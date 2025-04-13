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
    <title>Dashboard - Brillz Motors</title>
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
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <section class="dashboard">
        <h2>Your Import Requests</h2>
        <?php if (count($imports) > 0): ?>
            <div class="import-list">
                <?php foreach ($imports as $import): ?>
                    <div class="import-item">
                        <h3><?php echo $import['car_details']; ?></h3>
                        <p><strong>Budget:</strong> KES <?php echo number_format($import['budget'], 2); ?></p>
                        <p><strong>Description:</strong> <?php echo $import['description']; ?></p>
                        <p><strong>Estimated Days:</strong> <?php echo $import['estimated_days']; ?></p>
                        <p><strong>Status:</strong> <?php echo ucfirst(str_replace('_', ' ', $import['status'])); ?></p>
                        <a href="https://wa.me/254716012357" class="cta-button contact-button" target="_blank">Contact via WhatsApp</a>
                        <a href="tel:+254716012357" class="cta-button contact-button">Call Us</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No import requests found.</p>
        <?php endif; ?>
    </section>

    <!-- Chatbox -->
    <div class="chatbox">
        <div class="chatbox-header">
            <h3>Chat with Us</h3>
            <button class="chatbox-toggle">-</button>
        </div>
        <div class="chatbox-body">
            <div class="chatbox-messages"></div>
            <input type="text" class="chatbox-input" placeholder="Type a message...">
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Brillz Motors. All rights reserved.</p>
    </footer>

    <script>
        // Chatbox functionality
        const chatboxToggle = document.querySelector('.chatbox-toggle');
        const chatboxBody = document.querySelector('.chatbox-body');

        chatboxToggle.addEventListener('click', () => {
            chatboxBody.style.display = chatboxBody.style.display === 'none' ? 'block' : 'none';
            chatboxToggle.textContent = chatboxBody.style.display === 'none' ? '+' : '-';
        });

        // Notification reminders
        const imports = <?php echo json_encode($imports); ?>;
        imports.forEach(importItem => {
            const daysLeft = importItem.estimated_days - Math.floor((new Date() - new Date(importItem.created_at)) / (1000 * 60 * 60 * 24));
            if (daysLeft > 0) {
                alert(`Reminder: Your import request for ${importItem.car_details} has ${daysLeft} days left.`);
            }
        });
    </script>
</body>
</html>