<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
        <h2>Form</h2>
        <label for="fname">First Name:</label>
        <input type="text" name="fname" id="fname" required>
        <br><br>

        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" required>
        <br><br>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required>
        <br><br> 

        <label for="email">E-mail:</label>
        <input type="text" name="email" id="email" required>
        <br><br>

        <label for="tel">Phone Number:</label>
        <input type="text" name="tel" id="tel" required>
        <br><br>
        
        <label>Gender:</label>
        <input type="radio" name="gender" value="Female" class="gender" required>Female
        <input type="radio" name="gender" value="Male" class="gender">Male
        <input type="radio" name="gender" value="Other" class="gender">Other
        <br><br>
        
        <input class="btn" type="submit" name="submit" value="Submit">  
    </form>

    <?php
    
    $fname = $lname = $email = $gender = $address = $tel = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = input($_POST["fname"]);
        $lname = input($_POST["lname"]);
        $email = input($_POST["email"]);
        $address = input($_POST["address"]);
        $tel = input($_POST["tel"]);
        $gender = input($_POST["gender"]);
        
       
        $servername = "localhost"; 
        $username = "root"; 
        $password = ""; 
        $dbname = "validation"; 

       
        $conn = new mysqli($servername, $username, $password, $dbname);

     
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

       
        $stmt = $conn->prepare("INSERT INTO infos (fname, lname, address, email, tel, gender) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fname, $lname, $address, $email, $tel, $gender);

        if ($stmt->execute()) {
            echo '<script type="text/javascript">';
            echo 'alert("New record created successfully");';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Error: ' . $stmt->error . '");';
            echo '</script>';
        }
       
        $stmt->close();
        $conn->close();
    }

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo '<div class="output-container">';
        echo "<h2>Input Data:</h2>";
        echo "<p>First Name: " . $fname . "</p>";
        echo "<p>Last Name: " . $lname . "</p>";
        echo "<p>Address: " . $address . "</p>";
        echo "<p>E-mail: " . $email . "</p>";
        echo "<p>Phone Number: " . $tel . "</p>";
        echo "<p>Gender: " . $gender . "</p>";
        echo '</div>';
    }
    ?>
</body>
</html>