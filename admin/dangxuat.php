<?php
session_start();

// Hủy bỏ phiên làm việc 
session_unset();
session_destroy();

header("Location: ../index.php");
exit;
?>
