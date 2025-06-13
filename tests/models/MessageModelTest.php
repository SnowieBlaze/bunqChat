<?php
use PHPUnit\Framework\TestCase;
use models\MessageModel;

class MessageModelTest extends TestCase
{
    private $pdo;
    private $messageModel;

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
        $this->messageModel = new MessageModel($this->pdo);
    }

    public function testCreateMessage()
    {
        $messageId = $this->messageModel->createMessage("Hello", 1, 1);
        $this->assertIsInt($messageId);
    }

    public function testGetAllMessagesFromGroup()
    {
        $this->messageModel->createMessage("Hello", 1, 1);
        $messages = $this->messageModel->getAllMessagesFromGroup(1);
        $this->assertNotEmpty($messages);
        $this->assertEquals("Hello", $messages[0]["content"]);
    }

    public function testGetAllMessagesFromEmptyGroup()
    {
        $messages = $this->messageModel->getAllMessagesFromGroup(1);
        $this->assertNull($messages);
    }
}