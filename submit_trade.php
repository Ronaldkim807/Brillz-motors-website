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
    $mileage = $_POST['mileage'];
    $location = $_POST['location'];
    $phone = $_POST['phone'];
    $user_id = $_SESSION['user_id'];

    // Handle file uploads
    $photo_files = $_FILES['photos'];
    $document_files = $_FILES['documents'];

    // Validate file uploads
    $allowed_photo_types = ['image/jpeg', 'image/png', 'image/gif'];
    $allowed_document_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $photo_paths = [];
    $document_paths = [];

    // Upload photos
    foreach ($photo_files['tmp_name'] as $index => $tmp_name) {
        if ($photo_files['error'][$index] === UPLOAD_ERR_OK) {
            $file_type = mime_content_type($tmp_name);
            if (in_array($file_type, $allowed_photo_types)) {
                $file_name = basename($photo_files['name'][$index]);
                $file_path = $upload_dir . uniqid() . '_' . $file_name;
                move_uploaded_file($tmp_name, $file_path);
                $photo_paths[] = $file_path;
            }
        }
    }

    // Upload documents
    foreach ($document_files['tmp_name'] as $index => $tmp_name) {
        if ($document_files['error'][$index] === UPLOAD_ERR_OK) {
            $file_type = mime_content_type($tmp_name);
            if (in_array($file_type, $allowed_document_types)) {
                $file_name = basename($document_files['name'][$index]);
                $file_path = $upload_dir . uniqid() . '_' . $file_name;
                move_uploaded_file($tmp_name, $file_path);
                $document_paths[] = $file_path;
            }
        }
    }

    // Insert trade request into the database
    $stmt = $conn->prepare("INSERT INTO trades (user_id, car_details, mileage, location, phone, photo_paths, document_paths) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $car_details = "$make $model ($year)";
    $photo_paths_str = implode(',', $photo_paths);
    $document_paths_str = implode(',', $document_paths);

    if ($stmt->execute([$user_id, $car_details, $mileage, $location, $phone, $photo_paths_str, $document_paths_str])) {
        header("Location: trade.php?success=1");
        exit();
    } else {
        header("Location: trade.php?error=1");
        exit();
    }
} else {
    header("Location: trade.php");
    exit();
}
?>