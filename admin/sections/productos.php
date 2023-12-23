<?php include("../template/header.php"); ?>
<?php 

    $IDtxt = (isset($_POST['textid']))?$_POST['textid']:"";
    $Nametxt = (isset($_POST['textname']))?$_POST['textname']:"";
    $Imgtxt = (isset($_FILES['textimg']['name']))?$_FILES['textimg']['name']:"";
    $Textxt = (isset($_POST['description']))?$_POST['description']:"";
    $Pricetxt = (isset($_POST['price']))?$_POST['price']:"";
    $Actiontxt = (isset($_POST['accion']))?$_POST['accion']:"";
    

    include_once("../config/db.php");

    switch($Actiontxt){

        case "agregar":

            $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombre,imagen,descripcion,precio) VALUES (:nombre,:imagen,:descrip,:precio)");
            $sentenciaSQL->bindParam(':nombre',$Nametxt);
            $sentenciaSQL->bindParam(':descrip',$Textxt);
            $sentenciaSQL->bindParam(':precio',$Pricetxt);

            $fecha= new DateTime();
            $nombreArchivo=($Imgtxt!="")?$fecha->getTimestamp()."_".$_FILES["textimg"]["name"]:"imagen.jpg";

            $tmpimg= $_FILES["textimg"]["tmp_name"];

            if ($tmpimg!="") {
                move_uploaded_file($tmpimg,"../../img/".$nombreArchivo);
            }

            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->execute();

            header("location:productos.php");
            break;
        
        case "modificar":
            //echo "presionaste modificar";
            $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombre=:nombre, descripcion=:descrip, precio=:precio WHERE id=:id");
            $sentenciaSQL->bindParam(':nombre',$Nametxt);
            $sentenciaSQL->bindParam(':descrip',$Textxt);
            $sentenciaSQL->bindParam(':precio',$Pricetxt);
            $sentenciaSQL->bindParam(':id',$IDtxt);
            $sentenciaSQL->execute();

            if ($Imgtxt!="") {

                $fecha= new DateTime();
                $nombreArchivo=($Imgtxt!="")?$fecha->getTimestamp()."_".$_FILES["textimg"]["name"]:"imagen.jpg";
                $tmpimg= $_FILES["textimg"]["tmp_name"];

                move_uploaded_file($tmpimg,"../../img/".$nombreArchivo);

                $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                $sentenciaSQL->bindParam(':id',$IDtxt);
                $sentenciaSQL->execute();
                $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                if (isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg") ) {
                    if (file_exists("../../img/".$libro["imagen"])) {
                        unlink("../../img/".$libro["imagen"]);
                    }
                }

                $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
                $sentenciaSQL->bindParam(':id',$IDtxt);
                $sentenciaSQL->execute();        
            }
            header("location:productos.php");
            break;
            
        case "cancelar":
            header("location:productos.php");
            break;

        case "Seleccionar":
            $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$IDtxt);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $Nametxt=$libro['nombre'];
            $Textxt=$libro['descripcion'];
            $Pricetxt=$libro['precio'];
            $Imgtxt=$libro['imagen'];
            break;

        case "Borrar":
            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$IDtxt);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg") ) {
                if (file_exists("../../img/".$libro["imagen"])) {
                    unlink("../../img/".$libro["imagen"]);
                }
            }

            $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$IDtxt);
            $sentenciaSQL->execute();
            header("location:productos.php");
            break;
    }

    $sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listalibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
    <div class="col-md-4">

        <div class="card">
            <div class="card-header">
                Datos del Libro
            </div>

            <div class="card-body">

                <form method="POST" enctype="multipart/form-data">
                    <div class = "form-group">
                        <label>ID</label>
                        <input type="text" required readonly class="form-control" value="<?= $IDtxt;?>" name="textid" id="textid" placeholder="ID">
                    </div>

                    <div class = "form-group">
                        <label>Nombre</label>
                        <input type="text" required class="form-control" value="<?= $Nametxt;?>" name="textname" id="textname" placeholder="Ingresar nombre de Libro">
                    </div>

                    <div class = "form-group">
                        <label>Descripcion</label>
                        <textarea type="text" required class="form-control" value="<?= $Textxt;?>" name="description" id="description" placeholder="Ingresar una descripcion del libro"><?= $Textxt;?></textarea>
                    </div>

                    <div class = "form-group">
                        <label>Precio</label>
                        <input type="text" required class="form-control" value="<?= $Pricetxt;?>" name="price" id="price" placeholder="Ingresar precio del libro">
                    </div>

                    <div class = "form-group">
                        <label>Imagen</label>
                        <br>
                        <?php if ($Imgtxt!="") { ?>
                            
                        <img class="img-thumbnail rounded" src="../../img/<?= $Imgtxt; ?>" width="50" alt="">
                        
                        <?php } ?>
                        
                        <input type="file" <?= $Actiontxt=="Seleccionar"?"":"required" ?>  class="form-control" name="textimg" id="textimg" placeholder="Ingresar nombre de Libro">
                    </div>

                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" <?= $Actiontxt=="Seleccionar"?"disabled":"" ?> value="agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" <?= $Actiontxt!="Seleccionar"?"disabled":"" ?> value="modificar" class="btn btn-warning">Modificar</button>
                        <button type="submit" name="accion" <?= $Actiontxt!="Seleccionar"?"disabled":"" ?> value="cancelar" class="btn btn-info">Cancelar</button>
                    </div>
                </form>

            </div>

        </div>

    </div>
    <div class="col-md-8">
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($listalibros as $libro) {?>
                <tr>
                    <td><?= $libro['id']; ?></td>
                    <td><?= $libro['nombre']; ?></td>
                    <td><?= $libro['descripcion']; ?></td>
                    <td><?= $libro['precio']; ?></td>
                    <td>

                        <img class="img-thumbnail rounded" src="../../img/<?= $libro['imagen']; ?>" width="50" alt="">
                    </td>
                    <td>
                    
                        <form method="POST">
                            <input type="hidden" name="textid" id="textid" value="<?= $libro['id']; ?>"/>

                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                            
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                        </form>
                    
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

<?php include("../template/footer.php"); ?>