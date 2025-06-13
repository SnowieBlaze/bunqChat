<?php
use PHPUnit\Framework\TestCase;
use controllers\MessageController;

class MessageControllerTest extends TestCase
{
    private $pdo;
    private $controller;

    protected function setUp(): void
    {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->exec("
            CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT NOT NULL UNIQUE);
            CREATE TABLE groups (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, creator_id INTEGER NOT NULL);
            CREATE TABLE messages (id INTEGER PRIMARY KEY AUTOINCREMENT, content TEXT NOT NULL, author_id INTEGER NOT NULL, group_id INTEGER NOT NULL)
        ");
        $this->pdo->exec("INSERT INTO users (username) VALUES (\"user1\")");
        $this->pdo->exec("INSERT INTO groups (name, creator_id) VALUES (\"group1\", 1)");
        $this->controller = new MessageController($this->pdo);
    }

    public function testCreateMessage()
    {
        $result = $this->controller->createMessage("Hello", 1, 1);
        $this->assertTrue($result["success"]);
        $this->assertIsInt($result["message_id"]);
    }

    public function testGetMessagesFromGroup()
    {
        $this->controller->createMessage("Hello", 1, 1);
        $result = $this->controller->getMesssagesFromGroup(1);
        $this->assertTrue($result["success"]);
        $this->assertNotEmpty($result["messages"]);
        $this->assertEquals("Hello", $result["messages"][0]["content"]);
    }

    public function testGetMessagesFromEmptyGroup()
    {
        $result = $this->controller->getMesssagesFromGroup(1);
        $this->assertTrue($result["success"]);
        $this->assertNull($result["messages"]);
    }
}