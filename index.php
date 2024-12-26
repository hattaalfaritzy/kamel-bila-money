<?php
include('db.php');

// Query untuk data grafik income
$sqlChartIncomes = "SELECT source, SUM(amount) as total_amount FROM tabungan WHERE type = 'Income' GROUP BY source";
$resultIncomes = mysqli_query($conn, $sqlChartIncomes);

$dataIncomes = [];
if (mysqli_num_rows($resultIncomes) > 0) {
    while ($row = mysqli_fetch_assoc($resultIncomes)) {
        $dataIncomes[] = $row;
    }
}

// Query untuk data grafik spending
$sqlChartSpendings = "SELECT source, SUM(amount) as total_amount FROM tabungan WHERE type = 'Spending' GROUP BY source";
$resultSpendings = mysqli_query($conn, $sqlChartSpendings);

$dataSpendings = [];
if (mysqli_num_rows($resultSpendings) > 0) {
    while ($row = mysqli_fetch_assoc($resultSpendings)) {
        $dataSpendings[] = $row;
    }
}

ob_start();
?>

<!-- Month Dropdown -->
<select class="form-select" aria-label="Default select example" style="border-color: #dd0b8c; border-width: 2px;">
  <option selected>Pilih Bulan</option>
  <option value="1">Januari</option>
  <option value="2">Febuari</option>
  <option value="3">Maret</option>
  <option value="3">April</option>
  <option value="3">Mei</option>
  <option value="3">Juni</option>
  <option value="3">Juli</option>
  <option value="3">Agustus</option>
  <option value="3">September</option>
  <option value="3">Oktober</option>
  <option value="3">November</option>
  <option value="3">Desember</option>
</select>

<!-- Total Income Box -->
<div class="white-small-box total-balance clearfix" style="margin-top: 20px">
  <p>Total Income</p>
  <?php
    $totalIncome = array_sum(array_column($dataIncomes, 'total_amount'));
  ?>
  <h2>Rp. <?= number_format($totalIncome, 2) ?></h2>
</div>

<!-- Total Spending Box -->
<div class="white-small-box total-balance clearfix" style="margin-top: 20px">
  <p>Total Spending</p>
  <?php
    $totalSpending = array_sum(array_column($dataSpendings, 'total_amount'));
  ?>
  <h2>Rp. <?= number_format($totalSpending, 2) ?></h2>
</div>

<!-- Total Balance Box -->
<div class="white-small-box total-balance clearfix" style="margin-top: 20px">
  <p>Total Balance (Income - Spending)</p>
  <?php
    $totalBalance = $totalIncome - $totalSpending;
  ?>
  <h2>Rp. <?= number_format($totalBalance, 2) ?></h2>
</div>

<!-- Income Progress Box -->
<div class="white-large-box">
    <h2>Income Progress</h2>
    <?php if (empty($dataIncomes)): ?>
        <p>No data available</p>
    <?php else: ?>
      <div class="chart-progress">
      <?php
            $totalIncome = array_sum(array_column($dataIncomes, 'total_amount'));
        ?>
        <span><?= number_format($totalIncome, 2) ?></span>
        <canvas id="incomeChart" width="400" height="200"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Mendeklarasikan data sekali
            const labels = <?= json_encode(array_column($dataIncomes, 'source')) ?>;
            const dataValues = <?= json_encode(array_column($dataIncomes, 'total_amount')) ?>;

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

<div class="white-large-box">
    <h2>Spendings Progress</h2>
    <?php if (empty($dataSpendings)): ?>
        <p>No data available</p>
    <?php else: ?>
        <div class="chart-progress">
            <span><?= number_format($totalSpending, 2) ?></span>
            <canvas id="spendingChart" width="400" height="200"></canvas>
            <script>
                const spendingLabels = <?= json_encode(array_column($dataSpendings, 'source')) ?>;
                const spendingDataValues = <?= json_encode(array_column($dataSpendings, 'total_amount')) ?>;

                const spendingCtx = document.getElementById('spendingChart').getContext('2d');
                new Chart(spendingCtx, {
                    type: 'doughnut',
                    data: {
                        labels: spendingLabels,
                        datasets: [{
                            label: 'Spending Source',
                            data: spendingDataValues,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',  // Light red
                                'rgba(178, 45, 69, 0.2)',  // Coral red
                                'rgba(114, 12, 32, 0.2)',   // Crimson red
                                'rgba(76, 16, 16, 0.2)'    // Firebrick red
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',    // Light red
                                'rgb(178, 45, 69)',         // Coral red
                                'rgb(114, 12, 32)',         // Crimson red
                                'rgb(76, 16, 16)'           // Firebrick red
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

<?php
$content = ob_get_clean();

// Include Layout
include('layout/layout.php');
?>