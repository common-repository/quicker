(function ($) {
	'use strict';

	/**
	 * Load Select2
	 */
	const ids = ['#up_sell_products', '#cross_sell_products'];
	$.each(ids, function (index, value) {
		$(value).select2({ multiple: true, width: '100%' });
	});
	$('#cross_sell_products')
		.val(quicker_admin_data.up_sell_products)
		.trigger('change');
	$('#up_sell_products')
		.val(quicker_admin_data.cross_sell_products)
		.trigger('change');

	/**
	 * Tab functions
	 */
	const $settings_tab_li = $('.settings_tab_pan li');
	const active_tab =
		window.location?.hash.slice(1) == ''
			? 'settings'
			: window.location?.hash.slice(1);

	$settings_tab_li.removeClass('active');
	$('.tab-content div').removeClass('active');
	$(`li[data-item="${active_tab}"]`).addClass('active');
	$(`#${active_tab}`).addClass('active');

	$settings_tab_li.on('click', function () {
		const $this = $(this);
		$settings_tab_li.removeClass();
		$('.tab-content > div').hide();
		$this.addClass('active');
		const index = $settings_tab_li.index(this);
		$('.tab-content > div:eq(' + index + ')').show();
		window.history.replaceState(null, null, `#${$this.data('item')}`);
	});

	/**
	 * Submit settings
	 */
	const save_settings = $('#quicker_settings');

	save_settings.on('submit', function (e) {
		save_quicker_settings(e);
	});

	/**
	 * Get settings options
	 * @param {*} main_div
	 * @return
	 */
	function getAllValues(main_div) {
		const obj = {};
		$(main_div).map(function (x, item) {
			const $this = $(this);
			if (typeof $this.attr('name') === 'undefined') {
				return;
			}

			const type = $this.prop('type');

			if (type == 'checkbox' || type == 'radio') {
				if (this.checked) {
					obj[$this.attr('name')] = $this.val();
				} else {
					obj[$this.attr('name')] = 'no';
				}
				return obj;
			} else if (type == 'select-multiple' || type == 'select-one') {
				obj[$this.attr('name')] = $this.val();
				return obj;
			} else if (type == 'text' || type == 'hidden' || type == 'number') {
				obj[$this.attr('name')] = $this.val();
				return obj;
			}
		});

		return obj;
	}

	function getTabData(checkout_data = false) {
		let tabs 		= [];
		let form_data 	= {};

		if (checkout_data) {
			tabs = ['.checkout-form-update :input'];
		} else {
			tabs = [
				'#settings :input',
				'#side-cart :input',
				'#checkout-fees :input'
			];
		}

		tabs.forEach((element) => {
			const input_data = getAllValues(element);
			$.each(input_data, function (i, value) {
				form_data[i] = value;
			});
		});

		return form_data;
	}

	function save_quicker_settings(e) {
		e.preventDefault();
		const $admin_button = $('.admin-button');
		const $message = $('.settings_message');
		const form_data = getTabData();
		const data = {
			action: 'quicker_save_settings',
			params: form_data,
			nonce: quicker_admin_data.nonce,
		};

		$.ajax({
			url: quicker_admin_data.ajax_url,
			method: 'POST',
			data,
			beforeSend() {
				$admin_button.addClass('loading');
			},
			success(response) {
				$admin_button.removeClass('loading');
				$message
					.removeClass('d-none')
					.html('')
					.html(response?.data?.message)
					.fadeIn()
					.delay(2000)
					.fadeOut();
			},
		});
	}

	/**
	 * Open modal
	 */
	const $update_checkout = $('.update_checkout');
	const $modal_content = '#checkout-field-modal';
	$update_checkout.click(function () {
		$('#action_type').val('').val('update');
		const $this = $(this);
		const id = $this.data('id');
		const show_values = {
			field_label: $this.data('field_label'),
			field_name: $this.data('field_name'),
			field_placeholder: $this.data('field_placeholder'),
			field_required: $this.data('field_required'),
			field_enabled: $this.data('field_enabled'),
			field_position: $this.data('field_position'),
			input_type: $this.data('input_type'),
			ID: id,
			field_type: $this.data('field_type'),
		};

		const hide_section = ['field_position', 'input_type'];
		hide_section.forEach((element) => {
			if (!(element in show_values)) {
				$('#' + element)
					.parents('.single-block')
					.css('display', 'none');
			}
		});

		$.each(show_values, function (key, valueObj) {
			const input = $('.checkout-form-update').find('#' + key);
			if (input.attr('type') == 'checkbox') {
				if (valueObj !== 'no') {
					input.prop('checked', true);
				} else {
					input.prop('checked', false);
				}
			} else {
				input.val(valueObj);
			}
		});

		$($modal_content).show();
	});

	/**
	 * Add new checkout field
	 */
	$('.add_checkout_field').on('click', function (e) {
		e.preventDefault();
		$($modal_content).show();
		$('#action_type').val('').val('add');
		const refresh_input = [
			$('#key'),
			$('#field_type'),
			$('#field_name'),
			$('#field_label'),
			$('#field_placeholder'),
		];
		refresh_input.forEach((element) => {
			element.val('');
		});
	});
	$('.update_checkout_field').on('click', function (e) {
		e.preventDefault();
		save_checkout_fields();
	});

	/**
	 * Save checkout fields
	 * @param {*} params
	 */
	function save_checkout_fields(params) {
		const $message = $('.field_message');
		const $update_checkout = $('.update_checkout_field');
		const form_data = getTabData(true);
		const data = {
			action: 'insert_checkout_fields',
			params: form_data,
			nonce: quicker_admin_data.nonce,
		};

		$.ajax({
			url: quicker_admin_data.ajax_url,
			method: 'POST',
			data,
			beforeSend() {
				$update_checkout.addClass('loading');
			},
			success(response) {
				$update_checkout.removeClass('loading');

				if (response?.data?.data) {
					//reload table
					location.reload();
				}
				$('#checkout-field-modal').fadeOut(500);
				$message
					.removeClass('d-none')
					.html('')
					.html(response?.data?.message)
					.fadeIn()
					.delay(2000)
					.fadeOut();
			},
		});
	}

	// closing
	const $modal_close = $('.modal-close');
	$modal_close.on('click', function () {
		$($modal_content).fadeOut(500);
	});

	$(document).click(function (e) {
		if ($(e.target).is($modal_content)) {
			$($modal_content).fadeOut(500);
		}
	});

	/**
	 * Block show / hide
	 */
	const input_arr = ['#custom_price','#quicker_view', '#enable_buy_now', '#cod_charge' , '#enable_mini_cart','#mix_max_order'];
	input_arr.forEach((item) => {
		$(item).on('change', function () {
			toggle_show_hide($(this));
		});
	});

	function toggle_show_hide($this) {
		const id = $this.attr('id');
		const input = $(`.${id}`);

		if ($this.is(':checked') == 'yes' || $this.is(':checked') == true) {
			$(`.${id}`).fadeIn();
			$(`.${id}`).css('display', 'flex');
			if (input.hasClass('d-none')) {
				input.removeClass('d-none');
			}
		} else {
			$(`.${id}`).fadeOut();
		}
	}
	
	repeater_block();
	/**
	 * Create Repeater
	 * @param params
	 */
	function repeater_block() {
		const types = ['extra_fees'];
		$.each(types, function (id, type) {
			let repeater = $('#repeater-' + type);
			repeater.repeater({
				type,
				repeatElement: 'structure-' + type,
				createElement: 'createElement-' + type,
				removeElement: 'removeElement-' + type,
				containerElement: 'containerElement-' + type,
				groupName: 'repeat_fields[' + type + ']',
				items: quicker_admin_data.extra_fees,
			});
		});
	}

})(jQuery);

/**
 * Set value into field
 * @param     $
 * @param {*} field
 * @param {*} valueObj
 */
function set_value($, field, valueObj) {

	switch (field.prop('type')) {
		case 'hidden':
		case 'select-one':
			field.val(valueObj);
		case 'text':
		case 'number':
			field.val(valueObj);
		case 'checkbox':
			field.val(valueObj);
			if (valueObj == 'yes') {
				field.prop('checked', true);
			} else {
				field.prop('checked', false);
			}
		case 'select-multiple':
			field.val(valueObj).trigger('change');
		default:
			break;
	}
}
