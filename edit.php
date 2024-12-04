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
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>KAMEL BILA MONEY</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-header">
        <h1>Kamel Bila <span>Money</span> 💸</h1>
      </div>
      
      <a href="index.php" class="menu dashboard" style="text-decoration: none;">
      <div  id="dashboard">
        <i class="fas fa-piggy-bank"></i> dashboard
      </div>
      </a>
      <a href="income.php" class="menu incomes" style="text-decoration: none;">
      <div  id="incomes">
        <i class="fas fa-piggy-bank"></i> Incomes
      </div>
      </a>
      <a href="spendings.php" class="menu spendings" style="text-decoration: none;">
      <div  id="spendings">
        <i class="fas fa-piggy-bank"></i> spendings
      </div>
      </a>
      <a href="settings.php" class="menu settings" style="text-decoration: none;">
      <div  id="settings">
        <i class="fas fa-piggy-bank"></i> settings
      </div>
      </a>
    </div>
    <!-- End Sidebar -->

    <!-- Dashboard Content -->
    <div class="main-dashboard" id="main-dashboard">
      <!-- Dashboard Title -->
      <div class="user-title">
        <p class="kamel-title">
          Kamel Bila <span class="money-text">Money</span>
        </p>
      </div>
      <form action="" method="post" >
      <div>
        <input type="text" name="amount" value="<?php echo $data['amount'] ?>" placeholder="Amount">
        <input type="text" name="type" value="<?php echo $data['type'] ?>" placeholder="Type">
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
    </div>
    <!-- End Dashboard -->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
      integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
      integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
      crossorigin="anonymous"
    ></script>
    <script src="script.js"></script>
  </body>