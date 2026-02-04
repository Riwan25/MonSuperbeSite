<?php 
require_once __DIR__ .'/../process/requireAuth.php';
requireAuth(['Team Leader', 'Supervisor']);
$isTeamLeaderView = true;
require_once __DIR__ .'/../process/processDashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/headers.php'; ?>
    <title>Team Leader - Ticket Management</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/supervisor.css">
</head>
<body class="body-image">
    <?php include 'components/navbar.php'; ?>

    <div class="tickets-container tickets-container-wide">
        <div class="tickets-header">
            <h1>Team Tickets</h1>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <a href="?tab=pending" class="tab-btn <?php echo $currentTab === 'pending' ? 'active' : ''; ?>">
                Pending <span class="tab-count"><?php echo $pendingCount; ?></span>
            </a>
            <a href="?tab=closed" class="tab-btn <?php echo $currentTab === 'closed' ? 'active' : ''; ?>">
                Closed <span class="tab-count"><?php echo $closedCount; ?></span>
            </a>
            <a href="?tab=other" class="tab-btn <?php echo $currentTab === 'other' ? 'active' : ''; ?>">
                Other <span class="tab-count"><?php echo $otherCount; ?></span>
            </a>
        </div>

        <div class="tickets-list">
            <?php if (count($tickets) > 0): ?>
                <div class="ticket-header ticket-header-leader">
                    <div>N°</div>
                    <div>Priority</div>
                    <div>Status</div>
                    <div>Device type</div>
                    <div>Created At</div>
                    <div>Assigned To</div>
                </div>

                <?php foreach ($tickets as $ticket): ?>
                    <div class="ticket-item ticket-item-leader" onclick="window.location.href='ticket.php?id=<?php echo $ticket->getId(); ?>'">
                        <div class="ticket-id">
                            #<?php echo $ticket->getId(); ?>
                        </div>
                        <div>
                            <span class="mobile-healper">
                                Priority : 
                            </span>
                            <span class="priority-badge priority-<?php echo $ticket->getPriorityId(); ?>">
                                <?=getPriorityName($ticket->getPriorityId())?>
                            </span>
                        </div>
                        <div>
                            <span class="mobile-healper">
                                Status : 
                            </span>
                            <span class="status-badge status-<?php echo $ticket->getTicketStatusId(); ?>">
                                <?=getStatusName($ticket->getTicketStatusId())?>
                            </span>
                        </div>
                        <div>
                            <span class="mobile-healper">
                                Device :
                            </span>
                            <?=getDeviceTypeName($ticket->getDeviceTypeId())?>
                        </div>
                        <div class="ticket-date">
                            <span class="mobile-healper">
                                Created At :
                            </span>
                            <?=$ticket->getCreatedAt()->format('Y-m-d H:i:s')?>
                        </div>
                        <div class="ticket-assigned">
                            <span class="email-badge">
                                <?=$ticket->getAssignedUserEmail() ?? '<span class="empty-cell">Not assigned</span>'?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-tickets">
                    <p>
                        <?php 
                        switch($currentTab) {
                            case 'pending':
                                echo 'No pending tickets in your team.';
                                break;
                            case 'closed':
                                echo 'No closed tickets from your team.';
                                break;
                            case 'other':
                                echo 'No other tickets with interventions from your team.';
                                break;
                        }
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?tab=<?php echo $currentTab; ?>&page=1">&laquo; First</a>
                    <a href="?tab=<?php echo $currentTab; ?>&page=<?php echo $currentPage - 1; ?>">&lsaquo; Prev</a>
                <?php else: ?>
                    <span class="disabled">&laquo; First</span>
                    <span class="disabled">&lsaquo; Prev</span>
                <?php endif; ?>

                <?php
                $startPage = max(1, $currentPage - 2);
                $endPage = min($totalPages, $currentPage + 2);
                
                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <?php if ($i == $currentPage): ?>
                        <span class="current"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="?tab=<?php echo $currentTab; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?tab=<?php echo $currentTab; ?>&page=<?php echo $currentPage + 1; ?>">Next &rsaquo;</a>
                    <a href="?tab=<?php echo $currentTab; ?>&page=<?php echo $totalPages; ?>">Last &raquo;</a>
                <?php else: ?>
                    <span class="disabled">Next &rsaquo;</span>
                    <span class="disabled">Last &raquo;</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
</body>
</html>
