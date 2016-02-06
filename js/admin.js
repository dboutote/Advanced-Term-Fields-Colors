/* global jQuery, l10n_ATF_colors, validateForm */

( function ($) {
	'use strict';

	/**
	 * Instantiate the color picker
	 */
	if ( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ) {
		$( '#' + l10n_ATF_colors.meta_key ).wpColorPicker();
	}


	/**
	 * Quick edit actions
	 */
	$('#the-list').on('click', '.editinline', function () {
		var tr_id = $(this).parents('tr').attr('id');
		var meta_value = $('td.' + l10n_ATF_colors.custom_column_name + ' svg', '#' + tr_id).attr('data-' + l10n_ATF_colors.data_type);

		$(':input[name="' + l10n_ATF_colors.meta_key + '"]', '.inline-edit-row').val(meta_value);
	});


	/**
	 * Resets the color field
	 */
	function ATFResetTagFormColors() {
		var form = $('#addtag'),
			term_name_val = $('#tag-name', form).val(),
			term_slug_val = $('#tag-slug', form).val();

		if( '' === term_name_val && '' === term_slug_val){
			$('.wp-color-result', form).css({'background-color': 'transparent'});
			$( '#' + l10n_ATF_colors.meta_key, form ).val('');
		}
	};


	/**
	 * Reset the color field after the form has been submitted
	 *
	 * Note: this fires before wp-admin\js\tags.js hence the setTimeout
	 */
	$( '#submit', '#addtag').click( function(){
		var form = $(this).parents('form');

		if ( ! validateForm( form ) ) {
			return false;
		} else {
			setTimeout( ATFResetTagFormColors, 1000 );
		}
	});

})(jQuery);