<?php
class Question {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para registrar uma nova pergunta
    public function registerQuestion($product_id, $question) {
        $stmt = $this->pdo->prepare("INSERT INTO questions (product_id, question) VALUES (?, ?)");
        return $stmt->execute([$product_id, $question]);
    }

    // Método para obter todas as perguntas de todos os produtos
    public function getAllQuestions() {
        $stmt = $this->pdo->query("SELECT * FROM questions");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obter todas as perguntas de um produto específico
    public function getQuestionsByProductId($product_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE product_id = ?");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para excluir uma pergunta
    public function deleteQuestion($id) {
        $stmt = $this->pdo->prepare("DELETE FROM questions WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Método para obter uma pergunta específica por ID
    public function getQuestionById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para atualizar uma pergunta
    public function updateQuestion($question, $id) {
        $stmt = $this->pdo->prepare("UPDATE questions SET question = ? WHERE id = ?");
        return $stmt->execute([$question, $id]);
    }
}
?>
