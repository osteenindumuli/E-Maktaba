<?php

/**
 * Fetch all authors from the database.
 * @param mysqli $conn The database connection object.
 * @return array An array of authors, or an empty array if no authors are found.
 */
function get_all_authors($conn) {
    $sql = "SELECT * FROM author ORDER BY id DESC";
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
 * Fetch a single author by ID.
 * @param int $id The ID of the author.
 * @param mysqli $conn The database connection object.
 * @return array|null The author data as an associative array, or null if not found.
 */
 

function get_author($conn, $id) {
    // Ensure $conn is a valid mysqli object
    if (!($conn instanceof mysqli)) {
        throw new Exception("Invalid database connection.");
    }

    $sql = "SELECT * FROM author WHERE id = ?";
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

    // Check if a category was found
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the category as an associative array
    } else {
        return null; // Return null if no category is found
    }
}

?>