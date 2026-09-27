<?php
/**
 * LeafCare AI – Plant Leaf & Fungal Disease Detection System
 * Image Upload & Detection Processor (Backend Controller)
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ai_detector.php';

header('Content-Type: application/json; charset=utf-8');

// Ensure uploads directory exists
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

$response = [
    'status' => 'error',
    'message' => 'Invalid request.'
];

try {
    // Only accept POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Method Not Allowed. Please submit via POST.');
    }

    $savedFilePath = null;
    $clientFileName = '';

    // ==========================================
    // Case 1: Pre-packaged Sample Leaf Testing
    // ==========================================
    if (isset($_POST['sample_id']) && !empty($_POST['sample_id'])) {
        $sampleId = preg_replace('/[^a-zA-Z0-9_\-]/', '', $_POST['sample_id']);
        $samplePath = SAMPLE_DIR . $sampleId . '.svg';
        
        // Also check .jpg/.png if available
        if (!file_exists($samplePath)) {
            $samplePath = SAMPLE_DIR . $sampleId . '.jpg';
        }
        if (!file_exists($samplePath)) {
            $samplePath = SAMPLE_DIR . $sampleId . '.png';
        }

        if (!file_exists($samplePath)) {
            throw new Exception('Selected sample leaf was not found on server.');
        }

        // Copy sample into uploads for persistent history tracking
        $newFilename = 'sample_' . $sampleId . '_' . time() . '.' . pathinfo($samplePath, PATHINFO_EXTENSION);
        $targetPath = UPLOAD_DIR . $newFilename;
        copy($samplePath, $targetPath);
        $savedFilePath = $targetPath;
        $clientFileName = $sampleId;
    }
    // ==========================================
    // Case 2: Camera Capture (Base64 Data URI)
    // ==========================================
    elseif (isset($_POST['camera_data']) && !empty($_POST['camera_data'])) {
        $dataUri = $_POST['camera_data'];
        if (!preg_match('/^data:image\/(jpeg|png|webp);base64,/', $dataUri, $matches)) {
            throw new Exception('Invalid camera snapshot image format.');
        }

        $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
        $base64Data = substr($dataUri, strpos($dataUri, ',') + 1);
        $decodedData = base64_decode($base64Data);

        if ($decodedData === false) {
            throw new Exception('Failed to decode camera snapshot image.');
        }

        if (strlen($decodedData) > MAX_FILE_SIZE) {
            throw new Exception('Camera image exceeds the 10MB file limit.');
        }

        $randomHex = bin2hex(random_bytes(10));
        $newFilename = 'camera_' . $randomHex . '_' . time() . '.' . $extension;
        $targetPath = UPLOAD_DIR . $newFilename;

        if (file_put_contents($targetPath, $decodedData) === false) {
            throw new Exception('Failed to save camera snapshot to uploads directory.');
        }

        // Validate image integrity with getimagesize
        $imgCheck = @getimagesize($targetPath);
        if ($imgCheck === false) {
            @unlink($targetPath);
            throw new Exception('Camera capture is corrupted or not a valid image.');
        }

        $savedFilePath = $targetPath;
        $clientFileName = 'Webcam_Capture_' . date('His') . '.' . $extension;
    }
    // ==========================================
    // Case 3: File Upload (Drag & Drop or File Input)
    // ==========================================
    elseif (isset($_FILES['leaf_image'])) {
        $file = $_FILES['leaf_image'];

        // Validate upload error codes
        if ($file['error'] !== UPLOAD_ERR_OK) {
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new Exception('The uploaded file exceeds the allowed file size limit.');
                case UPLOAD_ERR_PARTIAL:
                    throw new Exception('The file was only partially uploaded.');
                case UPLOAD_ERR_NO_FILE:
                    throw new Exception('No leaf photo was selected.');
                default:
                    throw new Exception('An error occurred during file upload. Error code: ' . $file['error']);
            }
        }

        // Validate file size
        if ($file['size'] > MAX_FILE_SIZE) {
            throw new Exception('Image is too large! Maximum allowed size is 10MB.');
        }

        if ($file['size'] < 1024) { // Less than 1KB
            throw new Exception('Uploaded file appears to be empty or corrupted.');
        }

        // Validate file extension
        $origName = $file['name'];
        $clientFileName = $origName;
        $extension = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

        if (!in_array($extension, ALLOWED_EXTENSIONS, true)) {
            throw new Exception('Invalid file format (' . htmlspecialchars($extension) . '). Only JPG, PNG, and WEBP images are supported.');
        }

        // Validate MIME type with PHP Fileinfo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedMime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($detectedMime, ALLOWED_MIMES, true)) {
            throw new Exception('Security validation failed: File MIME type (' . htmlspecialchars($detectedMime) . ') is not an allowed image.');
        }

        // Validate image dimensions and header structure
        $imgInfo = @getimagesize($file['tmp_name']);
        if ($imgInfo === false) {
            throw new Exception('Corrupted or invalid image file. Please upload a clear photo of a plant leaf.');
        }

        // Generate unique cryptographically safe filename
        $randomHex = bin2hex(random_bytes(10));
        $newFilename = 'leaf_' . $randomHex . '_' . time() . '.' . $extension;
        $targetPath = UPLOAD_DIR . $newFilename;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new Exception('Failed to save uploaded image. Check directory permissions.');
        }

        $savedFilePath = $targetPath;
    } else {
        throw new Exception('No image provided. Please upload or take a photo of a plant leaf.');
    }

    // ==========================================
    // Run AI / Disease Detection
    // ==========================================
    $plantHint = $_POST['plant_hint'] ?? null;
    $detectionResult = detectLeafDisease($savedFilePath, $plantHint);

    if (!isset($detectionResult['status']) || $detectionResult['status'] !== 'success') {
        throw new Exception($detectionResult['message'] ?? 'AI Detection failed to classify the leaf.');
    }

    // Web-accessible image path
    $relativeImagePath = 'uploads/' . basename($savedFilePath);
    $detectionResult['image_url'] = $relativeImagePath;
    $detectionResult['original_filename'] = $clientFileName;

    // ==========================================
    // Save to Database (or Session fallback)
    // ==========================================
    $recordSavedToDb = false;

    if ($db_connected && $pdo) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO `detection_history` 
                (`image_path`, `plant_name`, `disease_name`, `disease_type`, `confidence`, `severity`, `notes`, `detection_date`) 
                VALUES (:image_path, :plant_name, :disease_name, :disease_type, :confidence, :severity, :notes, NOW())
            ");
            $stmt->execute([
                ':image_path'   => $relativeImagePath,
                ':plant_name'   => $detectionResult['plant_name'],
                ':disease_name' => $detectionResult['disease_name'],
                ':disease_type' => $detectionResult['disease_type'],
                ':confidence'   => $detectionResult['confidence'],
                ':severity'     => $detectionResult['severity'],
                ':notes'        => $detectionResult['symptoms']
            ]);
            $recordSavedToDb = true;
            $detectionResult['history_id'] = $pdo->lastInsertId();
        } catch (PDOException $e) {
            $recordSavedToDb = false;
        }
    }

    // Always maintain in PHP Session so users without MySQL can still view their session history!
    if (!isset($_SESSION['detection_history'])) {
        $_SESSION['detection_history'] = [];
    }
    array_unshift($_SESSION['detection_history'], [
        'id' => time(),
        'image_path' => $relativeImagePath,
        'plant_name' => $detectionResult['plant_name'],
        'disease_name' => $detectionResult['disease_name'],
        'disease_type' => $detectionResult['disease_type'],
        'confidence' => $detectionResult['confidence'],
        'severity' => $detectionResult['severity'],
        'notes' => $detectionResult['symptoms'],
        'detection_date' => date('Y-m-d H:i:s')
    ]);

    $detectionResult['db_saved'] = $recordSavedToDb;

    $response = [
        'status' => 'success',
        'data' => $detectionResult
    ];

} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
