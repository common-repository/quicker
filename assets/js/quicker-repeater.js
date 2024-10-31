(function ($) {
	$.fn.repeater = function (options) {
		// Default params
		const params = $.extend(
			{
				structure: [],
				items: [],
				repeatElement: 'structure',
				createElement: 'createElement',
				removeElement: 'removeElement',
				containerElement: 'containerElement',
				groupName: 'group',
			},
			options
		);

		const repeater = this;

		$('#' + params.containerElement).html('');

		repeater.find('#' + params.createElement).click(function () {
			const cloned = repeater.find('#' + params.repeatElement).clone();
			const inputs = cloned.find(':input');
			const newItem = [];
			$.each(inputs, function (key, input) {
				const next = params.items.length;
				cloned
					.find('#structure-' + params.type)
					.attr('id', 'structure-' + params.type + '-' + next);
				newItem.push({
					id: $(input).attr('id'),
					value: '',
				});

				const input_name = $(input).attr('data-name');

				$(input).attr(
					'name',
					params.groupName + '[' + next + '][' + input_name + ']'
				);
				$(input).attr(
					'class',
					input_name + ' ' + input_name + '-' + next
				);
				$(input).attr('data-id', next);

			});
			cloned.append(
				'<div class="removeElement ' +
					params.removeElement +
					' action_rows"><span class="dashicons dashicons-minus"></span></div>'
			);
			cloned.find('.' + params.removeElement).click(function () {
				$(this).parent().remove();
				if (params.onRemove !== undefined) {
					params.onRemove();
				}
			});
			cloned.show();
			cloned.appendTo('#' + params.containerElement);
			if (params.onShow !== undefined) {
				params.onShow();
			}
			params.items.push(newItem);
		});

		if (params.items.length > 0) {
			$.each(params.items, function (key1, item) {
				var cloned = repeater.find('#' + params.repeatElement).clone();
				var cloned = cloned
					.clone()
					.prop('id', 'structure-' + params.type + '-' + key1);
				const inputs = cloned.find(':input');
				$.each(inputs, function (key2, input) {
					const input_name = $(input).attr('data-name');
					$(input).attr(
						'name',
						params.groupName + '[' + key1 + '][' + input_name + ']'
					);
					$(input).attr(
						'class',
						input_name + ' ' + input_name + '-' + key1
					);
					$(input).attr('data-id', key1);
				});

				const action_col =
					key1 !== 0
						? ' action_rows"><span class="dashicons dashicons-minus"></span></div>'
						: '';
				cloned.append(
					'<div class="removeElement ' +
						params.removeElement +
						action_col
				);

				$.each(item, function (index, element) {
					const single = cloned.find('.' + index + '-' + key1);
					set_value($, single, element);
				});

				$.each(item, function (repeat_field, repeat_item) {
					const input_field = cloned.find(
						'.' + repeat_field + '-' + key1
					);

					input_field.val(repeat_item);
				});

				cloned.find('.' + params.removeElement).click(function () {
					$(this).parent().remove();
					if (params.onRemove !== undefined) {
						params.onRemove();
					}
				});
				cloned.show();
				cloned.appendTo('#' + params.containerElement);
			});
		}
		let hide_div = '#structure-' + params.type
		$(hide_div).css('display', 'none');
	};
})(jQuery);
