
<?php include("generate_random_price_change.php"); ?>


<?php 

	// Database connection configuration
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "bitirme";
	$table = "product";


	try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
	} catch(PDOException $e) {
   		echo "Connection failed: " . $e->getMessage() . "\r\n";
	}

	
	// $query_trendyol = "SELECT  CONCAT(t1.`trendyol_item_brand_name`, t1.`trendyol_item_name`) as name, t1.`trendyol_item_price`,
    //     MAX(CASE WHEN MONTH(t1.`trendyol_item_date`) = 2 THEN t1.`trendyol_item_price` END) AS product1,
    //     MAX(CASE WHEN MONTH(t1.`trendyol_item_date`) = 3 THEN t1.`trendyol_item_price` END) AS product2,
    //     MAX(CASE WHEN MONTH(t1.`trendyol_item_date`) = 4 THEN t1.`trendyol_item_price` END) AS product3,
    //     MAX(CASE WHEN MONTH(t1.`trendyol_item_date`) = 5 THEN t1.`trendyol_item_price` END) AS product4,
    //     MAX(CASE WHEN MONTH(t1.`trendyol_item_date`) = 6 THEN t1.`trendyol_item_price` END) AS product5
    // FROM trendyol_items_3 t1
    // INNER JOIN (
    //     SELECT `trendyol_item_name`, YEAR(`trendyol_item_date`) AS year, MONTH(`trendyol_item_date`) AS month, MAX(`trendyol_item_date`) AS latest_date
    //     FROM trendyol_items
    //     GROUP BY `trendyol_item_name`, YEAR(`trendyol_item_date`), MONTH(`trendyol_item_date`)
    // ) t2 ON t1.`trendyol_item_name` = t2.`trendyol_item_name` AND YEAR(t1.`trendyol_item_date`) = t2.year AND MONTH(t1.`trendyol_item_date`) = t2.month AND t1.`trendyol_item_date` = t2.latest_date
    // GROUP BY t1.`trendyol_item_name`";

    // try {
	//     // Prepare and execute the query_trendyol
	//     $stmt = $conn->prepare($query_trendyol);
	//     $stmt->execute();

	//     // Fetch the results
	//     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	//     // Update the 'product' table with the latest prices
	//     $updateQuery = "UPDATE product SET product_price1 = ?, product_price2 = ?, product_price3 = ?, product_price4 = ?, product_price5 = ? WHERE product_name = ?";
	//     $updateStmt = $conn->prepare($updateQuery);
	//     foreach ($results as $row) {

	   
	//         $updateStmt->execute([$row['product1'], $row['product2'], $row['product3'], $row['product4'], $row['product5'],$row['name']]);
	//     }

	//     echo "Updated 'product' table with latest prices successfully.\n";
	// } catch (PDOException $e) {
    // 	die("Error: " . $e->getMessage());
	// }

    // $query_a101 = "SELECT t1.`a101_item_name`, t1.`a101_item_price`,
    //     MAX(CASE WHEN MONTH(t1.`a101_item_date`) = 2 THEN t1.`a101_item_price` END) AS product1,
    //     MAX(CASE WHEN MONTH(t1.`a101_item_date`) = 3 THEN t1.`a101_item_price` END) AS product2,
    //     MAX(CASE WHEN MONTH(t1.`a101_item_date`) = 4 THEN t1.`a101_item_price` END) AS product3,
    //     MAX(CASE WHEN MONTH(t1.`a101_item_date`) = 5 THEN t1.`a101_item_price` END) AS product4,
    //     MAX(CASE WHEN MONTH(t1.`a101_item_date`) = 6 THEN t1.`a101_item_price` END) AS product5
    // FROM a101_items t1
    // INNER JOIN (
    //     SELECT `a101_item_name`, YEAR(`a101_item_date`) AS year, MONTH(`a101_item_date`) AS month, MAX(`a101_item_date`) AS latest_date
    //     FROM a101_items
    //     GROUP BY `a101_item_name`, YEAR(`a101_item_date`), MONTH(`a101_item_date`)
    // ) t2 ON t1.`a101_item_name` = t2.`a101_item_name` AND YEAR(t1.`a101_item_date`) = t2.year AND MONTH(t1.`a101_item_date`) = t2.month AND t1.`a101_item_date` = t2.latest_date
    // GROUP BY t1.`a101_item_name`";

    // try {
    //     // Prepare and execute the query_a101
    //     $stmt = $conn->prepare($query_a101);
    //     $stmt->execute();

    //     // Fetch the results
    //     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     // Update the 'product' table with the latest prices
    //     $updateQuery = "UPDATE product SET product_price1 = ?, product_price2 = ?, product_price3 = ?, product_price4 = ?, product_price5 = ? WHERE product_name = ?";
    //     $updateStmt = $conn->prepare($updateQuery);
    //     foreach ($results as $row) {

    //         $row['a101_item_name'] = trim($row['a101_item_name']);

    //         $updateStmt->execute([$row['product1'], $row['product2'], $row['product3'], $row['product4'], $row['product5'],$row['a101_item_name']]);
    //     }

    //     echo "Updated 'product' table with latest prices successfully.\n";
    // } catch (PDOException $e) {
    //     die("Error: " . $e->getMessage());
    // }

    // $query_n11 = "SELECT t1.`n11_item_name`, t1.`n11_item_price`,
    //     MAX(CASE WHEN MONTH(t1.`n11_item_date`) = 2 THEN t1.`n11_item_price` END) AS product1,
    //     MAX(CASE WHEN MONTH(t1.`n11_item_date`) = 3 THEN t1.`n11_item_price` END) AS product2,
    //     MAX(CASE WHEN MONTH(t1.`n11_item_date`) = 4 THEN t1.`n11_item_price` END) AS product3,
    //     MAX(CASE WHEN MONTH(t1.`n11_item_date`) = 5 THEN t1.`n11_item_price` END) AS product4,
    //     MAX(CASE WHEN MONTH(t1.`n11_item_date`) = 6 THEN t1.`n11_item_price` END) AS product5
    // FROM n11_items t1
    // INNER JOIN (
    //     SELECT `n11_item_name`, YEAR(`n11_item_date`) AS year, MONTH(`n11_item_date`) AS month, MAX(`n11_item_date`) AS latest_date
    //     FROM n11_items
    //     GROUP BY `n11_item_name`, YEAR(`n11_item_date`), MONTH(`n11_item_date`)
    // ) t2 ON t1.`n11_item_name` = t2.`n11_item_name` AND YEAR(t1.`n11_item_date`) = t2.year AND MONTH(t1.`n11_item_date`) = t2.month AND t1.`n11_item_date` = t2.latest_date
    // GROUP BY t1.`n11_item_name`";

    // try {
    //     // Prepare and execute the query_n11
    //     $stmt = $conn->prepare($query_n11);
    //     $stmt->execute();

    //     // Fetch the results
    //     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     // Update the 'product' table with the latest prices
    //     $updateQuery = "UPDATE product SET product_price1 = ?, product_price2 = ?, product_price3 = ?, product_price4 = ?, product_price5 = ? WHERE product_name = ?";
    //     $updateStmt = $conn->prepare($updateQuery);
    //     foreach ($results as $row) {

       
    //         $updateStmt->execute([$row['product1'], $row['product2'], $row['product3'], $row['product4'], $row['product5'],$row['n11_item_name']]);
    //     }

    //     echo "Updated 'product' table with latest prices successfully.\n";
    // } catch (PDOException $e) {
    //     die("Error: " . $e->getMessage());
    // }

    
    //  $query_amazon = "SELECT t1.`amazon_item_name`, t1.`amazon_item_price`,
    //     MAX(CASE WHEN MONTH(t1.`amazon_item_date`) = 2 THEN t1.`amazon_item_price` END) AS product1,
    //     MAX(CASE WHEN MONTH(t1.`amazon_item_date`) = 3 THEN t1.`amazon_item_price` END) AS product2,
    //     MAX(CASE WHEN MONTH(t1.`amazon_item_date`) = 4 THEN t1.`amazon_item_price` END) AS product3,
    //     MAX(CASE WHEN MONTH(t1.`amazon_item_date`) = 5 THEN t1.`amazon_item_price` END) AS product4,
    //     MAX(CASE WHEN MONTH(t1.`amazon_item_date`) = 6 THEN t1.`amazon_item_price` END) AS product5
    // FROM amazon_items t1
    // INNER JOIN (
    //     SELECT `amazon_item_name`, YEAR(`amazon_item_date`) AS year, MONTH(`amazon_item_date`) AS month, MAX(`amazon_item_date`) AS latest_date
    //     FROM amazon_items
    //     GROUP BY `amazon_item_name`, YEAR(`amazon_item_date`), MONTH(`amazon_item_date`)
    // ) t2 ON t1.`amazon_item_name` = t2.`amazon_item_name` AND YEAR(t1.`amazon_item_date`) = t2.year AND MONTH(t1.`amazon_item_date`) = t2.month AND t1.`amazon_item_date` = t2.latest_date
    // GROUP BY t1.`amazon_item_name`";

    // try {
    //     // Prepare and execute the query_n11
    //     $stmt = $conn->prepare($query_amazon);
    //     $stmt->execute();

    //     // Fetch the results
    //     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     // Update the 'product' table with the latest prices
    //     $updateQuery = "UPDATE product SET product_price1 = ?, product_price2 = ?, product_price3 = ?, product_price4 = ?, product_price5 = ? WHERE product_name = ?";
    //     $updateStmt = $conn->prepare($updateQuery);
    //     foreach ($results as $row) {

       
    //         $updateStmt->execute([$row['product1'], $row['product2'], $row['product3'], $row['product4'], $row['product5'],$row['amazon_item_name']]);
    //     }

    //     echo "Updated 'product' table with latest prices successfully.\n";
    // } catch (PDOException $e) {
    //     die("Error: " . $e->getMessage());
    // }


    //  $query_ciceksepeti = "SELECT t1.`ciceksepeti_item_name`, t1.`ciceksepeti_item_price`,
    //     MAX(CASE WHEN MONTH(t1.`ciceksepeti_item_date`) = 2 THEN t1.`ciceksepeti_item_price` END) AS product1,
    //     MAX(CASE WHEN MONTH(t1.`ciceksepeti_item_date`) = 3 THEN t1.`ciceksepeti_item_price` END) AS product2,
    //     MAX(CASE WHEN MONTH(t1.`ciceksepeti_item_date`) = 4 THEN t1.`ciceksepeti_item_price` END) AS product3,
    //     MAX(CASE WHEN MONTH(t1.`ciceksepeti_item_date`) = 5 THEN t1.`ciceksepeti_item_price` END) AS product4,
    //     MAX(CASE WHEN MONTH(t1.`ciceksepeti_item_date`) = 6 THEN t1.`ciceksepeti_item_price` END) AS product5
    // FROM ciceksepeti_items t1
    // INNER JOIN (
    //     SELECT `ciceksepeti_item_name`, YEAR(`ciceksepeti_item_date`) AS year, MONTH(`ciceksepeti_item_date`) AS month, MAX(`ciceksepeti_item_date`) AS latest_date
    //     FROM ciceksepeti_items
    //     GROUP BY `ciceksepeti_item_name`, YEAR(`ciceksepeti_item_date`), MONTH(`ciceksepeti_item_date`)
    // ) t2 ON t1.`ciceksepeti_item_name` = t2.`ciceksepeti_item_name` AND YEAR(t1.`ciceksepeti_item_date`) = t2.year AND MONTH(t1.`ciceksepeti_item_date`) = t2.month AND t1.`ciceksepeti_item_date` = t2.latest_date
    // GROUP BY t1.`ciceksepeti_item_name`";

    // try {
    //     // Prepare and execute the query_n11
    //     $stmt = $conn->prepare($query_ciceksepeti);
    //     $stmt->execute();

    //     // Fetch the results
    //     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     // Update the 'product' table with the latest prices
    //     $updateQuery = "UPDATE product SET product_price1 = ?, product_price2 = ?, product_price3 = ?, product_price4 = ?, product_price5 = ? WHERE product_name = ?";
    //     $updateStmt = $conn->prepare($updateQuery);
    //     foreach ($results as $row) {

       
    //         $updateStmt->execute([$row['product1'], $row['product2'], $row['product3'], $row['product4'], $row['product5'],$row['ciceksepeti_item_name']]);
    //     }

    //     echo "Updated 'product' table with latest prices successfully.\n";
    // } catch (PDOException $e) {
    //     die("Error: " . $e->getMessage());
    // }
    
