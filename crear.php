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

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El documento ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito'
  ];

  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $documento = [
      "tipo"   => $_POST['tipo'],
      "nombre"   => $_POST['nombre'],
      "descripcion" => $_POST['descripcion'],
      "fecha_doc"    => $_POST['fecha_doc'],
      "fecha_re"  => date('Y-m-d'),
      "estado"     => $_POST['estado'],
      "user_res"   => $_SESSION['cedu'],
      "user_rev"   => '1722786959',
      "fecha_rev"  => $_POST['fecha_rev']
    ];


      $consultaSQL = "INSERT INTO documento (tipo, nombre, descripcion, fecha_doc, fecha_re, estado, user_res, user_rev, fecha_rev)";
      $consultaSQL .= "values (:" . implode(", :", array_keys($documento)) . ")";

      $sentencia = $conexion->prepare($consultaSQL);
      $sentencia->execute($documento);
  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include 'templates/headerP.php'; ?>

<?php
if (isset($resultado)) {
?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
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
      <h2 class="mt-4">Crea un documento</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="tipo">Tipo</label>
          <input type="text" name="tipo" id="tipo" class="form-control">
        </div>
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control">
        </div>
        <div class="form-group">
          <label for="descripcion">Descripcion</label>
          <input type="text" name="descripcion" id="descripcion" class="form-control">
        </div>
        <div class="form-group">
          <label for="fecha_doc">Fecha del documento</label>
          <input type="date" name="fecha_doc" id="fecha_doc" class="form-control">
        </div>
        <div class="form-group">
          <label for="estado">Estado</label>
          <select name="estado" id="estado">
            <option value="0">Seleccione el estado</option>
            <option value="1">Elaborado</option>
            <option value="2">Aprobado</option>
            <option value="3">Rechazado</option>
            <option value="4">De baja</option>
          </select>
        </div>
        <div class="form-group">
          <label for="fecha_rev">Fecha de revision</label>
          <input type="date" name="fecha_rev" id="fecha_rev" class="form-control">
        </div>
        <div class="form-group">
          <!--<input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">-->
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>