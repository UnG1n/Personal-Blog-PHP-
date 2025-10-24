<?php
declare(strict_types=1);

Auth::requireLogin();

$userModel = new User();
$postModel = new Post();
$currentUser = Auth::getCurrentUser();

// Получаем статистику пользователя
$stats = $userModel->getUserStats($currentUser['id']);

// Получаем посты пользователя
$posts = $postModel->getByUserId($currentUser['id']);

require __DIR__ . '/../views/profile/index.php';
