<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer listing</title>
</head>
<body>
    <?php
    include"config.php";
    $DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
    
    // we use this because we dont want to overload the server with requests when connnection failed, it show the error message and exit the page
    if(mysqli_connect_errno()){
        echo "Error:unable to connect to MYSQL." .mysqli_connect_errno();
        exit;
    }

    // display the host information
    // echo "Connected via" .mysqli_get_host_info($DBC);
    // mysqli_close($DBC); 

    // prepare a query and send it to server
    $query = ' SELECT *
    FROM customer
    ORDER BY customerID';

    $result = mysqli_query($DBC, $query);
    $rowcount = mysqli_num_rows($result);

    ?>

    <h1>Customer Listing</h1>
    <h2>
        <a href="registercustomer.php">[Create new customer]</a>
        <a href="index.php">[Return to main page]</a>
    </h2>

    <table border= "1">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
            </tr>
        </thead>

        <?php

        if($rowcount >0){
            while ($row = mysqli_fetch_assoc($result)){
                $id = $row['customerID'];

                echo '<tr><td>'.$row['customerID']
                .'</td><td>'.$row['fname']
                .'</td><td>'.$row['lname']
                .'</td><td>'.$row['email']
                .'</td>';

                echo '</tr>' .PHP_EOL;

                }

        }else echo "<h2> No customers found!</h2>";
        mysqli_free_result($result);
        mysqli_close($DBC);
        ?>

    </table>
</body>