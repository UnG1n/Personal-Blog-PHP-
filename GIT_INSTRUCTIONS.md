# 🔧 Инструкции по настройке Git и загрузке проекта

## 📥 Установка Git

### 1. Скачайте Git
Перейдите на https://git-scm.com/downloads и скачайте Git для Windows.

### 2. Установите Git
Запустите установщик и следуйте инструкциям (можно оставить настройки по умолчанию).

### 3. Проверьте установку
Откройте новое окно командной строки и выполните:
```bash
git --version
```

## ⚙️ Настройка Git

### 1. Настройте пользователя
```bash
git config --global user.name "UnG1n"
git config --global user.email "vovagidonikys@gmail.com"
```

### 2. Проверьте настройки
```bash
git config --list
```

## 🚀 Команды для загрузки на GitHub

### 1. Инициализация репозитория
```bash
# В папке проекта (D:\TestTasks\DIID_test)
git init
```

### 2. Добавление файлов
```bash
# Добавить все файлы
git add .

# Проверить статус
git status
```

### 3. Первый коммит
```bash
git commit -m "Initial commit: Personal Blog v2.0

- Modern PHP 8+ blog application
- MVC architecture with base classes
- Security features: CSRF protection, validation
- AJAX functionality for likes/comments
- Responsive Bootstrap 5 design
- MySQL database with optimized queries"
```

### 4. Создание репозитория на GitHub
1. Перейдите на https://github.com
2. Нажмите "New repository"
3. Название: `personal_blog`
4. Описание: `🚀 Современный личный блог на PHP 8+ с MySQL. MVC архитектура, безопасность, AJAX, адаптивный дизайн Bootstrap 5.`
5. Выберите "Public"
6. НЕ добавляйте README, .gitignore или лицензию
7. Нажмите "Create repository"

### 5. Подключение к GitHub
```bash
git remote add origin https://github.com/UnG1n/personal_blog.git
```

### 6. Загрузка на GitHub
```bash
git branch -M main
git push -u origin main
```

### 7. Создание релиза
```bash
git tag -a v2.0.0 -m "Release v2.0.0: Modern Personal Blog

Features:
- MVC architecture with base classes
- Enhanced security with CSRF protection
- AJAX functionality for likes and comments
- Responsive Bootstrap 5 design
- Optimized database queries
- Russian language support"

git push origin v2.0.0
```

## 📁 Финальная структура проекта

```
personal_blog/
├── .gitignore              # Игнорируемые файлы
├── README.md               # Основная документация
├── LICENSE                 # Лицензия MIT
├── CONTRIBUTING.md         # Руководство по участию
├── API.md                  # API документация
├── core/                   # Ядро приложения
│   ├── Router.php         # Класс маршрутизации
│   └── BaseController.php # Базовый контроллер
├── models/                 # Модели данных
│   ├── BaseModel.php      # Базовый класс
│   ├── User.php           # Модель пользователей
│   ├── Post.php           # Модель постов
│   └── Comment.php        # Модель комментариев
├── controllers/            # Контроллеры
│   ├── AuthController.php # Аутентификация
│   ├── PostController.php # Управление постами
│   ├── ProfileController.php # Профиль
│   └── ApiController.php  # AJAX API
├── views/                  # Представления
│   ├── layouts/           # Базовые шаблоны
│   ├── auth/              # Страницы входа
│   ├── posts/             # Страницы постов
│   └── profile/           # Страница профиля
├── auth/                   # Аутентификация
│   └── Auth.php           # Класс аутентификации
├── utils/                  # Утилиты
│   └── Security.php       # Безопасность
├── config/                 # Конфигурация
│   ├── database.php       # Настройки БД
│   └── app.php            # Настройки приложения
├── database/              # База данных
│   └── schema.sql         # Схема БД
└── public/                 # Публичная директория
    ├── index.php          # Главный роутер
    └── index.html         # Статическая страница
```

## ✅ Чек-лист готовности

- [x] Вспомогательные файлы удалены
- [x] Временные файлы с "New" удалены
- [x] Структура проекта очищена
- [x] Документация готова
- [x] .gitignore настроен
- [x] LICENSE добавлен
- [x] README.md обновлен

## 🎯 Следующие шаги

1. **Установите Git** (если не установлен)
2. **Выполните команды** из раздела "Команды для загрузки"
3. **Создайте репозиторий** на GitHub
4. **Загрузите проект** на GitHub
5. **Создайте релиз** v2.0.0

## 🏆 Готово!

После выполнения всех шагов ваш проект будет доступен по адресу:
`https://github.com/UnG1n/personal_blog`

**Удачи с вашим проектом! 🚀**
