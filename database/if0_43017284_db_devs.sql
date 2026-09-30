-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql205.infinityfree.com
-- Generation Time: Sep 30, 2026 at 01:48 AM
-- Server version: 11.4.13-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_43017284_db_devs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_username` varchar(60) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_username`, `admin_password`) VALUES
(1, 'admin', '$2y$10$vp3Y.bGY5uKriQUJp3GGKe2jf6A8eZPvaygPQ4/bPk4zvCQn2SlVW'),
(3, 'devs', '$2y$10$54MC9/9ASyeBqR4pM/X2XOsayu0Xfjn09/f300j8P5DzX/Af5ta2m');

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `availability_id` int(10) UNSIGNED NOT NULL,
  `availability_status` varchar(40) NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`availability_id`, `availability_status`) VALUES
(1, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_replies`
--

CREATE TABLE `inquiry_replies` (
  `reply_id` int(10) UNSIGNED NOT NULL,
  `inquiry_id` int(10) UNSIGNED NOT NULL,
  `direction` enum('client','admin') NOT NULL DEFAULT 'admin',
  `reply_subject` varchar(255) NOT NULL DEFAULT '',
  `reply_message` text NOT NULL,
  `replied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiry_replies`
--

INSERT INTO `inquiry_replies` (`reply_id`, `inquiry_id`, `direction`, `reply_subject`, `reply_message`, `replied_at`) VALUES
(9, 1, 'client', 'New Inquiry', 'MAMA', '2026-09-26 15:04:44'),
(10, 2, 'client', 'New Inquiry', 'Hello', '2026-09-27 03:57:40'),
(11, 3, 'client', 'New Inquiry', 'test one', '2026-09-27 04:12:38'),
(12, 4, 'client', 'New Inquiry', 'Hello there', '2026-09-27 04:26:30'),
(13, 5, 'client', 'New Inquiry', 'bakod hu', '2026-09-27 04:54:56'),
(16, 1, 'client', 'New Inquiry', 'hello dear', '2026-09-27 05:04:03'),
(17, 6, 'client', 'New Inquiry', 'hello dear', '2026-09-27 05:04:03'),
(18, 6, 'admin', 'Re: Your inquiry to DEVS', 'hello maam what are you looking for', '2026-09-27 05:06:31'),
(19, 1, 'admin', 'Re: Your inquiry to DEVS', 'Hello! Thank you for reaching out to us. We appreciate your interest in our services.\r\n\r\nWe’d be happy to assist you with your inquiry. Please provide us with the details of what you’re looking for, and we’ll get back to you as soon as possible.\r\n\r\nThank you, and we look forward to assisting you!', '2026-09-29 06:38:05'),
(20, 1, 'client', 'New Inquiry', 'hu', '2026-09-29 07:16:15'),
(21, 7, 'admin', 'Re: Your inquiry to DEVS', 'Hello! Thank you for reaching out to us. We appreciate your interest in our services.\r\n\r\nWe’d be happy to assist you with your inquiry. Please provide us with the details of what you’re looking for, and we’ll get back to you as soon as possible.\r\n\r\nThank you, and we look forward to assisting you!', '2026-09-29 07:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(10) UNSIGNED NOT NULL,
  `project_name` varchar(160) NOT NULL,
  `project_slug` varchar(180) NOT NULL,
  `project_description` varchar(1000) NOT NULL DEFAULT '',
  `project_long_description` text DEFAULT NULL,
  `project_dev_story` text DEFAULT NULL,
  `project_category` varchar(40) NOT NULL DEFAULT 'Web',
  `project_featured_image` varchar(255) NOT NULL DEFAULT '',
  `project_gallery` text DEFAULT NULL,
  `project_features` text DEFAULT NULL,
  `project_github_url` varchar(255) NOT NULL DEFAULT '',
  `project_live_url` varchar(255) NOT NULL DEFAULT '',
  `project_status` tinyint(1) NOT NULL DEFAULT 1,
  `project_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `project_slug`, `project_description`, `project_long_description`, `project_dev_story`, `project_category`, `project_featured_image`, `project_gallery`, `project_features`, `project_github_url`, `project_live_url`, `project_status`, `project_created_at`) VALUES
