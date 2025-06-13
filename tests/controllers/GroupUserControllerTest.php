<?php
use PHPUnit\Framework\TestCase;
use controllers\GroupUserController;

class GroupUserControllerTest extends TestCase
{
    private $pdo;
    private $controller;

    protected function setUp(): void
    {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->exec("
            CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT NOT NULL UNIQUE);
            CREATE TABLE groups (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, creator_id INTEGER NOT NULL);
            CREATE TABLE group_users (user_id INTEGER, group_id INTEGER)
        ");
        $this->pdo->exec("INSERT INTO users (username) VALUES (\"user1\")");
        $this->pdo->exec("INSERT INTO groups (name, creator_id) VALUES (\"group1\", 1)");
        $this->controller = new GroupUserController($this->pdo);
    }

    public function testAddUserToGroup()
    {
        $result = $this->controller->addUserToGroup(1, 1);
        $this->assertTrue($result["success"]);
    }

    public function testRemoveUserFromGroup()
    {
        $this->controller->addUserToGroup(1, 1);
        $result = $this->controller->removeUserFromGroup(1, 1);
        $this->assertTrue($result["success"]);
    }

    public function testGetUsersInGroup()
    {
        $this->controller->addUserToGroup(1, 1);
        $result = $this->controller->getUsersInGroup(1);
        $this->assertTrue($result["success"]);
        $this->assertCount(1, $result["users"]);
    }

    public function testIsUserInGroup()
    {
        $this->controller->addUserToGroup(1, 1);
        $result = $this->controller->isUserInGroup(1, 1);
        $this->assertTrue($result["success"]);
        $this->assertTrue($result["is_member"]);
    }

    public function testIsUserNotInGroup()
    {
        $result = $this->controller->isUserInGroup(1, 1);
        $this->assertTrue($result["success"]);
        $this->assertFalse($result["is_member"]);
    }
}