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

  // Realiza la llamada a la API
  $url = "http://149.202.12.81/rapidprest_i2/public/api/maq1/generarqr/prueba1";
  $data = array('cantidad' => $cantidad, 'numeroautorizacion' => substr($telefono, -4));
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
        "authorization: Bearer sWCkATuQlzT2solMGTM8BumHnr5CcKtrl70r3kVAK6wuVHPq2nAq1O2M0D4w\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);

  /* Manejo de error */
  if ($result === FALSE) {
  }

  // Genera el código QR
  echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($result) . '" alt="QR Code" />';
  echo $result;
}
