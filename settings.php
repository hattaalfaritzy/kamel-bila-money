<?php
include('db.php');

ob_start();
?>

<?php
$content = ob_get_clean();

// Include Layout
include('layout/layout.php');
?>