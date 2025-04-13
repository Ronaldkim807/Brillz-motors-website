
<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $phone = $_POST['phone'];

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $email, $password, $phone])) {
        // Registration successful
        $_SESSION['user_id'] = $conn->lastInsertId();
        $_SESSION['email'] = $email;
        header("Location: index.php"); // Redirect to home page
        exit();
    } else {
        $error = "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Brillz Motors</title>
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

    <section class="register-form">
    <h2>Sign Up</h2>
    <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>

            <button type="submit" class="cta-button">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
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
</script>
</body>
</html>