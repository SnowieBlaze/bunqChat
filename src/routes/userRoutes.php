<?php

use controllers\UserController;
use PDO;

return function ($app, PDO $db) {
    $userController = new UserController($db);

    /**
     * The route for creating a new user.
     */
    $app->post("/user", function ($request, $response) use ($userController) {
        $data = $request->getParsedBody();
        $result = $userController->createUser($data["username"] ?? "");
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });

    /**
     * The route for getting a user by id.
     */
    $app->get("/user/{id}", function ($request, $response, $args) use ($userController) {
        $result = $userController->getUserById((int)$args["id"]);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });

    /**
     * The route for getting a user by username.
     */
    $app->get("/user/username/{username}", function ($request, $response, $args) use ($userController) {
        $result = $userController->getUserByUsername($args["username"]);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });
};