<?php
include('../db.php');

if (isset($_GET['id']) && isset($_GET['redirect'])) {
    $id = $_GET['id'];
    $redirectPage = $_GET['redirect'];

    $sql = "DELETE FROM tabungan WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Record deleted successfully');
                window.location.href='$redirectPage';
              </script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid parameters.";
}
?>
