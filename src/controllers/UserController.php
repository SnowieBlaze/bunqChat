<?php

namespace controllers;

use \models\UserModel;
use PDO;

class UserController
{
    private UserModel $userModel;

    /**
     * Constructor that instantiates userModel using a database object.
     * @param PDO $db - the database object.
     */
    public function __construct(PDO $db)
    {
        $this->userModel = new UserModel($db);
    }

    /**
     * Function to create a new user.
     * @param string $username - The username from request.
     * @return array - Success status and user Id if successful.
     *                 False and error otherwise.
     */
    public function createUser(string $username): array
    {
        try {
            $user_id = $this->userModel->createUser($username);
            return [
                "success" => true,
                "user_id" => $user_id,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Function to get user data by ID.
     * @param int $id
     * @return array|null - User data array if found.
     *                      Null otherwise.
     */
    public function getUserById(int $id): ?array
    {
        return $this->userModel->getUserById($id);
    }

    /**
     * Function to get user data by username.
     * @param string $username
     * @return array|null - User data array if found.
     *                      Null otherwise.
     */
    public function getUserByUsername(string $username): ?array
    {
        return $this->userModel->getUserByUsername($username);
    }
}
