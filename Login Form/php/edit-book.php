<?php

session_start();

// Ensure only logged-in admins can access this page
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Include the database configuration file and helper functions
require_once "config.php"; // Adjust the path if `config.php` is not in the same directory
require_once "func-author.php"; // Include the helper function to fetch author details

// Check if the author ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_page.php?error=" . urlencode("Invalid author ID."));
    exit();
}

$author_id = intval($_GET['id']);

// Fetch the author details using the helper function
$author = get_author($conn, $author_id);

if ($author === null) {
    header("Location: admin_page.php?error=" . urlencode("Author not found."));
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['author_name'])) {
    $author_name = trim($_POST['author_name']); // Trim to remove unnecessary spaces

    // Validate the author's name
    if (empty($author_name)) {
        $error_message = "The author's name is required.";
        header("Location: edit-author.php?id=" . urlencode($author_id) . "&error=" . urlencode($error_message));
        exit();
    }

    // Update the author's name in the database
    $stmt = $conn->prepare("UPDATE author SET name = ? WHERE id = ?");
    if (!$stmt) {
        $error_message = "Failed to prepare the statement: " . $conn->error;
        header("Location: edit-author.php?id=" . urlencode($author_id) . "&error=" . urlencode($error_message));
        exit();
    }

    $stmt->bind_param("si", $author_name, $author_id);

    if ($stmt->execute()) {
        $success_message = "Author updated successfully!";
        header("Location: admin_page.php?success=" . urlencode($success_message));
        exit();
    } else {
        $error_message = "Failed to update the author. Please try again.";
        header("Location: edit-author.php?id=" . urlencode($author_id) . "&error=" . urlencode($error_message));
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
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

        <!-- Edit Author Form -->
        <form action="edit-author.php?id=<?= htmlspecialchars($author_id); ?>" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width:50rem;">
            <h1 class="text-center pb-5 display-4 fs-3">Edit Author</h1>

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
                <label class="form-label">Author Name</label>
                <input type="text" class="form-control" name="author_name" value="<?= htmlspecialchars($author['name']); ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update Author</button>
        </form>
    </div>

</body>
</html>