/**
 * LeafCare AI – Plant Leaf & Fungal Disease Detection System
 * Frontend Interactions, Camera Capture, Drag & Drop, AJAX Processing & Filtering
 */

document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
    initMobileNav();
    initBackToTop();
    initFAQAccordion();
    initDetectionModule();
    initDiseasesFilter();
    initDiseaseModal();
});

/* ==========================================================================
   1. Theme Toggle (Dark / Light Mode)
   ========================================================================== */
function initThemeToggle() {
    const themeBtn = document.getElementById('theme-toggle-btn');
    if (!themeBtn) return;

    // Check stored preference or system preference
    const savedTheme = localStorage.getItem('leafcare_theme') || 'light';
    applyTheme(savedTheme);

    themeBtn.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        applyTheme(newTheme);
        localStorage.setItem('leafcare_theme', newTheme);
        showToast(`Switched to ${newTheme === 'dark' ? 'Dark' : 'Light'} Mode`, 'info');
    });
}

function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    const themeBtn = document.getElementById('theme-toggle-btn');
    if (!themeBtn) return;
    
    if (theme === 'dark') {
        themeBtn.innerHTML = '<i class="fa-solid fa-sun"></i>';
        themeBtn.setAttribute('title', 'Switch to Light Mode');
    } else {
        themeBtn.innerHTML = '<i class="fa-solid fa-moon"></i>';
        themeBtn.setAttribute('title', 'Switch to Dark Mode');
    }
}

/* ==========================================================================
   2. Mobile Navigation Drawer
   ========================================================================== */
function initMobileNav() {
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const drawer = document.getElementById('mobile-nav-drawer');
    if (!mobileBtn || !drawer) return;

    mobileBtn.addEventListener('click', () => {
        const isOpen = drawer.classList.toggle('open');
        mobileBtn.setAttribute('aria-expanded', isOpen);
    });
}

/* ==========================================================================
   3. Back to Top Button
   ========================================================================== */
function initBackToTop() {
    const btn = document.getElementById('back-to-top');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 350) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    });

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

/* ==========================================================================
   4. FAQ Accordion
   ========================================================================== */
function initFAQAccordion() {
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const questionBtn = item.querySelector('.faq-question');
        if (!questionBtn) return;

        questionBtn.addEventListener('click', () => {
            const isOpen = item.classList.contains('open');
            // Close other items
            faqItems.forEach(other => other.classList.remove('open'));
            if (!isOpen) {
                item.classList.add('open');
            }
        });
    });
}

/* ==========================================================================
   5. Leaf Detection & Analysis Module (detect.php)
   ========================================================================== */
let activeVideoStream = null;
let stagedFile = null;
let stagedCameraData = null;
let stagedSampleId = null;

