var Hai = {};

(function ($) {
	$.fn.matchHeight = function (childSelector) {
			var height = 0;

			this.find(childSelector)
					.css('height', 'auto')
					.each(function () {
							var childHeight = $(this).height();
							if (childHeight > height) height = childHeight;
					})
					.css('height', height+'px');
			return this;
	}
}(jQuery));

function checkVoucher (code) {
    return $.post(
        '/voucher_prizes.php',
        { code: code }
    );
}

function buildPrizeList (prizes, $container) {
    var $optTpl = $($('#tpl_prizeOpt').html());
    $container.empty();
    for (var i = 0, len = prizes.length; i < len; i++) {
        var prize = prizes[i];
        var $opt = $optTpl.clone();
        $opt
            .find(':radio')
                .val(prize.id)
                .end()
            .find('.prize-name')
                .text(prize.name)
                .end();
        $container.append($opt);
    }
}

function claimVoucher (url, code, prize) {
    return $.post(
        url,
        { code: code, prize_id: prize }
    );
}

$(function () {
    $('body')
        .on('submit', '#formVoucher', function (event) {
            event.preventDefault();
            var code = $(this).find('[name="voucher"]').val();
            var prize_id = $(this).find('[name="prize_id"]:checked').val();
            var $widget = $(this).closest('.widget');
            var $shade = $widget.find('.widget-shade');

            if (prize_id) {
                var url = $(this).attr('action');
                $(this).find('.btn').prop('disabled', true);
                $shade.removeClass('hide');
                claimVoucher(url, code, prize_id)
                    .done(function (json) {
                        $shade.addClass('hide');
                        if (json.error) return alert(json.message);
                        $('#grpVoucherCode').addClass('hide');
                        $('#grpPrizeList').find('.prize-opt:not(.selected)').addClass('hide');
                        $('.prize-button').addClass('hide');
                        $('#grpPrizeDone').removeClass('hide');
                    });
            } else {
                $shade.removeClass('hide');
                checkVoucher(code)
                    .done(function (json) {
                        $shade.addClass('hide');
                        if (json.error) return alert(json.message);
                        $('#grpVoucherCode').addClass('hide');
                        var prizes = json.data;
                        buildPrizeList(prizes, $('.prize-list'));
                        $('#grpPrizeList').removeClass('hide');
                    });
            }
        })
        .on('change', '.prize-opt :radio', function (event) {
            var $container = $(this).closest('.prize-list');
            $container.find('.prize-opt').removeClass('selected');
            $(this).closest('.prize-opt').addClass('selected');
        })
        .on('click', '.card-collect-btn', function (event) {
            event.preventDefault();

            var $btn = $(this);
            if ($btn.hasClass('disabled') || $btn.data('loading') || $btn.data('claimed')) {
                return;
            }
            $btn.data('loading', true);

            $.post('/myhai/loyalty_points_redeem.php', {
                _hai_csrf: $btn.data('csrf')
            }).done(function (json) {
                $btn.data('loading', false);
                if (json.status == 'error') {
                    return alert(json.message);
                }
                $btn.data('claimed', true);
                $btn.text(json.data.redeemed ? 'Claimed!' : 'Error claiming loyalty points.');
            });
        });
});



var ModalConfirm = (function (jQuery) {
	var defaults = {
		title: 'Are you sure?',
		message: 'Are you sure you want to do this?',
		modal: '#modalConfirm',
		data: {},
		cancelLabel: 'Cancel',
		confirmLabel: 'Confirm'
	};


	return function (opts) {
		var options = $.extend({}, defaults, opts);
		var $modal = $(options.modal);
		var def = $.Deferred();

		$modal
			.find('.modal-header .modal-title')
				.text(options.title)
				.end()
			.find('.modal-body p')
				.text(options.message)
				.end()
			.find('.modal-footer .btn.btn-default')
				.text(options.cancelLabel)
				.end()
			.find('.modal-footer .btn.btn-primary')
				.text(options.confirmLabel)
				.end()
			.on('show.bs.modal', function () {
				$('.modal-footer .btn.btn-default', this).focus();
			})
			.one('click', '.modal-footer .btn', function (event) {
				if ($(this).hasClass('btn-primary')) {
					def.resolve(options.data);
				} else {
					def.reject(options.data);
				}

				$modal.modal('hide');
			})
			.modal({
				backdrop: 'static',
				keyboard: false
			});

		return def.promise();
	};
}($));


