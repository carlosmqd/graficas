    <?php
  $con = mysqli_connect("127.0.0.1","root","hse23121608", "lecciones_aprendidas");
    if (!$con) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
	$con ->set_charset("utf8");
   // echo "Éxito: Se realizó una conexión apropiada a MySQL! La base de datos mi_bd es genial." . PHP_EOL;
   // echo "Información del host: " . mysqli_get_host_info($con) . PHP_EOL;
   // mysqli_close($con);
    ?>
