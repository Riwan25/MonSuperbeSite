<?php 
require_once __DIR__ .'/../process/requireAuth.php';
requireAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/headers.php'; ?>
    <title>My Account - Ticket Management</title>
    <link rel="stylesheet" href="./styles/account.css">
</head>
<body class="body-image">
    <?php include 'components/navbar.php'; ?>
    
    <div class="account-container center-children full-screen-navbar">
        <div class="account-card">
            <h2>Connected as</h2>
            <div class="account-info">
                <p><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                <p><span class="role-badge"><?php echo htmlspecialchars($_SESSION['role_name'] ?? 'N/A'); ?></span></p>
            </div>
            <form action="../process/processLogout.php" method="POST">
                <button type="submit" class="disconnect-btn">Disconnect</button>
            </form>
        </div>
    </div>
</body>
</html>
