<?php
require 'conexion.php';
?>

<h3>Productos por precio de menor a mayor</h3>
<ul>
    <?php
    $stmt = $pdo->query("SELECT nombre, precio FROM productos ORDER BY precio ASC");
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>" . $fila['nombre'] . " (" . $fila['precio'] . "€)</li>";
    }
    ?>
</ul>

<h3>Produtos de una categoria</h3>
<?php
$id_categoria = 1;
$stmt = $pdo->prepare("SELECT nombre FROM productos WHERE categoria_id = ?");
$stmt->execute([$id_categoria]);

while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Opción: " . $fila['nombre'] . "<br>";
}
?>

<h3>Productos con stock bajo</h3>
<?php
$limite = 20;
$stmt = $pdo->prepare("SELECT nombre, stock FROM productos WHERE stock < ?");
$stmt->execute([$limite]);

while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<span style='color:red'> !" . $fila['nombre'] . " (Stock: " . $fila['stock'] . ")</span><br>";
}
?>

<h3>Ejercicio 4</h3>
<table border="1">
    <tr><th>Producto</th><th>Precio</th><th>Categoría</th></tr>
    <?php
    $sql = "SELECT p.nombre, p.precio, c.nombre as nombre_categoria 
            FROM productos p 
            INNER JOIN categorias c ON p.categoria_id = c.id
            ORDER BY c.nombre, p.precio";

    $stmt = $pdo->query($sql);
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $fila['nombre'] . "</td>";
        echo "<td>" . $fila['precio'] . "</td>";
        echo "<td>" . $fila['nombre_categoria'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>
<br>
<a href="modificaciones.php">Ir a ejercicio 5 6</a>
