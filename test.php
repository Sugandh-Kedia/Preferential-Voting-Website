<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "fsd"; // Replace with your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch image data from database
        $sql = "SELECT photo FROM candidates WHERE name = 'Sugandh Kedia'";
        $result = $conn->query($sql);
    ?>
    <div>
        <h1>Retrieve Images from Database using PHP</h1>
        <div>
            <?php if($result->num_rows > 0){ ?>
            <div>
                <?php while($row = $result->fetch_assoc()){ ?>
                    <img src="data:image/jpg;charset=utf8;base64, <?php echo base64_encode($row['photo']); ?>" />
                <?php } ?>
            </div>
            <?php }else{ ?>
            <p class="status error">Image(s) not found...</p>
            <?php } ?>
        </div>
    </div>
    <?php
        // Close connection
        $conn->close();
    ?>
</body>
</html>
