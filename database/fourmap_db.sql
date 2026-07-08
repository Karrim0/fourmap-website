-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 31, 2026 at 08:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fourmap_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accreditations`
--

CREATE TABLE `accreditations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `password`, `created_at`) VALUES
(2, 'المسؤول', 'admin', '$2y$12$/L2luDhWlnTLyfCJZTNGzOZ66ZmPrzQv0iQboUsIbkuKnU5GeunfO', '2026-02-20 14:38:25');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `meta_title` varchar(70) DEFAULT NULL,
  `meta_description` varchar(170) DEFAULT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `excerpt`, `meta_title`, `meta_description`, `content`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'أهمية الخدمات الهندسية في تطوير البنية التحتية', 'تعرف على دور الخدمات الهندسية في بناء بنية تحتية قوية تدعم النمو الاقتصادي والاستدامة.', NULL, NULL, 'تُعد الخدمات الهندسية من الركائز الأساسية في تطوير البنية التحتية لأي دولة، حيث تشمل تصميم وتنفيذ المشاريع الحيوية مثل الطرق، الجسور، والمباني. تساهم هذه الخدمات في تحسين جودة الحياة من خلال توفير بيئة آمنة ومستدامة.\r\n\r\nيعتمد نجاح المشاريع الهندسية على التخطيط الجيد واستخدام أحدث التقنيات، بالإضافة إلى خبرة المهندسين في إدارة الموارد بكفاءة. كما تلعب الخدمات الهندسية دورًا مهمًا في تقليل التكاليف وتحقيق أعلى مستويات الجودة.\r\n\r\nومع التطور التكنولوجي، أصبحت الحلول الهندسية أكثر دقة وابتكارًا، مما يساعد في تنفيذ مشاريع معقدة بكفاءة عالية وفي وقت قياسي.', 'assets/uploads/articles/article_1774401604_4528.png', 'active', '2026-03-25 01:08:57', '2026-03-25 01:20:04'),