(4, 'GRACIA-Real Estate', 'gracia-real-estate', 'wait', 'hello', '', 'Web', '/uploads/proj_5ccd7bf94c94c673.png', '', '', 'https://github.com/renzdivine/Gracia-realEstate', 'https://gracia-real-estate.vercel.app/', 1, '2026-09-25 13:50:40'),
(5, 'S_S Store Management System', 's-s-store-management-system', 'A web-based system designed to help sari-sari store owners efficiently manage products, inventory, sales, customers, expenses, and daily store operations. It provides a dashboard for monitoring stock levels, revenue, profit, credit, and expiring products, making store management more organized and convenient.', '', 'We developed this system to help small-scale to large-scale sari-sari store owners manage their businesses more easily and efficiently. It provides a simple way to monitor products, inventory, sales, customers, credit, revenue, and daily operations in one system. The goal is to reduce the hassle of manual record-keeping, minimize errors, and help store owners make better decisions based on their store’s information.', 'System', '/uploads/proj_5ddd9735f9938900.png', '', 'This can manage products, inventory, sales, customers, expenses, and daily store operations.\r\nWith a dashboard for monitoring stock levels, revenue, profit, credit, and expiring products', 'https://github.com/ace715758-ui/Sari-sari_Store.git', 'https://sari-sari-store-azure-xi.vercel.app/', 1, '2026-09-26 15:54:08'),
(6, 'GeriaCare', 'geriacare', 'Geriatric Patient Management System,a clinical dashboard and electronic patient record for geriatric ward nurses, with real-time risk alerts for falls, aspiration, pressure ulcers, missed medications, and abnormal vitals.', 'GeriaCare is a responsive healthcare web app for geriatric nursing care. Nurses sign up, enter full patient records (demographics, clinical history, vitals across 5 time slots, labs, intake/output, medications, ADL checklist, FDAR notes, and risk assessments), and the dashboard aggregates every patient into 7 KPI tiles, 9 Chart.js visualizations, and 10 clinical alert tables (falls risk, missed meds, BP abnormalities, aspiration risk, fatigue, pressure ulcers, blood glucose, ADL non-compliance, allergies, lab results with CBC/BMP/Urinalysis tabs). It includes a 10-patient sample seed, auto-calculated risk scores, live clock, and a maroon custom design system.', 'GeriaCare started from a simple concern: geriatric patients are the most vulnerable in any ward — they face the highest risk of falls, medication errors, aspiration, and pressure ulcers, yet ward records are still kept on paper or in spreadsheets that make those risks easy to miss. I wanted to build a system made specifically for how geriatric nurses actually work: enter the patient\'s record once, and the app itself watches for danger — flagging high falls risk, missed medications, abnormal blood pressure and glucose, and ADL non-compliance automatically, instead of leaving the nurse to catch everything by hand. The goal was a tool that turns raw nursing notes into real-time alerts, so care decisions happen before an incident does — not after.', 'Other', '/uploads/proj_3c9412cdba6e29a5.png', '', 'Clinical dashboard with 7 KPI tiles\r\n9 Chart.js charts (vitals, SpO2, temperature, glucose, falls, aspiration, meds, ADL, census)\r\nClinical alert tables (falls, missed meds, BP, aspiration, fatigue, ulcers, glucose, ADL, allergies)\r\nFull patient data entry (history, vitals, labs, intake/output, SOAP notes)\r\nAuto-calculated falls and fatigue risk scores\r\nFDAR nursing notes\r\nMedication administration record (MAR)\r\nADL checklist with compliance tracking\r\nFeeding method and aspiration risk assessment', 'https://github.com/renzdivine/GeriaCare', 'https://geria-care.vercel.app/', 1, '2026-09-27 07:04:16'),
(10, 'Vote:O', 'vote-o', 'Web-based student election and polling system with admin-approved voter registration, 2FA-secured ballot voting, and live results for course-level elections.', 'Vote:O lets students register with their school ID and ID photos, wait for admin approval, then cast ballots in elections (grouped by position and partylist) and polls (grouped by category). Each course has its own officers, elections, candidates, and voter records, with per-position vote limits and course/year/section restrictions enforced server-side. Admins and CUSG officers manage students, elections, candidates, partylists, and polls through role-scoped dashboards with vote audit logs, turnout monitoring, live results, and election history. Security includes mandatory TOTP 2FA for every role, bcrypt hashing, forced credential resets for seeded accounts, and double-vote prevention at both the application and database level.', 'Vote:O started with a simple frustration: campus and course elections were still run on paper ballots and manual counting — slow to tally, easy to duplicate, and hard to trust. Students who couldn\'t line up at the booth lost their chance to vote, and officers spent hours sorting, counting, and double-checking ballots only to face doubts about the results. We wanted a system where every verified student gets exactly one vote, results are instant and auditable, and each course can run its own election without borrowing someone else\'s process. That became Vote:O: registration with real student IDs and admin approval, role-scoped dashboards for officers and CUSG, and double-vote protection built in at both the app and database level, so the outcome is something everyone can trust.', 'System', '/uploads/proj_c52b6d9a705583dc.png', '', 'Multi-step student signup with front/back ID photo upload\r\nAdmin approval workflow (pending → approved / declined)\r\nBallot voting by position with partylist grouping\r\nCategory-based polls with live voting\r\nPer-position vote limits and course/year/section restrictions\r\nDouble-vote prevention at app and database level\r\nRole-based dashboards for students, officers, and admins\r\nElection management: create, edit, toggle active, auto-expire\r\nCustom positions, partylists, and candidate management\r\nPoll management with options grouped by category\r\nVote audit log and turnout monitoring\r\nLive results widget and election history with filters', 'https://github.com/renzdivine/2A_VOTE-O', 'https://voteo.bsit2a.com/', 1, '2026-09-27 07:08:24'),
(11, 'Kaagapay', 'kaagapay', 'An all-in-one funeral services website where families can book service packages,\r\npay online, subscribe to pre-planned insurance, buy memorial products, and follow\r\nobituaries  with a staff panel for approvals, payments, and messages.', 'Kaagapay is a complete funeral services platform built for families who need help\r\nduring the most difficult moments of their lives. Instead of calling around or\r\nvisiting a branch, a family can reach the site at any hour of the day, read what to\r\ndo when a death occurs, choose between traditional, burial, cremation, and memorial\r\nservice packages, and book everything online.\r\n\r\nAfter booking and paying, an admin reviews and approves the request. Only then does\r\nthe merchandise shop unlock, so flowers, caskets, and urns can be purchased for that\r\nspecific arrangement. The site also includes pre-planning tools (a planning hub and\r\nchecklist), an insurance system that must be subscribed to before the date of death,\r\npublic obituaries and tribute pages, testimonials, and a resource section.\r\n\r\nClients get a dashboard where they can track bookings, orders, payments, insurance\r\npolicies, deceased records, messages, and notifications. Staff get a matching admin\r\npanel to manage clients, bookings, products, services, obituaries, insurance plans,\r\npayments, and inquiries — everything in one place instead of notebooks and inboxes.', 'I built Kaagapay because arranging a funeral usually happens on the worst day of\r\nsomeone\'s life. A death has just occurred, the family is grieving, and they still\r\nhave to call around, compare packages, travel to a branch, fill out forms, and keep\r\ntrack of payments — often at night or on a weekend.\r\n\r\nSo I moved the whole process online. A family can visit the site at any hour, read\r\nwhat to do when a death occurs, book a service package, pay, subscribe to\r\npre-planned insurance, buy memorial products, follow obituaries, and track every\r\nbooking, payment, and message from one dashboard. Staff get a matching admin panel\r\nthat approves bookings, verifies payments, publishes obituaries, and replies to\r\nmessages.', 'Web', '/uploads/proj_2f16205a787061ed.png', '', 'Online funeral package booking with admin approval\r\nBooking, order, and payment processing with receipts\r\nMerchandise shop that unlocks only after booking approval\r\nPre-planning hub and funeral planning checklist\r\nPre-need insurance plans, subscriptions, and inquiries\r\nPublic obituaries with detail/tribute pages\r\nClient dashboard for bookings, orders, payments, and insurance\r\nDeceased records management\r\nAdmin panel for clients, products, services, and payments\r\nIn-app notifications and message threads\r\nTestimonials with admin approval\r\nContact forms and 24/7 emergency hotline', 'https://github.com/renzdivine/kaagapay', 'https://kaagapay.infinityfreeapp.com/', 1, '2026-09-27 07:12:21'),
(12, 'Sugaryvon', 'sugaryvon', 'Sugaryvon is a modern bakery website where customers can browse the cake menu, see bestsellers, order a custom cake, and check delivery info — all in one place, on any device.', 'Sugaryvon is a responsive website for an artisan bakery. The homepage opens with a hero section, then walks visitors through the menu categories, best-selling cakes, and the bakery\'s promise of freshness — every cake is baked to order each morning. From there, customers can visit dedicated pages for the full menu, bestsellers, custom cake requests, delivery details, and the bakery\'s story. The design uses soft pastel colors, rounded cards, friendly typography, and smooth scrolling with animated transitions to feel warm and inviting, like a real bakery display case.', 'The client came to us because their bakery, Sugaryvon, was relying only on walk-ins, phone calls, and social media messages to take orders. Customers kept asking the same questions what cakes are available, how much a custom cake costs, and whether they deliver and the staff had to answer every one by hand. The client wanted one place where customers could see everything and order on their own, so we built this website.\r\nWe started with a fresh Vite and React project and shaped it into a bakery brand step by step. First we designed the look  soft pastel colors, rounded cards, and friendly fonts — so the site would feel warm and homemade instead of cold and corporate. Then we built the pages: a landing page to introduce the bakery, a menu page for the cake categories, a bestsellers page, a custom cake request page, a delivery page, and a page telling the bakery\'s story and freshness promise.\r\nMost of the work went into making it feel smooth and easy to use. We added a sticky navigation bar so customers can jump between pages, smooth scrolling and animations to make browsing enjoyable, and a layout that works on phones as well as laptops — since most people will open it on their phone. We used React, TypeScript, Tailwind CSS, and shadcn UI components to keep the code clean and easy to update, so the client can add new cakes or pages later without trouble.\r\nThe result is a website that works like a digital storefront: it answers customer questions, shows off the products, and takes custom cake requests even when the shop is closed.', 'Web', '/uploads/proj_8ef0fabe9824ba75.png', '', 'Landing page that introduces the bakery\r\n- Menu page listing cakes by category\r\n- Bestsellers page showing popular cakes\r\n- Custom cake order page\r\n- Delivery information page\r\n- Our promise page explaining freshness and quality', 'https://github.com/renzdivine/bake_de_yvon', '', 1, '2026-09-27 09:58:48'),
(13, 'Photobooth', 'photobooth', 'Photobooth is a web-based photo booth app that lets users capture photos, customize strips with filters, stickers, layouts, and frames, then download or share them through QR codes. It includes an admin dashboard for managing designs and Canva integration for advanced templates. Built with React/Vite and an Express backend.', 'Photobooth is a modern web-based photo booth platform designed for events, parties, celebrations, and casual photo sessions. Users can access the booth directly from their browser, choose from multiple photo layouts, capture a sequence of images using their device camera, and customize the final photo strip with filters, borders, colors, corner styles, stickers, date stamps, and uploaded frame designs.\r\n\r\nAfter customization, users can generate a finished photo strip, download it as a high-resolution PNG, print it, or scan a QR code to access the saved photo from another device. The experience is designed to be fast, playful, and easy to use without requiring downloads or user accounts.\r\n\r\nThe project includes an admin dashboard for managing frame templates and configuring supported layouts. Administrators can upload, activate, update, and delete designs, as well as manage Canva integration for brand templates and automated photo workflows.\r\n\r\nThe frontend is built with React and Vite and includes responsive layouts, GSAP and Lenis smooth scrolling, browser camera support, interactive photo customization, and a mobile-friendly interface. The backend is built with Node.js and Express and provides API endpoints for authentication, design management, photo storage, QR sharing, health checks, and Canva integration.\r\n\r\nThe application is deployed with the frontend on Vercel and the backend API on Render, with environment-based configuration connecting both services.', 'We built Photobooth to make memorable event photos easier, faster, and more personal. Instead of relying on physical equipment or complicated software, guests can open a browser, capture their moments, customize a photo strip, and share it instantly. The project combines a playful guest experience with an admin system that lets event organizers manage frames, layouts, and branded templates in one place.', 'Web', '/uploads/proj_b1cac7d0d553383a.jpg', '', 'Browser-based photo capture\r\nMultiple layouts and countdown timers\r\nFilters, borders, stickers, and custom frames\r\nLive photo strip customization\r\nDownload, print, and QR sharing\r\nAdmin design management dashboard\r\nCanva template integration\r\nResponsive mobile and desktop experience', 'https://github.com/melyades-dafort/photobooth.git', 'https://photobooth-wine-phi.vercel.app/', 1, '2026-09-27 11:49:57'),
(20, 'In-House Water Management System', 'in-house-water-management-system', 'The IBA Community Water Management and Billing System provides end-to-end administration for community-scale water distribution networks. It simplifies operational complexities by tracking water meters, accurately calculating consumption-based tariffs, automating monthly bill creation, generating printable receipts, logging operational expenses, and monitoring water infrastructure maintenance.', '', 'To create a  modern, responsive, and secure web-based water utility management and billing platform designed for community water associations, rural waterworks, barangay water systems, and small-to-medium utility operators.', 'Web', '/uploads/proj_2f00fdabe72cf4a7.png', '', '', 'https://github.com/ace715758-ui/IBA_WaterSystem', 'https://iba-watersystem.infinityfree.io/login', 1, '2026-09-29 14:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `project_images`
--

CREATE TABLE `project_images` (
  `image_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_images`
--

INSERT INTO `project_images` (`image_id`, `project_id`, `image_path`, `display_order`) VALUES
(1, 4, '/uploads/shot_68e33a33ca266ea1.png', 0),
(9, 6, '/uploads/shot_58354457e9db9fc4.png', 0),
(10, 10, '/uploads/shot_60c8ead3f6240de4.png', 0),
(11, 11, '/uploads/shot_b0d02360c048ba24.png', 0),
(12, 12, '/uploads/shot_12e2f3eab9dc5117.png', 0),
(13, 12, '/uploads/shot_479b94b3477f709b.png', 1),
(14, 13, '/uploads/shot_69cf97fbbb86cd5f.jpg', 0),
(15, 5, '/uploads/shot_ff9612f3a4fa3438.png', 0),
(16, 5, '/uploads/shot_6984fd1276828322.png', 1),
(17, 20, '/uploads/shot_8b2173812b49df93.png', 0),
(18, 20, '/uploads/shot_73d271c40a3f32d9.png', 1),
(19, 20, '/uploads/shot_ca6f8c18f28bbfcc.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `project_inquiries`
--

CREATE TABLE `project_inquiries` (
  `inquiry_id` int(10) UNSIGNED NOT NULL,
  `inquiry_name` varchar(120) NOT NULL,
  `inquiry_email` varchar(190) NOT NULL,
  `inquiry_phone` varchar(60) NOT NULL DEFAULT '',
  `inquiry_company` varchar(160) NOT NULL DEFAULT '',
  `inquiry_project_type` varchar(60) NOT NULL DEFAULT '',
  `inquiry_budget_range` varchar(60) NOT NULL DEFAULT '',
  `inquiry_description` text DEFAULT NULL,
  `inquiry_preferred_contact` varchar(40) NOT NULL DEFAULT '',
  `inquiry_status` varchar(30) NOT NULL DEFAULT 'New',
  `inquiry_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_inquiries`
--

INSERT INTO `project_inquiries` (`inquiry_id`, `inquiry_name`, `inquiry_email`, `inquiry_phone`, `inquiry_company`, `inquiry_project_type`, `inquiry_budget_range`, `inquiry_description`, `inquiry_preferred_contact`, `inquiry_status`, `inquiry_created_at`) VALUES
(1, 'Melquiades L. Parungao IV', 'parungao.melquiadesiv@gmail.com', '', '', '', '', 'MAMA', '', 'Contacted', '2026-09-26 15:04:44'),
(2, 'renz', 'renzdivinesy@gmail.com', '', '', '', '', 'Hello', '', 'Contacted', '2026-09-27 03:57:40'),
(3, 'Renz', 'renzdivinesy@gmail.com', '', '', '', '', 'test one', '', 'Contacted', '2026-09-27 04:12:38'),
(4, 'Renz', 'renzdivinesy@gmail.com', '09123456789', '', 'Web Application', 'Under $1,000', 'Hello there', '', 'Contacted', '2026-09-27 04:26:30'),
(5, 'Renz', 'renzdivinesy@gmail.com', '', '', '', '', 'bakod hu', '', 'Contacted', '2026-09-27 04:54:56'),
(6, 'Renz', 'divinagracia.renzsy@gmail.com', '', '', '', '', 'hello dear', '', 'Contacted', '2026-09-27 05:04:03'),
(7, 'Ace Magbanua', 'ace715758@gmail.com', '', '', '', '', 'hu', '', 'Contacted', '2026-09-29 07:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

CREATE TABLE `project_members` (
  `project_id` int(10) UNSIGNED NOT NULL,
  `member_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_members`
--

INSERT INTO `project_members` (`project_id`, `member_id`) VALUES
(4, 1),
(6, 1),
(10, 1),
(11, 1),
(12, 1),
(5, 4),
(20, 4),
(13, 5);

-- --------------------------------------------------------

--
-- Table structure for table `project_skills`
--

CREATE TABLE `project_skills` (
  `project_id` int(10) UNSIGNED NOT NULL,
  `skill_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_skills`
--

INSERT INTO `project_skills` (`project_id`, `skill_id`) VALUES
(5, 1),
(10, 1),
(11, 1),
(20, 1),
(10, 2),
(20, 2),
(4, 3),
(5, 3),
(6, 3),
(12, 3),
(13, 3),
(4, 4),
(5, 4),
(6, 4),
(5, 5),
(6, 5),
(10, 5),
(20, 5),
(5, 6),
(6, 6),
(10, 6),
(11, 6),
(12, 6),
(13, 6),
(20, 6),
(6, 7),
(10, 7),
(11, 7),
(12, 7),
(13, 7),
(20, 7),
(5, 8),
(5, 10),
(12, 10),
(5, 11),
(6, 11),
(13, 11),
(5, 13),
(12, 13),
(10, 18),
(11, 18),
(20, 18);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(10) UNSIGNED NOT NULL,
  `service_name` varchar(120) NOT NULL,
  `service_description` varchar(1000) NOT NULL DEFAULT '',
  `service_icon` varchar(60) NOT NULL DEFAULT '',
  `service_technologies` varchar(500) NOT NULL DEFAULT '',
  `service_status` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_description`, `service_icon`, `service_technologies`, `service_status`, `display_order`) VALUES
(1, 'Web Development', 'Custom websites and web applications designed around specific client requirements.', '</>', 'HTML, CSS, JavaScript, React, Next.js, PHP', 1, 1),
(2, 'Mobile Development', 'Mobile applications designed for real-world use cases on Android and other supported platforms.', 'APP', 'React, JavaScript, PHP', 1, 2),
(3, 'Custom System Development', 'Database-driven systems for organizations, businesses, schools, and other users.', '{}', 'PHP, MySQL', 1, 3),
(4, 'Database Development', 'Structured and reliable database solutions for applications and systems.', 'DB', 'MySQL, Supabase', 1, 4),
(5, 'API Development', 'Backend services that let your applications and services communicate.', 'API', 'PHP, MySQL, Supabase', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(10) UNSIGNED NOT NULL,
  `setting_key` varchar(80) NOT NULL,
  `setting_value` varchar(500) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_key`, `setting_value`) VALUES
(1, 'github_url', ''),
(2, 'linkedin_url', ''),
(3, 'site_email', 'devzs2026@gmail.com'),
(7, 'site_phone', '09919072070'),
(8, 'site_address', 'Bacolod City, Negros Occidental, Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(10) UNSIGNED NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `skill_category` varchar(100) NOT NULL DEFAULT 'Frontend',
  `skill_description` varchar(255) NOT NULL DEFAULT '',
  `skill_icon` varchar(60) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skill_id`, `skill_name`, `skill_category`, `skill_description`, `skill_icon`) VALUES
(1, 'PHP', 'Backend', 'Server-side application logic', 'PHP'),
(2, 'MySQL', 'Database', 'Relational data storage', 'MySQL'),
(3, 'React', 'Frontend', 'Interactive user interfaces', 'React'),
(4, 'Next.js', 'Frontend', 'Production React framework', 'Next'),
(5, 'HTML', 'Frontend', 'Semantic page structure', 'HTML'),
(6, 'CSS', 'Frontend', 'Layout and visual design', 'CSS'),
(7, 'JavaScript', 'Frontend', 'Browser and app logic', 'JS'),
(8, 'Supabase', 'Database / Backend Services', 'Auth, storage, and realtime backend', 'Supabase'),
(9, 'Photoshop', 'Frontend', 'Building Design', ''),
(10, 'TypeScript', 'Frontend', 'Typed JavaScript at scale', 'TS'),
(11, 'Node.js', 'Backend', 'JavaScript runtime environment', 'Node'),
(12, 'Express.js', 'Backend', 'Fast web framework for Node', 'Express'),
(13, 'Tailwind CSS', 'Frontend', 'Utility-first CSS framework', 'Tailwind'),
(15, 'Figma', 'Design', 'Interface design and prototyping tool', 'Figma'),
(16, 'PostgreSQL', 'Database', 'Powerful open source relational database', 'Postgres'),
(17, 'MongoDB', 'Database', 'Document-based NoSQL database', 'Mongo'),
(18, 'Phpmyadmin', 'Database', 'Store Data', 'Phpmyadmin');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `member_id` int(10) UNSIGNED NOT NULL,
  `member_name` varchar(120) NOT NULL,
  `member_slug` varchar(140) NOT NULL,
  `member_role` varchar(120) NOT NULL DEFAULT '',
  `member_photo` varchar(255) NOT NULL DEFAULT '',
  `member_short_bio` varchar(500) NOT NULL DEFAULT '',
  `member_full_bio` text DEFAULT NULL,
  `member_github` varchar(255) NOT NULL DEFAULT '',
  `member_linkedin` varchar(255) NOT NULL DEFAULT '',
  `member_facebook` varchar(255) NOT NULL DEFAULT '',
  `member_instagram` varchar(255) NOT NULL DEFAULT '',
  `member_email` varchar(190) NOT NULL DEFAULT '',
  `member_skills` varchar(500) NOT NULL DEFAULT '',
  `member_status` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`member_id`, `member_name`, `member_slug`, `member_role`, `member_photo`, `member_short_bio`, `member_full_bio`, `member_github`, `member_linkedin`, `member_facebook`, `member_instagram`, `member_email`, `member_skills`, `member_status`, `display_order`) VALUES
(1, 'Renz Divinagracia', 'renz-divinagracia', 'Full-Stack Developer', '/uploads/mem_71457c5504fc2c6f.jpg', 'Builds the web applications and systems behind DEVS, from database design to the final interface.', 'Renz focuses on turning requirements into working systems. He handles both the backend logic and the interfaces people actually use, with an emphasis on clean databases and maintainable code. At DEVS he leads most custom system and web application builds.', 'https://github.com/', 'https://www.linkedin.com/', '', '', '', 'CSS, HTML, JavaScript, MySQL, Next.js, PHP, React, Supabase', 1, 1),
(4, 'Ace S. Magbanua', 'ace-magbanua', 'Full-Stack Developer', '/uploads/mem_b69db4f9d371bd37.jpg', 'butangi di', 'butangi di', '', '', '', '', 'ace@gmail.com', 'HTML, Next.js, React, Supabase', 1, 0),
(5, 'Melquides L. Parungao IV', 'jay-jay', 'Full-Stack Developer', '/uploads/mem_091f6cd377948cb1.png', 'bahala kadi', '', 'https://github.com/melyades-dafort/photobooth', '', '', '', 'parungao.melquiadesiv@gmail.com', 'CSS, JavaScript, Next.js, Supabase', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_member_skills`
--

CREATE TABLE `team_member_skills` (
  `member_id` int(10) UNSIGNED NOT NULL,
  `skill_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_member_skills`
--

INSERT INTO `team_member_skills` (`member_id`, `skill_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(4, 3),
(1, 4),
(4, 4),
(5, 4),
(1, 5),
(4, 5),
(1, 6),
(5, 6),
(1, 7),
(5, 7),
(1, 8),
(4, 8),
(5, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `uq_admin_username` (`admin_username`);

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`availability_id`);

--
-- Indexes for table `inquiry_replies`
--
ALTER TABLE `inquiry_replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `idx_ir_inquiry` (`inquiry_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD UNIQUE KEY `uq_project_slug` (`project_slug`),
  ADD KEY `idx_project_status` (`project_status`);

--
-- Indexes for table `project_images`
--
ALTER TABLE `project_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `idx_pi_project` (`project_id`);

--
-- Indexes for table `project_inquiries`
--
ALTER TABLE `project_inquiries`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `idx_inquiry_status` (`inquiry_status`);

--
-- Indexes for table `project_members`
--
ALTER TABLE `project_members`
  ADD PRIMARY KEY (`project_id`,`member_id`),
  ADD KEY `fk_pm_member` (`member_id`);

--
-- Indexes for table `project_skills`
--
ALTER TABLE `project_skills`
  ADD PRIMARY KEY (`project_id`,`skill_id`),
  ADD KEY `fk_ps_skill` (`skill_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `uq_setting_key` (`setting_key`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`),
  ADD KEY `idx_skill_category` (`skill_category`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `uq_member_slug` (`member_slug`);

--
-- Indexes for table `team_member_skills`
--
ALTER TABLE `team_member_skills`
  ADD PRIMARY KEY (`member_id`,`skill_id`),
  ADD KEY `fk_tms_skill` (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
  MODIFY `availability_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inquiry_replies`
--
ALTER TABLE `inquiry_replies`
  MODIFY `reply_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `project_images`
--
ALTER TABLE `project_images`
  MODIFY `image_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `project_inquiries`
--
ALTER TABLE `project_inquiries`
  MODIFY `inquiry_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `member_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inquiry_replies`
--
ALTER TABLE `inquiry_replies`
  ADD CONSTRAINT `fk_ir_inquiry` FOREIGN KEY (`inquiry_id`) REFERENCES `project_inquiries` (`inquiry_id`) ON DELETE CASCADE;

--
-- Constraints for table `project_images`
--
ALTER TABLE `project_images`
  ADD CONSTRAINT `fk_pi_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `project_members`
--
ALTER TABLE `project_members`
  ADD CONSTRAINT `fk_pm_member` FOREIGN KEY (`member_id`) REFERENCES `team_members` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pm_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `project_skills`
--
ALTER TABLE `project_skills`
  ADD CONSTRAINT `fk_ps_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ps_skill` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`skill_id`) ON DELETE CASCADE;

--
-- Constraints for table `team_member_skills`
--
ALTER TABLE `team_member_skills`
  ADD CONSTRAINT `fk_tms_member` FOREIGN KEY (`member_id`) REFERENCES `team_members` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tms_skill` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`skill_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
