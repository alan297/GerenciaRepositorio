<?php

// require_once '../../Categorias/model/CategoriaModel.php';
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
class Categoria
{
    private $conexion;

    public function __construct()
    {
        $conexionDB = new DataBase();
        $this->conexion = $conexionDB->getConnection();
    }

    public function insertarCategoriaGasto($nombre)
    {
        try {
            $stmt = $this->conexion->prepare("CALL insertar_categoria_gasto(:nombre)");
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            // echo "Categoría registrada exitosamente.";
        } catch (PDOException $e) {
            // echo "Error al insertar la categoría: " . $e->getMessage();
        }
    }

    public function obtenerCategorias()
    {
        try {
            $stmt = $this->conexion->prepare("CALL obtener_categorias_gasto()");
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultados;
        } catch (PDOException $e) {
            echo "Error al obtener las categorías: " . $e->getMessage();
        }
    }

    public function actualizarCategoriaGasto($categoriagasto_id, $nombre)
    {
        try {
            $stmt = $this->conexion->prepare("CALL actualizar_categoria_gasto(:categoriagasto_id, :nombre)");
            $stmt->bindParam(':categoriagasto_id', $categoriagasto_id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            echo "Categoría actualizada exitosamente.";
        } catch (PDOException $e) {
            echo "Error al actualizar la categoría: " . $e->getMessage();
        }
    }

    public function eliminarCategoriaGasto($categoriagasto_id)
    {
        try {
            $stmt = $this->conexion->prepare("CALL eliminar_categoria_gasto(:categoriagasto_id)");
            $stmt->bindParam(':categoriagasto_id', $categoriagasto_id, PDO::PARAM_INT);
            $stmt->execute();
            echo "Categoría eliminada exitosamente.";
        } catch (PDOException $e) {
            echo "Error al eliminar la categoría: " . $e->getMessage();
        }
    }
}
$categoria = new Categoria();
$valores = $categoria->obtenerCategorias();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Finanzas</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <!-- Formulario de Gastos -->
    <form id="formulario-gastos" class="p-4 bg-info rounded shadow" style="width: 80%; max-width: 400px;">
        <h4 class="text-center text-white mb-3">Gastos</h4>
        <div class="form-group">
            <span style="color: #ffffff; font-weight: bold;">Nombre del gasto</span>
            <input type="text" name="nombre_gasto" class="form-control" placeholder="Nombre del gasto">
            <!-- <input type="text" name="nombre_categoria" class="form-control" placeholder="Nombre del gasto"> -->
        
        </div>
        <div class="form-group">
            <span style="color: #ffffff; font-weight: bold;">Monto</span>
            <input type="number" name="monto_gasto" class="form-control" placeholder="Insertar monto">
        </div>
        <span style="color: #ffffff; font-weight: bold;">Categoria</span>
        <div class="form-group">
        <select class="form-control" name="nombre_categoria">
            <?php
            // Recorrer el array y crear las opciones
            foreach ($valores as $valor) {
                // Solo agregar si el nombre no está vacío
                if (!empty($valor['nombre'])) {
                    echo "<option value=\"{$valor['categoriagasto_id']}\">{$valor['nombre']}</option>";
                }
            }
            ?>
        </select>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-dark text-white" style="width: 100%;" id="botonRegistrarGasto" >Registrar Gasto</button>
        </div>        
    </form>

    <script>
        const botonRegistrarGasto = document.getElementById("botonRegistrarGasto");
        const formulario = document.getElementById("formulario-gastos");
        
        botonRegistrarGasto.addEventListener("click",(event)=>{
            event.preventDefault();

            fetch("../controller/CinsertarGasto.php",{
                method:"POST",
                body: new FormData(formulario)
                }).then(response => response.text())
                .then(response => {
                alert(response);
                
                // Guardar la última actividad (fecha y hora) en el localStorage
                function actualizarUltimaActividad() {
                    const fechaActual = new Date();
                    localStorage.setItem("ultimaActividad", fechaActual.toString());
                }

                // Llamar esta función cada vez que el usuario registre un gasto o realice alguna acción
                localStorage.getItem("ultimaActividad")

            })
        })

  
    </script>
</body>
</html>
