<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/headers.php'; ?>

    <title>Login / Register</title>
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

            <?php if (!empty($_SESSION['register_success'])): ?>
                <div class="success">
                    <?= htmlspecialchars($_SESSION['register_success']) ?>
                </div>
                <?php unset($_SESSION['register_success']); ?>
            <?php endif; ?>

            <button type="button" class="toggle-button" onclick="toggleForms()">
                No account? Register
            </button>
        </form>
    </div>

    <!-- Register Form -->
    <div class="form-wrapper" id="registerForm">
        <form action="../process/processRegister.php" method="POST">
            <h1>Register</h1>

            <div class="input-group">
                <label>email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >
            </div>

            <div class="input-group">
                <label>password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    minlength="8"
                >
            </div>

            <div class="input-group">
                <label>confirm password</label>
                <input
                    type="password"
                    name="confirm_password"
                    placeholder="••••••••"
                    required
                    minlength="8"
                >
            </div>

            <input type="submit" value="Register" class="btn-submit">

            <?php if (!empty($_SESSION['register_error'])): ?>
                <div class="error">
                    <?= htmlspecialchars($_SESSION['register_error']) ?>
                </div>
                <?php unset($_SESSION['register_error']); ?>
            <?php endif; ?>

            <button type="button" class="toggle-button" onclick="toggleForms()">
                Already have an account? Login
            </button>
        </form>
    </div>
    </div>
</div>

<script>
    function toggleForms() {
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        
        loginForm.classList.toggle('active');
        registerForm.classList.toggle('active');
    }
</script>

</body>
</html>
