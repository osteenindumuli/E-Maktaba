<?php

/**
 * Fetch all categories from the database.
 * @param mysqli $conn The database connection object.
 * @return array An array of categories, or an empty array if no categories are found.
 */
function get_all_categories($conn) {
    $sql = "SELECT * FROM categories";
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
 * Fetch a single category by ID.
 * @param int $id The ID of the category.
 * @param mysqli $conn The database connection object.
 * @return array|null The category data as an associative array, or null if not found.
 */

 
    // Ensure $conn is a valid mysqli object
    function get_category($conn, $id) {
        // Ensure $conn is a valid mysqli object
        if (!($conn instanceof mysqli)) {
            throw new Exception("Invalid database connection.");
        }
    
        $sql = "SELECT * FROM categories WHERE id = ?";
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



