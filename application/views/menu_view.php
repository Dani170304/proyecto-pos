<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <title>MENU</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <link rel="icon" href="<?php echo base_url(); ?>assets/img/logo_drink.jpg" type="image/png">
        <!-- Incluye SweetAlert CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Incluye SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="index">
    <div class="contenedorTotal">
        <br><br>
        <section class="button-section">
            <button type="button" class="centered-button submit-button" id="boton1" onclick="inicio_1()">BOTELLAS</button>
            <button type="button" class="centered-button submit-button" id="boton2" onclick="inicio_2()">COCTELES</button>
            <button type="button" class="centered-button submit-button" id="boton3" onclick="inicio_3()">CERVEZAS</button>
            <button type="button" class="centered-button submit-button" id="boton5" onclick="inicio_5()">SODAS</button>
            <button type="button" class="centered-button submit-button" id="boton4" onclick="inicio_4()">PIQUEOS / SALADITOS</button>
        </section>
        <!-- Contenedor para mostrar productos -->
        <div class="mostrar" id="D1">
            <section class="products">
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['categoria'] === 'BOTELLA') : ?>
                        <div class="product" data-index="<?= $product['id_producto'] ?>" 
                             data-name="<?= htmlspecialchars($product['nombre']) ?>" 
                             data-value="<?= $product['precio'] ?>" 
                             data-id="<?= $product['id_producto'] ?>" 
                             data-stock="<?= $product['stock'] ?>" 
                             data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" 
                             data-category="<?= $product['categoria'] ?>" 
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
                            <div class="product" data-index="<?= $key; ?>" 
                                 data-name="<?= $product['nombre']; ?>" 
                                 data-value="<?= $product['precio']; ?>" 
                                 data-id="<?= $product['id_producto']; ?>" 
                                 data-stock="<?= $product['stock']; ?>"
                                 data-category="<?= $product['categoria'] ?>" 
                                 data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" >
                                <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= $product['nombre']; ?>">
                                <p class="product-name"><?= $product['nombre']; ?></p>
                                <br>
                                <p class="bold-text"><?= $product['precio'] . " Bs."; ?></p>
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
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['categoria'] === 'COCTEL') : ?>
                        <div class="product" data-index="<?= $product['id_producto'] ?>" 
                             data-name="<?= htmlspecialchars($product['nombre']) ?>" 
                             data-value="<?= $product['precio'] ?>" 
                             data-id="<?= $product['id_producto'] ?>" 
                             data-stock="<?= $product['stock'] ?>"
                             data-category="<?= $product['categoria'] ?>" 
                             data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>">
                            <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                            <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                            <p>Precio: Bs.<?= $product['precio'] ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </section>
        </div>
        <div class="mostrar" id="D3">
            <section class="products">
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['categoria'] === 'CERVEZA') : ?>
                        <div class="product" 
                             data-index="<?= $product['id_producto'] ?>" 
                             data-name="<?= htmlspecialchars($product['nombre']) ?>" 
                             data-value="<?= $product['precio'] ?>" 
                             data-id="<?= $product['id_producto'] ?>" 
                             data-stock="<?= $product['stock'] ?>"
                             data-category="<?= $product['categoria'] ?>" 
                             data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>">
                            <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                            <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                            <p>Precio: Bs.<?= $product['precio'] ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </section>
        </div>
        <div class="mostrar" id="D4">
            <section class="products">
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['categoria'] === 'PIQUEO') : ?>
                        <div class="product" 
                             data-index="<?= $product['id_producto'] ?>" 
                             data-name="<?= htmlspecialchars($product['nombre']) ?>" 
                             data-value="<?= $product['precio'] ?>" 
                             data-id="<?= $product['id_producto'] ?>" 
                             data-stock="<?= $product['stock'] ?>"
                             data-category="<?= $product['categoria'] ?>" 
                             data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>">
                            <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                            <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                            <p>Precio: Bs.<?= $product['precio'] ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </section>
        </div>
        <div class="mostrar" id="D5">
            <section class="products">
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['categoria'] === 'SODA') : ?>
                        <div class="product" 
                             data-index="<?= $product['id_producto'] ?>" 
                             data-name="<?= htmlspecialchars($product['nombre']) ?>" 
                             data-value="<?= $product['precio'] ?>" 
                             data-id="<?= $product['id_producto'] ?>" 
                             data-stock="<?= $product['stock'] ?>" 
                             data-category="<?= $product['categoria'] ?>" 
                             data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>">
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
                    <input class="submit-confirmar" type="button" value="CONFIRMAR" id="confirmar-btn">
                </div>
                <br>
                <?php if (isset($nombres)) : ?>
                    <div class="bold-text-info">
                        <span>NOMBRE DE USUARIO</span>
                        <input type="text" value="<?= htmlspecialchars($nombres) ?>" readonly>
                        <input type="hidden" value="<?= htmlspecialchars($id_usuario) ?>" readonly>
                        
                    </div>
                <?php endif; ?>
                <br>
            </form>
            <div>
                <a class="close" href="<?php echo site_url('CerrarDrink'); ?>">Cerrar Sesión</a>
            </div>
        </div>
    </section>
