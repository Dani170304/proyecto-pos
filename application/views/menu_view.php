<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <title>DRINK | MENU</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="icon" href="<?php echo base_url(); ?>assets/img/logo_drink.jpg" type="image/png">
        <!-- Incluye SweetAlert CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Carga de SweetAlert -->

</head>

<body class="index">

    <div class="contenedorTotal">
        <br><br>
        <section class="button-section">
            <button type="button" class="centered-button submit-button" id="boton1" onclick="inicio_1()">BOTELLAS</button>
            <button type="button" class="centered-button submit-button" id="boton2" onclick="inicio_2()">COCTELES</button>
            <button type="button" class="centered-button submit-button" id="boton3" onclick="inicio_3()">CERVEZAS</button>
            <button type="button" class="centered-button submit-button" id="boton5" onclick="inicio_5()">SODAS</button>
            <button type="button" class="centered-button submit-button" id="boton4" onclick="inicio_4()">OTROS</button>
        </section>
        <!-- Contenedor para mostrar productos -->
    
        <?php 
        $neonColors = [
            '#2ED411', '#FF007F', '#D1D12A', '#00D6D6', '#FF5F1F', '#E600E6', 
            '#9400D3', '#46959E', '#87A800', '#FF073A', '#23998D', '#6F8A0E'
        ];
        ?>

        <div class="mostrar" id="D1">
            <section class="products">
                <?php foreach ($products as $index => $product) : ?>
                    <?php if ($product['categoria'] === 'BOTELLA') : ?>
                        <?php 
                        // Selecciona el color de la lista usando el índice del producto
                        $color = $neonColors[$index % count($neonColors)]; 
                        ?>
                        <div class="product" 
                            data-index="<?= $product['id_producto'] ?>" 
                            data-name="<?= htmlspecialchars($product['nombre']) ?>" 
                            data-value="<?= $product['precio'] ?>" 
                            data-id="<?= $product['id_producto'] ?>" 
                            data-stock="<?= $product['stock'] ?>" 
                            data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" 
                            data-category="<?= $product['categoria'] ?>" 
                            style="background-color: <?= $color ?>;"
                            onclick="mostrarPopup('sodaComboPopup', <?= $product['stock'] ?>)">
                            <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                            <h3 class="title-beb"><?= htmlspecialchars($product['nombre']) ?></h3>
                            <p>Precio: Bs.<?= $product['precio'] ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </section>
        </div>


        <!-- Popup para selección de sodas -->
        <div class="popup-overlay" id="popupOverlay">
    <div class="popup" id="sodaComboPopup">
        <span id="popTitle">TIPO DE SODA</span>
        <section class="products">
            <?php foreach ($products as $key => $product) : ?>
                <?php if ($product['categoria'] === 'COMBO') : ?>
                    <?php 
                    // Selecciona un color de la lista de colores neón
                    $color = $neonColors[$key % count($neonColors)]; 
                    ?>
                    <div class="product" 
                         data-index="<?= $key; ?>" 
                         data-name="<?= $product['nombre']; ?>" 
                         data-value="<?= $product['precio']; ?>" 
                         data-id="<?= $product['id_producto']; ?>" 
                         data-stock="<?= $product['stock']; ?>"
                         data-category="<?= $product['categoria'] ?>" 
                         data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" 
                         style="background-color: <?= $color ?>;">
                        <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= $product['nombre']; ?>">
                        <p class="product-name"><?= $product['nombre']; ?></p>
                        <br>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </section>
    </div>
</div>
        <!-- Fin del popup -->

        <!-- Otras secciones para mostrar productos según categoría -->
        <div class="mostrar" id="D2">
    <section class="products">
        <?php foreach ($products as $index => $product) : ?>
            <?php if ($product['categoria'] === 'COCTEL') : ?>
                <?php 
                // Selecciona un color de la lista de colores neón
                $color = $neonColors[$index % count($neonColors)]; 
                ?>
                <div class="product" 
                     data-index="<?= $product['id_producto'] ?>" 
                     data-name="<?= htmlspecialchars($product['nombre']) ?>" 
                     data-value="<?= $product['precio'] ?>" 
                     data-id="<?= $product['id_producto'] ?>" 
                     data-stock="<?= $product['stock'] ?>"
                     data-category="<?= $product['categoria'] ?>" 
                     data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" 
                     style="background-color: <?= $color ?>;" >
                    <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                    <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                    <p>Precio: Bs.<?= $product['precio'] ?></p>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>
