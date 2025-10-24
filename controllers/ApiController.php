<?php
declare(strict_types=1);

header('Content-Type: application/json');

if (!Auth::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Необходима авторизация']);
    exit;
}

$postModel = new Post();
$commentModel = new Comment();
$currentUserId = Auth::getCurrentUserId();

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'like':
        $postId = (int)($_POST['post_id'] ?? 0);
        if ($postId > 0) {
            $result = $postModel->toggleLike($postId, $currentUserId);
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Неверный ID поста']);
        }
        break;
        
    case 'dislike':
        $postId = (int)($_POST['post_id'] ?? 0);
        if ($postId > 0) {
            $result = $postModel->toggleDislike($postId, $currentUserId);
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Неверный ID поста']);
        }
        break;
        
    case 'comment':
        $postId = (int)($_POST['post_id'] ?? 0);
        $text = Security::sanitizeInput($_POST['text'] ?? '');
        
        if ($postId > 0 && Security::validateComment($text)) {
            if ($commentModel->create($postId, $currentUserId, $text)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Ошибка при добавлении комментария']);
            }
        } else {
            echo json_encode(['error' => 'Неверные данные комментария']);
        }
        break;
        
    case 'delete_comment':
        $commentId = (int)($_POST['comment_id'] ?? 0);
        if ($commentId > 0) {
            if ($commentModel->delete($commentId, $currentUserId)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Ошибка при удалении комментария']);
            }
        } else {
            echo json_encode(['error' => 'Неверный ID комментария']);
        }
        break;
        
    case 'get_counters':
        $postId = (int)($_GET['post_id'] ?? 0);
        if ($postId > 0) {
            $post = $postModel->getById($postId);
            if ($post) {
                $likeStatus = $postModel->getUserLikeStatus($postId, $currentUserId);
                echo json_encode([
                    'success' => true,
                    'likes' => $post['likes'],
                    'dislikes' => $post['dislikes'],
                    'user_liked' => $likeStatus['liked'],
                    'user_disliked' => $likeStatus['disliked']
                ]);
            } else {
                echo json_encode(['error' => 'Пост не найден']);
            }
        } else {
            echo json_encode(['error' => 'Неверный ID поста']);
        }
        break;
        
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Неизвестное действие']);
        break;
}
