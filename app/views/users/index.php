<?php
// Check if a layout path was passed in data 
if (isset($data) && is_array($data)) {
    $user = $data['user'];

    // Check if the user is an admin or regular user
    $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'ADMIN';

    // If the user is admin, use admin layout
    if ($isAdmin) {
        // Create a content function that will be used in the admin layout
        $content = function ($layoutData) use ($user) {
            // Set the $user variable in the included file's scope
            $user = $user;
            include_once __DIR__ . '/index_content.php';
        };

        // Include the admin layout (which will call the content function)
        include_once __DIR__ . '/../layouts/AdminLayout/AdminLayout.php';
    } else {
        // For regular users, include the client layout
        $content = __DIR__ . '/index_content.php';
        include_once __DIR__ . '/../layouts/ClientLayout/ClientLayout.php';
    }
} else {
    echo "Error: No user data provided.";
}
