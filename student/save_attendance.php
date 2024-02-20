<?php

session_start();
include('connect.php');

try {
    if (isset($_POST['mark'])) {
        if (empty($_POST['status'])) {
            throw new Exception("Status can't be empty.");
        }

        if (empty($_POST['time'])) {
            throw new Exception("Time can't be empty.");
        }

        $status = $_POST['status'];
        $time = $_POST['time'];
        $username = $_SESSION['username'];

        // Using parameterized query to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO data (status, time, username) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $status, $time, $username);

        if ($stmt->execute()) {
            $success_msg = "Mark Successfully!";
        } else {
            throw new Exception("Error executing the query: " . $stmt->error);
        }

        $stmt->close();
    } else {
        throw new Exception("No 'mark' parameter found in the POST request.");
    }
} catch (Exception $e) {
    $error_msg = $e->getMessage();
} finally {
    if (!isset($error_msg)) {
        $error_msg = null;
    }
}

$conn->close();

// Output the result as JSON for better AJAX handling
header('Content-Type: application/json');
echo json_encode(['success' => isset($success_msg), 'error' => $error_msg]);

?>
