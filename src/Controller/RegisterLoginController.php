<?php
/*
** @ Drupal\reglog\Controller\RegisterLoginController;
*/
namespace Drupal\reglog\Controller;

use Drupal\user\UserAuth;
use Drupal\user\Entity\User;

class RegisterLoginController
{
    private $pass;
    private $mail;
    private $name;
    private $lang;
    private $uid;

    function __construct($name, $pass, $mail)
    {
        $this->pass = $pass;
        $this->mail = $mail;
        $this->name = $name;

        // Get current user id
        $this->uid = \Drupal::currentUser()->id();

        // Get current site language
        $this->lang = \Drupal::languageManager()->getCurrentLanguage()->getId();
    }

    public static function register()
    {
        $response = [];
        if($this->uid < 1 && !empty($this->name) && !empty($this->pass) && !empty($this->mail))
        {
            // Load the user by name. If exists, return with error message
            $user = user_load_by_name($this->name);
            if(!$user)
            {
                // Create user
                $user = User::create();

                // Mandatory settings
                $user->setPassword($this->pass);
                $user->set("langcode", $this->lang);
                $user->enforceIsNew();
                $user->setEmail($this->mail);
                $user->setUsername($this->name);
                
                // Optional settings
                $user->activate();

                // Save user
                $user->save();

                // User login
                user_login_finalize($user);

                // Get informations for current user
                $response = $this->get();
            }
            else
            {
                $response[] = 
                [
                    'status' => 'error',
                    'message' => t('This username is alredy exits!')
                ];
            }
        }
        else
        {
            $response[] = 
            [
                'status' => 'error',
                'message' => t('Register form - Empty fields!')
            ];
        }
        $response['message'] = 'success';
        return $response;
    }

    public static function login()
    {
        $response = [];

        if($this->uid < 1)
        {
            if(!empty($this->name) && !empty($this->pass))
            {
                // Authenticate user
                $this->uid = \Drupal::service('user.auth')->authenticate($this->name, $this->pass);
                
                if(!empty($this->uid))
                {
                    $user = User::load($this->uid);
                    user_login_finalize($user);
                }
                // Get informations for current user
                $response = $this->get();
            }
            else
            {
                $response[] = 
                [
                    'status' => 'error',
                    'message' => t('Login form - Empty fields.')
                ];
            }
        }
        else
        {
            $response[] = 
            [
                'status' => 'error',
                'message' => t('Login form - User is logged in.')
            ];
        }
        $response['message'] = 'success';
        return $response;
    }

    private function get()
    {
        $response = [];
        $this->uid = \Drupal::currentUser()->id();

        if($this->uid > 0)
        {
            // Get current user id
            $user = User::load($this->uid);
            
			// Retrieve field data from that user
			$name = $user->get('name')->value;
			$mail = $user->get('mail')->value;
            $lang = $user->get('langcode')->value;
            
            // Set response data
            $response['status'] = 'success';
			$response['name'] = $name;
			$response['mail'] = $mail;
			$response['lang'] = $lang;
        }
        else
        {
            $response[] = 
            [
                'status' => 'error',
                'message' => t('This user is not authenticated.')
            ];
        }

		return $response;
	}
}