<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Space</title>
    <link rel="stylesheet" href="style2.css">
    <script src="script2.js"></script>
</head>
<body>
    <h1>Welcome</h1>
    <div id="content">
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root"; // Replace with your database username
        $password = ""; // Replace with your database password
        $dbname = "fsd"; // Replace with your database name
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Define points for each dropdown menu selection
            $points = array(100, 75, 50, 25);
            
            // Loop through each dropdown menu
            for ($i = 1; $i <= 4; $i++) {
                // Check if a candidate is selected in the dropdown
                if (!empty($_POST['candidateSelect' . $i])) {
                    $selectedCandidate = $_POST['candidateSelect' . $i];
                    $pointsToAdd = $points[$i - 1]; // Get points for this dropdown
                    
                    // Update points of the selected candidate
                    $sql = "UPDATE candidates SET points = points + $pointsToAdd WHERE name = '$selectedCandidate'";
                    if ($conn->query($sql) === TRUE) {
                        echo "Points updated successfully for candidate: " . $selectedCandidate . "<br>";
                    } else {
                        echo "Error updating points: " . $conn->error . "<br>";
                    }
                }
            }
        }

        // Fetch posts from the database
        $sql = "SELECT DISTINCT post FROM candidates";
        $result = $conn->query($sql);
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <select id="postSelect" name="postSelect" onchange="displayPostInfo()">
                <option value="">Select the post</option> <!-- Initial option -->
                <?php
                    // Assuming $result contains the database query result
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['post']) . '">' . htmlspecialchars($row['post']) . '</option>';
                    }
                    $result->data_seek(0);
                ?>
            </select><br>
            <div id="postInfoDisplay"></div> <!-- This will display post info -->
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['postSelect'])) {
                    $selectedPost = $_POST['postSelect'];
                    $sql1 = "SELECT * FROM candidates WHERE post = '$selectedPost'";
                    $result1 = $conn->query($sql1);
        
                    if ($result1->num_rows > 0) {
                        // Loop to generate dropdown menus
                        for ($i = 1; $i <= 4; $i++) {
                            echo '<div class="pref-box">';
                            echo '<h3>Preference ' . $i . '</h3>';
                            echo '<select name="candidateSelect' . $i . '">';
                            echo '<option value="">Select the candidate</option>'; // Initial option
                            while ($row = $result1->fetch_assoc()) {
                                echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                            }
                            echo '</select>';
                            echo '</div>';
                            $result1->data_seek(0); // Reset result pointer
                        }
                    } else {
                        echo "No candidates found for this post";
                    }
                }
            ?>
            <input type="submit" value="Submit" style="margin-top:10px;">
        </form>

        <?php
            // Close connection
            $conn->close();
        ?>
    </div>
</body>
</html>
