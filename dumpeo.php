<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "importe3";
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Establecer la codificación de caracteres a latin1
if (!$conn->set_charset("latin1")) {
    die("Error al establecer la codificación de caracteres: " . $conn->error);
}


$batchSize = 100; // Tamaño del lote
$start = isset($_GET['start']) ? intval($_GET['start']) : 0; // Obtener el valor de inicio desde el parámetro GET o establecerlo en 0 por defecto

$file = fopen("padron_reducido_rucparasql.txt", "r");

if ($file) {
  $counter = 0; // Contador para controlar el tamaño del lote
  $lineNumber = 0; // Contador para llevar la cuenta de las líneas procesadas

  while (($line = fgets($file)) !== false) {
    $lineNumber++;

    if ($lineNumber <= $start) {
      continue; // Saltar las líneas que ya se han procesado
    }

    // Reemplazar algunas palabras en la línea
    $line = str_replace("NO HABIDO", "NH", $line);
    $line = str_replace("HABIDO", "H", $line);
    $line = str_replace("ACTIVO", "A", $line);
    $line = str_replace("BAJA DEFINITIVA", "BD", $line);
    $line = str_replace("SUSPENSION TEMPORAL", "ST", $line);
    $line = str_replace("BAJA DE OFICIO", "BO", $line);
    $line = str_replace("PENDIENTE", "P", $line);
    $line = str_replace("NO APLICABLE", "NA", $line);
    $line = str_replace("NO HALLADO", "NH", $line);

    // Procesar cada línea del archivo
    $data = explode("|", $line);
    // Escapar comillas simples en el nombre
    $Nombre_rs = str_replace("'", "\\'", $data[1]);
    // Insertar los datos en la base de datos
    $sql = "INSERT INTO importacion (ruc, Nombre_rs, Estado_contribuyente, Condicion_casa, ubigeo, tipo_de_via, Nombre_de_via, Codigo_de_zona, Tipo_de_zona, Numero, Interior, Lote, Departamento, Manzana, Km)
    VALUES ('$data[0]', '$Nombre_rs', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]', '$data[13]', '$data[14]')";

    if ($conn->query($sql) === TRUE) {
      echo "Registro ok<br>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $counter++;
    
    // Si se ha procesado el tamaño del lote, recargar la página con el siguiente lote como parámetro GET
    if ($counter >= $batchSize) {
      echo "Se han procesado $counter registros. Recargando página...";
      echo '<meta http-equiv="refresh" content="1;url=?start=' . ($start + $batchSize) . '">'; // Recargar la página después de 1 segundo con el siguiente lote como parámetro GET
      break; // Salir del bucle while
    }
  }
  fclose($file);

  // Si no se ha procesado el tamaño del lote, mostrar un mensaje final
  if ($counter < $batchSize) {
    echo "Se han procesado todos los registros.";
  }
} else {
  echo "Error al abrir el archivo";
}

$conn->close();
?>