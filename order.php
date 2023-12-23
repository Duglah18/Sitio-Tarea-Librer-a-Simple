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
 foreach($listalibros as $libro) {} 

    $cliCedula =(isset($_POST['textCI']))?$_POST['textCI']:"";
    $cliNombre =(isset($_POST['textname']))?$_POST['textname']:"";
    $libNombre =(isset($_POST['textNameBook']))?$_POST['textNameBook']:"";
    $libprecio =(isset($_POST['textbookprice']))?$_POST['textbookprice']:"";
    $Actiontxt =(isset($_POST['accion']))?$_POST['accion']:"";
    include("admin/config/db.php");
    
    switch ($Actiontxt) {

        case "Pedir":
            $sentenciaSQL = $conexion->prepare("INSERT INTO pedido (ci_cliente,nombre_cliente,nombre_libro,precio) VALUES (:cedula,:nomcli,:nomlib,:preciolib)");
            $sentenciaSQL->bindParam(':cedula',$cliCedula);
            $sentenciaSQL->bindParam(':nomcli',$cliNombre);
            $sentenciaSQL->bindParam(':nomlib',$libNombre);
            $sentenciaSQL->bindParam(':preciolib',$libprecio);

            $sentenciaSQL->execute();

            header("location:buy.php?id=$libNombre");
            break;
    }

 ?>
<div class="col-md-3"></div>

<div class="col-md-6 pb-3 text-center">

    <div class="card">
        <div class="card-header">
            Datos del Libro
        </div>

        <div class="card-body">

            <form method="POST" class="row">
                    <div class = "form-group">
                        <label>Cedula Cliente</label>
                        <input type="text" required class="form-control" name="textCI" id="textCI" placeholder="Ingrese su cedula por favor">
                    </div>

                    <div class = "form-group">
                        <label>Nombre Cliente</label>
                        <input type="text" required class="form-control" name="textname" id="textname" placeholder="Ingrese su nombre por favor">
                    </div>

                    <div class = "form-group">
                        <label>Nombre del libro pidiendo</label>
                        <input type="text" required readonly class="form-control" value="<?= $libro['nombre'];?>" name="textNameBook" id="textNameBook" placeholder="Ingresar precio del libro">
                    </div>

                    <div class = "form-group">
                        <label>Precio del libro</label>
                        <input type="text" required readonly class="form-control" value="<?= $libro['precio'];?>" name="textbookprice" id="textbookprice" placeholder="Ingresar precio del libro">
                    </div>

                    <div class = "form-group pb-3">
                        <label>Foto de Libro</label>
                        <br>
                        <?php if ($libro['imagen']!="") { ?>
                            
                            <img class="img-thumbnail rounded" src="img/<?= $libro['imagen']; ?>" width="150" alt="">
                        
                        <?php } else { ?>

                            <img class="img-thumbnail rounded" src="img/unknown.png" width="150" alt="">
                        
                        <?php } ?>
                        
                    </div>

                <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" value="Pedir" class="btn btn-success">Pedir</button>
                <a href="index.php" class="btn btn-info">Cancelar</a>
                </div>
            </form>

        </div>

    </div>

</div>

<div class="col-mb-3"></div>


<?php include("template/footer.php"); ?>