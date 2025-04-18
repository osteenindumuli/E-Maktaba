<?php

session_start();

// Ensure only logged-in admins can access this page
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Include database connection and helper functions
require_once "config.php"; // Use config.php for database connection

// Initialize search results
$search_results = [];

// Check if a search query is provided
if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $search_query = trim($_GET['query']);

    // Prepare the SQL query to search for books and join with authors and categories
    $stmt = $conn->prepare("
        SELECT books.*, author.name AS author_name, categories.name AS category_name 
        FROM books 
        LEFT JOIN author ON books.author_id = author.id 
        LEFT JOIN categories ON books.category_id = categories.id 
        WHERE books.title LIKE ? OR books.description LIKE ?
    ");
    $like_query = "%" . $search_query . "%";
    $stmt->bind_param("ss", $like_query, $like_query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all matching books
    if ($result->num_rows > 0) {
        $search_results = $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
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
                <a class="navbar-brand" href="admin_page.php">Admin DashBoard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="user_page.php">User</a>
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
            </div>
        </nav>

        <!-- Search Results -->
        <?php if (isset($search_query)) { ?>
            <h1 class="my-5">Search Results for "<?= htmlspecialchars($search_query); ?>"</h1>

            <?php if (!empty($search_results)) { ?>
                <div class="list-group">
                    <?php foreach ($search_results as $book) { ?>
                        <div class="list-group-item">
                            <div class="row">
                                <!-- Book Cover -->
                                <div class="col-md-2">
                                    <?php if (!empty($book['cover'])) { ?>
                                        <img src="uploads/cover/<?= htmlspecialchars($book['cover']); ?>" alt="Book Cover" class="img-fluid rounded">
                                    <?php } else { ?>
                                        <img src="images/default-cover.jpg" alt="Default Cover" class="img-fluid rounded">
                                    <?php } ?>
                                </div>

                                <!-- Book Details -->
                                <div class="col-md-6">
                                    <h5 class="mb-1"><?= htmlspecialchars($book['title']); ?></h5>
                                    <p class="mb-1"><?= htmlspecialchars($book['description']); ?></p>
                                    <p class="mb-1"><strong>By:</strong> <?= htmlspecialchars($book['author_name'] ?? 'Unknown'); ?></p>
                                    <p class="mb-1"><strong>Category:</strong> <?= htmlspecialchars($book['category_name'] ?? 'Uncategorized'); ?></p>
                                </div>

                                <!-- Book File -->
                                <div class="col-md-4 text-end">
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
                <p class="text-muted">No books found matching your search query.</p>
            <?php } ?>
        <?php } ?>

    </div>

</body>
</html>