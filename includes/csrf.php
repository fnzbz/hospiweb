<?php
if (isset($_SESSION['key'])) {
$csrf = hash_hmac('sha256', 'platformahospiwebcastigainfoeducatie', $_SESSION['key']);
} else die();
?>
