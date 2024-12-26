
<?php
include('db.php');

// Mendapatkan data dari URL
$id = $_GET['id'];

// Mengambil data lama dari database
$ambildata = mysqli_query($conn, "SELECT * FROM tabungan WHERE id='$id'");
$data = mysqli_fetch_array($ambildata);

// Memproses form ketika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    // Mendapatkan input dari form
    $amount = $_POST['amount'];
    $source = $_POST['source'];
    $type = $_POST['type'];
    $date = $_POST['date'];

    // Sanitasi input untuk keamanan
    $amount = mysqli_real_escape_string($conn, $amount);
    $source = mysqli_real_escape_string($conn, $source);
    $type = mysqli_real_escape_string($conn, $type);
    $date = mysqli_real_escape_string($conn, $date);
    $id = mysqli_real_escape_string($conn, $id);

    // Query untuk mengupdate data
    $sql = "UPDATE tabungan SET amount='$amount', source='$source', type ='$type', date ='$date' WHERE id='$id'";
    
    // Eksekusi query dan cek hasilnya
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil diperbarui!');
        window.location.href='income.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

ob_start();
?>

<form action="" method="post">
  <div>
    <input type="text" name="amount" value="<?php echo $data['amount'] ?>" placeholder="Amount">
    <input type="text" name="type" value="<?php echo $data['type'] ?>" disabled placeholder="Type">
    <input type="date" name="date" value="<?php echo $data['date'] ?>" placeholder="Date">
    
    <select name="source" required>
      <option value="Salary"<?= $data['source'] == 'Salary' ? 'selected' :null ?>>Salary</option>
      <option value="Investasi"<?= $data['source'] == 'Investasi' ? 'selected' :null ?>>Investasi</option>
      <option value="Bisnis"<?= $data['source'] == 'Bisnis' ? 'selected' :null ?>>Bisnis</option>
      <option value="Source"<?= $data['source'] == 'Source' ? 'selected' :null ?>>Source</option>
    </select>
    <button type="simpan" name="simpan" >Submit</button>
  </div>
</form>

<?php
$content = ob_get_clean();

// Include Layout
include('layout/layout.php');
?>