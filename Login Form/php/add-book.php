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
if (isset($_POST['book_title'])) {
    $title = trim($_POST['book_title']); // Trim to remove unnecessary spaces

    // Validate the author's name
    if (empty($title)) {
        $em = "The title's name is required";
        header("Location: ../add-book.php?error=" . urlencode($em)); // Correct path and parameter
        exit();
    }

    if (isset($_POST['description_title'])) {
        $description = trim($_POST['description_title']); // Trim to remove unnecessary spaces
    
        // Validate the author's name
        if (empty($description)) {
            $em = "The description's name is required";
            header("Location: ../add-book.php?error=" . urlencode($em)); // Correct path and parameter
            exit();
        }

    } 
    if (isset($_POST['book_author'])) {
        $author = trim($_POST['book_author']); // Trim to remove unnecessary spaces
    
        // Validate the author's name
        if (empty($author)) {
            $em = "The Author's name is required";
            header("Location: ../add-book.php?error=" . urlencode($em)); // Correct path and parameter
            exit();
        }

    } 

    if (isset($_POST['book_category'])) {
        $category = trim($_POST['book_category']); // Trim to remove unnecessary spaces
    
        // Validate the author's name
        if (empty($category)) {
            $em = "The category's name is required";
            header("Location: ../add-book.php?error=" . urlencode($em)); // Correct path and parameter
            exit();
        }

    } 
     
    if ($_FILES['book_cover']['error'] === UPLOAD_ERR_NO_FILE) {
        $em = "The Book cover is required.";
        header("Location: ../add-book.php?error=" . urlencode($em));
        exit();
    }


    
    if ($_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
        $em = "The Book file is required.";
        header("Location: ../add-book.php?error=" . urlencode($em));
        exit();
    }
    // Handle file uploads
    $book_cover = $_FILES['book_cover']['name'];
    $book_file = $_FILES['file']['name'];

    $book_cover_tmp = $_FILES['book_cover']['tmp_name'];
    $book_file_tmp = $_FILES['file']['tmp_name'];

    $book_cover_path = "../uploads/cover/" . $book_cover;
    $book_file_path = "../uploads/files/" . $book_file;

    // Move uploaded files to their respective directories
    if (!move_uploaded_file($book_cover_tmp, $book_cover_path)) {
        $em = "Failed to upload book cover.";
        header("Location: ../add-book.php?error=" . urlencode($em) . "&" . $user_input);
        exit();
    }

    if (!move_uploaded_file($book_file_tmp, $book_file_path)) {
        $em = "Failed to upload book file.";
        header("Location: ../add-book.php?error=" . urlencode($em) . "&" . $user_input);
        exit();
    }

    // If validation passes, proceed with database insertion
    $stmt = $conn->prepare("INSERT INTO books (title, description, author_id, category_id, cover, file) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $title, $description, $author, $category, $book_cover, $book_file);

    if ($stmt->execute()) {
        $success = "Book added successfully!";
        header("Location: ../add-book.php?success=" . urlencode($success));
        exit();
    } else {
        $em = "Failed to add the book. Please try again.";
        header("Location: ../add-book.php?error=" . urlencode($em) . "&" . $user_input);
        exit();
    }

} 
    



 else {
    // Redirect to admin page if the form is not submitted
    header("Location: ../admin_page.php"); // Adjusted path to admin_page.php
    exit();
}

?>