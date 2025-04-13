<?php
session_start();
include 'includes/db.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $budget = $_POST['budget'];
    $description = $_POST['description'];
    $estimated_days = $_POST['estimated_days'];
    $user_id = $_SESSION['user_id'];

    // Insert import request into the database
    $stmt = $conn->prepare("INSERT INTO imports (user_id, car_details, budget, description, estimated_days) VALUES (?, ?, ?, ?, ?)");
    $car_details = "$make $model ($year)"; // Combine car details into a single string
    if ($stmt->execute([$user_id, $car_details, $budget, $description, $estimated_days])) {
        // Success: Redirect to a confirmation page or back to the form
        header("Location: import.php?success=1");
        exit();
    } else {
        // Error: Redirect back to the form with an error message
        header("Location: import.php?error=1");
        exit();
    }
} else {
    // Redirect if the form is not submitted
    header("Location: import.php");
    exit();
}
?>