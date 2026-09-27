<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../helpers.php";
require_once __DIR__ . "/../models/TeamMembers.php";
require_once __DIR__ . "/../models/Skills.php";
require_once __DIR__ . "/../models/Services.php";
require_once __DIR__ . "/../models/Projects.php";
require_once __DIR__ . "/../models/Inquiries.php";
require_once __DIR__ . "/../models/ProjectRelations.php";

class HomeController {
    private $team;
    private $skills;
    private $services;
    private $projects;
    private $availability;

    public function __construct() {
        $db = (new Database())->connect();
        $this->team = new TeamMembers($db);
        $this->skills = new Skills($db);
        $this->services = new Services($db);
        $this->projects = new Projects($db);
        $this->availability = new Availability($db);
    }

    public function home() {
        $team = $this->team->getAll(1);
        $services = $this->services->getAll();
        $featuredProjects = array_slice($this->projects->getAll(1), 0, 4);
        $skills = $this->skills->getAll();
        $avail = $this->availability->get();
        $pageTitle = 'DEVS - Web & Mobile Development Team';
        $pageDescription = 'DEVS is a team of web and mobile developers building custom websites, applications, and systems for businesses, organizations, and individuals.';
        $pagePath = '/';
        include __DIR__ . "/../views/home.php";
    }

    public function about() {
        $team = $this->team->getAll(1);
        $skills = $this->skills->getAll();
        $pageTitle = 'About - DEVS';
        $pageDescription = 'DEVS is a growing team of young developers focused on practical, modern, and reliable digital solutions.';
        $pagePath = '/about';
        include __DIR__ . "/../views/about.php";
    }

    public function services() {
        $services = $this->services->getAll();
        $skills = $this->skills->getAll();
        $pageTitle = 'Services - DEVS';
        $pageDescription = 'Web development, mobile development, custom systems, databases, and APIs built around your requirements.';
        $pagePath = '/services';
        include __DIR__ . "/../views/services.php";
    }

    public function projects() {
        $projects = $this->projects->getAll(1);
        $skills = $this->skills->getAll();
        $pageTitle = 'Projects - DEVS';
        $pageDescription = 'A selection of web, mobile, and custom system projects built by DEVS.';
        $pagePath = '/projects';
        include __DIR__ . "/../views/projects.php";
    }

    public function contact() {
        $success = '';
        if (!empty($_SESSION['form_success'])) {
            $success = $_SESSION['form_success'];
            unset($_SESSION['form_success']);
        }
        $error = $_SESSION['form_error'] ?? '';
        unset($_SESSION['form_error']);
        $avail = $this->availability->get();
        $pageTitle = 'Contact - DEVS';
        $pageDescription = 'Have a project idea or system you need built? Tell DEVS what you are looking for.';
        $pagePath = '/contact';
        include __DIR__ . "/../views/contact.php";
    }
}

class TeamController {
    private $team;
    private $skills;
    private $projects;

    public function __construct() {
        $db = (new Database())->connect();
        $this->team = new TeamMembers($db);
        $this->skills = new Skills($db);
        $this->projects = new Projects($db);
    }

    public function index() {
        $members = $this->team->getAll(1);
        $pageTitle = 'Team - DEVS';
        $pageDescription = 'Meet the DEVS team of web and mobile developers.';
        $pagePath = '/team';
        include __DIR__ . "/../views/team.php";
    }

    public function member($slug) {
        $member = $this->team->getBySlug($slug);
        if (!$member) {
            http_response_code(404);
            include __DIR__ . "/../views/404.php";
            exit;
        }
        $skills = $this->team->getSkills($member['member_id']);
        if (empty($skills) && !empty($member['member_skills'])) {
            $skills = [];
            foreach (explode(',', $member['member_skills']) as $name) {
                $skills[] = ['skill_name' => trim($name), 'skill_category' => ''];
            }
        }
        $memberProjects = $this->projects->getByMemberId($member['member_id']);
        $pageTitle = $member['member_name'] . ' - DEVS';
        $pageDescription = $member['member_role'] . ' at DEVS. ' . $member['member_short_bio'];
        $pagePath = '/team/' . $member['member_slug'];
        include __DIR__ . "/../views/team-member.php";
    }
}

class ProjectController {
    private $projects;
    private $skills;
    private $team;

    public function __construct() {
        $db = (new Database())->connect();
        $this->projects = new Projects($db);
        $this->skills = new Skills($db);
        $this->team = new TeamMembers($db);
    }

    public function index() {
        $projects = $this->projects->getAll(1);
        $skills = $this->skills->getAll();
        $pageTitle = 'Projects - DEVS';
        $pageDescription = 'A selection of web, mobile, and custom system projects built by DEVS.';
        $pagePath = '/projects';
        include __DIR__ . "/../views/projects.php";
    }

    public function detail($slug) {
        $project = $this->projects->getBySlug($slug);
        if (!$project || !$project['project_status']) {
            http_response_code(404);
            include __DIR__ . "/../views/404.php";
            exit;
        }
        $skills = $this->projects->getSkills($project['project_id']);
        $members = $this->projects->getMembers($project['project_id']);
        $images = $this->projects->getImages($project['project_id']);
        $pageTitle = $project['project_name'] . ' - DEVS';
        $pageDescription = $project['project_description'];
        $pagePath = '/projects/' . $project['project_slug'];
        include __DIR__ . "/../views/project-detail.php";
    }
}

class ServiceController {
    private $services;

    public function __construct() {
        $db = (new Database())->connect();
        $this->services = new Services($db);
    }

    public function index() {
        $services = $this->services->getAll();
        $pageTitle = 'Services - DEVS';
        $pageDescription = 'Web development, mobile development, custom systems, databases, and APIs.';
        $pagePath = '/services';
        include __DIR__ . "/../views/services.php";
    }
}
