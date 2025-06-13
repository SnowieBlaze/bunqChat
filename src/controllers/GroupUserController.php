<?php

namespace controllers;

use \models\GroupUserModel;
use PDO;

class GroupUserController
{
    private GroupUserModel $groupUserModel;

    /**
     * Constructor that instantiates groupUserModel using a database object.
     * @param PDO $db - the database object.
     */
    public function __construct(PDO $db)
    {
        $this->groupUserModel = new GroupUserModel($db);
    }

    /**
     * Function to add a user to a group.
     * @param int $user_id - The Id of the user to add.
     * @param int $group_id - The Id of the group to add the user to.
     * @return array - Success status if successful.
     *                 False and error otherwise.
     */
    public function addUserToGroup(int $user_id, int $group_id): array
    {
        try {
            $this->groupUserModel->addUserToGroup($user_id, $group_id);
            return [
                "success" => true,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Function to remove a user from a group.
     * @param int $user_id - The Id of the user to remove.
     * @param int $groupId - The Id of the group to remove the user from.
     * @return array - Success status if successful.
     *                 False and error otherwise.
     */
    public function removeUserFromGroup(int $user_id, int $group_id): array
    {
        try {
            $this->groupUserModel->removeUserFromGroup($user_id, $group_id);
            return [
                "success" => true,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Function to get all users in a group.
     * @param int $group_id - The Id of the group.
     * @return array - Success status and users if found.
     *                 False and error otherwise.
     */
    public function getUsersInGroup(int $group_id): array
    {
        try {
            $users = $this->groupUserModel->getUsersInGroup($group_id);
            return [
                "success" => true,
                "users" => $users,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Function to check if a user is a member of a group.
     * @param int $user_id - The Id of the user.
     * @param int $group_id - The Id of the group.
     * @return array - Success status and true/false if successful.
     *                 False and error otherwise.
     */
    public function isUserInGroup(int $user_id, int $group_id): array
    {
        try {
            $isMember = $this->groupUserModel->isUserInGroup($user_id, $group_id);
            return [
                "success" => true,
                "is_member" => $isMember,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }
}