<?php
/**
 * LeafCare AI – Plant Leaf & Fungal Disease Detection System
 * Detection History Page (history.php)
 */

$pageTitle = "Detection History & Scans Log";
require_once __DIR__ . '/config.php';

// Handle Clear History Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_history'])) {
    if ($db_connected && $pdo) {
        try {
            $pdo->exec("TRUNCATE TABLE `detection_history`");
        } catch (Exception $e) {
            // Error handling
        }
    }
    $_SESSION['detection_history'] = [];
    header('Location: history.php?cleared=1');
    exit;
}

// Fetch Records
$historyRecords = [];

if ($db_connected && $pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM `detection_history` ORDER BY `detection_date` DESC");
        $historyRecords = $stmt->fetchAll();
    } catch (Exception $e) {
        $historyRecords = [];
    }
}

// Fallback to Session history if DB is empty or offline
if (empty($historyRecords) && !empty($_SESSION['detection_history'])) {
    $historyRecords = $_SESSION['detection_history'];
}

// If still empty and no cleared parameter, provide sample initial history for demonstration
if (empty($historyRecords) && !isset($_GET['cleared'])) {
    $historyRecords = [
        [
            'id' => 1,
            'image_path' => 'uploads/sample_tomato_early_blight.svg',
            'plant_name' => 'Tomato Plant',
            'disease_name' => 'Early Blight',
            'disease_type' => 'Fungal (Alternaria solani)',
            'confidence' => 94.6,
            'severity' => 'Moderate',
            'notes' => 'Concentric target spots detected on lower foliage.',
            'detection_date' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        [
            'id' => 2,
            'image_path' => 'uploads/sample_potato_late_blight.svg',
            'plant_name' => 'Potato Plant',
            'disease_name' => 'Late Blight',
            'disease_type' => 'Fungal (Phytophthora)',
            'confidence' => 97.2,
            'severity' => 'Critical',
            'notes' => 'Water-soaked lesions expanding on leaf margins.',
            'detection_date' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ],
        [
            'id' => 3,
            'image_path' => 'uploads/sample_grape_powdery_mildew.svg',
            'plant_name' => 'Grape Vine',
            'disease_name' => 'Powdery Mildew',
            'disease_type' => 'Fungal (Erysiphe necator)',
            'confidence' => 91.8,
            'severity' => 'Moderate',
            'notes' => 'Ash-gray mycelium spotted across leaf blade.',
            'detection_date' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ]
    ];
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="container history-container">
    <div class="history-header">
        <div>
            <span class="section-tag">Diagnostic Records</span>
            <h1 class="section-title">Detection History</h1>
            <p class="section-subtitle">
                Track previous leaf scans, evaluate crop symptom progression, and review confidence metrics.
            </p>
        </div>

        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <a href="detect.php" class="btn btn-primary">
                <i class="fa-solid fa-microscope"></i>
                <span>Scan New Leaf</span>
            </a>

            <?php if (!empty($historyRecords)): ?>
                <form method="POST" onsubmit="return confirm('Are you sure you want to clear all detection history?');" style="margin: 0;">
                    <button type="submit" name="clear_history" value="1" class="btn btn-secondary" title="Clear all history">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Clear History</span>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Storage Status Alert Banner -->
    <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 0.85rem 1.25rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; font-size: 0.9rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span class="status-dot <?php echo $db_connected ? 'online' : 'demo'; ?>"></span>
            <span>
                Storage Engine: <strong><?php echo $db_connected ? 'MySQL Database (leafcare_ai.detection_history)' : 'Session / Demo Mode Memory'; ?></strong>
            </span>
        </div>
        <span style="color: var(--text-muted); font-size: 0.85rem;">
            Total Scans Recorded: <strong><?php echo count($historyRecords); ?></strong>
        </span>
    </div>

    <?php if (empty($historyRecords)): ?>
        <div class="history-table-wrapper empty-history-box">
            <div class="empty-history-icon">
                <i class="fa-solid fa-seedling"></i>
            </div>
            <h3>No Scans Found in History</h3>
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem; max-width: 480px; margin-left: auto; margin-right: auto;">
                You haven't scanned any plant leaves yet. Start by taking a photo or testing with a sample leaf.
            </p>
            <a href="detect.php" class="btn btn-primary">
                <i class="fa-solid fa-camera"></i>
                <span>Start First Leaf Scan</span>
            </a>
        </div>
    <?php else: ?>
        <div class="history-table-wrapper">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Leaf Image</th>
                        <th>Plant &amp; Disease</th>
                        <th>Severity</th>
                        <th>Confidence</th>
                        <th>Detection Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historyRecords as $item): 
                        $imgPath = $item['image_path'];
                        if (!file_exists(ROOT_PATH . DIRECTORY_SEPARATOR . $imgPath)) {
                            $imgPath = 'images/samples/tomato_early_blight.svg';
                        }
                    ?>
                        <tr>
                            <td>
                                <img src="<?php echo safe($imgPath); ?>" alt="Scanned Leaf" class="history-thumb">
                            </td>
                            <td>
                                <strong><?php echo safe($item['disease_name']); ?></strong><br>
                                <span style="font-size: 0.85rem; color: var(--color-primary-vibrant); font-weight: 600;">
                                    <?php echo safe($item['plant_name']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?php echo getSeverityClass($item['severity'] ?? 'Moderate'); ?>">
                                    <?php echo safe($item['severity'] ?? 'Moderate'); ?>
                                </span>
                            </td>
                            <td>
                                <strong style="color: var(--color-primary-vibrant); font-size: 1.05rem;">
                                    <?php echo formatConfidence($item['confidence']); ?>
                                </strong>
                            </td>
                            <td style="color: var(--text-muted); font-size: 0.88rem;">
                                <i class="fa-regular fa-calendar-days"></i> <?php echo safe(date('M d, Y H:i', strtotime($item['detection_date']))); ?>
                            </td>
                            <td>
                                <a href="diseases.php?search=<?php echo urlencode($item['disease_name']); ?>" class="btn btn-secondary btn-sm" title="View Disease Information">
                                    <i class="fa-solid fa-book-medical"></i> View Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
