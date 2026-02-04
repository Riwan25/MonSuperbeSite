<?php 
require_once __DIR__ .'/../process/requireAuth.php';
requireAuth(['Supervisor']);
require_once __DIR__ .'/../process/processSupervisor.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/headers.php'; ?>
    <title>Supervisor - Ticket Management</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/supervisor.css">
    <link rel="stylesheet" href="styles/createTicket.css">
</head>
<body class="body-image">
    <?php include 'components/navbar.php'; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <div class="tickets-container tickets-container-wide">
        <div class="tickets-header">
            <h1>Supervisor Dashboard</h1>
            <div class="header-actions">
                <a href="user.php" class="header-btn btn-manage-users">
                    <i class="fa-solid fa-people-roof"></i>
                    Manage Users
                </a>
                <a href="createTicket.php" class="header-btn btn-create-ticket">
                    <i class="fa-solid fa-plus"></i>
                    Create Ticket
                </a>
            </div>
        </div>

        

        <!-- Tabs -->
        <div class="tabs-container">
            <a href="?tab=to_assign" class="tab-btn <?php echo $currentTab === 'to_assign' ? 'active' : ''; ?>">
                To Assign <span class="tab-count"><?php echo $toAssignCount; ?></span>
            </a>
            <a href="?tab=pending" class="tab-btn <?php echo $currentTab === 'pending' ? 'active' : ''; ?>">
                Pending <span class="tab-count"><?php echo $pendingCount; ?></span>
            </a>
            <a href="?tab=closed" class="tab-btn <?php echo $currentTab === 'closed' ? 'active' : ''; ?>">
                Closed <span class="tab-count"><?php echo $closedCount; ?></span>
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
                    <div><?php echo $currentTab === 'to_assign' ? 'Action' : ($currentTab === 'pending' ? 'Assigned To' : ''); ?></div>
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
                            <?php if ($currentTab === 'to_assign'): ?>
                                <button class="assign-btn" onclick="event.stopPropagation(); openAssignModal(<?php echo $ticket->getId(); ?>)">
                                    Assign User
                                </button>
                            <?php elseif ($currentTab === 'pending'): ?>
                                <span class="email-badge">
                                    <?=$ticket->getAssignedUserEmail() ?? '<span class="empty-cell">Not assigned</span>'?>
                                </span>
                            <?php else: ?>
                                <span class="empty-cell">-</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-tickets">
                    <p>
                        <?php 
                        switch($currentTab) {
                            case 'to_assign':
                                echo 'No tickets to assign.';
                                break;
                            case 'pending':
                                echo 'No pending tickets.';
                                break;
                            case 'closed':
                                echo 'No closed tickets.';
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

    <!-- Assign User Modal -->
    <div class="modal-overlay" id="assignModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Assign Ticket</h3>
                <button class="modal-close" onclick="closeAssignModal()">&times;</button>
            </div>
            <form method="POST" action="supervisor.php?tab=<?php echo $currentTab; ?>">
                <input type="hidden" name="action" value="assign_ticket">
                <input type="hidden" name="ticket_id" id="modalTicketId">
                <div class="modal-body">
                    <label for="userSearch">Search by Email:</label>
                    <input type="text" id="userSearch" class="search-input" placeholder="Type to search users..." autocomplete="off">
                    <label for="userSelect" style="margin-top: 15px;">Select User to Assign:</label>
                    <select name="user_id" id="userSelect" required>
                        <option value="">-- Select a user --</option>
                        <?php foreach ($allUsers as $user): ?>
                            <option value="<?php echo $user->getId(); ?>" data-email="<?php echo htmlspecialchars(strtolower($user->getEmail())); ?>">
                                <?php echo htmlspecialchars($user->getEmail()); ?> 
                                (<?php echo htmlspecialchars($user->getRoleName()); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="noResults" class="no-results" style="display: none;">No users found matching your search.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeAssignModal()">Cancel</button>
                    <button type="submit" class="modal-btn modal-btn-confirm">Assign</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAssignModal(ticketId) {
            document.getElementById('modalTicketId').value = ticketId;
            document.getElementById('assignModal').classList.add('active');
            document.getElementById('userSearch').focus();
        }

        function closeAssignModal() {
            document.getElementById('assignModal').classList.remove('active');
            document.getElementById('userSelect').value = '';
            document.getElementById('userSearch').value = '';
            filterUsers('');
        }

        function filterUsers(searchTerm) {
            const select = document.getElementById('userSelect');
            const options = select.querySelectorAll('option');
            const noResults = document.getElementById('noResults');
            let hasVisibleOptions = false;
            
            searchTerm = searchTerm.toLowerCase().trim();
            
            options.forEach((option, index) => {
                if (index === 0) {
                    // Always show the placeholder option
                    option.style.display = '';
                    return;
                }
                
                const email = option.getAttribute('data-email') || '';
                if (searchTerm === '' || email.includes(searchTerm)) {
                    option.style.display = '';
                    hasVisibleOptions = true;
                } else {
                    option.style.display = 'none';
                }
            });
            
            noResults.style.display = hasVisibleOptions || searchTerm === '' ? 'none' : 'block';
            
            // Reset selection if current selection is hidden
            if (select.selectedOptions[0] && select.selectedOptions[0].style.display === 'none') {
                select.value = '';
            }
        }

        // Search input event listener
        document.getElementById('userSearch').addEventListener('input', function(e) {
            filterUsers(e.target.value);
        });

        // Close modal when clicking outside
        document.getElementById('assignModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAssignModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAssignModal();
            }
        });
    </script>
    
</body>
</html>
