<?php

require_once __DIR__ . '/../DAO/InterventionDAO.php';

class InterventionController {
    
    public static function create(int $ticketId, int $userId, DateTime $startedAt, DateTime $endedAt): bool {
        $intervention = new Intervention($ticketId, $userId, $startedAt, $endedAt);
        return InterventionDAO::create($intervention);
    }

    public static function getInterventionsByTicketId(int $ticketId): array {
        $data = InterventionDAO::getInterventionsByTicketId($ticketId);
        $interventions = [];
        foreach ($data as $intervention) {
            $interventions[] = new Intervention(
                $intervention['ticket_id'],
                $intervention['user_id'],
                new DateTime($intervention['started_at']),
                new DateTime($intervention['ended_at']),
                new DateTime($intervention['created_at']),
                $intervention['id']
            );
        }
        return $interventions;
    }

    public static function getInterventionById(int $id): ?Intervention {
        $data = InterventionDAO::getInterventionById($id);
        if ($data) {
            return new Intervention(
                $data['ticket_id'],
                $data['user_id'],
                new DateTime($data['started_at']),
                new DateTime($data['ended_at']),
                new DateTime($data['created_at']),
                $data['id']
            );
        }
        return null;
    }

    public static function getInterventionsByUserId(int $userId): array {
        $data = InterventionDAO::getInterventionsByUserId($userId);
        $interventions = [];
        foreach ($data as $intervention) {
            $interventions[] = new Intervention(
                $intervention['ticket_id'],
                $intervention['user_id'],
                new DateTime($intervention['started_at']),
                new DateTime($intervention['ended_at']),
                new DateTime($intervention['created_at']),
                $intervention['id']
            );
        }
        return $interventions;
    }
}
