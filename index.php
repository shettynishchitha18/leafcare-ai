<?php
/**
 * LeafCare AI – Plant Leaf & Fungal Disease Detection System
 * Home Page (index.php)
 */

$pageTitle = "Home – Smart Plant Leaf & Fungal Disease Detection";
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-grid">
            <!-- Left Hero Content -->
            <div class="hero-content">
                <div class="hero-pill-badge">
                    <i class="fa-solid fa-leaf"></i>
                    <span>AI-Powered Botanical Diagnostics</span>
                </div>
                
                <h1 class="hero-title">
                    Identify Your Plant. <br>
                    <span class="text-gradient">Detect Leaf Diseases.</span>
                </h1>

                <p class="hero-description">
                    Diagnose plant health in seconds. Upload or photograph any crop leaf to instantly identify fungal pathogens, analyze lesion severity, and receive organic remedies tailored for sustainable farming.
                </p>

                <div class="hero-cta-group">
                    <a href="detect.php" class="btn btn-primary btn-lg btn-pulse">
                        <i class="fa-solid fa-camera"></i>
                        <span>Start Detection</span>
                    </a>
                    <a href="#how-it-works" class="btn btn-secondary btn-lg">
                        <i class="fa-solid fa-circle-play"></i>
                        <span>Learn More</span>
                    </a>
                </div>

                <div class="hero-trust-row">
                    <div class="trust-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>96%+ Accuracy</span>
                    </div>
                    <div class="trust-item">
                        <i class="fa-solid fa-shield-virus"></i>
                        <span>Early Spore Detection</span>
                    </div>
                    <div class="trust-item">
                        <i class="fa-solid fa-seedling"></i>
                        <span>Eco-Friendly Cures</span>
                    </div>
                </div>
            </div>

            <!-- Right Hero Visual Card -->
            <div class="hero-visual-card">
                <div class="scanner-radar-wrapper">
                    <!-- Botanical preview image -->
                    <img src="images/samples/tomato_early_blight.svg" alt="Tomato Leaf with Early Blight Scanner" id="hero-leaf-preview">
                    
                    <!-- Scanner Laser & Grid Overlay -->
                    <div class="scanner-line"></div>
                    <div class="scanner-crosshair tl"></div>
                    <div class="scanner-crosshair tr"></div>
                    <div class="scanner-crosshair bl"></div>
                    <div class="scanner-crosshair br"></div>

                    <!-- Floating live diagnosis readout -->
                    <div class="floating-detection-badge">
                        <div class="fdb-info">
                            <h5>Tomato Leaf: Early Blight</h5>
                            <p><i class="fa-solid fa-microscope"></i> Fungal Pathogen: Alternaria solani</p>
                        </div>
                        <div class="fdb-confidence">
                            94.8%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Animated Statistics Bar -->
<section class="stats-bar-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">45+</div>
                <div class="stat-label">Crop Diseases Cataloged</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">96.8%</div>
                <div class="stat-label">Model Precision Rate</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">&lt; 1.5s</div>
                <div class="stat-label">Instant Diagnostic Speed</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Free & Accessible AI</div>
            </div>
        </div>
    </div>
</section>

<!-- Core Features Section -->
<section class="section" id="features">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Key Capabilities</span>
            <h2 class="section-title">Engineered for Agricultural Excellence</h2>
            <p class="section-subtitle">
                Combining high-resolution visual processing with deep botanical pathology for dependable crop protection.
            </p>
        </div>

        <div class="features-grid">
            <!-- Feature 1: Plant Identification -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <h3 class="feature-title">🌿 Plant Identification</h3>
                <p class="feature-text">
                    Accurately determines plant species, botanical taxonomy, and family morphology (Solanaceae, Vitaceae, Poaceae) from high-resolution foliage leaf contours.
                </p>
            </div>

            <!-- Feature 2: Fungal Disease Detection -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-microscope"></i>
                </div>
                <h3 class="feature-title">🔬 Fungal Disease Detection</h3>
                <p class="feature-text">
                    Isolates fungal, bacterial, and viral foliar symptoms including early blight, late blight, powdery mildew, anthracnose, scabs, and rust pustules.
                </p>
            </div>

            <!-- Feature 3: Detection Results & Severity -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <h3 class="feature-title">📊 Detection Confidence & Stage</h3>
                <p class="feature-text">
                    Calculates statistical confidence percentages and severity levels (Low, Moderate, Severe, Critical) to guide timely agronomic intervention.
                </p>
            </div>

            <!-- Feature 4: Curated Treatments -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-kit-medical"></i>
                </div>
                <h3 class="feature-title">💊 Dual Organic & Chemical Cures</h3>
                <p class="feature-text">
                    Provides comprehensive treatment plans featuring bio-fungicides (Neem oil, Bacillus subtilis) and synthetic compounds (Copper, Mancozeb).
                </p>
            </div>

            <!-- Feature 5: Instant Camera Access -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-camera-retro"></i>
                </div>
                <h3 class="feature-title">📷 Live In-Field Camera Scan</h3>
                <p class="feature-text">
                    Take high-resolution leaf snapshots directly from your smartphone or laptop webcam while walking through the farm field or greenhouse.
                </p>
            </div>

            <!-- Feature 6: History Tracking -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <h3 class="feature-title">📜 Diagnostic History Log</h3>
                <p class="feature-text">
                    Archived scans let you monitor symptom progression, verify therapeutic recovery, and build a personalized agricultural disease log.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works (Workflow Steps) -->
