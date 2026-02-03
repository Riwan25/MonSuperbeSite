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
    <link rel="stylesheet" href="styles/supervisor.css">
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

    <div class="tickets-container">

        <!-- Ticket Info Card -->
        <div class="ticket-card">
            <div class="ticket-card-header">
                <h2>Ticket #<?php echo $ticket->getId(); ?></h2>
                <?php if (isset($_SESSION['role_name']) && $_SESSION['role_name'] === 'Supervisor'): ?>
                    <div class="header-actions">
                        <button class="header-btn btn-assign" onclick="openAssignModal(<?php echo $ticket->getId(); ?>)">
                            <i class="fa-solid fa-user-plus"></i>
                            <?php echo $ticket->getAssignedTo() ? 'Reassign' : 'Assign'; ?>
                        </button>
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

    <?php if (isset($_SESSION['role_name']) && $_SESSION['role_name'] === 'Supervisor'): ?>
    <!-- Assign User Modal -->
    <div class="modal-overlay" id="assignModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><?php echo $ticket->getAssignedTo() ? 'Reassign' : 'Assign'; ?> Ticket #<?php echo $ticket->getId(); ?></h3>
                <button class="modal-close" onclick="closeAssignModal()">&times;</button>
            </div>
            <form method="POST" action="ticket.php?id=<?php echo $ticket->getId(); ?>">
                <input type="hidden" name="action" value="assign_ticket">
                <div class="modal-body">
                    <label for="userSearch">Search by Email:</label>
                    <input type="text" id="userSearch" class="search-input" placeholder="Type to search users..." autocomplete="off">
                    <label for="userSelect" style="margin-top: 15px;">Select User to Assign:</label>
                    <select name="user_id" id="userSelect" required>
                        <option value="">-- Select a user --</option>
                        <?php foreach ($allUsers as $user): ?>
                            <option value="<?php echo $user->getId(); ?>" 
                                    data-email="<?php echo htmlspecialchars(strtolower($user->getEmail())); ?>"
                                    <?php echo ($ticket->getAssignedTo() == $user->getId()) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($user->getEmail()); ?> 
                                (<?php echo htmlspecialchars($user->getRoleName()); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="noResults" class="no-results" style="display: none;">No users found matching your search.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeAssignModal()">Cancel</button>
                    <button type="submit" class="modal-btn modal-btn-confirm"><?php echo $ticket->getAssignedTo() ? 'Reassign' : 'Assign'; ?></button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAssignModal(ticketId) {
            document.getElementById('assignModal').classList.add('active');
            document.getElementById('userSearch').focus();
        }

        function closeAssignModal() {
            document.getElementById('assignModal').classList.remove('active');
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
            
            if (select.selectedOptions[0] && select.selectedOptions[0].style.display === 'none') {
                select.value = '';
            }
        }

        document.getElementById('userSearch').addEventListener('input', function(e) {
            filterUsers(e.target.value);
        });

        document.getElementById('assignModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAssignModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAssignModal();
            }
        });
    </script>
    <?php endif; ?>
    
</body>
</html>
