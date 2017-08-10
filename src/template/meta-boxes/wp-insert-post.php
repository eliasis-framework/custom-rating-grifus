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

$styles = "style='color: #ffb900; font-size: 17px;'";

$star = "<span class='dashicons dashicons-star-filled' $styles></span>";

foreach ($data['votes'] as $number => $votes): ?>

	<label class="mtt">
		<?= str_repeat($star, $number); ?>
	</label>
	<br>
	<input type="number" name="efg-rating-<?= $number ?>" value="<?= $votes ?>">
	<br><br>

<?php endforeach; ?>

	<input type="hidden" name="efg-update-rating" value="true">
