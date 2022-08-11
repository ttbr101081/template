<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}

$error = false;
$config = include 'config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    if (isset($_POST['fechaI']) && isset($_POST['fechaF'])) {
        $consultaSQL = "SELECT * FROM factura WHERE FEC_PAG BETWEEN '" . $_POST['fechaI'] . "' AND '" . $_POST['fechaF'] . "'";
    } else {
        $consultaSQL = "SELECT * FROM factura";
    }

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    $factura = $sentencia->fetchAll();
} catch (PDOException $error) {
    $error = $error->getMessage();
}

$titulo = isset($_POST['fecha']) && isset($_POST['fechaF']) ? 'Lista de facturas desde (' . $_POST['fechaI'] . ' hasta ' . $_POST['fechaF'] . ')' : 'Lista de facturas';
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
            <!--<a href="crear.php"  class="btn btn-primary mt-4">Crear factura</a>-->
            <hr>
            <form method="post" class="form-inline">
                <div class="form-group mr-3">
                    <input type="date" id="fechaI" name="fechaI" placeholder="Buscar por fecha" class="form-control">
                    <input type="date" id="fechaF" name="fechaF" placeholder="Buscar por fecha" class="form-control">
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
                        <th>ID</th>
                        <th>Valor</th>
                        <th>Metodo</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Servicio</th>
                        <th>Cliente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($factura && $sentencia->rowCount() > 0) {
                        foreach ($factura as $fila) {
                    ?>
                            <tr>
                                <td><?php echo escapar($fila["ID_PAG"]); ?></td>
                                <td><?php echo escapar($fila["VAL_PAG"]); ?></td>
                                <td><?php echo escapar($fila["MET_PAG"]); ?></td>
                                <td><?php echo escapar($fila["EST_PAG"]); ?></td>
                                <td><?php echo escapar($fila["FEC_PAG"]); ?></td>
                                <td><?php echo escapar($fila["ID_SER"]); ?></td>
                                <td><?php echo escapar($fila["CED_CLI"]); ?></td>
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