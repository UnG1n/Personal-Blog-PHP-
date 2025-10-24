<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Регистрация - Личный блог</title>
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
						<h4 class="mb-0">Регистрация</h4>
					</div>
					<div class="card-body">
						<?php if (isset($error)): ?>
							<div class="alert alert-danger"><?= Security::escapeHtml($error) ?></div>
						<?php endif; ?>

						<?php if (isset($success)): ?>
							<div class="alert alert-success"><?= Security::escapeHtml($success) ?></div>
						<?php endif; ?>

						<form method="POST">
							<div class="mb-3">
								<label for="login" class="form-label">Логин</label>
								<input type="text" class="form-control" id="login" name="login" required>
								<div class="form-text">Буквы (включая русские), цифры и подчеркивания (3-50 символов)</div>
							</div>
							<div class="mb-3">
								<label for="password" class="form-label">Пароль</label>
								<input type="password" class="form-control" id="password" name="password" required>
								<div class="form-text">Минимум 6 символов</div>
							</div>
							<div class="mb-3">
								<label for="confirm_password" class="form-label">Подтверждение пароля</label>
								<input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
							</div>
							<button type="submit" class="btn btn-primary">Зарегистрироваться</button>
						</form>
					</div>
					<div class="card-footer text-center">
						Уже есть аккаунт? <a href="/login?action=login">Войти</a>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
