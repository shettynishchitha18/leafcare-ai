-- =======================================================
-- LeafCare AI – Plant Leaf & Fungal Disease Detection System
-- Database Schema & Comprehensive Botanical Seed Data
-- =======================================================

CREATE DATABASE IF NOT EXISTS `leafcare_ai` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `leafcare_ai`;

-- Drop existing tables if re-importing
DROP TABLE IF EXISTS `detection_history`;
DROP TABLE IF EXISTS `diseases`;

-- -------------------------------------------------------
-- Table: diseases
-- Stores botanical disease taxonomy, symptoms, and cures
-- -------------------------------------------------------
CREATE TABLE `diseases` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `disease_name` VARCHAR(150) NOT NULL,
  `scientific_name` VARCHAR(150) DEFAULT NULL,
  `plant_name` VARCHAR(150) NOT NULL,
  `disease_type` ENUM('Fungal', 'Bacterial', 'Viral', 'Healthy', 'Nutrient Deficiency') DEFAULT 'Fungal',
  `severity` ENUM('Low', 'Moderate', 'Severe', 'Critical', 'Healthy') DEFAULT 'Moderate',
  `symptoms` TEXT NOT NULL,
  `causes` TEXT NOT NULL,
  `prevention` TEXT NOT NULL,
  `treatment` TEXT NOT NULL,
  `organic_treatment` TEXT DEFAULT NULL,
  `chemical_treatment` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT 'default_leaf.svg',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- Table: detection_history
