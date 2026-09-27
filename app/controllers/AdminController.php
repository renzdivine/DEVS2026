<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../helpers.php";
require_once __DIR__ . "/../GoogleAuth.php";
require_once __DIR__ . "/../models/TeamMembers.php";
require_once __DIR__ . "/../models/Services.php";
require_once __DIR__ . "/../models/Skills.php";
require_once __DIR__ . "/../models/Projects.php";
require_once __DIR__ . "/../models/Inquiries.php";
require_once __DIR__ . "/../models/ProjectRelations.php";

class AdminController {
    private $admin;
    private $team;
    private $services;
    private $skills;
    private $projects;
    private $inquiries;
    private $availability;
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
        $this->admin = new AdminUser($this->db);
        $this->team = new TeamMembers($this->db);
        $this->services = new Services($this->db);
        $this->skills = new Skills($this->db);
        $this->projects = new Projects($this->db);
        $this->inquiries = new Inquiries($this->db);
        $this->availability = new Availability($this->db);
    }

    private function isLoggedIn() {
        return isset($_SESSION['admin_id']);
    }

    private function redirectLogin() {
        header("Location: " . BASE_URL . "/admin");
        exit;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_verify()) {
                $error = "Security check failed. Please try again.";
                include __DIR__ . "/../views/admin/login.php";
                exit;
            }

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $user = $this->admin->getByUsername($username);

            if ($user && $this->admin->verifyPassword($password, $user['admin_password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $user['admin_id'];
                $_SESSION['admin_username'] = $user['admin_username'];
                header("Location: " . BASE_URL . "/admin");
                exit;
            }

            $error = "Invalid username or password.";
            include __DIR__ . "/../views/admin/login.php";
            exit;
        }
        include __DIR__ . "/../views/admin/login.php";
    }

    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "/admin");
        exit;
    }

    /**
     * Step 1 - Redirect the browser to Google's OAuth consent screen.
     */
    public function googleLogin() {
        $google = new GoogleAuth();
        $url = $google->getAuthUrl();
        header("Location: " . $url);
        exit;
    }

    /**
     * Step 2 - Google redirects back here with ?code=&state=
     * Exchange the code, verify the email, and create the admin session.
     */
    public function googleCallback() {
        $code  = $_GET['code']  ?? '';
        $state = $_GET['state'] ?? '';

        // Google sends ?error= when the user cancels
        if (isset($_GET['error'])) {
            $error = 'Google sign-in was cancelled or denied.';
            include __DIR__ . "/../views/admin/login.php";
            exit;
        }

        if ($code === '' || $state === '') {
            $error = 'Invalid callback from Google. Please try again.';
            include __DIR__ . "/../views/admin/login.php";
            exit;
        }

        $google = new GoogleAuth();
        $result = $google->handleCallback($code, $state);

        if (!$result['ok']) {
            $error = $result['error'];
            include __DIR__ . "/../views/admin/login.php";
            exit;
        }

        // Successful - create the admin session
        session_regenerate_id(true);
        $_SESSION['admin_id']       = 'google:' . $result['email'];
        $_SESSION['admin_username'] = $result['name'];
        $_SESSION['admin_google']   = true;  // flag so we know it's a Google session

        header("Location: " . BASE_URL . "/admin");
        exit;
    }

    public function dashboard() {
        if (!$this->isLoggedIn()) { $this->redirectLogin(); }

        $allProjects     = $this->projects->getAll();
        $allInquiries    = $this->inquiries->getAll();
        $allTeam         = $this->team->getAll();
        $allServices     = $this->services->getAll();
        $allSkills       = $this->skills->getAll();

        $totalProjects  = count($allProjects);
        $totalTeam      = count($allTeam);
        $totalServices  = count($allServices);
        $totalSkills    = count($allSkills);
        $stats          = $this->inquiries->getStats();
        $recentProjects  = $allProjects;
        $recentInquiries = $allInquiries;
        $avail           = $this->availability->get();

        /* ---- Chart data ---- */

        /* 1. Inquiry status breakdown (donut) */
        $inqStatusCounts = [];
        foreach ($allInquiries as $inq) {
            $s = $inq['inquiry_status'] ?? 'Unknown';
            $inqStatusCounts[$s] = ($inqStatusCounts[$s] ?? 0) + 1;
        }

        /* 2. Inquiries by project type (bar) */
        $inqByType = [];
        foreach ($allInquiries as $inq) {
            $t = $inq['inquiry_project_type'] ?? 'Other';
            $inqByType[$t] = ($inqByType[$t] ?? 0) + 1;
        }
        arsort($inqByType);

        /* 3. Projects by category (horizontal bar) */
        $projByCategory = [];
        foreach ($allProjects as $p) {
            $c = $p['project_category'] ?? 'Uncategorized';
            $projByCategory[$c] = ($projByCategory[$c] ?? 0) + 1;
        }
        arsort($projByCategory);

        /* 4. Inquiries over last 6 months (line) */
        $inqByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $label = date('M Y', strtotime("-$i months"));
            $inqByMonth[$label] = 0;
        }
        foreach ($allInquiries as $inq) {
            $m = date('M Y', strtotime($inq['inquiry_created_at']));
            if (isset($inqByMonth[$m])) $inqByMonth[$m]++;
        }

        /* 5. Content overview (polar area) */
        $contentOverview = [
            'Projects'     => $totalProjects,
            'Team'         => $totalTeam,
            'Services'     => $totalServices,
            'Technologies' => $totalSkills,
        ];

        $pageTitle = 'Dashboard';
        include __DIR__ . "/../views/admin/header.php";
        include __DIR__ . "/../views/admin/dashboard.php";
        include __DIR__ . "/../views/admin/footer.php";
    }

    public function manageTeam() {
        if (!$this->isLoggedIn()) { $this->redirectLogin(); }
        $members = $this->team->getAll();
        $allSkills = $this->skills->getAll();

        $action = $_GET['action'] ?? '';
        $addOpen = ($action === 'adminAddTeam');
        $editId = ($action === 'adminEditTeam') ? (int)($_GET['id'] ?? 0) : 0;
        $editing = null;
        $editSkillIds = [];
        if ($editId) {
            $editing = $this->team->getById($editId);
            if ($editing) {
                $editSkillIds = array_map(fn($s) => (int)$s['skill_id'], $this->team->getSkills($editId));
            } else {
                $editId = 0;
                $action = '';
            }
        }

        $pageTitle = 'Team';
        include __DIR__ . "/../views/admin/header.php";
        include __DIR__ . "/../views/admin/team.php";
        include __DIR__ . "/../views/admin/footer.php";
    }

    public function manageServices() {
        if (!$this->isLoggedIn()) { $this->redirectLogin(); }
        $services = $this->services->getAll();

        $action = $_GET['action'] ?? '';
        $addOpen = ($action === 'adminAddService');
        $editId = ($action === 'adminEditService') ? (int)($_GET['id'] ?? 0) : 0;
        $editing = null;
        if ($editId) {
            $editing = $this->services->getById($editId);
            if (!$editing) { $editId = 0; }
        }

        $pageTitle = 'Services';
        include __DIR__ . "/../views/admin/header.php";
        include __DIR__ . "/../views/admin/services.php";
        include __DIR__ . "/../views/admin/footer.php";
    }

    public function manageTechnologies() {
        if (!$this->isLoggedIn()) { $this->redirectLogin(); }
        $skills = $this->skills->getAll();
        $categories = ['Backend', 'Frontend', 'Database', 'Database / Backend Services'];

        $action = $_GET['action'] ?? '';
        $addOpen = ($action === 'adminAddTech');
        $editId = ($action === 'adminEditTech') ? (int)($_GET['id'] ?? 0) : 0;
        $editing = null;
        if ($editId) {
            $editing = $this->skills->getById($editId);
            if (!$editing) { $editId = 0; }
        }

        $pageTitle = 'Technologies';
        include __DIR__ . "/../views/admin/header.php";
        include __DIR__ . "/../views/admin/technologies.php";
        include __DIR__ . "/../views/admin/footer.php";
    }

    public function manageProjects() {
        if (!$this->isLoggedIn()) { $this->redirectLogin(); }
        $projects = $this->projects->getAll();
        $skills = $this->skills->getAll();
        $teamMembers = $this->team->getAll();

        $action = $_GET['action'] ?? '';
        $addOpen = ($action === 'adminAddProject');
        $editId = ($action === 'adminEditProject') ? (int)($_GET['id'] ?? 0) : 0;
        $editing = null;
        $editSkillIds = [];
        $editMemberIds = [];
        $editScreenshots = [];
        if ($editId) {
            $editing = $this->projects->getById($editId);
            if ($editing) {
                $editSkillIds = array_map(fn($s) => (int)$s['skill_id'], $this->projects->getSkills($editId));
                $editMemberIds = array_map(fn($m) => (int)$m['member_id'], $this->projects->getMembers($editId));
                $editScreenshots = $this->projects->getImages($editId);
            } else {
                $editId = 0;
            }
        }

        $pageTitle = 'Projects';
        include __DIR__ . "/../views/admin/header.php";
        include __DIR__ . "/../views/admin/projects.php";
        include __DIR__ . "/../views/admin/footer.php";
    }

    public function manageInquiries() {
        if (!$this->isLoggedIn()) { $this->redirectLogin(); }

        $replies = new InquiryReplies($this->db);

        // Grouped contacts list (one row per unique email)
        $contacts = $this->inquiries->getGroupedByEmail();

        // Active conversation - driven by ?email=
        $activeEmail    = trim($_GET['email'] ?? '');
        $activeContact  = null;
        $activeInquiries = [];
        $activeThread   = [];
        $activeInquiry  = null; // latest inquiry for the reply form

        if ($activeEmail !== '') {
            // Find the contact row for sidebar highlighting
            foreach ($contacts as $c) {
                if ($c['inquiry_email'] === $activeEmail) {
                    $activeContact = $c;
                    break;
                }
            }
            // All inquiries from this email (for project details)
            $activeInquiries = $this->inquiries->getByEmail($activeEmail);
            // Latest inquiry row - used for the reply form inquiry_id
            $activeInquiry   = $this->inquiries->getLatestByEmail($activeEmail);
            // Full reply thread (client + admin messages)
            $activeThread    = $replies->getByEmail($activeEmail);

            // Mark all New inquiries from this contact as Contacted (clear unread badge)
            $stmt = $this->db->prepare(
                "UPDATE project_inquiries SET inquiry_status = 'Contacted'
                 WHERE inquiry_email = ? AND inquiry_status = 'New'"
            );
            $stmt->bind_param('s', $activeEmail);
            $stmt->execute();

            // Refresh contacts list so badge is gone immediately
            $contacts = $this->inquiries->getGroupedByEmail();

            // Re-find active contact in refreshed list
            foreach ($contacts as $c) {
                if ($c['inquiry_email'] === $activeEmail) {
                    $activeContact = $c;
                    break;
                }
            }
        }

        $statusOptions = ['New', 'Contacted', 'In Discussion', 'Accepted', 'Completed', 'Archived'];

        $pageTitle = 'Inquiries';
        include __DIR__ . "/../views/admin/header.php";
        include __DIR__ . "/../views/admin/inquiries.php";
        include __DIR__ . "/../views/admin/footer.php";
    }

    public function availability() {
        if (!$this->isLoggedIn()) { $this->redirectLogin(); }
        $avail = $this->availability->get();
        $pageTitle = 'Availability';
        include __DIR__ . "/../views/admin/header.php";
        include __DIR__ . "/../views/admin/availability.php";
        include __DIR__ . "/../views/admin/footer.php";
    }

    public function settings() {
        if (!$this->isLoggedIn()) { $this->redirectLogin(); }
        $settings = [];
        $stmt = $this->db->query("SELECT setting_key, setting_value FROM settings");
        if ($stmt) {
            while ($row = $stmt->fetch_assoc()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
        $pageTitle = 'Settings';
        include __DIR__ . "/../views/admin/header.php";
        include __DIR__ . "/../views/admin/settings.php";
        include __DIR__ . "/../views/admin/footer.php";
    }
}
