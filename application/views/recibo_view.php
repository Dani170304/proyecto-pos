<?php
date_default_timezone_set('America/La_Paz');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRINK | TICKET</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bill.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="icon" href="<?php echo base_url(); ?>assets/img/logo_drink.jpg" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bill">
    <br>
    <div>
        <a class="close-ticket" href="<?php echo site_url('CerrarDrink'); ?>">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>
    </div>
    <img src="<?php echo base_url(); ?>assets/img/logo_drink_sinFondo2.png" type="image/png" alt="" class="logo-img">
    <img src="<?php echo base_url(); ?>assets/img/logo.png" type="image/png" alt="" class="logo-img-eben">


    <div id="preloader"></div>

    <h1 class="titulo">TICKET</h1>
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
                            <td class='product-value'><?php echo number_format($item['valor'], 2); ?> Bs</td> <!-- Precio unitario -->
                            <td class='product-total'><?php echo number_format($subtotal, 2); ?> Bs</td> <!-- Subtotal -->
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>

        <div class="bill-print-total">
            <p><span>Importe TOTAL Bs:</span> <span><?php echo number_format($total, 2); ?></span></p> <!-- Total -->
            <p>Son: <?php echo $literal_total; ?></p>
        </div>
    </section>
    <section class="bill-actions">
        <button id="print">Imprimir</button>
        <!-- <button id="new">Nuevo</button> -->
    </section>

    <script>
        // Primero, convertimos los datos PHP a JavaScript
        const cart = <?php echo json_encode($cart); ?>;
        const mesero = <?php echo json_encode($mesero); ?>;
        const id_orden = <?php echo json_encode($id_orden); ?>;
        const fecha_hora = <?php echo json_encode($fecha_hora); ?>;

        async function sendBillToPHP(billData) {
            try {
                const response = await fetch('<?php echo base_url("/index.php/Ticket/save_bill"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(billData)
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.error || 'Error al guardar la factura');
                }

                console.log('Factura guardada:', result);
                return true;
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error: ' + error.message
                });
                return false;
            }
        }

        // Manejador del botón de impresión con monitore de carpeta
        // document.querySelector('#print').addEventListener('click', async function() {
        //     // Recolectar los datos de la factura usando las variables que definimos arriba
        //     const billData = {
        //         cart: cart,
        //         name: mesero,
        //         id: id_orden,
        //         metodoPago: 'Efectivo', // O podrías tener un select para esto
        //         newIdOrden: id_orden,
        //         fecha_hora: fecha_hora
        //     };

        //     // Enviar al PHP para guardar
        //     const saved = await sendBillToPHP(billData);

        //     if (saved) {
        //         Swal.fire({
        //             icon: 'success',
        //             title: '¡Éxito!',
        //             text: 'Imprimiendo factura',
        //             showConfirmButton: false,
        //             timer: 1500
        //         });
        //     }
        // });


        document.querySelector('#print').addEventListener('click', async function() {
    try {
        // Ocultamos temporalmente los botones para la impresión
        const billActions = document.querySelector('.bill-actions');
        const originalDisplay = billActions.style.display;
        billActions.style.display = 'none';
        
        // Primera impresión
        await printTicket("Primera impresión");
        
        // Segunda impresión
        await printTicket("Segunda impresión");
        
        // Restauramos los botones después de la impresión
        billActions.style.display = originalDisplay;
        
        // Mensaje final y redirección
        Swal.fire({
            icon: 'success',
            title: '¡Impresión completada!',
            text: 'Cerrando sesión...',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            // Redirigir al login después de cerrar sesión
            window.location.href = '<?php echo site_url("Login"); ?>';
        });
        
    } catch (error) {
        console.error('Error al imprimir:', error);
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error: ' + error.message
        });
    }
});

// Función para imprimir el ticket
async function printTicket(title) {
    return new Promise((resolve) => {
        // Aseguramos que el ticket sea visible
        const billPrint = document.getElementById('bill-print');
        billPrint.style.display = 'block';
        
        // Mostramos el mensaje de preparación
        Swal.fire({
            icon: 'info',
            title: 'Preparando impresión',
            text: title,
            showConfirmButton: false,
            timer: 500
        }).then(() => {
            // Antes de imprimir, aseguramos que los estilos estén correctamente aplicados
            document.body.classList.add('printing');
            
            // Llamamos al diálogo de impresión del navegador
            window.print();
            
            // Esperamos a que termine la impresión
            setTimeout(() => {
                document.body.classList.remove('printing');
                resolve();
            }, 100);
        });
    });
}
        // Manejador del botón nuevo
        // document.querySelector('#new').addEventListener('click', function() {
        //     window.location = '<?php echo base_url("index.php/menu/nueva_orden"); ?>';
        // });
    </script>
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('hidden'); // Agrega la clase 'hidden' para iniciar la transición
            setTimeout(() => {
                preloader.style.display = 'none'; // Oculta el preloader después de la transición
            }, 500); // Este tiempo debe coincidir con la duración de la transición en CSS
        });
    </script>

</body>

</html>