</div>
<!-- CERVEZA -->
<div class="mostrar" id="D3">
    <section class="products">
        <?php foreach ($products as $index => $product) : ?>
            <?php if ($product['categoria'] === 'CERVEZA') : ?>
                <?php 
                // Selecciona un color de la lista de colores neón
                $color = $neonColors[$index % count($neonColors)]; 
                ?>
                <div class="product" 
                     data-index="<?= $product['id_producto'] ?>" 
                     data-name="<?= htmlspecialchars($product['nombre']) ?>" 
                     data-value="<?= $product['precio'] ?>" 
                     data-id="<?= $product['id_producto'] ?>" 
                     data-stock="<?= $product['stock'] ?>"
                     data-category="<?= $product['categoria'] ?>" 
                     data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" 
                     style="background-color: <?= $color ?>;" >
                    <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                    <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                    <p>Precio: Bs.<?= $product['precio'] ?></p>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>
</div>

<!-- PIQUEO -->
<div class="mostrar" id="D4">
    <section class="products">
        <?php foreach ($products as $index => $product) : ?>
            <?php if ($product['categoria'] === 'PIQUEO') : ?>
                <?php 
                // Selecciona un color de la lista de colores neón
                $color = $neonColors[$index % count($neonColors)]; 
                ?>
                <div class="product" 
                     data-index="<?= $product['id_producto'] ?>" 
                     data-name="<?= htmlspecialchars($product['nombre']) ?>" 
                     data-value="<?= $product['precio'] ?>" 
                     data-id="<?= $product['id_producto'] ?>" 
                     data-stock="<?= $product['stock'] ?>"
                     data-category="<?= $product['categoria'] ?>" 
                     data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" 
                     style="background-color: <?= $color ?>;" >
                    <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                    <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                    <p>Precio: Bs.<?= $product['precio'] ?></p>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>
</div>

<!-- SODA -->
<div class="mostrar" id="D5">
    <section class="products">
        <?php foreach ($products as $index => $product) : ?>
            <?php if ($product['categoria'] === 'SODA') : ?>
                <?php 
                // Selecciona un color de la lista de colores neón
                $color = $neonColors[$index % count($neonColors)]; 
                ?>
                <div class="product" 
                     data-index="<?= $product['id_producto'] ?>" 
                     data-name="<?= htmlspecialchars($product['nombre']) ?>" 
                     data-value="<?= $product['precio'] ?>" 
                     data-id="<?= $product['id_producto'] ?>" 
                     data-stock="<?= $product['stock'] ?>" 
                     data-category="<?= $product['categoria'] ?>" 
                     data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" 
                     style="background-color: <?= $color ?>;" >
                    <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                    <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                    <p>Precio: Bs.<?= $product['precio'] ?></p>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>
</div>
    </div>
    <div class="orden">
    <section class="bill">


        <div class="bill-products">
            <h2 class="bold-text-orden"><b>ORDEN</b></h2>
            <ul id="cart-list" class="cart-items-list"></ul>

            <p class="bold-text-total" id="total">Total: Bs. 0</p>
        </div>
        <div class="bill-client">
            <form method="POST" action="<?= site_url('menu/ticket_orden') ?>" id="checkout-form">
                <div class="hidden">
                    <label for="cart">Carrito</label>
                    <input type="hidden" name="cart" id="cart" value="">
                </div>
                <div class="hidden">
                    <label for="cart">CarritoCombo</label>
                    <input type="hidden" name="cartCombo" id="cartCombo" value="">
                </div>

                <br>

                <div>
                    <input class="submit-confirmar" type="button" value="CONFIRMAR ORDEN" id="confirmar-btn">
                </div>
                <br>
                <?php if (isset($nombres) && isset($apellidos)) : ?>
                    <div class="bold-text-info">
                        <span class="span-nmbre">CLIENTE: </span>
                        <input type="text" value="<?= htmlspecialchars($nombres.'  '.$apellidos) ?>" readonly>
                        <input type="hidden" value="<?= htmlspecialchars($id_usuario) ?>" readonly>
                        
                    </div>
                <?php endif; ?>
                <br>
            </form>

            <div>
                <a class="close" href="<?php echo site_url('CerrarDrink'); ?>">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </section>
