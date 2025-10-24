<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Вход - Личный блог</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
	<nav class="navbar navbar-expand-lg bg-body-tertiary">
		<div class="container">
			<a class="navbar-brand" href="/">Личный блог</a>
		</div>
	</nav>

	<main class="container py-4">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h4 class="mb-0">Вход в систему</h4>
					</div>
					<div class="card-body">
						<?php if (isset($error)): ?>
							<div class="alert alert-danger"><?= Security::escapeHtml($error) ?></div>
						<?php endif; ?>

						<form method="POST">
							<div class="mb-3">
								<label for="login" class="form-label">Логин</label>
								<input type="text" class="form-control" id="login" name="login" required>
							</div>
							<div class="mb-3">
								<label for="password" class="form-label">Пароль</label>
								<input type="password" class="form-control" id="password" name="password" required>
							</div>
							<button type="submit" class="btn btn-primary">Войти</button>
						</form>
					</div>
					<div class="card-footer text-center">
						Нет аккаунта? <a href="/register?action=register">Зарегистрироваться</a>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
