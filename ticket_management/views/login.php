<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/headers.php'; ?>

    <title>Login</title>
    <link rel="stylesheet" href="./styles/auth.css">
</head>

<body class="body-image center-children">

<div class="auth-container">
    <div class="auth-card">
        <!-- Login Form -->
        <div class="form-wrapper active" id="loginForm">
        <form action="../process/processLogin.php" method="POST">
            <h1>Login</h1>

            <div class="input-group">
                <label>email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                >
            </div>

            <div class="input-group">
                <label>password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                >
            </div>

            <input type="submit" value="Login" class="btn-submit">

            <?php if (!empty($_SESSION['login_error'])): ?>
                <div class="error">
                    <?= htmlspecialchars($_SESSION['login_error']) ?>
                </div>
                <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>
        </form>
    </div>
    </div>
</div>

</body>
</html>
