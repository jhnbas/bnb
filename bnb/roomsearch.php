<?php
// Include database configuration
include "config.php";

// Get search parameters
$checkinDate = $_GET['checkinDate'];
$checkoutDate = $_GET['checkoutDate'];

// Create a new database connection
$DBC = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

// Check if the connection was successful
if ($DBC->connect_errno) {
    echo "Error: Unable to connect to MySQL. " . $DBC->connect_error;
    exit; // Stop processing the page further
}

// Prepare SQL query to search for available rooms

    $query = "SELECT*
    FROM room
    WHERE roomID NOT IN
        SELECT DISTINCT roomID
        FROM Bookings
        WHERE checkoutDate <= ? AND "




// Prepare the statement
$stmt = mysqli_prepare($DBC, $query);

// Bind parameters
mysqli_stmt_bind_param($stmt, "ss", $checkinDate, $checkoutDate); // Note the change in parameter positions

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result set
$result = mysqli_stmt_get_result($stmt);

// Check if the query was successful
if ($result) {
    // Display search result
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['roomID'] . "</td>";
            echo "<td>" . $row['roomname'] . "</td>";
            echo "<td>" . $row['checkinDate'] . "</td>";
            echo "<td>" . $row['checkoutDate'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "No available rooms found for the selected date range.";
    }
} else {
    // Handle query error
    echo "Error executing the query: " . $DBC->error;
}


// Close the statement
mysqli_stmt_close($stmt);

// Close database connection
mysqli_close($DBC);
?>
