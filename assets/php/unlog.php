<?php
setcookie('ID_User', 0, time() + (86400 * 30), '/');
echo "<script>window.close();</script>";
?>