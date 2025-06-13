<?php

namespace Models;

use PDO;

class UserModel
{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Function to create user in the database.
     * It first prepares the statement(injection protection, can bind after)
     * Then it binds the username in the statement
     * Finally, it executes the statement.
     * @param string $username - The user's username.
     * @return int - The id of the user after adding to the database.
     */
    public function createUser(string $username): int {
        $stmt = $this->db->prepare("INSERT INTO users (username) VALUES (:username)");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return (int) $this->db->lastInsertId();
    }

    /**
     * Function to get user by id.
     * It first prepares the statement(injection protection, can bind after)
     * Then it binds the id in the statement.
     * Finally, it executes the statement.
     * @param int $id - The id of the user we are looking for.
     * @return array|null - The user's data in JSON format according to the schema if found.
     *                      Null otherwise.
     */
    public function getUserById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Function to get user by username.
     * It first prepares the statement(injection protection, can bind after)
     * Then it binds the username in the statement.
     * Finally, it executes the statement.
     * @param string $username - The username of the user we are looking for.
     * @return array|null - The user's data in JSON format according to the schema if found.
     *                      Null otherwise.
     */
    public function getUserByUsername(string $username): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}