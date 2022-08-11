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
  $resultado['mensaje'] = 'El usuarios no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $usuario = [
      "id"        => $_GET['id'],
      "nombre"    => $_POST['nombre'],
      "apellido"  => $_POST['apellido'],
      "email"     => $_POST['email'],
      "socio"      => $_POST['socio']
    ];

    $consultaSQL = "UPDATE usuario SET
        NOM_CLI = :nombre,
        APE_CLI = :apellido,
        CORR_CLI = :email,
        SOCIO = :socio
        WHERE CED_CLI = :id";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($usuario);
  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM usuario WHERE CED_CLI =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$usuario) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el usuario';
  }
} catch (PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

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
          El usuario ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
<?php
}
?>

<?php
if (isset($usuario) && $usuario) {
?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el usuario <?= escapar($usuario['NOM_CLI']) . ' ' . escapar($usuario['APE_CLI'])  ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= escapar($usuario['NOM_CLI']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="<?= escapar($usuario['APE_CLI']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= escapar($usuario['CORR_CLI']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="socio">Socio</label>
            <input type="text" name="socio" id="socio" value="<?= escapar($usuario['SOCIO']) ?>" class="form-control">
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