<?php
/**
 * LeafCare AI – Plant Leaf & Fungal Disease Detection System
 * About & Technology Architecture Page (about.php)
 */

$pageTitle = "About – LeafCare AI Architecture & Methodology";
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container" style="padding-bottom: 5rem;">
    <!-- Page Hero Header -->
    <div class="about-hero">
        <span class="section-tag">Project Documentation &amp; Vision</span>
        <h1 class="section-title">About LeafCare AI</h1>
        <p class="section-subtitle">
            An intelligent computer-vision framework developed to bridge the gap between plant pathology research and accessible agricultural diagnostics for sustainable crop management.
        </p>
    </div>

    <!-- Section 1: What LeafCare AI Is & Project Objectives -->
    <div class="about-card">
        <h2 style="margin-bottom: 1.25rem;"><i class="fa-solid fa-bullseye" style="color: var(--color-primary-vibrant);"></i> Project Objectives &amp; Mission</h2>
        <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.75; margin-bottom: 1.5rem;">
            LeafCare AI is engineered as an advanced agricultural assistive system designed for farmers, agronomists, horticulturists, and home gardeners. The primary objective is to enable rapid foliar diagnostics directly in the field, helping detect devastating fungal pathogens before infections spread across entire crops.
        </p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
            <div style="background: var(--bg-page); padding: 1.5rem; border-radius: var(--radius-md); border-left: 4px solid var(--color-primary-accent);">
                <h4 style="margin-bottom: 0.5rem;"><i class="fa-solid fa-clock-fast"></i> Early Interception</h4>
                <p style="font-size: 0.92rem; color: var(--text-secondary);">
                    Identify latent or early-stage foliar blights before extensive necrosis and defoliation cause irreversible yield loss.
                </p>
            </div>
            <div style="background: var(--bg-page); padding: 1.5rem; border-radius: var(--radius-md); border-left: 4px solid var(--color-primary-accent);">
                <h4 style="margin-bottom: 0.5rem;"><i class="fa-solid fa-leaf"></i> Sustainable Bio-Control</h4>
                <p style="font-size: 0.92rem; color: var(--text-secondary);">
                    Prioritize organic remedies (copper hydroxides, biological antagonists like Trichoderma) to minimize chemical pesticide runoff.
                </p>
            </div>
            <div style="background: var(--bg-page); padding: 1.5rem; border-radius: var(--radius-md); border-left: 4px solid var(--color-primary-accent);">
                <h4 style="margin-bottom: 0.5rem;"><i class="fa-solid fa-mobile-screen"></i> Accessible In-Field Tool</h4>
                <p style="font-size: 0.92rem; color: var(--text-secondary);">
                    Ensure responsive mobile-friendly camera capture that operates on low-bandwidth networks in rural farming belts.
                </p>
            </div>
        </div>
    </div>

    <!-- Section 2: How Leaf Detection & Image Analysis Works -->
    <div class="about-card" id="methodology">
        <h2 style="margin-bottom: 1.25rem;"><i class="fa-solid fa-network-wired" style="color: var(--color-primary-vibrant);"></i> How Leaf Image Analysis Works</h2>
        <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.75;">
            Plant disease detection through optical image analysis involves a pipeline of computer vision and deep learning techniques. By examining subtle spectral differences, textural anomalies, and characteristic spore manifestations, the system identifies pathogens with high statistical precision.
        </p>

        <!-- Interactive Visual Pipeline Diagram -->
        <div class="pipeline-diagram">
            <div class="pipeline-node">
                <div class="pipeline-icon-circle"><i class="fa-solid fa-camera"></i></div>
                <strong>1. Image Capture</strong>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">RGB Leaf Photo Input</p>
            </div>
            <div class="pipeline-arrow"><i class="fa-solid fa-arrow-right"></i></div>

            <div class="pipeline-node">
                <div class="pipeline-icon-circle"><i class="fa-solid fa-crop-simple"></i></div>
                <strong>2. Preprocessing</strong>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Normalization &amp; Resize</p>
            </div>
            <div class="pipeline-arrow"><i class="fa-solid fa-arrow-right"></i></div>

            <div class="pipeline-node">
                <div class="pipeline-icon-circle"><i class="fa-solid fa-diagram-project"></i></div>
                <strong>3. CNN Extraction</strong>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Convolutions &amp; Feature Maps</p>
            </div>
            <div class="pipeline-arrow"><i class="fa-solid fa-arrow-right"></i></div>

            <div class="pipeline-node">
                <div class="pipeline-icon-circle"><i class="fa-solid fa-microscope"></i></div>
                <strong>4. Classification</strong>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Softmax Confidence Score</p>
            </div>
            <div class="pipeline-arrow"><i class="fa-solid fa-arrow-right"></i></div>

            <div class="pipeline-node">
                <div class="pipeline-icon-circle"><i class="fa-solid fa-prescription"></i></div>
                <strong>5. Agro-Prescription</strong>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Pathology &amp; Cure Plan</p>
            </div>
        </div>

        <div style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.7;">
            <p style="margin-bottom: 0.75rem;">
                <strong>Key Diagnostic Indicators Examined:</strong>
            </p>
            <ul style="padding-left: 1.5rem; margin-bottom: 1rem;">
                <li><strong>Concentric Target Rings:</strong> Characteristic of <em>Alternaria solani</em> (Early Blight).</li>
                <li><strong>Water-Soaked Margins:</strong> Indicative of oomycete infections like <em>Phytophthora infestans</em> (Late Blight).</li>
                <li><strong>Superficial Mycelial Bloom:</strong> Ash-gray powdery coatings seen in powdery mildew (<em>Erysiphe necator</em>).</li>
                <li><strong>Chlorotic Halos:</strong> Bright yellow borders surrounding bacterial spots (<em>Xanthomonas</em>).</li>
            </ul>
        </div>
    </div>

    <!-- Section 3: Technologies Used -->
    <div class="about-card">
        <h2 style="margin-bottom: 1.25rem;"><i class="fa-solid fa-laptop-code" style="color: var(--color-primary-vibrant);"></i> System Architecture &amp; Technology Stack</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
            
            <div style="background: var(--bg-page); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem;">
                <h4 style="display: flex; align-items: center; gap: 0.5rem; color: var(--color-primary); margin-bottom: 0.5rem;">
                    <i class="fa-brands fa-php" style="font-size: 1.5rem;"></i> PHP 8.2 Backend
                </h4>
                <p style="font-size: 0.9rem; color: var(--text-secondary);">
                    Handles multipart image uploads, cryptographic file sanitization, MIME verification, session management, and modular AI dispatching.
                </p>
            </div>

            <div style="background: var(--bg-page); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem;">
                <h4 style="display: flex; align-items: center; gap: 0.5rem; color: var(--color-primary); margin-bottom: 0.5rem;">
                    <i class="fa-solid fa-database" style="font-size: 1.4rem;"></i> MySQL Database
                </h4>
                <p style="font-size: 0.9rem; color: var(--text-secondary);">
                    Relational storage containing botanical disease taxonomies, treatment protocols, and user scan history logs using PDO prepared statements.
                </p>
            </div>

            <div style="background: var(--bg-page); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem;">
                <h4 style="display: flex; align-items: center; gap: 0.5rem; color: var(--color-primary); margin-bottom: 0.5rem;">
                    <i class="fa-brands fa-js" style="font-size: 1.4rem;"></i> Vanilla ES6 JavaScript
                </h4>
                <p style="font-size: 0.9rem; color: var(--text-secondary);">
                    WebRTC live camera streaming, drag-and-drop file API, asynchronous Fetch API for instant results, real-time library filtering, and dark mode toggling.
                </p>
            </div>

            <div style="background: var(--bg-page); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem;">
                <h4 style="display: flex; align-items: center; gap: 0.5rem; color: var(--color-primary); margin-bottom: 0.5rem;">
                    <i class="fa-brands fa-python" style="font-size: 1.4rem;"></i> AI / ML API Connector
                </h4>
                <p style="font-size: 0.9rem; color: var(--text-secondary);">
                    Pluggable REST architecture ready to interface with PyTorch, TensorFlow, MobileNetV2, or FastAPI backend endpoints.
                </p>
            </div>

        </div>
    </div>

    <!-- Section 4: Connecting a Real Deep Learning Model (Developer Guide) -->
    <div class="about-card">
        <h2 style="margin-bottom: 1.25rem;"><i class="fa-solid fa-plug" style="color: var(--color-primary-vibrant);"></i> Connecting a Real Machine Learning Model</h2>
        <p style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.7; margin-bottom: 1.25rem;">
            For academic demonstration, this prototype operates with an intelligent simulated botanical engine. To connect an actual Convolutional Neural Network (trained on PlantVillage or a custom dataset):
        </p>
        <div style="background: var(--bg-page); padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); font-family: monospace; font-size: 0.9rem; color: var(--text-primary); margin-bottom: 1.25rem;">
            // 1. In config.php, enable live API mode:<br>
            define('AI_MODE', 'api');<br>
            define('AI_API_ENDPOINT', 'http://127.0.0.1:5000/predict');<br><br>
            // 2. In your Python Flask / FastAPI script, expose an endpoint returning JSON:<br>
            {<br>
            &nbsp;&nbsp;"status": "success",<br>
            &nbsp;&nbsp;"plant": "Tomato",<br>
            &nbsp;&nbsp;"disease": "Early Blight",<br>
            &nbsp;&nbsp;"confidence": 95.4<br>
            }
        </div>
        <p style="font-size: 0.9rem; color: var(--text-secondary);">
            The PHP detection engine in <a href="file:///C:/Users/NITHESH%20SHETTY/.gemini/antigravity/scratch/LeafCare-AI/ai_detector.php"><code>ai_detector.php</code></a> automatically forwards the uploaded image via cURL and parses the returned prediction.
        </p>
    </div>

    <!-- Section 5: Professional Agricultural Disclaimer -->
    <div class="about-card" id="disclaimer" style="border-left: 6px solid var(--color-earth-gold);">
        <h3 style="display: flex; align-items: center; gap: 0.75rem; color: #d84315; margin-bottom: 0.75rem;">
            <i class="fa-solid fa-triangle-exclamation"></i> Agricultural &amp; Medical Disclaimer
        </h3>
        <p style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.7;">
            LeafCare AI is an automated diagnostic decision-support system intended for educational, prototype, and preliminary screening purposes. Visual manifestations of plant stress can be confounded by abiotic factors such as drought stress, nutrient imbalances (e.g. nitrogen deficiency, blossom end rot), pesticide phytotoxicity, and soil pH variances. 
            Before applying toxic chemical sprays or making commercial decisions, always consult certified agronomists or your local government agricultural extension services.
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
