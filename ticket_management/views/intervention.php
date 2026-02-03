<?php 
require_once __DIR__ . '/../process/requireAuth.php';
requireAuth();
require_once __DIR__ . '/../process/processIntervention.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/headers.php'; ?>
    <title>Add Intervention - Ticket #<?php echo $ticket->getId(); ?></title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/ticket.css">
</head>
<body class="body-image">
    <?php include 'components/navbar.php'; ?>

    <div class="tickets-container">
        <!-- Back to Ticket Link -->
        <div class="back-link">
            <a href="ticket.php?id=<?php echo $ticket->getId(); ?>">&larr; Back to Ticket #<?php echo $ticket->getId(); ?></a>
        </div>

        <!-- Intervention Form Card -->
        <div class="ticket-card">
            <div class="ticket-card-header">
                <h2>Add Intervention for Ticket #<?php echo $ticket->getId(); ?></h2>
            </div>
            <div class="ticket-card-body">
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p class="error"><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="intervention.php?ticket_id=<?php echo $ticket->getId(); ?>" class="intervention-form">
                    <div class="form-group">
                        <label for="started_at">Start Date/Time</label>
                        <input 
                            type="datetime-local" 
                            id="started_at" 
                            name="started_at" 
                            required
                            value="<?php echo isset($_POST['started_at']) ? htmlspecialchars($_POST['started_at']) : ''; ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="ended_at">End Date/Time</label>
                        <input 
                            type="datetime-local" 
                            id="ended_at" 
                            name="ended_at" 
                            required
                            value="<?php echo isset($_POST['ended_at']) ? htmlspecialchars($_POST['ended_at']) : ''; ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="status_id">Ticket Status</label>
                        <select id="status_id" name="status_id" required>
                            <option value="">Select Status</option>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?php echo $status->getId(); ?>" 
                                    <?php 
                                    $selected = isset($_POST['status_id']) 
                                        ? $_POST['status_id'] == $status->getId() 
                                        : $ticket->getTicketStatusId() == $status->getId();
                                    echo $selected ? 'selected' : ''; 
                                    ?>>
                                    <?php echo htmlspecialchars($status->getName()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="comment">Comment (Optional)</label>
                        <textarea 
                            id="comment" 
                            name="comment" 
                            rows="4" 
                            placeholder="Add a comment about this intervention..."
                        ><?php echo isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : ''; ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Create Intervention</button>
                        <a href="ticket.php?id=<?php echo $ticket->getId(); ?>" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>
