<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../helpers.php";
require_once __DIR__ . "/../lib/mailer.php";
require_once __DIR__ . "/../models/Projects.php";
require_once __DIR__ . "/../models/ProjectRelations.php";
require_once __DIR__ . "/../models/TeamMembers.php";
require_once __DIR__ . "/../models/Skills.php";
require_once __DIR__ . "/../models/Services.php";
require_once __DIR__ . "/../models/Inquiries.php";

class ProjectApiController {
    private $projects;
    private $projectSkills;
    private $projectMembers;
    private $team;
    private $skills;
    private $projectImages;

    public function __construct() {
        $db = (new Database())->connect();
        $this->projects = new Projects($db);
        $this->projectSkills = new ProjectSkills($db);
        $this->projectMembers = new ProjectMembers($db);
        $this->team = new TeamMembers($db);
        $this->skills = new Skills($db);
        $this->projectImages = new ProjectImages($db);
    }

    public function add() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $data = $this->collect();
        if (empty($data['name']) || empty($data['slug'])) {
            $_SESSION['error'] = "Project name and slug are required.";
            header("Location: " . BASE_URL . "/admin?sub=projects&action=adminAddProject");
            exit;
        }

        $upload = upload_image($_FILES['featured_image'] ?? null, 'proj');
        if (!empty($upload['error'])) {
            $_SESSION['error'] = $upload['error'];
            header("Location: " . BASE_URL . "/admin?sub=projects&action=adminAddProject");
            exit;
        }
        if ($upload['ok']) {
            $data['featured_image'] = $upload['path'];
        }

        $projectId = $this->projects->create($data);
        if ($projectId) {
            $this->handleProjectRelations($projectId);
            $this->handleScreenshots($projectId);
            $_SESSION['success'] = "Project added.";
        } else {
            $_SESSION['error'] = "Could not add the project.";
        }
        header("Location: " . BASE_URL . "/admin?sub=projects");
        exit;
    }

    public function edit() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $id = (int)($_POST['project_id'] ?? 0);
        $existing = $this->projects->getById($id);
        if (!$existing) {
            $_SESSION['error'] = "Project not found.";
            header("Location: " . BASE_URL . "/admin?sub=projects");
            exit;
        }

        $data = $this->collect();
        $data['featured_image'] = $existing['project_featured_image'];
        $data['gallery'] = $existing['project_gallery'];

        // Handle featured image removal
        if (!empty($_POST['remove_featured_image'])) {
            delete_upload($existing['project_featured_image']);
            $data['featured_image'] = '';
        }

        $upload = upload_image($_FILES['featured_image'] ?? null, 'proj');
        if (!empty($upload['error'])) {
            $_SESSION['error'] = $upload['error'];
            header("Location: " . BASE_URL . "/admin?sub=projects&action=adminEditProject&id=" . $id);
            exit;
        }
        if ($upload['ok']) {
            delete_upload($existing['project_featured_image']);
            $data['featured_image'] = $upload['path'];
        }

        // Handle individual screenshot deletions
        $deleteShots = array_map('intval', (array)($_POST['delete_screenshots'] ?? []));
        foreach ($deleteShots as $shotId) {
            if ($shotId > 0) {
                $shot = $this->projectImages->getById($shotId);
                if ($shot) {
                    delete_upload($shot['image_path']);
                    $this->projectImages->delete($shotId);
                }
            }
        }

        $this->projects->update($id, $data);
        $this->projectSkills->removeByProjectId($id);
        $this->projectMembers->removeByProjectId($id);
        $this->handleProjectRelations($id);
        $this->handleScreenshots($id);
        $_SESSION['success'] = "Project updated.";
        header("Location: " . BASE_URL . "/admin?sub=projects");
        exit;
    }

    public function delete() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        $id = (int)($_POST['id'] ?? 0);
        foreach ($this->projects->getImages($id) as $img) {
            delete_upload($img['image_path']);
        }
        $project = $this->projects->getById($id);
        $this->projectImages->deleteByProjectId($id);
        $this->projectSkills->removeByProjectId($id);
        $this->projectMembers->removeByProjectId($id);
        $this->projects->delete($id);
        if ($project) {
            delete_upload($project['project_featured_image']);
        }
        $_SESSION['success'] = "Project deleted.";
        header("Location: " . BASE_URL . "/admin?sub=projects");
        exit;
    }

    private function collect() {
        $name = trim($_POST['project_name'] ?? '');
        $slug = trim($_POST['project_slug'] ?? '');
        if ($slug === '') {
            $slug = slugify($name);
        } else {
            $slug = slugify($slug);
        }
        $status = (int)($_POST['project_status'] ?? 1);
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => trim($_POST['project_description'] ?? ''),
            'long_description' => trim($_POST['project_long_description'] ?? ''),
            'dev_story' => trim($_POST['project_dev_story'] ?? ''),
            'category' => trim($_POST['project_category'] ?? 'Web'),
            'featured_image' => '',
            'gallery' => '',
            'features' => trim($_POST['project_features'] ?? ''),
            'github_url' => trim($_POST['project_github_url'] ?? ''),
            'live_url' => trim($_POST['project_live_url'] ?? ''),
            'status' => $status ? 1 : 0,
        ];
    }

    private function handleProjectRelations($projectId) {
        $skills = $_POST['project_skills'] ?? [];
        foreach ((array)$skills as $skillId) {
            $skillId = (int)$skillId;
            if ($skillId > 0) {
                $this->projectSkills->assign($projectId, $skillId);
            }
        }

        $members = $_POST['project_members'] ?? [];
        foreach ((array)$members as $memberId) {
            $memberId = (int)$memberId;
            if ($memberId > 0) {
                $this->projectMembers->assign($projectId, $memberId);
            }
        }
    }

    private function handleScreenshots($projectId) {
        $files = $_FILES['screenshots'] ?? null;
        if (!$files || !is_array($files['name'] ?? null)) {
            return;
        }
        $count = count($files['name']);
        $existingCount = count($this->projectImages->getByProjectId($projectId));
        for ($i = 0; $i < $count; $i++) {
            if (($files['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                continue;
            }
            $single = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i] ?? '',
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i] ?? 0,
            ];
            $upload = upload_image($single, 'shot');
            if ($upload['ok']) {
                $this->projectImages->add($projectId, $upload['path'], $existingCount++);
            }
        }
    }

    private function isAdmin() {
        return isset($_SESSION['admin_id']);
    }
}

