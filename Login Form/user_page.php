<?php

session_start();

// Ensure only logged-in users can access this page
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Include database connection and helper functions
require_once "config.php"; // Use config.php for database connection
include "func-book.php";

include "func-category.php";  // Include helper functions for fetching books
$categories = get_all_categories($conn);

include "func-author.php";  // Include helper functions for fetching books
$authors = get_all_authors($conn);
 


// Fetch all categories
$categories = get_all_categories($conn);
 

// Check if a category filter is applied
$selected_category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;
$selected_author_id = isset($_GET['author_id']) ? intval($_GET['author_id']) : null;

// Fetch books based on the selected category
if ($selected_category_id) {
    $books = get_books_by_category($conn, $selected_category_id);
} elseif ($selected_author_id) {
    $books = get_books_by_author($conn, $selected_author_id);
} else {
    $books = get_all_books($conn); // Fetch all books if no filter is selected
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
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
                <a class="navbar-brand" href="user_page.php">User Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Search Bar -->
        <form action="php/search.php" method="get" style="width: 100%; max-width:30rem;" class="my-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search Book..." aria-label="Search Book..." required>
                <button class="btn btn-primary" type="submit">
                    <img src="images/Search.jpeg" width="20" alt="Search">
                </button>
            </div>
        </form>

        <div class="container">
            <div class="row">
                <!-- Category Section -->
                <div class="col-md-3">
                    <div class="category">
                        <div class="list-group">
                            <a href="user_page.php" class="list-group-item list-group-item-action <?= is_null($selected_category_id) ? 'active' : ''; ?>">All Categories</a>
                            <?php foreach ($categories as $category) { ?>
                                <a href="user_page.php?category_id=<?= $category['id']; ?>" 
                                   class="list-group-item list-group-item-action <?= $selected_category_id == $category['id'] ? 'active' : ''; ?>">
                                    <?= htmlspecialchars($category['name']); ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="author mt-4">
                    <div class="list-group">
                        <a href="user_page.php" class="list-group-item list-group-item-action <?= is_null($selected_author_id) ? 'active' : ''; ?>">All Authors</a>
                        <?php foreach ($authors as $author) { ?>
                            <a href="user_page.php?author_id=<?= $author['id']; ?>" 
                            class="list-group-item list-group-item-action <?= $selected_author_id == $author['id'] ? 'active' : ''; ?>">
                                <?= htmlspecialchars($author['name']); ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                </div>

                

                <!-- Books Section -->
                <div class="col-md-9">
                    <h1 class="my-5">Available Books</h1>

                    <?php if (!empty($books)) { ?>
                        <div class="row">
                            <?php foreach ($books as $book) { ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <!-- Book Cover -->
                                        <?php if (!empty($book['cover'])) { ?>
                                            <img src="uploads/cover/<?= htmlspecialchars($book['cover']); ?>" class="card-img-top img-fluid" alt="Book Cover" style="height: 200px; object-fit: cover;">
                                        <?php } else { ?>
                                            <img src="images/default-cover.jpg" class="card-img-top img-fluid" alt="Default Cover" style="height: 200px; object-fit: cover;">
                                        <?php } ?>

                                        <!-- Book Details -->
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($book['title']); ?></h5>
                                            <p class="card-text"><?= htmlspecialchars($book['description']); ?></p>
                                            <p class="card-text"><strong>By:</strong> <?= htmlspecialchars($book['author_name'] ?? 'Unknown'); ?></p>
                                            <p class="card-text"><strong>Category:</strong> <?= htmlspecialchars($book['category_name'] ?? 'Uncategorized'); ?></p>
                                        </div>

                                        <!-- Book File -->
                                        <div class="card-footer text-end">
                                            <?php if (!empty($book['file'])) { ?>
                                                <a href="uploads/files/<?= htmlspecialchars($book['file']); ?>" class="btn btn-primary btn-sm" target="_blank">View File</a>
                                                <a href="uploads/files/<?= htmlspecialchars($book['file']); ?>" class="btn btn-success btn-sm" download>Download File</a>
                                            <?php } else { ?>
                                                <span class="text-muted">No File Available</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p class="text-muted">No books available.</p>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>

</body>
</html>