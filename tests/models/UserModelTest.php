<?php
use PHPUnit\Framework\TestCase;
use models\UserModel;

class UserModelTest extends TestCase
{
    private $pdo;
    private $userModel;

    protected function setUp(): void
    {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->exec("CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT NOT NULL UNIQUE)");
        $this->userModel = new UserModel($this->pdo);
    }

    public function testCreateUser()
    {
        $userId = $this->userModel->createUser("testuser");
        $this->assertIsInt($userId);
    }

    public function testGetUserById()
    {
        $userId = $this->userModel->createUser("testuser");
        $user = $this->userModel->getUserById($userId);
        $this->assertEquals("testuser", $user["username"]);
    }

    public function testGetUserByUsername()
    {
        $this->userModel->createUser("testuser");
        $user = $this->userModel->getUserByUsername("testuser");
        $this->assertEquals("testuser", $user["username"]);
    }
}