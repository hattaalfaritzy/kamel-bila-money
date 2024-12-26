<?php
include('db.php');

// Query untuk data grafik
$sqlChart = "SELECT source, SUM(amount) as total_amount FROM tabungan WHERE type = 'Spending' GROUP BY source";
$result = mysqli_query($conn, $sqlChart);

$data = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

ob_start();
?>

<form action="controllers/submit_spending.php" method="post">
  <div>
    <input type="number" name="amount" placeholder="Amount" required min="0" />
    <select required name="source">
      <option value="" selected disabled>Source</option>
      <option value="Food">Food</option>
      <option value="Transport">Transport</option>
      <option value="Entertainment">Entertainment</option>
      <option value="Business">Business</option>
      <option value="Other">Other</option>
    </select>
    <button type="submit" name="submit">Submit</button>
  </div>
</form>

<div class="white-large-box">
    <h2>Spendings Progress</h2>
    <?php if (empty($data)): ?>
        <p>No data available</p>
    <?php else: ?>
      <div class="chart-progress">
      <?php
            $totalSpending = array_sum(array_column($data, 'total_amount'));
        ?>
        <span><?= number_format($totalSpending, 2) ?></span>
        <canvas id="spendingChart" width="400" height="200"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Mendeklarasikan data sekali
            const labels = <?= json_encode(array_column($data, 'source')) ?>;
            const dataValues = <?= json_encode(array_column($data, 'total_amount')) ?>;

            const ctx = document.getElementById('spendingChart').getContext('2d');
            const spendingChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Income Source',
                        data: dataValues,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',  // Light red
                            'rgba(178, 45, 69, 0.2)',  // Coral red
                            'rgba(114, 12, 32, 0.2)',   // Crimson red
                            'rgba(76, 16, 16, 0.2)'    // Firebrick red
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',    // Light red
                            'rgb(178, 45, 69)',    // Coral red
                            'rgb(114, 12, 32)',     // Crimson red
                            'rgb(76, 16, 16)'      // Firebrick red
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        </script>
      </div>
    <?php endif; ?>
</div>

<table class="table">
  <thead>
    <tr>
      <th>Amount</th>
      <th>Date</th>
      <th>Source</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT * FROM tabungan WHERE type = 'Spending'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
      <td><?php echo $row["amount"] ?></td>
      <td><?php echo $row["date"] ?></td>
      <td><?php echo $row["source"] ?></td>
      <td><a href="delete.php?id=<?php echo $row["id"] ?>">Delete</a></td>
      <td><a href="edit.php?id=<?php echo $row["id"] ?>">Edit</a></td>
    </tr>
    <?php
      }
    } else {
      echo "0 results";
    }
    ?>
  </tbody>
</table>


<?php
$content = ob_get_clean();

// Include Layout
include('layout/layout.php');
?>