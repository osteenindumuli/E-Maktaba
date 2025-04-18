<?php

function is_empty($var, $text, $location, $ms, $data) {
    if (empty($var)) {
        // Redirect with error message if the field is empty
        $error_message = $text . " is required.";
        header("Location: $location?$ms=$error_message&$data");
        exit();
    }
}

?>