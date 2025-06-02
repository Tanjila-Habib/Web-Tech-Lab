<?php
session_start();

if (!isset($_SESSION['uname'])) {
    // Not logged in, redirect to login or homepage
    header("Location: login.php");
    exit();
}

$username = $_SESSION['uname'];
$return_page = isset($_GET['return']) ? $_GET['return'] : 'request.php';

// DB connection
$con = mysqli_connect("localhost", "root", "", "AQI");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Escape username for query
$username_esc = mysqli_real_escape_string($con, $username);

// Fetch user info by username
$sql = "SELECT Name, Email, DOB, Country, Gender, Opinion, AgreeTC FROM User WHERE Name = '$username_esc' LIMIT 1";
$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "User information not found.";
    mysqli_close($con);
    exit();
}

$user = mysqli_fetch_assoc($result);

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f7f7f7;
        }
        .profile-container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-info {
            line-height: 1.6;
        }
        .profile-info strong {
            display: inline-block;
            width: 130px;
        }
        .back-button {
            display: block;
            margin: 30px auto 0;
            text-align: center;
        }
        .back-button button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }
        .back-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>User Profile</h2>
        <div class="profile-info">
            <p><strong>Name:</strong> <?= htmlspecialchars($user['Name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['Email']) ?></p>
            <p><strong>Date of Birth:</strong> <?= htmlspecialchars($user['DOB']) ?></p>
            <p><strong>Country:</strong> <?= htmlspecialchars($user['Country']) ?></p>
            <p><strong>Gender:</strong> <?= htmlspecialchars($user['Gender']) ?></p>
            <p><strong>Opinion:</strong> <?= nl2br(htmlspecialchars($user['Opinion'])) ?></p>
            <p><strong>Agreed to Terms:</strong> <?= htmlspecialchars($user['AgreeTC']) ?></p>
        </div>

        <div class="back-button">
            <a href="<?= htmlspecialchars($return_page) ?>">
                <button>Back</button>
            </a>
        </div>
    </div>
</body>
</html>