</div>

<script>
(function() {
    let productos = document.querySelectorAll('section.products > .product');
    let listaCarrito = document.getElementById('cart-list');
    let totalDisplay = document.getElementById('total');
    let itemsCarrito = [];
    let total = 0.00;

    totalDisplay.textContent = `Total: Bs. ${total.toFixed(2)}`;

    productos.forEach(producto => {
        producto.addEventListener('click', function(e) {
            let nombre = e.currentTarget.dataset.name;
            let valor = parseFloat(e.currentTarget.dataset.value);
            let id = e.currentTarget.dataset.id;
            let imagen = e.currentTarget.dataset.image;
            let categoria = e.currentTarget.dataset.category;
            let stock = parseInt(e.currentTarget.dataset.stock);

            if (categoria === 'BOTELLA') {
                mostrarPopup('sodaComboPopup', stock);
                sessionStorage.setItem('tempBottle', JSON.stringify({ id, nombre, valor, imagen, categoria, stock }));
            } else if (categoria === 'COMBO') {
                let bottleInfo = JSON.parse(sessionStorage.getItem('tempBottle'));
                if (bottleInfo) {
                    let pairId = `${bottleInfo.id}-${id}`;
                    agregarAlCarrito(bottleInfo.id, bottleInfo.nombre, bottleInfo.valor, bottleInfo.imagen, bottleInfo.categoria, pairId, bottleInfo.stock);
                    agregarAlCarrito(id, nombre, valor, imagen, categoria, pairId);
                    sessionStorage.removeItem('tempBottle');
                }
            } else {
                agregarAlCarrito(id, nombre, valor, imagen, categoria, null, stock);
            }

            actualizarCarrito();
        });
    });

    function agregarAlCarrito(id, nombre, valor, imagen, categoria, pairId = null, stock = null) {
        let itemExistente = pairId 
            ? itemsCarrito.find(item => item.id === id && item.pairId === pairId)
            : itemsCarrito.find(item => item.id === id && item.categoria === categoria);

        if (itemExistente) {
            itemExistente.cantidad += 1;
        } else {
            itemsCarrito.push({ id, nombre, valor, cantidad: 1, imagen, categoria, pairId, stock });
        }

        total += valor;
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
                <span style="display: table-cell; width: 13%; text-align: right;"><strong>Bs. ${item.valor.toFixed(2)}</strong></span>
                <span style="display: table-cell; width: 7%; text-align: center;">x ${item.cantidad}</span>
                <span style="display: table-cell; width: 14%; text-align: right;">
                    ${item.categoria !== 'COMBO' ? `
                        <img src="<?php echo base_url(); ?>assets/img/mas.png" alt="Sumar" class="btn-mas" data-id="${item.id}" data-pair-id="${item.pairId || ''}" data-stock="${item.stock || 0}" style="cursor: pointer; width: 30px; height: auto; margin-right: -2px;">
                        <img src="<?php echo base_url(); ?>assets/img/menos.png" alt="Restar" class="btn-menos" data-id="${item.id}" data-pair-id="${item.pairId || ''}" style="cursor: pointer; width: 30px; height: auto; margin-right: -2px;">
                        <img src="<?php echo base_url(); ?>assets/img/borrar.png" alt="Borrar" class="btn-borrar" data-id="${item.id}" data-pair-id="${item.pairId || ''}" style="cursor: pointer; width: 23px; height: auto;">
                    ` : ''}
                </span>
            `;

            if (item.categoria !== 'COMBO') {
                li.querySelector('.btn-mas').addEventListener('click', function() {
                    aumentarCantidad(item.id, item.pairId, item.stock);
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
        
        if (item) {
            if (item.categoria === 'BOTELLA') {
                mostrarPopup('sodaComboPopup', stock); // Muestra el popup
            }
            
            item.cantidad += 1;
            total += item.valor;

            if (item.categoria === 'BOTELLA' && pairId) {
                let comboItem = itemsCarrito.find(i => i.pairId === pairId && i.categoria === 'COMBO');
                if (comboItem) {
                    comboItem.cantidad += 1;
                    total += comboItem.valor;
                }
            }

            actualizarCarrito();
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

                if (item.categoria === 'BOTELLA' && pairId) {
                    let comboItem = itemsCarrito.find(i => i.pairId === pairId && i.categoria === 'COMBO');
                    if (comboItem) {
                        comboItem.cantidad -= 1;
                        total -= comboItem.valor;
                    }
                }
            } else {
                eliminarDelCarrito(id, pairId);
            }

            actualizarCarrito();
        }
    }

    function eliminarDelCarrito(id, pairId) {
        let index = pairId 
            ? itemsCarrito.findIndex(i => i.id === id && i.pairId === pairId)
            : itemsCarrito.findIndex(i => i.id === id);

        if (index !== -1) {
            let item = itemsCarrito[index];
            total -= item.valor * item.cantidad;
            itemsCarrito.splice(index, 1);

            if (item.categoria === 'BOTELLA' && pairId) {
                let comboIndex = itemsCarrito.findIndex(i => i.pairId === pairId && i.categoria === 'COMBO');
                if (comboIndex !== -1) {
                    let comboItem = itemsCarrito[comboIndex];
                    total -= comboItem.valor * comboItem.cantidad;
                    itemsCarrito.splice(comboIndex, 1);
                }
            }

            actualizarCarrito();
        }
    }

    function mostrarPopup(popupId, stock) {
        if (stock <= 0) {
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
                producto.addEventListener('click', function() {
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

        popups.forEach(function (popup) {
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

function mostrarPopup(popupId, stock) {
    // Verificar si el stock es mayor que cero
    if (stock <= 0) {
        return;
    }

    // Cerrar cualquier ventana emergente abierta
    cerrarPopup();

    var popup = document.getElementById(popupId);
    var overlay = document.getElementById('popupOverlay');

    if (popup && overlay) {
        overlay.style.display = 'block';
        popup.style.display = 'block';

        // Agrega un evento de clic a todos los elementos del producto dentro de la ventana emergente
        var productos = popup.querySelectorAll('.product');
        productos.forEach(function(producto) {
            producto.addEventListener('click', function() {
                // Aquí deberías agregar la lógica real para agregar el producto al carrito

                // Cierra automáticamente la ventana después de agregar el producto al carrito
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

        // Oculta todos los popups
        popups.forEach(function (popup) {
            popup.style.display = 'none';
        });
    }
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