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

// Recibir parámetro de búsqueda
$busqueda = $_GET['busqueda'];
//$posibledni = substr($busqueda, 2, -1);

// Consulta SQL para buscar por RUC o Nombre_rs
$sql = "SELECT * FROM importacion WHERE ruc LIKE '%$busqueda%' OR Nombre_rs LIKE '%$busqueda%' LIMIT 5";
$sql2 = "SELECT * FROM importacion WHERE ruc LIKE '%$busqueda%' OR Nombre_rs LIKE '%$busqueda%' ";
 
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
if ($result->num_rows > 0) {
    // Contar el número total de resultados
    $total_resultados = $result->num_rows;
    $total_resultados2 = $result2->num_rows;
    // Mostrar los datos encontrados
    $contador = 0;
    while($row = $result->fetch_assoc()) {
        $dni = substr($row["ruc"], 2, -1); // Recortar los dos primeros y último dígito del campo ruc
        echo "DNI: " . $dni . " - Nombre completo: " . $row["Nombre_rs"]. "- RUC: ".$row["ruc"]."  \n";
        $contador++;
    }
    // Mostrar mensaje si hay más de 10 resultados en total
    if ($total_resultados2 > 5) {
        echo "\n Hay mas de 5 resultados, en total son:** $total_resultados2. ** Mostrare solo los primeros 5 por que si no todo se llenaria.";
    }
} else {
    echo "No se encontraron resultados";
}

// Cerrar conexión
$conn->close();
?>