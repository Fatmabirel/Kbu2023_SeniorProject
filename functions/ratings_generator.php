<?php
	
	function generateRandomRatings($minRating = 1, $maxRating = 5) {

	   	global $rating;
	    $rating = rand($minRating, $maxRating);	        
	    return $rating;
	}

		
?>
