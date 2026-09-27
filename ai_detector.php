<?php
/**
 * LeafCare AI – Plant Leaf & Fungal Disease Detection Engine
 * 
 * Separated AI / Machine Learning Module
 * - Connects to external ML Inference APIs (e.g., Python Flask / FastAPI / PyTorch)
 * - Provides intelligent demo/simulated detection when external API is offline
 * - Labels simulated results transparently for academic and prototype clarity
 */

require_once __DIR__ . '/config.php';

/**
 * Built-in Botanical Knowledgebase fallback (used if MySQL is not yet configured)
 */
function getBotanicalKnowledgebase() {
    return [
        'tomato_early_blight' => [
            'plant' => 'Tomato Plant',
            'scientific_name' => 'Solanum lycopersicum',
            'disease' => 'Early Blight',
            'pathogen' => 'Alternaria solani',
            'disease_type' => 'Fungal',
            'severity' => 'Moderate',
            'confidence' => 94.8,
            'symptoms' => 'Dark brown to black necrotic spots with characteristic concentric target-like rings on older lower leaves. Surrounding tissue turns pale yellow (chlorosis), leading to premature defoliation and sunken stem cankers.',
            'causes' => 'Fungus Alternaria solani. Thrives in warm, humid weather (24°C - 29°C / 75°F - 85°F) with frequent rain or overhead sprinkler irrigation. Overwinters in infected crop debris.',
            'prevention' => 'Implement 3-year crop rotation away from solanaceous plants. Mulch around plant bases to prevent soil splashing onto foliage. Water strictly at ground level using drip irrigation. Prune lower foliage up to 18 inches off the ground.',
            'treatment' => 'Prune and destroy infected lower leaves immediately upon first sight. Apply preventative copper-based bio-fungicides or synthetic protectants before rainfall events.',
            'organic_treatment' => 'Spray certified organic Copper Hydroxide, Bacillus subtilis suspension, or diluted cold-pressed Neem oil (0.5%) every 7-10 days.',
            'chemical_treatment' => 'Apply Mancozeb, Chlorothalonil, or Azoxystrobin following strict agricultural withholding periods and dosage instructions.',
            'fungal_risk_index' => 'High (Concentric spore development detected)'
        ],
        'potato_late_blight' => [
            'plant' => 'Potato Plant',
            'scientific_name' => 'Solanum tuberosum',
            'disease' => 'Late Blight',
            'pathogen' => 'Phytophthora infestans',
            'disease_type' => 'Fungal / Oomycete',
            'severity' => 'Critical',
            'confidence' => 96.4,
            'symptoms' => 'Pale green to dark water-soaked spots rapidly expanding into brown/black necrotic patches on leaf tips and margins. White powdery mold forms on leaf undersides in high moisture. Tubers develop dry, purplish-brown rot beneath skins.',
            'causes' => 'Infected seed tubers carrying dormant Phytophthora infestans mycelium. Rapid airborne zoospore dispersal during cool, overcast, damp conditions with relative humidity > 90%.',
            'prevention' => 'Use certified disease-free seed tubers. High hill cultivation to build thick soil barrier preventing spores from washing down to tubers. Destroy volunteer potato sprouts in early spring.',
            'treatment' => 'Destroy haulms (vines) with desiccant or mechanical flail 2-3 weeks before harvest to prevent tuber contamination. Quarantine infected fields.',
            'organic_treatment' => 'Bordeaux mixture (copper sulfate + lime), compost tea foliar drenches, and potassium bicarbonate applications.',
            'chemical_treatment' => 'Fluopicolide, Mandipropamid, or Propamocarb applied according to disease forecasting warning systems.',
            'fungal_risk_index' => 'Critical (Rapid defoliation hazard)'
        ],
        'grape_powdery_mildew' => [
            'plant' => 'Grape Vine',
            'scientific_name' => 'Vitis vinifera',
            'disease' => 'Powdery Mildew',
            'pathogen' => 'Erysiphe necator',
            'disease_type' => 'Fungal',
            'severity' => 'Moderate',
            'confidence' => 92.5,
            'symptoms' => 'White to dusty ash-gray powdery fungal patches on upper and lower leaf surfaces, young shoots, and grape clusters. Infected leaves curl upward, become brittle, and may exhibit stunted, distorted growth.',
            'causes' => 'Caused by the obligate biotrophic fungus Erysiphe necator. Favored by warm (20°C - 27°C), shaded conditions with high atmospheric humidity. Unlike most fungi, does NOT require liquid water.',
            'prevention' => 'Maintain open vine canopies through shoot thinning and leaf pulling around fruiting zones. Maximize solar radiation and airflow. Avoid excessive nitrogen fertilizer.',
            'treatment' => 'Apply powdery mildew preventative treatments early when shoots are 3-6 inches long. Eradicate early colonies before cluster infection occurs.',
            'organic_treatment' => 'Spray dilute horticultural milk solution (1:9 ratio with water in full sun), Potassium bicarbonate (Kaligreen), or cold-pressed Neem oil.',
            'chemical_treatment' => 'Wettable sulfur, Quinoxyfen, Tebuconazole, or Trifloxystrobin rotated across FRAC classes to avoid fungal resistance.',
            'fungal_risk_index' => 'Moderate (Spore canopy colony expansion)'
        ],
        'apple_scab' => [
            'plant' => 'Apple Tree',
            'scientific_name' => 'Malus domestica',
            'disease' => 'Apple Scab',
            'pathogen' => 'Venturia inaequalis',
            'disease_type' => 'Fungal',
            'severity' => 'Moderate',
            'confidence' => 93.1,
            'symptoms' => 'Olive-green to velvety dark brown lesions on leaf surfaces. Spots become thickened, distorted, and puckered. Leaves turn yellow around spots and drop prematurely. Fruit develops corky, scabby lesions that crack.',
            'causes' => 'Caused by the ascomycete fungus Venturia inaequalis. Ascospores overwinter in fallen dead apple leaves and discharge during rainy spring weather to infect new tender foliage.',
            'prevention' => 'Rake and compost or shred fallen orchard leaves thoroughly in autumn to eliminate primary inoculum. Prune canopy to promote rapid sun drying of foliage.',
            'treatment' => 'Begin protective fungal sprays in early spring at green tip stage and continue until petal drop, particularly following wetting rain periods.',
            'organic_treatment' => 'Neem oil, horticultural dormant oils, Potassium bicarbonate, and wettable micronized sulfur sprays.',
            'chemical_treatment' => 'Myclobutanil, Fenbuconazole, Kresoxim-methyl, or Captan applied according to the Mills Period infection chart.',
            'fungal_risk_index' => 'Moderate (Leaf puckering & foliar scab)'
        ],
        'corn_northern_blight' => [
            'plant' => 'Corn / Maize',
            'scientific_name' => 'Zea mays',
            'disease' => 'Northern Leaf Blight',
            'pathogen' => 'Exserohilum turcicum',
            'disease_type' => 'Fungal',
            'severity' => 'Severe',
            'confidence' => 95.2,
            'symptoms' => 'Long, elliptical, cigar-shaped grayish-green to tan lesions (1 to 6 inches in length) parallel to leaf veins. As lesions mature, dark fungal spores form inside during damp weather.',
            'causes' => 'Fungus Exserohilum turcicum. Survives winter on corn crop residue on the soil surface. Spores are blown by wind and rain into lower leaves during moderate temperatures (18°C - 27°C).',
            'prevention' => 'Rotate crops with non-hosts (soybeans, alfalfa) for at least one season. Incorporate crop residues into the soil via tillage. Select corn hybrids with robust Ht resistance genes.',
            'treatment' => 'Monitor fields from whorl stage to tasseling. Apply foliar fungicides if lesions appear on the third leaf below the ear or higher prior to or at tasseling stage.',
            'organic_treatment' => 'Bio-fungicide sprays containing Bacillus amyloliquefaciens strain D747 or Trichoderma viride seed treatments.',
            'chemical_treatment' => 'Pyraclostrobin + Metconazole, Azoxystrobin + Propiconazole applied before blister (R2) kernel stage.',
            'fungal_risk_index' => 'Severe (Photosynthetic area loss)'
        ],
        'healthy_leaf' => [
            'plant' => 'Bell Pepper / Tomato',
            'scientific_name' => 'Capsicum annuum / Solanum lycopersicum',
            'disease' => 'Healthy Leaf (No Pathogens Detected)',
            'pathogen' => 'None (Normal Cellular Anatomy)',
            'disease_type' => 'Healthy',
            'severity' => 'Healthy',
            'confidence' => 98.6,
            'symptoms' => 'Vibrant green coloration, uniform leaf lamina, well-defined venation with zero necrotic spots, chlorosis, fungal mycelium, or bacterial lesions. Robust cellular turgidity.',
            'causes' => 'Optimal cultural management: sufficient balanced sunlight, appropriate watering schedule, and absence of pathogenic fungal spores.',
            'prevention' => 'Maintain regular watering, scout leaves weekly for early signs of pests, mulch soil bed, and avoid overhead sprinkler splash.',
            'treatment' => 'No treatment required. The foliage is in peak condition and photosynthetically vigorous.',
            'organic_treatment' => 'Continue routine organic foliar nutrition (dilute seaweed extract or compost tea) to maintain natural plant immunity.',
            'chemical_treatment' => 'No chemical fungicides necessary. Preserve beneficial microflora.',
            'fungal_risk_index' => 'Zero / Negligible'
        ]
    ];
}

