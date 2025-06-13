<?php
use PHPUnit\Framework\TestCase;
use controllers\UserController;

class UserControllerTest extends TestCase
{
    private $pdo;
    private $controller;

    protected function setUp(): void
    {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->exec("CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT NOT NULL UNIQUE)");
        $this->controller = new UserController($this->pdo);
    }

    public function testCreateUserSuccess()
    {
        $result = $this->controller->createUser("testuser");
        $this->assertTrue($result["success"]);
        $this->assertIsInt($result["user_id"]);
    }

    public function testCreateUserDuplicate()
    {
        $this->controller->createUser("testuser");
        $result = $this->controller->createUser("testuser");
        $this->assertFalse($result["success"]);
        $this->assertArrayHasKey("error", $result);
    }

    public function testGetUserByIdSuccess()
    {
        $create = $this->controller->createUser("testuser");
        $result = $this->controller->getUserById($create["user_id"]);
        $this->assertTrue($result["success"]);
        $this->assertEquals("testuser", $result["user"]["username"]);
    }

    public function testGetUserByIdNotFound()
    {
        $result = $this->controller->getUserById(999);
        $this->assertTrue($result["success"]);
        $this->assertNull($result["user"]);
    }

    public function testGetUserByUsernameSuccess()
    {
        $this->controller->createUser("testuser");
        $result = $this->controller->getUserByUsername("testuser");
        $this->assertTrue($result["success"]);
        $this->assertEquals("testuser", $result["user"]["username"]);
    }

    public function testGetUserByUsernameNotFound()
    {
        $result = $this->controller->getUserByUsername("nouser");
        $this->assertTrue($result["success"]);
        $this->assertNull($result["user"]);
    }
}