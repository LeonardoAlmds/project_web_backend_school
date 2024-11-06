<?php
// Definindo cabeçalhos comuns para JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Inclui configurações e controladores
include_once './config.php';
include_once './controllers/CategoryController.php';

// Pega a URL requisitada
$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Função simples para pegar o path da URL
function getRoutePath($uri) {
    $base = '/api'; // Define o prefixo da API, caso necessário
    return str_replace($base, '', parse_url($uri, PHP_URL_PATH));
}

// Roteamento
$route = getRoutePath($requestUri);

switch ($route) {
    case '/categories':
        $controller = new CategoryController();
        
        switch ($method) {
            case 'GET':
                $controller->listCategories();
                break;
            case 'POST':
                $controller->createCategory();
                break;
            case 'PUT':
                $controller->updateCategory();
                break;
            case 'DELETE':
                $controller->deleteCategory();
                break;
            default:
                http_response_code(405);
                echo json_encode(["message" => "Método não permitido"]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["message" => "Rota não encontrada"]);
        break;
}
?>
