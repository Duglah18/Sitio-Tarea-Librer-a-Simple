<?php include("../template/header.php"); ?>
<?php 

    $Idpedido = (isset($_POST['idpedido']))?$_POST['idpedido']:"";
    $clicedu = (isset($_POST['clicedu']))?$_POST['clicedu']:"";
    $clinom = (isset($_POST['clinom']))?$_POST['clinom']:"";
    $libnomb = (isset($_POST['libnomb']))?$_POST['libnomb']:"";
    $libprec = (isset($_POST['libprec']))?$_POST['libprec']:"";
    $Actiontxt = (isset($_POST['accion']))?$_POST['accion']:"";
    $Imgtxt = "";

    include("../config/db.php");

    switch($Actiontxt){
        
        case "modificar":
            //echo "presionaste modificar";
            $sentenciaSQL = $conexion->prepare("UPDATE pedido SET ci_cliente=:cicli, nombre_cliente=:nomcli, nombre_libro=:nomlib, precio=:preclib WHERE id_pedido=:identif");
            $sentenciaSQL->bindParam(':cicli',$clicedu);
            $sentenciaSQL->bindParam(':nomcli',$clinom);
            $sentenciaSQL->bindParam(':nomlib',$libnomb);
            $sentenciaSQL->bindParam(':preclib',$libprec);
            $sentenciaSQL->bindParam(':identif',$Idpedido);
            $sentenciaSQL->execute();


            header("location:productos.php");
            break;
            
        case "cancelar":
            header("location:productos.php");
            break;

        case "Seleccionar":
            $sentenciaSQL = $conexion->prepare("SELECT * FROM pedido WHERE id_pedido=:identif");
            $sentenciaSQL->bindParam(':identif',$Idpedido);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $clicedu=$libro['ci_cliente'];
            $clinom=$libro['nombre_cliente'];
            $libnomb=$libro['nombre_libro'];
            $libprec=$libro['precio'];

            $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE nombre=:nombrelibro");
            $sentenciaSQL->bindParam(':nombrelibro',$libnomb);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
            
            $Imgtxt=$libro['imagen'];
            break;

        case "Borrar":
            $sentenciaSQL = $conexion->prepare("DELETE FROM pedido WHERE id_pedido=:identif");
            $sentenciaSQL->bindParam(':identif',$Idpedido);
            $sentenciaSQL->execute();

            header("location:orders.php");
            break;
    }

    $sentenciaSQL = $conexion->prepare("SELECT * FROM pedido INNER JOIN libros WHERE pedido.nombre_libro = libros.nombre");
    $sentenciaSQL->execute();
    $listalibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
    <div class="col-md-4 pb-4">

        <div class="card">
            <div class="card-header">
                Datos del Pedido
            </div>

            <div class="card-body">

                <form method="POST" enctype="multipart/form-data">
                    <div class = "form-group">
                        <label>ID</label>
                        <input type="text" required readonly class="form-control" value="<?= $Idpedido;?>" name="idpedido" id="idpedido" placeholder="ID">
                    </div>

                    <div class = "form-group">
                        <label>Cedula Cliente</label>
                        <input type="text" required class="form-control" value="<?= $clicedu;?>" name="clicedu" id="clicedu" placeholder="Cedula cliente">
                    </div>

                    <div class = "form-group">
                        <label>Nombre Cliente</label>
                        <input type="text" required class="form-control" value="<?= $clinom;?>" name="clinom" id="clinom" placeholder="Ingresar una descripcion del libro"/>
                    </div>

                    <div class = "form-group">
                        <label>Nombre Libro</label>
                        <input type="text" required class="form-control" value="<?= $libnomb;?>" name="libnomb" id="libnomb" placeholder="Ingresar precio del libro">
                    </div>

                    <div class = "form-group">
                        <label>Precio Libro</label>
                        <input type="text" required class="form-control" value="<?= $libprec;?>" name="libprec" id="libprec" placeholder="Ingresar precio del libro">
                    </div>

                    <div class = "form-group">
                        <label>Imagen de Libro</label>
                        <br>
                        <?php if ($Imgtxt!="") { ?>
                            
                        <img class="img-thumbnail rounded" src="../../img/<?= $Imgtxt; ?>" width="150" alt="">
                        
                        <?php } else {
                            echo "<label>No has seleccionado nada.</label>";
                        } ?>
                        
                    </div>

                    <div class="btn-group" role="group" aria-label="">
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
                <tr class="text-center">
                    <th>ID</th>
                    <th>CI Cliente</th>
                    <th>Nombre Cliente</th>
                    <th>Nombre Libro</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($listalibros as $libro) {?>
                <tr>
                    <td><?= $libro['id_pedido']; ?></td>
                    <td><?= $libro['ci_cliente']; ?></td>
                    <td><?= $libro['nombre_cliente']; ?></td>
                    <td><?= $libro['nombre_libro']; ?></td>
                    <td><?= $libro['precio']; ?></td>
                    <td>
                    
                        <img class="img-thumbnail rounded" src="../../img/<?= $libro['imagen']; ?>" width="50" alt="">
                    
                    <td>
                    
                    <form method="POST">
                        <input type="hidden" name="idpedido" id="idpedido" value="<?= $libro['id_pedido']; ?>"/>

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