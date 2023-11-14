<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generador de QR</title>
</head>

<body>
  <h2>Formulario de QR</h2>
  <section>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <label for="nombre">Nombre:</label>
      <input type="text" name="nombre" required><br>

      <label for="cantidad">Cantidad:</label>
      <input type="number" name="cantidad" required><br>

      <label for="telefono">Teléfono:</label>
      <input type="tel" name="telefono" required><br>

      <input type="submit" value="Enviar">
    </form>
  </section>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $cantidad = $_POST["cantidad"];
  $telefono = $_POST["telefono"];

  // Hacer la llamada a la API
  $api_url = "http://149.202.12.81/rapidprest_i2/public/api/maq1/generarqr/prueba1";
  $api_params = array(
    'nombre' => $nombre,
    'cantidad' => $cantidad,
    'telefono' => $telefono
  );

  $curl = curl_init($api_url);

  curl_setopt_array($curl, [
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => http_build_query($api_params),
    CURLOPT_HTTPHEADER => [
      "Bearer sWCkATuQlzT2solMGTM8BumHnr5CcKtrl70r3kVAK6wuVHPq2nAq1O2M0D4w\r\n"
    ],
  ]);

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }

  // Decodificar la respuesta JSON
  $result = json_decode($response, true);

  // Verificar si la llamada a la API fue exitosa
  if ($result && $result['success']) {
    // Generar el QR físico y mostrarlo en pantalla
    echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($result) . '" alt="QR Code" />';
  } else {
    echo 'Error al generar el QR. Por favor, inténtalo de nuevo.';
  }
}
?>