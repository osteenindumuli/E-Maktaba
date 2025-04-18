<?php

/**
 * Fetch all books from the database.
 * @param mysqli $conn The database connection object.
 * @return array An array of books, or an empty array if no books are found.
 */
function get_all_books($conn) {
    $sql = "
        SELECT books.*, author.name AS author_name, categories.name AS category_name
        FROM books
        LEFT JOIN author ON books.author_id = author.id
        LEFT JOIN categories ON books.category_id = categories.id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

/**
 * Fetch a single book by ID.
 * @param mysqli $conn The database connection object.
 * @param int $id The ID of the book.
 * @return array|null The book data as an associative array, or null if not found.
 */
function get_book($conn, $id) {
    // Ensure $conn is a valid mysqli object
    if (!($conn instanceof mysqli)) {
        throw new Exception("Invalid database connection.");
    }

    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    // Bind the parameter (integer type)
    $stmt->bind_param("i", $id);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a book was found
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the book as an associative array
    } else {
        return null; // Return null if no book is found
    }
}

/**
 * Fetch all categories from the database.
 * @param mysqli $conn The database connection object.
 * @return array An array of categories, or an empty array if no categories are found.
 */
function get_books_by_category($conn, $category_id) {
    $sql = "
        SELECT books.*, author.name AS author_name, categories.name AS category_name
        FROM books
        LEFT JOIN author ON books.author_id = author.id
        LEFT JOIN categories ON books.category_id = categories.id
        WHERE books.category_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function get_books_by_author($conn, $author_id) {
    $sql = "
        SELECT books.*, author.name AS author_name, categories.name AS category_name
        FROM books
        LEFT JOIN author ON books.author_id = author.id
        LEFT JOIN categories ON books.category_id = categories.id
        WHERE books.author_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $author_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}


?>