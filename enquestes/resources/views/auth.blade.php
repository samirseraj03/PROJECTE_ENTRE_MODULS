<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
    <div class="container">
        <h1>Iniciar sessió</h1>
        <form action="/login" method="post">
            <label for="email">Correu electrònic:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Contrasenya:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Iniciar sesión">
        </form>
        <a href="/forgot-password">Has oblidat la contrasenya?</a>
    </div>
</body>
</html>