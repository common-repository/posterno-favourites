<?php
/**
 * The template for displaying the favorite action button for listings.
 *
 * This template can be overridden by copying it to yourtheme/posterno/favourites/button.php
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

use Posterno\Favourites\User;
use Posterno\Favourites\Helper;

$listing_id = get_queried_object_id();

?>

<?php if ( User::bookmarked_listing( $listing_id, get_current_user_id() ) ) : ?>

	<a class="pno-fav-button" href="<?php echo esc_url( Helper::get_user_listing_removal_link( $listing_id, get_current_user_id() ) ); ?>">
		<i class="fas fa-heart mr-1"></i>
		<span><?php esc_html_e( 'Remove from favourites', 'posterno-favourites' ); ?></span>
	</a>

<?php elseif ( is_user_logged_in() ) : ?>

	<a class="pno-fav-button" href="<?php echo esc_url( Helper::get_user_add_link( $listing_id ) ); ?>">
		<i class="fas fa-heart mr-1"></i>
		<span><?php esc_html_e( 'Add to favourites', 'posterno-favourites' ); ?></span>
	</a>

<?php else : ?>

	<a class="pno-fav-button" href="<?php echo esc_url( Helper::get_user_add_link( $listing_id ) ); ?>">
		<i class="fas fa-heart mr-1"></i>
		<span><?php esc_html_e( 'Add to favourites', 'posterno-favourites' ); ?></span>
	</a>

<?php endif; ?>
