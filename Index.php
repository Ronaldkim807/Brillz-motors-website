<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<div id="loading-spinner" class="loading-spinner">
    <div class="spinner"></div>
</div>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brillz Motors - Your Trusted Car Dealer in Nairobi</title>
    <button id="theme-toggle" class="theme-toggle">🌙</button>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
    <nav>
    <a href="index.php">Home</a>
    <a href="cars.php">Cars for Sale</a>
    <a href="import.php">Import a Car</a>
    <a href="trade.php">Trade Your Car</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Sign Up</a>
    <?php endif; ?>
</nav>
    </header>

    <section class="hero">
        <h1>Welcome to Brillz Motors</h1>
        <p>Your Trusted Car Dealer in Nairobi</p>
        <a href="cars.php" class="cta-button">Browse Cars</a>
    </section>
    <section id="contact" class="contact-section">
        <h2>Contact Us</h2>
        <div class="contact-container">
            <div class="contact-info">
                <h3>Get in Touch</h3>
                <p>We’d love to hear from you! Reach out to us via phone, email, or visit our office in Nairobi.</p>
                <ul>
                    <li><strong>Phone:</strong> +254 700 123 456</li>
                    <li><strong>Email:</strong> info@brillzmotors.com</li>
                    <li><strong>Address:</strong> 123 Mombasa Road, Nairobi, Kenya</li>
                </ul>
            </div>
            <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.808559999999!2d36.82154831475391!3d-1.292899835979916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10d7b3f3b3b5%3A0x1e3b9b9b9b9b9b9b!2sMombasa%20Road%2C%20Nairobi!5e0!3m2!1sen!2ske!4v1629999999999!5m2!1sen!2ske" 
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
            </iframe>
        </div>
    </section>

    <footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3>About Us</h3>
            <p>Brillz Motors is your trusted partner in buying, importing, and trading cars. We are committed to providing high-quality vehicles and exceptional customer service.</p>
        </div>
        <div class="footer-section">
            <h3>Our Mission</h3>
            <p>To deliver reliable and affordable vehicles while ensuring a seamless and enjoyable experience for our clients.</p>
        </div>
        <div class="footer-section">
            <h3>Our Vision</h3>
            <p>To become the leading car dealership in Kenya, known for transparency, quality, and customer satisfaction.</p>
        </div>
        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-media">
                <a href="https://facebook.com/brillzmotors" target="_blank" class="social-link">
                    <img src="images/facebook-icon.png" alt="Facebook">
                </a>
                <a href="https://twitter.com/brillzmotors" target="_blank" class="social-link">
                    <img src="images/twitter-icon.png" alt="Twitter">
                </a>
                <a href="https://instagram.com/brillzmotors" target="_blank" class="social-link">
                    <img src="images/instagram-icon.png" alt="Instagram">
                </a>
                <a href="https://linkedin.com/company/brillzmotors" target="_blank" class="social-link">
                    <img src="images/linkedin-icon.png" alt="LinkedIn">
                </a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Brillz Motors. All rights reserved.</p>
    </div>
</footer>
    <script>
// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent default anchor behavior
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth' // Smooth scroll
        });
    });
});
// Dark mode toggle
const themeToggle = document.getElementById('theme-toggle');
const body = document.body;

themeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    themeToggle.textContent = body.classList.contains('dark-mode') ? '☀️' : '🌙';
});
// Hide loading spinner when page is fully loaded
window.addEventListener('load', () => {
    const loadingSpinner = document.getElementById('loading-spinner');
    loadingSpinner.style.display = 'none';
});
</script>
<!-- Tidio Chatbot -->
<script src="//code.tidio.co/your-tidio-code.js" async></script>
</body>
</html>