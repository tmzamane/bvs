<?php
require_once "includes/db.php";
// 2. Define the backend functions
function formatRand($amount)
{
    return 'R' . number_format($amount, 2);
}

function getDashboardData($conn)
{
    // The query has been updated to pull data for the current year as per the instructions
    $sql = "SELECT DATE_FORMAT(CallTime, '%Y-%b') AS `year_month`, COUNT(*) AS `total_calls`, SUM(Cost) AS `total_cost` FROM `BVSCalls` WHERE YEAR(CallTime) = YEAR(CURDATE()) GROUP BY DATE_FORMAT(CallTime, '%Y-%b') ORDER BY `CallTime` ASC";
    $result = $conn->query($sql);
    if ($result === false) {
        die("Query failed: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getMonthlySummaryData($conn, $month_param)
{
    // SQL query to get monthly summary data grouped by extension
    $sql = "SELECT CallFrom AS extension, COUNT(*) AS number_of_calls, SUM(Cost) AS total_value FROM `BVSCalls` WHERE DATE_FORMAT(CallTime, '%Y-%b') = ? GROUP BY extension";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $month_param);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getExtensionDetailData($conn, $month_param, $extension_param, $sort_by, $sort_order, $limit, $offset)
{
    // Sanitize sort column and order to prevent SQL injection
    $allowed_columns = ['CallFrom', 'CallTo', 'CallTime', 'Duration', 'Cost'];
    $allowed_orders = ['ASC', 'DESC'];

    $sort_by = in_array($sort_by, $allowed_columns) ? $sort_by : 'CallTime';
    $sort_order = in_array(strtoupper($sort_order), $allowed_orders) ? strtoupper($sort_order) : 'ASC';

    // SQL query to get all call details for a specific extension and month with sorting and pagination
    $sql = "SELECT CallFrom, CallTo, CallTime, Duration, Cost FROM `BVSCalls` WHERE DATE_FORMAT(CallTime, '%Y-%b') = ? AND CallFrom = ? ORDER BY `$sort_by` $sort_order LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssii", $month_param, $extension_param, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getExtensionDetailCount($conn, $month_param, $extension_param)
{
    $sql = "SELECT COUNT(*) AS total FROM `BVSCalls` WHERE DATE_FORMAT(CallTime, '%Y-%b') = ? AND CallFrom = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $month_param, $extension_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'];
}

// 3. Simple routing and parameter handling
$page = $_GET['page'] ?? 'page1'; // Default to page 1
$month_param = $_GET['month'] ?? '';
$extension_param = $_GET['extension'] ?? '';
$sort_by = $_GET['sort'] ?? 'CallTime';
$sort_order = $_GET['order'] ?? 'asc';
$page_number = $_GET['p'] ?? 1;

// Define pagination constants
$records_per_page = 20;
$offset = ($page_number - 1) * $records_per_page;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telephone Call Reporting</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
        <h1>Telephone Call Reporting Dashboard</h1>
    </header>
    <main class="container">
        <?php
        switch ($page) {
            case 'page1':
                $data = getDashboardData($conn);
                include 'templates/page1.php';
                break;
            case 'page2':
                if (!$month_param) {
                    echo "<h2>Error: A month parameter is required.</h2>";
                } else {
                    $data = getMonthlySummaryData($conn, $month_param);
                    include 'templates/page2.php';
                }
                break;
            case 'page3':
                if (!$month_param || !$extension_param) {
                    echo "<h2>Error: Both month and extension parameters are required.</h2>";
                } else {
                    $total_records = getExtensionDetailCount($conn, $month_param, $extension_param);
                    $total_pages = ceil($total_records / $records_per_page);
                    $data = getExtensionDetailData($conn, $month_param, $extension_param, $sort_by, $sort_order, $records_per_page, $offset);
                    include 'templates/page3.php';
                }
                break;
            default:
                echo "<h2>404 Page Not Found</h2>";
                break;
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2025 Telephone Call Reporting</p>
    </footer>
</body>

</html>
<?php
// Close the database connection at the end of the script
$conn->close();
?>