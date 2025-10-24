<?php
declare(strict_types=1);

try {
    $postModel = new Post();
    $posts = $postModel->getAll(10, 0);
    $currentUser = Auth::getCurrentUser();
    
    require __DIR__ . '/../views/home.php';
} catch (Exception $e) {
    error_log("Error in HomeController: " . $e->getMessage());
    echo "Ошибка: " . $e->getMessage();
}
