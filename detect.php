<?php
/**
 * LeafCare AI – Plant Leaf & Fungal Disease Detection System
 * Main Leaf Detection Page (detect.php)
 */

$pageTitle = "Leaf Detection – Analyze Foliar Health & Pathogens";
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container detect-container">
    <!-- Header -->
    <div class="detect-header">
        <span class="section-tag">AI Pathology Diagnostics</span>
        <h1 class="section-title">Plant Leaf Diagnostic Scanner</h1>
        <p class="section-subtitle">
            Upload an image, snap a photo with your camera, or select a botanical sample to identify diseases and receive immediate treatment protocols.
        </p>
    </div>

    <!-- Main Detection Card Layout -->
    <div class="detect-layout">
        
        <!-- Input Method Tabs (Upload vs Camera) -->
        <div class="detection-tabs">
            <button id="tab-upload" class="detect-tab-btn active" type="button">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Upload Leaf Photo</span>
            </button>
            <button id="tab-camera" class="detect-tab-btn" type="button">
                <i class="fa-solid fa-camera"></i>
                <span>Take Photo (Camera)</span>
            </button>
        </div>

        <!-- Section 1: Drag & Drop Upload Dropzone -->
        <div id="upload-area-section">
            <div id="leaf-dropzone" class="dropzone" role="button" tabindex="0" aria-label="Drop leaf image here or click to browse">
                <div class="dropzone-icon-box">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>
                <h3 class="dropzone-title">Drag &amp; Drop leaf photo here</h3>
                <p class="dropzone-subtext">or click anywhere in this area to browse from your device</p>
                
                <button type="button" class="btn btn-primary" onclick="event.stopPropagation(); document.getElementById('leaf-file-input').click();">
                    <i class="fa-solid fa-folder-open"></i>
                    <span>Choose Leaf Photo</span>
                </button>

                <div class="dropzone-limits" style="margin-top: 1.25rem;">
                    Supported Formats: JPG, PNG, WEBP &bull; Max File Size: 10MB
                </div>
            </div>

            <!-- Hidden File Input -->
            <input type="file" id="leaf-file-input" class="visually-hidden" accept="image/jpeg,image/png,image/webp">
        </div>

        <!-- Section 2: Live Camera Capture Area -->
        <div id="camera-area-section" class="camera-wrapper">
            <h4 style="margin-bottom: 1rem;"><i class="fa-solid fa-video"></i> Align Leaf in Center of Camera</h4>
            <div class="camera-video-container">
                <video id="camera-stream" autoplay playsinline></video>
                <div class="scanner-line"></div>
                <div class="scanner-crosshair tl"></div>
                <div class="scanner-crosshair tr"></div>
                <div class="scanner-crosshair bl"></div>
                <div class="scanner-crosshair br"></div>
            </div>
            <div class="camera-controls">
                <button id="camera-snap-btn" class="btn btn-primary btn-lg" type="button">
                    <i class="fa-solid fa-circle-dot"></i>
                    <span>Capture Leaf Snapshot</span>
                </button>
            </div>
            <!-- Hidden Canvas for frame processing -->
            <canvas id="camera-canvas" class="visually-hidden"></canvas>
        </div>

        <!-- Quick Botanical Sample Leaves Picker (Instant One-Click Testing) -->
        <div class="samples-picker-section">
            <h4 class="samples-picker-title">
                <i class="fa-solid fa-flask-vial"></i>
                <span>Don't have a leaf handy? Try a pre-loaded sample:</span>
            </h4>
            <div class="samples-grid">
                <!-- Sample 1 -->
                <div class="sample-chip" data-sample-id="tomato_early_blight" data-sample-name="Tomato Early Blight">
                    <img src="images/samples/tomato_early_blight.svg" alt="Tomato Early Blight">
                    <span>Tomato Blight</span>
                    <small>Early Blight (Fungal)</small>
                </div>
                <!-- Sample 2 -->
                <div class="sample-chip" data-sample-id="potato_late_blight" data-sample-name="Potato Late Blight">
                    <img src="images/samples/potato_late_blight.svg" alt="Potato Late Blight">
                    <span>Potato Blight</span>
                    <small>Late Blight (Oomycete)</small>
                </div>
                <!-- Sample 3 -->
                <div class="sample-chip" data-sample-id="grape_powdery_mildew" data-sample-name="Grape Powdery Mildew">
                    <img src="images/samples/grape_powdery_mildew.svg" alt="Grape Powdery Mildew">
                    <span>Grape Mildew</span>
                    <small>Powdery Mildew</small>
                </div>
                <!-- Sample 4 -->
                <div class="sample-chip" data-sample-id="apple_scab" data-sample-name="Apple Scab">
                    <img src="images/samples/apple_scab.svg" alt="Apple Scab">
                    <span>Apple Scab</span>
                    <small>Foliar Lesions</small>
                </div>
                <!-- Sample 5 -->
                <div class="sample-chip" data-sample-id="corn_northern_blight" data-sample-name="Corn Northern Blight">
                    <img src="images/samples/corn_northern_blight.svg" alt="Corn Northern Blight">
                    <span>Corn Blight</span>
                    <small>Northern Leaf Blight</small>
                </div>
                <!-- Sample 6 -->
                <div class="sample-chip" data-sample-id="healthy_tomato" data-sample-name="Healthy Leaf">
                    <img src="images/samples/healthy_tomato.svg" alt="Healthy Leaf">
                    <span>Healthy Leaf</span>
                    <small>Pathogen Free</small>
                </div>
            </div>
        </div>

        <!-- Section 3: Image Preview & Pre-Analysis Confirmation -->
        <div id="preview-card" class="preview-card">
            <div class="preview-grid">
                <div class="preview-image-box">
                    <img id="preview-img" src="" alt="Staged Leaf Preview">
                </div>
                <div class="preview-details">
                    <span class="badge badge-info" style="margin-bottom: 0.75rem;">Ready for Diagnostics</span>
                    <h4 id="preview-filename">leaf_image.jpg</h4>
                    <p id="preview-meta" class="preview-meta">Image dimensions: 1200x800 &bull; Ready</p>
                    
                    <div class="preview-actions">
                        <button id="analyze-leaf-btn" class="btn btn-primary btn-lg btn-pulse" type="button">
                            <i class="fa-solid fa-microscope"></i>
                            <span>Analyze Leaf</span>
                        </button>
                        <button id="reset-upload-btn" class="btn btn-secondary" type="button">
                            <i class="fa-solid fa-trash-can"></i>
                            <span>Change Photo</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Loading & Scanning Progress Card -->
        <div id="analysis-progress-card" class="analysis-progress-card">
            <div class="scanner-loader"></div>
            <h3 id="progress-step-text" class="progress-step-text">Preprocessing &amp; normalizing leaf image...</h3>
            <p class="progress-subtext">LeafCare AI is scanning for fungal spores, necrotic lesions, and chlorosis...</p>
        </div>

        <!-- Section 5: Diagnostic Results Card -->
        <div id="result-card" class="result-card">
            <!-- Header bar with mode badge -->
            <div class="result-header-bar">
                <div class="result-status-tag">
                    <i class="fa-solid fa-circle-check"></i>
                    <span id="res-mode-badge">Analysis Complete</span>
                </div>
                <div class="result-header-actions">
                    <button id="print-report-btn" class="btn btn-secondary btn-sm" type="button" title="Print diagnosis or export to PDF">
                        <i class="fa-solid fa-print"></i>
                        <span>Print Report</span>
                    </button>
                </div>
            </div>

            <!-- Top Result Section (Image, Identification, Confidence Dial) -->
            <div class="result-top-grid">
                <div class="result-image-box">
                    <img id="result-image" src="" alt="Analyzed Leaf">
                </div>

                <div class="result-title-group">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--color-primary-vibrant); text-transform: uppercase;">
                        Pathological Classification
                    </span>
                    <h2 id="res-disease-name">Early Blight</h2>
                    <p id="res-plant-name" style="font-size: 1.25rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 2px;">Tomato Plant</p>
                    <p id="res-scientific-name" class="result-scientific-name">Scientific: Solanum lycopersicum</p>

                    <div class="result-badges-row">
                        <span id="res-severity-badge" class="badge badge-severe">Moderate</span>
                        <span id="res-type-badge" class="badge badge-info">Fungal</span>
                        <span class="badge badge-tech"><i class="fa-solid fa-circle-nodes"></i> Verified Pathology</span>
                    </div>
                </div>

                <div class="confidence-gauge-box">
                    <div id="res-confidence-val" class="confidence-val">94.8%</div>
                    <div class="confidence-label">Confidence Score</div>
                    <small style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-top: 0.35rem;">
                        High statistical certainty
                    </small>
                </div>
            </div>

            <!-- Detailed Pathology Information Grids -->
            <div class="pathology-details-grid">
                <!-- Symptoms -->
                <div class="pathology-card">
                    <h4><i class="fa-solid fa-triangle-exclamation"></i> Symptoms Observed</h4>
                    <p id="res-symptoms">Concentric target rings and necrotic margins detected on lower foliage with chlorotic yellow surrounding margins.</p>
                </div>

                <!-- Causes -->
                <div class="pathology-card">
                    <h4><i class="fa-solid fa-magnifying-glass"></i> Possible Pathogen Causes</h4>
                    <p id="res-causes">Fungal infection driven by Alternaria solani. Favored by high ambient humidity and prolonged foliage surface wetness.</p>
                </div>

                <!-- Prevention -->
                <div class="pathology-card">
                    <h4><i class="fa-solid fa-shield-halved"></i> Prevention &amp; Cultural Practices</h4>
                    <p id="res-prevention">Practice 3-year crop rotation away from solanaceous plants, water with drip irrigation at ground level, and mulch soil bed.</p>
                </div>

                <!-- Treatment -->
                <div class="pathology-card">
                    <h4><i class="fa-solid fa-notes-medical"></i> Clinical Management</h4>
                    <p id="res-treatment">Prune infected lower foliage immediately and incinerate. Maintain spacing for airflow.</p>
                </div>
            </div>

            <!-- Curated Organic vs Chemical Treatments -->
            <div class="treatment-split-card">
                <div class="treatment-split-header">
                    <i class="fa-solid fa-kit-medical"></i>
                    <span>Recommended Treatment Guidelines</span>
                </div>
                <div class="treatment-split-grid">
                    <div class="treatment-sub-box">
                        <h5><i class="fa-solid fa-leaf" style="color: var(--color-primary-accent);"></i> Eco-Friendly &amp; Organic Remedies</h5>
                        <p id="res-organic-treatment">Apply certified organic copper hydroxide, cold-pressed Neem oil spray (0.5%), or Bacillus subtilis biological suspension every 7-10 days.</p>
                    </div>
                    <div class="treatment-sub-box chemical">
                        <h5><i class="fa-solid fa-flask" style="color: var(--color-warning);"></i> Conventional Agricultural Chemical Options</h5>
                        <p id="res-chemical-treatment">Apply Mancozeb, Chlorothalonil, or Azoxystrobin following strict label withholding periods and dosage instructions.</p>
                    </div>
                </div>
            </div>

            <!-- Result Actions -->
            <div class="result-footer-actions">
                <button id="detect-another-btn" class="btn btn-primary" type="button">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                    <span>Detect Another Leaf</span>
                </button>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="diseases.php" class="btn btn-secondary">
                        <i class="fa-solid fa-book-medical"></i>
                        <span>Explore Disease Library</span>
                    </a>
                    <a href="history.php" class="btn btn-secondary">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>View Scan History</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
