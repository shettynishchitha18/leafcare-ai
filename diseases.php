<?php
/**
 * LeafCare AI – Plant Leaf & Fungal Disease Detection System
 * Searchable Disease Library Page (diseases.php)
 */

$pageTitle = "Plant & Fungal Diseases Library";
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ai_detector.php';

// Fetch disease list from Database or Fallback to built-in knowledgebase
$diseasesList = [];

if ($db_connected && $pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM diseases ORDER BY plant_name ASC, disease_name ASC");
        $diseasesList = $stmt->fetchAll();
    } catch (Exception $e) {
        $diseasesList = [];
    }
}

// Fallback to built-in dictionary if DB is empty or offline
if (empty($diseasesList)) {
    $kb = getBotanicalKnowledgebase();
    $idCounter = 1;
    foreach ($kb as $key => $item) {
        $diseasesList[] = [
            'id' => $idCounter++,
            'disease_name' => $item['disease'],
            'scientific_name' => $item['scientific_name'] ?? 'Pathogenic Microbe',
            'plant_name' => $item['plant'],
            'disease_type' => $item['disease_type'],
            'severity' => $item['severity'],
            'symptoms' => $item['symptoms'],
            'causes' => $item['causes'],
            'prevention' => $item['prevention'],
            'treatment' => $item['treatment'],
            'organic_treatment' => $item['organic_treatment'] ?? '',
            'chemical_treatment' => $item['chemical_treatment'] ?? '',
            'image' => $key . '.svg'
        ];
    }
}

// Initial search term from GET query parameter if present
$initialSearch = isset($_GET['search']) ? trim($_GET['search']) : '';

require_once __DIR__ . '/includes/header.php';
?>

<div class="container" style="padding-bottom: 5rem;">
    <!-- Page Header -->
    <div class="diseases-header">
        <span class="section-tag">Botanical Pathology Compendium</span>
        <h1 class="section-title">Plant &amp; Fungal Disease Library</h1>
        <p class="section-subtitle">
            Explore detailed pathology profiles, diagnostic indicators, and sustainable management protocols across major agricultural crop species.
        </p>
    </div>

    <!-- Search Box & Filter Chips -->
    <div class="search-filter-wrapper">
        <div class="search-input-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input 
                type="text" 
                id="disease-search-input" 
                class="search-field" 
                placeholder="Search for a plant, disease, or pathogen (e.g., 'Tomato', 'Early Blight', 'Powdery Mildew', 'Scab')..." 
                value="<?php echo safe($initialSearch); ?>"
                autocomplete="off"
            >
        </div>

        <div class="filter-pills-row">
            <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-right: 0.5rem;">Filter:</span>
            <button class="filter-pill active" data-filter="all" type="button">All (<?php echo count($diseasesList); ?>)</button>
            <button class="filter-pill" data-filter="fungal" type="button">Fungal</button>
            <button class="filter-pill" data-filter="bacterial" type="button">Bacterial</button>
            <button class="filter-pill" data-filter="healthy" type="button">Healthy Leaves</button>
            <button class="filter-pill" data-filter="tomato" type="button">Tomato</button>
            <button class="filter-pill" data-filter="potato" type="button">Potato</button>
            <button class="filter-pill" data-filter="grape" type="button">Grape</button>
            <button class="filter-pill" data-filter="apple" type="button">Apple</button>
            <button class="filter-pill" data-filter="corn" type="button">Corn</button>
        </div>
    </div>

    <!-- Disease Cards Grid -->
    <div class="diseases-grid" id="diseases-grid">
        <?php foreach ($diseasesList as $disease): 
            $imageFile = 'images/diseases/' . ($disease['image'] ?? 'default_leaf.svg');
            if (!file_exists(ROOT_PATH . DIRECTORY_SEPARATOR . $imageFile)) {
                $imageFile = 'images/diseases/default_leaf.svg';
            }
        ?>
            <div class="disease-card" 
                 data-plant="<?php echo safe($disease['plant_name']); ?>"
                 data-disease="<?php echo safe($disease['disease_name']); ?>"
                 data-scientific="<?php echo safe($disease['scientific_name'] ?? ''); ?>"
                 data-type="<?php echo safe($disease['disease_type']); ?>"
                 data-severity="<?php echo safe($disease['severity']); ?>"
                 data-symptoms="<?php echo safe($disease['symptoms']); ?>"
                 data-causes="<?php echo safe($disease['causes']); ?>"
                 data-prevention="<?php echo safe($disease['prevention']); ?>"
                 data-treatment="<?php echo safe($disease['treatment']); ?>"
                 data-organic="<?php echo safe($disease['organic_treatment'] ?? 'Apply organic bio-fungicides or neem oil.'); ?>"
                 data-chemical="<?php echo safe($disease['chemical_treatment'] ?? 'Apply certified agricultural protective fungicides.'); ?>"
            >
                <div class="disease-card-media">
                    <img src="<?php echo safe($imageFile); ?>" alt="<?php echo safe($disease['disease_name']); ?>" loading="lazy">
                    <div class="disease-card-badge">
                        <span class="badge <?php echo getSeverityClass($disease['severity']); ?>">
                            <?php echo safe($disease['severity']); ?>
                        </span>
                    </div>
                </div>

                <div class="disease-card-body">
                    <div class="disease-plant-tag">
                        <i class="fa-solid fa-leaf"></i> <?php echo safe($disease['plant_name']); ?>
                    </div>
                    <h3 class="disease-card-title"><?php echo safe($disease['disease_name']); ?></h3>
                    <p class="disease-card-scientific"><?php echo safe($disease['scientific_name'] ?? 'Botanical Pathogen'); ?></p>

                    <p class="disease-card-symptoms">
                        <?php echo safe($disease['symptoms']); ?>
                    </p>

                    <div class="disease-card-footer">
                        <span class="badge badge-info"><?php echo safe($disease['disease_type']); ?></span>
                        <button class="btn btn-primary btn-sm view-disease-btn" type="button">
                            <i class="fa-solid fa-book-open"></i>
                            <span>View Full Guide</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal Dialog for Comprehensive Disease Profile -->
