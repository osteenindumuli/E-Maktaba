<?php

session_start();

// Ensure only logged-in admins can access this page
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Include the database configuration file and helper functions
require_once "config.php";
require_once "func-book.php"; // Include the helper function to fetch book details
require_once "func-author.php"; // Include the helper function to fetch authors
require_once "func-category.php"; // Include the helper function to fetch categories

// Check if the book ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_page.php?error=" . urlencode("Invalid book ID."));
    exit();
}

$book_id = intval($_GET['id']);

// Fetch the book details using the helper function
$book = get_book($conn, $book_id);

if ($book === null) {
    header("Location: ../admin_page.php?error=" . urlencode("Book not found."));
    exit();
}

// Fetch all authors and categories
$authors = get_all_authors($conn);
$categories = get_all_categories($conn);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_title']) && isset($_POST['book_author']) && isset($_POST['book_category'])) {
    $book_title = trim($_POST['book_title']);
    $book_author = intval($_POST['book_author']);
    $book_category = intval($_POST['book_category']);
    $book_description = trim($_POST['book_description']);

    // Validate the book's title
    if (empty($book_title)) {
        $error_message = "The book's title is required.";
        header("Location: edit-book.php?id=" . urlencode($book_id) . "&error=" . urlencode($error_message));
        exit();
    }

    if (empty($book_author)) {
        $error_message = "The book's author is required.";
        header("Location: edit-book.php?id=" . urlencode($book_id) . "&error=" . urlencode($error_message));
        exit();
    }

    if (empty($book_category)) {
        $error_message = "The book's category is required.";
        header("Location: edit-book.php?id=" . urlencode($book_id) . "&error=" . urlencode($error_message));
        exit();
    }
    
    if (empty($book_description)) {
        $error_message = "The book's description is required.";
        header("Location: edit-book.php?id=" . urlencode($book_id) . "&error=" . urlencode($error_message));
        exit();
    }

    // Initialize file paths
    $book_cover = $_FILES['book_cover']['name'];
    $book_file = $_FILES['book_file']['name'];

    $book_cover_tmp = $_FILES['book_cover']['tmp_name'];
    $book_file_tmp = $_FILES['book_file']['tmp_name'];

    // Check if a new cover file is uploaded
    if (!empty($book_cover)) {
        $book_cover_ext = strtolower(pathinfo($book_cover, PATHINFO_EXTENSION));
        $allowed_cover_exts = ['jpg', 'jpeg', 'png'];

        if (in_array($book_cover_ext, $allowed_cover_exts)) {
            $book_cover_name = uniqid("cover_", true) . "." . $book_cover_ext; // Generate unique file name
            $book_cover_path = "uploads/cover/" . $book_cover_name; // Full path for saving the file
            if (!move_uploaded_file($book_cover_tmp, $book_cover_path)) {
                $em = "Failed to upload book cover.";
                header("Location: edit-book.php?id=" . urlencode($book_id) . "&error=" . urlencode($em));
                exit();
            }
        } else {
            $em = "Invalid book cover file type. Only JPG, JPEG, and PNG are allowed.";
            header("Location: edit-book.php?id=" . urlencode($book_id) . "&error=" . urlencode($em));
            exit();
        }
    } else {
        // If no new cover is uploaded, keep the existing cover
        $book_cover_name = basename($book['cover']); // Extract only the file name from the existing path
    }

    // Check if a new book file is uploaded
    if (!empty($book_file)) {
        $book_file_ext = strtolower(pathinfo($book_file, PATHINFO_EXTENSION));
        $allowed_file_exts = ['pdf', 'epub', 'docx','pptx'];

        if (in_array($book_file_ext, $allowed_file_exts)) {
            $book_file_name = uniqid("file_", true) . "." . $book_file_ext; // Generate unique file name
            $book_file_path = "uploads/files/" . $book_file_name; // Full path for saving the file
            if (!move_uploaded_file($book_file_tmp, $book_file_path)) {
                $em = "Failed to upload book file.";
                header("Location: edit-book.php?id=" . urlencode($book_id) . "&error=" . urlencode($em));
                exit();
            }
        } else {
            $em = "Invalid book file type. Only PPTX PDF, EPUB, and DOCX are allowed.";
            header("Location: edit-book.php?id=" . urlencode($book_id) . "&error=" . urlencode($em));
            exit();
        }
    } else {
        // If no new file is uploaded, keep the existing file
        $book_file_name = basename($book['file']); // Extract only the file name from the existing path
    }

    // Update the book's details in the database
    $stmt = $conn->prepare("UPDATE books SET title = ?, author_id = ?, category_id = ?, description = ?, cover = ?, file = ? WHERE id = ?");
    $stmt->bind_param(
        "siisssi",
        $book_title,
        $book_author,
        $book_category,
        $book_description,
        $book_cover_name, // Save only the file name
        $book_file_name,  // Save only the file name
        $book_id
    );

    if ($stmt->execute()) {
        $success = "Book updated successfully!";
        header("Location: edit-book.php?id=" . urlencode($book_id) . "&success=" . urlencode($success));
        exit();
    } else {
        $em = "Failed to update the book. Please try again.";
        header("Location: edit-book.php?id=" . urlencode($book_id) . "&error=" . urlencode($em));
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="../admin.css">
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

        <!-- Edit Book Form -->
        <form action="edit-book.php?id=<?= htmlspecialchars($book_id); ?>" method="post" enctype="multipart/form-data" class="shadow p-4 rounded mt-5" style="width: 90%; max-width:50rem;">
            <h1 class="text-center pb-5 display-4 fs-3">Edit Book</h1>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>

            <div class="mb-3">
                <label class="form-label">Book Title</label>
                <input type="text" class="form-control" name="book_title" value="<?= htmlspecialchars($book['title']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Book Description</label>
                <input type="text" class="form-control" name="book_description" value="<?= htmlspecialchars($book['description']); ?>">
                 
            </div>

            <div class="mb-3">
                <label class="form-label">Book Author</label>
                <select name="book_author" class="form-control">
                    <option value="0">Select author</option>
                    <?php foreach ($authors as $author) { ?>
                        <option value="<?= $author['id']; ?>" <?= $book['author_id'] == $author['id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($author['name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Book Category</label>
                <select name="book_category" class="form-control">
                    <option value="0">Select category</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['id']; ?>" <?= $book['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($category['name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Book Cover</label>
                <input type="file" class="form-control" name="book_cover">
                <?php if (!empty($book['cover'])) { ?>
                    <small class="form-text text-muted">
                        Current Cover: <a href="uploads/cover/<?= htmlspecialchars($book['cover']); ?>" class="link-dark" target="_blank">View Cover</a>
                    </small>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Book File</label>
                <input type="file" class="form-control" name="book_file">
                <?php if (!empty($book['file'])) { ?>
                    <small class="form-text text-muted">
                        Current File: <a href="uploads/files/<?= htmlspecialchars($book['file']); ?>" class="link-dark" target="_blank">View File</a>
                    </small>
                <?php } ?>
            </div>
             

            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>

</body>
</html>