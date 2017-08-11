# CHANGELOG

## 1.0.1 - 2017-08-10

* Now, on sites that use WP Super Cache it will automatically clear cache when the ratings change.

* Added a option in the menu to set whether to restart the rating when adding a new movie.

* Added a section to manually set votes when updating movie.

* The rating has been improved on the front end.

* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->getRatingState()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->addMovieRating()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->getIp()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->getMovieRating()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->clearCache()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->getTotalVotes()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->updateRating()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->restartWhenAdd()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->setRatingAndVotes()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->addMetaBoxes()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->renderMetaBoxes()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->getDefaultVotes()` method.

* Deleted `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->setMovieRating()` method.

* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->getThemeOptions()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->getMovieVotes()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->setMovieVotes()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->setUserVote()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->getPosts()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->setRestartWhenAdd()` method.

* Deleted `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->setMovieParams()` method.
* Deleted `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->restartAllRatings()` method.
* Deleted `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->restartRating()` method.
* Deleted `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->_updateRating()` method.

* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->setOptions()` method.

* Deleted `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->restartRating()` method.

* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Launcher\Launcher->addOptions()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Launcher\Launcher->getOptions()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Launcher\Launcher->deleteOptions()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Launcher\Launcher->deleteOptions()` method.

* Added `restartWhenAdd` method in `custom-rating-grifus/public/js/custom-rating-grifus-admin.js` file.

* Added `custom-rating-grifus/src/template/meta-boxes/wp-insert-post.php` file.

## 1.0.0 - 2017-05-26

* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher` class.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->init()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->activation()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->uninstallation()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->admin()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->getRatingInstance()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->restartRating()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->admin()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->front()` method.
ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->setLanguages()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->addScripts()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->addStyles()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher\Launcher->runAjax()` method.

* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Launcher\Launcher` class.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Launcher\Launcher->createTables()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Launcher\Launcher->removeTables()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Launcher\Launcher->deletePostMeta()` method.

* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating` class.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->setMovieParams()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->setMovieRating()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->restartAllRatings()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating\Rating->restartRating()` method.

* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating` class.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->setMovieParams()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->setMovieRating()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->restartAllRatings()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->restartRating()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating\Rating->_updateRating()` method.

* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Page\CustomRating\CustomRating` class.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Page\CustomRating\CustomRating->init()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Page\CustomRating\CustomRating->setSubmenu()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Page\CustomRating\CustomRating->addScripts()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Page\CustomRating\CustomRating->addStyles()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Page\CustomRating\CustomRating->render()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Page\CustomRating\CustomRating->runAjax()` method.
* Added `ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Page\CustomRating\CustomRating->getRatingInstance()` method.

* Added `custom-rating-grifus/config/add-urls.php` file.
* Added `custom-rating-grifus/config/assets.php` file.
* Added `custom-rating-grifus/config/menu.php` file.
* Added `custom-rating-grifus/config/namespaces.php` file.
* Added `custom-rating-grifus/config/pages.php` file.
* Added `custom-rating-grifus/config/paths.php` file.
* Added `custom-rating-grifus/config/set-hooks.php` file.

* Added `custom-rating-grifus/public/css/custom-rating-grifus.css` file.
* Added `custom-rating-grifus/public/css/custom-rating-grifus-admin.css` file.

* Added `custom-rating-grifus/public/js/custom-rating-grifus.js` file.
* Added `custom-rating-grifus/public/js/custom-rating-grifus-home.js` file.
* Added `custom-rating-grifus/public/js/custom-rating-grifus-admin.js` file.

* Added `custom-rating-grifus/public/sass/front/custom-rating-grifus-admin.sass` file.
* Added `custom-rating-grifus/public/sass/front/layout/_custom-rating.sass` file.
* Added `custom-rating-grifus/public/sass/front/partials/_custom-rating-section.sass` file.

* Added `custom-rating-grifus/public/sass/admin/custom-rating-grifus.sass` file.
* Added `custom-rating-grifus/public/sass/admin/layout/_custom-rating.sass` file.
* Added `custom-rating-grifus/public/sass/admin/partials/_rating.sass` file.
* Added `custom-rating-grifus/public/sass/admin/custom/_global.sass` file.

* Added `custom-rating-grifus/resources/banner-1544x500.png` file.
* Added `custom-rating-grifus/resources/screenshot-1.png` file.
* Added `custom-rating-grifus/resources/screenshot-2.png` file.
* Added `custom-rating-grifus/resources/screenshot-3.png` file.
* Added `custom-rating-grifus/resources/screenshot-4.png` file.
* Added `custom-rating-grifus/resources/screenshot-5.png` file.
* Added `custom-rating-grifus/resources/screenshot-6.png` file.

* Added `custom-rating-grifus/src/template/layout/custom-rating.php` file.

* Added `custom-rating-grifus/src/template/pages/custom-rating.php` file.

* Added `eliasis-framework/eliasis` library.
* Added `composer/installers` library.
* Added `Josantonius/WP_Register` library.
* Added `Josantonius/Hook` library.
* Added `Josantonius/WP_Menu` library.