// Prepare the SQL statement
    $sql = "SELECT * FROM PRODUCT";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iterate over the products
    foreach ($products as $product) {
        $productId = $product['productid'];
        $productPrice1 = $product['product_price1'];
        $productPrice2 = $product['product_price2'];
        $productPrice3 = $product['product_price3'];
        $productPrice4 = $product['product_price4'];
        $productPrice5 = $product['product_price5'];

        // Check if product_price1 is NULL and update it using the function
        if ($productPrice1 == 0 || is_null($productPrice1)) {
            $newPrice = generateRandomPriceChange($product['product_price']);
            $sql = "UPDATE PRODUCT SET product_price1 = :new_price WHERE productid = :productid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':new_price', $newPrice);
            $stmt->bindParam(':productid', $productId);
            $stmt->execute();
        }
        if ($productPrice2 == 0 || is_null($productPrice2)) {
            $newPrice = generateRandomPriceChange($product['product_price']);
            $sql = "UPDATE PRODUCT SET product_price2 = :new_price WHERE productid = :productid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':new_price', $newPrice);
            $stmt->bindParam(':productid', $productId);
            $stmt->execute();
        }
    
    if ($productPrice3 == 0 || is_null($productPrice3)) {
            $newPrice = generateRandomPriceChange($product['product_price']);
            $sql = "UPDATE PRODUCT SET product_price3 = :new_price WHERE productid = :productid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':new_price', $newPrice);
            $stmt->bindParam(':productid', $productId);
            $stmt->execute();
        }
    if ($productPrice4 == 0 || is_null($productPrice4)) {
            $newPrice = generateRandomPriceChange($product['product_price']);
            $sql = "UPDATE PRODUCT SET product_price4 = :new_price WHERE productid = :productid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':new_price', $newPrice);
            $stmt->bindParam(':productid', $productId);
            $stmt->execute();
        }
        if ($productPrice5 == 0 || is_null($productPrice5)) {
            $newPrice = generateRandomPriceChange($product['product_price']);
            $sql = "UPDATE PRODUCT SET product_price5 = :new_price WHERE productid = :productid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':new_price', $newPrice);
            $stmt->bindParam(':productid', $productId);
            $stmt->execute();
        }
    
    
    }

?>