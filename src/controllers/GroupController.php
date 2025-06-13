<?php

namespace controllers;

use \models\GroupModel;
use PDO;

class GroupController
{
    private GroupModel $groupModel;

    /**
     * Constructor that instantiates groupModel using a database object.
     * @param PDO $db - the database object.
     */
    public function __construct(PDO $db)
    {
        $this->groupModel = new GroupModel($db);
    }

    /**
     * Function to create a new group.
     * @param string $name - The name of the group.
     * @param int $creator_id - The id of the creator.
     * @return array - Success status and group id if successful.
     *                 False and error otherwise.
     */
    public function createGroup(string $name, int $creator_id): array
    {
        try {
            $group_id = $this->groupModel->createGroup($name, $creator_id);
            return [
                "success" => true,
                "group_id" => $group_id,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Function to get group data by ID.
     * @param int $id - The id of the group.
     * @return array - Success status and group data if found.
     *                 False and error otherwise.
     */
    public function getGroupById(int $id): array
    {
        try {
            $group = $this->groupModel->getGroupById($id);
            return [
                "success" => true,
                "group" => $group,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Function to get group data by name.
     * @param string $name - The name of the group.
     * @return array - Success status and group data if found.
     *                 False and error otherwise.
     */
    public function getGroupByName(string $name): array
    {
        try {
            $group = $this->groupModel->getGroupByName($name);
            return [
                "success" => true,
                "group" => $group,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Function to get all groups by creator.
     * @param int $creator_id - The id of the creator.
     * @return array - Success status and groups if found.
     *                 False and error otherwise.
     */
    public function getGroupsByCreator(int $creator_id): array
    {
        try {
            $groups = $this->groupModel->getGroupsByCreator($creator_id);
            return [
                "success" => true,
                "groups" => $groups,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Function to get all groups.
     * @return array - Success status and groups if found.
     *                 False and error otherwise.
     */
    public function getAllGroups(): array
    {
        try {
            $groups = $this->groupModel->getAllGroups();
            return [
                "success" => true,
                "groups" => $groups,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }
}