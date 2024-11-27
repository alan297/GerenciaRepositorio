<?php
class Database {
    private $host = "bezirivychjwzl8wvo83-mysql.services.clever-cloud.com";
    private $dbname = "bezirivychjwzl8wvo83";
    private $username = "uyx5ubcf1vi0vs6k";
    private $password = "YbBZklP2FDVLhzbvPEEL";
    private $pdo;

    public function __construct() {
        $this->pdo = $this->connect();
    }

    private function connect() {
        try {
            // Crear una instancia de PDO
            $pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->username, $this->password);
            // Configurar el modo de error de PDO
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            // Manejo de errores
            echo "Error de conexión: " . $e->getMessage();
            return null; // Retorna null en caso de error
        }
    }

    public function getConnection() {
        return $this->pdo; // Retorna el objeto PDO
    }
}
?>
