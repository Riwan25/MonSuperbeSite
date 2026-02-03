<nav class="navbar">
    <h1 class="navbar-title">Ticket managment</h1>
    <div class="navbar-icons">
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <i class="fa-solid fa-house navbar-icon"></i>
        </a>
        <?php if (isset($_SESSION['role_name']) && $_SESSION['role_name'] === 'Supervisor'): ?>
            <a href="supervisor.php" style="text-decoration: none; color: inherit;">
                <i class="fa-solid fa-screwdriver-wrench navbar-icon"></i>
            </a>
        <?php endif; ?>
        <?php if (isset($_SESSION['role_name']) && ($_SESSION['role_name'] === 'Supervisor' || $_SESSION['role_name'] === 'Team Leader')): ?>
            <a href="teamLeader.php" style="text-decoration: none; color: inherit;">
                <i class="fa-solid fa-users navbar-icon"></i>
            </a>
        <?php endif; ?>
        <a href="account.php" style="text-decoration: none; color: inherit;">
            <i class="fa-solid fa-user navbar-icon"></i>
        </a>
    </div>
</nav>
