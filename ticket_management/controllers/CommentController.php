<?php

require_once __DIR__ . '/../DAO/CommentDAO.php';
class CommentController {
    public static function create(int $ticketId, int $userId, string $content): bool {
        return CommentDAO::create($ticketId, $userId, $content);
    }

    public static function getCommentsByTicketId(int $ticketId){
        $data =  CommentDAO::getCommentsByTicketId($ticketId);
        $comments = [];
        foreach($data as $comment){
            $comments[] = new Comment(
                $comment['user_id'],
                $comment['content'],
                $comment['id'],
                new DateTime($comment['created_at']),
                $comment['email']
            );
        }
        return $comments;
    }
}