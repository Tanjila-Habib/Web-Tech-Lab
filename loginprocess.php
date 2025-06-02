<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $umail = $_POST['umail'] ?? '';
    $upass = $_POST['upass'] ?? '';

    // Connect to database
    $con = mysqli_connect("localhost", "root", "", "AQI");
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $uname = mysqli_real_escape_string($con, $umail);

    $sql = "SELECT * FROM User WHERE Email = '$umail'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['Password'];

        if (password_verify($upass, $hashedPassword)) {
            // Correct password
            $_SESSION['uname'] = $row['Name'];

            echo '<div style="text-align:center; margin-top:50px; font-family:Arial,Helvetica,sans-serif;">';
            echo '<h2>Welcome, ' . htmlspecialchars($row['Name']) . '!</h2>';
            echo '<p>Login successful.</p>';
            echo '</div>';

            header("refresh: 2; url=request.php");
            exit();
        } else {
            // Incorrect password
            echo '<div style="text-align:center; margin-top:50px; font-family:Arial,Helvetica,sans-serif;">';
            echo '<p>Incorrect Password.</p>';
            echo '</div>';

            header("refresh: 2; url=index.html");
            exit();
        }
    } else {
        // User not found
        echo '<div style="text-align:center; margin-top:50px; font-family:Arial,Helvetica,sans-serif;">';
        echo '<p>User not found.</p>';
        echo '</div>';

        header("refresh: 2; url=index.html");
        exit();
    }
if ($con) {
    mysqli_close($con);
}
  
} else {
    echo '<p style="color:red; text-align:center;">Invalid request.</p>';
}
?>
