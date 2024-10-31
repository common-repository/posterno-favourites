<?php
/**
 * The template for displaying the list of favourites into the frontend dashboard.
 *
 * This template can be overridden by copying it to yourtheme/posterno/favourites/dashboard-list.php
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

use Posterno\Favourites\FavouritesList;
use Posterno\Favourites\User;

$user_id = get_current_user_id();

$not_found_message = esc_html__( 'Your favourites list is currently empty.', 'posterno-favourites' );

$list = User::get_list( $user_id );

?>

<h2><?php esc_html_e( 'Favourites', 'posterno-favourites' ); ?></h2>

<?php
	//phpcs:ignore
	if ( isset( $_GET['bookmark'] ) && $_GET['bookmark'] === 'removed' ) {
		posterno()->templates
			->set_template_data(
				[
					'type'    => 'success',
					'message' => esc_html__( 'Listing successfully removed from your favourites.', 'posterno-favourites' ),
				]
			)
			->get_template_part( 'message' );
	}
?>

<?php if ( $list instanceof FavouritesList && ! empty( $list->get_listings() ) ) : ?>

	<table class="table table-bordered mt-3">
		<thead>
			<tr>
				<th scope="col"><?php esc_html_e( 'Listing', 'posterno-favourites' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Actions', 'posterno-favourites' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $list->get_listings() as $listing_id ) : ?>
				<tr>
					<td class="align-middle">
						<a href="<?php echo esc_url( get_permalink( $listing_id ) ); ?>"><?php echo esc_html( get_the_title( $listing_id ) ); ?></a>
					</td>
					<td class="align-middle">
						<a class="btn btn-danger btn-sm" href="#" role="button" data-toggle="modal" data-target="#favs-delete-modal-<?php echo esc_attr( $listing_id ); ?>"><?php esc_html_e( 'Remove', 'posterno-favourites' ); ?></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php foreach ( $list->get_listings() as $modal_listing_id ) : ?>
		<div class="modal fade" id="favs-delete-modal-<?php echo esc_attr( $modal_listing_id ); ?>" tabindex="-1" role="dialog" aria-labelledby="favs-delete-modal-title-<?php echo esc_attr( $modal_listing_id ); ?>" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<form method="POST">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="favs-delete-modal-title-<?php echo esc_attr( $modal_listing_id ); ?>"><?php esc_html_e( 'Are you sure?', 'posterno-favourites' ); ?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p><?php printf( __( 'Are you sure you want to remove the listing <strong>"%s"</strong> from your favourites?', 'posterno-favourites' ), get_the_title( $modal_listing_id ) ); ?></p>
						</div>
						<div class="modal-footer">
							<input type="submit" name="pno_favs_removal_submit" class="btn btn-danger" value="<?php esc_html_e( 'Remove listing', 'posterno-favourites' ); ?>" />
						</div>
					</div>
					<input type="hidden" name="listing_id" value="<?php echo esc_attr( $modal_listing_id ); ?>" />
					<?php wp_nonce_field( 'removing_bookmark_from_dashboard', 'dashboard_favs_removal_nonce' ); ?>
				</form>
			</div>
		</div>
	<?php endforeach; ?>

	<?php else : ?>

		<?php

		$data = [
			'message' => $not_found_message,
			'type'    => 'info',
		];

		posterno()->templates
			->set_template_data( $data )
			->get_template_part( 'message' );

		?>

	<?php endif; ?>
