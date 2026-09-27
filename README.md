# LeafCare AI – Plant Leaf & Fungal Disease Detection System

**A modern, responsive, AI-assisted agricultural web application built with PHP, HTML5, CSS3, JavaScript (ES6), and MySQL.**

Developed for farmers, agronomists, horticulturists, and academic project presentations (BCA / B.Tech / MCA Final Year).

---

## 🌟 Key Features

* 🌿 **Instant Plant Identification:** Identifies crop species (Tomato, Potato, Grape, Apple, Corn, Bell Pepper, Strawberry, Wheat).
* 🔬 **Fungal & Pathogen Detection:** Diagnoses Early Blight, Late Blight, Powdery Mildew, Scab, Black Rot, Leaf Scorch, Rusts, and differentiates healthy foliage.
* 📊 **Confidence Dial & Severity Scoring:** Real-time statistical confidence percentage with clinical severity classification (Healthy, Mild, Moderate, Severe, Critical).
* 💊 **Dual Treatment Prescriptions:** Delivers both certified eco-friendly organic remedies (Neem oil, *Bacillus subtilis*, copper soaps) and conventional agricultural fungicides (*Mancozeb*, *Chlorothalonil*).
* 📷 **Live In-Field Camera Capture:** WebRTC camera snapshot integration directly from mobile or desktop webcams.
* 🗂️ **Drag-and-Drop Dropzone:** Seamless file upload with instant client-side preview, validation, and cancel/replace options.
* 🧪 **6 One-Click Test Samples:** Built-in botanical leaf samples for instant testing without needing an actual infected leaf photo.
* 📚 **Searchable Disease Library (`diseases.php`):** Interactive disease dictionary with real-time live search, category pills, and full-screen disease guide modal dialogs.
* 📜 **Detection History (`history.php`):** Persistent scan logs with thumbnail previews, timestamps, confidence scores, and clear history functionality.
* 🌓 **Dark & Light Mode:** Nature-inspired themes with smooth transitions and `localStorage` persistence.
* 🖨️ **Printable Diagnosis PDF Report:** Clean `@media print` styling to export farmer diagnostic reports to PDF with a single click.
* 🛡️ **Enterprise Security:**
  * Server-side MIME validation with `finfo_file` and `getimagesize()` to block polyglot PHP scripts.
  * Cryptographically secure file renaming (`bin2hex(random_bytes(10))`).
  * File execution disabled in `uploads/.htaccess`.
  * Prepared PDO statements across all SQL queries against SQL injection.
  * XSS prevention with context-aware `htmlspecialchars()`.

---

## 🗂️ Project Structure

```text
LeafCare-AI/
│
├── index.php                 # Beautiful Landing & Home Page
├── detect.php                # Main Leaf Detection & Camera Scanner Interface
├── diseases.php              # Searchable Botanical Disease Library & Modal
├── history.php               # Diagnostic Scan History & Storage Manager
├── about.php                 # System Architecture, CV Pipeline & ML Connector Guide
│
├── config.php                # Database Connection, Security Limits & AI Engine Settings
├── process.php               # Upload Handler, MIME Validator & Detection Controller
├── ai_detector.php           # Separated AI / Machine Learning Inference & Heuristic Engine
├── database.sql              # Complete MySQL Database Schema & Botanical Seed Data
│
├── includes/
│   ├── header.php            # Global Header, Navigation Bar & Theme Switcher
│   └── footer.php            # Global Footer, Animated Leaf Particles & Scripts
│
├── css/
│   └── style.css             # Nature-Inspired Theme, Glassmorphism & Responsive Layout
│
├── js/
│   └── script.js             # WebRTC Camera, Drag-Drop, AJAX Engine & Filtering
│
├── images/
│   ├── samples/              # 6 Botanical Test Leaf Samples (SVGs)
│   └── diseases/             # 12+ Botanical Disease Cards Graphics
│
├── uploads/
│   └── .htaccess             # Security Directive: Disables PHP script execution
│
└── README.md                 # Complete Installation & Deployment Manual
```

---

## 🚀 Setup & Installation Guide

### Option A: Running on XAMPP (Recommended)

#### Step 1: Place the Project in `htdocs`
Copy or move the `LeafCare-AI` folder into your XAMPP web root directory:
```text
C:\xampp\htdocs\LeafCare-AI
```

#### Step 2: Start Apache and MySQL
1. Open the **XAMPP Control Panel**.
2. Click **Start** next to **Apache**.
3. Click **Start** next to **MySQL**.
*(Both modules should turn green with active port numbers).*

#### Step 3: Create & Import the Database
1. Open your browser and navigate to:
   ```text
   http://localhost/phpmyadmin
   ```
2. Click on the **Databases** tab in the top menu.
3. In the "Create database" field, type:
   ```text
   leafcare_ai
   ```
