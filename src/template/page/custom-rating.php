<?php
/**
 * Custom Rating Grifus · Extensions For Grifus
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    GPL-2.0+
 * @link       https://github.com/Josantonius/Custom-Rating-Grifus.git
 * @since      1.0.0
 */

use Eliasis\View\View;

$data = View::get();
?>

<form enctype="multipart/form-data" id="custom-rating-grifus-form" method="post" action="">
   <div class="mdl-cell mdl-cell--8-col mdl-cell--12-col-tablet mdl-cell--8-col-desktop mdl-grid mdl-grid--no-spacing-off">
      <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-cell--12-col-desktop jst-card">
         <div class="mdl-card__title mdl-card--expand mdl-color--blue-200">
            <h2 class="mdl-card__title-text jst-card-title">
               <?= __('Custom Rating', 'extensions-for-grifus-rating') ?>
            </h2>
            <div id="spinner-grifus" class="mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active"></div>
         </div>
         <div class="jst-card-subtitle mdl-card__supporting-text mdl-color-text--grey-600">
            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-rating">
              <input type="checkbox" id="checkbox-rating" class="mdl-checkbox__input" <?= ($data['restart-when-add']) ? 'checked' : '' ?>>
              <span class="mdl-checkbox__label"><?= __('Restart rating when adding a new movie', 'extensions-for-grifus-rating') ?></span>
            </label><br /><br />
            <div class="mdl-card__actions mdl-card--border"></div>
            <?= __('Restart all IMDB ratings', 'extensions-for-grifus-rating') ?>
            <div id="tt4" class="icon material-icons info-icon">info_outline</div>
            <div class="mdl-tooltip mdl-tooltip--large" for="tt4">
            <?= __('This will reset all IMDB ratings to zero', 'extensions-for-grifus-rating') ?>
            </div>
            <div id="custom-section" class="mdl-list__item">
               <div class="custom-fields">
                  <div id="process" class="custom-fields">
                     <div id="film-rating">
                        <div id="film-rating-badge" class="material-icons g-icons picture-icon mdl-badge mdl-badge--overlap" data-badge="0">movie_filter</div>
                        <span class="grifus-span was-done"><?= __('Rating were restarted', 'extensions-for-grifus-rating') ?></span>
                        <span class="grifus-span nothing-was-done"><?= __('All ratings had already been reset', 'extensions-for-grifus-rating') ?></span><br />
                     </div>
                  </div>
                  <div class="replace-button">
                     <button id="restart-all-ratings" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        <?= __('Reset all ratings', 'extensions-for-grifus-rating') ?>
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
