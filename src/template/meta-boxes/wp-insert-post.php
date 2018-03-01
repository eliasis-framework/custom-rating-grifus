<?php
/**
 * Custom Rating Grifus · Extensions For Grifus
 *
 * @author    Josantonius <hello@josantonius.com>
 * @package   Josantonius/Custom-Rating-Grifus
 * @copyright 2017 - 2018 (c) Josantonius - Custom Rating Grifus
 * @license   GPL-2.0+
 * @link      https://github.com/eliasis-framework/custom-rating-grifus.git
 * @since     1.0.0
 */

use Eliasis\Framework\View;

$data = View::getOption();

$star = "<span class='custom-rating dashicons dashicons-star-filled'></span>";
?>
	
	<div class="custom-rating-grifus">
		
		<span id="efg-rating-value">0</span><br>
		
		<div class="efg-votes">
			<span id="efg-total-votes">0</span>
		</div>
	
	</div><br>

<?php foreach ( $data['votes'] as $number => $votes ) : ?>

	<label class="mtt">
		<?php echo str_repeat( $star, $number ); ?>
	</label>
	<br>
	<input class="efg-rating-input" type="number" name="efg-rating-<?php echo $number; ?>" data-star="<?php echo $number; ?>" value="<?php echo $votes; ?>">
	<br><br>

<?php endforeach; ?>

	<input type="hidden" name="efg-update-rating" value="true">
