<html>
<head>
    <title>My Web Page</title>
</head>
<body>
    <?php
    // Fetching the EC2 Availability Zone
    $availabilityZone = file_get_contents("http://169.254.169.254/latest/meta-data/placement/availability-zone");
    echo "<p>EC2 Availability Zone: " . $availabilityZone . "</p>";

    // Fetching the EC2 instance ID
    $instanceId = file_get_contents("http://169.254.169.254/latest/meta-data/instance-id");
    echo "<p>EC2 Instance ID: " . $instanceId . "</p>";

    // Database connection details
    $host = 'my-db.ctjqojps0rjn.us-gov-west-1.rds.amazonaws.com'; // Replace with your database host
    $dbname = 'database-1'; // Replace with your database name
    $user = 'admin'; // Replace with your database user
    $password = '1qaz2wsx'; // Replace with your database password

    // Perform a DNS lookup to get the IP address of the RDS instance
    $rds_ip = gethostbyname($host);

    // Display the Database IP and Endpoint
    echo "<p>Database IP: " . $rds_ip . "</p>";
    echo "<p>Database Endpoint: " . $host . "</p>";

    // Create connection
    $conn = new mysqli($host, $user, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo "<p>Database Connection: Failed (" . $conn->connect_error . ")</p>";
    } else {
        echo "<p>Database Connection: Successful</p>";
        // You can also show more information as needed, just be careful not to display sensitive data.
    }
    
     // If the form is submitted, insert comment into database
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if delete button is clicked
        if (isset($_POST["delete_comment"])) {
            $commentId = $_POST["comment_id"];

            // Prepare SQL statement to delete comment
            $sql = "DELETE FROM comments WHERE id = '$commentId'";

            if ($conn->query($sql) === TRUE) {
                echo "Comment deleted successfully";
                // Optionally, you can redirect the user to a different page after deletion
                // header("Location: your_page.php");
            } else {
                echo "Error deleting comment: " . $conn->error;
            }
        } else { // Insert new comment if delete button is not clicked
            $name = $_POST['name'];
            $email = $_POST['email'];
            $comment = $_POST['comment'];

            // Prepare SQL statement to insert comment
            $sql = "INSERT INTO comments (name, email, comment) VALUES ('$name', '$email', '$comment')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    <button id="loadTestButton">Start Load Test</button>
    // Fetch comments from database
    $sql = "SELECT * FROM comments";
    $result = $conn->query($sql);

    // Display comments
    if ($result->num_rows > 0) {
        echo "<h2>Comments:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>Name:</strong> " . $row["name"] . "</p>";
            echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
            echo "<p><strong>Comment:</strong> " . $row["comment"] . "</p>";
            // Display delete button for each comment
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
            echo "<input type='hidden' name='comment_id' value='" . $row["id"] . "'>";
            echo "<input type='submit' name='delete_comment' value='Delete'>";
            echo "</form>";
            echo "<hr>";
        }
    } else {
        echo "No comments yet.";
    }

    // Close the database connection
    $conn->close();

    // The file list code
    $efs_directory = '/var/www/html/efs'; // This is the mounted EFS directory

    echo '<h2>File List from EFS:</h2>';
    $files = array_diff(scandir($efs_directory), array('..', '.'));

    echo '<ul>';
    foreach ($files as $file) {
        $safe_file = htmlspecialchars($file);
        $urlencoded_file = urlencode($file);
        // Ensure you have a PHP script to handle the download if you are not linking directly to the files
        echo "<li><a href='download.php?file={$urlencoded_file}' target='_blank'>{$safe_file}</a></li>";
    }
    echo '</ul>';
    ?>

    <h2>Add a Comment:</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        <label for="comment">Comment:</label><br>
        <textarea name="comment" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" value="Submit">
    </form>

    <script>
    document.getElementById('loadTestButton').addEventListener('click', function() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'load_test.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert('Load test started.');
            }
        }
        xhr.send();
    });
    </script>
</body>
</html>
