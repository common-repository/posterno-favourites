<?php
/**
 * The template for displaying the success ajax notice.
 *
 * This template can be overridden by copying it to yourtheme/posterno/favourites/added-notice.php
 *
 * HOWEVER, on occasion PNO will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @version 1.0.0
 * @package Posterno
 */

?>

<div class="alert alert-success pno-favs-notice" style="display:none;position: fixed;top: 0;z-index: 99999;width: 100%;border-radius:0;padding:1.25rem;text-align:center;" role="alert">
	<?php esc_html_e( 'Listing successfully added to your favourites.', 'posterno-favourites' ); ?>
</div>
