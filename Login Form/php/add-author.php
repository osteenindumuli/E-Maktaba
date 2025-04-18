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
if (isset($_POST['author_name'])) {
    $name = trim($_POST['author_name']); // Trim to remove unnecessary spaces

    // Validate the author's name
    if (empty($name)) {
        $em = "The author's name is required";
        header("Location: ../add-author.php?error=" . urlencode($em)); // Correct path and parameter
        exit();
    }

    // Insert the author's name into the database
    $stmt = $conn->prepare("INSERT INTO author (name) VALUES (?)");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        $success = "Author added successfully!";
        header("Location: ../add-author.php?success=" . urlencode($success)); // Adjusted path to admin_page.php
        exit();
    } else {
        $em = "Failed to add the author. Please try again.";
        header("Location: ../add_author.php?error=" . urlencode($em)); // Adjusted path to add_author.php
        exit();
    }
} else {
    // Redirect to admin page if the form is not submitted
    header("Location: ../admin_page.php"); // Adjusted path to admin_page.php
    exit();
}

?>