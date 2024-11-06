<?php
  class Category {
    private $pdo;

    public function __construct($pdo) {
     $this->pdo = $pdo;
    }

    public function getCategories() {
      $query = $this->pdo->query("SELECT * FROM categories");
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerCategory($category, $icon_url) {
        $stmt = $this->pdo->prepare("INSERT INTO categories (category, icon_url) VALUES (?), (?)");
        return $stmt->execute([$category, $icon_url]);
    }

    public function updateCategory($id, $category, $icon_url) {
        $stmt = $this->pdo->prepare("UPDATE categories SET category = ?, icon_url = ? WHERE id = ?");
        return $stmt->execute([$category, $icon_url, $id]);
    }

    public function deleteCategory($id) {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

  }
?>