<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Space</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <script>
        // Retrieve the username from the URL parameter using JavaScript
        const params = new URLSearchParams(window.location.search);
        const username = params.get('username');
        alert("Welcome, " + username + "!");
    </script>
    <div id="project">
        <h1>Workspace</h1>
        
        <div id="content">
            
            <form id="electionForm" action="gathering_value.php" method="post" enctype="multipart/form-data">
                <div class="inputvalues"> 
                <h2 class="discription">Here you create the election of your choice</h2>
                <h3>Enter the information to create the election</h3>
                <div class="input">
                    <input type="text" id="post" name="post" placeholder="Enter the post for which the election is held">
                    <input type="text" name="candidateName" placeholder="Enter Candidate Name">
                    <input type="submit" value="Submit">
                </div>
                    
                </div>
            </form>
        </div>
    </div>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "fsd";
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            // Prepare SQL statement to insert candidate data into database
            $stmt = $conn->prepare("INSERT INTO candidates (name, post, institute) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $post, $institute);
            
            // Get the candidate name, post from the POST data
            $name = $_POST['candidateName'];
            $post = $_POST['post'];
            $institute = "MIT"; // Example institute
            
            // Execute the prepared statement to insert candidate data into database
            if ($stmt->execute()) {
                echo "New record inserted successfully";
            } else {
                echo "Error: " . $stmt->error;
            }
            
            // Close statement
            $stmt->close();
            
            // Close connection
            $conn->close();
        }
    ?>
</body>
</html>
