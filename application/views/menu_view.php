<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <title>MENU</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
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
                        <div class="product" data-index="<?= $product['id_producto'] ?>" data-name="<?= htmlspecialchars($product['nombre']) ?>" data-value="<?= $product['precio'] ?>" data-id="<?= $product['id_producto'] ?>" data-stock="<?= $product['stock'] ?>">
                            <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                            <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                            <p>Precio: $<?= $product['precio'] ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </section>
        </div>

        <div class="popup-overlay" id="popupOverlay">

        </div>

        <div class="mostrar" id="D2">
            <section class="products">
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['categoria'] === 'COCTEL') : ?>
                        <div class="product" data-index="<?= $product['id_producto'] ?>" data-name="<?= htmlspecialchars($product['nombre']) ?>" data-value="<?= $product['precio'] ?>" data-id="<?= $product['id_producto'] ?>" data-stock="<?= $product['stock'] ?>">
                            <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                            <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                            <p>Precio: $<?= $product['precio'] ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </section>
        </div>
        <div class="mostrar" id="D3">
            <section class="products">
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['categoria'] === 'CERVEZA') : ?>
                        <div class="product" data-index="<?= $product['id_producto'] ?>" data-name="<?= htmlspecialchars($product['nombre']) ?>" data-value="<?= $product['precio'] ?>" data-id="<?= $product['id_producto'] ?>" data-stock="<?= $product['stock'] ?>">
                            <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                            <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                            <p>Precio: $<?= $product['precio'] ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </section>
        </div>
        <div class="mostrar" id="D4">
            <section class="products">
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['categoria'] === 'PIQUEO') : ?>
                        <div class="product" data-index="<?= $product['id_producto'] ?>" data-name="<?= htmlspecialchars($product['nombre']) ?>" data-value="<?= $product['precio'] ?>" data-id="<?= $product['id_producto'] ?>" data-stock="<?= $product['stock'] ?>">
                            <img src="<?= base_url(); ?>/assets/imagenes_bebidas/<?= $product['imagen'] ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                            <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                            <p>Precio: $<?= $product['precio'] ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </section>
        </div>
        <div class="mostrar" id="D5">
            <section class="products">
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['categoria'] === 'soda') : ?>
                        <div class="product" data-index="<?= $product['id_producto'] ?>" data-name="<?= htmlspecialchars($product['nombre']) ?>" data-value="<?= $product['precio'] ?>" data-id="<?= $product['id_producto'] ?>" data-stock="<?= $product['stock'] ?>">
                        <?php
                        $foto=$row->imagen;
                        ?>
                        <img src="<?php echo base_url()?>/assets/imagenes_bebidas/<?php echo $foto ?>"/>
                            <h3><?= htmlspecialchars($product['nombre']) ?></h3>
                            <p>Precio: $<?= $product['precio'] ?></p>
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

                    <!-- <?php if (isset($id_usuario)) : ?>
                        <div class="bold-text-info">
                            <span>N°</span>
                            <input type="text" value="<?= htmlspecialchars($id_usuario) ?>" readonly>
                        </div>
                    <?php endif; ?> -->
                    <br>
                    <br>
                </form>
                <div>
                    <a class="close" href="<?php echo site_url('cerrar'); ?>">Cerrar Sesión</a>
                </div>
            </div>
        </section>


    </div>
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