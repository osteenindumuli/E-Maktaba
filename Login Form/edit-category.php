<?php

session_start();

// Ensure only logged-in admins can access this page
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Include the database configuration file
require_once "config.php"; // Adjust the path if `config.php` is not in the same directory
require_once "func-category.php"; // Include the helper function to fetch category details

// Check if the category ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_page.php?error=" . urlencode("Invalid category ID."));
    exit();
}

$category_id = intval($_GET['id']);

// Fetch the category details
$category = get_category($conn, $category_id);

if ($category === null) {
    header("Location: admin_page.php?error=" . urlencode("Category not found."));
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (empty($_POST['category_name'])) {
        $error = "Category name is required.";
        header("Location: edit-category.php?id=" . urlencode($category_id) . "&error=" . urlencode($error));
        exit();
    }

    $category_name = trim($_POST['category_name']);

    // Update the category in the database
    $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
    if (!$stmt) {
        $error = "Failed to prepare the statement: " . $conn->error;
        header("Location: edit-category.php?id=" . urlencode($category_id) . "&error=" . urlencode($error));
        exit();
    }

    $stmt->bind_param("si", $category_name, $category_id);

    if ($stmt->execute()) {
        $success = "Category updated successfully!";
        header("Location: admin_page.php?success=" . urlencode($success));
        exit();
    } else {
        $error = "Failed to update the category. Please try again.";
        header("Location: edit-category.php?id=" . urlencode($category_id) . "&error=" . urlencode($error));
        exit();
    }
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
        <form action="edit-category.php?id=<?= htmlspecialchars($category_id); ?>" class="shadow p-4 rounded mt-5"
              style="width: 90%; max-width:50rem;" method="post">
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
                <input type="text" class="form-control" name="category_name"
                       value="<?= htmlspecialchars($category['name']); ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>

</body>
</html>