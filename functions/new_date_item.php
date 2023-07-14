<?php
// // Database connection settings
//     $servername = "localhost";
//     $username = "root";
//     $password = "";
//     $database = "bitirme";
//     $table = "product";

// try {
   
//     try {
   
//     $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     } 

//     catch(PDOException $e) {
//         echo "Connection failed: " . $e->getMessage() . "\r\n";
//     }

//     $query = "UPDATE product SET ";
//     for ($i = 5; $i >= 2; $i--) {
//         $currentColumn = "product_price$i";
//         $previousColumn = "product_price" . ($i - 1);
        
//         $query .= "$currentColumn = $previousColumn";
        
//         if ($i != 2) {
//             $query .= ", ";
//         }
//     }
    
//     $stmt = $conn->prepare($query);
//     $stmt->execute();
    
    
//     $affectedRows = $stmt->rowCount();
//     echo "Updated $affectedRows rows.";

//     } catch (PDOException $e) {
//     echo "Error: " . $e->getMessage();
//     }
?>
