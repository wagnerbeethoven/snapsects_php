<html>

<head>
   <title>Identificar IP do usu�rio</title>
</head>

<body>

   <?php

   $ip = $_SERVER['REMOTE_ADDR'];
   echo "Seu IP �: " . $ip . '<br>';
   print_r($_SERVER);
   ?>

</body>

</html>