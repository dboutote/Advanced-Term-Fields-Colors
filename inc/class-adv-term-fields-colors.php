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
 * @version 0.1.1 Added upgrade check. Changed $meta_key to protected. Added @var $meta_slug.
 * @version 0.1.0
 *
 * @since 0.1.0
 *
 */
class Adv_Term_Fields_Colors extends Advanced_Term_Fields
{

	/**
	 * Version number
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	protected $version = ATF_COLORS_VERSION;


	/**
	 * Metadata database key
	 *
	 * For storing/retrieving the meta value.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public $meta_key = '_term_color';


	/**
	 * Singular slug for meta key
	 *
	 * Used for:
	 * - localizing js files
	 * - form field views
	 *
	 * @see Adv_Term_Fields_Colors::enqueue_admin_scripts()
	 * @see Adv_Term_Fields_Colors\Views\(add|edit|qedit).php
	 *
	 * @since 0.1.2
	 *
	 * @var string
	 */
	public $meta_slug = 'term-color';


	/**
	 * Unique singular descriptor for meta type
	 *
	 * (e.g.) "icon", "color", "thumbnail", "image", "lock".
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
	 * @uses Advanced_Term_Fields::process_term_meta()
	 * @uses Advanced_Term_Fields::filter_terms_query()
	 * @uses Advanced_Term_Fields::$allowed_taxonomies
	 * @uses Adv_Term_Fields_Colors::load_admin_functions()
	 * @uses Adv_Term_Fields_Colors::show_inner_fields()
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 */
	public function init()
	{
		$this->register_meta();
		$this->load_admin_functions();
		$this->show_custom_column( $this->allowed_taxonomies );
		$this->show_custom_fields( $this->allowed_taxonomies );
		$this->process_term_meta();
		$this->filter_terms_query();
		$this->show_inner_fields();
	}


	/**
	 * Loads various admin functions
	 *
	 * - Checks for version update.
	 * - Loads js/css scripts
	 *
	 * @uses Advanced_Term_Fields::load_admin_functions()
	 *
	 * @access public
	 *
	 * @since 0.1.2
	 *
	 * @return void
	 */
	public function load_admin_functions()
	{
		parent::load_admin_functions();
		add_action( 'admin_init', array( $this, 'check_for_update' ) );
	}


	/**
	 * Loads upgrade check
	 *
	 * Checks if declared plugin version  matches the version stored in the database.
	 *
	 * @uses Adv_Term_Fields_Colors::$version
	 * @uses Adv_Term_Fields_Colors::$db_version_key
	 * @uses WordPress get_option()
	 * @uses Adv_Term_Fields_Colors::upgrade_version()
	 *
	 *
	 * @access public
	 *
	 * @since 0.1.2
	 *
	 * @return void
	 */
	public function check_for_update()
	{
		$db_version_key = $this->db_version_key;
		$db_version = get_option( $db_version_key );
		$plugin_version = $this->version;

		do_action( "atf_pre_{$this->meta_key}_upgrade_check", $db_version_key, $db_version );

		if( ! $db_version || version_compare( $db_version, $plugin_version, '<' ) ) {
			$this->upgrade_version( $db_version_key, $plugin_version, $db_version, $this->meta_key );
		}
	}


	/**
	 * Upgrades database record of plugin version
	 *
	 * @uses WordPress update_option()
	 *
	 * @since 0.1.2
	 *
	 * @param string $db_version_key The database key for the plugin version.
	 * @param string $plugin_version The most recent plugin version.
	 * @param string $db_version     The plugin version stored in the database pre upgrade.
	 * @param string $meta_key       The meta field key.
	 *
	 * @return bool $updated True if version has changed, false if not or if update failed.
	 */
	public function upgrade_version( $db_version_key, $plugin_version, $db_version = 0, $meta_key = '' )
	{
		do_action( "atf_pre_{$meta_key}_version_upgrade", $plugin_version, $db_version, $db_version_key );

		$updated = update_option( $db_version_key, $plugin_version );

		do_action( "atf_{$meta_key}_version_upgraded", $updated, $db_version_key, $plugin_version, $db_version, $meta_key );

		return $updated;
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
			'meta_key'	         => esc_html__( $this->meta_key ),
			'meta_slug'	         => esc_html__( $this->meta_slug ),
			'data_type'	         => esc_html__( $this->data_type ),
		) );
	}


	/**
	 * Prints out CSS styles in admin head
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
			'<i data-color="%1$s" class="term-color" title="%1$s" style="background-color:%1$s" />',
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
	 * @uses Advanced_Term_Fields::$meta_slug To populate CSS IDs, classes.
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
		include dirname( $this->file ) . '/views/inner-add-form-field.php';
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
	 * @uses Advanced_Term_Fields::$meta_slug To populate CSS IDs, classes.
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
		include dirname( $this->file ) . '/views/inner-edit-form-field.php';
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
	 * @uses Advanced_Term_Fields::$meta_slug To populate CSS IDs, classes.
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
		include dirname( $this->file ) . '/views/inner-quick-form-field.php';
		$field = ob_get_contents();
		ob_end_clean();

		echo $field;
	}


	/**
	 * Validates submitted meta value
	 *
	 * Makes sure it's a valid hex color code.
	 *
	 * @since 0.1.0
	 *
	 * @param string $data The expected hex color code.
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
	 * @see Advanced_Term_Fields::sortable_columns()
	 *
	 * @param array $columns The columns of the Tag List table
	 */
	public function sortable_columns( $columns = array() )
	{
		return $columns;
	}


}