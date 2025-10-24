<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Создать пост - Личный блог</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
	<nav class="navbar navbar-expand-lg bg-body-tertiary">
		<div class="container">
			<a class="navbar-brand" href="/">Личный блог</a>
			<div class="ms-auto">
				<a class="btn btn-outline-primary" href="/">На главную</a>
			</div>
		</div>
	</nav>

	<main class="container py-4">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-header">
						<h4 class="mb-0">Создать новый пост</h4>
					</div>
					<div class="card-body">
						<?php if (isset($error)): ?>
							<div class="alert alert-danger"><?= Security::escapeHtml($error) ?></div>
						<?php endif; ?>

						<form method="POST">
							<div class="mb-3">
								<label for="title" class="form-label">Заголовок</label>
								<input type="text" class="form-control" id="title" name="title" required>
							</div>
							<div class="mb-3">
								<label for="content" class="form-label">Содержимое</label>
								<textarea class="form-control" id="content" name="content" rows="10" required></textarea>
							</div>
							<div class="d-flex gap-2">
								<button type="submit" class="btn btn-primary">Создать пост</button>
								<a href="/" class="btn btn-outline-secondary">Отмена</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
