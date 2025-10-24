<?php
declare(strict_types=1);

/**
 * Класс для маршрутизации запросов
 */
class Router {
    private array $routes = [];
    private string $basePath = '';
    
    public function __construct(string $basePath = '') {
        $this->basePath = rtrim($basePath, '/');
    }
    
    /**
     * Добавляет маршрут
     */
    public function addRoute(string $method, string $path, callable $handler): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $this->basePath . $path,
            'handler' => $handler
        ];
    }
    
    /**
     * Добавляет GET маршрут
     */
    public function get(string $path, callable $handler): void {
        $this->addRoute('GET', $path, $handler);
    }
    
    /**
     * Добавляет POST маршрут
     */
    public function post(string $path, callable $handler): void {
        $this->addRoute('POST', $path, $handler);
    }
    
    /**
     * Обрабатывает запрос
     */
    public function handleRequest(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        
        foreach ($this->routes as $route) {
            if ($this->matchRoute($route, $method, $path)) {
                $this->executeHandler($route['handler']);
                return;
            }
        }
        
        // 404 Not Found
        $this->handleNotFound();
    }
    
    /**
     * Проверяет соответствие маршрута
     */
    private function matchRoute(array $route, string $method, string $path): bool {
        if ($route['method'] !== $method) {
            return false;
        }
        
        // Точное совпадение
        if ($route['path'] === $path) {
            return true;
        }
        
        // Проверка параметрических маршрутов (например, /post/{id})
        if (preg_match('/^' . str_replace(['{', '}'], ['(?P<', '>[^/]+)'], $route['path']) . '$/', $path, $matches)) {
            // Сохраняем параметры в $_GET
            foreach ($matches as $key => $value) {
                if (is_string($key)) {
                    $_GET[$key] = $value;
                }
            }
            return true;
        }
        
        return false;
    }
    
    /**
     * Выполняет обработчик маршрута
     */
    private function executeHandler(callable $handler): void {
        try {
            $handler();
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }
    
    /**
     * Обрабатывает 404 ошибку
     */
    private function handleNotFound(): void {
        http_response_code(404);
        echo '404 Not Found';
    }
    
    /**
     * Обрабатывает ошибки
     */
    private function handleError(Exception $e): void {
        error_log("Router error: " . $e->getMessage());
        http_response_code(500);
        echo 'Internal Server Error';
    }
}
