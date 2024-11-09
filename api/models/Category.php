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

    public function getCategoryById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registerCategory($name, $icon_url, $banner_url) {
        $stmt = $this->pdo->prepare("INSERT INTO categories (name, icon_url, banner_url) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $icon_url, $banner_url]);
    }

    public function updateCategory($id, $name, $icon_url, $banner_url) {
        $stmt = $this->pdo->prepare("UPDATE categories SET name = ?, icon_url = ?, banner_url = ? WHERE id = ?");
        return $stmt->execute([$name, $icon_url, $banner_url, $id]);
    }

    public function deleteCategory($id) {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getTopCategoriesByProductCount() {
        $stmt = $this->pdo->query("
            SELECT c.id, c.name, c.icon_url, c.banner_url, COUNT(p.id) AS product_count
            FROM categories c
            LEFT JOIN products p ON p.category_id = c.id
            GROUP BY c.id, c.name, c.icon_url, c.banner_url
            ORDER BY product_count DESC
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
