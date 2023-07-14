
<?php include_once("functions/class.php"); ?>
<?php
	ini_set('max_execution_time', 90000000);
?>
<?php 
	
	require __DIR__ . '/../vendor/autoload.php';
	use FuzzyWuzzy\Fuzz;
	use FuzzyWuzzy\Process;

	$brands = ["Komili","Yudum","Eti","Fellas","Yayla","Tat","Öncü","Torku","Nutella","Ace","Domestos","Freşa","Beypazarı","Duru","Nivea","La Roche Posay","Baby Turco","Jacobs","Doğuş","Lipton","Çaykur","Fairy","Copier Bond","Selpak","Nesquik","Sensodyne","Kızılay","Pınar","İçim","Palmolive"];

	$keywords_brands = ["Yağ","Yağı","Yağ","Yağı","Lifalif","Lifalifli","Gronala","Gronalası","Pirinç","Pirinci","Salça","Salçası","Salça","Salçası","Kreması","Çikolata","Kreması","Çikolata","Su","Suyu","Su","Suyu","Su","Suyu","Su","Suyu","Pirinç","Pirinci","Krem","Kremi","Krem","Kremi","Mendil","Mendili","Kahve","Kahvesi","Çay","Çayı","Çay","Çayı","Çay","Çayı","Tablet","Tableti","Kağıt","Kağıdı","Kağıt","Kağıdı","Süt","Sütü","Macun","Macunu","Su","Suyu","Süt","Süt","Süt","Süt","Jel","Jeli"];

	
	function a101_trendyol_match($a101_dizi,$trendyol_dizi,$trendyol_item_name){	

		$fuzz = new Fuzz();
		$process = new Process($fuzz);

		global $a101_item;
		global $trendyol_item;
		global $table_trendyol;
		global $table_a101;

		global $keywords_value1;
		global $keywords_value2;

		$a101_item = array();
		$trendyol_item = array();
		$table_trendyol = array();
		$table_a101 = array();

		$a101_explode = array();
		$a101_value_left = array();
		$trendyol_explode = array();

		for ($i=0; $i <sizeof($trendyol_dizi); $i++) { 
			$trendyol_explode = explode(" ", $trendyol_dizi[$i]);
			$trendyol_explode = array_filter($trendyol_explode);
			for ($j=0; $j <sizeof($a101_dizi); $j++) { 
				$a101_explode = explode(" ", $a101_dizi[$j]);

				$keywords = [$keywords_value1,$keywords_value2];				
				$key_1 = array_search($keywords[0], $a101_explode);
				$key_2 = array_search($keywords[1], $a101_explode);

				if(isset($key_1) && $key_1 >= 1){
					$a101_explode = array_filter($a101_explode);
					$value_left = $key_1+1;			
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";	
					array_push($a101_value_left, $a101_explode[$value_left]);
				}elseif(isset($key_2) && $key_2 >= 1){
					$a101_explode = array_filter($a101_explode);
					$value_left = $key_2+1;				
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";
					array_push($a101_value_left, $a101_explode[$value_left]);
				}
				else{
					$a101_explode = array_filter($a101_explode);
					$value_left = 1;
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";
					array_push($a101_value_left, $a101_explode[$value_left]);
				}

				$result = $fuzz->tokenSortRatio($trendyol_dizi[$i], $a101_dizi[$j]);
				if(($result >= 75) && (strpos($trendyol_dizi[$i],$a101_value_left[$j]) == true)){
					array_push($trendyol_item,$trendyol_dizi[$i]);
					array_push($a101_item,$a101_dizi[$j]);
					array_push($table_trendyol,'trendyol_items');
					//echo $trendyol_dizi[$i] . '-' . $a101_dizi[$j]. ' ürünleri benzerlik oranı:' . $result. '<br>';
				}
			}
		}
	}
	
	function a101_amazon_match($a101_dizi,$amazon_dizi){

		$fuzz = new Fuzz();
		$process = new Process($fuzz);

		global $a101_item2;
		global $amazon_item;
		global $table_amazon;
		global $table_a101;

		global $keywords_value1;
		global $keywords_value2;

		$a101_item2 = array();
		$amazon_item = array();
		$table_amazon = array();
		$table_a101 = array();

		$a101_explode = array();
		$a101_value_left = array();
		$amazon_explode = array();

		for ($i=0; $i <sizeof($amazon_dizi); $i++) { 
			$amazon_explode = explode(" ", $amazon_dizi[$i]);
			$amazon_explode = array_filter($amazon_explode);			
			array_push($table_a101,'a101_items');

			for ($j=0; $j <sizeof($a101_dizi); $j++) { 

				$a101_explode = explode(" ", $a101_dizi[$j]);
				$keywords = [$keywords_value1,$keywords_value2];					
				$key_1 = array_search($keywords[0], $a101_explode);
				$key_2 = array_search($keywords[1], $a101_explode);

				if(isset($key_1) && $key_1 >= 1){
					$a101_explode = array_filter($a101_explode);
					$value_left = $key_1+1;						
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";			
					array_push($a101_value_left, $a101_explode[$value_left]);
				}elseif(isset($key_2) && $key_2 >= 1){
					$a101_explode = array_filter($a101_explode);
					$value_left = $key_2+1;							
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";		
					array_push($a101_value_left, $a101_explode[$value_left]);
				}
				else{
					$a101_explode = array_filter($a101_explode);
					$value_left = 1;
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";
					array_push($a101_value_left, $a101_explode[$value_left]);
				}
				
				$result = $fuzz->tokenSortRatio($amazon_dizi[$i], $a101_dizi[$j]);

				if(($result >= 75) && (strpos($amazon_dizi[$i],$a101_value_left[$j]) == true)){
					array_push($amazon_item,$amazon_dizi[$i]);
					array_push($a101_item2,$a101_dizi[$j]);
					array_push($table_amazon,'amazon_items');
					//echo $amazon_dizi[$i] . '-' . $a101_dizi[$j]. ' ürünleri benzerlik oranı:' . $result. '<br>';
				}
			}
		}
	}		

	function a101_n11_match($a101_dizi,$n11_dizi){

		$fuzz = new Fuzz();
		$process = new Process($fuzz);

		global $a101_item3;
		global $n11_item;
		global $table_n11;
		global $table_a101;

		global $keywords_value1;
		global $keywords_value2;

		$a101_item3 = array();
		$n11_item = array();
		$table_n11 = array();
		$table_a101 = array();

		$a101_explode = array();
		$a101_value_left = array();
		$n11_explode = array();

		for ($i=0; $i <sizeof($n11_dizi); $i++) { 

			$n11_explode = explode(" ", $n11_dizi[$i]);
			$n11_explode = array_filter($n11_explode);			
			array_push($table_a101,'a101_items');
			
			for ($j=0; $j <sizeof($a101_dizi); $j++) { 

				$a101_explode = explode(" ", $a101_dizi[$j]);
				$keywords = [$keywords_value1,$keywords_value2];					
				$key_1 = array_search($keywords[0], $a101_explode);
				$key_2 = array_search($keywords[1], $a101_explode);
				if(isset($key_1) && $key_1 >= 1){
					$a101_explode = array_filter($a101_explode);
					$value_left = $key_1+1;			
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";	
					array_push($a101_value_left, $a101_explode[$value_left]);
				}elseif(isset($key_2) && $key_2 >= 1){
					$a101_explode = array_filter($a101_explode);
					$value_left = $key_2+1;	
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";			
					array_push($a101_value_left, $a101_explode[$value_left]);
				}
				else{
					$a101_explode = array_filter($a101_explode);
					$value_left = 1;
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";
					array_push($a101_value_left, $a101_explode[$value_left]);
				}
				
				$result = $fuzz->tokenSortRatio($n11_dizi[$i], $a101_dizi[$j]);
				if(($result >= 75) && (strpos($n11_dizi[$i],$a101_value_left[$j]) == true)){
					array_push($n11_item,$n11_dizi[$i]);
					array_push($a101_item3,$a101_dizi[$j]);
					array_push($table_n11,'n11_items');
					//echo $n11_dizi[$i] . '-' . $a101_dizi[$j]. ' ürünleri benzerlik oranı:' . $result. '<br>';
				}
			}
		}
	}

	function a101_ciceksepeti_match($a101_dizi,$ciceksepeti_dizi){

		$fuzz = new Fuzz();
		$process = new Process($fuzz);

		global $a101_item4;
		global $ciceksepeti_item;
		global $table_ciceksepeti;
		global $table_a101;

		global $keywords_value1;
		global $keywords_value2;

		$a101_item4 = array();
		$ciceksepeti_item = array();
		$a101_explode = array();
		$a101_value_left = array();
		$ciceksepeti_explode = array();
		$table_ciceksepeti = array();
		$table_a101 = array();
		

		for ($i=0; $i <sizeof($ciceksepeti_dizi); $i++) { 

			$ciceksepeti_explode = explode(" ", $ciceksepeti_dizi[$i]);
			$ciceksepeti_explode = array_filter($ciceksepeti_explode);			
			array_push($table_a101,'a101_items');
			
			for ($j=0; $j <sizeof($a101_dizi); $j++) { 

				$a101_explode = explode(" ", $a101_dizi[$j]);
				$keywords = [$keywords_value1,$keywords_value2];						
				$key_1 = array_search($keywords[0], $a101_explode);
				$key_2 = array_search($keywords[1], $a101_explode);
				if(isset($key_1) && $key_1 >= 1){
					$a101_explode = array_filter($a101_explode);
					$value_left = $key_1+1;			
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";	
					array_push($a101_value_left, $a101_explode[$value_left]);
				}elseif(isset($key_2) && $key_2 >= 1){
					$a101_explode = array_filter($a101_explode);
					$value_left = $key_2+1;		
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";		
					array_push($a101_value_left, $a101_explode[$value_left]);
				}
				else{
					$a101_explode = array_filter($a101_explode);
					$value_left = 1;
					$a101_explode[$value_left] = $a101_explode[$value_left] ?? "?";
					array_push($a101_value_left, $a101_explode[$value_left]);
				}
				

				$value_1 =  $ciceksepeti_dizi[$i];
				$value_2 =  $a101_dizi[$j];
				$value_1 = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $value_1), ENT_NOQUOTES, 'UTF-8');
				$value_2 = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $value_2), ENT_NOQUOTES, 'UTF-8');
				
				$result = $fuzz->tokenSortRatio($value_1,$value_2);

				if(($result > 75)  && (strpos($value_1,$a101_value_left[$j]) == true)){
					array_push($ciceksepeti_item,$ciceksepeti_dizi[$i]);
					array_push($a101_item4,$a101_dizi[$j]);
					array_push($table_ciceksepeti,"ciceksepeti_items");
					//echo $value_1. '-' . $a101_dizi[$j]. ' ürünleri benzerlik oranı:' . $result. '<br>';
				}
			}
		}
	}

	function trendyol_amazon_match($trendyol_dizi,$amazon_dizi,$trendyol_item_name){
		$fuzz = new Fuzz();
		$process = new Process($fuzz);

		global $amazon_item2;
		global $trendyol_item2;
		global $table_amazon;
		global $table_trendyol;

		global $keywords_value1;
		global $keywords_value2;

		$amazon_item2 = array();
		$trendyol_item2 = array();
		$table_amazon = array();
		$table_trendyol = array();

		$amazon_explode = array();
		$amazon_value_left = array();
		$trendyol_explode = array();

		for ($i=0; $i <sizeof($trendyol_dizi); $i++) { 
			$trendyol_explode = explode(" ", $trendyol_dizi[$i]);
			$trendyol_explode = array_filter($trendyol_explode);
			
			for ($j=0; $j <sizeof($amazon_dizi); $j++) { 
				$amazon_explode = explode(" ", $amazon_dizi[$j]);

				$keywords = [$keywords_value1,$keywords_value2];
				$key_1 = array_search($keywords[0], $amazon_explode);
				$key_2 = array_search($keywords[1], $amazon_explode);
				if(isset($key_1) && $key_1 >= 1){
					$amazon_explode = array_filter($amazon_explode);
					$value_left = $key_1+1;				
					$amazon_explode[$value_left] = $amazon_explode[$value_left] ?? "?";
					array_push($amazon_value_left, $amazon_explode[$value_left]);
				}elseif(isset($key_2) && $key_2 >= 1){
					$amazon_explode = array_filter($amazon_explode);
					$value_left = $key_2+1;				
					$amazon_explode[$value_left] = $amazon_explode[$value_left] ?? "?";
					array_push($amazon_value_left, $amazon_explode[$value_left]);
				}
				else{
					$amazon_explode = array_filter($amazon_explode);
					$value_left = 1;
					$amazon_explode[$value_left] = $amazon_explode[$value_left] ?? "?";
					array_push($amazon_value_left, $amazon_explode[$value_left]);
				}
				
				$result = $fuzz->tokenSortRatio($trendyol_dizi[$i], $amazon_dizi[$j]);
				if(($result >= 75) && (strpos($trendyol_dizi[$i],$amazon_value_left[$j]) == true)){
					array_push($trendyol_item2,$trendyol_dizi[$i]);
					array_push($amazon_item2,$amazon_dizi[$j]);
					array_push($table_amazon,'amazon_items');
					array_push($table_trendyol,'trendyol_items');
					//echo $trendyol_dizi[$i] . '-' . $amazon_dizi[$j]. ' ürünleri benzerlik oranı:' . $result. '<br>';
				}
			}
		}
	}

	function trendyol_n11_match($trendyol_dizi,$n11_dizi,$trendyol_item_name){
		$fuzz = new Fuzz();
		$process = new Process($fuzz);

		global $n11_item2;
		global $trendyol_item3;
		global $table_n11;
		global $table_trendyol;

		global $keywords_value1;
		global $keywords_value2;

		$n11_item2 = array();
		$trendyol_item3 = array();
		$table_n11 = array();
		$table_trendyol = array();

		$n11_explode = array();
		$n11_value_left = array();
		$trendyol_explode = array();

		for ($i=0; $i <sizeof($trendyol_dizi); $i++) { 
			$trendyol_explode = explode(" ", $trendyol_dizi[$i]);
			$trendyol_explode = array_filter($trendyol_explode);			
			
			for ($j=0; $j <sizeof($n11_dizi); $j++) { 
				$n11_explode = explode(" ", $n11_dizi[$j]);

				$keywords = [$keywords_value1,$keywords_value2];			
				$key_1 = array_search($keywords[0], $n11_explode);
				$key_2 = array_search($keywords[1], $n11_explode);
				if(isset($key_1) && $key_1 >= 1){
					$n11_explode = array_filter($n11_explode);
					$value_left = $key_1+1;				
					$n11_explode[$value_left] = $n11_explode[$value_left] ?? "?";
					array_push($n11_value_left, $n11_explode[$value_left]);
				}elseif(isset($key_2) && $key_2 >= 1){
					$n11_explode = array_filter($n11_explode);
					$value_left = $key_2+1;	
					$n11_explode[$value_left] = $n11_explode[$value_left] ?? "?";		
					array_push($n11_value_left, $n11_explode[$value_left]);
				}
				else{
					$n11_explode = array_filter($n11_explode);
					$value_left = 1;
					$n11_explode[$value_left] = $n11_explode[$value_left] ?? "?";
					array_push($n11_value_left, $n11_explode[$value_left]);
				}

				$result = $fuzz->tokenSortRatio($trendyol_dizi[$i], $n11_dizi[$j]);

				if(($result >= 75) && (strpos($trendyol_dizi[$i],$n11_value_left[$j]) == true)){
					array_push($trendyol_item3,$trendyol_dizi[$i]);
					array_push($n11_item2,$n11_dizi[$j]);
					array_push($table_n11,'n11_items');
					array_push($table_trendyol,'trendyol_items');
					//echo $trendyol_dizi[$i] . '-' . $n11_dizi[$j]. ' ürünleri benzerlik oranı:' . $result. '<br>';
				}
			}
		}
	}

	function trendyol_ciceksepeti_match($trendyol_dizi,$ciceksepeti_dizi,$trendyol_item_name){
		$fuzz = new Fuzz();
		$process = new Process($fuzz);

		global $ciceksepeti_item2;
		global $trendyol_item4;
		global $table_trendyol;
		global $table_ciceksepeti;

		global $keywords_value1;
		global $keywords_value2;

		$ciceksepeti_item2 = array();
		$trendyol_item4 = array();
		$table_trendyol = array();
		$table_ciceksepeti = array();

		$ciceksepeti_explode = array();
		$ciceksepeti_value_left = array();
		$trendyol_explode = array();

		for ($i=0; $i <sizeof($trendyol_dizi); $i++) { 
			$trendyol_explode = explode(" ", $trendyol_dizi[$i]);
			$trendyol_explode = array_filter($trendyol_explode);

			for ($j=0; $j <sizeof($ciceksepeti_dizi); $j++) { 
				$ciceksepeti_explode = explode(" ", $ciceksepeti_dizi[$j]);

				$keywords = [$keywords_value1,$keywords_value2];		
				$key_1 = array_search($keywords[0], $ciceksepeti_explode);
				$key_2 = array_search($keywords[1], $ciceksepeti_explode);
				if(isset($key_1) && $key_1 >= 1){
					$ciceksepeti_explode = array_filter($ciceksepeti_explode);
					$value_left = $key_1 + 1;		
					$ciceksepeti_explode[$value_left] = $ciceksepeti_explode[$value_left] ?? "?";		
					array_push($ciceksepeti_value_left, $ciceksepeti_explode[$value_left]);
				}elseif(isset($key_2) && $key_2 >= 1){
					$ciceksepeti_explode = array_filter($ciceksepeti_explode);
					$value_left = $key_2 + 1;	
					$ciceksepeti_explode[$value_left] = $ciceksepeti_explode[$value_left] ?? "?";			
					array_push($ciceksepeti_value_left, $ciceksepeti_explode[$value_left]);
				}
				else{
					$ciceksepeti_explode = array_filter($ciceksepeti_explode);
					$value_left = 1;
					$ciceksepeti_explode[$value_left] = $ciceksepeti_explode[$value_left] ?? "?";
					array_push($ciceksepeti_value_left, $ciceksepeti_explode[$value_left]);
				}

				$value_1 =  $trendyol_dizi[$i];
				$value_2 =  $ciceksepeti_dizi[$j];
				$value_1 = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $value_1), ENT_NOQUOTES, 'UTF-8');
				$value_2 = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $value_2), ENT_NOQUOTES, 'UTF-8');

				$result = $fuzz->tokenSortRatio($value_1, $value_2);

				if(($result >= 75) && (strpos($value_1,$ciceksepeti_value_left[$j]) == true)){
					array_push($trendyol_item4,$trendyol_dizi[$i]);
					array_push($ciceksepeti_item2,$ciceksepeti_dizi[$j]);
					array_push($table_ciceksepeti,'ciceksepeti_items');
					array_push($table_trendyol,'trendyol_items');
					//echo $trendyol_dizi[$i] . '-' . $ciceksepeti_dizi[$j]. ' ürünleri benzerlik oranı:' . $result. '<br>';
				}
			}
		}
	}

	
	function amazon_n11_match($amazon_dizi,$n11_dizi){
		$fuzz = new Fuzz();
		$process = new Process($fuzz);

		global $n11_item3;
		global $amazon_item3;
		global $table_n11;
		global $table_amazon;

		global $keywords_value1;
		global $keywords_value2;

		$n11_item3 = array();
		$amazon_item3 = array();
		$table_n11 = array();
		$table_amazon = array();

		$n11_explode = array();
		$n11_value_left = array();
		$amazon_explode = array();

		for ($i=0; $i <sizeof($amazon_dizi); $i++) { 
			$amazon_explode = explode(" ", $amazon_dizi[$i]);
			$amazon_explode = array_filter($amazon_explode);
			
			for ($j=0; $j <sizeof($n11_dizi); $j++) { 
				$n11_explode = explode(" ", $n11_dizi[$j]);

				$keywords = [$keywords_value1,$keywords_value2];			
				$key_1 = array_search($keywords[0], $n11_explode);
				$key_2 = array_search($keywords[1], $n11_explode);

				if(isset($key_1) && $key_1 >= 1){
					$n11_explode = array_filter($n11_explode);
					$value_left = $key_1+1;				
					$n11_explode[$value_left] = $n11_explode[$value_left] ?? "?";
					array_push($n11_value_left, $n11_explode[$value_left]);
				}elseif(isset($key_2) && $key_2 >= 1){
					$n11_explode = array_filter($n11_explode);
					$value_left = $key_2+1;
					$n11_explode[$value_left] = $n11_explode[$value_left] ?? "?";		
					array_push($n11_value_left, $n11_explode[$value_left]);
				}
				else{
					$n11_explode = array_filter($n11_explode);
					$value_left = 1;
					$n11_explode[$value_left] = $n11_explode[$value_left] ?? "?";
					array_push($n11_value_left, $n11_explode[$value_left]);
				}
				
				$result = $fuzz->tokenSortRatio($amazon_dizi[$i], $n11_dizi[$j]);
				if(($result >= 75) && (strpos($amazon_dizi[$i],$n11_value_left[$j]) == true)){
					array_push($amazon_item3,$amazon_dizi[$i]);
					array_push($n11_item3,$n11_dizi[$j]);
					array_push($table_n11,'n11_items');
					array_push($table_amazon,'amazon_items');
					
					//echo $amazon_dizi[$i] . '-' . $n11_dizi[$j]. ' ürünleri benzerlik oranı:' . $result. '<br>';
				}
			}
		}
	}

	function amazon_ciceksepeti_match($amazon_dizi,$ciceksepeti_dizi){
		$fuzz = new Fuzz();
		$process = new Process($fuzz);

		global $ciceksepeti_item3;
		global $amazon_item4;
		global $table_ciceksepeti;
		global $table_amazon;

		global $keywords_value1;
		global $keywords_value2;

		$ciceksepeti_item3 = array();
		$amazon_item4 = array();
		$table_ciceksepeti = array();
		$table_amazon = array();

		$ciceksepeti_explode = array();
		$ciceksepeti_left_value = array();
		$amazon_explode = array();

		for ($i=0; $i <sizeof($amazon_dizi); $i++) { 
			$amazon_explode = explode(" ", $amazon_dizi[$i]);
			$amazon_explode = array_filter($amazon_explode);		
			
			for ($j=0; $j <sizeof($ciceksepeti_dizi); $j++) { 
				$ciceksepeti_explode = explode(" ", $ciceksepeti_dizi[$j]);

				$keywords = [$keywords_value1,$keywords_value2];

				$key_1 = array_search($keywords[0], $ciceksepeti_explode);
				$key_2 = array_search($keywords[1], $ciceksepeti_explode);
				if(isset($key_1) && $key_1 >= 1){
					$ciceksepeti_explode = array_filter($ciceksepeti_explode);
					$value_left = $key_1 + 1;		
					$ciceksepeti_explode[$value_left] = $ciceksepeti_explode[$value_left] ?? "?";		
					array_push($ciceksepeti_left_value, $ciceksepeti_explode[$value_left]);
				}elseif(isset($key_2) && $key_2 >= 1){
					$ciceksepeti_explode = array_filter($ciceksepeti_explode);
					$value_left = $key_2 + 1;	
					$ciceksepeti_explode[$value_left] = $ciceksepeti_explode[$value_left] ?? "?";			
					array_push($ciceksepeti_left_value, $ciceksepeti_explode[$value_left]);
				}
				else{
					$ciceksepeti_explode = array_filter($ciceksepeti_explode);
					$value_left = 1;
					$ciceksepeti_explode[$value_left] = $ciceksepeti_explode[$value_left] ?? "?";
					array_push($ciceksepeti_left_value, $ciceksepeti_explode[$value_left]);
				}

				$value_1 =  $amazon_dizi[$i];
				$value_2 =  $ciceksepeti_dizi[$j];
				$value_1 = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $value_1), ENT_NOQUOTES, 'UTF-8');
				$value_2 = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $value_2), ENT_NOQUOTES, 'UTF-8');

				$result = $fuzz->tokenSortRatio($value_1, $value_2);
				
				if(($result >= 75) && (strpos($value_1,$ciceksepeti_left_value[$j]) == true)){
					array_push($amazon_item4,$amazon_dizi[$i]);
					array_push($ciceksepeti_item3,$ciceksepeti_dizi[$j]);
					array_push($table_amazon,'amazon_items');			
					array_push($table_ciceksepeti,'ciceksepeti_items');						
					//echo $amazon_dizi[$i] . '-' . $ciceksepeti_dizi[$j]. ' ürünleri benzerlik oranı:' . $result. '<br>';
				}
			}
		}
	}

	function n11_ciceksepeti_match($n11_dizi,$ciceksepeti_dizi){
		$fuzz = new Fuzz();
		$process = new Process($fuzz);

		global $n11_item4;
		global $ciceksepeti_item4;
		global $table_ciceksepeti;
		global $table_n11;

		global $keywords_value1;
		global $keywords_value2;

		$n11_item4 = array();
		$ciceksepeti_item4 = array();
		$table_ciceksepeti = array();
		$table_n11 = array();

		$ciceksepeti_explode = array();
		$ciceksepeti_left_value = array();
		$n11_explode = array();

		for ($i=0; $i <sizeof($n11_dizi); $i++) { 
			$n11_explode = explode(" ", $n11_dizi[$i]);
			$n11_explode = array_filter($n11_explode);
			array_push($table_n11,'n11_items');
			
			
			for ($j=0; $j <sizeof($ciceksepeti_dizi); $j++) { 
				$ciceksepeti_explode = explode(" ", $ciceksepeti_dizi[$j]);

				$keywords = [$keywords_value1,$keywords_value2];
							
				$key_1 = array_search($keywords[0], $ciceksepeti_explode);
				$key_2 = array_search($keywords[1], $ciceksepeti_explode);
				if(isset($key_1) && $key_1 >= 1){
					$ciceksepeti_explode = array_filter($ciceksepeti_explode);
					$value_left = $key_1 + 1;		
					$ciceksepeti_explode[$value_left] = $ciceksepeti_explode[$value_left] ?? "?";		
					array_push($ciceksepeti_left_value, $ciceksepeti_explode[$value_left]);
				}elseif(isset($key_2) && $key_2 >= 1){
					$ciceksepeti_explode = array_filter($ciceksepeti_explode);
					$value_left = $key_2 + 1;	
					$ciceksepeti_explode[$value_left] = $ciceksepeti_explode[$value_left] ?? "?";			
					array_push($ciceksepeti_left_value, $ciceksepeti_explode[$value_left]);
				}
				else{
					$ciceksepeti_explode = array_filter($ciceksepeti_explode);
					$value_left = 1;
					$ciceksepeti_explode[$value_left] = $ciceksepeti_explode[$value_left] ?? "?";
					array_push($ciceksepeti_left_value, $ciceksepeti_explode[$value_left]);
				}

				$value_1 =  $n11_dizi[$i];
				$value_2 =  $ciceksepeti_dizi[$j];
				$value_1 = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $value_1), ENT_NOQUOTES, 'UTF-8');
				$value_2 = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $value_2), ENT_NOQUOTES, 'UTF-8');

				$result = $fuzz->tokenSortRatio($value_1, $value_2);

				if(($result >= 75) && (strpos($value_1,$ciceksepeti_left_value[$j]) == true)){
					array_push($n11_item4,$n11_dizi[$i]);
					array_push($ciceksepeti_item4,$ciceksepeti_dizi[$j]);
					array_push($table_ciceksepeti,'ciceksepeti_items');
					//echo $n11_dizi[$i] . '-' . $ciceksepeti_dizi[$j]. ' ürünleri benzerlik oranı:' . $result. '<br>';
				}
			}
		}
	}

	/*
	for ($m=0; $m < sizeof($brands); $m++) { 

		$keywords_value1 = $keywords_brands[$m*2];
		$keywords_value2 = $keywords_brands[$m*2 + 1];

		trendyol_name_list_item("SELECT DISTINCT trendyol_item_name, CONCAT (trendyol_item_brand_name,' ',trendyol_item_name) as name FROM trendyol_items WHERE trendyol_item_brand_name= '$brands[$m]' AND trendyol_item_name != '0'");

		a101_list_item("SELECT DISTINCT a101_item_name FROM a101_items WHERE a101_item_name LIKE '%$brands[$m]%'");

		amazon_name_list_item("SELECT DISTINCT amazon_item_name as name FROM amazon_items WHERE amazon_item_name LIKE '%$brands[$m]%'");

		n11_name_list_item("SELECT DISTINCT n11_item_name as name FROM n11_items WHERE n11_item_name LIKE '%$brands[$m]%' AND n11_item_name != '0'");

		ciceksepeti_name_list_item("SELECT DISTINCT ciceksepeti_item_name as name FROM ciceksepeti_items WHERE ciceksepeti_item_name LIKE '%$brands[$m] %' AND ciceksepeti_item_name != '0'");

		//echo 'A101-TRENDYOL BENZERLİK KARŞILAŞTIRMASI - GÜNCEL FİYAT GÖSTERİMİ'. '<br>'. '<br>';
		a101_trendyol_match($a101_dizi,$trendyol_dizi,$trendyol_item_name);

		//echo 'A101-AMAZON BENZERLİK KARŞILAŞTIRMASI - GÜNCEL FİYAT GÖSTERİMİ'. '<br>'. '<br>';
		a101_amazon_match($a101_dizi,$amazon_dizi);

		//echo 'A101-N11 BENZERLİK KARŞILAŞTIRMASI - GÜNCEL FİYAT GÖSTERİMİ'. '<br>'. '<br>';
		a101_n11_match($a101_dizi,$n11_dizi);
		
		//echo 'A101-CİCEKSEPETİ BENZERLİK KARŞILAŞTIRMASI - GÜNCEL FİYAT GÖSTERİMİ'. '<br>'. '<br>';
		a101_ciceksepeti_match($a101_dizi,$ciceksepeti_dizi);

		$a101_all_items = array();
		$a101_all_items = array_merge($a101_item4,$a101_all_items);
		$a101_all_items = array_merge($a101_item3,$a101_all_items);
		$a101_all_items = array_merge($a101_item2,$a101_all_items);
		$a101_all_items = array_merge($a101_item,$a101_all_items);

		$other_all_items = array();
		$other_all_items = array_merge($ciceksepeti_item,$other_all_items);
		$other_all_items = array_merge($n11_item,$other_all_items);
		$other_all_items = array_merge($amazon_item,$other_all_items);
		$other_all_items = array_merge($trendyol_item,$other_all_items);

		$all_tables = array();
		$all_tables = array_merge($table_ciceksepeti,$all_tables);
		$all_tables = array_merge($table_n11,$all_tables);
		$all_tables = array_merge($table_amazon,$all_tables);
		$all_tables = array_merge($table_trendyol,$all_tables);

		for ($i=0; $i < sizeof($a101_all_items) ; $i++) {
			$first_item = $a101_all_items[$i]; 
			$second_item = $other_all_items[$i]; 
			$tables = $all_tables[$i]; 
			$object = new Obj;
			$object->first_item = $first_item;
			$object->first_item_tables = 'a101_items';
			$object->second_item = $second_item;
			$object->second_item_tables = $tables;
			//$object->create("match_products");
		}

		//echo 'TRENDYOL-AMAZON BENZERLİK KARŞILAŞTIRMASI - GÜNCEL FİYAT GÖSTERİMİ'. '<br>'. '<br>';
		trendyol_amazon_match($trendyol_dizi,$amazon_dizi,$trendyol_item_name);
	
		//echo 'TRENDYOL-N11 BENZERLİK KARŞILAŞTIRMASI - GÜNCEL FİYAT GÖSTERİMİ'. '<br>'. '<br>';
		trendyol_n11_match($trendyol_dizi,$n11_dizi,$trendyol_item_name);

		//echo 'TRENDYOL-CİCEKSEPETİ BENZERLİK KARŞILAŞTIRMASI - GÜNCEL FİYAT GÖSTERİMİ'. '<br>'. '<br>';
		trendyol_ciceksepeti_match($trendyol_dizi,$ciceksepeti_dizi,$trendyol_item_name);

		$trendyol_all_items = array();
		$trendyol_all_items = array_merge($trendyol_item4,$trendyol_all_items);
		$trendyol_all_items = array_merge($trendyol_item3,$trendyol_all_items);
		$trendyol_all_items = array_merge($trendyol_item2,$trendyol_all_items);
		
		$other_all_items2 = array();
		$other_all_items2 = array_merge($ciceksepeti_item2,$other_all_items2);
		$other_all_items2 = array_merge($n11_item2,$other_all_items2);
		$other_all_items2 = array_merge($amazon_item2,$other_all_items2);

		$all_tables = array();
		$all_tables = array_merge($table_ciceksepeti,$all_tables);
		$all_tables = array_merge($table_n11,$all_tables);
		$all_tables = array_merge($table_amazon,$all_tables);

		for ($i=0; $i < sizeof($trendyol_all_items) ; $i++) {
			$first_item = $trendyol_all_items[$i]; 
			$second_item = $other_all_items2[$i]; 
			$tables = $all_tables[$i]; 
			$object = new Obj;
			$object->first_item = $first_item;
			$object->first_item_tables = 'trendyol_items';
			$object->second_item = $second_item;
			$object->second_item_tables = $tables;
			//$object->create("match_products");
		}

		//echo 'N11-AMAZON BENZERLİK KARŞILAŞTIRMASI - GÜNCEL FİYAT GÖSTERİMİ'. '<br>'. '<br>';
		amazon_n11_match($amazon_dizi,$n11_dizi);

		//echo 'AMAZON-CİCEKSEPETİ BENZERLİK KARŞILAŞTIRMASI - GÜNCEL FİYAT GÖSTERİMİ'. '<br>'. '<br>';
		amazon_ciceksepeti_match($amazon_dizi,$ciceksepeti_dizi);

		$amazon_all_items = array();
		$amazon_all_items = array_merge($amazon_item3,$amazon_all_items);
		$amazon_all_items = array_merge($amazon_item4,$amazon_all_items);
		
		$other_all_items3 = array();
		$other_all_items3 = array_merge($n11_item3,$other_all_items3);
		$other_all_items3 = array_merge($ciceksepeti_item3,$other_all_items3);

		$all_tables = array();	
		$all_tables = array_merge($table_n11,$all_tables);	
		$all_tables = array_merge($table_ciceksepeti,$all_tables);	
		
		for ($i=0; $i < sizeof($amazon_all_items) ; $i++) {
			$first_item = $amazon_all_items[$i]; 
			$second_item = $other_all_items3[$i]; 
			$tables = $all_tables[$i]; 
			$object = new Obj;
			$object->first_item = $first_item;
			$object->first_item_tables = 'amazon_items';
			$object->second_item = $second_item;
			$object->second_item_tables = $tables;
			//$object->create("match_products");
		}

		//echo 'N11-CİCEKSEPETİ BENZERLİK KARŞILAŞTIRMASI - GÜNCEL FİYAT GÖSTERİMİ'. '<br>'. '<br>';
		n11_ciceksepeti_match($n11_dizi,$ciceksepeti_dizi);

		$n11_all_items = array();
		$n11_all_items = array_merge($n11_item4,$n11_all_items);
		
		$other_all_items4 = array();
		$other_all_items4 = array_merge($ciceksepeti_item4,$other_all_items4);
		
		$all_tables = array();
		$all_tables = array_merge($table_ciceksepeti,$all_tables);

		for ($i=0; $i < sizeof($n11_all_items) ; $i++) {
			$first_item = $n11_all_items[$i]; 
			$second_item = $other_all_items4[$i]; 
			$tables = $all_tables[$i]; 
			$object = new Obj;
			$object->first_item = $first_item;
			$object->first_item_tables = 'n11_items';
			$object->second_item = $second_item;
			$object->second_item_tables = $tables;
			//$object->create("match_products");
		}
*/
	//A101-TRENDYOL
