<?php
session_start();
session_unset();
# setcookie('ID_User', 0, time() + (86400 * 30), '/');
echo "<script>window.history.back();</script>";
?>