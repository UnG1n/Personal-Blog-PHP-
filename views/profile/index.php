<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Профиль - Личный блог</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">
	<nav class="navbar navbar-expand-lg bg-body-tertiary">
		<div class="container">
			<a class="navbar-brand" href="/">Личный блог</a>
			<div class="ms-auto d-flex gap-2">
				<a class="btn btn-outline-primary" href="/">На главную</a>
				<a class="btn btn-primary" href="/post?action=create">Создать пост</a>
				<a class="btn btn-outline-secondary" href="/logout?action=logout">Выйти</a>
			</div>
		</div>
	</nav>

	<main class="container py-4">
		<div class="row">
			<div class="col-lg-8">
				<div class="card mb-4">
					<div class="card-header">
						<h4 class="mb-0">Мои посты</h4>
					</div>
					<div class="card-body">
						<?php if (empty($posts)): ?>
							<div class="alert alert-info">
								У вас пока нет постов. <a href="/post?action=create">Создайте первый пост</a>!
							</div>
						<?php else: ?>
							<?php foreach ($posts as $post): ?>
								<div class="card mb-3">
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
												<?= date('d.m.Y H:i', strtotime($post['created_at'])) ?>
												<?php if ($post['updated_at'] !== $post['created_at']): ?>
													| Обновлено: <?= date('d.m.Y H:i', strtotime($post['updated_at'])) ?>
												<?php endif; ?>
											</small>
											<div class="d-flex gap-2">
												<a href="/post?action=edit&id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-primary">
													<i class="bi bi-pencil"></i> Редактировать
												</a>
												<a href="/post?action=delete&id=<?= $post['id'] ?>" 
												   class="btn btn-sm btn-outline-danger"
												   onclick="return confirm('Вы уверены, что хотите удалить этот пост?')">
													<i class="bi bi-trash"></i> Удалить
												</a>
											</div>
										</div>
										<div class="d-flex gap-3 mt-2">
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
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
			
			<div class="col-lg-4">
				<div class="card mb-4">
					<div class="card-header">
						<h5 class="mb-0">Информация о профиле</h5>
					</div>
					<div class="card-body">
						<p><strong>Логин:</strong> <?= Security::escapeHtml($currentUser['login']) ?></p>
						<p><strong>Дата регистрации:</strong> <?= date('d.m.Y H:i', strtotime($currentUser['created_at'])) ?></p>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">Статистика</h5>
					</div>
					<div class="card-body">
						<div class="row text-center">
							<div class="col-6">
								<div class="border rounded p-3 mb-3">
									<h3 class="text-primary"><?= $stats['post_count'] ?></h3>
									<small class="text-muted">Постов</small>
								</div>
							</div>
							<div class="col-6">
								<div class="border rounded p-3 mb-3">
									<h3 class="text-success"><?= $stats['total_views'] ?></h3>
									<small class="text-muted">Просмотров</small>
								</div>
							</div>
							<div class="col-6">
								<div class="border rounded p-3">
									<h3 class="text-primary"><?= $stats['total_likes'] ?></h3>
									<small class="text-muted">Лайков</small>
								</div>
							</div>
							<div class="col-6">
								<div class="border rounded p-3">
									<h3 class="text-secondary"><?= $stats['total_dislikes'] ?></h3>
									<small class="text-muted">Дизлайков</small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
