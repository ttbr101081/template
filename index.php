<?php
include 'funciones.php';
session_start();
if (!isset($_SESSION['cedu'])) {
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

  if (isset($_POST['nombre'])) {
    $consultaSQL = "SELECT * FROM documento WHERE nombre LIKE '%" . $_POST['nombre'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM documento";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $documento = $sentencia->fetchAll();
} catch (PDOException $error) {
  $error = $error->getMessage();
}

$titulo = isset($_POST['nombre']) ? 'Lista de documentos (' . $_POST['nombre'] . ')' : 'Lista de documentos';
?>

<?php include "templates/headerP.php"; ?>

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
      <!--<a href="crear.php"  class="btn btn-primary mt-4">Crear $documento</a>-->
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="nombre" name="nombre" placeholder="Buscar por nombre" class="form-control">
        </div>
        <!--<input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">-->
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
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Fecha del documentos</th>
            <th>Fecha del registro</th>
            <th>Estado</th>
            <th>Usuario responsable</th>
            <th>Usuario revisor</th>
            <th>Fecha de revision</th>
            <th>Accion</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($documento && $sentencia->rowCount() > 0) {
            foreach ($documento as $fila) {
          ?>
              <tr>
                <td><?php echo escapar($fila["tipo"]); ?></td>
                <td><?php echo escapar($fila["nombre"]); ?></td>
                <td><?php echo escapar($fila["descripcion"]); ?></td>
                <td><?php echo escapar($fila["fecha_doc"]); ?></td>
                <td><?php echo escapar($fila["fecha_re"]); ?></td>
                <td><?php
                    if (escapar($fila["estado"]) == 1) {
                      echo 'Elaborado';
                    };
                    if (escapar($fila["estado"]) == 2) {
                      echo 'Aprobado';
                    };
                    if (escapar($fila["estado"]) == 3) {
                      echo 'Rechazado';
                    };
                    if (escapar($fila["estado"]) == 4) {
                      echo 'De baja';
                    };
                    ?></td>
                <td><?php echo escapar($fila["user_res"]); ?></td>
                <td><?php echo escapar($fila["user_rev"]); ?></td>
                <td><?php echo escapar($fila["fecha_rev"]); ?></td>
                <td><?php echo escapar($fila["archivo"]); ?></td>
                <td>
                  <a href="<?= 'editar.php?id=' . escapar($fila["codigo"]) ?>">✏️Editar</a>
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