function initDetectionModule() {
    const dropzone = document.getElementById('leaf-dropzone');
    const fileInput = document.getElementById('leaf-file-input');
    const analyzeBtn = document.getElementById('analyze-leaf-btn');
    const resetBtn = document.getElementById('reset-upload-btn');
    const detectAnotherBtn = document.getElementById('detect-another-btn');
    const printReportBtn = document.getElementById('print-report-btn');

    // Tab buttons
    const tabUpload = document.getElementById('tab-upload');
    const tabCamera = document.getElementById('tab-camera');
    const uploadArea = document.getElementById('upload-area-section');
    const cameraArea = document.getElementById('camera-area-section');

    if (!dropzone && !fileInput) return; // Not on detect.php

    // --- Tab Switching ---
    if (tabUpload && tabCamera && uploadArea && cameraArea) {
        tabUpload.addEventListener('click', () => {
            tabUpload.classList.add('active');
            tabCamera.classList.remove('active');
            uploadArea.style.display = 'block';
            cameraArea.classList.remove('active');
            stopCameraStream();
        });

        tabCamera.addEventListener('click', () => {
            tabCamera.classList.add('active');
            tabUpload.classList.remove('active');
            uploadArea.style.display = 'none';
            cameraArea.classList.add('active');
            startCameraStream();
        });
    }

    // --- Drag and Drop Events ---
    if (dropzone && fileInput) {
        dropzone.addEventListener('click', () => fileInput.click());

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('dragover');
            });
        });

        dropzone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files && files.length > 0) {
                handleSelectedFile(files[0]);
            }
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files && e.target.files.length > 0) {
                handleSelectedFile(e.target.files[0]);
            }
        });
    }

    // --- Camera Snapshot Handler ---
    const snapBtn = document.getElementById('camera-snap-btn');
    const videoElem = document.getElementById('camera-stream');
    const cameraCanvas = document.getElementById('camera-canvas');

    if (snapBtn && videoElem && cameraCanvas) {
        snapBtn.addEventListener('click', () => {
            if (!activeVideoStream) {
                showToast('Camera is not active or permission was denied.', 'warning');
                return;
            }
            const context = cameraCanvas.getContext('2d');
            cameraCanvas.width = videoElem.videoWidth || 640;
            cameraCanvas.height = videoElem.videoHeight || 480;
            context.drawImage(videoElem, 0, 0, cameraCanvas.width, cameraCanvas.height);
            
            const dataUri = cameraCanvas.toDataURL('image/jpeg', 0.92);
            stagedCameraData = dataUri;
            stagedFile = null;
            stagedSampleId = null;

            displayImagePreview(dataUri, 'Live Camera Snapshot (' + new Date().toLocaleTimeString() + ')', 'Snapshot ready for diagnosis');
            stopCameraStream();

            // Switch view back to upload/preview
            if (tabUpload && tabCamera && uploadArea && cameraArea) {
                tabUpload.classList.add('active');
                tabCamera.classList.remove('active');
                uploadArea.style.display = 'block';
                cameraArea.classList.remove('active');
            }
            showToast('Photo captured successfully! Click Analyze Leaf.', 'success');
        });
    }

    // --- Sample Leaf Quick Picker ---
    const sampleChips = document.querySelectorAll('.sample-chip');
    sampleChips.forEach(chip => {
        chip.addEventListener('click', () => {
            const sampleId = chip.getAttribute('data-sample-id');
            const sampleName = chip.getAttribute('data-sample-name') || sampleId;
            const imgSrc = chip.querySelector('img, svg').getAttribute('src');

            stagedSampleId = sampleId;
            stagedFile = null;
            stagedCameraData = null;

            displayImagePreview(imgSrc, sampleName, 'Demonstration Botanical Sample');
            showToast(`Loaded sample: ${sampleName}`, 'success');
        });
    });

    // --- Reset / Clear Staged Image ---
    if (resetBtn) {
        resetBtn.addEventListener('click', clearStagedImage);
    }
    if (detectAnotherBtn) {
        detectAnotherBtn.addEventListener('click', () => {
            clearStagedImage();
            window.scrollTo({ top: 120, behavior: 'smooth' });
        });
    }

    // --- Print / Export Report ---
    if (printReportBtn) {
        printReportBtn.addEventListener('click', () => {
            window.print();
        });
    }

    // --- Analyze Leaf Button (AJAX Submit) ---
    if (analyzeBtn) {
        analyzeBtn.addEventListener('click', () => {
            submitLeafAnalysis();
        });
    }
}

/**
 * Handle user file selection from drag-and-drop or browse input
 */
function handleSelectedFile(file) {
    // Validate file type
    const validExtensions = ['image/jpeg', 'image/png', 'image/webp'];
    if (!validExtensions.includes(file.type)) {
        showToast('Invalid file format. Please upload a JPG, PNG, or WEBP photo.', 'error');
        return;
    }

    // Validate size (10MB limit)
    if (file.size > 10 * 1024 * 1024) {
        showToast('Image size exceeds 10MB limit. Please choose a smaller photo.', 'error');
        return;
    }

    stagedFile = file;
    stagedCameraData = null;
    stagedSampleId = null;

    const reader = new FileReader();
    reader.onload = (e) => {
        const sizeFormatted = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
        displayImagePreview(e.target.result, file.name, `File Size: ${sizeFormatted}`);
    };
    reader.readAsDataURL(file);
}

/**
 * Render image preview card
 */
function displayImagePreview(src, filename, meta) {
    const previewCard = document.getElementById('preview-card');
    const previewImg = document.getElementById('preview-img');
    const previewName = document.getElementById('preview-filename');
    const previewMeta = document.getElementById('preview-meta');
    const resultCard = document.getElementById('result-card');

    if (!previewCard || !previewImg) return;

    previewImg.src = src;
    if (previewName) previewName.textContent = filename;
    if (previewMeta) previewMeta.textContent = meta;

    previewCard.style.display = 'block';
    if (resultCard) resultCard.style.display = 'none';

    previewCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

/**
 * Reset preview and clear all staged files
 */
function clearStagedImage() {
    stagedFile = null;
    stagedCameraData = null;
    stagedSampleId = null;

    const fileInput = document.getElementById('leaf-file-input');
    if (fileInput) fileInput.value = '';

    const previewCard = document.getElementById('preview-card');
    if (previewCard) previewCard.style.display = 'none';

    const resultCard = document.getElementById('result-card');
    if (resultCard) resultCard.style.display = 'none';

    const progressCard = document.getElementById('analysis-progress-card');
    if (progressCard) progressCard.style.display = 'none';

    stopCameraStream();
}

/**
 * Start webcam video stream using WebRTC
 */
async function startCameraStream() {
    const videoElem = document.getElementById('camera-stream');
    if (!videoElem) return;

    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: { ideal: 'environment' } },
            audio: false
        });
        activeVideoStream = stream;
        videoElem.srcObject = stream;
        videoElem.play();
    } catch (err) {
        showToast('Could not access camera: ' + err.message, 'error');
    }
}

