<?php
include('db.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM tabungan WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Record deleted successfully')
        window.location.href='index.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