/**
 * Main AI Detection Function
 * 
 * @param string $imagePath Absolute path to the leaf image on disk
 * @param string|null $plantHint Optional plant category hint
 * @return array Structured diagnostic results
 */
function detectLeafDisease($imagePath, $plantHint = null) {
    $startTime = microtime(true);

    if (!file_exists($imagePath)) {
        return [
            'status' => 'error',
            'message' => 'Image file not found on server.'
        ];
    }

    // Check if live ML API is configured and enabled
    if (defined('AI_MODE') && AI_MODE === 'api') {
        $apiResult = queryExternalMLModel($imagePath);
        if ($apiResult && isset($apiResult['status']) && $apiResult['status'] === 'success') {
            $apiResult['execution_time'] = round((microtime(true) - $startTime) * 1000, 2) . ' ms';
            $apiResult['mode'] = 'api';
            $apiResult['mode_label'] = 'Live AI/ML Model (Inference API)';
            return $apiResult;
        }
        // If API fails or is unreachable, fallback gracefully to intelligent demo mode
    }

    // Execute Intelligent Demo / Heuristic Detection Simulation
    $result = runIntelligentSimulatedDetection($imagePath, $plantHint);
    $result['execution_time'] = round((microtime(true) - $startTime) * 1000, 2) . ' ms';
    $result['mode'] = 'demo';
    $result['mode_label'] = 'Demo / Simulated Detection Mode';
    $result['ai_disclaimer'] = 'This diagnosis was generated by LeafCare AI in Demo / Prototype Mode. Connect an external PyTorch/TensorFlow ML endpoint in config.php for real-time model weights inference.';

    return $result;
}

