<?php
/**
 * LeafCare AI – Plant Leaf & Fungal Disease Detection System
 * Global Header Component
 */

if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../config.php';
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? safe($pageTitle) . ' – ' . APP_NAME : APP_NAME . ' – Plant Leaf & Fungal Disease Detection'; ?></title>
    <meta name="description" content="AI-assisted plant leaf disease and fungal pathogen detection system. Diagnose crop infections, evaluate disease severity, and get organic remedies in seconds.">
    <meta name="theme-color" content="#1b5e20">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Free CDN for Botanical & Diagnostic Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css?v=2.0">
</head>
<body>

    <!-- Notification / Toast Container -->
    <div id="toast-container" class="toast-container" aria-live="polite"></div>

    <!-- Navigation Bar -->
    <header class="navbar-wrapper">
        <nav class="navbar container">
            <a href="index.php" class="brand-logo" aria-label="LeafCare AI Home">
                <div class="logo-icon-box">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-name">LeafCare<span class="brand-accent">AI</span></span>
                    <span class="brand-subtext">Plant Pathology & Care</span>
                </div>
            </a>

            <!-- Desktop Navigation Menu -->
            <ul class="nav-links">
                <li>
                    <a href="index.php" class="nav-link <?php echo ($currentPage === 'index.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-house"></i> Home
                    </a>
                </li>
                <li>
                    <a href="detect.php" class="nav-link <?php echo ($currentPage === 'detect.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-microscope"></i> Leaf Detection
                    </a>
                </li>
                <li>
                    <a href="diseases.php" class="nav-link <?php echo ($currentPage === 'diseases.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-book-medical"></i> Diseases Library
                    </a>
                </li>
                <li>
                    <a href="history.php" class="nav-link <?php echo ($currentPage === 'history.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-clock-rotate-left"></i> History
                    </a>
                </li>
                <li>
                    <a href="about.php" class="nav-link <?php echo ($currentPage === 'about.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-circle-info"></i> About
                    </a>
                </li>
            </ul>

            <!-- Navbar Actions -->
            <div class="nav-actions">
                <!-- Dark / Light Theme Toggle -->
                <button id="theme-toggle-btn" class="icon-btn" aria-label="Toggle dark/light theme" title="Toggle theme">
                    <i class="fa-solid fa-moon"></i>
                </button>

                <!-- Quick Action Button -->
                <a href="detect.php" class="btn btn-primary btn-sm nav-cta">
                    <i class="fa-solid fa-camera"></i>
                    <span>Scan Leaf</span>
                </a>

                <!-- Mobile Hamburger Toggle -->
                <button id="mobile-menu-btn" class="mobile-toggle" aria-label="Open mobile menu" aria-expanded="false">
                    <span class="hamburger-bar"></span>
                    <span class="hamburger-bar"></span>
                    <span class="hamburger-bar"></span>
                </button>
            </div>
        </nav>

        <!-- Mobile Drawer Menu -->
        <div id="mobile-nav-drawer" class="mobile-nav-drawer">
            <ul class="mobile-nav-links">
                <li>
                    <a href="index.php" class="mobile-nav-link <?php echo ($currentPage === 'index.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-house"></i> Home
                    </a>
                </li>
                <li>
                    <a href="detect.php" class="mobile-nav-link <?php echo ($currentPage === 'detect.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-microscope"></i> Leaf Detection
                    </a>
                </li>
                <li>
                    <a href="diseases.php" class="mobile-nav-link <?php echo ($currentPage === 'diseases.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-book-medical"></i> Diseases Library
                    </a>
                </li>
                <li>
                    <a href="history.php" class="mobile-nav-link <?php echo ($currentPage === 'history.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-clock-rotate-left"></i> Detection History
                    </a>
                </li>
                <li>
                    <a href="about.php" class="mobile-nav-link <?php echo ($currentPage === 'about.php') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-circle-info"></i> About System
                    </a>
                </li>
            </ul>
            <div class="mobile-drawer-footer">
                <a href="detect.php" class="btn btn-primary btn-block">
                    <i class="fa-solid fa-camera"></i> Start Detection
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Container Wrapper -->
    <main class="main-content">
