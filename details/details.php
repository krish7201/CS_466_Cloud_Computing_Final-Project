<?php
    session_start();
    date_default_timezone_set("America/Chicago");
    $con = mysqli_connect('34.135.227.45', 'root', '6XoQjMTo', 'cs466db');
    if ($con) {#echo "Connection Successful ";
        if (isset($_POST['submit'])) { #echo "Submit pressed ";
            $_SESSION['timerStart'] = microtime(true);
            if (isset($_POST['warehouseSelection']) && isset($_POST['districtSelection']) && isset($_POST['customerSelection'])) {
                #Initialize Variables
                $warehouseSelection = $_POST['warehouseSelection'];
                $districtSelection = $_POST['districtSelection'];
                $customerSelection = $_POST['customerSelection'];
                $custDisc = 0;
                $orderNumber = mysqli_num_rows(mysqli_query($con, "SELECT * from orders")) + 1;
                $dateOrder = date("Y-m-d h:i:s");
                $wTax; $dTax;
                $priceAllItems = 0;
                $executionStatus = 1;
                $errMsgCredit = ""; $errMsgInsfStock = "";

                echo "<!DOCTYPE html>";
                echo "<html>";
                    echo "<head>";
                        echo "<link rel='stylesheet' type='text/css' href='styles.css'>"; 
                        echo "<title>Order Details</title>";
                    echo "</head>";

                    echo "<body style = 'color:white'>";
                        echo "<h1 style='margin-top: 0px;margin-bottom: 0px;'>TPC-C Benchmark using Google Services - New Order Transaction</h1>";

                        echo "<table><tbody>";
                            echo "<tr><th></th>";
                            echo "<th></th>";
                            echo "<th colspan = '2'>New Order</th></tr>";

                            ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            ////INSERT TO ORDERS (DISTRICT NUM, WAREHOUSE NUM, CUSTOMER NUM, NULL, NULL, NULL, NULL)
                            ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            #order is submitted only once
                            $insert = "INSERT INTO orders(O_D_ID, O_W_ID, O_C_ID, O_ENTRY_D, O_CARRIER_ID, O_OL_CNT, O_ALL_LOCAL) values($districtSelection, $warehouseSelection, $customerSelection, NULL, NULL, NULL, NULL)";
                            if ($con->query($insert) === TRUE) {} //submitted successfully
                            else {} //submitted unsuccessfully

                            ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            ////INSERT TO NEW_ORDER (ORDER NUM, DISTRICT NUM, WAREHOUSE NUM)
                            ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            #new order is submitted only once
                            $insert = "INSERT INTO new_order(NO_O_ID, NO_D_ID, NO_W_ID) values($orderNumber, $districtSelection, $warehouseSelection)";
                            if ($con->query($insert) === TRUE) {} //submitted successfully
                            else {} //submitted unsuccessfully

                            $count = 0; 

                            ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            ////INSERT TO ORDER_LINE (ORDER NUM, DISTRICT NUM, WAREHOUSE NUM, ROW NUM FROM ORDER_LINE + 1, ITEM 
                            ////ID, WAREHOUSE NUM, NULL, QUANTITY OF ITEM, NULL, NULL                            
                            ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            for ($x = 0; $x < 5; $x++) {     
                                #new order is submitted only once
                                $rowcount = mysqli_num_rows(mysqli_query($con, "SELECT * from order_line"));   

                                $itemID = $_POST["OL_I_ID_" . $x];
                                $warehouseID = $_POST["OL_SUPPLY_W_ID_" . $x];
                                $itemQuantity = $_POST["OL_QUANTITY_" . $x];

                                $insert = "INSERT INTO order_line(OL_O_ID, OL_D_ID, OL_W_ID, OL_NUMBER, OL_I_ID, OL_SUPPLY_W_ID, OL_DELIVERY_D, OL_QUANTITY, OL_AMOUNT, OL_DIST_INFO) values($orderNumber, $districtSelection, $warehouseSelection, $rowcount + 1, $itemID, $warehouseID, NULL, $itemQuantity, NULL, NULL)";
                                if ($con->query($insert) === TRUE) {} //submitted successfully
                                else {} //submitted unsuccessfully
                                $count++;
                            }

                            ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            ////INSERT TO ORDER_LINE (ORDER NUM, DISTRICT NUM, WAREHOUSE NUM, ROW NUM FROM ORDER_LINE + 1, ITEM 
                            ////ID, WAREHOUSE NUM, NULL, QUANTITY OF ITEM, NULL, NULL                            
                            ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            #For all entries past the 5th entry (required)
                            for ($x = 0; $x < 10; $x++) {
                                if (empty($_POST["OL_I_ID_" . $x + 5]) || empty($_POST["OL_QUANTITY_" . $x + 5]) || empty($_POST["OL_SUPPLY_W_ID_" . $x + 5])) {}
                                else {
                                    $rowcount = mysqli_num_rows(mysqli_query($con, "SELECT * from order_line"));  
                                        
                                    $itemID = $_POST["OL_I_ID_" . $x + 5];
                                    $warehouseID = $_POST["OL_SUPPLY_W_ID_" . $x + 5];
                                    $itemQuantity = $_POST["OL_QUANTITY_" . $x + 5];

                                    $insert = "INSERT INTO order_line(OL_O_ID, OL_D_ID, OL_W_ID, OL_NUMBER, OL_I_ID, OL_SUPPLY_W_ID, OL_DELIVERY_D, OL_QUANTITY, OL_AMOUNT, OL_DIST_INFO) values($orderNumber, $districtSelection, $warehouseSelection, $rowcount + 1, $itemID, $warehouseID, NULL, $itemQuantity, NULL, NULL)";
                                    if ($con->query($insert) === TRUE) {} //submitted successfully
                                    else {} //submitted unsuccessfully
                                    $count++;
                                }
                            }

                            #######################################################################################################
                            #PRINT ROW 2 (CUSTOMER ID, CUSTOMER NAME, CREDIT, DISCOUNT)
                            #######################################################################################################
                            #echo "Top 2 Entries are set";
                            echo "<tr><th>" . "Warehouse: " .  $warehouseSelection . "</th>" .
                                "<th>" . "District: " .  $districtSelection . "</th>" . 
                                "<th colspan = '2'>" . "Date: " . $dateOrder . "</th></tr>";

                            #######################################################################################################
                            #PRINT ROW 3 (CUSTOMER ID, CUSTOMER NAME, CREDIT, DISCOUNT)
                            #######################################################################################################
                            #echo "Customer selection set.";
                            $query = $con->query("SELECT * FROM customer WHERE C_ID = $customerSelection");
                            while ($row = $query->fetch_assoc()) {
                                $custDisc = $row["C_DISCOUNT"];
                                echo "<tr><td>" . "Customer ID: " . $customerSelection . 
                                "</td><td>" . "Name: " . $row["C_FIRST"] . " " . $row["C_MIDDLE"] . " " . $row["C_LAST"] .  
                                "</td><td>" . "Credit: " . $row["C_CREDIT"] .  
                                "</td><td>" . "Discount: " . $custDisc .  
                                "</td></tr>" . "<br></br>";
                                if($row["C_CREDIT"] == "GC") {
                                    $executionStatus = 1;
                                } else {
                                    $executionStatus = 0;
                                    $errMsgCredit = "Customer has insufficient credit to make purchase. ";
                                }
                            }

                            #######################################################################################################
                            #PRINT ROW 4 (ORDER NUMBER, NUMBER OF LINES, WAREHOUSE TAX, DISTRICT TAX)
                            #######################################################################################################
                            $query = $con->query("SELECT * FROM district WHERE D_ID = $districtSelection");
                            while ($row = $query->fetch_assoc()) {$dTax = $row["D_TAX"];}

                            $query = $con->query("SELECT * FROM warehouse WHERE W_ID = $warehouseSelection");
                            while ($row = $query->fetch_assoc()) {$wTax = $row["W_TAX"];}

                            echo "<tr><th>" . "Order Number: " .  $orderNumber . "</th>" .
                                "<th>" . "Number of Lines: " .  $count . "</th>" . 
                                "<th>" . "W_tax: " . $wTax . "</th>" . 
                                "<th>" . "D_tax: " . $dTax . "</th></tr>";

                            #######################################################################################################
                            #PRINT ROW 5 (COLUMN LABELS)
                            #######################################################################################################
                            echo "</tbody></table><br>" . "<table><tbody>" . "<tr>" . "<th>Supp_W</th>" . "<th>Item_ID</th>" .
                                "<th>Item_Name</th>" . "<th>Qty</th>" . "<th>Stock</th>" . "<th>B/G</th>" . "<th>Price</th>" . 
                                "<th>Amount</th>" . "</tr>";

                            #######################################################################################################
                            #PRINT ROW 6 + [EACH ITEM NAME ORDERED] (FOLLOWS COLUMN LABELING ABOVE)
                            #######################################################################################################
                            #new order is submitted only once
                            $query = $con->query("SELECT * FROM order_line WHERE OL_O_ID = $orderNumber");

                            while ($row = $query->fetch_assoc()) {

                                $BG;
                                $suppW = $row["OL_W_ID"]; 
                                $itemID = $row["OL_I_ID"]; 
                                $itemQuantity = $row["OL_QUANTITY"];
                                $queryTemp = $con->query("SELECT * FROM item WHERE I_ID = $itemID");

                                while ($row = $queryTemp->fetch_assoc()) {
                                    $itemName = $row["I_NAME"];
                                    $itemPrice = round(($row["I_PRICE"] - ($row["I_PRICE"] * $custDisc)) + 
                                                    ($row["I_PRICE"] * ($dTax + $wTax)), 2);
                                }

                                $queryTemp = $con->query("SELECT * FROM stock WHERE S_W_ID = $warehouseSelection AND S_I_ID = $itemID");
                                while ($row = $queryTemp->fetch_assoc()) {$itemStock = $row["S_QUANTITY"];}

                                $totalPriceItem = round($itemQuantity * $itemPrice, 2); 
                                $priceAllItems = round($totalPriceItem + $priceAllItems, 2);

                                if((int)$itemQuantity > (int)$itemStock) {$BG = "B"; $executionStatus = 0; $errMsgInsfStock = "Warehouse has insufficient stock for items indicated B.";} 
                                else {$BG = "G";}

                                echo "<tr><th>" .  $suppW . "</th>" .
                                    "<th>" . $itemID . "</th>" . 
                                    "<th>" . $itemName . "</th>" . 
                                    "<th>" . $itemQuantity . "</th>" .
                                    "<th>" . $itemStock . "</th>" . 
                                    "<th>" . $BG . "</th>" . 
                                    "<th>" . $itemPrice . "</th>" .
                                    "<th>" . $totalPriceItem . "</th></tr>";
                            }

                            #######################################################################################################
                            #PRINT ROW 6 + [EACH ITEM NAME ORDERED] + 1 (FOLLOWS COLUMN LABELING ABOVE)
                            #######################################################################################################
                            if($executionStatus == 1) {
                                echo "<tr>" .
                                "<th colspan = '3'>Execution Status: New Order Transaction executed successfully!</th>" .
                                "<th colspan = '3'></th>" .
                                "<th colspan = '2'>" . $priceAllItems . "</th>" .
                                "</tr>";

                            } else {
                                echo "<tr>" .
                                "<th colspan = '3'>Execution Status: New Order Transaction executed unsuccessfully.</th>" .
                                "<th colspan = '3'></th>" .
                                "<th colspan = '2'>" . $priceAllItems . "</th>" .
                                "</tr>";
                            }
                            

                            #######################################################################################################
                            #PRINT ROW 6 + [EACH ITEM NAME ORDERED] + 2 (FOLLOWS COLUMN LABELING ABOVE)
                            #######################################################################################################
                            if ($errMsgCredit == "") {
                                $_SESSION['timerEnd'] = microtime(true);
                                $_SESSION['time'] = $_SESSION['timerEnd'] - $_SESSION['timerStart'];
                                echo "<tr>" .
                                    "<th colspan = '3'>" . $errMsgInsfStock . "</th>" .
                                    "<th colspan = '5'>Total processing time: " . round($_SESSION['time'], 2) . "ms</th>" .
                                    "</tr>" . "</tbody></table><br>";
                            } 
                            else if ($errMsgInsfStock == "") {
                                $_SESSION['timerEnd'] = microtime(true);
                                $_SESSION['time'] = $_SESSION['timerEnd'] - $_SESSION['timerStart'];
                                echo "<tr>" .
                                    "<th colspan = '3'>" . $errMsgCredit . "</th>" .
                                    "<th colspan = '5'>Total processing time: " . round($_SESSION['time'], 2) . "ms</th>" .
                                    "</tr>" . "</tbody></table><br>";
                            } else {
                                $_SESSION['timerEnd'] = microtime(true);
                                $_SESSION['time'] = $_SESSION['timerEnd'] - $_SESSION['timerStart'];
                                echo "<tr>" .
                                    "<th colspan = '3'>" . $errMsgCredit . "<br>" . $errMsgInsfStock . "</th>" .
                                    "<th colspan = '5'>Total processing time: " . round($_SESSION['time'], 2) . "ms</th>" .
                                    "</tr>" . "</tbody></table><br>";
                            }
                                        
                        echo "<button onclick='window.location.href= &#039 //localhost/index.php &#039 '>Start New Transaction</button><br></br>";

                    echo "</body>";
                echo "</html>";
            } else{} #echo "warehouse selection, district selection, and customer selection not set";
        } else{} #echo "Submit not pressed"; 
    } else{} #echo "Connection Unsucessful"; 
    $con->close();
?>