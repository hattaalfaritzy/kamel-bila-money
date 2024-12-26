<?php
include('db.php');

// Logika untuk input data
if (isset($_POST['submit'])) {
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $source = mysqli_real_escape_string($conn, $_POST['source']);

    $sql = "INSERT INTO tabungan (amount, source, type) VALUES ('$amount', '$source', 'Income')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('New record created successfully'); window.location.href='income.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Query untuk data grafik
$sqlChart = "SELECT source, SUM(amount) as total_amount FROM tabungan WHERE type = 'Income' GROUP BY source";
$result = mysqli_query($conn, $sqlChart);

$data = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

ob_start();
?>

<!-- Konten khusus untuk Income -->
<form action="income.php" method="post">
    <div>
        <input type="text" name="amount" placeholder="Amount" required />
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

<div class="white-large-box">
    <h2>Income Progress</h2>
    <?php if (empty($data)): ?>
        <p>No data available</p>
    <?php else: ?>
      <div class="income-progress">
      <?php
            $totalIncome = array_sum(array_column($data, 'total_amount'));
        ?>
        <span><?= number_format($totalIncome, 2) ?></span>
        <canvas id="incomeChart" width="400" height="200"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Mendeklarasikan data sekali
            const labels = <?= json_encode(array_column($data, 'source')) ?>;
            const dataValues = <?= json_encode(array_column($data, 'total_amount')) ?>;

            const ctx = document.getElementById('incomeChart').getContext('2d');
            const incomeChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Income Source',
                        data: dataValues,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(201, 203, 207, 1)'
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
?>