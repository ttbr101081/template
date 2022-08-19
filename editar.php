<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include 'config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El documento no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $documento = [
      "id"          => $_GET['id'],
      "estado"      => $_POST['estado']
    ];

    $consultaSQL = "UPDATE documento SET
        estado = :estado
        WHERE codigo = :id";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($documento);
  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM documento WHERE codigo =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $documento = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$documento) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el documento';
  }
} catch (PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/headerP.php"; ?>

<?php
if ($resultado['error']) {
?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El documento ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
<?php
}
?>

<?php
if (isset($documento) && $documento) {
?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el documento <?= escapar($documento['nombre'])   ?></h2>
        <hr>
        <form method="post">
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
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
}
?>

<?php require "templates/footer.php"; ?>