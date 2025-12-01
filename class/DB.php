<?php
class DB {
    private $pdo;
  public $stmt;
    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=localhost;port=3307;dbname=cat_project", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("❌ فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
        }
    }

    public function query($sql) {
        $this->stmt = $this->pdo->prepare($sql);
    }

    public function execute($params = []) {
        $this->stmt->execute($params);
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
?>
