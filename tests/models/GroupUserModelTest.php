<?php
use PHPUnit\Framework\TestCase;
use models\GroupUserModel;

class GroupUserModelTest extends TestCase
{
    private $pdo;
    private $groupUserModel;

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
        $this->groupUserModel = new GroupUserModel($this->pdo);
    }

    public function testAddUserToGroup()
    {
        $this->groupUserModel->addUserToGroup(1, 1);
        $users = $this->groupUserModel->getUsersInGroup(1);
        $this->assertCount(1, $users);
    }

    public function testRemoveUserFromGroup()
    {
        $this->groupUserModel->addUserToGroup(1, 1);
        $this->groupUserModel->removeUserFromGroup(1, 1);
        $users = $this->groupUserModel->getUsersInGroup(1);
        $this->assertCount(0, $users);
    }

    public function testIsUserInGroup()
    {
        $this->groupUserModel->addUserToGroup(1, 1);
        $isMember = $this->groupUserModel->isUserInGroup(1, 1);
        $this->assertTrue($isMember);
    }

    public function testIsUserNotInGroup()
    {
        $isMember = $this->groupUserModel->isUserInGroup(1, 1);
        $this->assertFalse($isMember);
    }
}