<?php
// controllers/AuthController.php
include_once './config/database.php';
include_once './models/Users.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->user = new User($this->db);
    }

    public function register($data) {
        $this->user->username = $data['username'];
        $this->user->password = $data['password'];

        if ($this->user->register()) {
            echo json_encode(["message" => "Usuário registrado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao registrar usuário."]);
        }
    }

    public function login($data) {
        $this->user->username = $data['username'];
        $this->user->password = $data['password'];

        if ($this->user->login()) {
            echo json_encode(["message" => "Login bem-sucedido!", "user_id" => $this->user->id]);
        } else {
            http_response_code(401);
            echo json_encode(["error" => "Nome de usuário ou senha incorretos."]);
        }
    }
}
?>
