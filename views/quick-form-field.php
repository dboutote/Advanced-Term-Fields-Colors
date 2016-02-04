<?php
/**
 * Quick-edit form view
 *
 * Displays the form field for quick-editing terms.
 *
 * @package Advanced_Term_Fields
 * @subpackage Adv_Term_Fields_Colors\Views
 *
 * @since 0.1.0
 */
?>
<input id="inline-<?php echo esc_attr( $this->meta_key ); ?>" type="text" class="ptitle" name="<?php echo esc_attr( $this->meta_key ); ?>" value="" size="20" />