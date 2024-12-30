<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Drone Orders</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #89f7fe, #66a6ff, #d4a6ff, #ffafbd); /* Soft pastel gradient */
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            padding: 50px;
            margin: 0;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: translateY(-8px);
        }
        h1 {
            color: #3f51b5; /* Cool blue for header */
            text-align: center;
            font-size: 34px;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }
        .message {
            text-align: center;
            margin: 20px 0;
            padding: 12px;
            font-size: 18px;
            background-color: #e1f5fe;
            border-radius: 8px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
            color: #3f51b5;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"] {
            padding: 14px;
            font-size: 16px;
            border-radius: 8px;
            border: 2px solid #c5cae9; /* Light blue border */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #3f51b5;
            outline: none;
            box-shadow: 0 0 5px rgba(63, 81, 181, 0.3);
        }
        input[type="submit"] {
            padding: 12px;
            background-color: #3f51b5;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        input[type="submit"]:hover {
            background-color: #5c6bc0;
            transform: scale(1.05);
        }
        input[type="submit"]:active {
            transform: scale(0.98);
        }
        a {
            text-decoration: none;
            color: #3f51b5;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #5c6bc0;
        }
        p {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Drone Orders</h1>
        
        <?php
        // Enable error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Database configuration
        $servername = "localhost"; // Your server name
        $username = "root"; // Your database username
        $password = ""; // Your database password
        $dbname = "create_drone_orders"; // Your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password);

        // Check connection
        if ($conn->connect_error) {
            die("<div class='message'>Connection failed: " . $conn->connect_error . "</div>");
        }

        // Create database if it does not exist
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        if ($conn->query($sql) === TRUE) {
            // Database created successfully or already exists
        }

        // Select database
        $conn->select_db($dbname);

        // Create table if it does not exist
        $sql = "CREATE TABLE IF NOT EXISTS DroneOrders (
            Id INT AUTO_INCREMENT PRIMARY KEY,
            CustomerName TEXT NOT NULL,
            DroneNo INT NOT NULL,
            Destination TEXT NOT NULL,
            OrderFailure INT DEFAULT 0
        )";

        if ($conn->query($sql) !== TRUE) {
            echo "<div class='message'>Error creating table: " . $conn->error . "</div>";
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $customerName = $_POST['customerName'];
            $droneNo = $_POST['droneNo'];
            $destination = $_POST['destination'];
            $orderFailure = $_POST['orderFailure'];

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO DroneOrders (CustomerName, DroneNo, Destination, OrderFailure) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sisi", $customerName, $droneNo, $destination, $orderFailure);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<div class='message'>Order added successfully.</div>";
            } else {
                echo "<div class='message'>Error: " . $stmt->error . "</div>";
            }

            // Close statement
            $stmt->close();
        }
        ?>

        <form method="POST" action="">
            <label for="customerName">Customer Name:</label>
            <input type="text" id="customerName" name="customerName" required>

            <label for="droneNo">Drone No:</label>
            <input type="number" id="droneNo" name="droneNo" required>

            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" required>

            <label for="orderFailure">Order Failure (0 for No, 1 for Yes):</label>
            <input type="number" id="orderFailure" name="orderFailure" min="0" max="1" required>

            <input type="submit" value="Add Order">
        </form>

        <p>
            <a href="index.html">Go Back to Main Page</a>
        </p>
    </div>
</body>
</html>