-- Records every analyzed leaf image, classification, and confidence
-- -------------------------------------------------------
CREATE TABLE `detection_history` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `image_path` VARCHAR(255) NOT NULL,
  `plant_name` VARCHAR(150) NOT NULL,
  `disease_name` VARCHAR(150) NOT NULL,
  `disease_type` VARCHAR(100) DEFAULT 'Fungal',
  `confidence` DECIMAL(5, 2) NOT NULL,
  `severity` VARCHAR(50) DEFAULT 'Moderate',
  `notes` TEXT DEFAULT NULL,
  `detection_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- Indexing for search optimization
-- -------------------------------------------------------
CREATE INDEX `idx_disease_search` ON `diseases` (`disease_name`, `plant_name`, `disease_type`);
CREATE INDEX `idx_history_date` ON `detection_history` (`detection_date`);

-- -------------------------------------------------------
-- Pre-populated Botanical & Plant Disease Dataset
-- -------------------------------------------------------
INSERT INTO `diseases` 
(`id`, `disease_name`, `scientific_name`, `plant_name`, `disease_type`, `severity`, `symptoms`, `causes`, `prevention`, `treatment`, `organic_treatment`, `chemical_treatment`, `image`) 
VALUES
(
  1,
  'Early Blight',
  'Alternaria solani',
  'Tomato Plant',
  'Fungal',
  'Moderate',
  'Dark brown to black necrotic spots with characteristic concentric target-like rings on older lower leaves. Surrounding tissue turns pale yellow (chlorosis), leading to premature defoliation and sunken stem cankers.',
  'Caused by the fungus Alternaria solani. Thrives in warm, humid weather (24°C - 29°C / 75°F - 85°F) with frequent rain or overhead sprinkler irrigation. Overwinters in infected crop debris, nightshade weeds, and contaminated seeds.',
  'Implement 3-year crop rotation away from solanaceous plants. Mulch around plant bases to prevent soil splashing onto foliage. Water strictly at ground level using drip irrigation. Prune lower foliage up to 18 inches off the ground.',
  'Prune and destroy infected lower leaves immediately upon first sight. Apply preventative copper-based bio-fungicides or synthetic protectants before rainfall events.',
  'Spray certified organic Copper Hydroxide, Bacillus subtilis suspension, or diluted cold-pressed Neem oil (0.5%) every 7-10 days.',
  'Apply Mancozeb, Chlorothalonil, or Azoxystrobin following strict agricultural withholding periods and dosage instructions.',
  'tomato_early_blight.svg'
),
(
  2,
  'Late Blight',
  'Phytophthora infestans',
  'Tomato Plant',
  'Fungal',
  'Critical',
  'Large, irregular, water-soaked greenish-black lesions that spread rapidly across leaves and stems. In damp humid weather, a delicate white fuzzy fungal sporulation develops on leaf undersides. Stems turn black and brittle.',
  'Caused by the oomycete water mold Phytophthora infestans (the pathogen responsible for the Irish Potato Famine). Favored by cool, wet, humid conditions (15°C - 21°C) with prolonged leaf wetness.',
  'Plant certified disease-free and resistant tomato hybrids (e.g., Mountain Magic, Defiant). Ensure spacious plant spacing for rapid air circulation. Avoid planting near infected potato patches. Destroy all cull piles.',
  'Act aggressively immediately upon detection. Prune all affected foliage if localized, or cull entire infected vines to protect remaining greenhouse or field crops.',
  'Preventative Copper Sulfate sprays, Bio-fungicides containing Trichoderma harzianum or Serenade (Bacillus amyloliquefaciens).',
  'Systemic oomycete fungicides: Cymoxanil + Mancozeb, Dimethomorph, or Metalaxyl-M applied before sporulation becomes systemic.',
  'tomato_late_blight.svg'
),
(
  3,
  'Late Blight',
  'Phytophthora infestans',
  'Potato Plant',
  'Critical',
  'Pale green to dark water-soaked spots rapidly expanding into brown/black necrotic patches on leaf tips and margins. White powdery mold forms on leaf undersides in high moisture. Tubers develop dry, purplish-brown rot beneath skins.',
  'Infected seed tubers carrying dormant Phytophthora infestans mycelium. Rapid airborne zoospore dispersal during cool, overcast, damp conditions with relative humidity > 90%.',
  'Use certified disease-free seed tubers. High hill cultivation to build thick soil barrier preventing spores from washing down to tubers. Destroy volunteer potato sprouts in early spring.',
  'Destroy haulms (vines) with desiccant or mechanical flail 2-3 weeks before harvest to prevent tuber contamination. Quarantine infected fields.',
  'Bordeaux mixture (copper sulfate + lime), compost tea foliar drenches, and potassium bicarbonate applications.',
  'Fluopicolide, Mandipropamid, or Propamocarb applied according to disease forecasting warning systems.',
  'potato_late_blight.svg'
),
(
  4,
  'Black Rot',
  'Diplodia seriata / Botryosphaeria obtusa',
  'Apple Tree',
  'Severe',
  'Small purple specks on upper leaf surfaces that enlarge into circular spots with tan/brown centers and dark purple margins (known as "frog-eye" leaf spots). Fruit develops brown rot rings with black fungal fruiting bodies (pycnidia).',
  'Caused by the fungus Botryosphaeria obtusa. Overwinters in dead wood, mummified apple fruit hanging on trees, and fire-blighted cankers. Spores disperse via spring rains.',
  'Prune out dead or weakened twigs, fire blight strikes, and cankered branches during winter dormancy. Remove and burn all mummified apples remaining in the orchard or under the canopy.',
  'Carefully prune out infected limbs 6 to 8 inches below noticeable cankers. Sanitize pruning shear blades between cuts with 70% isopropyl alcohol.',
  'Lime sulfur dormant sprays, liquid copper soaps, and sulfur dusting before petal fall.',
  'Captan 50WP, Thiophanate-methyl, or Mancozeb applied from tight cluster through cover spray intervals.',
  'apple_black_rot.svg'
),
(
  5,
  'Apple Scab',
  'Venturia inaequalis',
  'Apple Tree',
  'Moderate',
  'Olive-green to velvety dark brown lesions on leaf surfaces. Spots become thickened, distorted, and puckered. Leaves turn yellow around spots and drop prematurely. Fruit develops corky, scabby lesions that crack.',
  'Caused by the ascomycete fungus Venturia inaequalis. Ascospores overwinter in fallen dead apple leaves and discharge during rainy spring weather to infect new tender foliage.',
  'Rake and compost or shred fallen orchard leaves thoroughly in autumn to eliminate primary inoculum. Prune canopy to promote rapid sun drying of foliage. Plant scab-resistant varieties (Liberty, Enterprise, Honeycrisp).',
  'Begin protective fungal sprays in early spring at green tip stage and continue until petal drop, particularly following wetting rain periods.',
  'Neem oil, horticultural dormant oils, Potassium bicarbonate, and wettable micronized sulfur sprays.',
  'Myclobutanil, Fenbuconazole, Kresoxim-methyl, or Captan applied according to the Mills Period infection chart.',
  'apple_scab.svg'
),
(
  6,
  'Powdery Mildew',
  'Erysiphe necator / Uncinula necator',
  'Grape Vine',
  'Moderate',
  'White to dusty ash-gray powdery fungal patches on upper and lower leaf surfaces, young shoots, and grape clusters. Infected leaves curl upward, become brittle, and may exhibit stunted, distorted growth.',
  'Caused by the obligate biotrophic fungus Erysiphe necator. Favored by warm (20°C - 27°C / 68°F - 80°F), dry, shaded conditions with high atmospheric humidity. Unlike most fungi, does NOT require liquid water.',
  'Maintain open vine canopies through shoot thinning and leaf pulling around fruiting zones. Maximize solar radiation and airflow. Avoid excessive nitrogen fertilizer that stimulates soft succulent tissue.',
  'Apply powdery mildew preventative treatments early when shoots are 3-6 inches long. Eradicate early colonies before cluster infection occurs.',
  'Spray dilute horticultural milk solution (1:9 ratio with water in full sun), Potassium bicarbonate (Kaligreen), or cold-pressed Neem oil.',
  'Wettable sulfur, Quinoxyfen, Tebuconazole, or Trifloxystrobin rotated across FRAC classes to avoid fungal resistance.',
  'grape_powdery_mildew.svg'
),
(
  7,
  'Grape Black Rot',
  'Guignardia bidwellii',
  'Grape Vine',
  'Severe',
  'Reddish-brown circular necrotic spots on leaves with distinct dark borders. Inside the spots, tiny black pimple-like dots (pycnidia) appear in concentric rings. Young green berries turn brown, then shrivel into hard, black, wrinkled mummies.',
  'Fungal pathogen Guignardia bidwellii. Overwinters on mummified berries and stem canes. Airborne ascospores require prolonged leaf wetness at 21°C - 29°C for successful penetration.',
  'Collect and destroy all dried black mummy grapes during dormant pruning. Clean vine trunks of dead bark. Keep vineyard grass mowed low to reduce ground moisture and improve airflow.',
  'Spray protective fungicides from early shoot growth through 4 weeks post-bloom when young grape clusters are exceptionally vulnerable.',
  'Fixed copper fungicides combined with hydrated lime (Bordeaux mixture), fermented horsetail (Equisetum) extract.',
  'Mancozeb, Ziram, or Sterol-inhibitors (DMI fungicides) applied during high-risk rain events.',
  'grape_black_rot.svg'
),
(
  8,
  'Northern Leaf Blight',
  'Exserohilum turcicum',
  'Corn / Maize',
  'Severe',
  'Long, elliptical, cigar-shaped grayish-green to tan lesions (1 to 6 inches in length) parallel to leaf veins. As lesions mature, dark fungal spores form inside during damp weather, giving spots a dirty, dusky appearance.',
  'Fungus Exserohilum turcicum. Survives winter on corn crop residue on the soil surface. Spores are blown by wind and rain into lower leaves during moderate temperatures (18°C - 27°C) accompanied by heavy dew.',
  'Rotate crops with soybeans, wheat, or alfalfa for at least one season. Incorporate crop residues into the soil via tillage where appropriate. Select corn hybrids with robust Ht gene resistance.',
  'Monitor fields from whorl stage to tasseling. Apply foliar fungicides if lesions appear on the third leaf below the ear or higher prior to or at tasseling stage.',
  'Bio-fungicide sprays containing Bacillus amyloliquefaciens strain D747 or Trichoderma viride seed treatments.',
  'Pyraclostrobin + Metconazole, Azoxystrobin + Propiconazole applied before blister (R2) kernel stage.',
  'corn_northern_blight.svg'
),
(
  9,
  'Bacterial Spot',
  'Xanthomonas campestris pv. vesicatoria',
  'Bell Pepper / Chili',
  'Moderate',
  'Small, water-soaked, circular spots on leaves that turn dark brown or black with a distinct bright chlorotic yellow halo. Spots may coalesce, causing extensive leaf yellowing, browning, and severe defoliation exposing peppers to sunscald.',
  'Caused by the bacterium Xanthomonas campestris. Disperses through wind-driven rains, sprinkler irrigation, and worker machinery handling wet foliage. Enters leaf tissues through natural stomata and mechanical abrasions.',
  'Plant certified pathogen-free pepper seeds. Avoid overhead spray irrigation; use sub-surface drip tapes. Disinfect greenhouse seedling trays, staking poles, and pruning shears between crop cycles.',
  'Strip and discard severely spotted leaves in dry weather. Copper bactericides mixed with mancozeb can suppress bacterial populations on remaining foliage.',
  'Copper octanoate (copper soap) coupled with bio-pesticides containing bacteriophages or Bacillus subtilis.',
  'Streptomycin agricultural formulations (where permitted by regional regulations) or Copper Hydroxide combined with Mancozeb.',
  'pepper_bacterial_spot.svg'
),
(
  10,
  'Leaf Scorch',
  'Diplocarpon earlianum',
  'Strawberry',
  'Moderate',
  'Numerous small, irregular purplish-red to dark brown spots on upper leaf surfaces. Unlike common leaf spot, scorch spots never develop pale white centers; centers remain dark purple and dry out, giving leaves a burned, scorched appearance.',
  'Fungal pathogen Diplocarpon earlianum. Overwinters on living strawberry foliage and runner crowns. Spores spread rapidly during warm, wet spring rains with extended periods of leaf surface wetness.',
  'Establish strawberry beds in full sunlight with well-drained, sandy-loam soils. Avoid over-fertilizing with quick-release nitrogen in spring. Space plants 12-18 inches apart to promote rapid leaf drying.',
  'Mow or renovate strawberry beds immediately following fruit harvest. Rake and dispose of all trimmed diseased leaves.',
  'Wettable sulfur or copper hydroxide applied in early spring as new crowns initiate growth.',
  'Captan, Pyraclostrobin, or Boscalid applied prior to bloom when weather forecasts predict wet conditions.',
  'strawberry_leaf_scorch.svg'
),
(
  11,
  'Stem Rust',
  'Puccinia graminis',
  'Wheat / Cereal Crops',
  'Severe',
  'Reddish-brown, elongated, pustular blisters (uredinia) that rupture the epidermal layer of stems and leaf sheaths. Rubbing infected stems leaves rust-colored powder (spores) on fingers. Lodging and shriveled grains occur.',
  'Caused by the heteroecious macrocyclic rust fungus Puccinia graminis. Airborne urediniospores can travel hundreds of miles on wind currents. Requires 6-8 hours of dew at 18°C - 30°C.',
  'Eradicate alternate host barberry bushes (Berberis vulgaris) near wheat fields. Plant rust-resistant wheat cultivars carrying effective Sr resistance genes. Early planting to mature before peak spore flights.',
  'Scout wheat tillering through heading stages. Apply triazole fungicides at flag leaf emergence if disease incidence crosses economic threshold.',
  'Preventative biological seed dressings with Trichoderma species and foliar bio-stimulants.',
  'Propiconazole, Tebuconazole, or Picoxystrobin applied prior to full flowering stage.',
  'wheat_stem_rust.svg'
),
(
  12,
  'Healthy Leaf (No Pathogens)',
  'Solanum lycopersicum',
  'Tomato Plant',
  'Healthy',
  'Healthy',
  'Vibrant green color, uniform texture, well-defined leaf veins with zero necrotic spots, chlorosis, fungal mycelium, or bacterial lesions. Robust leaf turgor and healthy epidermal cellular structure.',
  'Optimal growing conditions: adequate sunlight, balanced soil N-P-K nutrition, proper watering schedule, and absence of pathogenic spore infection.',
  'Maintain regular watering, mulch base, scout leaves weekly for early signs of pests or disease, and ensure balanced fertilization with micronutrients (calcium, magnesium).',
  'No treatment required. The plant is in optimal health and flourishing.',
  'Continue routine organic maintenance: compost teas, companion planting with marigolds/basil, and beneficial insect conservation.',
  'No chemical intervention needed. Avoid unnecessary prophylactic chemical sprays.',
  'healthy_tomato.svg'
);

-- -------------------------------------------------------
-- Sample Initial Scan Records for Detection History
-- -------------------------------------------------------
INSERT INTO `detection_history` 
(`image_path`, `plant_name`, `disease_name`, `disease_type`, `confidence`, `severity`, `notes`, `detection_date`) 
VALUES
('uploads/sample_tomato_early_blight.svg', 'Tomato Plant', 'Early Blight', 'Fungal', 94.60, 'Moderate', 'Concentric target spots detected on lower foliage. Fungal pathogen Alternaria solani identified.', DATE_SUB(NOW(), INTERVAL 2 DAY)),
('uploads/sample_potato_late_blight.svg', 'Potato Plant', 'Late Blight', 'Fungal', 97.20, 'Critical', 'Water-soaked necrotic lesions. Phytophthora infestans risk alert triggered.', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('uploads/sample_grape_powdery_mildew.svg', 'Grape Vine', 'Powdery Mildew', 'Fungal', 91.80, 'Moderate', 'Ash-gray mycelium spotted across leaf blade. Recommended milk/potassium bicarbonate treatment.', NOW());