class TeamApiController {
    private $team;
    private $skills;

    public function __construct() {
        $db = (new Database())->connect();
        $this->team = new TeamMembers($db);
        $this->skills = new Skills($db);
    }

    public function add() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $data = $this->collect();
        if (empty($data['name']) || empty($data['slug'])) {
            $_SESSION['error'] = "Name and slug are required.";
            header("Location: " . BASE_URL . "/admin?sub=team&action=adminAddTeam");
            exit;
        }

        $upload = upload_image($_FILES['member_photo'] ?? null, 'mem');
        if (!empty($upload['error'])) {
            $_SESSION['error'] = $upload['error'];
            header("Location: " . BASE_URL . "/admin?sub=team&action=adminAddTeam");
            exit;
        }
        if ($upload['ok']) {
            $data['photo'] = $upload['path'];
        }

        $memberId = $this->team->create($data);
        $this->syncSkills($memberId);
        $_SESSION['success'] = "Team member added.";
        header("Location: " . BASE_URL . "/admin?sub=team");
        exit;
    }

    public function edit() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $id = (int)($_POST['member_id'] ?? 0);
        $existing = $this->team->getById($id);
        if (!$existing) {
            $_SESSION['error'] = "Team member not found.";
            header("Location: " . BASE_URL . "/admin?sub=team");
            exit;
        }

        $data = $this->collect();
        $data['photo'] = $existing['member_photo'];

        $upload = upload_image($_FILES['member_photo'] ?? null, 'mem');
        if (!empty($upload['error'])) {
            $_SESSION['error'] = $upload['error'];
            header("Location: " . BASE_URL . "/admin?sub=team&action=adminEditTeam&id=" . $id);
            exit;
        }
        if ($upload['ok']) {
            delete_upload($existing['member_photo']);
            $data['photo'] = $upload['path'];
        }

        $this->team->update($id, $data);
        $this->syncSkills($id);
        $_SESSION['success'] = "Team member updated.";
        header("Location: " . BASE_URL . "/admin?sub=team");
        exit;
    }

    public function delete() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        $id = (int)($_POST['id'] ?? 0);
        $existing = $this->team->getById($id);
        $this->team->delete($id);
        if ($existing) {
            delete_upload($existing['member_photo']);
        }
        $_SESSION['success'] = "Team member deleted.";
        header("Location: " . BASE_URL . "/admin?sub=team");
        exit;
    }

    private function collect() {
        $name = trim($_POST['member_name'] ?? '');
        $slug = trim($_POST['member_slug'] ?? '');
        if ($slug === '') {
            $slug = slugify($name);
        } else {
            $slug = slugify($slug);
        }
        $status = (int)($_POST['member_status'] ?? 1);
        $skillIds = array_map('intval', (array)($_POST['member_skills'] ?? []));
        $names = [];
        foreach ($this->skills->getAll() as $skill) {
            if (in_array((int)$skill['skill_id'], $skillIds, true)) {
                $names[] = $skill['skill_name'];
            }
        }
        return [
            'name' => $name,
            'slug' => $slug,
            'role' => trim($_POST['member_role'] ?? ''),
            'photo' => '',
            'short_bio' => trim($_POST['member_short_bio'] ?? ''),
            'full_bio' => trim($_POST['member_full_bio'] ?? ''),
            'github' => trim($_POST['member_github'] ?? ''),
            'linkedin' => trim($_POST['member_linkedin'] ?? ''),
            'facebook' => trim($_POST['member_facebook'] ?? ''),
            'instagram' => trim($_POST['member_instagram'] ?? ''),
            'email' => trim($_POST['member_email'] ?? ''),
            'skills' => implode(', ', $names),
            'status' => $status ? 1 : 0,
            'display_order' => (int)($_POST['display_order'] ?? 0),
        ];
    }

    private function syncSkills($memberId) {
        $conn = $this->team->getConn();
        $stmt = $conn->prepare("DELETE FROM team_member_skills WHERE member_id = ?");
        $stmt->bind_param("i", $memberId);
        $stmt->execute();

        $skillIds = array_filter(array_map('intval', (array)($_POST['member_skills'] ?? [])));
        $insert = $conn->prepare("INSERT INTO team_member_skills (member_id, skill_id) VALUES (?, ?)");
        foreach ($skillIds as $skillId) {
            $insert->bind_param("ii", $memberId, $skillId);
            $insert->execute();
        }
    }

    private function isAdmin() {
        return isset($_SESSION['admin_id']);
    }
}

