<?php
declare(strict_types=1);

/**
 * Базовый класс для всех моделей
 */
abstract class BaseModel {
    protected PDO $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    /**
     * Выполняет подготовленный запрос
     */
    protected function executeQuery(string $sql, array $params = []): PDOStatement {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    /**
     * Получает одну запись
     */
    protected function fetchOne(string $sql, array $params = []): ?array {
        $stmt = $this->executeQuery($sql, $params);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    /**
     * Получает все записи
     */
    protected function fetchAll(string $sql, array $params = []): array {
        $stmt = $this->executeQuery($sql, $params);
        return $stmt->fetchAll();
    }
    
    /**
     * Выполняет INSERT/UPDATE/DELETE запрос
     */
    protected function execute(string $sql, array $params = []): bool {
        try {
            $stmt = $this->executeQuery($sql, $params);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Получает ID последней вставленной записи
     */
    protected function getLastInsertId(): int {
        return (int) $this->db->lastInsertId();
    }
    
    /**
     * Начинает транзакцию
     */
    protected function beginTransaction(): bool {
        return $this->db->beginTransaction();
    }
    
    /**
     * Подтверждает транзакцию
     */
    protected function commit(): bool {
        return $this->db->commit();
    }
    
    /**
     * Откатывает транзакцию
     */
    protected function rollback(): bool {
        return $this->db->rollBack();
    }
}