/**
 * Stop active camera video stream
 */
function stopCameraStream() {
    if (activeVideoStream) {
        activeVideoStream.getTracks().forEach(track => track.stop());
        activeVideoStream = null;
    }
}

/**
 * Submit leaf photo to process.php via AJAX FormData
 */
async function submitLeafAnalysis() {
    if (!stagedFile && !stagedCameraData && !stagedSampleId) {
        showToast('Please select or capture a leaf photo first!', 'warning');
        return;
    }

    const previewCard = document.getElementById('preview-card');
    const progressCard = document.getElementById('analysis-progress-card');
    const resultCard = document.getElementById('result-card');
    const progressStep = document.getElementById('progress-step-text');

    if (previewCard) previewCard.style.display = 'none';
    if (resultCard) resultCard.style.display = 'none';
    if (progressCard) progressCard.style.display = 'block';

    // Simulated progress steps for engaging UX
    const steps = [
        'Preprocessing & normalizing leaf image...',
        'Segmenting foliar contours & chlorophyll index...',
        'Scanning for necrotic lesions & fungal spore colonies...',
        'Consulting AI botanical pathology database...'
    ];

    let currentStep = 0;
    const progressInterval = setInterval(() => {
        currentStep = (currentStep + 1) % steps.length;
        if (progressStep) progressStep.textContent = steps[currentStep];
    }, 450);

    const formData = new FormData();
    if (stagedSampleId) {
        formData.append('sample_id', stagedSampleId);
    } else if (stagedCameraData) {
        formData.append('camera_data', stagedCameraData);
    } else if (stagedFile) {
        formData.append('leaf_image', stagedFile);
    }

    try {
        const response = await fetch('process.php', {
            method: 'POST',
            body: formData
        });

        clearInterval(progressInterval);

        const data = await response.json();

        if (data.status !== 'success') {
            throw new Error(data.message || 'Detection failed. Please try another image.');
        }

        renderDiagnosticResult(data.data);
        showToast('Leaf analysis complete! Disease identified.', 'success');

    } catch (err) {
        clearInterval(progressInterval);
        if (progressCard) progressCard.style.display = 'none';
        if (previewCard) previewCard.style.display = 'block';
        showToast(err.message, 'error');
    }
}

/**
 * Populate and display result card
 */
