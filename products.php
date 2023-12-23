<?php include("template/header.php"); ?>
<?php 
    include("admin/config/db.php");

    $sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listalibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php foreach($listalibros as $libro) { ?>
    
<div class="col-md-3 pb-3">
    <div class="card">
        <img class="card-img-top" src="./img/<?= $libro['imagen']; ?>" alt="">
        <div class="card-body">
            <h4 class="card-title"><?= $libro['nombre'] ?></h4>
            <h4 class="card-title">$<?= $libro['precio'] ?></h4>
            <a class="btn btn-primary" href="book.php?id=<?=$libro['id'];?>" role="button">Ver más</a>
        </div>
    </div>
</div>
<?php } if (empty($listalibros)){?>
    <h1 class="m-0 vh-100 row justify-content-center align-items-center">No hay libros disponibles por el momento disculpe.</h1>
<?php } ?>


<?php include("template/footer.php"); ?>