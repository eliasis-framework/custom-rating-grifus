<?php
/**
 * Custom Rating Grifus · Extensions For Grifus
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    GPL-2.0+
 * @link       https://github.com/Josantonius/Custom-Rating-Grifus.git
 * @since      1.0.1
 */

use Eliasis\View\View;

$data = View::get();

$star = "<span class='custom-rating dashicons dashicons-star-filled'></span>";
?>
	
	<div class="custom-rating-grifus">
		
		<span id="efg-rating-value">0</span><br>
		
		<div class="efg-votes">
			<span id="efg-total-votes">0</span>
		</div>
	
	</div><br>

<?php foreach ($data['votes'] as $number => $votes): ?>

	<label class="mtt">
		<?= str_repeat($star, $number); ?>
	</label>
	<br>
	<input class="efg-rating-input" type="number" name="efg-rating-<?= $number ?>" data-star="<?= $number ?>" value="<?= $votes ?>">
	<br><br>

<?php endforeach; ?>

	<input type="hidden" name="efg-update-rating" value="true">
