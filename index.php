<?php include_once("functions/class.php"); ?>
<?php include_once("simple_html_dom.php"); ?>

<?php include("functions/n11_get_item.php"); ?>
<?php include("functions/ciceksepeti_get_item.php"); ?>
<?php include("functions/amazon_get_item.php"); ?>
<?php include("functions/trendyol_get_item.php"); ?>
<?php include("functions/a101_get_item.php"); ?>

<?php include("functions/product_date_history.php"); ?>

<?php

// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "bitirme";
$table = "product";

$keywords = ["yayla pirinç","nutella çikolata", "Sensodyne diş macunu","pınar süt","Selpak tuvalet kağıdı","copierbond kağıt","lipton çay","çaykur çay","fairy bulaşık tableti","jacobs kahve","baby turco ıslak mendil","la roche güneş kremi","duru pirinç","tat salça","öncü salça","Palmolive duş jeli","beypazarı maden suyu","kızılay maden suyu","torku çikolata","yudum ayçiçek yağı","komili ayçiçek yağı","fellas granola","eti granola","nesquik süt","elidor şampuan","sütaş peynir","balküpü şeker","domestos çamaşırsuyu","ace çamaşırsuyu","omo deterjan","marmarabirlik zeytin"];

$categories = ["gıda","gıda", "ağız bakım","içecek","ev bakım","kırtasiye","içecek","içecek","ev bakım","içecek","ev bakım","cilt bakım","gıda","gıda","gıda","cilt bakım","içecek","içecek","gıda","gıda","gıda","gıda","gıda","içecek","cilt bakım","gıda","gıda","ev bakım","ev bakım","ev bakım","gıda"];

$products_CICEKSEPETI = array();
$products_AMAZON = array();
$products_A101 = array();
$products_TRENDYOL = array();
$products_N11 = array();

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
	// Fetch items from the database
    $get_ciceksepeti_products = "SELECT * FROM $table WHERE marketid = 1";
    $stmt = $conn->query($get_ciceksepeti_products);
    
    // Check if any items are found
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$products_CICEKSEPETI[] = $row["product_name"];
        }
    } else {
        //echo "Ciceksepeti Database is Empty.". "\r\n";
    }

	// Fetch items from the database
    $get_amazon_products = "SELECT * FROM $table WHERE marketid = 2";
    $stmt = $conn->query($get_amazon_products);
    
    // Check if any items are found
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$products_AMAZON[] = $row["product_name"];
        }
    } else {
        //echo "Amazon Database is Empty.". "\r\n";
    }

    // Fetch items from the database
    $get_a101_products = "SELECT * FROM $table WHERE marketid = 3";
    $stmt = $conn->query($get_a101_products);
    
    // Check if any items are found
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$products_A101[] = $row["product_name"];
        }
    } else {
        //echo "A101 Database is Empty.". "\r\n";
    }

	// Fetch items from the database
    $get_trendyol_products = "SELECT * FROM $table WHERE marketid = 4";
    $stmt = $conn->query($get_trendyol_products);
    
    // Check if any items are found
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$products_TRENDYOL[] = $row["product_name"];
        }
    } else {
       // echo "Trendyol Database is Empty.". "\r\n";
    }

	// Fetch items from the database
    $get_n11_products = "SELECT * FROM $table WHERE marketid = 5";
    $stmt = $conn->query($get_n11_products);
    
    // Check if any items are found
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$products_N11[] = $row["product_name"];
        }
    } else {
        //echo "N11 Database is Empty.". "\r\n";
    }

	
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\r\n";
}

foreach($keywords as $index => $keyword){
	exit;
	$category = $categories[$index];

	try {
    	get_products_AMAZON($conn, $keyword, $products_AMAZON,$category);
	} 

	catch (Exception $e) {
   		Echo 'Amazon -- Bağlantı Hatası'. '<br>';
	}

	try {
    	get_products_CICEKSEPETI($conn, $keyword, $products_CICEKSEPETI,$category);
	} 

	catch (Exception $e) {
   		Echo 'Çiçek Sepeti -- Bağlantı Hatası'. '<br>';
	}

	try {
    	get_products_A101($conn, $keyword, $products_A101,$category);
	} 

	catch (Exception $e) {
   		Echo 'A101 -- Bağlantı Hatası'. '<br>';
	}

	try {
    	get_products_N11($conn, $keyword, $products_CICEKSEPETI,$category);
	} 

	catch (Exception $e) {
   		Echo 'N11 -- Bağlantı Hatası'. '<br>';
	}

	try {
    	get_products_TRENDYOL($conn, $keyword, $products_TRENDYOL,$category);
	} 

	catch (Exception $e) {
   		Echo 'Trendyol -- Bağlantı Hatası' . '<br>';
	}

}

$conn = null;
?>
	
