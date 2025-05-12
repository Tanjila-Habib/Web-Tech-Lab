<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $name     = $_POST['uname']   ?? 'Not Provided';
    $email    = $_POST['umail']   ?? 'Not Provided';
    $dob      = $_POST['dob']    ?? 'Not Provided';
    $country  = $_POST['country']?? 'Not Provided';
    $gender   = $_POST['gen']  ?? 'Not Provided';
    $color    = $_POST['color']  ?? 'Not Provided';
    $opinion  = $_POST['opinion'] ?? 'Not Provided';
    $agree    = isset($_POST['tc']) ? 'Yes' : 'No';

    
    echo '<div style="border:1px solid #333; padding:20px; width:400px; margin:auto; margin-top:50px; font-family:Arial,Helvetica, sans-serif;">';
    echo "<h2 style='text-align:center;'>Registration Receipt</h2>";
    echo "Name: " . htmlspecialchars($name) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Date of Birth: " . htmlspecialchars($dob) . "<br>";
    echo "Country: " . htmlspecialchars($country) . "<br>";
    echo "Gender: " . htmlspecialchars($gender) . "<br>";
    echo "Color: " . htmlspecialchars($color) . "<br>";
    echo "Opinion: " . nl2br(htmlspecialchars($opinion)) . "<br>";
    echo "Agree to Terms and Conditions: " . $agree . "<br>";
    echo '<div style="text-align:center;"><a href="App1.html"><button style="padding:10px 20px; font-size:16px;">Go Back</button></a></div>';
    echo '</div>';
} else {
    echo "No data submitted.";
}
?>






