<?php
include 'funciones.php';

include 'templates/headerP.php';

require "data/conex.php";

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}

if (isset($_POST['submit'])) {
    $resultado = [
        'error' => false,
        'mensaje' => 'El rol de pago ha sido agregado con éxito'
    ];

    $config = include 'config.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        $pago = [
            "valor"     => $_POST['valor'],
            "metodo"   => $_POST['metodo'],
            "estado"   => 1,
            "fecha"    => date('Y-m-d'),
            "servicio" => $_POST['servicio'],
            "cedula"    => $_POST['cedula'],
            
        ];

        $consultaSQL = "INSERT INTO factura (VAL_PAG, MET_PAG, EST_PAG, FEC_PAG, ID_SER, CED_CLI)";
        $consultaSQL .= "values (:" . implode(", :", array_keys($pago)) . ")";

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute($pago);

        //$servicio = $sentencia->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}

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
            <h2 class="mt-4">Crea un rol de pago</h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="valor">Valor a Pagar</label>
                    <input type="text" name="valor" id="valor" class="form-control">
                </div>
                <div class="form-group">
                    <label for="metodo">Metodo de pago</label>
                    <input type="text" name="metodo" id="metodo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="cedula">Cedula</label>
                    <input type="text" name="cedula" id="cedula" class="form-control">
                </div>
                <div class="form-group">
                    <label for="cedula">Servicio</label>
                    <select name='servicio' id='servicio'>
                        <option value="0">Seleccione el servicio</option>
                        <?=
                        $sql = "SELECT * FROM servicio";
                        $r = mysqli_query($l, $sql) or die("Error");
                        while ($servicio = mysqli_fetch_array($r)) {
                            echo "<option name='servicio' value=' $servicio[ID_SER]'> $servicio[NOM_SER]</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                    <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
                    <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>