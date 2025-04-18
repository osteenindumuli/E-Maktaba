<?php

session_start();

// Ensure only logged-in users can access this page
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php"); // Adjusted path to index.php
    exit();
}

// Include the database configuration file
include "../config.php"; // Adjusted path to config.php

// Check if the form is submitted
if (isset($_POST['category_name'])) {
    $name = trim($_POST['category_name']); // Trim to remove unnecessary spaces

    // Validate the category's name
    if (empty($name)) {
        $em = "The category's name is required";
        header("Location: ../add-category.php?error=" . urlencode($em)); // Correct path and parameter
        exit();
    }

    // Insert the category's name into the database
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        $success = "Category added successfully!";
        header("Location: ../add-category.php?success=" . urlencode($success)); // Adjusted path to admin_page.php
        exit();
    } else {
        $em = "Failed to add the category. Please try again.";
        header("Location: ../add_category.php?error=" . urlencode($em)); // Adjusted path to add_category.php
        exit();
    }
} else {
    // Redirect to admin page if the form is not submitted
    header("Location: ../admin_page.php"); // Adjusted path to admin_page.php
    exit();
}

?>