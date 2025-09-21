<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call Details</title>
</head>

<body>
    <div class="page-header">
        <h2>Call Detail for <?php echo htmlspecialchars($extension_param); ?> (<?php echo htmlspecialchars($month_param); ?>)</h2>
    </div>

    <div class="table-container">
        <?php if (!empty($data)): ?>
            <table>
                <thead>
                    <tr>
                        <th class="text-center">Call From</th>
                        <th class="text-center">Call To</th>
                        <th class="text-center">Time of Call</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td class="text-center"><?php echo htmlspecialchars($row['CallFrom']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['CallTo']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['CallTime']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['Duration']); ?></td>
                            <td class="text-center"><?php echo formatRand($row['Cost']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No data found for the selected extension and month.</p>
        <?php endif; ?>
    </div>

    <a href="?page=page2&month=<?php echo urlencode($month_param); ?>" class="back-link">← Back to Monthly Summary</a>
</body>

</html>