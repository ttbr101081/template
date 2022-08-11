<?php
include 'funciones.php';
session_start();
if(!isset($_SESSION['cedu'])){
  header('location: https://localhost/template/login.php');
}

/*csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}*/

$error = false;
$config = include 'config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['apellido'])) {
    $consultaSQL = "SELECT * FROM usuario WHERE APE_CLI LIKE '%" . $_POST['apellido'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM usuario";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $usuario = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['apellido']) ? 'Lista de usuarios (' . $_POST['apellido'] . ')' : 'Lista de usuarios';
?>

<?php include "templates/header.php"; ?>

<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <!--<a href="crear.php"  class="btn btn-primary mt-4">Crear usuario</a>-->
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="apellido" name="apellido" placeholder="Buscar por apellido" class="form-control">
        </div>
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
        <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
      </form>
    </div>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Socio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($usuario && $sentencia->rowCount() > 0) {
            foreach ($usuario as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["CED_CLI"]); ?></td>
                <td><?php echo escapar($fila["NOM_CLI"]); ?></td>
                <td><?php echo escapar($fila["APE_CLI"]); ?></td>
                <td><?php echo escapar($fila["CORR_CLI"]); ?></td>
                <td><?php echo escapar($fila["SOCIO"]); ?></td>
                <td>
                  <a href="<?= 'borrar.php?id=' . escapar($fila["CED_CLI"]) ?>">🗑️Borrar</a>
                  <a href="<?= 'editar.php?id=' . escapar($fila["CED_CLI"]) ?>">✏️Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>

<?php include "templates/footer.php"; ?>