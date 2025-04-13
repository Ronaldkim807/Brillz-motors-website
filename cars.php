<?php
session_start();
include 'includes/db.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch cars from the database
try {
    $stmt = $conn->query("SELECT * FROM cars WHERE status = 'available'");
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Debugging: Check if $cars is an array
if (!is_array($cars)) {
    die("Error: Unable to fetch car data.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars for Sale - Brillz Motors</title>
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

    <section class="car-listings">
        <h2>Available Cars for Sale</h2>
        <div class="car-grid">
            <?php if (count($cars) > 0): ?>
                <?php foreach ($cars as $car): ?>
                    <div class="car">
                        <div class="car-images">
                            <img src="images/<?php echo $car['image_url']; ?>" alt="<?php echo $car['make'] . ' ' . $car['model']; ?>">
                            <div class="additional-images">
                                <img src="images/<?php echo str_replace('front', 'engine', $car['image_url']); ?>" alt="Engine">
                                <img src="images/<?php echo str_replace('front', 'interior', $car['image_url']); ?>" alt="Interior">
                            </div>
                        </div>
                        <h3><?php echo $car['make'] . ' ' . $car['model'] . ' (' . $car['year'] . ')'; ?></h3>
                        <p><strong>Price:</strong> KES <?php echo number_format($car['price'], 2); ?></p>
                        <p><strong>Mileage:</strong> <?php echo number_format($car['mileage']); ?> km</p>
                        <p><strong>Fuel Type:</strong> <?php echo $car['fuel_type']; ?></p>
                        <p><?php echo $car['description']; ?></p>
                        <button class="cta-button buy-button" data-car-id="<?php echo $car['car_id']; ?>">Buy Now</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No cars available at the moment.</p>
            <?php endif; ?>
        </div>
    </section>
<!-- Payment Modal -->
<div id="payment-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Complete Your Purchase</h2>
        <div class="payment-options">
            <div class="payment-option">
                <h3>Pay via PayPal</h3>
                <p>Click the button below to pay securely with PayPal.</p>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="your-paypal-email@example.com">
                    <input type="hidden" name="item_name" value="Car Purchase">
                    <input type="hidden" name="amount" value="<?php echo $car['price']; ?>">
                    <input type="hidden" name="currency_code" value="KES">
                    <button type="submit" class="cta-button">Pay with PayPal</button>
                </form>
            </div>
            <div class="payment-option">
                <h3>Bank Deposit</h3>
                <p>Deposit the payment to our bank account:</p>
                <p><strong>Bank:</strong> Equity Bank</p>
                <p><strong>Account Name:</strong> Brillz Motors</p>
                <p><strong>Account Number:</strong> 1234567890</p>
                <p><strong>Amount:</strong> KES <?php echo number_format($car['price'], 2); ?></p>
                <button class="cta-button" onclick="alert('Please deposit KES <?php echo number_format($car['price'], 2); ?> to the account above.')">Confirm Deposit</button>
            </div>
            <div class="payment-option">
                <h3>Pay with Cash</h3>
                <p>Contact us via WhatsApp or call to arrange cash payment.</p>
                <a href="https://wa.me/254716012357" class="cta-button" target="_blank">Chat on WhatsApp</a>
                <a href="tel:+254716012357" class="cta-button">Call Us</a>
            </div>
        </div>
    </div>
</div>
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
// Open payment modal when "Buy Now" is clicked
document.querySelectorAll('.buy-button').forEach(button => {
    button.addEventListener('click', () => {
        const carId = button.getAttribute('data-car-id');
        document.getElementById('payment-modal').style.display = 'flex';
    });
});

// Close payment modal when the close button is clicked
document.querySelector('.close').addEventListener('click', () => {
    document.getElementById('payment-modal').style.display = 'none';
});

// Close payment modal when clicking outside the modal
window.addEventListener('click', (event) => {
    const modal = document.getElementById('payment-modal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Show larger image when clicked
document.querySelectorAll('.additional-images img').forEach(image => {
    image.addEventListener('click', () => {
        const largeImage = document.createElement('div');
        largeImage.style.position = 'fixed';
        largeImage.style.top = '0';
        largeImage.style.left = '0';
        largeImage.style.width = '100%';
        largeImage.style.height = '100%';
        largeImage.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
        largeImage.style.display = 'flex';
        largeImage.style.justifyContent = 'center';
        largeImage.style.alignItems = 'center';
        largeImage.style.zIndex = '1000';

        const img = document.createElement('img');
        img.src = image.src;
        img.style.maxWidth = '90%';
        img.style.maxHeight = '90%';
        img.style.borderRadius = '10px';

        largeImage.appendChild(img);
        document.body.appendChild(largeImage);

        largeImage.addEventListener('click', () => {
            document.body.removeChild(largeImage);
        });
    });
});

</script>
</body>
</html>