/*
for ($m=0; $m < sizeof($brands); $m++) { 
	matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'a101_items' AND `second_item_tables` = 'trendyol_items' AND `first_item` LIKE  '%$brands[$m]%'");

	$second_item_a101 = array_unique($match_dizi);
	$second_item_a101 = array_values($second_item_a101);
	$value = $tables_second[0] ?? $tables_second[0] ?? "none";
	if($value == 'trendyol_items'){

		for ($a=0; $a < sizeof($second_item_a101); $a++) {
			matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'a101_items' AND  `first_item` =  '$second_item_a101[$a]' AND `second_item_tables` = 'trendyol_items'"); 

			$second_item_trendyol = array();
			$second_item_trendyol = array_merge($second_item_trendyol,$match_dizi_second);
		
			for ($i=0; $i< sizeof($second_item_trendyol); $i++) { 
			
				matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'trendyol_items' AND `first_item` = '$second_item_trendyol[$i]' AND `second_item_tables` = 'amazon_items'");

				$second_item_amazon = array();
				$second_item_amazon = array_merge($second_item_amazon, $match_dizi_second);	
				//echo '<br>';

				for ($j=0; $j< sizeof($second_item_amazon); $j++) { 
					matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'amazon_items' AND `first_item` = '$second_item_amazon[$j]' AND `second_item_tables` = 'n11_items'");
			
					$second_items_n11 = array();
					$second_items_n11 = array_merge($second_items_n11, $match_dizi_second);

					//echo '<br>';	
			
					for ($k=0; $k< sizeof($second_items_n11); $k++) { 
						$second_items_n11[$k] = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $second_items_n11[$k]), ENT_NOQUOTES, 'UTF-8');
						matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'n11_items' AND `first_item` = '$second_items_n11[$k]' AND `second_item_tables` = 'ciceksepeti_items'");
						
						$second_item_ciceksepeti = array();
						$second_item_ciceksepeti = array_merge($second_item_ciceksepeti, $match_dizi_second);

						$object = new Obj;
						$object->a101_product = isset($second_item_a101[$a]) ? $second_item_a101[$a] : '-';
						$object->trendyol_product = isset($second_item_trendyol[$i]) ? $second_item_trendyol[$i] : '-' ;
						$object->amazon_product = isset($second_item_amazon[$j]) ? $second_item_amazon[$j] : '-' ;
						$object->n11_product = isset($second_items_n11[$k]) ? $second_items_n11[$k] : '-' ;
						$object->ciceksepeti_product = isset($second_item_ciceksepeti[$k]) ? $second_item_ciceksepeti[$k] : '-';
						//$object->create("last_products");
						//echo '<br>';			
					}		
				}
			}
		}
	}
	
	
	//A101-AMAZON
	matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'a101_items' AND `second_item_tables` = 'amazon_items' AND `first_item` LIKE  '%$brands[$m]%'");

	$second_item_a101 = array_unique($match_dizi);
	$second_item_a101 = array_values($second_item_a101);

	$value = $tables_second[0] ?? $tables_second[0] ?? "none";

	if ($value == 'amazon_items') {

		for ($a=0; $a < sizeof($second_item_a101); $a++) {
			matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'a101_items' AND  `first_item` =  '$second_item_a101[$a]' AND `second_item_tables` = 'amazon_items'"); 

			$second_item_amazon = array();
			$second_item_amazon = array_merge($second_item_amazon, $match_dizi_second);	
			//echo '<br>';

			for ($j=0; $j< sizeof($second_item_amazon); $j++) { 
				matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'amazon_items' AND `first_item` = '$second_item_amazon[$j]' AND `second_item_tables` = 'n11_items'");
			
				$second_items_n11 = array();
				$second_items_n11 = array_merge($second_items_n11, $match_dizi_second);
			
				//echo '<br>';	
			
				for ($k=0; $k< sizeof($second_items_n11); $k++) { 
					matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'n11_items' AND `first_item` = '$second_items_n11[$k]' ");
					
					$second_item_ciceksepeti = array();
					$second_item_ciceksepeti = array_merge($second_item_ciceksepeti, $match_dizi_second);
					$object = new Obj;
					$object->a101_product = isset($second_item_a101[$a]) ? $second_item_a101[$a] : '-';
					$object->trendyol_product = '-' ;
					$object->amazon_product = isset($second_item_amazon[$j]) ? $second_item_amazon[$j] : '-' ;
					$object->n11_product = isset($second_items_n11[$k]) ? $second_items_n11[$k] : '-' ;
					$object->ciceksepeti_product = isset($second_item_ciceksepeti[$k]) ? $second_item_ciceksepeti[$k] : '-' ;
					//$object->create("last_products");
					//echo '<br>';
				}
			}
		}
	}
	
	//A101-N11

	matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'a101_items' AND `second_item_tables` = 'n11_items' AND `first_item` LIKE  '%$brands[$m]%'");
	$second_item_a101 = array_unique($match_dizi);
	$second_item_a101 = array_values($second_item_a101);

	$value = $tables_second[0] ?? $tables_second[0] ?? "none";

	if ($value == 'n11_items') {

		for ($a=0; $a < sizeof($second_item_a101); $a++) {
			matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'a101_items' AND  `first_item` =  '$second_item_a101[$a]' AND `second_item_tables` = 'n11_items'");

			$second_items_n11 = array();
			$second_items_n11 = array_merge($second_items_n11, $match_dizi_second);
			
			//echo '<br>';	
			
			for ($k=0; $k< sizeof($second_items_n11); $k++) { 
				matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'n11_items' AND `first_item` = '$second_items_n11[$k]'");
					
				$second_item_ciceksepeti = array();
				$second_item_ciceksepeti = array_merge($second_item_ciceksepeti, $match_dizi_second);

				for ($l=0; $l < sizeof($second_item_ciceksepeti); $l++) { 
					$object = new Obj;
					$object->a101_product = isset($second_item_a101[$a]) ? $second_item_a101[$a] : '-';
					$object->trendyol_product = '-' ;
					$object->amazon_product = '-' ;
					$object->n11_product = isset($second_items_n11[$k]) ? $second_items_n11[$k] : '-' ;
					$object->ciceksepeti_product = isset($second_item_ciceksepeti[$l]) ? $second_item_ciceksepeti[$l] : '-' ;
					//$object->create("last_products");
				
				//echo '<br>';
				}	
			}
		}
	}
			
	

	// TRENDYOL - AMAZON
	
	matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'trendyol_items' AND `second_item_tables` = 'amazon_items' AND `first_item` LIKE  '%$brands[$m]%'");
	
	$second_item_trendyol = array();
	$second_item_trendyol = array_unique($match_dizi);
	$second_item_trendyol = array_values($second_item_trendyol);

	for ($a=0; $a < sizeof($second_item_trendyol); $a++) {

		matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'trendyol_items' AND  `first_item` =  '$second_item_trendyol[$a]' AND `second_item_tables` = 'amazon_items'"); 

		$second_item_amazon = array();
		$second_item_amazon = array_merge($second_item_amazon, $match_dizi_second);	
		//echo '<br>';
			
		for ($j=0; $j< sizeof($second_item_amazon); $j++) { 
			matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'amazon_items' AND `first_item` = '$second_item_amazon[$j]' AND `second_item_tables` = 'n11_items'");
			
			$second_items_n11 = array();
			$second_items_n11 = array_merge($second_items_n11, $match_dizi_second);
			//echo 'N11: ' . $second_items_n11[$i];		
			
			//echo '<br>';
			for ($k=0; $k< sizeof($second_items_n11); $k++) { 
				matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'n11_items' AND `first_item` = '$second_items_n11[$k]' AND `second_item_tables` = 'ciceksepeti_items' ");
				//echo $second_items_n11[$k];
			
				$second_item_ciceksepeti = array();
				$second_item_ciceksepeti = array_merge($second_item_ciceksepeti, $match_dizi_second);
				$object = new Obj;
				$object->a101_product =  '-';
				$object->trendyol_product = isset($second_item_trendyol[$a]) ? $second_item_trendyol[$a] : '-' ;
				$object->amazon_product = isset($second_item_amazon[$j]) ? $second_item_amazon[$j] : '-' ;
				$object->n11_product = isset($second_items_n11[$k]) ? $second_items_n11[$k] : '-' ;
				$object->ciceksepeti_product = isset($second_item_ciceksepeti[$k]) ? $second_item_ciceksepeti[$k] : '-' ;
				//$object->create("last_products");				
				//echo '<br>';
			}
		}
	}

	
	// TRENDYOL - N11
	matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'trendyol_items'  AND `second_item_tables` = 'n11_items' AND `first_item` LIKE  '%$brands[$m]%'");
	
	$second_item_trendyol = array();
	$second_item_trendyol = array_unique($match_dizi);
	$second_item_trendyol = array_values($second_item_trendyol);
	
	for ($a=0; $a < sizeof($second_item_trendyol); $a++) {
		
			matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'trendyol_items' AND `first_item` = '$second_item_trendyol[$a]' AND `second_item_tables` = 'n11_items'");
			
			$second_items_n11 = array();
			$second_items_n11 = array_merge($second_items_n11, $match_dizi_second);
			//echo 'N11: ' . $second_items_n11[$i];		
			//echo '<br>';
			for ($k=0; $k< sizeof($second_items_n11); $k++) { 
				matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'n11_items' AND `first_item` = '$second_items_n11[$k]' AND `second_item_tables` = 'ciceksepeti_items' ");

				$second_item_ciceksepeti = array();
				$second_item_ciceksepeti = array_merge($second_item_ciceksepeti, $match_dizi_second);
				
				for ($l=0; $l < sizeof($second_item_ciceksepeti); $l++) { 
					$object = new Obj;
					$object->a101_product =  '-';
					$object->trendyol_product = isset($second_item_trendyol[$a]) ? $second_item_trendyol[$a] : '-' ;
					$object->amazon_product = '-' ;
					$object->n11_product = isset($second_items_n11[$k]) ? $second_items_n11[$k] : '-' ;
					$object->ciceksepeti_product = isset($second_item_ciceksepeti[$l]) ? $second_item_ciceksepeti[$l] : '-' ;
					//$object->create("last_products");
					//echo '<br>';
				}			
				
			}
		}
	
	//AMAZON - N11
	
	matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'amazon_items' AND `second_item_tables` = 'n11_items' AND `first_item` LIKE  '%$brands[$m]%'");
	
	$second_item_amazon = array();
	$second_item_amazon = array_unique($match_dizi);
	$second_item_amazon = array_values($second_item_amazon);

	for ($a=0; $a < sizeof($second_item_amazon); $a++) {

		matching_product_list_item("SELECT `first_item`, `first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'amazon_items' AND  `first_item` =  '$second_item_amazon[$a]' AND `second_item_tables` = 'n11_items'"); 

		$second_items_n11 = array();
		$second_items_n11 = array_merge($second_items_n11, $match_dizi_second);
		//echo 'N11: ' . $second_items_n11[$i];		
			
		//echo '<br>';
		for ($k=0; $k< sizeof($second_items_n11); $k++) { 
			matching_product_list_item("SELECT `first_item`,`first_item_tables`, `second_item`, `second_item_tables` FROM `match_products` WHERE `first_item_tables` = 'n11_items' AND `first_item` = '$second_items_n11[$k]' AND `second_item_tables` = 'ciceksepeti_items' ");
			
			$second_item_ciceksepeti = array();
			$second_item_ciceksepeti = array_merge($second_item_ciceksepeti, $match_dizi_second);

			for ($l=0; $l <  sizeof($second_item_ciceksepeti); $l++) { 
				$object = new Obj;
				$object->a101_product =  '-';
				$object->trendyol_product = '-' ;
				$object->amazon_product = isset($second_item_amazon[$a]) ? $second_item_amazon[$a] : '-' ;
				$object->n11_product = isset($second_items_n11[$k]) ? $second_items_n11[$k] : '-' ;
				$object->ciceksepeti_product = isset($second_item_ciceksepeti[$l]) ? $second_item_ciceksepeti[$l] : '-' ;
				//$object->create("last_products");	
				//echo '<br>';
			}
			
		}
	}
}

	for ($l=0; $l < sizeof($brands) ; $l++) { 
		echo 'A101-TRENDYOL-AMAZON-N11 ve ÇİÇEKSEPETİNDE olanlar'. '<br>'. '<br>';

	list_last_item("SELECT DISTINCT `a101_product`,`trendyol_product`,`amazon_product`,`n11_product`,`ciceksepeti_product` FROM `last_products`  WHERE `a101_product` != '-' AND `a101_product` LIKE  '%$brands[$l]%'"); //a101'de olan ürünler

	$trendyol_array = array();
	$amazon_array = array();
	$n11_array = array();
	$ciceksepeti_array = array();
	$trendyol_array = array_merge($trendyol_product);
	$amazon_array = array_merge($amazon_product);
	$n11_array = array_merge($n11_product);
	$ciceksepeti_array = array_merge($ciceksepeti_product);

	echo 'TRENDYOL-AMAZON-N11 ve ÇİÇEKSEPETİNDE olanlar' . '<br>'. '<br>';

	list_last_item("SELECT DISTINCT `a101_product`,`trendyol_product`,`amazon_product`,`n11_product`,`ciceksepeti_product` FROM `last_products`  WHERE `a101_product` = '-' AND `trendyol_product` != '-'  AND `trendyol_product` LIKE  '%$brands[$l]%'"); //a101'de olan ürünler

	$trendyol_array2 = array();
	$amazon_array2 = array();
	$n11_array2 = array();
	$ciceksepeti_array2 = array();

	$trendyol_array2 = array_merge($trendyol_product);
	$amazon_array2 = array_merge($amazon_product);
	$n11_array2 = array_merge($n11_product);
	$ciceksepeti_array2 = array_merge($ciceksepeti_product);
	
	//print_r($trendyol_array);
	//print_r($trendyol_array2);
	
	for ($k=0; $k < sizeof($trendyol_array); $k++) { 
		for ($i=0; $i < sizeof($trendyol_array2) ; $i++) { 
			if($trendyol_array[$k] == $trendyol_array2[$i] && $amazon_array[$k] == $amazon_array2[$i] && $n11_array[$k] == $n11_array2[$i] && $ciceksepeti_array[$k] == $ciceksepeti_array2[$i]){
				echo $trendyol_array2[$i] . $amazon_array2[$i] . $n11_array2[$i] . $ciceksepeti_array2[$i] . ' Sil '. '<br>' ;
			
				//list_last_item("DELETE FROM `last_products` WHERE `a101_product` = '-' AND `trendyol_product` = '$trendyol_array2[$i]' AND `amazon_product` = '$amazon_array2[$i]' AND `n11_product` = '$n11_array2[$i]' AND `ciceksepeti_product` = '$ciceksepeti_array2[$i]' "); //a101'de olan ürünler
			}elseif($trendyol_array[$k] == $trendyol_array2[$i]  && $amazon_array2[$i] = '-' && $n11_array[$k] == $n11_array2[$i] && $ciceksepeti_array[$k] == $ciceksepeti_array2[$i]){
				echo $trendyol_array2[$i] . $amazon_array2[$i] . $n11_array2[$i] . $ciceksepeti_array2[$i] . ' Sil '. '<br>' ;
				//list_last_item("DELETE FROM `last_products` WHERE `a101_product` = '-' AND `trendyol_product` = '$trendyol_array2[$i]' AND `amazon_product` = '-' AND `n11_product` = '$n11_array2[$i]' AND `ciceksepeti_product` = '$ciceksepeti_array2[$i]' "); //a101'de olan ürünler	
			}
		}
	}
	
	echo 'AMAZON-N11 ve ÇİÇEKSEPETİNDE olanlar' . '<br>';

	list_last_item("SELECT DISTINCT `a101_product`,`trendyol_product`,`amazon_product`,`n11_product`,`ciceksepeti_product` FROM `last_products`  WHERE `a101_product` = '-' AND `trendyol_product` = '-'  AND `amazon_product` LIKE  '%brands[$l]%'"); //amazon-n11-ciceksepeti'nde olan ürünler

	$trendyol_array3 = array();
	$amazon_array3 = array();
	$n11_array3 = array();
	$ciceksepeti_array3 = array();

	$trendyol_array3 = array_merge($trendyol_product);
	$amazon_array3 = array_merge($amazon_product);
	$n11_array3 = array_merge($n11_product);
	$ciceksepeti_array3 = array_merge($ciceksepeti_product);

	for ($k=0; $k < sizeof($amazon_array); $k++) { 
		for ($i=0; $i < sizeof($amazon_array3) ; $i++) { 
			if($trendyol_array[$k] ='-'  && $amazon_array[$k] == $amazon_array3[$i] && $n11_array[$k] == $n11_array3[$i] && $ciceksepeti_array[$k] == $ciceksepeti_array3[$i]){
				echo $amazon_array3[$i] . $n11_array3[$i] . $ciceksepeti_array3[$i] . 'Sil '. '<br>' ;
				//list_last_item("DELETE FROM `last_products` WHERE `a101_product` = '-' AND `trendyol_product` = '-' AND `amazon_product` = '$amazon_array3[$i]' AND `n11_product` = '$n11_array3[$i]' AND `ciceksepeti_product` = '$ciceksepeti_array3[$i]' "); //a101'de olan ürünler
			}
		}
	}
	}
	
	
*/

?>