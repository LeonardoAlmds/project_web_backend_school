<?php
include_once './config/database.php';  // Inclui o database.php
include_once './models/Category.php';

class CategoryController {
    private $category;

    public function __construct() {
        // Cria uma nova conexão de banco de dados
        $database = new Database();
        $db = $database->connect();
        
        // Passa a conexão para o modelo Category
        $this->category = new Category($db);
    }

    public function listCategories() {
        $categories = $this->category->getCategories();
        echo json_encode($categories);
    }

    public function createCategory() {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->category) && $this->category->registerCategory($data->category)) {
            echo json_encode(["message" => "Categoria criada com sucesso"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Erro ao criar a categoria"]);
        }
    }

    public function updateCategory() {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id, $data->category) && $this->category->updateCategory($data->id, $data->category)) {
            echo json_encode(["message" => "Categoria atualizada com sucesso"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Erro ao atualizar a categoria"]);
        }
    }

    public function deleteCategory() {
        parse_str(file_get_contents("php://input"), $data);
        if (isset($data['id']) && $this->category->deleteCategory($data['id'])) {
            echo json_encode(["message" => "Categoria deletada com sucesso"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Erro ao deletar a categoria"]);
        }
    }
}
?>
