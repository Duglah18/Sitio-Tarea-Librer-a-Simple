<?php include("template/header.php"); ?>

<?php 
    include("admin/config/db.php");
    if (isset($_GET['id'])) {
        $id_book = $_GET['id'];
        if (!empty($id_book)) {
            $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=$id_book");
            $sentenciaSQL->execute();
            $listalibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
        }
    }
 foreach($listalibros as $libro) { ?>
<?php } ?>

    <div class="jumbotron row pb-3">
        <div class="col-md-3">
            <img class="img-thumbnail rounded mx-auto d-block" src="./img/<?= $libro['imagen']; ?>" alt="">
        </div>
        <div class="col-md-5 pt-3">
            <h2 class="card-title"><?= $libro['nombre'] ?></h2>
            <h3 class="card-title">Precio del libro: $<?= $libro['precio'] ?></h3>
            <p>
                <?= $libro['descripcion'];?>
            </p>
            <a name="" id="" class="btn btn-primary" href="order.php?id=<?=$libro['id'];?>" role="button">Ver más</a>
        </div>
    </div>

<?php include("template/footer.php"); ?>