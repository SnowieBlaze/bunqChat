<?php

namespace Models;

use PDO;

class GroupUserModel
{
    private PDO $db;

    /**
     * Constructor that passes the database object to the model.
     * @param PDO $db - The database object.
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Function to add a user to a group.
     * It first prepares the statement.
     * Then, it binds the parameter.
     * Finally, it executes the statement.
     * @param int $userId - The Id of the user to add.
     * @param int $groupId - The Id of the group to add the user to.
     * @return void
     */
    public function addUserToGroup(int $userId, int $groupId): void {
        $stmt = $this->db->prepare("
            INSERT INTO group_users (user_id, group_id)
            VALUES (:user_id, :group_id)
        ");
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':group_id', $groupId);
        $stmt->execute();
    }

    /**
     * Function to remove a user from a group.
     * It first prepares the statement.
     * Then, it binds the parameter.
     * Finally, it executes the statement.
     * @param int $userId - The Id of the user to remove.
     * @param int $groupId - The Id of the group to remove the user from.
     * @return void
     */
    public function removeUserFromGroup(int $userId, int $groupId): void {
        $stmt = $this->db->prepare("
            DELETE FROM group_users
            WHERE user_id = :user_id
            AND group_id = :group_id
        ");
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':group_id', $groupId);
        $stmt->execute();
    }

    /**
     * Function to get all users in a group.
     * It first prepares the statement.
     * Then, it binds the parameter.
     * Finally, it executes the statement.
     * @param int $groupId - The Id of the group.
     * @return array - Users in the group data as JSON.
     */
    public function getUsersInGroup(int $groupId): array {
        $stmt = $this->db->prepare("
            SELECT u.* FROM users u
            JOIN group_users gu ON gu.user_id = u.id
            WHERE gu.group_id = :group_id
        ");
        $stmt->bindValue(':group_id', $groupId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Function to check if a user is a member of a group.
     * It first prepares the statement.
     * Then, it binds the parameter.
     * Finally, it executes the statement.
     * @param int $userId - The Id of the user.
     * @param int $groupId - The Id of the group.
     * @return bool - True if the user is in the group, false otherwise.
     */
    public function isUserInGroup(int $userId, int $groupId): bool {
        $stmt = $this->db->prepare("
            SELECT 1 FROM group_users
            WHERE user_id = :user_id
            AND group_id = :group_id
        ");
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':group_id', $groupId);
        $stmt->execute();
        return (bool) $stmt->fetchColumn();
    }
}
