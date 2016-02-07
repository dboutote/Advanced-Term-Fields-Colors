/* global jQuery, l10n_ATF_colors, validateForm */

( function ($) {
	'use strict';
	
    /**
     * Globals
     */
	var atf_tag_form = $('#addtag');

	/**
	 * Resets the color field
	 */
	function atfResetTagFormColors( form ) {
		$('.wp-color-result', form).css({'background-color': 'transparent'});
		$( '#' + l10n_ATF_colors.meta_key, form ).val('');
	};


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
	 * Resets the color picker fields
	 *
	 * Checks if the form has been submitted and if there's no ajax error message.
	 */
	$( '#tag-name', atf_tag_form ).on('blur', function(){
		var form = $(this).parents('form');
		if( form.hasClass('atf-submitted') &&  $('#ajax-response').html() == '' ) {
			atfResetTagFormColors( form );
		}		
	});
	
	
	/**
	 * Reset the color field after the form has been submitted
	 *
	 * Note: There is no easy way to check if the form has successfully submitted, since it's ajax-
	 * posted, no change events are fired on any form fields.
	 *
	 * @since 0.1.1
	 */
	$( '#submit', atf_tag_form).click( function(){
		var form = $(this).parents('form');
		
		if ( ! validateForm( form ) ) {
			form.removeClass('atf-submitted');
			return false;
		} else {
			form.addClass('atf-submitted');
		}
	});	

})(jQuery);