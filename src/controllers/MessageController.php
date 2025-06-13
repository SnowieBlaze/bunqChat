<?php

namespace controllers;

use \models\MessageModel;
use PDO;

class MessageController
{
    private MessageModel $messageModel;

    /**
     * Constructor that instantiates messageModel using a database object.
     * @param PDO $db - the database object.
     */
    public function __construct(PDO $db){
        $this->messageModel = new MessageModel($db);
    }

    /**
     * Function to create a message.
     * @param string $content - Content of the message.
     * @param int $author_id - Id of the author.
     * @param int $group_id - Id of the group.
     * @return array - Success status and message id if successful.
     *                 False and error otherwise.
     */
    public function createMessage(string $content, int $author_id, int $group_id): array {
        try {
            $message_id = $this->messageModel->createMessage($content, $author_id, $group_id);
            return [
                "success" => true,
                "message_id" => $message_id,
            ];

        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Function to get all messages from a group.
     * @param int $group_id - The group to get messages from.
     * @return array - Success status and messages if successful.
     *                 False and error otherwise.
     */
    public function getMesssagesFromGroup(int $group_id): array {
        try {
            $messages = $this->messageModel->getAllMessagesFromGroup($group_id);
            return [
                "success" => true,
                "messages" => $messages,
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }
}