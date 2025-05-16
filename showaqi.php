<?php
session_start();

// Connect to MySQL database
$con = mysqli_connect("localhost", "root", "", "AQI");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if selected cities exist in session
if (!isset($_SESSION['selected_cities']) || empty($_SESSION['selected_cities'])) {
    echo "No cities selected.";
    exit();
}

$cities = $_SESSION['selected_cities'];

// Prepare city names for SQL IN clause (escape for security)
$escaped_cities = array_map(function($city) use ($con) {
    return "'" . mysqli_real_escape_string($con, $city) . "'";
}, $cities);

// Create comma-separated list for SQL IN
$city_list = implode(',', $escaped_cities);

// SQL query to get city, country, and aqi_value from Info table
$sql = "SELECT City, Country, AQI FROM Info WHERE City IN ($city_list)";

$result = mysqli_query($con, $sql);

// Check if query succeeded
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Close connection later (after HTML output)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selected City AQI</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f4f4f4;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 40%;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 18px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: black;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
    </style>
</head>
<body>

<h2>Air Quality Index (AQI) of Selected Cities</h2>

<table>
    <thead>
        <tr>
            <th>City</th>
            <th>Country</th>
            <th>AQI</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['City']) . "</td>
                    <td>" . htmlspecialchars($row['Country']) . "</td>
                    <td>" . htmlspecialchars($row['AQI']) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No AQI data found for selected cities.</td></tr>";
    }

    // Close the DB connection
    mysqli_close($con);
    ?>
    </tbody>
</table>

</body>
</html>
