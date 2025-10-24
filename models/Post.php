<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/BaseModel.php';

class Post extends BaseModel {
    
    public function create(int $userId, string $title, string $content): bool {
        return $this->execute('INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)', [$userId, $title, $content]);
    }
    
    public function getAll(int $limit = 10, int $offset = 0): array {
        $sql = '
            SELECT p.*, u.login as author_login 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            ORDER BY p.created_at DESC 
            LIMIT ? OFFSET ?
        ';
        return $this->fetchAll($sql, [$limit, $offset]);
    }
    
    public function getById(int $id): ?array {
        $sql = '
            SELECT p.*, u.login as author_login 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            WHERE p.id = ?
        ';
        return $this->fetchOne($sql, [$id]);
    }
    
    public function getByUserId(int $userId, int $limit = 10, int $offset = 0): array {
        $stmt = $this->db->prepare('
            SELECT p.*, u.login as author_login 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            WHERE p.user_id = ? 
            ORDER BY p.created_at DESC 
            LIMIT ? OFFSET ?
        ');
        $stmt->execute([$userId, $limit, $offset]);
        return $stmt->fetchAll();
    }
    
    public function update(int $id, int $userId, string $title, string $content): bool {
        $stmt = $this->db->prepare('
            UPDATE posts 
            SET title = ?, content = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE id = ? AND user_id = ?
        ');
        return $stmt->execute([$title, $content, $id, $userId]);
    }
    
    public function delete(int $id, int $userId): bool {
        $stmt = $this->db->prepare('DELETE FROM posts WHERE id = ? AND user_id = ?');
        return $stmt->execute([$id, $userId]);
    }
    
    public function incrementViews(int $id): void {
        $stmt = $this->db->prepare('UPDATE posts SET views = views + 1 WHERE id = ?');
        $stmt->execute([$id]);
    }
    
    public function toggleLike(int $postId, int $userId): array {
        // Проверяем, есть ли уже лайк от этого пользователя
        $stmt = $this->db->prepare('
            SELECT id FROM post_likes 
            WHERE post_id = ? AND user_id = ?
        ');
        $stmt->execute([$postId, $userId]);
        
        if ($stmt->fetch()) {
            // Убираем лайк
            $stmt = $this->db->prepare('DELETE FROM post_likes WHERE post_id = ? AND user_id = ?');
            $stmt->execute([$postId, $userId]);
            
            $stmt = $this->db->prepare('UPDATE posts SET likes = GREATEST(likes - 1, 0) WHERE id = ?');
            $stmt->execute([$postId]);
            
            return ['action' => 'removed', 'liked' => false];
        } else {
            // Убираем дизлайк, если есть
            $stmt = $this->db->prepare('DELETE FROM post_dislikes WHERE post_id = ? AND user_id = ?');
            $stmt->execute([$postId, $userId]);
            
            $stmt = $this->db->prepare('UPDATE posts SET dislikes = GREATEST(dislikes - 1, 0) WHERE id = ?');
            $stmt->execute([$postId]);
            
            // Добавляем лайк
            $stmt = $this->db->prepare('INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)');
            $stmt->execute([$postId, $userId]);
            
            $stmt = $this->db->prepare('UPDATE posts SET likes = likes + 1 WHERE id = ?');
            $stmt->execute([$postId]);
            
            return ['action' => 'added', 'liked' => true];
        }
    }
    
    public function toggleDislike(int $postId, int $userId): array {
        // Проверяем, есть ли уже дизлайк от этого пользователя
        $stmt = $this->db->prepare('
            SELECT id FROM post_dislikes 
            WHERE post_id = ? AND user_id = ?
        ');
        $stmt->execute([$postId, $userId]);
        
        if ($stmt->fetch()) {
            // Убираем дизлайк
            $stmt = $this->db->prepare('DELETE FROM post_dislikes WHERE post_id = ? AND user_id = ?');
            $stmt->execute([$postId, $userId]);
            
            $stmt = $this->db->prepare('UPDATE posts SET dislikes = GREATEST(dislikes - 1, 0) WHERE id = ?');
            $stmt->execute([$postId]);
            
            return ['action' => 'removed', 'disliked' => false];
        } else {
            // Убираем лайк, если есть
            $stmt = $this->db->prepare('DELETE FROM post_likes WHERE post_id = ? AND user_id = ?');
            $stmt->execute([$postId, $userId]);
            
            $stmt = $this->db->prepare('UPDATE posts SET likes = GREATEST(likes - 1, 0) WHERE id = ?');
            $stmt->execute([$postId]);
            
            // Добавляем дизлайк
            $stmt = $this->db->prepare('INSERT INTO post_dislikes (post_id, user_id) VALUES (?, ?)');
            $stmt->execute([$postId, $userId]);
            
            $stmt = $this->db->prepare('UPDATE posts SET dislikes = dislikes + 1 WHERE id = ?');
            $stmt->execute([$postId]);
            
            return ['action' => 'added', 'disliked' => true];
        }
    }
    
    public function getUserLikeStatus(int $postId, int $userId): array {
        $stmt = $this->db->prepare('
            SELECT 
                (SELECT COUNT(*) FROM post_likes WHERE post_id = ? AND user_id = ?) as liked,
                (SELECT COUNT(*) FROM post_dislikes WHERE post_id = ? AND user_id = ?) as disliked
        ');
        $stmt->execute([$postId, $userId, $postId, $userId]);
        $result = $stmt->fetch();
        
        return [
            'liked' => (bool)$result['liked'],
            'disliked' => (bool)$result['disliked']
        ];
    }
}
