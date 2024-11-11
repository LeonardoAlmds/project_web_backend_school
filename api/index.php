<?php
header("Access-Control-Allow-Origin: *");  // Permite todas as origens, ou altere "*" para a origem específica.
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Se for uma requisição de pré-verificação, responder com um status 200
    http_response_code(200);
    exit;
}

// Inclui configurações e controladores
include_once './controllers/CategoryController.php';
include_once './controllers/ProductController.php'; // Inclui o ProductController
include_once './controllers/AuthController.php';
include_once './controllers/QuestionController.php'; // Inclui o QuestionController

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
    // Roteamento para Categories
    case '/categories':
        $controller = new CategoryController();
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $controller->getCategoryById($_GET['id']);
                } else {
                    $controller->listCategories();
                }
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

    case '/categories/top':
        if ($method === 'GET') {
            $controller = new CategoryController();
            $controller->listTopCategoriesByProductCount();
        } else {
            http_response_code(405);
            echo json_encode(["message" => "Método não permitido"]);
        }
        break;

    // Roteamento para Products
    case '/products':
        $controller = new ProductController();
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {  // Verifica se há um ID para buscar um único produto
                    $controller->getProductById($_GET['id']);
                } elseif (isset($_GET['category_id'])) {
                    $controller->listProductsByCategory($_GET['category_id']);
                } else {
                    $controller->listProducts();
                }
                break;
            case 'POST':
                $controller->createProduct();
                break;
            case 'PUT':
                $controller->updateProduct();
                break;
            case 'DELETE':
                $controller->deleteProduct();
                break;
            default:
                http_response_code(405);
                echo json_encode(["message" => "Método não permitido"]);
        }
        break;

    case '/products/top-rated':
        $controller = new ProductController();
        if ($method === 'GET') {
            $controller->listTopRatedProducts();
        } else {
            http_response_code(405);
            echo json_encode(["message" => "Método não permitido"]);
        }
        break;

    // Roteamento para Questions
    case '/questions':
        $controller = new QuestionController();
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $controller->getQuestionById($_GET['id']);
                } elseif (isset($_GET['product_id'])) {
                    // Rota para listar perguntas por produto
                    $controller->listQuestionsByProduct($_GET['product_id']);
                } else {
                    $controller->listQuestions();
                }
                break;
            case 'POST':
                $controller->createQuestion();
                break;
            case 'PUT':
                if (isset($_GET['id'])) {
                    $controller->updateQuestion($_GET['id']);
                }
                break;
            case 'DELETE':
                if (isset($_GET['id'])) {
                    $controller->deleteQuestion($_GET['id']);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(["message" => "Método não permitido"]);
        }
        break;

    // Rota para registro de usuário
    case '/register':
        if ($method === 'POST') {
            $authController = new AuthController();
            $data = json_decode(file_get_contents("php://input"), true);
            $authController->register($data);
        } else {
            http_response_code(405);
            echo json_encode(["message" => "Método não permitido"]);
        }
        break;

    // Rota para login de usuário
    case '/login':
        if ($method === 'POST') {
            $authController = new AuthController();
            $data = json_decode(file_get_contents("php://input"), true);
            $authController->login($data);
        } else {
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
