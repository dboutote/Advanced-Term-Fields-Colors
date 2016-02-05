<?php

/**
 * Adv_Term_Fields_Colors Class
 *
 * Adds colors for taxonomy terms.
 *
 * @package Advanced_Term_Fields
 * @subpackage Adv_Term_Fields_Colors
 *
 * @since 0.1.0
 *
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * Adds colors for taxonomy terms
 *
 * @version 1.0.0
 *
 * @since 0.1.0
 *
 */
final class Adv_Term_Fields_Colors extends Advanced_Term_Fields
{

	/**
	 * Version number
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public $version = '0.1.0';


	/**
	 * Metadata database key
	 *
	 * For storing/retrieving the meta value.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public $meta_key = 'term_color';


	/**
	 * Unique singular slug for meta type
	 *
	 * Used in localizing js files.
	 *
	 * @see Adv_Term_Fields_Colors::enqueue_admin_scripts()
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public $data_type = 'color';


	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param string $file Full file path to calling plugin file
	 */
	public function __construct( $file = '' )
	{
		parent::__construct( $file );
	}


	/**
	 * Loads the class
	 *
	 * @uses Advanced_Term_Fields::show_custom_column()
	 * @uses Advanced_Term_Fields::show_custom_fields()
	 * @uses Advanced_Term_Fields::register_meta()
	 * @uses Advanced_Term_Fields::load_admin_functions()
	 * @uses Advanced_Term_Fields::process_term_meta()
	 * @uses Advanced_Term_Fields::filter_terms_query()
	 * @uses Advanced_Term_Fields::$allowed_taxonomies
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 */
	public function init()
	{
		$this->show_custom_column( $this->allowed_taxonomies );
		$this->show_custom_fields( $this->allowed_taxonomies );
		$this->register_meta();
		$this->load_admin_functions();
		$this->process_term_meta();
		$this->filter_terms_query();
		$this->show_inner_fields();
	}


	/**
	 * Sets labels for form fields
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 */
	public function set_labels()
	{
		$this->labels = array(
			'singular'    => esc_html__( 'Color',  'atf-colors' ),
			'plural'      => esc_html__( 'Colors', 'atf-colors' ),
			'description' => esc_html__( 'Select a color to represent this term.', 'atf-colors' )
		);
	}


	/**
	 * Loads js admin scripts
	 *
	 * Note: Only loads on edit-tags.php
	 *
	 * @uses Advanced_Term_Fields::$custom_column_name
	 * @uses Advanced_Term_Fields::$meta_key
	 * @uses Advanced_Term_Fields::$data_type
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param string $hook The slug of the currently loaded page.
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts( $hook )
	{
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'atf-colors', $this->url . 'js/admin.js', array( 'jquery', 'wp-color-picker' ), '', true );

		wp_localize_script( 'atf-colors', 'l10n_ATF_colors', array(
			'custom_column_name' => esc_html__( $this->custom_column_name ),
			'meta_key'           => esc_html__( $this->meta_key ),
			'data_type'          => esc_html__( $this->data_type ),
		) );
	}


	/**
	 * Prints out css styles in admin head
	 *
	 * Note: Only loads on edit-tags.php
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function admin_head_styles()
	{
		ob_start();
		include dirname( $this->file ) . "/css/admin.css";
		$css = ob_get_contents();
		ob_end_clean();

		echo $css;
	}


	/**
	 * Displays meta value in custom column
	 *
	 * @see Advanced_Term_Fields::add_column_value()
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param string $meta_value The stored meta value to be displayed.
	 *
	 * @return string $output The displayed meta value.
	 */
	public function custom_column_output( $meta_value )
	{
		$output = sprintf(
			'<svg data-%1$s="%2$s" class="term-%1$s" width="25" height="25"> <title>%2$s</title> <circle cx="12" cy="12" r="12" fill="%2$s" /> %2$s </svg>',
			$this->data_type,
			esc_attr( $meta_value )
			);

		return $output;
	}


	/**
	 * Displays inner form field on Add Term form
	 *
	 * @see Advanced_Term_Fields::show_custom_fields()
	 * @see Advanced_Term_Fields::add_form_field()
	 *
	 * @uses Advanced_Term_Fields::$file To include view.
	 * @uses Advanced_Term_Fields::$meta_key To populate field attributes.
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param string $taxonomy Current taxonomy slug.
	 *
	 * @return void
	 */
	public function show_inner_field_add( $taxonomy = '' )
	{
		ob_start();
		include dirname( $this->file ) . '/views/add-form-field.php';
		$field = ob_get_contents();
		ob_end_clean();

		echo $field;
	}


	/**
	 * Displays inner form field on Edit Term form
	 *
	 * @see Advanced_Term_Fields::show_custom_fields()
	 * @see Advanced_Term_Fields::edit_form_field()
	 *
	 * @uses Advanced_Term_Fields::$file To include view.
	 * @uses Advanced_Term_Fields::$meta_key To populate field attributes.
	 * @uses Advanced_Term_Fields::get_meta() To retrieve meta value.
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param object $term Term object.
	 * @param string $taxonomy Current taxonomy slug.
	 *
	 * @return void
	 */
	public function show_inner_field_edit( $term = false, $taxonomy = '' )
	{
		ob_start();
		include dirname( $this->file ) . '/views/edit-form-field.php';
		$field = ob_get_contents();
		ob_end_clean();

		echo $field;
	}


	/**
	 * Displays inner form field on Quick Edit Term form
	 *
	 * @see Advanced_Term_Fields::show_custom_fields()
	 * @see Advanced_Term_Fields::quick_edit_form_field()
	 *
	 * @uses Advanced_Term_Fields::$file To include view.
	 * @uses Advanced_Term_Fields::$meta_key To populate field attributes.
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param string $column_name Name of the column to edit.
	 * @param string $screen	  The screen name.
	 * @param string $taxonomy	  Current taxonomy slug.
	 *
	 * @return void
	 */
	public function show_inner_field_qedit( $column_name = '' , $screen = '' , $taxonomy = '' )
	{
		ob_start();
		include dirname( $this->file ) . '/views/quick-form-field.php';
		$field = ob_get_contents();
		ob_end_clean();

		echo $field;
	}


	/**
	 * Make sure we have valid hex color
	 *
	 * @since 0.1.0
	 *
	 * @param string $data The expected hex color code
	 *
	 * @return string $data The sanitized meta value.
	 */
	public function sanitize_callback( $data = '' )
	{
		return preg_match( '/#([a-fA-F0-9]{3}){1,2}\b/', $data ) ? $data : '';
	}


	/**
	 * Disables sorting by column
	 *
	 * @since 0.1.0
	 *
	 * @see WP_Term_Toolbox::sortable_columns()
	 *
	 * @param array $columns The columns of the Tag List table
	 */
	public function sortable_columns2( $columns = array() )
	{
		return $columns;
	}


}