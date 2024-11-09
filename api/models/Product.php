<?php
class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getProducts() {
        $query = $this->pdo->query("SELECT * FROM products");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerProduct($category_id, $name, $price, $stock_quantity, $posted_date, $description = null, $image_url = null, $status = 'active', $rating = 0.0) {
        $stmt = $this->pdo->prepare("INSERT INTO products (category_id, name, price, stock_quantity, posted_date, description, image_url, status, rating) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$category_id, $name, $price, $stock_quantity, $posted_date, $description, $image_url, $status, $rating]);
    }

    public function updateProduct($id, $category_id, $name, $price, $stock_quantity, $description = null, $image_url = null, $status = 'active', $rating = 0.0) {
        $stmt = $this->pdo->prepare("UPDATE products SET category_id = ?, name = ?, price = ?, stock_quantity = ?, description = ?, image_url = ?, status = ?, rating = ? WHERE id = ?");
        return $stmt->execute([$category_id, $name, $price, $stock_quantity, $description, $image_url, $status, $rating, $id]);
    }

    public function deleteProduct($id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getProductsByCategory($category_id) {
        $query = 'SELECT * FROM products WHERE category_id = :category_id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopRatedProducts() {
        $query = "SELECT * FROM products ORDER BY rating DESC LIMIT 12";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>
