<?php

/**
 * File upload helper function
 * Handles file uploads and validates file extensions.
 *
 * @param array $file The uploaded file from $_FILES.
 * @param array $allowed_exs Allowed file extensions.
 * @param string $upload_dir The directory to save the uploaded file.
 * @return array An array containing the status and data (file name or error message).
 */
function upload_file($file, $allowed_exs, $upload_dir) {
    $file_name = $file['name'];
    $file_tmp_name = $file['tmp_name'];
    $file_error = $file['error'];

    // Get file extension
    $file_ex = pathinfo($file_name, PATHINFO_EXTENSION);

    if ($file_error === 0) {
        if (in_array($file_ex, $allowed_exs)) {
            $new_file_name = uniqid("", true) . "." . $file_ex;
            $file_upload_path = $upload_dir . $new_file_name;
            if (move_uploaded_file($file_tmp_name, $file_upload_path)) {
                return ["status" => "success", "data" => $new_file_name];
            } else {
                return ["status" => "error", "data" => "Failed to upload the file."];
            }
        } else {
            return ["status" => "error", "data" => "You can't upload files of this type."];
        }
    } else {
        return ["status" => "error", "data" => "An unknown error occurred while uploading."];
    }
}
?>