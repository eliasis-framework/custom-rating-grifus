/**
 * Custom Rating Grifus · Extensions For Grifus
 *
 * @author    Josantonius <hello@josantonius.com>
 * @package   Josantonius/Custom-Rating-Grifus
 * @copyright 2017 - 2018 (c) Josantonius - Custom Rating Grifus
 * @license   GPL-2.0+
 * @link      https://github.com/eliasis-framework/custom-rating-grifus.git
 * @since     1.0.2
 */
 
(function ($) {
    
   $(document).ready(function () {

      if (typeof eliasis !== 'undefined') {
        var custom_rating_grifus_edit_post = eliasis;
      } else {
        var custom_rating_grifus_edit_post = customRatingGrifusEditPost;
      }

      setMovieRating();

      addRatingTab();

      disableFormElements();

      $(".efg-rating-input").on("keyup",  function() { 

        if (this.value !== "") {

          if (!isInt(this.value) || this.value < 0) {

            this.value = 0;
          }
        } 

        setMovieRating();
        
      });

      $(".efg-rating-input").on("blur",  function() { 

        this.value = (this.value == "") ? 0 : this.value;
      });

      $("#rating-tab").on("click",  function() { 
        
        document.getElementById("info_movie-rating-movie").scrollIntoView();
      });

      /**
       * Disable form elements.
       *
       * @since 1.0.2
       */
      function disableFormElements() {

        $( "#imdbRating, #imdbVotes" ).prop( "disabled", true );
      }

      /**
       * Add rating tab.
       *
       * @since 1.0.2
       */
      function addRatingTab() {

        $("#info_movie-info-movie > div > div.menus_mt_datos > ul").append(
          '<li>' +
            '<a id="rating-tab" href="#rating">' +
                custom_rating_grifus_edit_post.rating +
            '</a>' +
          '</li>'
        );
      }

      /**
       * Count votes.
       *
       * @since 1.0.2
       */
      function calculateRating() {

        var votes      = 0;
        var rating     = 0;
        var totalVotes = 0;

        $('input.efg-rating-input').each(function() {

            if (isInt(this.value)) {

                votes = parseInt(this.value, 10);

                totalVotes += votes;

                rating += $(this).data('star') * votes;
            }
        });

        rating = rating / totalVotes;

        rating = (rating > 0) ? rating : 0;

        rating = (isFloat(rating)) ? parseFloat(rating).toFixed(1) : parseInt(rating, 10);

        return {

          rating:rating, 
          totalVotes:totalVotes + ' ' + custom_rating_grifus_edit_post.votes
        };
      }

      /**
       * Get movie rating.
       *
       * @since 1.0.2
       */
      function setMovieRating() {

        var response = calculateRating();

        $("#efg-total-votes").text(response['totalVotes']);
        $("#efg-rating-value").text(response['rating']);
      }

      /**
       * Check if number is float.
       *
       * @since 1.0.2
       */
      function isFloat(n) {
        
        return Number(n) === n && n % 1 !== 0;
      }

      /**
       * Check if number is int.
       *
       * @since 1.0.2
       */
      function isInt(n) {
        
        return !isNaN(parseInt(n, 10));
      }

   });

})(jQuery);
