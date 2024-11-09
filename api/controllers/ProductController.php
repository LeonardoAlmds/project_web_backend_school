<?php
include_once './config/database.php';
include_once './models/Product.php';

class ProductController {
    private $product;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->product = new Product($db);
    }

    public function listProducts() {
        $products = $this->product->getProducts();
        echo json_encode($products);
    }

    public function createProduct() {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->category_id, $data->name, $data->price, $data->stock_quantity, $data->posted_date)) {
            if ($this->product->registerProduct($data->category_id, $data->name, $data->price, $data->stock_quantity, $data->posted_date, $data->description, $data->image_url, $data->status, $data->rating)) {
                echo json_encode(["message" => "Produto criado com sucesso"]);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Erro ao criar o produto"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos para criar o produto"]);
        }
    }

    public function updateProduct() {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id, $data->category_id, $data->name, $data->price, $data->stock_quantity)) {
            if ($this->product->updateProduct($data->id, $data->category_id, $data->name, $data->price, $data->stock_quantity, $data->description, $data->image_url, $data->status, $data->rating)) {
                echo json_encode(["message" => "Produto atualizado com sucesso"]);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Erro ao atualizar o produto"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos para atualizar o produto"]);
        }
    }

    public function deleteProduct() {
        parse_str(file_get_contents("php://input"), $data);
        if (isset($data['id']) && $this->product->deleteProduct($data['id'])) {
            echo json_encode(["message" => "Produto deletado com sucesso"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Erro ao deletar o produto"]);
        }
    }

    public function listProductsByCategory($category_id) {
        $products = $this->product->getProductsByCategory($category_id);
        echo json_encode($products);
    }
    
    public function listTopRatedProducts() {
        $products = $this->product->getTopRatedProducts();
        echo json_encode($products);
    }
      
}
?>
