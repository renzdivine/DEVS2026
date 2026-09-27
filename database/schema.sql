-- DEVS website schema
-- Import: mysql -u root < database/schema.sql  (or via phpMyAdmin)
-- Default admin login: admin / devs-admin-2026  (change after first login)

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS db_devs CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_devs;

DROP TABLE IF EXISTS project_inquiries;
DROP TABLE IF EXISTS project_images;
DROP TABLE IF EXISTS project_members;
DROP TABLE IF EXISTS project_skills;
DROP TABLE IF EXISTS team_member_skills;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS team_members;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS skills;
DROP TABLE IF EXISTS availability;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
  admin_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  admin_username VARCHAR(60) NOT NULL,
  admin_password VARCHAR(255) NOT NULL,
  PRIMARY KEY (admin_id),
  UNIQUE KEY uq_admin_username (admin_username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE team_members (
  member_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  member_name VARCHAR(120) NOT NULL,
  member_slug VARCHAR(140) NOT NULL,
  member_role VARCHAR(120) NOT NULL DEFAULT '',
  member_photo VARCHAR(255) NOT NULL DEFAULT '',
  member_short_bio VARCHAR(500) NOT NULL DEFAULT '',
  member_full_bio TEXT,
  member_github VARCHAR(255) NOT NULL DEFAULT '',
  member_linkedin VARCHAR(255) NOT NULL DEFAULT '',
  member_facebook VARCHAR(255) NOT NULL DEFAULT '',
  member_instagram VARCHAR(255) NOT NULL DEFAULT '',
  member_email VARCHAR(190) NOT NULL DEFAULT '',
  member_skills VARCHAR(500) NOT NULL DEFAULT '',
  member_status TINYINT(1) NOT NULL DEFAULT 1,
  display_order INT NOT NULL DEFAULT 0,
  PRIMARY KEY (member_id),
  UNIQUE KEY uq_member_slug (member_slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE skills (
  skill_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  skill_name VARCHAR(100) NOT NULL,
  skill_category VARCHAR(100) NOT NULL DEFAULT 'Frontend',
  skill_description VARCHAR(255) NOT NULL DEFAULT '',
  skill_icon VARCHAR(60) NOT NULL DEFAULT '',
  PRIMARY KEY (skill_id),
  KEY idx_skill_category (skill_category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE team_member_skills (
  member_id INT UNSIGNED NOT NULL,
  skill_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (member_id, skill_id),
  CONSTRAINT fk_tms_member FOREIGN KEY (member_id) REFERENCES team_members (member_id) ON DELETE CASCADE,
  CONSTRAINT fk_tms_skill FOREIGN KEY (skill_id) REFERENCES skills (skill_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE services (
  service_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  service_name VARCHAR(120) NOT NULL,
  service_description VARCHAR(1000) NOT NULL DEFAULT '',
  service_icon VARCHAR(60) NOT NULL DEFAULT '',
  service_technologies VARCHAR(500) NOT NULL DEFAULT '',
  service_status TINYINT(1) NOT NULL DEFAULT 1,
  display_order INT NOT NULL DEFAULT 0,
  PRIMARY KEY (service_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE projects (
  project_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  project_name VARCHAR(160) NOT NULL,
  project_slug VARCHAR(180) NOT NULL,
  project_description VARCHAR(1000) NOT NULL DEFAULT '',
  project_long_description TEXT,
  project_dev_story TEXT,
  project_category VARCHAR(40) NOT NULL DEFAULT 'Web',
  project_featured_image VARCHAR(255) NOT NULL DEFAULT '',
  project_gallery TEXT,
  project_features TEXT,
  project_github_url VARCHAR(255) NOT NULL DEFAULT '',
  project_live_url VARCHAR(255) NOT NULL DEFAULT '',
  project_status TINYINT(1) NOT NULL DEFAULT 1,
  project_created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (project_id),
  UNIQUE KEY uq_project_slug (project_slug),
  KEY idx_project_status (project_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE project_skills (
  project_id INT UNSIGNED NOT NULL,
  skill_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (project_id, skill_id),
  CONSTRAINT fk_ps_project FOREIGN KEY (project_id) REFERENCES projects (project_id) ON DELETE CASCADE,
  CONSTRAINT fk_ps_skill FOREIGN KEY (skill_id) REFERENCES skills (skill_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE project_members (
  project_id INT UNSIGNED NOT NULL,
  member_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (project_id, member_id),
  CONSTRAINT fk_pm_project FOREIGN KEY (project_id) REFERENCES projects (project_id) ON DELETE CASCADE,
  CONSTRAINT fk_pm_member FOREIGN KEY (member_id) REFERENCES team_members (member_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE project_images (
  image_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  project_id INT UNSIGNED NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  display_order INT NOT NULL DEFAULT 0,
  PRIMARY KEY (image_id),
  KEY idx_pi_project (project_id),
  CONSTRAINT fk_pi_project FOREIGN KEY (project_id) REFERENCES projects (project_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE project_inquiries (
  inquiry_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  inquiry_name VARCHAR(120) NOT NULL,
  inquiry_email VARCHAR(190) NOT NULL,
  inquiry_phone VARCHAR(60) NOT NULL DEFAULT '',
  inquiry_company VARCHAR(160) NOT NULL DEFAULT '',
  inquiry_project_type VARCHAR(60) NOT NULL DEFAULT '',
  inquiry_budget_range VARCHAR(60) NOT NULL DEFAULT '',
  inquiry_description TEXT,
  inquiry_preferred_contact VARCHAR(40) NOT NULL DEFAULT '',
  inquiry_status VARCHAR(30) NOT NULL DEFAULT 'New',
  inquiry_created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (inquiry_id),
  KEY idx_inquiry_status (inquiry_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE availability (
  availability_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  availability_status VARCHAR(40) NOT NULL DEFAULT 'Available',
  PRIMARY KEY (availability_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE settings (
  setting_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  setting_key VARCHAR(80) NOT NULL,
  setting_value VARCHAR(500) NOT NULL DEFAULT '',
  PRIMARY KEY (setting_id),
  UNIQUE KEY uq_setting_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------- Seed data ----------

INSERT INTO admins (admin_username, admin_password) VALUES
('admin', '$2y$10$vp3Y.bGY5uKriQUJp3GGKe2jf6A8eZPvaygPQ4/bPk4zvCQn2SlVW');

INSERT INTO availability (availability_status) VALUES ('Available');

INSERT INTO settings (setting_key, setting_value) VALUES
('github_url', ''),
('linkedin_url', ''),
('site_email', '');

INSERT INTO skills (skill_name, skill_category, skill_description, skill_icon) VALUES
('PHP', 'Backend', 'Server-side application logic', 'PHP'),
('MySQL', 'Database', 'Relational data storage', 'MySQL'),
('React', 'Frontend', 'Interactive user interfaces', 'React'),
('Next.js', 'Frontend', 'Production React framework', 'Next'),
('HTML', 'Frontend', 'Semantic page structure', 'HTML'),
('CSS', 'Frontend', 'Layout and visual design', 'CSS'),
('JavaScript', 'Frontend', 'Browser and app logic', 'JS'),
('Supabase', 'Database / Backend Services', 'Auth, storage, and realtime backend', 'Supabase');

INSERT INTO services (service_name, service_description, service_icon, service_technologies, service_status, display_order) VALUES
('Web Development', 'Custom websites and web applications designed around specific client requirements.', '</>', 'HTML, CSS, JavaScript, React, Next.js, PHP', 1, 1),
('Mobile Development', 'Mobile applications designed for real-world use cases on Android and other supported platforms.', 'APP', 'React, JavaScript, PHP', 1, 2),
('Custom System Development', 'Database-driven systems for organizations, businesses, schools, and other users.', '{}', 'PHP, MySQL', 1, 3),
('Database Development', 'Structured and reliable database solutions for applications and systems.', 'DB', 'MySQL, Supabase', 1, 4),
('API Development', 'Backend services that let your applications and services communicate.', 'API', 'PHP, MySQL, Supabase', 1, 5);

INSERT INTO team_members (member_name, member_slug, member_role, member_photo, member_short_bio, member_full_bio, member_github, member_linkedin, member_facebook, member_instagram, member_email, member_skills, member_status, display_order) VALUES
('Renz Divinagracia', 'renz-divinagracia', 'Full-Stack Developer', '',
 'Builds the web applications and systems behind DEVS, from database design to the final interface.',
 'Renz focuses on turning requirements into working systems. He handles both the backend logic and the interfaces people actually use, with an emphasis on clean databases and maintainable code. At DEVS he leads most custom system and web application builds.',
 'https://github.com/', 'https://www.linkedin.com/', '', '', '',
 'PHP, MySQL, React', 1, 1),
('Miguel Santos', 'miguel-santos', 'Mobile Developer', '',
 'Designs and builds mobile applications for Android and cross-platform use.',
 'Miguel works on the mobile side of DEVS projects. He focuses on applications that people use daily: simple flows, reliable data handling, and interfaces that do not get in the way. He collaborates closely with the web team so mobile and web systems share one backend.',
 'https://github.com/', 'https://www.linkedin.com/', '', '', '',
 'JavaScript, React, PHP', 1, 2),
('Katrina Reyes', 'katrina-reyes', 'Frontend Developer', '',
 'Builds the interfaces clients and their users see, with an eye for detail and clarity.',
 'Katrina is responsible for the frontend of DEVS projects: layout, typography, responsive behavior, and the small interaction details that make an application feel finished. She works from design references and prototypes through to production CSS and component work.',
 'https://github.com/', 'https://www.linkedin.com/', '', '', '',
 'HTML, CSS, JavaScript, React, Next.js', 1, 3);

INSERT INTO team_member_skills (member_id, skill_id)
SELECT m.member_id, s.skill_id FROM team_members m JOIN skills s
WHERE (m.member_slug = 'renz-divinagracia' AND s.skill_name IN ('PHP','MySQL','React','JavaScript'))
   OR (m.member_slug = 'miguel-santos' AND s.skill_name IN ('JavaScript','React','PHP'))
   OR (m.member_slug = 'katrina-reyes' AND s.skill_name IN ('HTML','CSS','JavaScript','React','Next.js'));

INSERT INTO projects (project_name, project_slug, project_description, project_long_description, project_dev_story, project_category, project_featured_image, project_gallery, project_features, project_github_url, project_live_url, project_status) VALUES
('CampusFlow Student Portal', 'campus-flow-student-portal',
 'A web portal where students check grades, enrollment status, and announcements in one place.',
 'Schools were distributing grades, forms, and announcements through separate channels, so students and staff duplicated work. CampusFlow brings those tasks into one portal: students sign in and see their records, faculty manage grades, and administrators publish announcements to the right year levels.',
 'We started by mapping how the registrar actually processes enrollment each term, then modeled the database around that flow instead of around the printed forms. The first version was tested with a small group of students before grades were opened up. Most of the work went into permission rules: who can see and edit which records.',
 'Web', '', '',
 'Student login with role-based access\nGrade and enrollment viewing\nAnnouncement publishing by year level\nAdmin dashboard for records\nPrintable forms', '', '', 1),
('Barangay Records App', 'barangay-records-app',
 'A mobile app for barangay officials to manage resident records and issue clearances.',
 'Resident information lived in paper logs, which made issuing clearances slow and hard to audit. This app gives officials a searchable resident database and a clearance request flow that records who requested what and when.',
 'We designed the data model with the barangay secretary during two working sessions, then built the mobile screens around the clearance process she already used. Offline capture was added last, because connectivity in the hall is unreliable during peak hours.',
 'Mobile', '', '',
 'Resident search and profiles\nClearance request and approval log\nOffline record capture\nOfficial issue history', '', '', 1),
('Inventory Control System', 'inventory-control-system',
 'A stock management system for a growing retail business, with low-stock alerts and reporting.',
 'The business was tracking stock in spreadsheets, and reorder decisions were made from memory. The system tracks every stock movement, flags items below their reorder point, and produces weekly reports the owner actually reads.',
 'We followed one week of their receiving and selling process before writing queries. The alert thresholds turned out to matter more than any dashboard: once low-stock items surfaced on the home screen, missed reorders stopped happening.',
 'System', '', '',
 'Stock in/out with audit trail\nLow-stock alerts by threshold\nWeekly movement reports\nUser accounts by role\nSupplier directory', '', '', 1);

INSERT INTO project_skills (project_id, skill_id)
SELECT p.project_id, s.skill_id FROM projects p JOIN skills s
WHERE (p.project_slug = 'campus-flow-student-portal' AND s.skill_name IN ('PHP','MySQL','React','JavaScript'))
   OR (p.project_slug = 'barangay-records-app' AND s.skill_name IN ('JavaScript','React','PHP','MySQL'))
   OR (p.project_slug = 'inventory-control-system' AND s.skill_name IN ('PHP','MySQL','HTML','CSS','JavaScript'));

INSERT INTO project_members (project_id, member_id)
SELECT p.project_id, m.member_id FROM projects p, team_members m
WHERE p.project_slug = 'campus-flow-student-portal' AND m.member_slug IN ('renz-divinagracia','katrina-reyes');

INSERT INTO project_members (project_id, member_id)
SELECT p.project_id, m.member_id FROM projects p, team_members m
WHERE p.project_slug = 'barangay-records-app' AND m.member_slug IN ('miguel-santos','renz-divinagracia');

INSERT INTO project_members (project_id, member_id)
SELECT p.project_id, m.member_id FROM projects p, team_members m
WHERE p.project_slug = 'inventory-control-system' AND m.member_slug IN ('renz-divinagracia','katrina-reyes');

SET FOREIGN_KEY_CHECKS = 1;
