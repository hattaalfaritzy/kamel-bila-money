<?php
include('../db.php');

if (isset($_POST['submit'])) {
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $source = mysqli_real_escape_string($conn, $_POST['source']);

    $sql = "INSERT INTO tabungan (amount, source, type) VALUES ('$amount', '$source', 'Spending')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('New spending data created successfully');
                window.location.href='../spendings.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>