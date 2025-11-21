<?php
require 'conexion.php';
echo "<h1>Ejercicio 5 y 6</h1>";

try {
    $pdo->beginTransaction();
    $cat_id = 1;
    $sql = "UPDATE productos SET precio = precio * 1.10 WHERE categoria_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cat_id]);
    echo "<p>Precios actualizados (subida 10%).</p>";

    $prod_id = 4;
    $cantidad_a_restar = 5;

    $check = $pdo->prepare("SELECT stock FROM productos WHERE id = ?");
    $check->execute([$prod_id]);
    $stock_actual = $check->fetchColumn();

    if ($stock_actual >= $cantidad_a_restar) {
        $update = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
        $update->execute([$cantidad_a_restar, $prod_id]);
        echo "<p>Stock reducido de la mandarina.</p>";
    } else {
        echo "<p>No se pudo reducir stock.</p>";
    }

    $pdo->commit();
    echo "<h3>Borrando productos sin stok</h3>";

    $sql_borrar = "UPDATE productos SET eliminado = 1 WHERE stock = 0";
    $stmt = $pdo->query($sql_borrar);

    echo "<p>Productos eliminados: " . $stmt->rowCount() . "</p>";

    echo "<h4>Lista actual:</h4>";
    $ver = $pdo->query("SELECT nombre FROM productos WHERE eliminado = 0");
    while($f = $ver->fetch(PDO::FETCH_ASSOC)){
        echo "- " . $f['nombre'] . "<br>";
    }

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Hubo un error: " . $e->getMessage();
}
?>
<br>
<a href="compra.php">Ir a ejercicio 7</a>