class ServiceApiController {
    private $services;

    public function __construct() {
        $db = (new Database())->connect();
        $this->services = new Services($db);
    }

    public function add() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $data = $this->collect();
        if (empty($data['name'])) {
            $_SESSION['error'] = "Service name is required.";
            header("Location: " . BASE_URL . "/admin?sub=services&action=adminAddService");
            exit;
        }
        $this->services->create($data);
        $_SESSION['success'] = "Service added.";
        header("Location: " . BASE_URL . "/admin?sub=services");
        exit;
    }

    public function edit() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $id = (int)($_POST['service_id'] ?? 0);
        $data = $this->collect();
        $this->services->update($id, $data);
        $_SESSION['success'] = "Service updated.";
        header("Location: " . BASE_URL . "/admin?sub=services");
        exit;
    }

    public function delete() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        $id = (int)($_POST['id'] ?? 0);
        $this->services->delete($id);
        $_SESSION['success'] = "Service deleted.";
        header("Location: " . BASE_URL . "/admin?sub=services");
        exit;
    }

    private function collect() {
        return [
            'name' => trim($_POST['service_name'] ?? ''),
            'description' => trim($_POST['service_description'] ?? ''),
            'icon' => trim($_POST['service_icon'] ?? ''),
            'technologies' => trim($_POST['service_technologies'] ?? ''),
            'status' => (int)($_POST['service_status'] ?? 1) ? 1 : 0,
            'display_order' => (int)($_POST['display_order'] ?? 0),
        ];
    }

    private function isAdmin() {
        return isset($_SESSION['admin_id']);
    }
}

class TechnologyApiController {
    private $skills;

    public function __construct() {
        $db = (new Database())->connect();
        $this->skills = new Skills($db);
    }

    public function add() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $data = $this->collect();
        if (empty($data['name'])) {
            $_SESSION['error'] = "Technology name is required.";
            header("Location: " . BASE_URL . "/admin?sub=technologies&action=adminAddTech");
            exit;
        }
        $this->skills->create($data);
        $_SESSION['success'] = "Technology added.";
        header("Location: " . BASE_URL . "/admin?sub=technologies");
        exit;
    }

    public function edit() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $id = (int)($_POST['skill_id'] ?? 0);
        $data = $this->collect();
        $data['id'] = $id;
        $this->skills->update($id, $data);
        $_SESSION['success'] = "Technology updated.";
        header("Location: " . BASE_URL . "/admin?sub=technologies");
        exit;
    }

    public function delete() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        $id = (int)($_POST['id'] ?? 0);
        $this->skills->delete($id);
        $_SESSION['success'] = "Technology deleted.";
        header("Location: " . BASE_URL . "/admin?sub=technologies");
        exit;
    }

    private function collect() {
        return [
            'name' => trim($_POST['skill_name'] ?? ''),
            'category' => trim($_POST['skill_category'] ?? 'Frontend'),
            'description' => trim($_POST['skill_description'] ?? ''),
            'icon' => trim($_POST['skill_icon'] ?? ''),
        ];
    }

    private function isAdmin() {
        return isset($_SESSION['admin_id']);
    }
}

