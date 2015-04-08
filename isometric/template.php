<?php
/**
 * This template is loaded inside a popup object:
 *
 * $this .. A reference to the IncPopupItem object!
 *
 * Tipps: Possibly the top section "1. Prepare the variables" does not need any
 *        changes at all. The second part of the file can be changed to modify
 *        the HTML structure of the Pop-up.
 */

$style_name = 'isometric'; // Change this to match your template name.

// *****************************************************************************
// 1. Prepare the variables

$has_title = ! empty( $this->title );
$has_subtitle = ! empty( $this->subtitle );
$has_cta = ! empty( $this->cta_label ) && ! empty( $this->cta_link );
$has_img = ! empty( $this->image );
$has_buttons = $has_cta || $this->can_hide;

if ( ! $this->image_mobile && wp_is_mobile() ) { $has_img = false; }

$msg_class = '';
if ( $has_img ) {
	$img_left = ($this->image_pos == 'left');
	$msg_class .= 'img-' . $this->image_pos . ' ';
} else {
	$msg_class .= 'no-img ';
}
if ( $this->is_preview ) {
	$msg_class .= 'preview ';
	if ( ! $this->image_mobile ) {
		$msg_class .= 'mobile-no-img ';
	}
}
if ( $has_buttons ) {
	$msg_class .= 'buttons ';
}
if ( $this->round_corners ) { $msg_class .= 'rounded '; }
if ( $this->custom_size ) { $msg_class .= 'custom-size '; }
$msg_class .= 'wdpu-' . $this->id . ' ';

$move_class = '';

/**
 * Allow users to manually position a Pop-up.
 * Return value should be an array that defines either left/right/top/bottom.
 * Important: Filter is only used when PopUp uses a custom size!
 *
 * Example:
 * return array( 'left' => '20%', 'top' => '50px' );
 *
 * @var   false|array
 * @since 4.6.1.2
 */
$pos = false;
$pos_style = '';
if ( $this->custom_size ) {
	$pos = apply_filters( 'popup-template-position', $pos, $this->id, $this );

	if ( is_array( $pos ) ) {
		$pos_style .= 'position:absolute;';
		$msg_class .= 'custom-pos ';

		if ( isset( $pos['left'] ) || isset( $pos['right'] ) ) {
			isset( $pos['left'] ) && $pos_style .= 'left:' . $pos['left'] . ';';
			isset( $pos['right'] ) && $pos_style .= 'right:' . $pos['right'] . ';';
			$move_class .= 'no-move-x ';
			$pos_style .= 'margin-left:0;margin-right:0;';
		}
		if ( isset( $pos['top'] ) || isset( $pos['bottom'] ) ) {
			isset( $pos['top'] ) && $pos_style .= 'top:' . $pos['top'] . ';';
			isset( $pos['bottom'] ) && $pos_style .= 'bottom:' . $pos['bottom'] . ';';
			$move_class .= 'no-move-y ';
			$pos_style .= 'margin-top:0;margin-bottom:0;';
		}
	} else {
		$move_class = 'no-move-x ';
	}
} else {
	$move_class = 'no-move-x ';
}

/**
 * Allow users to add a custom CSS class to the Pop-up.
 * Needed for Upfront integration!
 *
 * @var   string
 * @since 4.6.1.2
 */
$classes = $this->custom_class;
if ( $has_title ) { $classes[] = 'with-title'; }
else { $classes[] = 'no-title'; }
if ( $has_subtitle ) { $classes[] = 'with-subtitle'; }
else { $classes[] = 'no-subtitle'; }

$msg_class .= implode(
	' ',
	apply_filters( 'popup-template-class', $classes, $this->id, $this )
);

/**
 * This determines if the PopUp is initially hidden on the page.
 * Needed for Upfront integration!
 *
 * @var   bool
 * @since 4.8.0.0
 */
$layer_style = 'display:none;';
if ( $this->show_on_load ) {
	$layer_style = '';
}
$layer_style = apply_filters( 'popup-layer-style', $layer_style, $this->id, $this );


// *****************************************************************************
// 2. Output the actual Popup code

?>
<div id="<?php echo esc_attr( $this->code->id ); ?>"
	class="style-<?php echo esc_attr( $style_name ); ?> wdpu-container wdpu-background <?php echo esc_attr( $msg_class ); ?>"
	style="<?php echo esc_attr( $layer_style ); ?>">

	<div class="wdpu-msg resize move <?php echo esc_attr( $move_class ); ?>" style="<?php echo esc_attr( $pos_style ); ?>">
		<a href="#" class="wdpu-close" title="<?php _e( 'Close this box', PO_LANG ); ?>"></a>

		<div class="wdpu-msg-inner resize">
			<?php if ( $has_img && $img_left ) : ?>
			<div class="wdpu-image">
				<img src="<?php echo esc_url( $this->image ); ?>" />
			</div>
			<?php endif; ?>

			<div class="wdpu-text">
				<div class="wdpu-inner <?php if ( ! $has_buttons ) { echo esc_attr( 'no-bm' ); } ?>">
					<div class="wdpu-head">
						<div class="wdpu-title">
							<?php echo esc_html( $this->title ); ?>
						</div>
						<div class="wdpu-subtitle">
							<?php echo esc_html( $this->subtitle ); ?>
						</div>
					</div>
					<div class="wdpu-content">
						<?php echo '' . apply_filters( 'the_content', $this->content ); ?>
					</div>
				</div>

				<?php if ( $has_buttons ) : ?>
					<div class="wdpu-buttons">
						<?php if ( $has_cta ) : ?>
							<a href="<?php echo esc_url( $this->cta_link ); ?>" class="wdpu-cta">
								<?php echo esc_html( $this->cta_label ); ?>
							</a>
						<?php endif; ?>

						<?php if ( $this->can_hide ) : ?>
						<a href="#" class="wdpu-hide-forever">
							<?php _e( 'Never see this message again.', PO_LANG ); ?>
						</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $has_img && ! $img_left ) : ?>
			<div class="wdpu-image">
				<img src="<?php echo esc_url( $this->image ); ?>" />
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>