/**
 * Intelligent Demo Detection Engine
 * Analyzes image metrics and matches with comprehensive botanical profiles.
 */
function runIntelligentSimulatedDetection($imagePath, $plantHint = null) {
    global $pdo, $db_connected;

    $kb = getBotanicalKnowledgebase();
    $filename = strtolower(basename($imagePath));

    // 1. Keyword-based matching for sample testing leaves
    $selectedKey = null;
    if (strpos($filename, 'tomato') !== false && (strpos($filename, 'early') !== false || strpos($filename, 'blight') !== false)) {
        $selectedKey = 'tomato_early_blight';
    } elseif (strpos($filename, 'potato') !== false || (strpos($filename, 'late') !== false && strpos($filename, 'blight') !== false)) {
        $selectedKey = 'potato_late_blight';
    } elseif (strpos($filename, 'grape') !== false || strpos($filename, 'mildew') !== false) {
        $selectedKey = 'grape_powdery_mildew';
    } elseif (strpos($filename, 'apple') !== false || strpos($filename, 'scab') !== false) {
        $selectedKey = 'apple_scab';
    } elseif (strpos($filename, 'corn') !== false || strpos($filename, 'maize') !== false) {
        $selectedKey = 'corn_northern_blight';
    } elseif (strpos($filename, 'healthy') !== false) {
        $selectedKey = 'healthy_leaf';
    }

    // 2. Visual color analysis using PHP GD (if available)
    if (!$selectedKey && function_exists('imagecreatefromjpeg') && function_exists('getimagesize')) {
        $imageInfo = @getimagesize($imagePath);
        if ($imageInfo) {
            $mime = $imageInfo['mime'];
            $im = null;
            if ($mime === 'image/jpeg') $im = @imagecreatefromjpeg($imagePath);
            elseif ($mime === 'image/png') $im = @imagecreatefrompng($imagePath);
            elseif ($mime === 'image/webp' && function_exists('imagecreatefromwebp')) $im = @imagecreatefromwebp($imagePath);

            if ($im) {
                $w = imagesx($im);
                $h = imagesy($im);
                $samplePoints = 40;
                $greenScore = 0;
                $brownYellowScore = 0;
                $totalSampled = 0;

                $stepX = max(1, (int)($w / $samplePoints));
                $stepY = max(1, (int)($h / $samplePoints));

                for ($x = 0; $x < $w; $x += $stepX) {
                    for ($y = 0; $y < $h; $y += $stepY) {
                        $rgb = imagecolorat($im, $x, $y);
                        $r = ($rgb >> 16) & 0xFF;
                        $g = ($rgb >> 8) & 0xFF;
                        $b = $rgb & 0xFF;

                        // Check healthy chlorophyll green vs necrotic lesion color
                        if ($g > $r + 15 && $g > $b + 15) {
                            $greenScore++;
                        } elseif (($r > 100 && $g > 80 && $b < 80) || ($r < 60 && $g < 60 && $b < 60)) {
                            // Brownish, yellowish, or dark necrotic spot
                            $brownYellowScore++;
                        }
                        $totalSampled++;
                    }
                }
                imagedestroy($im);

                $healthyRatio = $totalSampled > 0 ? ($greenScore / $totalSampled) : 0.5;
                $lesionRatio = $totalSampled > 0 ? ($brownYellowScore / $totalSampled) : 0.3;

                if ($healthyRatio > 0.65 && $lesionRatio < 0.15) {
                    $selectedKey = 'healthy_leaf';
                } elseif ($lesionRatio > 0.35) {
                    $selectedKey = 'tomato_early_blight';
                } else {
                    $keys = ['tomato_early_blight', 'grape_powdery_mildew', 'apple_scab', 'corn_northern_blight'];
                    $selectedKey = $keys[crc32($filename) % count($keys)];
                }
            }
        }
    }

    // Default fallback if still undetermined
    if (!$selectedKey || !isset($kb[$selectedKey])) {
        $keys = array_keys($kb);
        $selectedKey = $keys[abs(crc32($filename)) % count($keys)];
    }

    $data = $kb[$selectedKey];

    // Jitter confidence slightly for realistic demonstration variation (between 91.0% and 97.8%)
    $seed = abs(crc32($filename)) % 70;
    $jitteredConfidence = round(91.0 + ($seed / 10), 1);
    if ($selectedKey === 'healthy_leaf') {
        $jitteredConfidence = round(96.0 + ($seed / 20), 1);
    }

    // Try fetching database record if available for even richer dynamic descriptions
    if ($db_connected && $pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM diseases WHERE disease_name LIKE :dname OR plant_name LIKE :pname LIMIT 1");
            $stmt->execute([
                ':dname' => '%' . $data['disease'] . '%',
                ':pname' => '%' . $data['plant'] . '%'
            ]);
            $dbRow = $stmt->fetch();
            if ($dbRow) {
                $data['symptoms'] = $dbRow['symptoms'];
                $data['causes'] = $dbRow['causes'];
                $data['prevention'] = $dbRow['prevention'];
                $data['treatment'] = $dbRow['treatment'];
                if (!empty($dbRow['organic_treatment'])) $data['organic_treatment'] = $dbRow['organic_treatment'];
                if (!empty($dbRow['chemical_treatment'])) $data['chemical_treatment'] = $dbRow['chemical_treatment'];
                if (!empty($dbRow['scientific_name'])) $data['scientific_name'] = $dbRow['scientific_name'];
            }
        } catch (Exception $e) {
            // Silently fall back to built-in KB
        }
    }

    return [
        'status' => 'success',
        'plant' => $data['plant'],
        'plant_name' => $data['plant'],
        'scientific_name' => $data['scientific_name'],
        'disease' => $data['disease'],
        'disease_name' => $data['disease'],
        'pathogen' => $data['pathogen'] ?? 'Pathogenic Microorganism',
        'disease_type' => $data['disease_type'],
        'severity' => $data['severity'],
        'confidence' => $jitteredConfidence,
        'symptoms' => $data['symptoms'],
        'causes' => $data['causes'],
        'prevention' => $data['prevention'],
        'treatment' => $data['treatment'],
        'organic_treatment' => $data['organic_treatment'],
        'chemical_treatment' => $data['chemical_treatment'],
        'fungal_risk_index' => $data['fungal_risk_index'] ?? 'Moderate',
        'analyzed_image' => basename($imagePath),
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

/**
 * Placeholder for connecting external AI/ML Model via HTTP POST (e.g. FastAPI / PyTorch / Flask)
 * 
 * To connect your real deep learning model:
 * 1. Train a model (ResNet, MobileNet, EfficientNet) on PlantVillage dataset.
 * 2. Expose an inference route in Python returning:
 *    {"status": "success", "plant": "Tomato", "disease": "Early Blight", "confidence": 95.4, ...}
 * 3. Set define('AI_MODE', 'api') in config.php and point AI_API_ENDPOINT to your server URL.
 */
function queryExternalMLModel($imagePath) {
    if (!function_exists('curl_init')) {
        return null;
    }

    $ch = curl_init();
    $cfile = new CURLFile($imagePath, mime_content_type($imagePath), basename($imagePath));
    $postData = ['file' => $cfile];

    curl_setopt($ch, CURLOPT_URL, AI_API_ENDPOINT);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, AI_API_TIMEOUT);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 200 && $response) {
        $json = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
            return $json;
        }
    }

    return null; // Signals fallback to simulated mode
}
