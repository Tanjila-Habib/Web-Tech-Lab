 <?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // First submission: Store in session
    if (!isset($_POST['confirm'])) {
        $_SESSION['uname']   = $_POST['uname']   ?? 'Not Provided';
        $_SESSION['umail']   = $_POST['umail']   ?? 'Not Provided';
        $_SESSION['dob']     = $_POST['dob']     ?? 'Not Provided';
        $_SESSION['country'] = $_POST['country'] ?? 'Not Provided';
        $_SESSION['gen']     = $_POST['gen']     ?? 'Not Provided';
        $_SESSION['color']   = $_POST['color']   ?? '#ffffff';
        $_SESSION['opinion'] = $_POST['opinion'] ?? 'Not Provided';
        $_SESSION['agree']   = isset($_POST['tc']) ? 'Yes' : 'No';
        $_SESSION['password'] = $_POST['upass'] ?? '';

      
        $user_cookie_key = 'bgcolor_' . md5($_SESSION['uname']);
        setcookie($user_cookie_key, $_SESSION['color'], time() + (86400 * 30)); 

        // Show confirmation page
        echo '<form method="POST">';
        echo '<div style="border:1px solid #333; padding:20px; width:400px; margin:auto; margin-top:50px; font-family:Arial,Helvetica, sans-serif;">';
        echo "<h2 style='text-align:center;'>Please Confirm Your Information</h2>";
        echo "Name: " . htmlspecialchars($_SESSION['uname']) . "<br>";
        echo "Email: " . htmlspecialchars($_SESSION['umail']) . "<br>";
        echo "Date of Birth: " . htmlspecialchars($_SESSION['dob']) . "<br>";
        echo "Country: " . htmlspecialchars($_SESSION['country']) . "<br>";
        echo "Gender: " . htmlspecialchars($_SESSION['gen']) . "<br>";
        echo "Opinion: " . nl2br(htmlspecialchars($_SESSION['opinion'])) . "<br>";
        echo "Agree to Terms and Conditions: " . $_SESSION['agree'] . "<br><br>";
        echo '<div style="text-align:center;">';
        echo '<button type="submit" name="confirm" style="padding:10px 20px; font-size:16px; margin-right:10px;">Confirm</button>';
        echo '<a href="index.html"><button type="button" style="padding:10px 20px; font-size:16px;">Back</button></a>';
        echo '</div>';
        echo '</div>';
        echo '</form>';

    } else {
        // Final confirmation: Insert into database
        $name     = $_SESSION['uname'];
        $email    = $_SESSION['umail'];
        $dob      = $_SESSION['dob'];
        $country  = $_SESSION['country'];
        $gender   = $_SESSION['gen'];
        $color    = $_SESSION['color'];
        $opinion  = $_SESSION['opinion'];
        $agree    = $_SESSION['agree'];
        $password = $_SESSION['password'];

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $con = mysqli_connect("localhost", "root", "", "AQI");
        if (!$con) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $name = mysqli_real_escape_string($con, $name);
        $email = mysqli_real_escape_string($con, $email);
        $dob = mysqli_real_escape_string($con, $dob);
        $country = mysqli_real_escape_string($con, $country);
        $gender = mysqli_real_escape_string($con, $gender);
        $opinion = mysqli_real_escape_string($con, $opinion);
        $agree = mysqli_real_escape_string($con, $agree);
        $password_hash = mysqli_real_escape_string($con, $password_hash);

        $sql = "INSERT INTO User (Name, Email, DOB, Country, Gender, Opinion, AgreeTC, Password) 
                VALUES ('$name', '$email', '$dob', '$country', '$gender', '$opinion', '$agree', '$password_hash')";

        if (mysqli_query($con, $sql)) {
            // Retrieve user-specific bgcolor cookie
            $user_cookie_key = 'bgcolor_' . md5($email);
            $bgcolor = $_COOKIE[$user_cookie_key] ?? '#ffffff';

           echo '<div style="border:1px solid #333; padding:20px; width:400px; margin:auto; margin-top:50px; font-family:Arial,Helvetica, sans-serif;">';
            echo "<h2 style='text-align:center;'>Registration Completed</h2>";
            echo "Thank you, " . htmlspecialchars($name) . "! Your information has been saved.<br><br>";
            echo '<div style="text-align:center;"><a href="index.html"><button style="padding:10px 20px; font-size:16px;">Go to Home</button></a></div>';
            echo '</div>';
        } else {
            echo "Failed to insert data: " . mysqli_error($con);
        }

        mysqli_close($con);
        session_destroy(); // Clear data
    }
} else {
    echo "No data submitted.";
}
?>
