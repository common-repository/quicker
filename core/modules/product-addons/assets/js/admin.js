(function($) {
    "use strict";

    $(document).ready(function() {

        var pao_wrapper = $('#quicker_pao_content');
        // if desc checkbox is checked, then show description textarea box
        pao_wrapper.on( 'click', '.quicker_pao_desc_enable', function() {
            var current_this = $(this);

            if ( current_this.is( ':checked' ) ) {
                current_this.parents( '.quicker_pao_wrap' ).find( '.quicker_pao_desc' ).css('display', 'block');
            } else {
                current_this.parents( '.quicker_pao_wrap' ).find( '.quicker_pao_desc' ).css('display', 'none');
            }
        } )

        // if char limit checkbox is checked, then show min, max char input area
        pao_wrapper.on( 'click', '.quicker_pao_char_limit_enable', function() {
            var current_this = $(this);

            if ( current_this.is( ':checked' ) ) {
                current_this.parents( '.quicker_pao_wrap' ).find( '.wpc-addon-char-limit-wrap' ).addClass('show');
            } else {
                current_this.parents( '.quicker_pao_wrap' ).find( '.wpc-addon-char-limit-wrap' ).removeClass('show');
            }
        } )
        .on('change', '.quicker_pao_type', function() {
            var current_this = $(this);

            if(current_this.val() != 'text') { // others
                current_this.parents( '.quicker_pao_wrap' ).find( '.wpc-addons-place-holder' ).css('display', 'none');
                current_this.parents( '.quicker_pao_wrap' ).find( '.wpc-addon-char-limit-main' ).css('display', 'none');
                current_this.parents( '.quicker_pao_wrap' ).find( '.quicker-pao-option-row');
                current_this.parents( '.quicker_pao_wrap' ).find( '.quicker-pao-option-title, .quicker-pao-option-footer, .quicker-pao-option-sort-wrap, .quicker-pao-option-label, .quicker-pao-option-default-wrap' )
                    .removeClass('hide_block').addClass('show_block');
                current_this.parents( '.quicker_pao_wrap' ).find( '.quicker-pao-option-remove' ).css('display', 'block');
            } else {
                current_this.parents( '.quicker_pao_wrap' ).find( '.wpc-addons-place-holder' ).css('display', 'block');
                current_this.parents( '.quicker_pao_wrap' ).find( '.wpc-addon-char-limit-main' ).css('display', 'block');

                current_this.parents( '.quicker_pao_wrap' ).find( '.quicker-pao-option-row').not(':first').css('display', 'none');
                current_this.parents( '.quicker_pao_wrap' ).find( '.quicker-pao-option-title, .quicker-pao-option-footer, .quicker-pao-option-sort-wrap, .quicker-pao-option-label, .quicker-pao-option-default-wrap, .quicker-pao-option-remove')
                    .removeClass('show_block').addClass('hide_block');
                current_this.parents( '.quicker_pao_wrap' ).find( '.quicker-pao-option-remove' ).css('display', 'none');
            }
        })
        // add new pao field
        .on('click', '.quicker_pao_add_fields', function() {
            var clicked_this   = $(this);
            var next_pao_index = clicked_this.attr('data-next_pao_index');

            $.ajax({
                type: "POST",
                url: quicker_pro_pao_obj.ajax_url,
                dataType: 'json',
                data: {
                    action: 'add_pao', security: quicker_pro_pao_obj.add_pao_nonce,
                    'next_pao_index': next_pao_index,
                },
                complete: function() {
                },
                success: function (res) {
                    if( res.status_code == 1 ) {
                        clicked_this.attr('data-next_pao_index', parseInt(next_pao_index)+1);

                        var new_pao = res.content;
                        new_pao     = new_pao.replace( /hide_block/g, 'show_block' );

                        pao_wrapper.find('.quicker_pao_main_block').append(new_pao);
                    }
                }
            });
        })
        // add new price option block under specific pao field
        .on('click', '.quicker_pao_add_option', function() {
            var clicked_this   = $(this);
            var current_counter_index = clicked_this.data('current_counter_index');
            var next_option_index     = parseInt( clicked_this.attr('data-next_option_index') );
						var content = `<div class="quicker-pao-option-row">
						<div class="quicker-pao-option-sort-wrap show_block">
							<span class="quicker-pao-option-sort-handle dashicons dashicons-menu"></span>
						</div>

						<div class="quicker-pao-option-label show_block">
							<input type="text" class="quicker-input" name="quicker_pao_option_label[`+current_counter_index+`][]" value="" placeholder="`+ quicker_pro_pao_obj.repeater_text.opt_name +`">
						</div>

						<div class="quicker-pao-option-price-type">
							<select name="quicker_pao_option_price_type[`+current_counter_index+`][]" class="quicker-input quicker-pao-option-price-type">
								<option value="quantity_based">`+ quicker_pro_pao_obj.repeater_text.qty_based +`</option>
							</select>
						</div>

						<div class="quicker-pao-option-price">
							<input type="text" name="quicker_pao_option_price[`+current_counter_index+`][]" class="quicker-input wc_input_price quicker_pao_opt_price" value="" placeholder="0">
						</div>

						<div class="quicker-pao-option-default-wrap show_block">
							<div class="quicker-pao-option-default">
							<input type="checkbox" class="" id="quicker_pao_option_default_`+current_counter_index+`_`+next_option_index+`" name="quicker_pao_option_default[`+next_option_index+`][]" value="`+next_option_index+`">
							<label for="quicker_pao_option_default_`+current_counter_index+`_`+next_option_index+`">`+ quicker_pro_pao_obj.repeater_text.def_select +`</label>
							</div>
						</div>

						<button type="button" class="quicker-pao-option-remove button"">
							<i class="dashicons dashicons-no-alt"></i>
						</button>
					</div>`;

					$( content ).appendTo( clicked_this.parent().siblings('.quicker-pao-option-wrap') );
                        clicked_this.attr('data-next_option_index', next_option_index+1);

        })
        // show/hide pao content whenever that pao header is clicked
        .on( 'click', '.quicker-pao-header', function( e ) {
            e.preventDefault();
            var pao_block = $(this).next( '.quicker_pao_wrap' );
            pao_block.slideToggle();
        } )

        // sort pao fields
        $( '.quicker_pao_main_block' ).sortable( {
            items: '.quicker-pao-fields',
            cursor: 'move',
            axis: 'y',
            handle: '.quicker-pao-header',
            scrollSensitivity: 40,
            helper: function( e, view ) {
                return view;
            },
            start: function( eventt, view ) {
                view.item.css({ 'border-style': 'dotted', 'border-width': '1px', 'border-color': 'darkorange' });
            },
            stop: function( eventt, view ) {
                view.item.removeAttr( 'style' );
                paoBlockIndexesChange($);
            }
        } );

        // sort price option block under specific pao field
        $( '.quicker-pao-option-wrap' ).sortable( {
            items: '.quicker-pao-option-row',
            cursor: 'move',
            axis: 'y',
            handle: '.quicker-pao-option-sort-handle',
            scrollSensitivity: 40,
            helper: function( e, view ) {
                return view;
            },
            start: function( eventt, view ) {
                view.item.css({ 'border-style': 'dotted', 'border-width': '1px', 'border-color': 'darkorange' });
            },
            stop: function( eventt, view ) {
                view.item.removeAttr( 'style' );
                paoBlockIndexesChange($);
            }
        } );

        // need to change to match with existing remove function
        let obj = {
            parent_block: '.quicker_pao_main_block',
            remove_button: '.quicker-pao-fields .quicker-pao-remove',
            removing_block: '.quicker-pao-fields'
        };
        
        $(obj.parent_block).on( 'click' , obj.remove_button , function(e) {
            e.preventDefault();
            $(this).parents( obj.removing_block ).remove();
        });

        // remove price option block
        var remove_pao_option_block = {
            parent_block: '#quicker_pao_content',
            remove_button: '.quicker-pao-option-remove',
            removing_block: '.quicker-pao-option-row'
        };

        remove_block(remove_pao_option_block);

        // show error message and highlight fields if empty title/price option name
        if(pao_wrapper.length > 0) {
            $( '#publishing-action input[name="save"], .wpc_global_addons_save' ).on( 'click', function() {

								var has_error = check_addons_validation( 'on_submit' );

                if ( has_error ) {
                    var err_msg_block = '<div class="notice notice-error quicker-pao-error-msg"><p><a href="#quicker_pao_content">' + quicker_pro_pao_obj.empty_label_price_msg + '</a></p></div>';
                    $( '.wrap #post' ).before( err_msg_block );
                }

                return !has_error; // to allow/prevent normal submit action
            } );
        }
    });

check_addons_validation( 'typing' );
// TODO : Check validation on submit and typing.
function check_addons_validation( checking_type ) {
	var has_error    = false,
	border_error = false ;

// remove notice error msg which is showing on top
$( '.quicker-pao-error-msg' ).remove();

	var current_this;
	$( '.quicker_pao_main_block' ).find( '.quicker-pao-fields' ).each( function( i ) {
			current_this    = $(this);
			var pao_type    = $(this).find( '.quicker_pao_type' );
			var pao_title   = $(this).find( '.quicker_pao_title' );

			if ( checking_type =='typing' ) {
				var option_name = current_this.find( '.quicker-pao-option-label input:first' );

			// title on keyup
				pao_title.on('keyup',function(){
					if ( $.trim(pao_title.val()).length == 0) {
						current_this.addClass( 'quicker-pao-error' );
						pao_title.addClass( 'quicker-pao-error' ).after('<div class="quicker-warning">'+ quicker_pro_pao_obj.addons.pao_title +'</div>');
						has_error = border_error = true;
					} else {
							pao_title.removeClass( 'quicker-pao-error' ).next('div').remove();
					}
				});

				// option name on keyup
				option_name.on('keyup',function(){
					if ( $.trim(option_name.val()).length == 0) {
							current_this.parents( '.quicker-pao-fields' ).eq(0).addClass( 'quicker-pao-error' );
							option_name.addClass( 'quicker-pao-error' ).
							after('<div class="quicker-warning">'+ quicker_pro_pao_obj.addons.option_name +'</div>');
							has_error = border_error = true;
					} else {
							option_name.removeClass( 'quicker-pao-error' ).next('div').remove();
					}
				});
			}
			else{
				// check on submit
				if ( $.trim(pao_title.val()).length == 0) {
					current_this.addClass( 'quicker-pao-error' );
					pao_title.addClass( 'quicker-pao-error' );
					if (!pao_title.next().hasClass("quicker-warning")) {
						pao_title.after('<div class="quicker-warning">'+ quicker_pro_pao_obj.addons.pao_title +'</div>');
					}
					has_error = border_error = true;
				} else {
						pao_title.removeClass( 'quicker-pao-error' );
				}

				if ( pao_type.val() != 'text' ) {
						var option_name = current_this.find( '.quicker-pao-option-label input:first' );

						if ( $.trim(option_name.val()).length == 0) {
								option_name.addClass( 'quicker-pao-error' );
								if (!option_name.next().hasClass("quicker-warning")) {
									option_name.after('<div class="quicker-warning">'+ quicker_pro_pao_obj.addons.option_name +'</div>');
								}
								current_this.parents( '.quicker-pao-fields' ).eq(0).addClass( 'quicker-pao-error' );
								has_error = border_error = true;
						} else {
								option_name.removeClass( 'quicker-pao-error' );
						}
				}
				// for individual field block: if no error
				if ( !border_error ) {
						current_this.removeClass( 'quicker-pao-error');
				}
				if (has_error) {
					$('html, body').animate({
						scrollTop: ( current_this.offset().top )
					}, 1000 );
				}
			}

	});

	return has_error;
}

})(jQuery);

function paoBlockIndexesChange($) {
    $( '.quicker_pao_main_block .quicker-pao-fields' ).each( function( i, ele ) {
        var position = parseInt( $( ele ).index( '.quicker_pao_main_block .quicker-pao-fields' ) );
        $( '.quicker_pao_position', ele ).val( position );
    } );
}
// remove block
function remove_block( obj ) {
    console.log(obj.parent_block.length);
    console.log(obj.remove_button.length);
    jQuery(obj.parent_block).on( 'click' , obj.remove_button , function(e) {
        e.preventDefault();
        jQuery(this).parent( obj.removing_block ).remove();
    });
}