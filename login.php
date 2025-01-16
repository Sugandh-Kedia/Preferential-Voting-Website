<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Preferential Voting</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="project">
    <h1>Preferential Voting</h1>
    <div id="content">
      <form action="login.php" method="post">
      
        <div class="inputvalues"> 
        <h2>Enter the credentials to access the server</h2>
        <div class="input">
        <label for="username">Username</label><br>
            <input type="text" id="username" name="username" placeholder="Enter Username"><br><br>
            <div class="password">
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" placeholder="Enter Your Password"><br><br>
            </div>
            <input class="button" type="submit" value="Login">
        </div>
            
        </div>
      </form>
    </div>
    <?php
        //connection to server
        $servername="localhost";
        $username="root";
        $pass="";
        $database = "fsd"; // Your MySQL database name
        $conn=mysqli_connect($servername,$username,$pass, $database);
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get username and password from form
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Check if the username is "admin"
            if ($username === "Admin" && $password === "Admin@#123") {
                // Redirect to google.com
                $redirect_url = "gathering_value.php?username=" . urlencode($username);
                header("Location: $redirect_url");
                exit();
            }

            // Prepare SQL query
            $sql = "SELECT password, Name FROM voters WHERE username = '$username'";

            // Execute query
            $result = mysqli_query($conn, $sql);

            // Check if query executed successfully
            if ($result) {
                // Fetch the password from the result set
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                    $valid_password = $row['password'];
                    $name = $row['Name'];
    
                    // Check if username and password are correct
                    if ($username === $username && $password === $valid_password) {
                        // Authentication successful
                        $redirect_url = "voting_space.php?username=" . urlencode($username);
                        header("Location: $redirect_url");
                        echo '<script>';
                        echo 'alert("Welcome: ' . $name . '")';
                        echo '</script>';
                        exit();
                    } else {
                        echo '<script>';
                        echo 'alert("Invalid username or password.");';
                        echo '</script>';
                    }
                } else {
                    echo '<script>';
                    echo 'alert("User not found.");';
                    echo '</script>';
                }
            } else {
                echo '<script>';
                echo 'alert("Error executing query.");';
                echo '</script>';
            }
        }
    ?>
</body>

</html>
