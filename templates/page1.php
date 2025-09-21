<div class="page-header">
    <h2>Dashboard - Overview by Month (2018)</h2>
</div>

<div class="chart-container">
    <canvas id="callsChart"></canvas>
</div>

<div class="table-container">
    <h3>Monthly Summary</h3>
    <?php if (!empty($data)): ?>
        <table>
            <thead>
                <tr>
                    <th class="text-center">Year-Month</th>
                    <th class="text-center">Number of Calls</th>
                    <th class="text-center">Total Cost (R)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td class="text-center">
                            <a href="?page=page2&month=<?php echo urlencode($row['year_month']); ?>">
                                <?php echo htmlspecialchars($row['year_month']); ?>
                            </a>
                        </td>
                        <td class="text-center"><?php echo htmlspecialchars($row['total_calls']); ?></td>
                        <td class="text-center"><?php echo formatRand($row['total_cost']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No data found for the current year.</p>
    <?php endif; ?>
</div>

<script>
    const chartData = {
        labels: [<?php echo implode(',', array_map(function ($row) {
                        return "'" . $row['year_month'] . "'";
                    }, $data)); ?>],
        datasets: [{
            label: 'Number of Calls',
            data: [<?php echo implode(',', array_map(function ($row) {
                        return $row['total_calls'];
                    }, $data)); ?>],
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }, {
            label: 'Total Cost (R)',
            data: [<?php echo implode(',', array_map(function ($row) {
                        return $row['total_cost'];
                    }, $data)); ?>],
            backgroundColor: 'rgba(255, 99, 132, 0.6)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    };

    const ctx = document.getElementById('callsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Value'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            }
        }
    });
</script>