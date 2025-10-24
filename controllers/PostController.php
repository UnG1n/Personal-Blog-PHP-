<?php
declare(strict_types=1);

$postModel = new Post();
$commentModel = new Comment();
$currentUser = Auth::getCurrentUser();

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        Auth::requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = Security::sanitizeInput($_POST['title'] ?? '');
            $content = Security::sanitizeInput($_POST['content'] ?? '');
            
            if (!Security::validateTitle($title)) {
                $error = 'Заголовок не может быть пустым и не должен превышать 255 символов';
            } elseif (!Security::validateContent($content)) {
                $error = 'Содержимое поста не может быть пустым';
            } else {
                if ($postModel->create($currentUser['id'], $title, $content)) {
                    header('Location: /');
                    exit;
                } else {
                    $error = 'Ошибка при создании поста';
                }
            }
        }
        require __DIR__ . '/../views/posts/create.php';
        break;
        
    case 'edit':
        Auth::requireLogin();
        
        $postId = (int)($_GET['id'] ?? 0);
        $post = $postModel->getById($postId);
        
        if (!$post || $post['user_id'] !== $currentUser['id']) {
            header('Location: /');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = Security::sanitizeInput($_POST['title'] ?? '');
            $content = Security::sanitizeInput($_POST['content'] ?? '');
            
            if (!Security::validateTitle($title)) {
                $error = 'Заголовок не может быть пустым и не должен превышать 255 символов';
            } elseif (!Security::validateContent($content)) {
                $error = 'Содержимое поста не может быть пустым';
            } else {
                if ($postModel->update($postId, $currentUser['id'], $title, $content)) {
                    header('Location: /post/' . $postId);
                    exit;
                } else {
                    $error = 'Ошибка при обновлении поста';
                }
            }
        }
        require __DIR__ . '/../views/posts/edit.php';
        break;
        
    case 'delete':
        Auth::requireLogin();
        
        $postId = (int)($_GET['id'] ?? 0);
        $post = $postModel->getById($postId);
        
        if ($post && $post['user_id'] === $currentUser['id']) {
            $postModel->delete($postId, $currentUser['id']);
        }
        
        header('Location: /');
        exit;
        
    default:
        // Просмотр отдельного поста
        $postId = (int)($_GET['id'] ?? 0);
        $post = $postModel->getById($postId);
        
        if (!$post) {
            http_response_code(404);
            echo 'Пост не найден';
            exit;
        }
        
        // Увеличиваем счетчик просмотров
        $postModel->incrementViews($postId);
        $post['views']++;
        
        // Получаем комментарии
        $comments = $commentModel->getByPostId($postId);
        
        // Получаем статус лайков/дизлайков для текущего пользователя
        $likeStatus = $currentUser ? $postModel->getUserLikeStatus($postId, $currentUser['id']) : ['liked' => false, 'disliked' => false];
        
        require __DIR__ . '/../views/posts/view.php';
        break;
}
