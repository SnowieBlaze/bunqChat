<?php
use PHPUnit\Framework\TestCase;
use models\GroupModel;

class GroupModelTest extends TestCase
{
    private $pdo;
    private $groupModel;

    protected function setUp(): void
    {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->exec("
            CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT NOT NULL UNIQUE);
            CREATE TABLE groups (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, creator_id INTEGER NOT NULL)
        ");
        $this->pdo->exec("INSERT INTO users (username) VALUES (\"creator\")");
        $this->groupModel = new GroupModel($this->pdo);
    }

    public function testCreateGroup()
    {
        $groupId = $this->groupModel->createGroup("group1", 1);
        $this->assertIsInt($groupId);
    }

    public function testGetGroupById()
    {
        $groupId = $this->groupModel->createGroup("group1", 1);
        $group = $this->groupModel->getGroupById($groupId);
        $this->assertEquals("group1", $group["name"]);
    }

    public function testGetGroupByName()
    {
        $this->groupModel->createGroup("group1", 1);
        $group = $this->groupModel->getGroupByName("group1");
        $this->assertEquals("group1", $group["name"]);
    }

    public function testGetGroupsByCreator()
    {
        $this->groupModel->createGroup("group1", 1);
        $groups = $this->groupModel->getGroupsByCreator(1);
        $this->assertNotEmpty($groups);
    }

    public function testGetAllGroups()
    {
        $this->groupModel->createGroup("group1", 1);
        $groups = $this->groupModel->getAllGroups();
        $this->assertNotEmpty($groups);
    }
}