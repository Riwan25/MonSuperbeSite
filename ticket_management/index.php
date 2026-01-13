<?php

require_once __DIR__ .'/controller/UserController.php';

$users = UserController::getUsers();

var_dump($users);

?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Role ID</th>
            <th>Role name</th>
            <th>Leader ID</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user->getId()); ?></td>
            <td><?php echo htmlspecialchars($user->getEmail()); ?></td>
            <td><?php echo htmlspecialchars($user->getRoleId()); ?></td>
            <td><?php echo htmlspecialchars($user->getRoleName() ?? "null"); ?></td>
            <td><?php echo htmlspecialchars($user->getLeaderId() ?? "null"); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>