function renderDiagnosticResult(res) {
    const progressCard = document.getElementById('analysis-progress-card');
    const resultCard = document.getElementById('result-card');
    if (progressCard) progressCard.style.display = 'none';
    if (!resultCard) return;

    // 1. Image
    const resImg = document.getElementById('result-image');
    if (resImg) resImg.src = res.image_url;

    // 2. Titles
    const plantTitle = document.getElementById('res-plant-name');
    if (plantTitle) plantTitle.textContent = res.plant_name || res.plant;

    const scientificTitle = document.getElementById('res-scientific-name');
    if (scientificTitle) scientificTitle.textContent = res.scientific_name ? `Scientific: ${res.scientific_name}` : '';

    const diseaseTitle = document.getElementById('res-disease-name');
    if (diseaseTitle) diseaseTitle.textContent = res.disease_name || res.disease;

    // 3. Badges
    const severityBadge = document.getElementById('res-severity-badge');
    if (severityBadge) {
        severityBadge.textContent = res.severity;
        severityBadge.className = 'badge ' + getSeverityClass(res.severity);
    }

    const typeBadge = document.getElementById('res-type-badge');
    if (typeBadge) {
        typeBadge.textContent = res.disease_type || 'Fungal';
    }

    // 4. Confidence Gauge
    const confidenceVal = document.getElementById('res-confidence-val');
    if (confidenceVal) {
        confidenceVal.textContent = (res.confidence || 95.0) + '%';
    }

    // 5. Mode info
    const modeBadge = document.getElementById('res-mode-badge');
    if (modeBadge) {
        modeBadge.textContent = res.mode_label || (res.mode === 'api' ? 'Live AI Model' : 'Demo / Simulated Mode');
    }

    // 6. Pathology Details
    const symptomsEl = document.getElementById('res-symptoms');
    if (symptomsEl) symptomsEl.textContent = res.symptoms;

    const causesEl = document.getElementById('res-causes');
    if (causesEl) causesEl.textContent = res.causes;

    const preventionEl = document.getElementById('res-prevention');
    if (preventionEl) preventionEl.textContent = res.prevention;

    const treatmentEl = document.getElementById('res-treatment');
    if (treatmentEl) treatmentEl.textContent = res.treatment;

    const organicEl = document.getElementById('res-organic-treatment');
    if (organicEl) organicEl.textContent = res.organic_treatment || 'Apply organic neem oil spray or Bacillus subtilis bio-fungicide.';

    const chemicalEl = document.getElementById('res-chemical-treatment');
    if (chemicalEl) chemicalEl.textContent = res.chemical_treatment || 'Apply copper-based fungicides or mancozeb as per agricultural extension guidelines.';

    resultCard.style.display = 'block';
    resultCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function getSeverityClass(sev) {
    if (!sev) return 'badge-info';
    const s = sev.toLowerCase().trim();
    if (s === 'critical' || s === 'severe') return 'badge-severe';
    if (s === 'moderate') return 'badge-moderate';
    if (s === 'mild' || s === 'low') return 'badge-mild';
    if (s === 'healthy') return 'badge-healthy';
    return 'badge-info';
}

/* ==========================================================================
   6. Diseases Library Filtering & Search (diseases.php)
   ========================================================================== */
function initDiseasesFilter() {
    const searchInput = document.getElementById('disease-search-input');
    const filterPills = document.querySelectorAll('.filter-pill');
    const diseaseCards = document.querySelectorAll('.disease-card');

    if (!searchInput && filterPills.length === 0) return;

    let activeFilter = 'all';

    // Search input handler
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            filterCards();
        });
    }

    // Filter pill click handlers
    filterPills.forEach(pill => {
        pill.addEventListener('click', () => {
            filterPills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            activeFilter = pill.getAttribute('data-filter') || 'all';
            filterCards();
        });
    });

    function filterCards() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

        diseaseCards.forEach(card => {
            const plant = (card.getAttribute('data-plant') || '').toLowerCase();
            const disease = (card.getAttribute('data-disease') || '').toLowerCase();
            const type = (card.getAttribute('data-type') || '').toLowerCase();
            const symptoms = (card.getAttribute('data-symptoms') || '').toLowerCase();

            const matchesQuery = !query || 
                plant.includes(query) || 
                disease.includes(query) || 
                type.includes(query) || 
                symptoms.includes(query);

            let matchesFilter = true;
            if (activeFilter !== 'all') {
                const target = activeFilter.toLowerCase();
                matchesFilter = (type === target || plant.includes(target) || disease.includes(target));
            }

            if (matchesQuery && matchesFilter) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
}

/* ==========================================================================
   7. Disease Details Modal (diseases.php)
   ========================================================================== */
function initDiseaseModal() {
    const modal = document.getElementById('disease-modal');
    const closeBtn = document.getElementById('modal-close-btn');
    if (!modal) return;

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
        });
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    // Delegate open modal buttons
    document.addEventListener('click', (e) => {
        const openBtn = e.target.closest('.view-disease-btn');
        if (!openBtn) return;

        const card = openBtn.closest('.disease-card');
        if (!card) return;

        document.getElementById('modal-plant-name').textContent = card.getAttribute('data-plant');
        document.getElementById('modal-disease-name').textContent = card.getAttribute('data-disease');
        document.getElementById('modal-scientific').textContent = card.getAttribute('data-scientific');
        document.getElementById('modal-symptoms').textContent = card.getAttribute('data-symptoms');
        document.getElementById('modal-causes').textContent = card.getAttribute('data-causes');
        document.getElementById('modal-prevention').textContent = card.getAttribute('data-prevention');
        document.getElementById('modal-treatment').textContent = card.getAttribute('data-treatment');
        document.getElementById('modal-organic').textContent = card.getAttribute('data-organic');
        document.getElementById('modal-chemical').textContent = card.getAttribute('data-chemical');

        const modalImg = document.getElementById('modal-image');
        const cardImg = card.querySelector('.disease-card-media img, .disease-card-media svg');
        if (modalImg && cardImg) {
            modalImg.src = cardImg.getAttribute('src');
        }

        modal.classList.add('active');
    });
}

/* ==========================================================================
   8. Toast Notifications Helper
   ========================================================================== */
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;

    let iconClass = 'fa-circle-check';
    if (type === 'error') iconClass = 'fa-circle-exclamation';
    else if (type === 'warning') iconClass = 'fa-triangle-exclamation';
    else if (type === 'info') iconClass = 'fa-circle-info';

    toast.innerHTML = `
        <i class="fa-solid ${iconClass} toast-icon"></i>
        <span class="toast-msg">${escapeHtml(message)}</span>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

function escapeHtml(str) {
    if (!str) return '';
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
