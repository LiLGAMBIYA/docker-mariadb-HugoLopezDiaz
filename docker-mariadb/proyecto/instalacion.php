<?php
require 'conexion.php';

echo "<h1>Instalando Base de Datos</h1>";

try {
    $pdo->exec("DROP TABLE IF EXISTS detalles_pedidos, pedidos, productos, usuarios, categorias");

    //Tabla de categorias
    $pdo->exec("CREATE TABLE categorias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL,
        descripcion TEXT
    )");

    //Tabla usuarios
    $pdo->exec("CREATE TABLE usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100),
        email VARCHAR(100) UNIQUE,
        contrasena VARCHAR(255)
    )");

    //Tabla productos
    $pdo->exec("CREATE TABLE productos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100),
        categoria_id INT,
        precio DECIMAL(10, 2),
        stock INT,
        eliminado TINYINT(1) DEFAULT 0, 
        FOREIGN KEY (categoria_id) REFERENCES categorias(id)
    )");

    //Tabla pedidos
    $pdo->exec("CREATE TABLE pedidos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT,
        fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
        total DECIMAL(10, 2),
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )");

    $pdo->exec("CREATE TABLE detalles_pedidos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        pedido_id INT,
        producto_id INT,
        cantidad INT,
        FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
    )");

    echo "<p>Tablas creadas correctamente.</p>";


    $pdo->exec("INSERT INTO categorias (nombre) VALUES ('Cítricos'), ('Frutas Rojas'), ('Tropicales')");

    $pdo->exec("INSERT INTO usuarios (nombre, email) VALUES ('Pepe', 'pepe@correo.com')");

    $sql = "INSERT INTO productos (nombre, categoria_id, precio, stock) VALUES 
            ('Naranja', 1, 1.50, 100),
            ('Limón', 1, 0.80, 50),
            ('Pomelo', 1, 1.20, 30),
            ('Mandarina', 1, 1.80, 80),
            ('Fresa', 2, 3.00, 40),
            ('Arándano', 2, 5.00, 5),  
            ('Frambuesa', 2, 4.50, 20),
            ('Plátano', 3, 1.10, 200),
            ('Mango', 3, 2.50, 0),    
            ('Piña', 3, 3.00, 30)";
    $pdo->exec($sql);

    echo "<p>Datos insertados.</p>";
    echo "<a href='consultas.php'>Ir al siguiente ejercicio</a>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>