<?php 
require_once __DIR__ .'/../process/requireAuth.php';
requireAuth(['Supervisor']);
require_once __DIR__ .'/../process/processUser.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/headers.php'; ?>
    <title>Manage Users - Ticket Management</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/supervisor.css">
    <link rel="stylesheet" href="styles/user.css">
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
            <h1>Manage Users</h1>
            <div class="header-actions">
                <button class="header-btn btn-create-user" onclick="openCreateModal()">
                    <i class="fa-solid fa-user-plus"></i>
                    Create User
                </button>
            </div>
        </div>

        <div class="tickets-list">
            <?php if (count($users) > 0): ?>
                <div class="ticket-header ticket-header-user">
                    <div>ID</div>
                    <div>Email</div>
                    <div>Role</div>
                    <div>Leader</div>
                    <div>Actions</div>
                </div>

                <?php foreach ($users as $user): ?>
                    <div class="ticket-item ticket-item-user">
                        <div class="ticket-id">
                            #<?php echo $user->getId(); ?>
                        </div>
                        <div class="user-email">
                            <i class="fa-solid fa-envelope"></i>
                            <?php echo htmlspecialchars($user->getEmail()); ?>
                        </div>
                        <div>
                            <span class="role-badge role-<?php echo strtolower(str_replace(' ', '-', $user->getRoleName())); ?>">
                                <?php echo htmlspecialchars($user->getRoleName()); ?>
                            </span>
                        </div>
                        <div class="user-leader">
                            <?php 
                            $leaderEmail = null;
                            if ($user->getLeaderId()) {
                                foreach ($teamLeaders as $leader) {
                                    if ($leader->getId() === $user->getLeaderId()) {
                                        $leaderEmail = $leader->getEmail();
                                        break;
                                    }
                                }
                            }
                            if ($leaderEmail) {
                                echo '<span class="email-badge">' . htmlspecialchars($leaderEmail) . '</span>';
                            } else {
                                ?>
                                <button class="assign-btn" onclick="event.stopPropagation(); openAssignLeaderModal(<?php echo $user->getId(); ?>, '<?php echo htmlspecialchars($user->getEmail()); ?>')">
                                    Assign Leader
                                </button>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="user-actions">
                            <button class="action-btn btn-edit" onclick="openEditModal(<?php 
                                echo htmlspecialchars(json_encode([
                                    'id' => $user->getId(),
                                    'email' => $user->getEmail(),
                                    'roleId' => $user->getRoleId(),
                                    'leaderId' => $user->getLeaderId()
                                ])); 
                            ?>)" title="Edit User">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <?php if ($user->getId() !== $_SESSION['user_id']): ?>
                                <button class="action-btn btn-delete" onclick="openDeleteModal(<?php echo $user->getId(); ?>, '<?php echo htmlspecialchars($user->getEmail()); ?>')" title="Delete User">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <?php else: ?>
                                <button class="action-btn btn-delete disabled" title="Cannot delete yourself" disabled>
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-tickets">
                    <p>No users found.</p>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=1">&laquo; First</a>
                    <a href="?page=<?php echo $currentPage - 1; ?>">&lsaquo; Prev</a>
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
                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?php echo $currentPage + 1; ?>">Next &rsaquo;</a>
                    <a href="?page=<?php echo $totalPages; ?>">Last &raquo;</a>
                <?php else: ?>
                    <span class="disabled">Next &rsaquo;</span>
                    <span class="disabled">Last &raquo;</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Create User Modal -->
    <div class="modal-overlay" id="createModal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h3><i class="fa-solid fa-user-plus"></i> Create New User</h3>
                <button class="modal-close" onclick="closeCreateModal()">&times;</button>
            </div>
            <form method="POST" action="user.php">
                <input type="hidden" name="action" value="create_user">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createEmail">Email <span class="required">*</span></label>
                        <input type="email" name="email" id="createEmail" placeholder="Enter email address" required>
                    </div>
                    <div class="form-group">
                        <label for="createPassword">Password <span class="required">*</span></label>
                        <input type="password" name="password" id="createPassword" placeholder="Enter password (min. 6 characters)" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="createRole">Role <span class="required">*</span></label>
                        <select name="role_id" id="createRole" required>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role->getId(); ?>">
                                    <?php echo htmlspecialchars($role->getName()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="createLeader">Team Leader (Optional)</label>
                        <select name="leader_id" id="createLeader">
                            <option value="">-- No Leader --</option>
                            <?php foreach ($teamLeaders as $leader): ?>
                                <option value="<?php echo $leader->getId(); ?>">
                                    <?php echo htmlspecialchars($leader->getEmail()); ?> (<?php echo htmlspecialchars($leader->getRoleName()); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeCreateModal()">Cancel</button>
                    <button type="submit" class="modal-btn modal-btn-confirm">Create User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h3><i class="fa-solid fa-user-pen"></i> Edit User</h3>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form method="POST" action="user.php">
                <input type="hidden" name="action" value="update_user">
                <input type="hidden" name="user_id" id="editUserId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editEmail">Email <span class="required">*</span></label>
                        <input type="email" name="email" id="editEmail" placeholder="Enter email address" required>
                    </div>
                    <div class="form-group">
                        <label for="editPassword">New Password (leave empty to keep current)</label>
                        <input type="password" name="password" id="editPassword" placeholder="Enter new password (min. 6 characters)" minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="editRole">Role <span class="required">*</span></label>
                        <select name="role_id" id="editRole" required>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role->getId(); ?>">
                                    <?php echo htmlspecialchars($role->getName()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editLeader">Team Leader (Optional)</label>
                        <select name="leader_id" id="editLeader">
                            <option value="">-- No Leader --</option>
                            <?php foreach ($teamLeaders as $leader): ?>
                                <option value="<?php echo $leader->getId(); ?>">
                                    <?php echo htmlspecialchars($leader->getEmail()); ?> (<?php echo htmlspecialchars($leader->getRoleName()); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="modal-btn modal-btn-confirm">Update User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa-solid fa-triangle-exclamation"></i> Confirm Delete</h3>
                <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
            </div>
            <form method="POST" action="user.php">
                <input type="hidden" name="action" value="delete_user">
                <input type="hidden" name="user_id" id="deleteUserId">
                <div class="modal-body">
                    <p class="delete-warning">Are you sure you want to delete this user?</p>
                    <p class="delete-email" id="deleteUserEmail"></p>
                    <p class="delete-note">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" class="modal-btn modal-btn-delete">Delete User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Assign Leader Modal -->
    <div class="modal-overlay" id="assignLeaderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Assign Leader</h3>
                <button class="modal-close" onclick="closeAssignLeaderModal()">&times;</button>
            </div>
            <form method="POST" action="user.php">
                <input type="hidden" name="action" value="assign_leader">
                <input type="hidden" name="user_id" id="assignLeaderUserId">
                <div class="modal-body">
                    <p class="assign-info">Assign a leader to: <strong id="assignLeaderUserEmail"></strong></p>
                    <label for="leaderSearch">Search by Email:</label>
                    <input type="text" id="leaderSearch" class="search-input" placeholder="Type to search leaders..." autocomplete="off">
                    <label for="leaderSelect" style="margin-top: 15px;">Select Leader:</label>
                    <select name="leader_id" id="leaderSelect" required>
                        <option value="">-- Select a leader --</option>
                        <?php foreach ($teamLeaders as $leader): ?>
                            <option value="<?php echo $leader->getId(); ?>" data-email="<?php echo htmlspecialchars(strtolower($leader->getEmail())); ?>">
                                <?php echo htmlspecialchars($leader->getEmail()); ?> 
                                (<?php echo htmlspecialchars($leader->getRoleName()); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="noLeaderResults" class="no-results" style="display: none;">No leaders found matching your search.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeAssignLeaderModal()">Cancel</button>
                    <button type="submit" class="modal-btn modal-btn-confirm">Assign</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Create Modal Functions
        function openCreateModal() {
            document.getElementById('createModal').classList.add('active');
            document.getElementById('createEmail').focus();
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.remove('active');
            document.getElementById('createEmail').value = '';
            document.getElementById('createPassword').value = '';
            document.getElementById('createRole').selectedIndex = 0;
            document.getElementById('createLeader').selectedIndex = 0;
        }

        // Edit Modal Functions
        function openEditModal(userData) {
            document.getElementById('editUserId').value = userData.id;
            document.getElementById('editEmail').value = userData.email;
            document.getElementById('editRole').value = userData.roleId;
            document.getElementById('editLeader').value = userData.leaderId || '';
            document.getElementById('editPassword').value = '';
            document.getElementById('editModal').classList.add('active');
            document.getElementById('editEmail').focus();
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        // Delete Modal Functions
        function openDeleteModal(userId, userEmail) {
            document.getElementById('deleteUserId').value = userId;
            document.getElementById('deleteUserEmail').textContent = userEmail;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Assign Leader Modal Functions
        function openAssignLeaderModal(userId, userEmail) {
            document.getElementById('assignLeaderUserId').value = userId;
            document.getElementById('assignLeaderUserEmail').textContent = userEmail;
            document.getElementById('assignLeaderModal').classList.add('active');
            document.getElementById('leaderSearch').focus();
        }

        function closeAssignLeaderModal() {
            document.getElementById('assignLeaderModal').classList.remove('active');
            document.getElementById('leaderSelect').value = '';
            document.getElementById('leaderSearch').value = '';
            filterLeaders('');
        }

        function filterLeaders(searchTerm) {
            const select = document.getElementById('leaderSelect');
            const options = select.querySelectorAll('option');
            const noResults = document.getElementById('noLeaderResults');
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

        // Leader search input event listener
        document.getElementById('leaderSearch').addEventListener('input', function(e) {
            filterLeaders(e.target.value);
        });

        // Close modals when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateModal();
                closeEditModal();
                closeDeleteModal();
                closeAssignLeaderModal();
            }
        });
    </script>
    
</body>
</html>
