<?php
include('db.php');

// Logika untuk input data
if (isset($_POST['submit'])) {
  $amount = mysqli_real_escape_string($conn, $_POST['amount']);
  $source =  mysqli_real_escape_string($conn, $_POST['source']);

  $sql = "INSERT INTO tabungan (amount, source, type) VALUES ('$amount', '$source', 'income')";
  if (mysqli_query($conn, $sql)) {
    echo "<script>alert('New record created successfully')
    window.location.href='income.php';</script>";
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn); 
  }
}

// Konten Halaman Income
ob_start();
?>
<!-- Konten khusus untuk Income -->
<form action="income.php" method="post">
  <div>
    <input type="text" name="amount" placeholder="Amount" />
    <select name="source" required>
      <option value="" selected disabled>Source</option>
      <option value="Salary">Salary</option>
      <option value="Investasi">Investasi</option>
      <option value="Bisnis">Bisnis</option>
      <option value="Other">Other</option>
    </select>
    <button type="submit" name="submit">Submit</button>
  </div>
</form>

      <!-- Income Progress Box -->
      <div class="white-large-box incomes-progress clearfix">
        <p>Income Progress</p>
        <div class="circle-container">
          <!-- Salary -->
          <div class="round salary" data-value="0.6">
            <strong></strong>
            <span>Salary</span>
          </div>

          <!-- Investasi -->
          <div class="round investasi" data-value="0.2">
            <strong></strong>
            <span>Investasi</span>
          </div>

          <!-- Bisnis -->
          <div class="round bisnis" data-value="0.2">
            <strong></strong>
            <span>Bisnis</span>
          </div>
        </div>
      </div>

<!-- Income Table -->
<table class="table">
  <thead>
    <tr>
      <th>Amount</th>
      <th>Date</th>
      <th>Source</th>
      <th colspan="2">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT * FROM tabungan WHERE type = 'Income'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
          <td>{$row['amount']}</td>
          <td>{$row['date']}</td>
          <td>{$row['source']}</td>
          <td><a href='delete.php?id={$row['id']}'>Delete</a></td>
          <td><a href='edit.php?id={$row['id']}'>Edit</a></td>
        </tr>";
      }
    } else {
      echo "<tr><td colspan='5'>No records found</td></tr>";
    }
    ?>
  </tbody>
</table>
<?php
$content = ob_get_clean();

// Include Layout
include('layout/layout.php');
