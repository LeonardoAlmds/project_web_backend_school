<?php
include_once './config/database.php';
include_once './models/Question.php';

class QuestionController {
    private $question;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->question = new Question($db);
    }

    // Listar todas as perguntas de um produto específico
    public function listQuestionsByProduct($product_id) {
        $questions = $this->question->getQuestionsByProductId($product_id);
        echo json_encode($questions);
    }

    // Obter uma pergunta específica por ID
    public function getQuestionById($id) {
        $question = $this->question->getQuestionById($id);
        echo json_encode($question);
    }

    // Criar uma nova pergunta
    public function createQuestion() {
        $data = json_decode(file_get_contents("php://input"), true);
        $success = $this->question->registerQuestion($data['product_id'], $data['question']);
        echo json_encode(["message" => $success ? "Pergunta criada com sucesso" : "Erro ao criar pergunta"]);
    }

    // Atualizar uma pergunta
    public function updateQuestion($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $this->question->updateQuestion($data['question'], $id);
        echo json_encode(["message" => $stmt ? "Pergunta atualizada com sucesso" : "Erro ao atualizar pergunta"]);
    }

    // Deletar uma pergunta
    public function deleteQuestion($id) {
        $success = $this->question->deleteQuestion($id);
        echo json_encode(["message" => $success ? "Pergunta deletada com sucesso" : "Erro ao deletar pergunta"]);
    }
}
?>