</div>
<div id="preloader"></div>
<script>
    window.addEventListener('load', function () {
        const preloader = document.getElementById('preloader');
        preloader.classList.add('hidden'); // Agrega la clase 'hidden' para iniciar la transición
        setTimeout(() => {
            preloader.style.display = 'none'; // Oculta el preloader después de la transición
        }, 500); // Este tiempo debe coincidir con la duración de la transición en CSS
    });

</script>


<script>
    
(function() {
    
    let productos = document.querySelectorAll('section.products > .product');
    let listaCarrito = document.getElementById('cart-list');
    let totalDisplay = document.getElementById('total');
    let itemsCarrito = [];
    let total = 0.00;
    let comboCounter = 0;

    totalDisplay.textContent = `Total: Bs. ${total.toFixed(2)}`;

    productos.forEach(producto => {
    producto.addEventListener('click', function(e) {
        let nombre = e.currentTarget.dataset.name;
        let valor = parseFloat(e.currentTarget.dataset.value);
        let id = e.currentTarget.dataset.id;
        let imagen = e.currentTarget.dataset.image;
        let categoria = e.currentTarget.dataset.category;
        let stock = parseInt(e.currentTarget.dataset.stock);

        // Verificación inicial de stock
        if (stock <= 0) {
            Swal.fire({
                title: 'Producto Agotado',
                text: `Lo sentimos, ${nombre} está agotado.`,
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        // Advertencias de stock bajo
        if (stock === 5) {
            Swal.fire({
                title: '¡Stock Limitado!',
                text: `Quedan solo 5 unidades de ${nombre}`,
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
        } else if (stock === 1) {
            Swal.fire({
                title: '¡Última Unidad!',
                text: `Solo queda 1 unidad de ${nombre}`,
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
        }

        if (categoria === 'BOTELLA') {
            // Buscar si el producto ya está en el carrito
            let itemExistente = itemsCarrito.find(item => item.id === id && !item.pairId);
            
            // Verificar si hay suficiente stock considerando la cantidad actual
            if (itemExistente && itemExistente.cantidad >= stock) {
                Swal.fire({
                    title: 'Stock Insuficiente',
                    text: `No hay suficiente stock de ${nombre}`,
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Si hay stock disponible, mostrar el popup y guardar información temporal
            mostrarPopup('sodaComboPopup', stock);
            sessionStorage.setItem('tempBottle', JSON.stringify({ id, nombre, valor, imagen, categoria, stock }));
            
        } else if (categoria === 'COMBO') {
            let bottleInfo = JSON.parse(sessionStorage.getItem('tempBottle'));
            if (bottleInfo) {
                // Verificar stock de la soda para el combo
                if (stock <= 0) {
                    Swal.fire({
                        title: 'Combo No Disponible',
                        text: `Lo sentimos, no hay stock disponible de la soda para este combo.`,
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                    sessionStorage.removeItem('tempBottle');
                    return;
                }

                let existingCombo = itemsCarrito.find(item => 
                    item.categoria === 'BOTELLA' && 
                    item.id === bottleInfo.id && 
                    item.comboId === id
                );

                if (existingCombo) {
                    aumentarCantidad(existingCombo.id, existingCombo.pairId, existingCombo.stock);
                } else {
                    comboCounter++;
                    let pairId = `${bottleInfo.id}-${id}-${comboCounter}`;
                    agregarAlCarrito(bottleInfo.id, bottleInfo.nombre, bottleInfo.valor, bottleInfo.imagen, bottleInfo.categoria, pairId, bottleInfo.stock, id);
                    agregarAlCarrito(id, nombre, valor, imagen, categoria, pairId);
                }
                sessionStorage.removeItem('tempBottle');
            }
        } else {
            agregarAlCarrito(id, nombre, valor, imagen, categoria, null, stock);
        }

        actualizarCarrito();
        actualizarStockVisual(id, stock - 1);
    });
});

    function agregarAlCarrito(id, nombre, valor, imagen, categoria, pairId = null, stock = null, comboId = null) {
        if (stock !== null && stock <= 0) {
            Swal.fire({
                title: 'Stock Agotado',
                text: `Lo sentimos, ${nombre} está agotado.`,
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        if (categoria === 'BOTELLA' || categoria === 'COMBO') {
            itemsCarrito.push({ 
                id, 
                nombre, 
                valor, 
                cantidad: 1, 
                imagen, 
                categoria, 
                pairId, 
                stock,
                comboId 
            });
        } else {
            let itemExistente = itemsCarrito.find(item => item.id === id && item.categoria === categoria);
            if (itemExistente) {
                if (stock !== null && itemExistente.cantidad >= stock) {
                    Swal.fire({
                        title: 'Stock Insuficiente',
                        text: `No hay suficiente stock de ${nombre}`,
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                    return false;
                }
                itemExistente.cantidad += 1;
            } else {
                itemsCarrito.push({ id, nombre, valor, cantidad: 1, imagen, categoria, pairId, stock });
            }
        }
        total += valor;
        return true;
    }

    function actualizarCarrito() {
        listaCarrito.innerHTML = '';

        itemsCarrito.forEach(item => {
            let li = document.createElement('li');
            li.style.display = 'table-row';
            li.innerHTML = `
                <span style="display: table-cell; width: 5%;">
                    <img src="${item.imagen}" alt="${item.nombre}" style="width: 30px; height: auto; margin-right: 5px;">
                </span>
                <span style="display: table-cell; width: 20%;">${item.nombre}</span>
                <span style="display: table-cell; width: 13%; text-align: right;">
                    ${item.valor > 0 ? `<strong>Bs. ${item.valor.toFixed(2)}</strong>` : ''}
                </span>
                <span style="display: table-cell; width: 7%; text-align: center;">x ${item.cantidad}</span>
                <span style="display: table-cell; width: 14%; text-align: right;">
                    ${item.categoria !== 'COMBO' ? `
                        <img src="<?php echo base_url(); ?>assets/img/mas.png" alt="Sumar" class="btn-mas" data-id="${item.id}" data-pair-id="${item.pairId || ''}" data-stock="${item.stock || 0}" style="cursor: pointer; width: 34px; height: auto; margin-right: -2px;">
                        <img src="<?php echo base_url(); ?>assets/img/menos.png" alt="Restar" class="btn-menos" data-id="${item.id}" data-pair-id="${item.pairId || ''}" style="cursor: pointer; width: 34px; height: auto; margin-right: -2px;">
                        <img src="<?php echo base_url(); ?>assets/img/borrar.png" alt="Borrar" class="btn-borrar" data-id="${item.id}" data-pair-id="${item.pairId || ''}" style="cursor: pointer; width: 24px; height: auto;">
                    ` : ''}
                </span>
            `;

            if (item.categoria !== 'COMBO') {
                li.querySelector('.btn-mas').addEventListener('click', function() {
                    // Obtener el stock actual del producto
                    let producto = document.querySelector(`[data-id="${item.id}"]`);
                    let stockActual = parseInt(producto.dataset.stock);

                    if (stockActual <= 0) {
                        Swal.fire({
                            title: 'Stock Agotado',
                            text: `Lo sentimos, ${item.nombre} está agotado.`,
                            icon: 'error',
                            confirmButtonText: 'Entendido'
                        });
                        return;
                    }

                    if (item.categoria === 'BOTELLA') {
                        // Verificar si hay sodas disponibles antes de mostrar el popup
                        let sodasDisponibles = false;
                        let popupSodas = document.querySelectorAll('#sodaComboPopup .product');
                        
                        popupSodas.forEach(soda => {
                            if (parseInt(soda.dataset.stock) > 0) {
                                sodasDisponibles = true;
                            }
                        });

                        if (!sodasDisponibles) {
                            Swal.fire({
                                title: 'Sodas Agotadas',
                                text: 'Lo sentimos, no hay stock disponible de sodas para combos.',
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                            return;
                        }

                        mostrarPopup('sodaComboPopup', stockActual);
                        sessionStorage.setItem('tempBottle', JSON.stringify({ 
                            id: item.id, 
                            nombre: item.nombre, 
                            valor: item.valor, 
                            imagen: item.imagen, 
                            categoria: item.categoria, 
                            stock: stockActual,
                            existingComboId: item.comboId
                        }));
                    } else {
                        aumentarCantidad(item.id, item.pairId, stockActual);
                    }
                });
                
                li.querySelector('.btn-menos').addEventListener('click', function() {
                    disminuirCantidad(item.id, item.pairId);
                });

                li.querySelector('.btn-borrar').addEventListener('click', function() {
                    eliminarDelCarrito(item.id, item.pairId);
                });
            }

            listaCarrito.appendChild(li);
        });

        totalDisplay.textContent = `Total: Bs. ${total.toFixed(2)}`;
        document.getElementById('cart').value = JSON.stringify(itemsCarrito);
    }

    function aumentarCantidad(id, pairId, stock) {
        let item = pairId 
            ? itemsCarrito.find(i => i.id === id && i.pairId === pairId)
            : itemsCarrito.find(i => i.id === id);
        
        if (item && stock !== null) {
            if (item.cantidad >= stock) {
                Swal.fire({
                    title: 'Stock Insuficiente',
                    text: `No hay suficiente stock de ${item.nombre}`,
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
                return;
            }
        }

        if (item) {
            if (item.categoria === 'BOTELLA' && !pairId) {
                mostrarPopup('sodaComboPopup', stock);
                return;
            }
            
            item.cantidad += 1;
            total += item.valor;

            if (pairId) {
                let comboItem = itemsCarrito.find(i => i.pairId === pairId && i.categoria === 'COMBO');
                if (comboItem) {
                    comboItem.cantidad += 1;
                    total += comboItem.valor;
                }
            }

            actualizarCarrito();
            actualizarStockVisual(id, stock - item.cantidad);
        }
    }

    function disminuirCantidad(id, pairId) {
        let item = pairId 
            ? itemsCarrito.find(i => i.id === id && i.pairId === pairId)
            : itemsCarrito.find(i => i.id === id);

        if (item) {
            if (item.cantidad > 1) {
                item.cantidad -= 1;
                total -= item.valor;

                if (pairId) {
                    let comboItem = itemsCarrito.find(i => i.pairId === pairId && i.categoria === 'COMBO');
                    if (comboItem) {
                        comboItem.cantidad -= 1;
                        total -= comboItem.valor;
                    }
                }
                
                // Actualizar stock visual al disminuir cantidad
                let stockActual = parseInt(document.querySelector(`[data-id="${id}"]`).dataset.stock);
                actualizarStockVisual(id, stockActual + 1);
            } else {
                eliminarDelCarrito(id, pairId);
            }

            actualizarCarrito();
        }
    }

    function eliminarDelCarrito(id, pairId) {
        let indices = [];
        let stockDevuelto = 0;
        
        itemsCarrito.forEach((item, index) => {
            if ((pairId && item.pairId === pairId) || (!pairId && item.id === id)) {
                indices.push(index);
                total -= item.valor * item.cantidad;
                stockDevuelto = item.cantidad;
            }
        });

        // Actualizar stock visual al eliminar del carrito
        if (stockDevuelto > 0) {
            let stockActual = parseInt(document.querySelector(`[data-id="${id}"]`).dataset.stock);
            actualizarStockVisual(id, stockActual + stockDevuelto);
        }

        indices.sort((a, b) => b - a).forEach(index => {
            itemsCarrito.splice(index, 1);
        });

        actualizarCarrito();
    }

    function actualizarStockVisual(id, nuevoStock) {
        let producto = document.querySelector(`[data-id="${id}"]`);
        if (producto) {
            producto.dataset.stock = nuevoStock;
            
            // Actualizar visualización del stock si existe un elemento para mostrarlo
            let stockDisplay = producto.querySelector('.stock-display');
            if (stockDisplay) {
                stockDisplay.textContent = `Stock: ${nuevoStock}`;
            }
        }
    }

    window.mostrarPopup = function(popupId, stock) {
    if (stock <= 0) {
        Swal.fire({
            title: 'Stock Agotado',
            text: 'Lo sentimos, este producto está agotado.',
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
        return;
    }

    cerrarPopup();

    var popup = document.getElementById(popupId);
    var overlay = document.getElementById('popupOverlay');

    if (popup && overlay) {
        overlay.style.display = 'block';
        popup.style.display = 'block';

        var productos = popup.querySelectorAll('.product');
        productos.forEach(function(producto) {
            let sodaStock = parseInt(producto.dataset.stock);
            
            if (sodaStock <= 0) {
                producto.style.opacity = '0.5';
                producto.style.cursor = 'not-allowed';
            } else {
                producto.style.opacity = '1';
                producto.style.cursor = 'pointer';
            }

            producto.addEventListener('click', function() {
                if (sodaStock <= 0) {
                    Swal.fire({
                        title: 'Soda No Disponible',
                        text: 'Lo sentimos, no hay stock disponible de esta soda.',
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                    return;
                }
                cerrarPopup();
            });
        });
    }
}

    function cerrarPopup() {
        var overlay = document.getElementById('popupOverlay');
        var popups = document.querySelectorAll('.popup');

        if (overlay) {
            overlay.style.display = 'none';
        }

        popups.forEach(function(popup) {
            popup.style.display = 'none';
        });
    }

    document.getElementById('confirmar-btn').addEventListener('click', function() {
        if (itemsCarrito.length === 0) {
            Swal.fire({
                title: '¡Atención!',
                text: "Por favor, selecciona al menos un producto antes de confirmar.",
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Una vez confirmada, no podrás editar tu pedido.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('checkout-form').submit();
            }
        });
    });
})();
</script>

    <script>
        let tipoBebidaContainer = document.getElementById('tipoBebidaContainer');
        let menuBotellas = document.getElementById('D1');
        let menuCocktails = document.getElementById('D2');
        let menuBeers = document.getElementById('D3');
        let menuSnacks = document.getElementById('D4');
        let menuSodas = document.getElementById('D5');



        function mostrarTipoBebida(displayStyle) {
            // Muestra el contenedor solo si el menú de botellas (D1) está activo
            tipoBebidaContainer.style.display = displayStyle;
        }
        document.getElementById("D1").style.display = "block";
        document.getElementById("D5").style.display = "none";

        function inicio_1() {
            document.getElementById("D1").style.display = "block";
            document.getElementById("D2").style.display = "none";
            document.getElementById("D3").style.display = "none";
            document.getElementById("D4").style.display = "none";
            document.getElementById("D5").style.display = "none";

            // Agrega la clase activa y quita la clase activa de los demás botones
            document.getElementById("boton1").classList.add("active-button");
            document.getElementById("boton2").classList.remove("active-button");
            document.getElementById("boton3").classList.remove("active-button");
            document.getElementById("boton4").classList.remove("active-button");
            document.getElementById("boton5").classList.remove("active-button");
        }

        function inicio_2() {
            document.getElementById("D1").style.display = "none";
            document.getElementById("D2").style.display = "block";
            document.getElementById("D3").style.display = "none";
            document.getElementById("D4").style.display = "none";
            document.getElementById("D5").style.display = "none";

            // Agrega la clase activa y quita la clase activa de los demás botones
            document.getElementById("boton1").classList.remove("active-button");
            document.getElementById("boton2").classList.add("active-button");
            document.getElementById("boton3").classList.remove("active-button");
            document.getElementById("boton4").classList.remove("active-button");
            document.getElementById("boton5").classList.remove("active-button");
        }

        function inicio_3() {
            document.getElementById("D1").style.display = "none";
            document.getElementById("D2").style.display = "none";
            document.getElementById("D3").style.display = "block";
            document.getElementById("D4").style.display = "none";
            document.getElementById("D5").style.display = "none";

            // Agrega la clase activa y quita la clase activa de los demás botones
            document.getElementById("boton1").classList.remove("active-button");
            document.getElementById("boton2").classList.remove("active-button");
            document.getElementById("boton3").classList.add("active-button");
            document.getElementById("boton4").classList.remove("active-button");
            document.getElementById("boton5").classList.remove("active-button");
        }

        function inicio_4() {
            document.getElementById("D1").style.display = "none";
            document.getElementById("D2").style.display = "none";
            document.getElementById("D3").style.display = "none";
            document.getElementById("D4").style.display = "block";
            document.getElementById("D5").style.display = "none";

            // Agrega la clase activa y quita la clase activa de los demás botones
            document.getElementById("boton1").classList.remove("active-button");
            document.getElementById("boton2").classList.remove("active-button");
            document.getElementById("boton3").classList.remove("active-button");
            document.getElementById("boton4").classList.add("active-button");
            document.getElementById("boton5").classList.remove("active-button");
        }

        function inicio_5() {
            document.getElementById("D1").style.display = "none";
            document.getElementById("D2").style.display = "none";
            document.getElementById("D3").style.display = "none";
            document.getElementById("D4").style.display = "none";
            document.getElementById("D5").style.display = "block";

            // Agrega la clase activa y quita la clase activa de los demás botones
            document.getElementById("boton1").classList.remove("active-button");
            document.getElementById("boton2").classList.remove("active-button");
            document.getElementById("boton3").classList.remove("active-button");
            document.getElementById("boton4").classList.remove("active-button");
            document.getElementById("boton5").classList.add("active-button");
        }
    </script>
</body>

</html>