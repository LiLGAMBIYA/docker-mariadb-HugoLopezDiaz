<?php
require 'conexion.php';
echo "<h1>Ejercicio 8</h1>";
?>

    <h3>a) Productos mas vendidos</h3>
<?php
$sql = "SELECT p.nombre, SUM(d.cantidad) as total_vendido
        FROM productos p
        JOIN detalles_pedidos d ON p.id = d.producto_id
        GROUP BY p.id
        ORDER BY total_vendido DESC";

$stmt = $pdo->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Producto: " . $row['nombre'] . " - Vendidos: " . $row['total_vendido'] . "<br>";
}
?>

    <h3>b) Ingresos totales posibles por categora</h3>
<?php
$sql = "SELECT c.nombre, SUM(p.precio * p.stock) as dinero_en_stock
        FROM categorias c
        JOIN productos p ON c.id = p.categoria_id
        WHERE p.eliminado = 0
        GROUP BY c.id";

$stmt = $pdo->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Categoría " . $row['nombre'] . ": " . $row['dinero_en_stock'] . "€<br>";
}
?>

    <h3>c)Stock Bajo</h3>
<?php
$stmt = $pdo->query("SELECT nombre, stock FROM productos WHERE stock < 10 AND eliminado = 0");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "!" . $row['nombre'] . " (Quedan: " . $row['stock'] . ")<br>";
}
?>

    <h3>d) Mayor compras</h3>
<?php
$sql = "SELECT u.nombre, COUNT(p.id) as num_pedidos
        FROM usuarios u
        JOIN pedidos p ON u.id = p.usuario_id
        GROUP BY u.id
        ORDER BY num_pedidos DESC";

$stmt = $pdo->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Usuario: " . $row['nombre'] . " tiene " . $row['num_pedidos'] . " pedidos.<br>";
}
?>