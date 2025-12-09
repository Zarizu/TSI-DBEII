<?php

require_once 'src/config.php';

use Controller\MemberController;
use Controller\TeamController;
use Controller\RoleController;
use Controller\MissionController;
use Controller\ItemController;
use Http\Request;
use Http\Response;
use Error\APIException;

// Captura informações da requisição
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$body = file_get_contents("php://input");
$request = new Request($uri, $method, $body);

try {
    switch ($request->getResource()) {
        case 'members':
            $controller = new MemberController();
            $controller->processRequest($request);
            break;

        case 'teams':
            $controller = new TeamController();
            $controller->processRequest($request);
            break;

        case 'roles':
            $controller = new RoleController();
            $controller->processRequest($request);
            break;

        case 'missions':
            $controller = new MissionController();
            $controller->processRequest($request);
            break;

        case 'items':
            $controller = new ItemController();
            $controller->processRequest($request);
            break;

        case null:
            // rota raiz / mostrando todos os endpoints disponíveis
            $endpoints = [
                // Roles
                "POST /roles",
                "GET /roles?name=name",
                "GET /roles/:id",
                "PUT /roles/:id",
                "DELETE /roles/:id",

                // Members
                "POST /members",
                "GET /members",
                "GET /members/:id",
                "GET /members/:id/inventory",
                "PATCH /members/:id/gold",
                "DELETE /members/:id",

                // Teams
                "POST /teams",
                "GET /teams",
                "GET /teams/:id",
                "GET /teams/:id/members",
                "PATCH /teams/:id/gold",
                "DELETE /teams/:id",

                // Missions
                "POST /missions",
                "GET /missions",
                "GET /missions/:id",
                "PUT /missions/:id",
                "PATCH /missions/:id/reward",
                "DELETE /missions/:id",

                // Team-Mission
                "POST /teams/:team_id/missions",
                "GET /teams/:team_id/missions",
                "GET /teams/:team_id/missions/:mission_id",
                "DELETE /teams/:team_id/missions/:mission_id",

                // Items
                "POST /members/:member_id/items",
                "GET /members/:member_id/items",
                "PUT /items/:id",
                "PATCH /items/:id/amount",
                "PATCH /items/:member_id/transfer",
                "DELETE /items/:id",
            ];
            Response::send(["endpoints" => $endpoints]);
            break;

        default:
            throw new APIException("Resource not found!", 404);
    }
} catch (APIException $e) {
    http_response_code($e->getCode());
    echo json_encode(['error' => $e->getMessage()]);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error', 'details' => $e->getMessage()]);
}
