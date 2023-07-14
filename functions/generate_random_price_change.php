<?php
	
	function generateRandomPriceChange($item_price) {
        $max_change_percentage = 10; // 10% change
        $max_price_change = ($item_price * $max_change_percentage) / 100;
        $price_change = mt_rand() / mt_getrandmax() * 2 - 1; // Random number between -1 and 1
        $price_change *= $max_price_change;
        $new_price = $item_price + $price_change;
        $new_price = round($new_price, 2); // Round to two decimal places
        echo $new_price . "\r\n";
        return $new_price;
    }

?>