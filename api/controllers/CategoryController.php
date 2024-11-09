<?php
include_once './config/database.php';
include_once './models/Category.php';

class CategoryController {
    private $category;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        
        $this->category = new Category($db);
    }

    public function listCategories() {
        $categories = $this->category->getCategories();
        echo json_encode($categories);
    }

    public function getCategoryById($id) {
        $category = $this->category->getCategoryById($id);
        if ($category) {
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Categoria não encontrada"]);
        }
    }

    public function createCategory() {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->name, $data->icon_url, $data->banner_url) && $this->category->registerCategory($data->name, $data->icon_url, $data->banner_url)) {
            echo json_encode(["message" => "Categoria criada com sucesso"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Erro ao criar a categoria"]);
        }
    }

    public function updateCategory() {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id, $data->name, $data->icon_url, $data->banner_url) && $this->category->updateCategory($data->id, $data->name, $data->icon_url, $data->banner_url)) {
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

    public function listTopCategoriesByProductCount() {
        $topCategories = $this->category->getTopCategoriesByProductCount();
        echo json_encode($topCategories);
    }
}
?>
