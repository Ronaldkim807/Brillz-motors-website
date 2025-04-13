<?php
session_start();
include 'includes/db.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user's import requests
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM imports WHERE user_id = ?");
$stmt->execute([$user_id]);
$imports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import a Car - Brillz Motors</title>
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
        <a href="dashboard.php">Dashboard</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Sign Up</a>
    <?php endif; ?>
</nav>
    </header>
    <section class="import-form">
        <h2>Import a Car</h2>
        <form action="submit_import.php" method="POST">
            <label for="make">Car Make:</label>
            <input type="text" id="make" name="make" required>

            <label for="model">Car Model:</label>
            <input type="text" id="model" name="model" required>

            <label for="year">Year:</label>
            <input type="number" id="year" name="year" required>

            <label for="budget">Budget (KES):</label>
            <input type="number" id="budget" name="budget" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required></textarea>

            <label for="estimated_days">Estimated Days for Import:</label>
            <input type="number" id="estimated_days" name="estimated_days" required>

            <button type="submit" class="cta-button">Submit Request</button>
        </form>
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
});// Dark mode toggle
const themeToggle = document.getElementById('theme-toggle');
const body = document.body;

themeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    themeToggle.textContent = body.classList.contains('dark-mode') ? '☀️' : '🌙';
});

</script>
</body>
</html>