<?php
    session_start();
    date_default_timezone_set("America/Chicago");
    $con = mysqli_connect('34.135.227.45', 'root', '6XoQjMTo', 'cs466db');
    if ($con) {#Connection Successful
        #collect statements
        $numWarehouses = mysqli_num_rows(mysqli_query($con, "SELECT * from warehouse"));
        $numDistricts = mysqli_num_rows(mysqli_query($con, "SELECT * from district"));
        $numCustomers = mysqli_num_rows(mysqli_query($con, "SELECT * from customer"));
        $numItems = mysqli_num_rows(mysqli_query($con, "SELECT * from item"));

        #essentially straight HTML
        echo "<html>";
            echo "<head>";
                echo "<link rel='stylesheet' type='text/css' href='styles.css'>"; 
                echo "<title>New Order Input page</title>";
            echo "</head>";

            echo "<body style='color:white;'>";
                echo "<h1 style='margin-bottom: 18px;'>TPC-C Benchmark using Google Services</h1>";
                echo "<form action='details/details.php' method='POST'>";
                    
                    echo "Select Warehouse: <input type='number' name='warehouseSelection' required min = 1 max = " . $numWarehouses . "><br></br>";
                    echo "Select District: <input type='number' name='districtSelection' required min = 1 max = " . $numDistricts . "><br></br>";
                    echo "Select Customer: <input type='number' name = 'customerSelection' required min = 1 max = " . $numCustomers . "><br></br>";
                        
                    echo "<table id = 'itemInfoTable'><tbody>";
                        echo "<tr><th>OL_I_ID</th>";
                        echo "<th>OL_SUPPLY_W_ID</th>";
                        echo "<th>OL_QUANTITY</th></tr>";
                        
                        echo "<tr><td><input type='number' name = 'OL_I_ID_0' required min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_0' required min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_0' required min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_1' required min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_1' required min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_1' required min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_2' required min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_2' required min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_2' required min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_3' required min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_3' required min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number'name = 'OL_QUANTITY_3' required min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_4' required min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_4' required min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_4' required min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_5' min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_5' min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_5' min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_6' min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_6' min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_6' min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_7' min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_7' min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_7' min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_8' min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_8' min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_8' min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_9' min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_9' min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_9' min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_10' min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_10' min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_10' min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_11' min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_11' min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_11' min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_12' min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_12' min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_12' min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_13' min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_13' min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_13' min = 0 max = 9999></td></tr>";

                        echo "<tr><td><input type='number' name = 'OL_I_ID_14' min = 1 max = " . $numItems . "></td>";
                        echo "<td><input type='number' name = 'OL_SUPPLY_W_ID_14' min = 1 max = " . $numWarehouses . "></td>";
                        echo "<td><input type='number' name = 'OL_QUANTITY_14' min = 0 max = 9999></td></tr>";

                    echo "</tbody></table><br>";
                echo "<input type='submit' name='submit' value='Perform New Order Transaction'><br></br></form>";
            echo "</body>";
        echo "</html>";
    }
    $con->close();
?>