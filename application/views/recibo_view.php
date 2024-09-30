<?php
date_default_timezone_set('America/La_Paz');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bill.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body class="bill">
<section id="bill-print" class="bill-print">
    <div class="bill-print-header">
        <h1 class="bold-text">DRINKMASTER</h1>
        <p class="bold-text"><span>DRINKMASTER.COM</span></p>
        <p class="bold-text"><span>Cochabamba, Bolivia</span></p>
        <p class="bold-text"><?php echo date('d/m/Y H:i', strtotime($fecha_hora)); ?></p> <!-- Mostrar fecha y hora -->
    </div>
    <div class="bill-print-user">
        <p><span>Usuario:</span> <span><?php echo $mesero; ?></span></p>
        <p><span>N° de Orden:</span> <span><?php echo $id_orden; ?></span></p>
    </div>
    <div class="bill-print-products">
    <table>
        <tr>
            <th>Cant.</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Subtotal</th>
        </tr>
        <?php 
        $total = 0; // Inicializa el total
        if (isset($cart) && is_array($cart)) {
            foreach ($cart as $item) { 
                $subtotal = $item['valor'] * $item['cantidad']; // Calcular el subtotal multiplicando el precio por la cantidad
                $total += $subtotal; // Acumula el total
        ?>
                <tr>
                    <td class='product-quantity'>x<?php echo $item['cantidad']; ?></td> <!-- Mostrar cantidad real -->
                    <td class='product-name'><?php echo $item['nombre']; ?></td> 
                    <td class='product-value'><?php echo $item['valor']; ?> Bs</td> <!-- Precio unitario -->
                    <td class='product-total'><?php echo $subtotal; ?> Bs</td> <!-- Subtotal -->
                </tr>
        <?php 
            } 
        }
        ?>
    </table>
</div>

    <div class="bill-print-total">
        <p><span>Importe TOTAL Bs:</span> <span><?php echo $total; ?></span></p>
        <p>Son: <?php echo $literal_total; ?></p>
    </div>
</section>
<section class="bill-actions">
    <button id="print">Imprimir</button>
    <button id="new">Nuevo</button>
</section>

    <script>
        (function() {
            document.querySelector('#print').addEventListener('click', function() {
                window.print();
            });
            let newButton = document.querySelector('#new');
            newButton.addEventListener('click', function() {
                window.location = '<?php echo base_url("index.php/menu/nueva_orden"); ?>';
            });
        })();
    </script>
</body>
</html>
