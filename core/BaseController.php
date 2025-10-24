<?php
declare(strict_types=1);

/**
 * Базовый класс для всех контроллеров
 */
abstract class BaseController {
    protected array $data = [];
    protected ?array $currentUser = null;
    
    public function __construct() {
        $this->currentUser = Auth::getCurrentUser();
    }
    
    /**
     * Рендерит представление
     */
    protected function render(string $view, array $data = []): void {
        $this->data = array_merge($this->data, $data);
        $this->data['currentUser'] = $this->currentUser;
        
        extract($this->data);
        
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new Exception("View not found: {$view}");
        }
    }
    
    /**
     * Перенаправляет на другую страницу
     */
    protected function redirect(string $url): void {
        header("Location: {$url}");
        exit;
    }
    
    /**
     * Возвращает JSON ответ
     */
    protected function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Проверяет авторизацию
     */
    protected function requireAuth(): void {
        if (!$this->currentUser) {
            $this->redirect('/login');
        }
    }
    
    /**
     * Проверяет, что пользователь НЕ авторизован
     */
    protected function requireGuest(): void {
        if ($this->currentUser) {
            $this->redirect('/');
        }
    }
    
    /**
     * Получает POST данные с валидацией
     */
    protected function getPostData(array $fields): array {
        $data = [];
        $errors = [];
        
        foreach ($fields as $field => $rules) {
            $value = $_POST[$field] ?? '';
            
            if (isset($rules['sanitize']) && $rules['sanitize']) {
                $value = Security::sanitizeInput($value);
            }
            
            if (isset($rules['required']) && $rules['required'] && empty($value)) {
                $errors[$field] = "Поле {$field} обязательно для заполнения";
                continue;
            }
            
            if (isset($rules['validate']) && !empty($value)) {
                $validator = $rules['validate'];
                if (is_callable($validator) && !$validator($value)) {
                    $errors[$field] = $rules['error_message'] ?? "Неверное значение поля {$field}";
                    continue;
                }
            }
            
            $data[$field] = $value;
        }
        
        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
        
        return $data;
    }
    
    /**
     * Обрабатывает исключения
     */
    protected function handleException(Exception $e): void {
        if ($e instanceof ValidationException) {
            $this->data['errors'] = $e->getErrors();
        } else {
            error_log("Controller error: " . $e->getMessage());
            $this->data['error'] = 'Произошла ошибка. Попробуйте позже.';
        }
    }
}

/**
 * Исключение для ошибок валидации
 */
class ValidationException extends Exception {
    private array $errors;
    
    public function __construct(array $errors) {
        $this->errors = $errors;
        parent::__construct('Validation failed');
    }
    
    public function getErrors(): array {
        return $this->errors;
    }
}
