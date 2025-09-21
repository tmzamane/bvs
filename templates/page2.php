<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Summary</title>
</head>

<body>
    <div class="page-header">
        <h2>Monthly Summary by Extension for <?php echo htmlspecialchars($month_param); ?></h2>
    </div>

    <div class="table-container">
        <?php if (!empty($data)): ?>
            <table>
                <thead>
                    <tr>
                        <th class="text-center">Extension</th>
                        <th class="text-center">Number of Calls</th>
                        <th class="text-center">Total Cost (R)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td class="text-center">
                                <a href="?page=page3&month=<?php echo urlencode($month_param); ?>&extension=<?php echo htmlspecialchars($row['extension']); ?>">
                                    <?php echo htmlspecialchars($row['extension']); ?>
                                </a>
                            </td>
                            <td class="text-center"><?php echo htmlspecialchars($row['number_of_calls']); ?></td>
                            <td class="text-center"><?php echo formatRand($row['total_value']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No data found for the selected month.</p>
        <?php endif; ?>
    </div>

    <a href="?page=page1" class="back-link">← Back to Dashboard</a>
</body>

</html>