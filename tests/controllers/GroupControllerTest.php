<?php
use PHPUnit\Framework\TestCase;
use controllers\GroupController;

class GroupControllerTest extends TestCase
{
    private $pdo;
    private $controller;

    protected function setUp(): void
    {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->exec("
            CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT NOT NULL UNIQUE);
            CREATE TABLE groups (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, creator_id INTEGER NOT NULL)
        ");
        $this->pdo->exec("INSERT INTO users (username) VALUES (\"creator\")");
        $this->controller = new GroupController($this->pdo);
    }

    public function testCreateGroupSuccess()
    {
        $result = $this->controller->createGroup("group1", 1);
        $this->assertTrue($result["success"]);
        $this->assertIsInt($result["group_id"]);
    }

    public function testGetGroupByIdSuccess()
    {
        $create = $this->controller->createGroup("group1", 1);
        $result = $this->controller->getGroupById($create["group_id"]);
        $this->assertTrue($result["success"]);
        $this->assertEquals("group1", $result["group"]["name"]);
    }

    public function testGetGroupByIdNotFound()
    {
        $result = $this->controller->getGroupById(999);
        $this->assertTrue($result["success"]);
        $this->assertNull($result["group"]);
    }

    public function testGetGroupByNameSuccess()
    {
        $this->controller->createGroup("group1", 1);
        $result = $this->controller->getGroupByName("group1");
        $this->assertTrue($result["success"]);
        $this->assertEquals("group1", $result["group"]["name"]);
    }

    public function testGetGroupByNameNotFound()
    {
        $result = $this->controller->getGroupByName("nogroup");
        $this->assertTrue($result["success"]);
        $this->assertNull($result["group"]);
    }

    public function testGetGroupsByCreator()
    {
        $this->controller->createGroup("group1", 1);
        $this->controller->createGroup("group2", 1);
        $result = $this->controller->getGroupsByCreator(1);
        $this->assertTrue($result["success"]);
        $this->assertCount(2, $result["groups"]);
    }

    public function testGetAllGroups()
    {
        $this->controller->createGroup("group1", 1);
        $this->controller->createGroup("group2", 1);
        $result = $this->controller->getAllGroups();
        $this->assertTrue($result["success"]);
        $this->assertCount(2, $result["groups"]);
    }
}