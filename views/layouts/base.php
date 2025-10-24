<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Личный блог' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .navbar-brand { font-weight: bold; }
        .card { box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
        .badge { font-size: 0.75em; }
        .comment { border-left: 3px solid #dee2e6; }
        .comment:hover { border-left-color: #0d6efd; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="/">Личный блог</a>
            <div class="ms-auto d-flex gap-2">
                <?php if ($currentUser): ?>
                    <a class="btn btn-outline-primary" href="/profile">Профиль</a>
                    <a class="btn btn-primary" href="/post?action=create">Создать пост</a>
                    <a class="btn btn-outline-secondary" href="/logout?action=logout">Выйти</a>
                <?php else: ?>
                    <a class="btn btn-outline-primary" href="/login?action=login">Войти</a>
                    <a class="btn btn-primary" href="/register?action=register">Регистрация</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= Security::escapeHtml($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= Security::escapeHtml($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($errors) && is_array($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= Security::escapeHtml($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <footer class="bg-light text-center py-3 mt-5">
        <div class="container">
            <small class="text-muted">© 2025 Личный блог. Все права защищены.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (isset($scripts)): ?>
        <?= $scripts ?>
    <?php endif; ?>
</body>
</html>
