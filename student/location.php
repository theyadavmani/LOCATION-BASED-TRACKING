<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
} 
// elseif ($_SESSION['role'] === 'teacher') {
//     header("location: view_attendance.html");
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="location.css">
    <title>ATTENDANCE BY LOCATION</title>
</head>
<body>
<header>

<h1>ATTENDANCE BY LOCATION</h1>
<div class="navbar">
<a href="index.php">Home</a>
<!-- <a href="students.php">Students</a> -->
<a href="location.php">My Report</a>
<!-- <a href="account.php">My Account</a> -->
<a href="../logout.php">Logout</a>

</div>
</header>
<div class="hey"> WELCOME !  <?php echo $_SESSION['username']; 
    ?> , Mark you attendance..
</div>
    <div class="presence">

    <p id="attendanceStatus">Attendance status: Not Marked</p>
    <p id="time">Time: </p>
    </div>
    <button id="btn" onclick="startAttendance()">Mark Attendance</button>
    <!-- <button id="sav" onclick="saveAttendance()"> Save Attendance</button> -->

    <script>
        console.log('11');
        var isInsideCollege = false;
        var currentdate;
        var username = "<?php echo  $_SESSION['username']; ?>"; // Pass username from PHP
        console.log("username: " + username);

        function startAttendance() {
            setInterval(checkAttendance,4000);
            checkAttendance();
        }

        function checkAttendance() {
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        var collegeLocation = { latitude: 23.01952, longitude: 72.6171648 };
                        console.log('\n',"Current latitude",position.coords.latitude);
                        console.log("Current longitude",position.coords.longitude);
                        
                        const distance = calculateDistance(
                            position.coords.latitude,
                            position.coords.longitude,
                            collegeLocation.latitude,
                            collegeLocation.longitude
                        );
                        console.log("Distance between College and current location" ,distance)
                        

                        if (distance <= 10) {
                            
                            if (!isInsideCollege) {
                                console.log('1')
                                markAttendance(true);
                                isInsideCollege = true;
                                currentdate = new Date();
                                printTime();
                            }
                        } else {
                            if (isInsideCollege) {
                                // console.log('2')
                                markAttendance(false);
                                isInsideCollege = false;
                                currentdate = new Date();
                                printTime();
                            }
                        }
                    },
                    error => {
                        console.error('Error getting location:', error);
                    },{enableHighAccuracy: false, timeout: 2000, maximumAge: 0}
                );
            } else {
                alert('Geolocation is not supported by your browser.');
            }
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c;
            return distance;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        function markAttendance(isPresent) {
    const attendanceStatusElement = document.getElementById('attendanceStatus');
    attendanceStatusElement.textContent = `Attendance status: ${isPresent ? 'Present' : 'Not Present'}`;

    const currentdate = new Date();
    const clientusername = "<?php echo $_SESSION['username']; ?>";
    const status = isPresent ? 'present' : 'absent';
    // date_default_timezone_set('Asia/Kolkata');
    const localTime = currentdate.toLocaleString('en-US', { timeZone: 'Asia/Kolkata' }); 
    const time = new Date(localTime).toISOString().slice(0, 19).replace("T", " ");

    // const time = currentdate.toString();
    var data = "mark=true&status=" + encodeURIComponent(status) + "&time=" + encodeURIComponent(time) + "&username=" + encodeURIComponent(clientusername);
var xhr = new XMLHttpRequest();
xhr.open("POST", "save_attendance.php", true);
xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
        // The PHP file has been executed, and you can handle the response here
        console.log(xhr.responseText);
    }
};
xhr.send(data);
}
        function printTime() {
            const timeElement = document.getElementById('time');
            timeElement.textContent = `Time: ${currentdate}`;
        }
    </script>
</body>
</html>

