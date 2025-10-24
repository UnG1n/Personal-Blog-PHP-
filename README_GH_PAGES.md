# Personal Blog (PHP)

🚀 Современный личный блог на PHP 8+ с MySQL. MVC архитектура, безопасность, AJAX, адаптивный дизайн Bootstrap 5.

## 🎯 Демо-сайт

**👉 [Посетите демо-сайт](https://ung1n.github.io/Personal-Blog-PHP-/)**

## ✨ Возможности

- 🔐 **Система аутентификации** - регистрация, вход, выход с защитой от брутфорса
- 📝 **Управление постами** - создание, редактирование, удаление постов
- 💬 **Система комментариев** - с AJAX и валидацией
- 👍 **Лайки и дизлайки** - интерактивная система оценок
- 📊 **Аналитика профиля** - статистика постов, просмотров, лайков
- 🔒 **Безопасность** - CSRF защита, валидация, защита от SQL-инъекций и XSS
- 📱 **Адаптивный дизайн** - Bootstrap 5, современный UI/UX
- ⚡ **Производительность** - оптимизированные запросы, кэширование

## 🛠️ Технологии

- **Backend:** PHP 8.4+ с строгой типизацией
- **Database:** MySQL 5.7+ с оптимизированными индексами
- **Frontend:** Bootstrap 5, JavaScript ES6+, AJAX
- **Security:** CSRF защита, валидация, хеширование паролей
- **Architecture:** MVC паттерн, базовые классы, роутинг

## 🚀 Быстрый старт

### 1. Клонирование репозитория
```bash
git clone https://github.com/UnG1n/Personal-Blog-PHP-.git
cd Personal-Blog-PHP-
```

### 2. Настройка базы данных
```bash
# Создайте базу данных
mysql -u root -p -e "CREATE DATABASE blog_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Импортируйте схему
mysql -u root -p blog_db < database/schema.sql
```

### 3. Настройка конфигурации
Отредактируйте `config/database.php`:
```php
private const DB_HOST = 'localhost';
private const DB_NAME = 'blog_db';
private const DB_USER = 'root';
private const DB_PASS = 'your_password';
```

### 4. Запуск приложения
```bash
php -S localhost:8000 -t public
```

## 📊 Статистика проекта

- **Файлов:** 35+
- **Строк кода:** 3000+
- **PHP классов:** 12
- **JavaScript функций:** 8
- **SQL таблиц:** 5
- **Версия:** v2.0.0
- **Лицензия:** MIT

## 🔗 Ссылки

- **GitHub:** https://github.com/UnG1n/Personal-Blog-PHP-
- **Демо:** https://ung1n.github.io/Personal-Blog-PHP-/
- **API Документация:** [API.md](API.md)
- **Руководство по участию:** [CONTRIBUTING.md](CONTRIBUTING.md)

## 📄 Лицензия

Этот проект лицензирован под лицензией MIT - см. файл [LICENSE](LICENSE) для деталей.

---

⭐ **Если проект вам понравился, поставьте звезду на GitHub!**