$(function () {

	$('#tabsDetails a').click(function(event) {
			event.preventDefault();
			$(this).tab('show');
	});

	$('#panePassword').on('submit', 'form', ajaxUpdate);
	$('#paneDetails').on('submit', 'form', ajaxUpdate);


	$('#modalUpgrade').on('submit', 'form.package-select', doPackageChange);

	$('#formIpidiSerial').on('submit', function (event) {
		event.preventDefault();
		var $form = $(this);

		ipidiRegister($form).done(function (serial) {
			$form.find('[name="serial"]').val('');

			var $tpl = $($('#ipidiFormTemplate').html());
			$tpl.find('input[name="serial"]').val(serial);
			$('#listIpidiSerials').append($tpl);
			$('#ipidiEmptyMsg').addClass('hide');
			var len = $('#listIpidiSerials .ipidi-serial-remove').length;
			if (len >= 4) {
				$('#formIpidiSerial').addClass('hide');
			}
		}).fail(function (message) {
			alert('Error: '+message);
		});
	});
	$('#listIpidiSerials').on('submit', '.ipidi-serial-remove', function (event) {
		event.preventDefault();
		var $form = $(this);

		ModalConfirm({
			message: 'Are you sure you want to delete this serial? It will be removed immediately.'
		}).done(function () {
			ipidiRemove($form).done(function () {
				$form.slideUp('fast', function () {
					$(this).remove();


					var len = $('#listIpidiSerials .ipidi-serial-remove').length;
					if (len == 0) {
						$('#ipidiEmptyMsg').removeClass('hide');
					}
					if (len < 4) {
						$('#formIpidiSerial').removeClass('hide');
					}
				});
			}).fail(function (message) {
				alert('Error: '+message);
			});
		});
	});

	function ipidiRegister ($form) {
		var def = $.Deferred();
		var data = $form.serialize();
		$.post(
			$form.attr('action'),
			data
		).done(function (json) {
			if (json.success) {
				def.resolve(json.data.serial);
			} else {
				def.reject(json.message);
			}
		}).fail(function () {
			def.reject('Error submitting form');
		});

		return def.promise();
	}
	function ipidiRemove ($form) {
		var def = $.Deferred();
		var data = $form.serialize();
		$.post(
			$form.attr('action'),
			data
		).done(function (json) {
			if (json.success) {
				def.resolve();
			} else {
				def.reject(json.message);
			}
		}).fail(function () {
			def.reject('Error submitting form');
		});

		return def.promise();
	}

	function doPackageChange (event) {
		event.preventDefault();
		var $form = $(this);
		var action = $form.attr('action');
		var method = $form.attr('method');
		var $inputs = $form.find('input, button');
		var data = $form.serialize();
		$inputs.prop('disabled', true);

		$.ajax({
			url: action,
			type: method,
			data: data	
		}).done(function (json) {
			$inputs.prop('disabled', false);

			if (json.error) {
				return alert('Error: '+json.message);
			}

			if (json.data.redirect) {
				window.location.href = json.data.redirect;
			}
		});
	}

    /*
	function changePackageModalLoaded (resp) {
		var $content = $('#modalUpgrade .modal-content');
		$content.html(resp);

		$('#modalUpgrade').one('shown.bs.modal', function (event) {
			$content.matchHeight('.package-detail-container');
			$content.matchHeight('.package-footer');
		});
	}
    */

	$('#modalSpeedTest').on('show.bs.modal', function () {
		$(this).find('iframe').attr('src', 'https://speedtest.liquidtelecom.co.ke');
	}).on('hidden.bs.modal', function () {
		$(this).find('iframe').attr('src', 'about:blank');
	});

	function ajaxUpdate (event) {
		event.preventDefault();
		var $form = $(this);	
		var action = $form.attr('action');
		var method = $form.attr('method');
		var $inputs = $form.find('input, select, textarea');
		var $disabled = $inputs.filter(':disabled');
		var $buttons = $form.find('button');
		var data = $form.serialize();

		$form.find('.alert.alert-haiform').remove();
		$form.find('.form-group .help-block.help-haiform').remove();

		$inputs.prop('disabled', true);
		$buttons.prop('disabled', true);

		$.ajax({
			url: action,
			type: method,
			data: data
		}).done(function (json) {
			$inputs.prop('disabled', false);
			$buttons.prop('disabled', false);
			$disabled.prop('disabled', true);

			var $alert = $('<div class="alert alert-haiform">');
			var $help = $('<span class="help-block help-haiform">');
			var message = json.message;
			var field = (json.data && json.data.field ? json.data.field : null);

			if (json.error) {
				if (field) {
					var $field = $form.find('[name="'+field+'"]');
					var $group = $field.closest('.form-group');
					$group.addClass('has-error');
					$help.text(message);
					$group.append($help);
				} else {
					$alert.addClass('alert-danger').text(message);
					$form.prepend($alert);
				}
			} else {
				$alert.addClass('alert-success').text(message);
				$form.prepend($alert);

				if (json.data && json.data.fields) {
					$.each(json.data.fields, function (name, val) {
						$form.find('[name="'+name+'"]').val(val);
					});
				}
			}
			
		});
	}

    $('body')
        .on('change', '.big-opt .big-opt-check', function (event) {
            var $check = $(this);
            var $set = $check.closest('.big-opt-set');
            var $opt = $check.closest('.big-opt');

            if ($opt.hasClass('selected')) return;

            $set.find('.big-opt').removeClass('selected');
            $opt.addClass('selected');
        })
        .find('.big-opt-set').each(function () {
            var $set = $(this);
            var $selected = $set.find('.big-opt-check:checked')
            if ($selected.length == 0) return;
            var $opt = $selected.closest('.big-opt');
            $opt.addClass('selected');
        });

});
