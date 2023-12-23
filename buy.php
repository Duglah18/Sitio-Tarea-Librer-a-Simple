<?php include("template/header.php"); ?>
<?php
    if (isset($_GET['id'])) {
        if ($_GET['id']!="") {
            $libro_pedido =  $_GET['id'];
        } else {
            $libro_pedido = "ERROR";
            header("location:index.php");
        }
    } else {
        $libro_pedido = "ERROR";
        header("location:index.php");
    }
?>
<?php if($libro_pedido != "ERROR"){ ?>
    <div class="jumbotron jumbotron-fluid text-center pb-4">
        <div class="container">
            <h1 class="display-3">Gracias por tu pedido de <strong><?= $libro_pedido;?></strong></h1>
            <p class="lead">Por favor contactate con nosotros al siguiente numero para concretar el pago
                y envio de tu libro: 0424-5936421#
            </p>
         <hr class="my-2">
            <p>
                Regresa al inicio
            </p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="index.php" role="button">Inicio</a>
            </p>
            <img src="./img/gracias.jpg" class="img-thumbnail rounded mx-auto d-block" alt="">   
        </div>
    </div>
<?php } else { ?>

    <h1>Error ha ocurrido un error por favor vuele a intentarlo.</h1>

<?php header("location:index.php"); } ?>

<?php include("template/footer.php"); ?>