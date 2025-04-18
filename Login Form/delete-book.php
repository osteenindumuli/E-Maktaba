<?php

session_start();

// Ensure only logged-in admins can access this page
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Include the database configuration file
require_once "config.php";

// Check if the book ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_page.php?error=" . urlencode("Invalid book ID."));
    exit();
}

$book_id = intval($_GET['id']);

// Fetch the book details to confirm it exists
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_page.php?error=" . urlencode("Book not found."));
    exit();
}

$book = $result->fetch_assoc();

// Check if the form is submitted to confirm deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete the book from the database
    $delete_stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $delete_stmt->bind_param("i", $book_id);

    if ($delete_stmt->execute()) {
        // Redirect with success message
        $success_message = "Book deleted successfully!";
        header("Location: admin_page.php?success=" . urlencode($success_message));
        exit();
    } else {
        // Redirect with error message
        $error_message = "Failed to delete the book. Please try again.";
        header("Location: admin_page.php?error=" . urlencode($error_message));
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <link rel="stylesheet" href="admin.css">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</head>
<body>

    <div class="container">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin_page.php">Admin</a>
            </div>
        </nav>

        <!-- Delete Confirmation Form -->
        <form action="delete-book.php?id=<?= htmlspecialchars($book_id); ?>" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width:50rem;">
            <h1 class="text-center pb-5 display-4 fs-3">Delete Book</h1>

            <p>Are you sure you want to delete the book <strong><?= htmlspecialchars($book['title']); ?></strong>?</p>

            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="admin_page.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

</body>
</html>