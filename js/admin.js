( function ($) {
	'use strict';

	if ( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ) {
		$( '#' + l10n_ATF_colors.meta_key ).wpColorPicker();
	}

	$('#the-list').on('click', '.editinline', function () {
		var tr_id = $(this).parents('tr').attr('id');
		var meta_value = $('td.' + l10n_ATF_colors.custom_column_name + ' svg', '#' + tr_id).attr('data-' + l10n_ATF_colors.data_type);

		$(':input[name="' + l10n_ATF_colors.meta_key + '"]', '.inline-edit-row').val(meta_value);
	});

})(jQuery);