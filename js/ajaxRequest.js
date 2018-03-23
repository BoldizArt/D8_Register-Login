
		// Log/Reg

		$('#shop-login').click(function(e){
			e.preventDefault();
			var url = $(this).attr('href');
			var $name = $('#login-name').val();
			var $pass = $('#login-pass').val();

			$.get(url, {name: $name, pass: $pass}).done(function(response){
				console.info(response);
				if(response.status == 'success'){
					$('#checkout-logreg').fadeOut(480);
				}
			});
		});

		$('#shop-register').click(function(e){
			e.preventDefault();
			var url = $(this).attr('href');
			var $name = $('#register-name').val();
			var $pass = $('#register-pass').val();
			var $mail = $('#register-mail').val();

			$.get(url, {name: $name, pass: $pass, mail: $mail}).done(function(response){
				console.info(response);
				if(response.status == 'success'){
					$('#checkout-logreg').fadeOut(480);
				}
			});
		});

		// Log/Reg END


