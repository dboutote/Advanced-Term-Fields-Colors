<?php
/**
 * Edit form view
 *
 * Displays the form field for editing terms.
 *
 * @package Advanced_Term_Fields
 * @subpackage Adv_Term_Fields_Colors\Views
 *
 * @since 0.1.0
 */

$meta_value = $this->get_meta( $term->term_id ); 
?>
<div id="atf-color-meta-wrap" class="color-meta-wrap">
	<input name="<?php echo esc_attr( $this->meta_key ); ?>" id="<?php echo esc_attr( $this->meta_key ); ?>" type="text" value="<?php echo $meta_value; ?>" size="20" />
</div>