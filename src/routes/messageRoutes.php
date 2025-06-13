<?php

use controllers\MessageController;
use PDO;

return function ($app, PDO $db) {
    $messageController = new MessageController($db);

    /**
     * The route for creating a new message in a group.
     */
    $app->post("/message", function ($request, $response) use ($messageController) {
        $data = $request->getParsedBody();
        $result = $messageController->createMessage(
            $data["content"] ?? "",
            (int)($data["author_id"] ?? 0),
            (int)($data["group_id"] ?? 0)
        );
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });

    /**
     * The route for getting all messages from a group.
     */
    $app->get("/messages/group/{group_id}", function ($request, $response, $args) use ($messageController) {
        $result = $messageController->getMesssagesFromGroup((int)$args["group_id"]);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });
};