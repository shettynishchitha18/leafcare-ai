<?php
/**
 * LeafCare AI – Plant Leaf & Fungal Disease Detection System
 * Configuration & Database Connection Handler
 */

// Error reporting for development (disable display_errors in production)
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Application Constants
define('APP_NAME', 'LeafCare AI');
define('APP_TAGLINE', 'Plant Leaf & Fungal Disease Detection System');
define('APP_VERSION', '2.0.0');
define('BASE_URL', '');

// Directory Paths
define('ROOT_PATH', __DIR__);
define('UPLOAD_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR);
define('SAMPLE_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'samples' . DIRECTORY_SEPARATOR);

// Upload Security Configuration
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10 Megabytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);
define('ALLOWED_MIMES', [
    'image/jpeg',
    'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/webp'
]);

// AI Detection Engine Configuration
// 'demo' = Intelligent simulated botanical analysis & local rules engine
// 'api'  = Forward image to external Python / Flask / FastAPI PyTorch model
define('AI_MODE', 'demo'); 
define('AI_API_ENDPOINT', 'http://127.0.0.1:5000/predict');
define('AI_API_TIMEOUT', 15); // seconds

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'leafcare_ai');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Initialize PDO Database Connection with graceful fallback
 * If MySQL is not running yet, the application gracefully continues in demo mode.
 */
$pdo = null;
$db_connected = false;
$db_error = null;

try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_TIMEOUT            => 2,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    $db_connected = true;
} catch (PDOException $e) {
    $db_connected = false;
    $db_error = $e->getMessage();
    // Non-fatal error: Application continues with session-based memory & offline database
}

/**
 * Helper: Sanitize input strings for safe HTML output
 */
function safe($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Helper: Format confidence percentage
 */
function formatConfidence($score) {
    return number_format(floatval($score), 1) . '%';
}

/**
 * Helper: Get severity badge CSS class
 */
function getSeverityClass($severity) {
    switch (strtolower(trim($severity))) {
        case 'critical':
        case 'severe':
            return 'badge-severe';
        case 'moderate':
            return 'badge-moderate';
        case 'mild':
        case 'low':
            return 'badge-mild';
        case 'healthy':
        case 'none':
            return 'badge-healthy';
        default:
            return 'badge-info';
    }
}
