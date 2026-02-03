<?php 
require_once __DIR__ .'/../process/requireAuth.php';
requireAuth();
require_once __DIR__ .'/../process/processTicket.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/headers.php'; ?>
    <title>Ticket #<?php echo $ticket->getId(); ?></title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/ticket.css">
</head>
<body class="body-image">
    <?php include 'components/navbar.php'; ?>

    <div class="tickets-container">

        <!-- Ticket Info Card -->
        <div class="ticket-card">
            <div class="ticket-card-header">
                <h2>Ticket #<?php echo $ticket->getId(); ?></h2>
                <?php if (isset($_SESSION['role_name']) && $_SESSION['role_name'] === 'Supervisor'): ?>
                    <div class="header-actions">
                        <a href="updateTicket.php?id=<?php echo $ticket->getId(); ?>" class="header-btn btn-update">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Update Ticket
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="ticket-card-body">
                <div class="ticket-info-grid">
                    <div class="ticket-info-item">
                        <span class="ticket-info-label">Priority</span>
                        <span class="priority-badge priority-<?php echo $ticket->getPriorityId(); ?>">
                            <?php echo getPriorityName($ticket->getPriorityId()); ?>
                        </span>
                    </div>
                    <div class="ticket-info-item">
                        <span class="ticket-info-label">Status</span>
                        <span class="status-badge status-<?php echo $ticket->getTicketStatusId(); ?>">
                            <?php echo getStatusName($ticket->getTicketStatusId()); ?>
                        </span>
                    </div>
                    <div class="ticket-info-item">
                        <span class="ticket-info-label">Device</span>
                        <span class="ticket-info-value">
                            <?php echo getDeviceTypeName($device->getDeviceTypeId()) ?>:<?php echo htmlspecialchars($device->getExternalUid()); ?>
                        </span>
                    </div>
                    <div class="ticket-info-item">
                        <span class="ticket-info-label">Assigned To</span>
                        <span class="ticket-info-value"><?php echo $ticket->getAssignedUserEmail(); ?></span>
                    </div>
                    <div class="ticket-info-item">
                        <span class="ticket-info-label">Created At</span>
                        <span class="ticket-info-value"><?php echo $ticket->getCreatedAt()->format('Y-m-d H:i:s'); ?></span>
                    </div>
                    <div class="ticket-info-item">
                        <span class="ticket-info-label">Updated At</span>
                        <span class="ticket-info-value"><?php echo $ticket->getUpdatedAt()->format('Y-m-d H:i:s'); ?></span>
                    </div>
                </div>
                <div class="ticket-description-section">
                    <span class="ticket-info-label">Description</span>
                    <p class="ticket-description-text"><?php echo htmlspecialchars($ticket->getDescription()); ?></p>
                </div>
            </div>
        </div>

        <!-- Comments Card -->
        <div class="ticket-card">
            <div class="ticket-card-header">
                <h2>Comments (<?php echo count($comments); ?>)</h2>
            </div>
            <div class="ticket-card-body">
                <?php if (count($comments) > 0): ?>
                    <div class="comments-list">
                        <?php foreach ($comments as $comment): ?>
                            <div class="comment-item">
                                <div class="comment-header">
                                    <span class="comment-author"><?php echo htmlspecialchars($comment->getUserEmail()); ?></span>
                                    <span class="comment-date"><?php echo $comment->getCreatedAt()->format('Y-m-d H:i:s'); ?></span>
                                </div>
                                <div class="comment-content">
                                    <?php echo htmlspecialchars($comment->getContent()); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-comments">
                        <p>No comments yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="ticket-actions">
            <a href="intervention.php?ticket_id=<?php echo $ticket->getId(); ?>" class="btn-intervention">Add Intervention</a>
        </div>
    </div>
    
</body>
</html>
