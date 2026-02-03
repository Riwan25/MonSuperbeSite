<?php 
require_once __DIR__ .'/../process/requireAuth.php';
requireAuth();
require_once __DIR__ .'/../process/processCreateTicket.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/headers.php'; ?>
    <title>Create Ticket - Ticket Management</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/supervisor.css">
    <link rel="stylesheet" href="styles/createTicket.css">
</head>
<body class="body-image">
    <?php include 'components/navbar.php'; ?>

    <div class="tickets-container">
        <div class="tickets-header">
            <h1>Create New Ticket</h1>
        </div>

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

        <form method="POST" action="createTicket.php" class="ticket-form" style="border-radius: 0px 0px 8px 8px;">
            <input type="hidden" name="action" value="create_ticket">
            
            <!-- Device Section -->
            <div class="form-section">
                <h2 class="section-title">Device Information</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="device_type_id">Device Type <span class="required">*</span></label>
                        <select name="device_type_id" id="device_type_id" required>
                            <option value="">-- Select Device Type --</option>
                            <?php foreach ($deviceTypes as $type): ?>
                                <option value="<?php echo $type->getId(); ?>">
                                    <?php echo htmlspecialchars($type->getName()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="external_uid">Device Serial Number / UID <span class="required">*</span></label>
                        <input type="text" name="external_uid" id="external_uid" placeholder="Enter device serial number" required>
                    </div>
                </div>
            </div>

            <!-- Client Section -->
            <div class="form-section">
                <h2 class="section-title">Client Information</h2>
                
                <div class="client-option-tabs">
                    <button type="button" class="client-tab active" data-option="existing">Select Existing Client</button>
                    <button type="button" class="client-tab" data-option="new">Create New Client</button>
                </div>
                <input type="hidden" name="client_option" id="client_option" value="existing">
                
                <!-- Existing Client Selection -->
                <div id="existing-client-section" class="client-section active">
                    <div class="form-group">
                        <label for="clientSearch">Search Client</label>
                        <input type="text" id="clientSearch" class="search-input" placeholder="Type to search by name, phone or email..." autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="client_id">Select Client <span class="required">*</span></label>
                        <select name="client_id" id="client_id">
                            <option value="">-- Select a client --</option>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?php echo $client->getId(); ?>" 
                                        data-search="<?php echo htmlspecialchars(strtolower($client->getFullName() . ' ' . $client->getPhoneNumber() . ' ' . $client->getEmail())); ?>">
                                    <?php echo htmlspecialchars($client->getFullName()); ?> - <?php echo htmlspecialchars($client->getPhoneNumber()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <!-- New Client Form -->
                <div id="new-client-section" class="client-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="client_first_name">First Name <span class="required">*</span></label>
                            <input type="text" name="client_first_name" id="client_first_name" placeholder="Enter first name">
                        </div>
                        <div class="form-group">
                            <label for="client_last_name">Last Name <span class="required">*</span></label>
                            <input type="text" name="client_last_name" id="client_last_name" placeholder="Enter last name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="client_phone">Phone Number <span class="required">*</span></label>
                            <input type="tel" name="client_phone" id="client_phone" placeholder="Enter phone number">
                        </div>
                        <div class="form-group">
                            <label for="client_email">Email</label>
                            <input type="email" name="client_email" id="client_email" placeholder="Enter email (optional)">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ticket Details Section -->
            <div class="form-section">
                <h2 class="section-title">Ticket Details</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="priority_id">Priority <span class="required">*</span></label>
                        <select name="priority_id" id="priority_id" required>
                            <option value="">-- Select Priority --</option>
                            <?php foreach ($priorities as $priority): ?>
                                <option value="<?php echo $priority->getId(); ?>">
                                    <?php echo htmlspecialchars($priority->getName()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="assigned_to">Assign To (Optional)</label>
                        <select name="assigned_to" id="assigned_to">
                            <option value="">-- Leave unassigned --</option>
                            <?php foreach ($allUsers as $user): ?>
                                <option value="<?php echo $user->getId(); ?>">
                                    <?php echo htmlspecialchars($user->getEmail()); ?> 
                                    (<?php echo htmlspecialchars($user->getRoleName()); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description <span class="required">*</span></label>
                    <textarea name="description" id="description" rows="5" placeholder="Describe the issue in detail..." required></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="supervisor.php" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Create Ticket</button>
            </div>
        </form>
    </div>

    <script>
        // Client option tabs
        document.querySelectorAll('.client-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const option = this.dataset.option;
                
                // Update active tab
                document.querySelectorAll('.client-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Update hidden input
                document.getElementById('client_option').value = option;
                
                // Show/hide sections
                document.querySelectorAll('.client-section').forEach(section => {
                    section.classList.remove('active');
                });
                document.getElementById(option + '-client-section').classList.add('active');
                
                // Toggle required attributes
                if (option === 'existing') {
                    document.getElementById('client_id').setAttribute('required', 'required');
                    document.getElementById('client_first_name').removeAttribute('required');
                    document.getElementById('client_last_name').removeAttribute('required');
                    document.getElementById('client_phone').removeAttribute('required');
                } else {
                    document.getElementById('client_id').removeAttribute('required');
                    document.getElementById('client_first_name').setAttribute('required', 'required');
                    document.getElementById('client_last_name').setAttribute('required', 'required');
                    document.getElementById('client_phone').setAttribute('required', 'required');
                }
            });
        });

        // Client search filter
        document.getElementById('clientSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            const select = document.getElementById('client_id');
            const options = select.querySelectorAll('option');
            
            options.forEach((option, index) => {
                if (index === 0) {
                    option.style.display = '';
                    return;
                }
                
                const searchData = option.getAttribute('data-search') || '';
                if (searchTerm === '' || searchData.includes(searchTerm)) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
            
            // Reset selection if current selection is hidden
            if (select.selectedOptions[0] && select.selectedOptions[0].style.display === 'none') {
                select.value = '';
            }
        });

        // Form validation before submit
        document.querySelector('.ticket-form').addEventListener('submit', function(e) {
            const clientOption = document.getElementById('client_option').value;
            
            if (clientOption === 'existing') {
                const clientId = document.getElementById('client_id').value;
                if (!clientId) {
                    e.preventDefault();
                    alert('Please select a client.');
                    return false;
                }
            } else {
                const firstName = document.getElementById('client_first_name').value.trim();
                const lastName = document.getElementById('client_last_name').value.trim();
                const phone = document.getElementById('client_phone').value.trim();
                
                if (!firstName || !lastName || !phone) {
                    e.preventDefault();
                    alert('Please fill in all required client fields.');
                    return false;
                }
            }
        });
    </script>
    
</body>
</html>
