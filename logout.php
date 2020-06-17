<?php
session_start();
session_destroy();

echo '<script>alert("Вие излезнахте успешно от акаунта си !")</script><script>window.location= "index.php"</script>';
?>