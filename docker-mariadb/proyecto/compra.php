<?php
require 'conexion.php';
echo "<h1>Ejercicio 7</h1>";

$id_usuario = 1;
$id_producto = 1; // Naranja
$cantidad = 10;

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT precio, stock FROM productos WHERE id = ? AND eliminado = 0");
    $stmt->execute([$id_producto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto || $producto['stock'] < $cantidad) {
        throw new Exception("Stock insuficiente o producto no disponible.");
    }

    $total_pagar = $producto['precio'] * $cantidad;

    $stmtPedido = $pdo->prepare("INSERT INTO pedidos (usuario_id, total) VALUES (?, ?)");
    $stmtPedido->execute([$id_usuario, $total_pagar]);

    $id_pedido = $pdo->lastInsertId();

    $stmtDetalle = $pdo->prepare("INSERT INTO detalles_pedidos (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)");
    $stmtDetalle->execute([$id_pedido, $id_producto, $cantidad]);

    $stmtStock = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
    $stmtStock->execute([$cantidad, $id_producto]);
    $pdo->commit();

    echo "<div style='background:lightgreen; padding:10px;'>";
    echo "Compra realizada con exito.<br>";
    echo "Total: $total_pagar €<br>";
    echo "Stock restante actualizado.";
    echo "</div>";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "<div style='background:pink; padding:10px;'>";
    echo "X" . $e->getMessage();
    echo "</div>";
}
?>
<br>
<a href="reportes.php">Ir a ejercicio 8</a>