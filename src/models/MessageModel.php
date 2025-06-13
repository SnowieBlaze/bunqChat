<?php

namespace models;

use PDO;

class MessageModel
{
    private PDO $db;

    /**
     * Constructor that passes the database object to the model.
     * @param PDO $db - the database object.
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Function to get all messages in a group.
     * It first prepares the statement.
     * Then, it binds the parameter.
     * Finally, it executes the statement.
     * @param int $groupId - The group to get messages from.
     * @return array|null - The messages in JSON format if available.
     *                      Null otherwise.
     */
    public function getAllMessagesFromGroup(int $groupId): ?array{
        $stmt = $this->db->prepare("SELECT * FROM messages WHERE group_id=:groupId");
        $stmt->bindParam(':groupId', $groupId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? $result : null;
    }

    /**
     *  Function for a user to create a message in a group.
     *  It first prepares the statement.
     *  Then, it binds the parameters.
     *  Finally, it executes the statement.
     * @param string $content - The content of the message.
     * @param int $authorId - The id of the author(user).
     * @param int $groupId - The id of the group.
     * @return int - The id of the message after it was inserted.
     */
    public function createMessage(string $content, int $authorId, int $groupId): int {
        $stmt = $this->db->prepare("
        INSERT INTO messages (content, author_id, group_id) 
        VALUES (:content, :author_id, :group_id)
    ");
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author_id', $authorId);
        $stmt->bindParam(':group_id', $groupId);
        $stmt->execute();
        return (int) $this->db->lastInsertId();
    }

}