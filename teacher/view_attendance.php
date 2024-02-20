<?php
session_start();
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher')
// if (!isset($_SESSION['username']))
// {
//     header("location: ../index.php");
//     exit();
// }

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete and update logic here

// Fetch attendance data
$sql = "SELECT * FROM data";
$result = $conn->query($sql);

$attendanceData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attendanceData[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view.css">
    <title>View Attendance</title>
</head>
<body>
<header>

<h1>ATTENDANCE BY LOCATION</h1>
<div class="navbar">
<a href="index.php">Home</a>
<a href="view_attendance.php">Students</a>
<!-- <a href="teachers.php">Faculties</a> -->
<!-- <a href="attendance.php">Attendance</a> -->
<!-- <a href="report.php">Report</a> -->
<a href="../logout.php">Logout</a>

</div>

</header>
    <h1>View Attendance</h1>

    <div id="attendanceList"></div>

    <script>
        const attendanceData = <?php echo json_encode($attendanceData); ?>;

        // Display attendance data on the page
        function displayAttendance(attendanceData) {
            const attendanceListElement = document.getElementById('attendanceList');

            if (attendanceData.length > 0) {
                const table = document.createElement('table');
                table.border = '1';

                // Create table header
                const headerRow = table.insertRow(0);
                for (const key in attendanceData[0]) {
                    const headerCell = headerRow.insertCell(-1);
                    headerCell.textContent = key;
                }

                // Populate table with data
                attendanceData.forEach((entry, index) => {
                    const row = table.insertRow(index + 1);
                    for (const key in entry) {
                        const cell = row.insertCell(-1);
                        cell.textContent = entry[key];
                    }
                });

                attendanceListElement.appendChild(table);
            } else {
                attendanceListElement.textContent = 'No attendance data found.';
            }
        }
        // Fetch attendance data from the server
        displayAttendance(attendanceData);
    </script>
</body>
</html>
