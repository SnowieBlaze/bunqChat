<?php

use controllers\GroupController;
use PDO;

return function ($app, PDO $db) {
    $groupController = new GroupController($db);

    /**
     * The route for creating a new group.
     */
    $app->post("/group", function ($request, $response) use ($groupController) {
        $data = $request->getParsedBody();
        $result = $groupController->createGroup($data["name"] ?? "", (int)($data["creator_id"] ?? 0));
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });

    /**
     * The route for getting a group by id.
     */
    $app->get("/group/{id}", function ($request, $response, $args) use ($groupController) {
        $result = $groupController->getGroupById((int)$args["id"]);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });

    /**
     * The route for getting a group by name.
     */
    $app->get("/group/name/{name}", function ($request, $response, $args) use ($groupController) {
        $result = $groupController->getGroupByName($args["name"]);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });

    /**
     * The route for getting all groups by creator.
     */
    $app->get("/group/creator/{creator_id}", function ($request, $response, $args) use ($groupController) {
        $result = $groupController->getGroupsByCreator((int)$args["creator_id"]);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });

    /**
     * The route for getting all groups.
     */
    $app->get("/groups", function ($request, $response) use ($groupController) {
        $result = $groupController->getAllGroups();
        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");
    });
};