class InquiryApiController {
    private $inquiries;
    private $replies;

    public function __construct() {
        $db = (new Database())->connect();
        $this->inquiries = new Inquiries($db);
        $this->replies   = new InquiryReplies($db);
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }
        if (!csrf_verify()) {
            http_response_code(419);
            $_SESSION['form_error'] = 'Security check failed. Please submit the form again.';
            header("Location: " . BASE_URL . "/contact");
            exit;
        }

        $name = trim($_POST['inquiry_name'] ?? '');
        $email = trim($_POST['inquiry_email'] ?? '');
        $description = trim($_POST['inquiry_description'] ?? '');

        if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $description === '') {
            $_SESSION['form_error'] = 'Please fill in your name, a valid email, and a project description.';
            header("Location: " . BASE_URL . "/contact");
            exit;
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => trim($_POST['inquiry_phone'] ?? ''),
            'company' => trim($_POST['inquiry_company'] ?? ''),
            'project_type' => trim($_POST['inquiry_project_type'] ?? ''),
            'budget' => trim($_POST['inquiry_budget'] ?? '') === 'custom'
                        ? trim($_POST['inquiry_budget_custom'] ?? '')
                        : trim($_POST['inquiry_budget'] ?? ''),
            'description' => $description,
            'preferred_contact' => trim($_POST['inquiry_preferred_contact'] ?? ''),
            'status' => 'New',
        ];

        $inquiryId = $this->inquiries->create($data);

        // Store the client message in the replies table for thread display
        if ($inquiryId) {
            $this->replies->add((int)$inquiryId, 'client', 'New Inquiry', $description);
        }

        // Send email notification to admin
        $notifyEmail = setting('site_email');
        if ($notifyEmail && filter_var($notifyEmail, FILTER_VALIDATE_EMAIL)) {
            $subject  = "New Inquiry from {$name}";
            $body     = "You have a new inquiry from your DEVS website.\n\n";
            $body    .= "Name: {$name}\n";
            $body    .= "Email: {$email}\n";
            if (!empty($data['phone']))        $body .= "Phone: {$data['phone']}\n";
            if (!empty($data['company']))      $body .= "Company: {$data['company']}\n";
            if (!empty($data['project_type'])) $body .= "Project Type: {$data['project_type']}\n";
            if (!empty($data['budget']))       $body .= "Budget: {$data['budget']}\n";
            $body    .= "\nMessage:\n{$description}\n";
            $body    .= "\n---\nView conversation: " . BASE_URL . "/admin?sub=inquiries&email=" . urlencode($email) . "\n";
            send_mail($notifyEmail, 'DEVS Admin', $subject, $body, $email);
        }

        $_SESSION['form_success'] = 'Thank you. Your project inquiry has been received.';

        header("Location: " . BASE_URL . "/contact");
        exit;
    }

    public function updateStatus() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $id = (int)($_POST['inquiry_id'] ?? 0);
        $allowed = ['New', 'Contacted', 'In Discussion', 'Accepted', 'Completed', 'Archived'];
        $status = trim($_POST['inquiry_status'] ?? 'New');
        if (!in_array($status, $allowed, true)) {
            $status = 'New';
        }
        $this->inquiries->updateStatus($id, $status);
        $_SESSION['success'] = "Inquiry status updated.";
        $email = trim($_POST['view_email'] ?? '');
        if ($email !== '') {
            header("Location: " . BASE_URL . "/admin?sub=inquiries&email=" . urlencode($email));
        } else {
            header("Location: " . BASE_URL . "/admin?sub=inquiries");
        }
        exit;
    }

    private function isAdmin() {
        return isset($_SESSION['admin_id']);
    }
}

class AvailabilityApiController {
    private $availability;

    public function __construct() {
        $db = (new Database())->connect();
        $this->availability = new Availability($db);
    }

