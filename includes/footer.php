    </main>

    <!-- Floating Background Leaves for Nature Vibe -->
    <div class="leaf-particles" aria-hidden="true">
        <span class="leaf leaf-1"><i class="fa-solid fa-leaf"></i></span>
        <span class="leaf leaf-2"><i class="fa-solid fa-leaf"></i></span>
        <span class="leaf leaf-3"><i class="fa-solid fa-leaf"></i></span>
        <span class="leaf leaf-4"><i class="fa-solid fa-leaf"></i></span>
        <span class="leaf leaf-5"><i class="fa-solid fa-leaf"></i></span>
        <span class="leaf leaf-6"><i class="fa-solid fa-leaf"></i></span>
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top" aria-label="Back to top" title="Back to top">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- Global Footer -->
    <footer class="footer-wrapper">
        <div class="footer-top-gradient"></div>
        <div class="container footer-content">
            <div class="footer-grid">
                <!-- Col 1: Brand & Mission -->
                <div class="footer-col brand-col">
                    <div class="footer-brand">
                        <div class="logo-icon-box">
                            <i class="fa-solid fa-seedling"></i>
                        </div>
                        <span class="brand-name">LeafCare<span class="brand-accent">AI</span></span>
                    </div>
                    <p class="footer-description">
                        An intelligent plant pathology platform designed to diagnose leaf diseases, detect early fungal sporulation, and empower farmers and gardeners with proactive, eco-friendly treatment strategies.
                    </p>
                    <div class="tech-badge-row">
                        <span class="badge badge-tech"><i class="fa-brands fa-php"></i> PHP 8.2</span>
                        <span class="badge badge-tech"><i class="fa-solid fa-database"></i> MySQL</span>
                        <span class="badge badge-tech"><i class="fa-brands fa-js"></i> ES6 JavaScript</span>
                        <span class="badge badge-tech"><i class="fa-solid fa-brain"></i> CNN Architecture</span>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div class="footer-col">
                    <h4 class="footer-heading">Quick Navigation</h4>
                    <ul class="footer-links">
                        <li><a href="index.php"><i class="fa-solid fa-angle-right"></i> Home Portal</a></li>
                        <li><a href="detect.php"><i class="fa-solid fa-angle-right"></i> Live Leaf Scanner</a></li>
                        <li><a href="diseases.php"><i class="fa-solid fa-angle-right"></i> Diseases Library</a></li>
                        <li><a href="history.php"><i class="fa-solid fa-angle-right"></i> Detection History</a></li>
                        <li><a href="about.php"><i class="fa-solid fa-angle-right"></i> System Architecture</a></li>
                    </ul>
                </div>

                <!-- Col 3: Supported Plant Species -->
                <div class="footer-col">
                    <h4 class="footer-heading">Supported Crops</h4>
                    <ul class="footer-links">
                        <li><a href="diseases.php?search=Tomato"><i class="fa-solid fa-seedling"></i> Tomato (Early/Late Blight)</a></li>
                        <li><a href="diseases.php?search=Potato"><i class="fa-solid fa-seedling"></i> Potato (Late Blight)</a></li>
                        <li><a href="diseases.php?search=Grape"><i class="fa-solid fa-seedling"></i> Grape (Powdery Mildew)</a></li>
                        <li><a href="diseases.php?search=Apple"><i class="fa-solid fa-seedling"></i> Apple (Scab & Black Rot)</a></li>
                        <li><a href="diseases.php?search=Corn"><i class="fa-solid fa-seedling"></i> Corn / Maize (Blight)</a></li>
                        <li><a href="diseases.php?search=Pepper"><i class="fa-solid fa-seedling"></i> Bell Pepper (Bacterial Spot)</a></li>
                    </ul>
                </div>

                <!-- Col 4: Agricultural Notice & Contact -->
                <div class="footer-col">
                    <h4 class="footer-heading">Pathology Notice</h4>
                    <div class="footer-notice-box">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <p>
                            Computer vision predictions serve as an early advisory aid. Always consult local agricultural extension officers or certified agronomists before large-scale pesticide applications.
                        </p>
                    </div>
                    <div class="system-status-indicator">
                        <span class="status-dot <?php echo ($db_connected ?? false) ? 'online' : 'demo'; ?>"></span>
                        <span class="status-label">
                            Database: <?php echo ($db_connected ?? false) ? 'MySQL Connected' : 'Demo / Memory Mode'; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <strong>LeafCare AI</strong> – Plant Leaf & Fungal Disease Detection System. Crafted for Academic Excellence & Sustainable Agriculture.</p>
                <div class="footer-bottom-links">
                    <a href="about.php#methodology">Research Methodology</a>
                    <span>&bull;</span>
                    <a href="about.php#privacy">Data Privacy</a>
                    <span>&bull;</span>
                    <a href="about.php#disclaimer">Disclaimer</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Core Scripts -->
    <script src="js/script.js?v=2.0"></script>
</body>
</html>
