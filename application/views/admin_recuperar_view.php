<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="<?php echo base_url('assets/css/bill.css'); ?>">
    <style>
        .btn {
            font-weight: bold;
        }

        .btn-morado {
            background-color: #6f42c1;
            color: white;
        }

        .btn-morado:hover {
            background-color: #563d7c;
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .color-num {
            color: #083CC2;
            font-weight: bold;
        }

        .hr-ta {
            margin-top: -10px;
            margin-bottom: 30px;
            border: 1px solid #ccc;
        }

        /* Nuevos estilos para el formulario de búsqueda */
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            margin: 0 auto;
            max-width: 600px;
        }

        .search-container form {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            gap: 10px;
        }

        .search-input {
            padding: 8px 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            width: 200px;
            height: 38px;
            font-size: 1rem;
        }

        .date-picker {
            margin: 0;
        }

        /* Estilos para el ticket */
        .bill-print {
            font-family: 'Courier New', Courier, monospace;
        }
        
        .bill-print-header {
            text-align: center;
            margin-bottom: 20px;
            color: #000;
        }
        
        .bill-print-products table {
            width: 100%;
            margin: 15px 0;
        }
        
        .bill-print-total {
            color: #000;
        }

        .bill-print-user {
            color: #000;
        }
        section.bill-actions button {
display: block;
background: #D20058;
border: 1px solid #D20058;
border-radius: 5px;
box-sizing: border-box;
color: #ffffff;
font-size: 1rem;
margin: 1rem auto;
max-width: 350px;
padding: 0.5rem 1.5rem;
transition: 0.3s ease-in-out;
width: 100%;
font-weight: bold;
}
section.bill-actions button:hover {
background: #008DEB;
border: 1px solid #008DEB;
color: #000;
transform: scale(0.9); /* Hacer el botón un 5% más pequeño */
transition: transform 0.2s ease-in-out; /* Suavizar la transición */
}
.copy-text {
            font-weight: bold;
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 10px;
            text-align: center;
            color: #000;
        }

        /* Asegurarse de que COPIA aparezca en la impresión */
        @media print {
            .copy-text {
                display: block !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact;
            }
            .bill-actions {
                display: none !important;
            }
        }

        .bold-text {
            font-weight: bold;
        }
        .preview-title {
    font-weight: bold;
    margin-bottom: 5px;
    color: #6f42c1;
  }
    </style>
</head>
<body>
    <!-- El resto del HTML permanece igual -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 id="title">RECUPERAR TICKET</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tickets</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <div class="card-info">
            <div class="card-body">
                <div class="search-container">
                    <form method="POST" action="<?php echo base_url('index.php/admin/recuperarTicket'); ?>" id="searchForm">
                        <input type="number" name="orden_id" class="search-input date-picker" placeholder="Ingrese nro. de orden" required>
                        <button type="submit" class="btn btn-morado">Buscar Ticket</button>
                    </form>
                </div>
                <br>
                <hr class="hr-ta">

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($ticket)): ?>
        <div class="ticket-container">
            <section class="bill-print">
                <div class="bill-print-header">
                    <h1 class="bold-text">DRINKMASTER</h1>
                    <p class="bold-text"><span>DRINKMASTER.COM</span></p>
                    <p class="bold-text"><span>Cochabamba, Bolivia</span></p>
                    <p class="bold-text"><?php echo date('d/m/Y H:i', strtotime($ticket['fecha_hora'])); ?></p>
                    <p class="copy-text">COPIA</p>
                </div>
                <div class="bill-print-user">
                    <p><span>Usuario:</span> <span><?php echo $ticket['mesero']; ?></span></p>
                    <p><span>N° de Orden:</span> <span><?php echo $ticket['id_orden']; ?></span></p>
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
                        $total = 0;
                        foreach ($ticket['cart'] as $item): 
                            $subtotal = $item['valor'] * $item['cantidad'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td class='product-quantity'>x<?php echo $item['cantidad']; ?></td>
                                <td class='product-name'><?php echo $item['nombre']; ?></td>
                                <td class='product-value'><?php echo number_format($item['valor'], 2); ?> Bs</td>
                                <td class='product-total'><?php echo number_format($subtotal, 2); ?> Bs</td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="bill-print-total">
                    <p><span>Importe TOTAL Bs:</span> <span><?php echo number_format($total, 2); ?></span></p>
                    <p>Son: <?php echo $ticket['literal_total']; ?></p>
                </div>
            </section>
            <section class="bill-actions">
                <button id="print">Imprimir</button>
            </section>
        </div>

        <script>
            // Convertir los datos PHP a JavaScript
            const cart = <?php echo json_encode($ticket['cart']); ?>;
            const mesero = <?php echo json_encode($ticket['mesero']); ?>;
            const id_orden = <?php echo json_encode($ticket['id_orden']); ?>;
            const fecha_hora = <?php echo json_encode($ticket['fecha_hora']); ?>;

            async function sendBillToPHP(billData) {
                try {
                    const response = await fetch('<?php echo base_url("index.php/Ticket/save_bill_2"); ?>', {
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
                        title: 'Error',
                        text: error.message
                    });
                    return false;
                }
            }

            // Manejador del botón de impresión
            document.querySelector('#print').addEventListener('click', async function() {
                // Recolectar los datos de la factura
                const billData = {
                    cart: cart,
                    name: mesero,
                    id: id_orden,
                    metodoPago: 'Efectivo',
                    newIdOrden: id_orden,
                    fecha_hora: fecha_hora
                };

                // Enviar al PHP para guardar
                const saved = await sendBillToPHP(billData);

                if (saved) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Imprimiendo factura',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                    });
                }
            });
        </script>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
            document.getElementById('searchForm').reset();
        });
    </script>
</body>
</html>