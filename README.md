# D8_Register-Login
Register/Login user programmatically in Drupal 8

// You can use jQuery and/or only ajax to Register / Login user (you get response in json format).

    // Register
	$.post('/reglog/register', {name: 'Test, pass: 'test123', mail: 'test@exemple.lol'})
        .done(function(response)
    {
		// console.info(response);
		if(response.status == 'success'){
			// code...
		}
	});

    // Login
	$.post('/reglog/login', {name: 'Test, pass: 'test123'})
        .done(function(response)
    {
		// console.info(response);
		if(response.status == 'success'){
			// code...
		}
	});

// And can use php statuc function to Register / Login user (you get response in php array format).

use use Drupal\logreg\Controller\RegisterLoginController;

// Register
    $response = RegLog::register($name, $pass, $mail);

// Login
    $response = RegLog::login($name, $pass);

