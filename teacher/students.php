<?php
session_start();
var_dump($_SESSION);

// Check if the user is not logged in or is not a teacher
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header("location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <h2>Attendance Data</h2>

    <div id="attendanceList"></div>

    <script>
        // Fetch attendance data from the server
        fetch('view.php')
            .then(response => response.json())
            .then(data => displayAttendance(data))
            .catch(error => console.error('Error fetching attendance data:', error));

        // Display attendance data on the page
        function displayAttendance(attendanceData) {
            const attendanceListElement = document.getElementById('attendanceList');

            if (attendanceData.success) {
                if (attendanceData.data.length > 0) {
                    const table = document.createElement('table');
                    table.border = '1';

                    // Create table header
                    const headerRow = table.insertRow(0);
                    for (const key in attendanceData.data[0]) {
                        const headerCell = headerRow.insertCell(-1);
                        headerCell.textContent = key;
                    }

                    // Populate table with data
                    attendanceData.data.forEach((entry, index) => {
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
            } else {
                attendanceListElement.textContent = 'Error fetching attendance data.';
            }
        }
    </script>
</body>
</html>
