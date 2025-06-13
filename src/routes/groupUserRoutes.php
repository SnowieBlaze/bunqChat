<?php

use controllers\GroupUserController;
use PDO;

return function ($app, PDO $db) {
    $groupUserController = new GroupUserController($db);

    /**
     * The route for adding a user to a group.
     */
    $app->post("/groupuser/add", function ($request, $response) use ($groupUserController) {
        $data = $request->getParsedBody();
        $result = $groupUserController->addUserToGroup((int)($data["user_id"] ?? 0), (int)($data["group_id"] ?? 0));
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });

    /**
     * The route for removing a user from a group.
     */
    $app->post("/groupuser/remove", function ($request, $response) use ($groupUserController) {
        $data = $request->getParsedBody();
        $result = $groupUserController->removeUserFromGroup((int)($data["user_id"] ?? 0), (int)($data["group_id"] ?? 0));
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });

    /**
     * The route for getting all users in a group.
     */
    $app->get("/groupuser/group/{group_id}", function ($request, $response, $args) use ($groupUserController) {
        $result = $groupUserController->getUsersInGroup((int)$args["group_id"]);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });

    /**
     * The route for checking if a user is a member of a group.
     */
    $app->get("/groupuser/is_member/{user_id}/{group_id}", function ($request, $response, $args) use ($groupUserController) {
        $result = $groupUserController->isUserInGroup((int)$args["user_id"], (int)$args["group_id"]);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });
};