<div id="disease-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modal-disease-name">
    <div class="modal-content">
        <button id="modal-close-btn" class="modal-close-btn" type="button" aria-label="Close dialog">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div style="display: flex; gap: 1.5rem; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap;">
            <div style="width: 140px; height: 110px; border-radius: var(--radius-md); overflow: hidden; background: #0f1c12; border: 1px solid var(--border-subtle);">
                <img id="modal-image" src="" alt="Disease Botanical Preview" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div>
                <span id="modal-plant-name" style="font-size: 0.9rem; font-weight: 700; color: var(--color-primary-vibrant); text-transform: uppercase;">Plant Name</span>
                <h2 id="modal-disease-name" style="font-size: 1.85rem; margin-top: 2px;">Disease Name</h2>
                <p id="modal-scientific" style="font-style: italic; color: var(--text-muted);">Scientific Pathogen Name</p>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
            <div class="pathology-card">
                <h4><i class="fa-solid fa-triangle-exclamation"></i> Symptoms &amp; Diagnostic Signs</h4>
                <p id="modal-symptoms"></p>
            </div>

            <div class="pathology-card">
                <h4><i class="fa-solid fa-magnifying-glass"></i> Pathogen Biology &amp; Causes</h4>
                <p id="modal-causes"></p>
            </div>

            <div class="pathology-card">
                <h4><i class="fa-solid fa-shield-halved"></i> Cultural Prevention &amp; Sanitation</h4>
                <p id="modal-prevention"></p>
            </div>

            <div class="pathology-card">
                <h4><i class="fa-solid fa-notes-medical"></i> General Clinical Treatment</h4>
                <p id="modal-treatment"></p>
            </div>

            <div class="treatment-split-grid">
                <div class="treatment-sub-box">
                    <h5><i class="fa-solid fa-leaf" style="color: var(--color-primary-accent);"></i> Eco-Friendly Organic Remedies</h5>
                    <p id="modal-organic"></p>
                </div>
                <div class="treatment-sub-box chemical">
                    <h5><i class="fa-solid fa-flask" style="color: var(--color-warning);"></i> Conventional Chemical Controls</h5>
                    <p id="modal-chemical"></p>
                </div>
            </div>
        </div>

        <div style="text-align: right; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border-subtle);">
            <a href="detect.php" class="btn btn-primary">
                <i class="fa-solid fa-microscope"></i>
                <span>Scan a Leaf for this Disease</span>
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
