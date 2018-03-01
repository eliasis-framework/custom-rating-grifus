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

 jQuery(document).ready( function($) {

   if (typeof eliasis !== 'undefined') {
      var custom_rating_grifus_home = eliasis;
   } else {
      var custom_rating_grifus_home = customRatingGrifusHome;
   }

   function changeIMDBsingleName() {
       
      $(".dato").each(function() {
         var text = $(this).text();
         text = text.replace("IMDB", custom_rating_grifus_home.imdb_button);
         $(this).text(text);
      });
   }

   if ($(".dato").length) {
   
   	changeIMDBsingleName();
   }

});
