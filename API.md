# 🔌 API Документация

Документация по API endpoints блога.

## 📋 Общая информация

- **Base URL:** `http://localhost:8000`
- **Content-Type:** `application/json`
- **Authentication:** Session-based

## 🔐 Аутентификация

### POST /login
Вход в систему

**Параметры:**
```json
{
    "login": "username",
    "password": "password"
}
```

**Ответ:**
```json
{
    "success": true,
    "redirect": "/"
}
```

### POST /register
Регистрация нового пользователя

**Параметры:**
```json
{
    "login": "newuser",
    "password": "password123",
    "confirm_password": "password123"
}
```

**Ответ:**
```json
{
    "success": true,
    "message": "Регистрация успешна!"
}
```

## 📝 Посты

### GET /post/{id}
Получение поста по ID

**Ответ:**
```json
{
    "id": 1,
    "title": "Заголовок поста",
    "content": "Содержимое поста",
    "author_login": "username",
    "created_at": "2025-01-01 12:00:00",
    "views": 10,
    "likes": 5,
    "dislikes": 1
}
```

### POST /post
Создание нового поста

**Параметры:**
```json
{
    "title": "Заголовок",
    "content": "Содержимое поста"
}
```

**Ответ:**
```json
{
    "success": true,
    "redirect": "/"
}
```

## 👍 Лайки и дизлайки

### POST /api/like
Поставить/убрать лайк

**Параметры:**
```json
{
    "post_id": 1
}
```

**Ответ:**
```json
{
    "action": "added",
    "liked": true
}
```

### POST /api/dislike
Поставить/убрать дизлайк

**Параметры:**
```json
{
    "post_id": 1
}
```

**Ответ:**
```json
{
    "action": "added",
    "disliked": true
}
```

## 💬 Комментарии

### POST /api/comment
Добавить комментарий

**Параметры:**
```json
{
    "post_id": 1,
    "text": "Текст комментария"
}
```

**Ответ:**
```json
{
    "success": true
}
```

### POST /api/delete_comment
Удалить комментарий

**Параметры:**
```json
{
    "comment_id": 1
}
```

**Ответ:**
```json
{
    "success": true
}
```

## 📊 Статистика

### GET /api/get_counters
Получить счетчики поста

**Параметры:**
- `post_id` (query parameter)

**Ответ:**
```json
{
    "success": true,
    "likes": 10,
    "dislikes": 2,
    "user_liked": true,
    "user_disliked": false
}
```

## 🚨 Коды ошибок

| Код | Описание |
|-----|----------|
| 400 | Неверные параметры запроса |
| 401 | Необходима авторизация |
| 403 | Доступ запрещен |
| 404 | Ресурс не найден |
| 500 | Внутренняя ошибка сервера |

## 📝 Примеры использования

### JavaScript (AJAX)

```javascript
// Поставить лайк
fetch('/api/like', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'post_id=1'
})
.then(response => response.json())
.then(data => {
    if (data.error) {
        console.error(data.error);
    } else {
        console.log('Лайк поставлен');
    }
});
```

### PHP (cURL)

```php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/like');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'post_id=1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$data = json_decode($response, true);

if ($data['error']) {
    echo "Ошибка: " . $data['error'];
} else {
    echo "Успешно!";
}

curl_close($ch);
```

## 🔒 Безопасность

- Все POST запросы требуют CSRF токен
- Валидация всех входных данных
- Защита от SQL-инъекций
- Защита от XSS атак
- Ограничение попыток входа
