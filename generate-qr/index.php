<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./index.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>Generador de QR</title>
</head>

<body>
  <section class="wrapper">
    <form method="post" action="<?php echo $_SERVER[" PHP_SELF"]; ?>">
      <h1>Formulario de QR</h1>
      <div class="input-box">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <i class='bx bx-user'></i>
      </div>

      <div class="input-box">
        <input type="number" name="cantidad" placeholder="Cantidad" required>
        <i class='bx bx-dollar-circle'></i>
      </div>

      <div class="input-box">
        <input type="number" name="telefono" placeholder="Telefono" required>
        <i class='bx bx-phone'></i>
      </div>

      <input class="btn" type="submit" value="Enviar">
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
}