(5, 'أنواع الخدمات الهندسية ودورها في المشاريع الحديثة', 'استعرض أبرز أنواع الخدمات الهندسية وكيف تساهم في نجاح المشاريع المعاصرة.', NULL, NULL, 'تنقسم الخدمات الهندسية إلى عدة مجالات مثل الهندسة المدنية، المعمارية، الكهربائية، والميكانيكية، وكل منها يلعب دورًا حيويًا في تنفيذ المشاريع المختلفة.\r\n\r\nالهندسة المدنية تركز على إنشاء البنية التحتية، بينما تهتم الهندسة المعمارية بتصميم المباني من حيث الشكل والوظيفة. أما الهندسة الكهربائية والميكانيكية فتختص بأنظمة التشغيل والتجهيزات الداخلية.\r\n\r\nتكامل هذه التخصصات يضمن تنفيذ مشروع متكامل يلبي احتياجات المستخدمين ويحقق أعلى معايير الجودة. لذلك، تعتمد الشركات الناجحة على فرق متعددة التخصصات لضمان أفضل النتائج.', 'assets/uploads/articles/article_1774401869_3620.png', 'active', '2026-03-25 01:24:29', NULL),
(6, 'كيف تختار شركة خدمات هندسية مناسبة لمشروعك', 'دليل عملي لاختيار أفضل شركة خدمات هندسية تضمن نجاح مشروعك من البداية للنهاية.', NULL, NULL, 'اختيار شركة خدمات هندسية مناسبة هو خطوة حاسمة في نجاح أي مشروع. يجب أولًا التأكد من خبرة الشركة وسجلها في تنفيذ مشاريع مشابهة.\r\n\r\nمن المهم أيضًا مراجعة فريق العمل والتأكد من كفاءتهم، بالإضافة إلى الاطلاع على التقنيات التي تستخدمها الشركة في التصميم والتنفيذ. الشفافية في التعامل والالتزام بالمواعيد من العوامل الأساسية التي يجب أخذها في الاعتبار.\r\n\r\nكما يُفضل اختيار شركة تقدم حلولًا مبتكرة وتعمل على تحقيق التوازن بين الجودة والتكلفة، مما يضمن تنفيذ المشروع بأفضل صورة ممكنة.', 'assets/uploads/articles/article_1774401955_1204.png', 'active', '2026-03-25 01:25:55', NULL),
(7, 'دور التكنولوجيا في تطوير الخدمات الهندسية', 'تعرف على كيف غيرت التكنولوجيا الحديثة شكل الخدمات الهندسية ورفعت من كفاءتها.', NULL, NULL, 'شهدت الخدمات الهندسية تطورًا كبيرًا بفضل التكنولوجيا الحديثة، حيث أصبح استخدام البرامج المتقدمة مثل نمذجة المعلومات (BIM) أمرًا أساسيًا في تصميم المشاريع.\r\n\r\nتساعد هذه التقنيات في تقليل الأخطاء وتحسين دقة التصميم، بالإضافة إلى تسهيل عملية التواصل بين الفرق المختلفة. كما تساهم في تقليل الوقت والتكاليف من خلال محاكاة المشروع قبل التنفيذ.\r\n\r\nالتكنولوجيا لم تقتصر فقط على التصميم، بل امتدت إلى التنفيذ باستخدام المعدات الذكية وأنظمة الإدارة الحديثة، مما أدى إلى تحسين جودة المشاريع وزيادة كفاءتها بشكل ملحوظ.', 'assets/uploads/articles/article_1774402011_7468.png', 'active', '2026-03-25 01:26:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `is_featured` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `image`, `status`, `is_featured`, `created_at`, `updated_at`) VALUES
(17, 'إعارة المهندسين والمشرفين الميدانيين', 'توفير مهندس معتمد أو مشرف ميداني للإشراف وضبط الجودة ومطابقة الأعمال مع المخططات وكود البناء.', 'assets/images/services/service_1774782875_cb625d6c.png', 'active', 1, '2026-02-20 20:19:02', '2026-03-29 11:14:35'),
(18, 'إدارة المشروع الشاملة', 'إدارة دورة حياة المشروع من الدراسات والتصميم حتى التنفيذ والتسليم أو البيع، بتكامل فني وإداري كامل.', 'assets/images/services/service_1774782837_bd59e404.png', 'active', 1, '2026-02-20 20:19:46', '2026-03-29 11:13:57'),
(19, 'إدارة التعاقدات والموردين', 'التعاقد مع مقاولين وموردين معتمدين ذو خبرة عالية وإدارة العقود والمستخلصات رقمياً وفق نطاق أعمال واضح.', 'assets/images/services/service_1774782800_ea007d5f.png', 'active', 1, '2026-02-20 20:20:28', '2026-03-29 11:13:20'),
(20, 'التصاميم الهندسية المتكاملة', 'إعداد التصاميم المعمارية والإنشائية والكهربائية والميكانيكية مع تنسيق هندسي شامل لضمان تكامل المخططات وجاهزيتها للتنفيذ.', 'assets/images/services/service_1774782068_a9cf0154.png', 'active', 1, '2026-02-20 20:24:55', '2026-03-29 11:12:28');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(191) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('text','textarea','image','url','phone','email') NOT NULL DEFAULT 'text',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `updated_at`, `created_at`) VALUES
(1, 'footer_about', 'فور ماب هو مكتبك الرقمي الأنسب', 'textarea', '2026-03-10 20:17:35', '2026-02-19 04:40:58'),
(2, 'footer_copyright', '© 2026 فور ماب - جميع الحقوق محفوظة', 'text', '2026-03-10 20:17:35', '2026-02-19 04:40:58'),
(3, 'contact_email', '4map@gmail.com', 'text', '2026-02-22 06:53:48', '2026-02-19 04:40:58'),
(4, 'contact_phone', '‪0535742020‬', 'text', '2026-03-10 20:17:35', '2026-02-19 04:40:58'),
(5, 'contact_address', 'المملكه العربية السعودية', 'text', '2026-03-10 20:17:35', '2026-02-19 04:40:58'),
(6, 'social_instagram', 'https://www.instagram.com/4map.sa', 'url', '2026-03-10 20:21:00', '2026-02-19 04:40:58'),
(7, 'social_linkedin', 'https://www.linkedin.com/company/4-map-sa/', 'url', '2026-03-10 20:21:00', '2026-02-19 04:40:58'),
(8, 'appstore_url', 'https://apps.apple.com/sa/app/4map/id6756793950', 'url', '2026-03-10 20:36:32', '2026-02-19 04:40:58'),
(9, 'googleplay_url', 'https://play.google.com/store/apps/details?id=com.four.map&pcampaignid=web_share', 'url', '2026-03-10 20:36:32', '2026-02-19 04:40:58'),
(10, 'site_logo', 'assets/images/thislogo.png', 'image', '2026-02-22 04:03:48', '2026-02-19 04:40:58'),
(11, 'social_x', 'https://x.com/4map__sa', 'url', '2026-03-10 20:21:00', '2026-02-19 12:47:11'),
(12, 'social_youtube', 'https://www.yahoo.com', 'url', '2026-02-25 21:04:47', '2026-02-19 12:47:11'),
(42, 'hero_title_text', 'كل خدماتك الهندسية،', 'text', '2026-02-20 20:12:41', '2026-02-19 14:53:38'),
(43, 'hero_title_highlight', 'بين يدّك!', 'text', '2026-02-20 20:12:41', '2026-02-19 14:53:38'),
(44, 'hero_subtitle', 'من الطلب حتي الإعتماد', 'text', '2026-03-10 20:08:40', '2026-02-19 14:53:38'),
(47, 'hero_image', 'assets/uploads/settings/logo_1774785570_5977.png', 'image', '2026-03-29 11:59:30', '2026-02-19 14:53:38'),
(58, 'about_title', 'من نحن؟', 'text', '2026-02-20 20:14:57', '2026-02-19 15:02:07'),
(59, 'about_p1', 'فور ماب منصة إلكترونية مبتكرة تقدم حلول هندسية وخدمات مهنيه متكاملة، دون الحاجة لزيارات مكتبية أو مراجعات متعددة. مصممة خصيصاً لتلبية احتياجات السوق السعــودي', 'textarea', '2026-02-20 20:14:57', '2026-02-19 15:02:07'),
(60, 'about_p2', 'بسهولة، سرعة وثقه. نسعى لتحويل الأجراءات المعقدة إلى تجارب سلسة، عبر واجهة رقمية تمكن الأفراد والشركات من تنفيذ متطلباتهم الهندسية.', 'textarea', '2026-02-20 20:14:57', '2026-02-19 15:02:07'),
(78, 'about_image', 'assets/uploads/settings/logo_1774786524_3218.jpeg', 'image', '2026-03-29 12:15:24', '2026-02-19 15:02:54'),
(93, 'vision_text', 'نسعى في فور ماب إلى أن نكون المنصة الهندسية الرقمية الرائدة في المملكــة، من خلال تقديم حلول متكاملة في إدارة المشاريع، التصاميم، وإصدار الرخص وفق أعلى المعايير الفنية. نعتمد على الكفاءة الهندسية، التحول الرقمي، وضبط الجودة لضمان تنفيذ المشاريــع بدقة وكفاءة واستدامة.', 'textarea', '2026-03-10 20:10:50', '2026-02-19 15:09:47'),
(94, 'vision_map_image', 'assets/uploads/settings/logo_1771625808_2702.png', 'image', '2026-02-22 04:02:42', '2026-02-19 15:09:47'),
(112, 'why_title', 'ليه فور ماب؟', 'text', '2026-02-20 20:29:06', '2026-02-19 15:16:20'),
(113, 'why_subtitle', 'منصة رقميّة موحدة تجمع كل الخدمات الهندسية المهمة في مكان واحد', 'text', '2026-02-20 20:29:06', '2026-02-19 15:16:20'),
(114, 'why1_title', 'سهولة الوصول', 'text', '2026-02-20 20:29:06', '2026-02-19 15:16:20'),
(115, 'why1_text', 'كل الخدمات متوفرة عبر الجوال في تطبيق واحد', 'text', '2026-02-20 20:29:06', '2026-02-19 15:16:20'),
(116, 'why2_title', 'مهندسين معتمدين', 'text', '2026-02-20 20:29:06', '2026-02-19 15:16:20'),
(117, 'why2_text', 'خدمات تنفيذ واستشارات عبر محترفين معتمدين', 'text', '2026-02-20 20:29:06', '2026-02-19 15:16:20'),
(118, 'why2_icon', 'assets/images/10.png', 'image', '2026-02-22 04:05:13', '2026-02-19 15:16:20'),
(119, 'why3_title', 'تنفيذ سريع وموثوق', 'text', '2026-02-20 20:29:06', '2026-02-19 15:16:20'),
(120, 'why3_text', 'نظام متابعة فوري من الطلب حتى التسليم', 'text', '2026-02-20 20:29:06', '2026-02-19 15:16:20'),
(121, 'why3_icon', 'assets/images/12.png', 'image', '2026-02-22 04:05:13', '2026-02-19 15:16:20'),
(122, 'why4_title', '', 'text', '2026-02-20 20:29:06', '2026-02-19 15:16:20'),
(123, 'why4_text', '', 'text', '2026-02-20 20:29:06', '2026-02-19 15:16:20'),
(124, 'why4_icon', 'assets/images/13.png', 'image', '2026-02-22 04:05:13', '2026-02-19 15:16:20'),
(143, 'about_page_title_main', 'من', 'text', '2026-02-20 20:37:13', '2026-02-19 15:30:24'),
(144, 'about_page_title_highlight', 'نحن', 'text', '2026-02-20 20:37:13', '2026-02-19 15:30:24'),
(145, 'about_page_breadcrumb_label', 'نحن', 'text', '2026-02-20 20:37:13', '2026-02-19 15:30:24'),
(146, 'about_page_heading_text', 'نحن', 'text', '2026-02-20 20:37:13', '2026-02-19 15:30:24'),
(147, 'about_page_heading_highlight', 'فور ماب', 'text', NULL, '2026-02-19 15:30:24'),
(148, 'about_page_p1', 'فور ماب هو منصة هندسية رقمية متكاملة أُسست بهدف توفير الخدمات الهندسية المتنوعة للمواطنين والمقيمين في المملكة العربية السعودية، بطريقة سهلة، سريعة، وموثوقة من خلال تطبيق ذكي متعدد المنصات.', 'textarea', '2026-02-20 20:37:13', '2026-02-19 15:30:24'),
(149, 'about_page_p2', 'نؤمن في فور ماب بأن الوصول إلى الخدمة الهندسية المتخصصة يجب ألا يكون معقداً أو مكلفاً، لذلك نعمل على ربط العملاء بأفضل المهندسين المعتمدين في مختلف التخصصات، وتقديم الخدمة في أقل وقت وبأعلى جودة.', 'textarea', '2026-02-20 20:37:13', '2026-02-19 15:30:24'),
(150, 'about_page_p3', 'تأسست المنصة في إطار دعم رؤية 2030 لتحقيق التحول الرقمي في قطاع الإنشاء والبناء، وتمكين المهندسين السعوديين من تقديم خدماتهم عبر قنوات رقمية متطورة.', 'textarea', '2026-02-20 20:37:13', '2026-02-19 15:30:24'),
(151, 'about_page_image', 'assets/uploads/settings/logo_1774786534_3499.jpeg', 'image', '2026-03-29 12:15:34', '2026-02-19 15:30:24'),
(180, 'about_stats_1_number', '+130', 'text', '2026-02-20 20:37:13', '2026-02-19 15:35:59'),
(181, 'about_stats_1_label', 'مشروع منجز', 'text', NULL, '2026-02-19 15:35:59'),
(182, 'about_stats_2_number', '+600', 'text', '2026-03-10 20:15:57', '2026-02-19 15:35:59'),
(183, 'about_stats_2_label', 'استشارة هندسية', 'text', '2026-03-10 20:15:57', '2026-02-19 15:35:59'),
(184, 'about_stats_3_number', '+1000', 'text', '2026-02-20 20:37:13', '2026-02-19 15:35:59'),
(185, 'about_stats_3_label', 'عميل سعيد', 'text', NULL, '2026-02-19 15:35:59'),
(1906, 'contact_whatsapp', '0535742020', 'text', '2026-03-10 20:18:16', '2026-02-20 21:06:52'),
(3462, 'seo_home_title', 'فور ماب | خدمات هندسية متكاملة في المملكة العربية السعودية', 'text', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3463, 'seo_home_description', 'فور ماب منصة هندسية رقمية تقدم خدمات رخص البناء والتصاميم المعمارية والإشراف الهندسي بسهولة وسرعة في السعودية', 'textarea', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3464, 'seo_home_keywords', 'فور ماب, خدمات هندسية, رخص بناء, تصاميم معمارية, مكتب هندسي, السعودية', 'textarea', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3465, 'seo_about_title', 'من نحن | فور ماب - المنصة الهندسية الرقمية', 'text', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3466, 'seo_about_description', 'تعرف على فور ماب، المنصة الهندسية الرقمية الرائدة في المملكة العربية السعودية لتقديم الخدمات الهندسية بأعلى جودة', 'textarea', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3467, 'seo_about_keywords', 'من نحن فور ماب, مكتب هندسي رقمي, رؤية 2030, خدمات هندسية السعودية', 'textarea', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3468, 'seo_services_title', 'خدماتنا الهندسية | فور ماب', 'text', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3469, 'seo_services_description', 'اكتشف خدمات فور ماب: رخص البناء، التصاميم المعمارية والإنشائية، الإشراف الهندسي، الاستشارات، والرفع المساحي', 'textarea', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3470, 'seo_services_keywords', 'خدمات هندسية, رخص بناء, تصاميم معمارية, إشراف هندسي, استشارات هندسية', 'textarea', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3471, 'seo_contact_title', 'تواصل معنا | فور ماب', 'text', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3472, 'seo_contact_description', 'تواصل مع فريق فور ماب الهندسي عبر واتساب أو البريد الإلكتروني للحصول على خدماتك الهندسية', 'textarea', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3473, 'seo_contact_keywords', 'تواصل فور ماب, واتساب, خدمة عملاء, استفسار هندسي', 'textarea', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3474, 'seo_consultation_title', 'طلب استشارة هندسية | فور ماب', 'text', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3475, 'seo_consultation_description', 'احصل على استشارة هندسية مجانية وعرض سعر فوري من مهندسي فور ماب المعتمدين في المملكة العربية السعودية', 'textarea', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3476, 'seo_consultation_keywords', 'استشارة هندسية, عرض سعر, مهندس معتمد, فور ماب, خدمات هندسية', 'textarea', '2026-03-18 21:08:51', '2026-03-18 19:11:34'),
(3739, 'facebook_pixel', '', 'text', NULL, '2026-03-27 06:04:01'),
(3740, 'google_analytics', '', 'text', NULL, '2026-03-27 06:04:01'),
(3741, 'google_search_console', '', 'text', NULL, '2026-03-27 06:04:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accreditations`
--
ALTER TABLE `accreditations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accreditations`
--
ALTER TABLE `accreditations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6121;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
