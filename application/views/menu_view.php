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
                             data-category="<?= htmlspecialchars($product['categoria']) ?>" 
                             onclick="mostrarPopup('sodaComboPopup', <?= $product['stock'] ?>)">
                            <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                            <h3><?= htmlspecialchars($product['nombre']) ?></h3>
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
                        <?php if ($product['categoria'] === 'SODA') : ?>
                            <div class="product" data-index="<?= $key; ?>" 
                                 data-name="<?= $product['nombre']; ?>" 
                                 data-value="<?= $product['precio']; ?>" 
                                 data-id="<?= $product['id_producto']; ?>" 
                                 data-stock="<?= $product['stock']; ?>"
                                 data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" >
                                <?php
                                $nombreArchivo = basename($product['imagen']);
                                $rutaImagen = "assets/imagenes_bebidas/" . $nombreArchivo;
                                ?>
                                <img src="<?= base_url() . '/' . $rutaImagen; ?>" alt="<?= $product['nombre']; ?>">
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
                        <div class="product" data-index="<?= $product['id_producto'] ?>" data-name="<?= htmlspecialchars($product['nombre']) ?>" data-value="<?= $product['precio'] ?>" data-id="<?= $product['id_producto'] ?>" data-stock="<?= $product['stock'] ?>" data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>">
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
                        <div class="product" data-index="<?= $product['id_producto'] ?>" data-name="<?= htmlspecialchars($product['nombre']) ?>" data-value="<?= $product['precio'] ?>" data-id="<?= $product['id_producto'] ?>" data-stock="<?= $product['stock'] ?>" data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>">
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
        <div class="product" data-index="<?= $product['id_producto'] ?>" data-name="<?= htmlspecialchars($product['nombre']) ?>" data-value="<?= $product['precio'] ?>" data-id="<?= $product['id_producto'] ?>" data-stock="<?= $product['stock'] ?>" data-image="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>">
            <?php
            $foto = $product['imagen'];
            ?>
            <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $foto ?>" />
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
                <form method="POST" action="./bill.php" id="checkout-form">
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
                        <input class="submit-confirmar" type="submit" value="CONFIRMAR">
                    </div>
                    <br>
                    <?php if (isset($nombres)) : ?>
                        <div class="bold-text-info">
                            <span>NOMBRE DE USUARIO</span>
                            <input type="text" value="<?= htmlspecialchars($nombres) ?>" readonly>
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
        let inputCarrito = document.getElementById('cart');

        let total = 0;
        let itemsCarrito = [];

        // Function to initialize product click events
        productos.forEach(producto => {
            producto.addEventListener('click', function(e) {
                let nombre = e.currentTarget.dataset.name;
                let valor = parseFloat(e.currentTarget.dataset.value);
                let id = e.currentTarget.dataset.index;
                let imagen = e.currentTarget.dataset.image;
                let categoria = e.currentTarget.dataset.category; // Añadir esta línea
                let isFromPopup = e.currentTarget.closest('.popup') !== null; // Verificar si proviene de popup

                // Buscar si el producto ya está en el carrito
                let itemExistente = itemsCarrito.find(item => item.id === id);

                if (itemExistente) {
                    itemExistente.cantidad += 1;
                } else {
                    itemsCarrito.push({ id, nombre, valor, cantidad: 1, imagen, categoria, isFromPopup });
                }

                total += valor;
                actualizarCarrito();
            });
        });

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
        `;

        // Si el producto proviene del popup, mostrar solo el botón de menos
        if (item.isFromPopup) {
            li.innerHTML += `
                <span style="display: table-cell; width: 14%; text-align: right;">
                    <img src="<?php echo base_url(); ?>assets/img/menos.png" alt="Restar" class="btn-menos" data-id="${item.id}" style="cursor: pointer; width: 30px; height: auto; margin-right: -2px;">
                </span>
            `;
        } else {
            // Si el producto no proviene del popup, mostrar botones de más, menos y borrar
            li.innerHTML += `
                <span style="display: table-cell; width: 14%; text-align: right;">
                    <img src="<?php echo base_url(); ?>assets/img/mas.png" alt="Sumar" class="btn-mas" data-id="${item.id}" style="cursor: pointer; width: 30px; height: auto; margin-right: -2px;">
                    <img src="<?php echo base_url(); ?>assets/img/menos.png" alt="Restar" class="btn-menos" data-id="${item.id}" style="cursor: pointer; width: 30px; height: auto; margin-right: -2px;">
                    <img src="<?php echo base_url(); ?>assets/img/borrar.png" alt="Borrar" class="btn-borrar" data-id="${item.id}" style="cursor: pointer; width: 23px; height: auto;">
                </span>
            `;
        }

        listaCarrito.appendChild(li);

        // Agregar los event listeners para los botones de menos
        li.querySelector('.btn-menos').addEventListener('click', function() {
            if (item.cantidad > 1) {
                item.cantidad -= 1;
                total -= item.valor;
            } else {
                total -= item.valor;
                itemsCarrito = itemsCarrito.filter(i => i.id !== item.id);
            }
            actualizarCarrito();
        });

        // Agregar los event listeners para los botones de más y borrar solo si no es del popup
// Agregar los event listeners para los botones de más y borrar solo si no es del popup
if (!item.isFromPopup) {
    li.querySelector('.btn-mas').addEventListener('click', function() {
        console.log('Elemento actual:', item);
        console.log('Categoría del producto:', item.categoria);
        
        // Verificar si el producto es de la categoría 'BOTELLA'
        if (item.categoria === 'BOTELLA') {
            item.cantidad += 1;
            total += item.valor;
            actualizarCarrito();

            // Habilitar el popup solo para productos de la categoría 'BOTELLA'
            mostrarPopup('sodaComboPopup', item.stock);
        } else {
            console.log('El producto no es de la categoría BOTELLA, no se mostrará el popup.');
        }
    });



            li.querySelector('.btn-borrar').addEventListener('click', function() {
                total -= item.valor * item.cantidad;
                itemsCarrito = itemsCarrito.filter(i => i.id !== item.id);
                actualizarCarrito();
            });
        }
    });

    totalDisplay.textContent = `Total: Bs. ${total.toFixed(2)}`;
    inputCarrito.value = JSON.stringify(itemsCarrito);
}


        // Expose the function mostrarPopup to be accessible globally
        window.mostrarPopup = function(popupId, stock) {
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
                        let nombre = producto.dataset.name;
                        let valor = parseFloat(producto.dataset.value);
                        let id = producto.dataset.index;
                        let imagen = producto.dataset.image;

                        let itemExistente = itemsCarrito.find(item => item.id === id);

                        if (itemExistente) {
                            itemExistente.cantidad += 0; // Cambié de 0 a 1
                        } else {
                            itemsCarrito.push({ id, nombre, valor, cantidad: 1, imagen, isFromPopup: true });
                        }

                        actualizarCarrito();
                        cerrarPopup();
                    });
                });
            }
        }

        function cerrarPopup() {
            var overlay = document.getElementById('popupOverlay');
            var popups = document.querySelectorAll('.popup');

            overlay.style.display = 'none';
            popups.forEach(function(popup) {
                popup.style.display = 'none';
            });
        }
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