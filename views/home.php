<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Личный блог</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
		<?php if ($currentUser): ?>
			<div class="alert alert-info">
				Добро пожаловать, <strong><?= Security::escapeHtml($currentUser['login']) ?></strong>!
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="col-lg-8">
				<h2 class="mb-4">Последние посты</h2>
				
				<?php if (empty($posts)): ?>
					<div class="alert alert-info">
						Пока нет постов. <a href="/register?action=register">Зарегистрируйтесь</a> и создайте первый пост!
					</div>
				<?php else: ?>
					<?php foreach ($posts as $post): ?>
						<div class="card mb-4">
							<div class="card-body">
								<h5 class="card-title">
									<a href="/post/<?= $post['id'] ?>" class="text-decoration-none">
										<?= Security::escapeHtml($post['title']) ?>
									</a>
								</h5>
								<p class="card-text">
									<?= Security::escapeHtml(substr($post['content'], 0, 200)) ?>
									<?php if (strlen($post['content']) > 200): ?>...<?php endif; ?>
								</p>
								<div class="d-flex justify-content-between align-items-center">
									<small class="text-muted">
										Автор: <?= Security::escapeHtml($post['author_login']) ?> | 
										<?= date('d.m.Y H:i', strtotime($post['created_at'])) ?>
									</small>
									<div class="d-flex gap-3">
										<span class="badge bg-success">
											<i class="bi bi-eye"></i> <?= $post['views'] ?>
										</span>
										<span class="badge bg-primary">
											<i class="bi bi-hand-thumbs-up"></i> <?= $post['likes'] ?>
										</span>
										<span class="badge bg-secondary">
											<i class="bi bi-hand-thumbs-down"></i> <?= $post['dislikes'] ?>
										</span>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			
			<div class="col-lg-4">
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">Информация</h5>
					</div>
					<div class="card-body">
						<p>Добро пожаловать в личный блог!</p>
						<p>Здесь вы можете:</p>
						<ul>
							<li>Создавать и редактировать посты</li>
							<li>Комментировать посты</li>
							<li>Ставить лайки и дизлайки</li>
							<li>Просматривать статистику</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