    public function update() {
        if (!$this->isAdmin()) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $id = (int)($_POST['avail_id'] ?? 0);
        $allowed = ['Available', 'Limited Availability', 'Currently Busy'];
        $status = trim($_POST['availability_status'] ?? 'Available');
        if (!in_array($status, $allowed, true)) {
            $status = 'Available';
        }
        if ($id > 0) {
            $this->availability->update($id, $status);
        }
        $_SESSION['success'] = "Availability updated.";
        $back = $_POST['back'] ?? 'availability';
        $sub = $back === 'dashboard' ? 'dashboard' : 'availability';
        header("Location: " . BASE_URL . "/admin?sub=" . $sub);
        exit;
    }

    private function isAdmin() {
        return isset($_SESSION['admin_id']);
    }
}

class ReplyInquiryApiController {
    private $db;
    private $replies;

    public function __construct() {
        $this->db = (new Database())->connect();
        $this->replies = new InquiryReplies($this->db);
    }

    public function send() {
        if (!isset($_SESSION['admin_id'])) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $inquiryId   = (int)($_POST['inquiry_id'] ?? 0);
        $clientEmail = trim($_POST['client_email'] ?? '');
        $clientName  = trim($_POST['client_name'] ?? '');
        $subject     = trim($_POST['reply_subject'] ?? '');
        $message     = trim($_POST['reply_message'] ?? '');
        $adminEmail  = setting('site_email') ?: '';

        if (!$inquiryId || !filter_var($clientEmail, FILTER_VALIDATE_EMAIL) || $subject === '' || $message === '') {
            $_SESSION['reply_error'] = 'Please fill in both subject and message.';
            header('Location: ' . BASE_URL . '/admin?sub=inquiries&email=' . urlencode($clientEmail));
            exit;
        }

        // --- Email to client ---
        $clientBody  = "Hi {$clientName},\n\n";
        $clientBody .= "{$message}\n\n";
        $clientBody .= "---\nDEVS - Web & Mobile Development Team\n";
        if ($adminEmail) $clientBody .= "Email: {$adminEmail}\n";

        $sentToClient = send_mail($clientEmail, $clientName, $subject, $clientBody, $adminEmail ?: '');

        // --- Notification copy to admin Gmail ---
        if ($adminEmail && filter_var($adminEmail, FILTER_VALIDATE_EMAIL) && $adminEmail !== $clientEmail) {
            $adminBody  = "You sent a reply to {$clientName} ({$clientEmail}).\n\n";
            $adminBody .= "Subject: {$subject}\n\n";
            $adminBody .= "Message:\n{$message}\n\n";
            $adminBody .= "---\nView conversation: " . BASE_URL . "/admin?sub=inquiries&email=" . urlencode($clientEmail) . "\n";
            send_mail($adminEmail, 'DEVS Admin', "[DEVS] Reply sent to {$clientName}", $adminBody);
        }

        if ($sentToClient === '') {
            // Store reply in DB
            $this->replies->add($inquiryId, 'admin', $subject, $message);

            // Auto-update status to Contacted if still New
            $stmt = $this->db->prepare(
                "UPDATE project_inquiries SET inquiry_status = 'Contacted'
                 WHERE inquiry_id = ? AND inquiry_status = 'New'"
            );
            $stmt->bind_param('i', $inquiryId);
            $stmt->execute();

            $_SESSION['reply_success'] = "Reply sent to {$clientEmail}.";
        } else {
            $_SESSION['reply_error'] = 'Could not send the email: ' . $sentToClient;
        }

        header('Location: ' . BASE_URL . '/admin?sub=inquiries&email=' . urlencode($clientEmail));
        exit;
    }
}

class SettingsApiController {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function save() {
        if (!isset($_SESSION['admin_id'])) { http_response_code(403); exit; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { return; }

        $keys = ['github_url', 'linkedin_url', 'site_email', 'site_phone', 'site_address'];
        $stmt = $this->db->prepare(
            "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)"
        );
        foreach ($keys as $key) {
            $value = trim($_POST[$key] ?? '');
            if ($key === 'site_email' && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Please enter a valid email address.";
                header("Location: " . BASE_URL . "/admin?sub=settings");
                exit;
            }
            $stmt->bind_param("ss", $key, $value);
            $stmt->execute();
        }
        $_SESSION['success'] = "Settings saved.";
        header("Location: " . BASE_URL . "/admin?sub=settings");
        exit;
    }
}
