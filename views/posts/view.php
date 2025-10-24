<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= Security::escapeHtml($post['title']) ?> - Личный блог</title>
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
		<div class="row">
			<div class="col-lg-8">
				<article class="card mb-4">
					<div class="card-body">
						<h1 class="card-title"><?= Security::escapeHtml($post['title']) ?></h1>
						<div class="d-flex justify-content-between align-items-center mb-3">
							<small class="text-muted">
								Автор: <?= Security::escapeHtml($post['author_login']) ?> | 
								<?= date('d.m.Y H:i', strtotime($post['created_at'])) ?>
								<?php if ($post['updated_at'] !== $post['created_at']): ?>
									| Обновлено: <?= date('d.m.Y H:i', strtotime($post['updated_at'])) ?>
								<?php endif; ?>
							</small>
							<?php if ($currentUser && $currentUser['id'] === $post['user_id']): ?>
								<div class="dropdown">
									<button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
										Действия
									</button>
									<ul class="dropdown-menu">
										<li><a class="dropdown-item" href="/post?action=edit&id=<?= $post['id'] ?>">Редактировать</a></li>
										<li><a class="dropdown-item text-danger" href="/post?action=delete&id=<?= $post['id'] ?>" onclick="return confirm('Вы уверены, что хотите удалить этот пост?')">Удалить</a></li>
									</ul>
								</div>
							<?php endif; ?>
						</div>
						
						<div class="card-text">
							<?= nl2br(Security::escapeHtml($post['content'])) ?>
						</div>
						
						<div class="d-flex justify-content-between align-items-center mt-4">
							<div class="d-flex gap-3">
								<span class="badge bg-success">
									<i class="bi bi-eye"></i> <?= $post['views'] ?> просмотров
								</span>
								<span class="badge bg-primary">
									<i class="bi bi-hand-thumbs-up"></i> <?= $post['likes'] ?> лайков
								</span>
								<span class="badge bg-secondary">
									<i class="bi bi-hand-thumbs-down"></i> <?= $post['dislikes'] ?> дизлайков
								</span>
							</div>
							
							<?php if ($currentUser): ?>
								<div class="d-flex gap-2">
									<button class="btn btn-sm <?= $likeStatus['liked'] ? 'btn-primary' : 'btn-outline-primary' ?>" 
											onclick="toggleLike(<?= $post['id'] ?>)">
										<i class="bi bi-hand-thumbs-up"></i> Лайк
									</button>
									<button class="btn btn-sm <?= $likeStatus['disliked'] ? 'btn-secondary' : 'btn-outline-secondary' ?>" 
											onclick="toggleDislike(<?= $post['id'] ?>)">
										<i class="bi bi-hand-thumbs-down"></i> Дизлайк
									</button>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</article>

				<!-- Комментарии -->
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">Комментарии (<?= count($comments) ?>)</h5>
					</div>
					<div class="card-body">
						<?php if ($currentUser): ?>
							<form id="commentForm" class="mb-4">
								<div class="mb-3">
									<textarea class="form-control" id="commentText" placeholder="Добавить комментарий..." rows="3" required></textarea>
								</div>
								<button type="submit" class="btn btn-primary">Добавить комментарий</button>
							</form>
						<?php else: ?>
							<div class="alert alert-info">
								<a href="/login?action=login">Войдите</a> или <a href="/register?action=register">зарегистрируйтесь</a>, чтобы оставлять комментарии.
							</div>
						<?php endif; ?>

						<div id="commentsList">
							<?php foreach ($comments as $comment): ?>
								<div class="comment mb-3 p-3 border rounded">
									<div class="d-flex justify-content-between align-items-start">
										<div>
											<strong><?= Security::escapeHtml($comment['author_login']) ?></strong>
											<small class="text-muted ms-2"><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></small>
										</div>
										<?php if ($currentUser && $currentUser['id'] === $comment['user_id']): ?>
											<button class="btn btn-sm btn-outline-danger" onclick="deleteComment(<?= $comment['id'] ?>)">
												<i class="bi bi-trash"></i>
											</button>
										<?php endif; ?>
									</div>
									<div class="mt-2"><?= nl2br(Security::escapeHtml($comment['text'])) ?></div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-lg-4">
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0">Информация о посте</h5>
					</div>
					<div class="card-body">
						<p><strong>Автор:</strong> <?= Security::escapeHtml($post['author_login']) ?></p>
						<p><strong>Создан:</strong> <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></p>
						<?php if ($post['updated_at'] !== $post['created_at']): ?>
							<p><strong>Обновлен:</strong> <?= date('d.m.Y H:i', strtotime($post['updated_at'])) ?></p>
						<?php endif; ?>
						<p><strong>Просмотров:</strong> <?= $post['views'] ?></p>
						<p><strong>Лайков:</strong> <?= $post['likes'] ?></p>
						<p><strong>Дизлайков:</strong> <?= $post['dislikes'] ?></p>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		function toggleLike(postId) {
			fetch('/api/like?action=like', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: 'post_id=' + postId
			})
			.then(response => response.json())
			.then(data => {
				if (data.error) {
					alert(data.error);
				} else {
					// Обновляем счетчики без перезагрузки страницы
					updateLikeCounters();
				}
			});
		}

		function toggleDislike(postId) {
			fetch('/api/dislike?action=dislike', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: 'post_id=' + postId
			})
			.then(response => response.json())
			.then(data => {
				if (data.error) {
					alert(data.error);
				} else {
					// Обновляем счетчики без перезагрузки страницы
					updateLikeCounters();
				}
			});
		}

		document.getElementById('commentForm').addEventListener('submit', function(e) {
			e.preventDefault();
			const text = document.getElementById('commentText').value;
			
			fetch('/api/comment?action=comment', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: 'post_id=<?= $post['id'] ?>&text=' + encodeURIComponent(text)
			})
			.then(response => response.json())
			.then(data => {
				if (data.error) {
					alert(data.error);
				} else {
					// Перезагружаем только комментарии
					location.reload();
				}
			});
		});

		function updateLikeCounters() {
			// Получаем актуальные счетчики с сервера
			fetch('/api/get_counters?post_id=<?= $post['id'] ?>')
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Обновляем счетчики на странице
					document.querySelector('.badge.bg-primary').innerHTML = '<i class="bi bi-hand-thumbs-up"></i> ' + data.likes;
					document.querySelector('.badge.bg-secondary').innerHTML = '<i class="bi bi-hand-thumbs-down"></i> ' + data.dislikes;
					
					// Обновляем кнопки
					const likeBtn = document.querySelector('button[onclick*="toggleLike"]');
					const dislikeBtn = document.querySelector('button[onclick*="toggleDislike"]');
					
					if (data.user_liked) {
						likeBtn.className = 'btn btn-sm btn-primary';
						dislikeBtn.className = 'btn btn-sm btn-outline-secondary';
					} else if (data.user_disliked) {
						likeBtn.className = 'btn btn-sm btn-outline-primary';
						dislikeBtn.className = 'btn btn-sm btn-secondary';
					} else {
						likeBtn.className = 'btn btn-sm btn-outline-primary';
						dislikeBtn.className = 'btn btn-sm btn-outline-secondary';
					}
				}
			});
		}

		function deleteComment(commentId) {
			if (confirm('Вы уверены, что хотите удалить этот комментарий?')) {
				fetch('/api/delete_comment?action=delete_comment', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: 'comment_id=' + commentId
				})
				.then(response => response.json())
				.then(data => {
					if (data.error) {
						alert(data.error);
					} else {
						location.reload();
					}
				});
			}
		}
	</script>
</body>
</html>
