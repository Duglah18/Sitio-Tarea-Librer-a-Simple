<?php
  session_start();
    if (!isset($_SESSION['user'])) {
      header("location:../index.php");
    }else{
      if ($_SESSION['user']=="ok") {
        $username = $_SESSION['usuario'];
      }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Administrador de Biblioteca</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="icon" href="favicon(2).ico"/>
  </head>
  <body>

    <?php $url="http://".$_SERVER['HTTP_HOST']."/SitioWeb"?>

  <nav class="navbar navbar-expand navbar-light bg-light m-3">
      <div class="nav navbar-nav">
          <a class="nav-item nav-link" href="#"><strong>Administrador de biblioteca de Wan Shi Tong</strong><span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="<?= $url;?>/admin/inicial.php">Inicio</a>
          <a class="nav-item nav-link" href="<?= $url;?>/admin/sections/productos.php">Libros</a>
          <a class="nav-item nav-link" href="<?= $url;?>/admin/sections/orders.php">Pedidos</a>
          <a class="nav-item nav-link" href="<?= $url;?>/admin/sections/close.php">Cerrar</a>
          <a class="nav-item nav-link" href="<?= $url;?>">Ver sitio Web</a>
      </div>
  </nav>

  <div class="container">
    <br>
    <div class="row">