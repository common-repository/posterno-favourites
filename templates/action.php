<?php
/**
 * The template for displaying the favorite action button for listings.
 *
 * This template can be overridden by copying it to yourtheme/posterno/favourites/action.php
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

use Posterno\Favourites\Helper;
use Posterno\Favourites\User;

$is_logged_in = is_user_logged_in();

$bookmarked = User::bookmarked_listing( $data->listing_id, get_current_user_id() );

?>

<?php if ( $is_logged_in ) : ?>

<a class="pno-fav-link <?php if ( $bookmarked ) : ?>liked<?php endif; ?>" href="#" data-listing="<?php echo absint( $data->listing_id ); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'Toggle from favourites', 'posterno-favourites' ); ?>">
	<i class="fas fa-heart"></i>
</a>

<?php else : ?>

<a href="<?php echo esc_url( Helper::get_user_add_link( $data->listing_id ) ); ?>" data-listing="<?php echo absint( $data->listing_id ); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'Add to favourites', 'posterno-favourites' ); ?>">
	<i class="fas fa-heart"></i>
</a>

<?php endif; ?>
