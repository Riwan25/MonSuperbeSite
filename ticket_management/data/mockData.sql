-- Mock Data for Ticket Management System
-- Run this after createDb.sql and seedDb.sql

-- =============================================
-- USERS (password is 'password123' hashed with password_hash())
-- =============================================
INSERT INTO `users` (`email`, `password`, `role_id`, `leader_id`) VALUES
-- Supervisors (role_id = 3)
('admin@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, NULL),
('sarah.manager@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, NULL),

-- Team Leaders (role_id = 2)
('john.leader@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, NULL),
('emma.leader@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, NULL),
('michael.leader@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, NULL),

-- Users/Technicians (role_id = 1)
('alice.tech@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 3),
('bob.tech@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 3),
('charlie.tech@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 4),
('diana.tech@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 4),
('edward.tech@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 5),
('fiona.tech@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 5),
('george.tech@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 3);

-- =============================================
-- CLIENTS
-- =============================================
INSERT INTO `clients` (`first_name`, `last_name`, `phone_number`, `email`) VALUES
('Jean', 'Dupont', '+33612345678', 'jean.dupont@email.com'),
('Marie', 'Martin', '+33623456789', 'marie.martin@email.com'),
('Pierre', 'Bernard', '+33634567890', 'pierre.bernard@email.com'),
('Sophie', 'Petit', '+33645678901', 'sophie.petit@email.com'),
('Lucas', 'Robert', '+33656789012', 'lucas.robert@email.com'),
('Emma', 'Richard', '+33667890123', 'emma.richard@email.com'),
('Hugo', 'Durand', '+33678901234', 'hugo.durand@email.com'),
('Léa', 'Leroy', '+33689012345', 'lea.leroy@email.com'),
('Thomas', 'Moreau', '+33690123456', 'thomas.moreau@email.com'),
('Camille', 'Simon', '+33601234567', 'camille.simon@email.com'),
('Antoine', 'Laurent', '+33612345679', 'antoine.laurent@email.com'),
('Julie', 'Lefebvre', '+33623456790', 'julie.lefebvre@email.com'),
('Nicolas', 'Michel', '+33634567891', 'nicolas.michel@email.com'),
('Laura', 'Garcia', '+33645678902', 'laura.garcia@email.com'),
('Maxime', 'David', '+33656789013', 'maxime.david@email.com');

-- =============================================
-- DEVICES
-- device_type_id: 1=Laptop, 2=Desktop, 3=Tablet, 4=Smartphone, 5=Printer, 6=Router
-- =============================================
INSERT INTO `devices` (`external_uid`, `device_type_id`) VALUES
('LAPTOP-2024-001', 1),
('LAPTOP-2024-002', 1),
('LAPTOP-2024-003', 1),
('LAPTOP-2024-004', 1),
('LAPTOP-2024-005', 1),
('DESKTOP-2024-001', 2),
('DESKTOP-2024-002', 2),
('DESKTOP-2024-003', 2),
('DESKTOP-2024-004', 2),
('TABLET-2024-001', 3),
('TABLET-2024-002', 3),
('TABLET-2024-003', 3),
('PHONE-2024-001', 4),
('PHONE-2024-002', 4),
('PHONE-2024-003', 4),
('PRINTER-2024-001', 5),
('PRINTER-2024-002', 5),
('ROUTER-2024-001', 6),
('ROUTER-2024-002', 6),
('LAPTOP-2024-006', 1);

-- =============================================
-- TICKETS
-- ticket_status_id: 1=To assign, 2=To re assign, 3=Pending, 4=Resolved, 5=Closed
-- priority_id: 1=Low, 2=Medium, 3=High, 4=Critical
-- =============================================
INSERT INTO `tickets` (`device_id`, `ticket_status_id`, `priority_id`, `description`, `created_at`, `updated_at`, `assigned_to`, `client_id`) VALUES
(1, 3, 4, 'Laptop won\'t boot - shows blue screen of death. Employee cannot work.', '2026-01-15 08:30:00', '2026-01-15 10:00:00', 6, 1),
(18, 3, 4, 'Main office router is down. Entire floor has no internet access.', '2026-01-20 09:00:00', '2026-01-20 09:30:00', 10, 5),
(6, 3, 3, 'Desktop computer is extremely slow. Takes 10 minutes to boot.', '2026-01-18 14:00:00', '2026-01-19 09:00:00', 7, 2),
(16, 2, 3, 'Printer prints blank pages. Already replaced ink cartridge.', '2026-01-22 11:30:00', '2026-01-23 08:00:00', NULL, 3),
(2, 4, 3, 'Laptop keyboard not working properly. Several keys are unresponsive.', '2026-01-10 16:00:00', '2026-01-14 12:00:00', 8, 4),
(10, 3, 2, 'Tablet screen is cracked but still functional. Need replacement.', '2026-01-25 10:00:00', '2026-01-26 14:00:00', 9, 6),
(7, 1, 2, 'Desktop needs software update. Current version is outdated.', '2026-01-28 13:00:00', '2026-01-28 13:00:00', NULL, 7),
(13, 5, 2, 'Smartphone battery drains too fast. Replaced battery successfully.', '2026-01-05 09:30:00', '2026-01-08 16:00:00', 6, 8),
(3, 3, 2, 'Laptop camera not working for video calls.', '2026-01-27 08:45:00', '2026-01-27 11:00:00', 11, 9),
(17, 1, 2, 'Printer paper jam occurs frequently.', '2026-01-30 15:00:00', '2026-01-30 15:00:00', NULL, 10),
(8, 5, 1, 'Desktop monitor flickering occasionally. Fixed by replacing cable.', '2026-01-02 11:00:00', '2026-01-04 14:30:00', 7, 11),
(11, 4, 1, 'Tablet needs factory reset. User forgot password.', '2026-01-12 14:30:00', '2026-01-13 10:00:00', 9, 12),
(14, 5, 1, 'Smartphone screen protector needs replacement.', '2025-12-28 16:00:00', '2025-12-29 09:00:00', 10, 13),
(4, 3, 1, 'Laptop fan making noise. May need cleaning.', '2026-01-29 09:00:00', '2026-01-30 08:00:00', 12, 14),
(19, 1, 1, 'Router firmware needs to be updated.', '2026-01-31 10:30:00', '2026-01-31 10:30:00', NULL, 15),
(5, 4, 3, 'Laptop infected with malware. Cleaned and secured.', '2026-01-08 13:00:00', '2026-01-10 17:00:00', 8, 1),
(9, 2, 2, 'Desktop display settings reset after every reboot.', '2026-01-24 10:00:00', '2026-01-25 09:00:00', NULL, 2),
(12, 5, 1, 'Tablet app installation issue resolved.', '2026-01-06 15:00:00', '2026-01-07 11:00:00', 11, 3),
(15, 3, 2, 'Smartphone not syncing with email server.', '2026-01-26 12:00:00', '2026-01-27 14:00:00', 6, 4),
(20, 1, 4, 'New laptop setup required for new employee starting Monday.', '2026-01-31 14:00:00', '2026-01-31 14:00:00', NULL, 5);

-- =============================================
-- INTERVENTIONS
-- =============================================
INSERT INTO `interventions` (`ticket_id`, `user_id`, `created_at`, `started_at`, `ended_at`) VALUES
-- Completed interventions
(8, 6, '2026-01-05 10:00:00', '2026-01-05 10:30:00', '2026-01-08 15:30:00'),
(11, 7, '2026-01-02 11:30:00', '2026-01-02 14:00:00', '2026-01-04 14:00:00'),
(13, 10, '2025-12-28 16:30:00', '2025-12-29 08:00:00', '2025-12-29 08:30:00'),
(5, 8, '2026-01-10 16:30:00', '2026-01-11 09:00:00', '2026-01-14 11:30:00'),
(12, 9, '2026-01-12 15:00:00', '2026-01-13 08:00:00', '2026-01-13 09:30:00'),
(16, 8, '2026-01-08 13:30:00', '2026-01-08 14:00:00', '2026-01-10 16:30:00'),
(18, 11, '2026-01-06 15:30:00', '2026-01-07 09:00:00', '2026-01-07 10:30:00'),

-- Ongoing interventions
(1, 6, '2026-01-15 09:00:00', '2026-01-15 09:30:00', NULL),
(2, 10, '2026-01-20 09:15:00', '2026-01-20 09:30:00', NULL),
(3, 7, '2026-01-18 14:30:00', '2026-01-19 08:00:00', NULL),
(6, 9, '2026-01-25 10:30:00', '2026-01-26 09:00:00', NULL),
(9, 11, '2026-01-27 09:00:00', '2026-01-27 10:00:00', NULL),
(14, 12, '2026-01-29 09:30:00', '2026-01-30 08:00:00', NULL),
(19, 6, '2026-01-26 12:30:00', '2026-01-27 09:00:00', NULL);

-- =============================================
-- COMMENTS
-- =============================================
INSERT INTO `comments` (`ticket_id`, `user_id`, `content`, `created_at`) VALUES
-- Comments on ticket 1 (Critical - laptop BSOD)
(1, 6, 'Received the laptop. Running diagnostics now.', '2026-01-15 09:45:00'),
(1, 6, 'BSOD error code indicates memory issue. Will test RAM modules.', '2026-01-15 11:00:00'),
(1, 3, 'Please prioritize this. Employee has an important deadline.', '2026-01-15 11:30:00'),

-- Comments on ticket 2 (Critical - router down)
(2, 10, 'On site. Checking router configuration.', '2026-01-20 09:45:00'),
(2, 10, 'Power supply seems faulty. Requesting replacement unit.', '2026-01-20 10:30:00'),
(2, 5, 'Replacement router approved. Please expedite.', '2026-01-20 11:00:00'),

-- Comments on ticket 3 (High - slow desktop)
(3, 7, 'Initial assessment: Hard drive showing signs of failure.', '2026-01-19 09:30:00'),
(3, 7, 'Backing up data before replacing HDD with SSD.', '2026-01-19 14:00:00'),

-- Comments on ticket 5 (Resolved - keyboard)
(5, 8, 'Keyboard inspection complete. Multiple keys have debris underneath.', '2026-01-11 10:00:00'),
(5, 8, 'Deep cleaned keyboard. Testing functionality.', '2026-01-13 14:00:00'),
(5, 8, 'Keyboard fully functional after cleaning. Returning device.', '2026-01-14 11:00:00'),
(5, 4, 'Client confirmed issue is resolved. Closing ticket.', '2026-01-14 15:00:00'),

-- Comments on ticket 8 (Closed - battery)
(8, 6, 'Smartphone received. Battery health at 45%.', '2026-01-05 10:45:00'),
(8, 6, 'New battery installed. Running calibration cycle.', '2026-01-07 09:00:00'),
(8, 6, 'Battery replacement successful. Device ready for pickup.', '2026-01-08 14:00:00'),

-- Comments on ticket 11 (Closed - monitor flickering)
(11, 7, 'Tested with different cable - flickering stopped.', '2026-01-03 10:00:00'),
(11, 7, 'Old cable was damaged. Replaced with new one.', '2026-01-04 13:00:00'),

-- Comments on ticket 16 (Resolved - malware)
(16, 8, 'Running full system scan. Found multiple suspicious files.', '2026-01-08 14:30:00'),
(16, 8, 'Malware removed. Installing additional security software.', '2026-01-09 16:00:00'),
(16, 8, 'System cleaned and secured. Running final verification.', '2026-01-10 15:00:00'),

-- Comments on ticket 6 (Pending - tablet screen)
(6, 9, 'Screen damage assessed. Ordering replacement display.', '2026-01-26 10:00:00'),
(6, 4, 'Replacement part ETA: 3 business days.', '2026-01-26 14:30:00'),

-- Comments on ticket 9 (Pending - camera)
(9, 11, 'Camera driver updated. Testing with video call app.', '2026-01-27 10:30:00'),
(9, 11, 'Driver update did not fix issue. May be hardware problem.', '2026-01-27 15:00:00'),

-- Comments on ticket 14 (Pending - fan noise)
(14, 12, 'Opened laptop. Significant dust buildup in fan assembly.', '2026-01-30 09:00:00'),

-- Comments on ticket 19 (Pending - email sync)
(19, 6, 'Checking email server settings on device.', '2026-01-27 10:00:00'),
(19, 6, 'Server authentication issue detected. Working on fix.', '2026-01-27 14:00:00');
