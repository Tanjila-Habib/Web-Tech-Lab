<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cities']) && is_array($_POST['cities'])) {
        
        $_SESSION['selected_cities'] = $_POST['cities'];

       
        header("Location: showaqi.php");
        exit();
    } else {
        
        $_SESSION['selected_cities'] = [];

       
        header("Location: showaqi.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>City AQI Request Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }

        .city-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 20px 0;
        }

        .city-item {
            display: flex;
            align-items: center;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Select Cities</h2>
    <form action="request.php" method="POST">
        <div class="city-list">
            <?php
                $cities = [
                    "Dhaka", "Delhi", "Beijing", "Sydney", "Karachi",
                    "Jakarta", "London", "Berlin", "Rome", "New York",
                    "Mexico City", "Istanbul", "Toronto", "Los Angeles",
                    "Paris", "Tokyo", "Cairo", "Bangkok", "Moscow", "Bucharest"
                ];

                foreach ($cities as $city) {
                    echo "<div class='city-item'><input type='checkbox' name='cities[]' value='$city'> $city</div>";
                }
            ?>
        </div>
        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>
