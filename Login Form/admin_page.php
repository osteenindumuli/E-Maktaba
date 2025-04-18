<?php

session_start();

// Ensure only logged-in admins can access this page
if (!isset($_SESSION['email'])){
    header("Location: index.php");
    exit();
}

// Include database connection and helper functions
require_once "config.php"; // Use config.php for database connection
include "func-book.php"; 
$books = get_all_books($conn);


include "func-author.php";  // Include helper functions for fetching books
$authors = get_all_authors($conn);

include "func-category.php";  // Include helper functions for fetching books
$categories = get_all_categories($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 bg-light sidebar py-4">
                <h4 class="text-center">Admin Dashboard</h4>
                <ul class="nav flex-column">
                     
                    <li class="nav-item">
                        <a class="nav-link" href="user_page.php">User Page</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-book.php">Add Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-category.php">Add Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-author.php">Add Author</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <nav class="navbar navbar-light bg-light">
                    <div class="container-fluid">
                        <span class="navbar-text">
                            Welcome, <strong><?= htmlspecialchars($_SESSION['name']); ?></strong>
                        </span>
                        <form action="search.php" method="get" class="d-flex" style="max-width: 30rem;">
                            <input type="text" name="query" class="form-control me-2" placeholder="Search Book..." required>
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </form>
                    </div>
                </nav>

                <!-- Display Books -->
                <div class="container mt-4">
                    <?php if (empty($books)) { ?>
                        <h4>No books available</h4>
                    <?php } else { ?>
                        <h4>All Books</h4>
                        <table class="table table-bordered shadow">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($books as $book) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td>
                                            <img width="100" src="uploads/cover/<?= htmlspecialchars($book['cover']); ?>" alt="Book Cover">
                                            <a href="uploads/files/<?= htmlspecialchars($book['file']); ?>" class="d-block text-center">
                                                <?= htmlspecialchars($book['title']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            foreach ($authors as $author) {
                                                if ($author['id'] == $book['author_id']) {
                                                    echo htmlspecialchars($author['name']);
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($book['description']); ?></td>
                                        <td>
                                            <?php
                                            foreach ($categories as $category) {
                                                if ($category['id'] == $book['category_id']) {
                                                    echo htmlspecialchars($category['name']);
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="edit-book.php?id=<?= $book['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete-book.php?id=<?= $book['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>

                    <!-- Display Categories -->
                    <h4 class="mt-5">All Categories</h4>
                    <table class="table table-bordered shadow">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $j = 0;
                            foreach ($categories as $category) {
                                $j++;
                            ?>
                                <tr>
                                    <td><?= $j ?></td>
                                    <td><?= htmlspecialchars($category['name']); ?></td>
                                    <td>
                                        <a href="edit-category.php?id=<?= $category['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete-category.php?id=<?= $category['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <!-- Display Authors -->
                    <h4 class="mt-5">All Authors</h4>
                    <table class="table table-bordered shadow">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Author Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $k = 0;
                            foreach ($authors as $author) {
                                $k++;
                            ?>
                                <tr>
                                    <td><?= $k ?></td>
                                    <td><?= htmlspecialchars($author['name']); ?></td>
                                    <td>
                                        <a href="edit-author.php?id=<?= $author['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete-author.php?id=<?= $author['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>