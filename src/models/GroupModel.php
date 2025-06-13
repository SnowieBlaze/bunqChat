<?php

namespace models;

use PDO;

class GroupModel
{
    private PDO $db;

    /**
     * Constructor that passes the database object to the model.
     * @param PDO $db - the database object.
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Function to create a group.
     * It first prepares the statement.
     * Then, it binds the parameters.
     * Finally, it executes the statement.
     * @param string $name - Name of the group.
     * @param int $creator_id - Id of the creator.
     * @return int - Id of the group that was created.
     */
    public function createGroup(string $name, int $creator_id): int {
        $stmt = $this->db->prepare("
            INSERT INTO groups (name, creator_id)
            VALUES (:name, :creator_id)
        ");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":creator_id", $creator_id);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    /**
     * Function to get a group by id.
     * It first prepares the statement.
     * Then, it binds the parameter.
     * Finally, it executes the statement.
     * @param int $id - The id of the group.
     * @return array|null - The group in a JSON format if found.
     *                      Null otherwise.
     */
    public function getGroupById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM groups WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result =  $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Function to get a group by name.
     * It first prepares the statement.
     * Then, it binds the parameter.
     * Finally, it executes the statement.
     * @param string $name - The name of the group.
     * @return array|null - The group in a JSON format if found.
     *                      Null otherwise.
     */
    public function getGroupByName(string $name): ?array {
        $stmt = $this->db->prepare("SELECT * FROM groups WHERE name=:name");
        $stmt->bindParam(':name', name);
        $stmt->execute();
        $result =  $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Function to get all groups.
     * It just executes the database statement.
     * @return array|null - The groups in a JSON format if found.
     *                      Null otherwise.
     */
    public function getAllGroups(): ?array {
        $stmt = $this->db->prepare("SELECT * FROM groups");
        $stmt->execute();
        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}