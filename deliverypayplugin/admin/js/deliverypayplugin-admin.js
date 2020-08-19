(function( $ ) {

	$( document ).ready(function() {

		//check cod button
		if(!$('#codcheck').is(':checked')){
			// let nexttr = $('#codcheck').closest('tr').next('tr');
			let nexttr = $('#codcheck').closest('tr').nextAll();
			$(nexttr).hide();
			$('#rangecheck').hide();
			$('.range_options_wrapper').hide();
		}

		$('#codcheck').change(function() {
			let nexttr = $('#codcheck').closest('tr').nextAll();
			if(this.checked) {
				(nexttr).show();
				$('#rangecheck').show();
				$('.range_options_wrapper').show();

			}
			else{
				$(nexttr).hide();
				$('#rangecheck').hide();
				$('.range_options_wrapper').hide();
			}
			RangeCheck();
			CyprusCheck();
		});

		//cyprus check cod button
		if(!$('#cyprus_check').is(':checked')){
			// let nexttr = $('#codcheck').closest('tr').next('tr');
			let nexttr = $('#cyprus_check').closest('tr').nextAll();
			$(nexttr).hide();
			$('#cyprus_check').hide();
			$('.cyprus_range_options_wrapper').hide();
			CyprusRangeCheck();
		}

		$('#cyprus_check').change(function() {
			console.log("Yes");
			CyprusCheck();
			CyprusRangeCheck();
		});

		//range check
		RangeCheck();

		$('#rangecheck').change(function() {
			RangeCheck();
		});

		//cyprus range check
		CyprusRangeCheck();

		$('#cyprus_rangecheck').change(function() {
			CyprusRangeCheck();
		});

		function CyprusCheck(){
			let nexttr = $('#cyprus_check').closest('tr').nextAll();
			if ($('#cyprus_check').is(':checked')) {
				(nexttr).show();
				$('#cyprus_rangecheck').show();
				$('.cyprus_range_options_wrapper').show();
			} else {
				$(nexttr).hide();
				$('#cyprus_rangecheck').hide();
				$('.cyprus_range_options_wrapper').hide();
			}
			CyprusRangeCheck();

		}

		function CyprusRangeCheck(){
			if($('#cyprus_rangecheck').is(':checked')) {
				$('.cyprus_range_options_wrapper').show();
			}
			else{
				$('.cyprus_range_options_wrapper').hide();
			}
		}

		function RangeCheck(){
			if($('#rangecheck').is(':checked')) {
				$('.range_options_wrapper').show();
			}
			else{
				$('.range_options_wrapper').hide();
			}
		}

		//main request
		function MainRequest(action, sendData, callback) {

			var _sendData = sendData || {};
			_sendData.action = action;
			$.ajax({
				url: delivery_pay_plugin_data.url,
				type: 'POST',
				data: _sendData,
				success: function(res) {

					if(res) {
						var data = $.parseJSON(res);
						if (data.status) {
							return callback(data);
						}
					}
					return callback(null);
				},
				error: function() {
					return callback(null);
				}
			});
		}

		//save range options
		if ($('.inputs-for-range-delivery-payment')) {

			$('#save_delivery_range_option').click(function () {

				$(event.currentTarget).html('Loading...');

				var send_data = {};

				send_data.delivery_range_from = $('#delivery_range_from').val();
				send_data.delivery_range_to = $('#delivery_range_to').val();
				send_data.delivery_range_price = $('#delivery_range_price').val();

				MainRequest('save_pay_range_options', send_data, function (data) {


					if (data) {
						// $(".delivery-range-list-table").load(location.href + " .delivery-range-list-table");
						// $(".inputs-for-range-delivery-payment").load(location.href + " .inputs-for-range-delivery-payment");
						location.reload();

					}else{
						alert("Συμπληρώστε σωστά τα πεδία");
						location.reload();
					}
				});

			});

		}

		//save cyprus range options
		if ($('.inputs-for-cyprus-range-delivery-payment')) {

			$('#save_delivery_cyprus_range_option').click(function () {

				$(event.currentTarget).html('Loading...');

				var send_data = {};

				send_data.delivery_cyprus_range_from = $('#delivery_cyprus_range_from').val();
				send_data.delivery_cyprus_range_to = $('#delivery_cyprus_range_to').val();
				send_data.delivery_cyprus_range_price = $('#delivery_cyprus_range_price').val();

				MainRequest('save_pay_cyprus_range_options', send_data, function (data) {


					if (data) {
						// $(".delivery-cyprus-range-list-table").load(location.href + " .delivery-cyprus-range-list-table");
						// $(".inputs-for-cyprus-range-delivery-payment").load(location.href + " .inputs-for-cyprus-range-delivery-payment");
						location.reload();

					}else{
						alert("Συμπληρώστε σωστά τα πεδία");
						location.reload();
					}
				});

			});

		}

		//delete range option from list
		// if ($('.range-list-table')) {

		$('.delete_range_option').click(function () {

			$(event.currentTarget).html('Loading...');

			var send_data = {};
			send_data.range_no = $(event.currentTarget).data('pickup_no');

			MainRequest('delete_range_option', send_data, function (data) {

				if (data) {
					location.reload();
				}else{
					alert("Δεν μπόρεσε να σβηστεί η επιλογή από την λίστα, ανανεώστε την σελίδα και ξαναπροσπαθήστε");
					location.reload();
				}

			});

		});

		// }

		//delete range option from cyprus list
		// if ($('.cyprus-range-list-table')) {

		$('.delete_cyprus_range_option').click(function () {

			$(event.currentTarget).html('Loading...');

			var send_data = {};
			send_data.cyprus_range_no = $(event.currentTarget).data('pickup_no');

			MainRequest('delete_cyprus_range_option', send_data, function (data) {

				if (data) {
					location.reload();
				}else{
					alert("Δεν μπόρεσε να σβηστεί η επιλογή από την λίστα, ανανεώστε την σελίδα και ξαναπροσπαθήστε");
					location.reload();
				}

			});

		});

		// }



	});

})( jQuery );