4. Click **Create**.
5. Select the newly created `leafcare_ai` database from the left sidebar.
6. Click the **Import** tab in the top navigation.
7. Click **Choose File** and select:
   ```text
   C:\xampp\htdocs\LeafCare-AI\database.sql
   ```
8. Click **Import** (or **Go**) at the bottom of the page.
*(All tables: `diseases` and `detection_history` will be created and seeded with 12+ plant diseases).*

#### Step 4: Open LeafCare AI
In your browser, visit:
```text
http://localhost/LeafCare-AI
```

---

### Option B: Quick Run via PHP Built-in Server (No XAMPP Required!)

If you want to run the project immediately without configuring Apache:
1. Open PowerShell or Command Prompt in the project folder:
   ```powershell
   cd "path\to\LeafCare-AI"
   ```
2. Launch the PHP development server:
   ```powershell
   php -S localhost:8000
   ```
3. Open your browser and visit:
   ```text
   http://localhost:8000
   ```
*(Note: If MySQL is not running, LeafCare AI automatically switches to its built-in fallback knowledgebase and session memory mode without crashing).*

---

### Option C: Running on WAMP Server

1. Copy the `LeafCare-AI` folder to:
   ```text
   C:\wamp64\www\LeafCare-AI
   ```
2. Start WampServer from your Start Menu.
3. Open `http://localhost/phpmyadmin`, create database `leafcare_ai`, and import `database.sql`.
4. Open `http://localhost/LeafCare-AI` in your web browser.

---

## 🤖 AI / Machine Learning Integration Architecture

LeafCare AI includes a clearly separated **AI Detection Module** (`ai_detector.php`).

### How It Works:
```text
[Browser User] 
      │ (Uploads Leaf / Camera Snapshot)
      ▼
[process.php] ──(Validates MIME & File Security)
      │
      ▼
[ai_detector.php :: detectLeafDisease()]
      │
      ├─► [External ML Model: AI_MODE = 'api'] (e.g. Python FastAPI / PyTorch)
      │        └─► Returns JSON with disease class and confidence
      │
      └─► [Intelligent Simulation: AI_MODE = 'demo'] (Default Prototype Mode)
               └─► Heuristic color distribution, chlorophyll analysis & botanical dataset matching
```

### Connecting Your Real PyTorch / TensorFlow Model:
1. Train a Convolutional Neural Network (e.g., MobileNetV2, ResNet50, or EfficientNet) on the [PlantVillage Dataset](https://github.com/spMohanty/PlantVillage-Dataset).
2. Expose an inference route in Python (FastAPI or Flask):
   ```python
   from fastapi import FastAPI, UploadFile, File
   from PIL import Image
   import torch

   app = FastAPI()

   @app.post("/predict")
   async def predict(file: UploadFile = File(...)):
       image = Image.open(file.file).convert("RGB")
       # Run inference with model
       # prediction = model(transform(image))
       return {
           "status": "success",
           "plant": "Tomato Plant",
           "scientific_name": "Solanum lycopersicum",
           "disease": "Early Blight",
           "confidence": 96.4,
           "severity": "Moderate",
           "symptoms": "Dark concentric target spots on foliage...",
           "causes": "Alternaria solani fungal infection...",
           "prevention": "Crop rotation, drip irrigation...",
           "treatment": "Copper hydroxide, Mancozeb..."
       }
   ```
3. In `config.php`, update the configuration:
   ```php
   define('AI_MODE', 'api');
   define('AI_API_ENDPOINT', 'http://127.0.0.1:5000/predict');
   ```
4. LeafCare AI will now stream uploaded leaves directly to your Python ML server and display live deep-learning predictions!

---

## 🧪 Testing the Website

1. Navigate to **Leaf Detection** (`detect.php`).
2. Test any of the **6 Pre-loaded Sample Chips** (e.g., *Tomato Early Blight*, *Potato Late Blight*, *Healthy Leaf*).
3. Click **Analyze Leaf**.
4. Watch the laser scanning animation and inspect the resulting pathology card:
   * Confidence percentage score
   * Botanical plant and pathogen taxonomy
   * Clinical symptoms and causes
   * Organic vs Chemical treatment guidelines
   * "Print Report" button to generate a clean PDF
5. Navigate to **Diseases Library** (`diseases.php`):
   * Type in the search box (e.g., *"blight"*, *"mildew"*, *"apple"*).
   * Click category filter buttons.
   * Click **View Full Guide** on any disease card to view the pop-up modal.
6. Navigate to **History** (`history.php`):
   * View all recorded scans with thumbnails and timestamps.
   * Clear history using the "Clear History" button.
7. Click the **Sun/Moon Icon** in the top right to switch between Dark and Light mode.

---

## 📜 License & Academic Usage

This project is created for educational and agricultural research demonstration. Feel free to use and adapt it for university projects, seminars, or agricultural extension prototypes.
