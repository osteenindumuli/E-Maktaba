<?php

session_start();

// Ensure only logged-in users can access this page
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php"); // Redirect to login page if not logged in
    exit();
}

// Include the database configuration file
include "../config.php"; // Ensure the correct path to config.php

// Check if the form is submitted
if (isset($_POST['category_name']) && isset($_POST['category_id'])) {
    $name = trim($_POST['category_name']); // Trim to remove unnecessary spaces
    $id = intval($_POST['category_id']); // Ensure the ID is an integer

    // Validate the category's name
    if (empty($name)) {
        $em = "The category's name is required.";
        header("Location: ../edit-category.php?id=" . urlencode($id) . "&error=" . urlencode($em)); // Redirect back with error
        exit();
    }

    // Update the category's name in the database
    $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
    if (!$stmt) {
        $em = "Failed to prepare the statement: " . $conn->error;
        header("Location: ../edit-category.php?id=" . urlencode($id) . "&error=" . urlencode($em)); // Redirect back with error
        exit();
    }

    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        $success = "Category updated successfully!";
        header("Location: ../admin_page.php?success=" . urlencode($success)); // Redirect to admin page with success message
        exit();
    } else {
        $em = "Failed to update the category. Please try again.";
        header("Location: ../edit-category.php?id=" . urlencode($id) . "&error=" . urlencode($em)); // Redirect back with error
        exit();
    }
} else {
    // Redirect to admin page if the form is not submitted
    header("Location: ../admin_page.php"); // Redirect to admin page
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
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

        <!-- Edit Category Form -->
        <!-- filepath: c:\xampp\htdocs\Login Form\edit-category.php -->
        <form action="php/edit-category.php" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width:50rem;">
    <h1 class="text-center pb-5 display-4 fs-3">Edit Category</h1>

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
        <label class="form-label">Category Name</label>
        <input type="text" class="form-control" name="category_name" value="<?= htmlspecialchars($category['name']); ?>">
    </div>

    <!-- Hidden input to pass the category ID -->
    <input type="hidden" name="category_id" value="<?= htmlspecialchars($category['id']); ?>">

    <button type="submit" class="btn btn-primary">Update Category</button>
</form>
    </div>

</body>
</html>