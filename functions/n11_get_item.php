

<?php 
	function unit_n11($product_name){
			
			global $unit;
			$birim_fiyat = 1;
			if (preg_match('/\d+(\.\d+)?\s*(g|kg|gram|GRAM|GR|Gr|gr|kilogram|KG|G|Kg|ml|Ml|ML|mL|mililitre|Mililitre|MİLİLİTRE|litre|Litre|LİTRE|lt|LT|l|L|Lt)/', $product_name, $matches) ) {

		 		if (preg_match('/\d+(\.\d+)?\s*(g|G|gram|GRAM|GR|Gr|gr|ml|Ml|ML|mL|mililitre|Mililitre|MİLİLİTRE)/', $product_name, $matches2)) {
		 			$unit = intval($matches2[0]); 
		 		}else{
		 			$unit = intval($matches[0]);

		 			$unit = $unit * 1000;
		 		}
			}
			return $unit;

		}

		function unit_number_n11($product_name){
			$unit_number = 1;
			$pattern1 = '/\d+(\.\d+)?\s*(adet|Adet|tane|parça|paket|Paket|PAKET | x |x| x|Tane|TANE|ADET|Parça|Yıkama|yıkama|kullanım|Kullanım| X | X | X|Ad\.|ad\.|lı|li|lu|lü|Yaprak|yaprak|li|lı|lu|lü|Rulo|rulo)/';

			if (preg_match($pattern1, $product_name, $matches))
			{ 
		 		$unit_number = intval($matches[0]);
		 		//echo 'Adet sayısı: ' . $unit_number . '<br>';
			}
			return $unit_number;
		}
		
	function get_products_N11($conn, $key, $products_exist,$category){

		$translationTable = array(
			'ı' => 'i',
			'ç' => 'c',
			'ğ' => 'g',
			'ö' => 'o',
			'ş' => 's',
			'ü' => 'u',
			' ' => '+'
		);

		$key = strtr($key, $translationTable);
		$url = "https://www.n11.com/arama?q=". $key;
		
		
		$css_product_name = 'h3[class="productName"]';
		$css_product_price = 'ins';

		

		$context = stream_context_create(
			array(
				"http" => array(
					"header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like 			Gecko) Chrome/50.0.2661.102 Safari/537.36"
				)
			)
		);
			
		$html = file_get_html($url, false, $context);
		$products = $html->find("li[class='column']");

		foreach ($products as $product) {

			$product_rating = generateRandomRatings();

		
			$temp_html = str_get_html($product->outertext);
		
			$marketid = 5;
			$product_name = $temp_html->find($css_product_name);
			$product_price = $temp_html->find($css_product_price);
			

			$gida = ($category == "gıda") ? 1 : 0;
			$icecek = ($category == "içecek") ? 1 : 0;
			$agizbakim = ($category == "ağız bakım") ? 1 : 0;
			$ciltbakim = ($category == "cilt bakım") ? 1 : 0;
			$evbakim = ($category == "ev bakım") ? 1 : 0;
			$kirtasiye = ($category == "kırtasiye") ? 1 : 0;

			$product_name = strip_tags($product_name[0]) ?? "İsim Yok";
			$price_edits = [
				"." => "",
				"," => ".",
			];
			if(!$product_price)
				continue;
			
			$product_price = doubleval(str_replace(array_keys($price_edits), array_values($price_edits), strip_tags($product_price[0] ?? "0")));
			

		
			$unit = unit_n11($product_name);
			$unit_number = unit_number_n11($product_name);
		
			$total_unit = $unit * $unit_number;
		
			if ($total_unit == 1) {
				continue;
			}
		
			if (in_array($product_name, $products_exist)) {
				// If it exists, update the product_price
				$query = "UPDATE PRODUCT SET product_price = :product_price WHERE product_name = :product_name";
				$stmt = $conn->prepare($query);
				$stmt->bindValue(':product_name', $product_name);
				$stmt->bindValue(':product_price', $product_price);
				$stmt->execute();
		
				echo "Product updated: " . iconv("UTF-8", "CP857", $product_name) . "<br>";
			} else {
				$query = "INSERT INTO PRODUCT(marketid, product_name, product_price, product_price1, product_price2, product_price3, product_price4, product_price5, unit_number, product_rating, gida, icecek, agizbakim, ciltbakim, evbakim, kirtasiye) VALUES(:marketid, :product_name, :product_price, :product_price1, :product_price2, :product_price3, :product_price4, :product_price5, :total_unit, :product_rating, :gida, :icecek, :agizbakim, :ciltbakim, :evbakim, :kirtasiye)";
				$stmt = $conn->prepare($query);
		
				$stmt->execute([
					':marketid' => $marketid,
					':product_name' => $product_name,
					':product_price' => $product_price,
					':product_price1' => 0.00,
					':product_price2' => 0.00,
					':product_price3' => 0.00,
					':product_price4' => 0.00,
					':product_price5' => 0.00,
					':product_rating' => $product_rating,
					':total_unit' => $total_unit,
					':gida' => $gida,
					':icecek' => $icecek,
					':agizbakim' => $agizbakim,
					':ciltbakim' => $ciltbakim,
					':evbakim' => $evbakim,
					':kirtasiye' => $kirtasiye,
					
				]);
				
				echo "Product added to the database: " . iconv("UTF-8", "CP857", $product_name) . "<br>";
			}
		}

		$url2 = "https://www.n11.com/arama?q=". $key . '&ipg=2';
		$html = file_get_html($url2, false, $context);
		$products = $html->find("li[class='column']");

		foreach ($products as $product) {

			$product_rating = generateRandomRatings();

		
			$temp_html = str_get_html($product->outertext);
		
			$marketid = 5;
			$product_name = $temp_html->find($css_product_name);
			$product_price = $temp_html->find($css_product_price);
			

			$gida = ($category == "gıda") ? 1 : 0;
			$icecek = ($category == "içecek") ? 1 : 0;
			$agizbakim = ($category == "ağız bakım") ? 1 : 0;
			$ciltbakim = ($category == "cilt bakım") ? 1 : 0;
			$evbakim = ($category == "ev bakım") ? 1 : 0;
			$kirtasiye = ($category == "kırtasiye") ? 1 : 0;

			$product_name = strip_tags($product_name[0]) ?? "İsim Yok";
			$price_edits = [
				"." => "",
				"," => ".",
			];
			if(!$product_price)
				continue;
			
			$product_price = doubleval(str_replace(array_keys($price_edits), array_values($price_edits), strip_tags($product_price[0] ?? "0")));
			

		
			$unit = unit_n11($product_name);
			$unit_number = unit_number_n11($product_name);
		
			$total_unit = $unit * $unit_number;
		
			if ($total_unit == 1) {
				continue;
			}
		
			if (in_array($product_name, $products_exist)) {
				// If it exists, update the product_price
				$query = "UPDATE PRODUCT SET product_price = :product_price WHERE product_name = :product_name";
				$stmt = $conn->prepare($query);
				$stmt->bindValue(':product_name', $product_name);
				$stmt->bindValue(':product_price', $product_price);
				$stmt->execute();
		
				echo "Product updated: " . iconv("UTF-8", "CP857", $product_name) . "<br>";
			} else {
				$query = "INSERT INTO PRODUCT(marketid, product_name, product_price, product_price1, product_price2, product_price3, product_price4, product_price5, unit_number, product_rating, gida, icecek, agizbakim, ciltbakim, evbakim, kirtasiye) VALUES(:marketid, :product_name, :product_price, :product_price1, :product_price2, :product_price3, :product_price4, :product_price5, :total_unit, :product_rating, :gida, :icecek, :agizbakim, :ciltbakim, :evbakim, :kirtasiye)";
				$stmt = $conn->prepare($query);
		
				$stmt->execute([
					':marketid' => $marketid,
					':product_name' => $product_name,
					':product_price' => $product_price,
					':product_price1' => 0.00,
					':product_price2' => 0.00,
					':product_price3' => 0.00,
					':product_price4' => 0.00,
					':product_price5' => 0.00,
					':product_rating' => $product_rating,
					':total_unit' => $total_unit,
					':gida' => $gida,
					':icecek' => $icecek,
					':agizbakim' => $agizbakim,
					':ciltbakim' => $ciltbakim,
					':evbakim' => $evbakim,
					':kirtasiye' => $kirtasiye,
					
				]);
				
				echo "Product added to the database: " . iconv("UTF-8", "CP857", $product_name) . "<br>";
			}
		}

		$url3 = "https://www.n11.com/arama?q=". $key . '&ipg=2';
		$html = file_get_html($url3, false, $context);
		$products = $html->find("li[class='column']");

		foreach ($products as $product) {

			$product_rating = generateRandomRatings();

		
			$temp_html = str_get_html($product->outertext);
		
			$marketid = 5;
			$product_name = $temp_html->find($css_product_name);
			$product_price = $temp_html->find($css_product_price);
			

			$gida = ($category == "gıda") ? 1 : 0;
			$icecek = ($category == "içecek") ? 1 : 0;
			$agizbakim = ($category == "ağız bakım") ? 1 : 0;
			$ciltbakim = ($category == "cilt bakım") ? 1 : 0;
			$evbakim = ($category == "ev bakım") ? 1 : 0;
			$kirtasiye = ($category == "kırtasiye") ? 1 : 0;

			$product_name = strip_tags($product_name[0]) ?? "İsim Yok";
			$price_edits = [
				"." => "",
				"," => ".",
			];
			if(!$product_price)
				continue;
			
			$product_price = doubleval(str_replace(array_keys($price_edits), array_values($price_edits), strip_tags($product_price[0] ?? "0")));
			

		
			$unit = unit_n11($product_name);
			$unit_number = unit_number_n11($product_name);
		
			$total_unit = $unit * $unit_number;
		
			if ($total_unit == 1) {
				continue;
			}
		
			if (in_array($product_name, $products_exist)) {
				// If it exists, update the product_price
				$query = "UPDATE PRODUCT SET product_price = :product_price WHERE product_name = :product_name";
				$stmt = $conn->prepare($query);
				$stmt->bindValue(':product_name', $product_name);
				$stmt->bindValue(':product_price', $product_price);
				$stmt->execute();
		
				echo "Product updated: " . iconv("UTF-8", "CP857", $product_name) . "<br>";
			} else {
				$query = "INSERT INTO PRODUCT(marketid, product_name, product_price, product_price1, product_price2, product_price3, product_price4, product_price5, unit_number, product_rating, gida, icecek, agizbakim, ciltbakim, evbakim, kirtasiye) VALUES(:marketid, :product_name, :product_price, :product_price1, :product_price2, :product_price3, :product_price4, :product_price5, :total_unit, :product_rating, :gida, :icecek, :agizbakim, :ciltbakim, :evbakim, :kirtasiye)";
				$stmt = $conn->prepare($query);
		
				$stmt->execute([
					':marketid' => $marketid,
					':product_name' => $product_name,
					':product_price' => $product_price,
					':product_price1' => 0.00,
					':product_price2' => 0.00,
					':product_price3' => 0.00,
					':product_price4' => 0.00,
					':product_price5' => 0.00,
					':product_rating' => $product_rating,
					':total_unit' => $total_unit,
					':gida' => $gida,
					':icecek' => $icecek,
					':agizbakim' => $agizbakim,
					':ciltbakim' => $ciltbakim,
					':evbakim' => $evbakim,
					':kirtasiye' => $kirtasiye,
					
				]);
				
				echo "Product added to the database: " . iconv("UTF-8", "CP857", $product_name) . "<br>";
			}
		}

		
	}
?>