<section class="section" id="how-it-works" style="background: var(--bg-surface-elevated); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Simple Diagnostic Workflow</span>
            <h2 class="section-title">How LeafCare AI Works</h2>
            <p class="section-subtitle">
                From leaf capture to actionable pathology report in 4 intuitive steps.
            </p>
        </div>

        <div class="workflow-grid">
            <div class="workflow-card">
                <div class="step-number">1</div>
                <div class="step-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                <h4 class="step-title">Upload or Snap Photo</h4>
                <p class="step-text">Drag-and-drop a leaf image or take a snapshot with your device camera.</p>
            </div>

            <div class="workflow-card">
                <div class="step-number">2</div>
                <div class="step-icon"><i class="fa-solid fa-brain"></i></div>
                <h4 class="step-title">Deep Feature Analysis</h4>
                <p class="step-text">Neural networks inspect color variations, lesions, margins, and concentric target rings.</p>
            </div>

            <div class="workflow-card">
                <div class="step-number">3</div>
                <div class="step-icon"><i class="fa-solid fa-stethoscope"></i></div>
                <h4 class="step-title">Pathogen Identification</h4>
                <p class="step-text">The system matches symptom patterns against verified fungal & botanical datasets.</p>
            </div>

            <div class="workflow-card">
                <div class="step-number">4</div>
                <div class="step-icon"><i class="fa-solid fa-prescription-bottle-medical"></i></div>
                <h4 class="step-title">Receive Treatment Plan</h4>
                <p class="step-text">Access immediate biological preventions, organic sprays, and chemical recommendations.</p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="detect.php" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-arrow-right"></i>
                <span>Try Detection Now</span>
            </a>
        </div>
    </div>
</section>

<!-- Frequently Asked Questions (FAQ) Section -->
<section class="section" id="faq">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Got Questions?</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">
                Everything you need to know about the LeafCare AI platform and diagnostic procedures.
            </p>
        </div>

        <div class="faq-accordion">
            <div class="faq-item open">
                <button class="faq-question">
                    <span>How should I photograph the leaf for highest diagnostic precision?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Place the affected leaf against a plain, neutral background (such as paper, palm of your hand, or dark soil) in balanced natural daylight. Ensure the camera lens is focused directly on visible spots, lesions, or powdery patches without intense glare or motion blur.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>What types of plant diseases can LeafCare AI detect?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    The platform specializes in fungal diseases such as Early Blight, Late Blight, Powdery Mildew, Scab, Black Rot, Leaf Scorch, and Rusts across major crops like Tomato, Potato, Apple, Grape, Maize, and Bell Pepper, as well as distinguishing healthy, non-infected leaves.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Can I connect my own custom Python PyTorch or TensorFlow model?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Yes! LeafCare AI is built with an enterprise-grade modular architecture. Simply set <code>define('AI_MODE', 'api')</code> and specify your API URL in <code>config.php</code>. The backend will forward uploaded images to your inference endpoint and map the classification output into the frontend report.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Are the recommended treatments organic and safe for home gardens?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Yes. Every diagnostic result displays both certified organic interventions (such as Neem oil, copper hydroxide, and bio-control bacteria) alongside standard agricultural fungicides so home growers and commercial farmers can choose their preferred management strategy.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section style="padding: 4rem 0 2rem;">
    <div class="container">
        <div style="background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary)); border-radius: var(--radius-lg); padding: 3.5rem 2.5rem; text-align: center; color: #ffffff; box-shadow: var(--shadow-lg); position: relative; overflow: hidden;">
            <h2 style="color: #ffffff; font-size: 2.4rem; margin-bottom: 1rem;">Ready to Protect Your Crops?</h2>
            <p style="color: #c8e6c9; font-size: 1.15rem; max-width: 600px; margin: 0 auto 2rem;">
                Experience lightning-fast plant pathology diagnosis. Try our pre-loaded sample leaves or upload a leaf photo now.
            </p>
            <a href="detect.php" class="btn btn-primary btn-lg" style="background: #ffffff; color: var(--color-primary-dark); font-weight: 700;">
                <i class="fa-solid fa-leaf"></i>
                <span>Launch Leaf Diagnostic Scanner</span>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
