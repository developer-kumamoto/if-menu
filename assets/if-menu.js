jQuery(function($) {


	// Show or hide conditions section
	$('body').on('change', '.menu-item-if-menu-enable', function() {
		$( this ).closest( '.if-menu-enable' ).next().toggle( $( this ).prop( 'checked' ) );

		if ( ! $( this ).prop( 'checked' ) ) {
			var firstCondition = $( this ).closest( '.if-menu-enable' ).next().find('p:first');
			firstCondition.find('.menu-item-if-menu-enable-next').val('false');
			firstCondition.nextAll().remove();
		}
	});


	// Show or hide conditions section for multiple rules
	$('body').on( 'change', '.menu-item-if-menu-enable-next', function() {
		var elCondition = $( this ).closest( '.if-menu-condition' );

		if ($(this).val() === 'false') {
			elCondition.nextAll().remove();
		} else if (!elCondition.next().length) {
			var newCondition = elCondition.clone().appendTo(elCondition.parent());
			newCondition.find('select').removeAttr('data-val').find('option:selected').removeAttr('selected');
			newCondition.find('.menu-item-if-menu-options, .select2').remove();
		}
	});


	// Check if menu extra fields are actually displayed
	if ($('#menu-to-edit li').length !== $('#menu-to-edit li .if-menu-enable').length) {
		$('<div class="notice error is-dismissible if-menu-notice"><p>' + IfMenu.conflictErrorMessage + '</p></div>').insertAfter('.wp-header-end');
	}


	// Store current value in data-val attribute (used for CSS styling)
	$('body').on('change', '.menu-item-if-menu-condition-type', function() {
		$(this).attr('data-val', $(this).val());
	});


	// Display multiple options
	$('.menu-item-if-menu-options').select2();
	$('body').on('change', '.menu-item-if-menu-condition', function() {
		var options = $(this).find('option:selected').data('options'),
			elCondition = $(this).closest('.if-menu-condition');

		elCondition.find('.menu-item-if-menu-options').select2('destroy').remove();

		if (options) {
			var data = [];

			for (key in options) {
				data.push({
					id:		key,
					text:	options[key]
				});
			}

			$('<select class="menu-item-if-menu-options" name="menu-item-if-menu-options[' + elCondition.data('menu-item-id') + '][' + elCondition.index() + '][]" style="width: 305px" multiple></select>')
				.appendTo(elCondition)
				.select2({data: data});
		}
	});


});
