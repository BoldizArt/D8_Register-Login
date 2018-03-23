<?php
/**
* @file
* Contains \Drupal\logreg\RequestController.
*/
namespace Drupal\logreg\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\logreg\Controller\RegisterLoginController as RegLog;

/**
 * Provides route responses for the hello world page example.
 */
class RequestController
{
  
	public function login(Request $request) 
	{
		$response = [];
		if($request)
		{
			// Get name and password from request
			$name = $request->get('name');
			$pass = $request->get('pass');

			// Call the login function in RegLog class
			$response = RegLog::login($name, $pass);
		}
		// Return the response in Json format
		return new JsonResponse($response);
	}

	public function register(Request $request)
	{
		$response = [];
		if($request)
		{
			// Get name, password and email address fromm request
			$name = $request->get('name');
			$pass = $request->get('pass');
			$mail = $request->get('mail');
					
			// Call the register function in RegLog class
			$response = RegLog::register($name, $pass, $mail);
		}
		// Return the response in Json format
		return new JsonResponse($response);
	}
}