<?php

use Config\Services;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

if ( ! function_exists('h_post'))
{
	function h_post($attribute = false)
	{
		$request = \Config\Services::request();
        return $attribute ? $request->getPost($attribute) : $request->getPost();
	}
}

if ( ! function_exists('h_get'))
{
	function h_get($attribute = false)
	{
		$request = \Config\Services::request();
        return $attribute ? $request->getGet($attribute) : $request->getGet();
	}
}


if ( ! function_exists('h_file_post'))
{
	function h_file_post($attribute = false)
	{
		$request = \Config\Services::request();
        return $attribute ? $request->getFile($attribute) : $request->getFile();
	}
}


if ( ! function_exists('h_session'))
{
	function h_session($key)
	{
        $session = \Config\Services::session();
        $sess = $session->get($key);

        return $sess ? $sess : '';
	}
}


if ( ! function_exists('h_set_session'))
{
	function h_set_session($key, $value=false)
	{
        $session = \Config\Services::session();
		if (!$value) {
			$session->set($key);
		}
		else{
			$session->set($key, $value);
		}
	}
}

if ( ! function_exists('h_kill_login_session'))
{
//function to generate company unique ids
	function h_kill_login_session($session_id = false)
	{
		// $CI = & get_instance();
		// $session_id = $session_id ? $session_id : $CI->session->userdata('login_session_id');
		// $system_database = $CI->session->userdata('system_database');
		// $date = h_current_date_time();

		// $res = $session_id ? $CI->db->query("UPDATE ".$system_database.".login_sessions set logged_in = 0,last_updated = '".$date."' where id = ".$session_id) : 0;
	}
}

if ( ! function_exists('h_upload_file_uploads'))
{
	function h_upload_file_uploads($file, $school_id, $directory='others')
	{
		$uploadsPath = ROOTPATH . 'public/assets/uploads/' . $school_id . '/'. $directory .'/';

		// Create the directory if it doesn't exist
		if (!is_dir($uploadsPath)) {
			mkdir($uploadsPath, 0775, true);
		}

        if ($file->isValid() && !$file->hasMoved()) {

			// Get the original file name and extension
			$originalName = $file->getClientName();
			$extension = $file->getClientExtension();
	
			// Generate a new name based on the original name and current timestamp
			$newName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;
	
			// Move the file to the new location
			$file->move($uploadsPath, $newName);

			// Set proper permissions on the uploaded file
			chmod($uploadsPath . $newName, 0644);
	
			// Construct the URL to the uploaded image
			$imageURL = 'assets/uploads/' . $school_id . '/'. $directory .'/' . $newName;
	
			// return save image url
			return $imageURL;
		} 
		else {
			return false;
		}
	}
}

if ( ! function_exists('h_download_student_template'))
	{
	function h_download_student_template() {

		$filePath = ROOTPATH . 'public/assets/templates/Schoolhub_Students_Upload.csv';
		// Check if the file exists
		if (file_exists($filePath)) {
			// Set the appropriate headers to force download
			header('Content-Description: File Transfer');
			header('Content-Type: application/force-download');
			header('Content-Disposition: attachment; filename='.basename($filePath));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filePath));
			ob_clean();
			flush();
			readfile($filePath);
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists('is_logged_in'))
{
	function is_logged_in($type = false)
	{
		$logged_in = h_session('logged_in');
		$school_id = h_session('school_id');

		if ($school_id != '' && $logged_in != '')
		{
			// ---log out user if is inactive for 5 minutes---
			// $last_active = h_date_diff($session->last_activity,h_current_date_time());
			// if ($last_active->minutes >= 20) return false;

			return true;
		}

		//return false if not set
		return false;
	}
}

if ( ! function_exists('h_is_ajax_request'))
{
	function h_is_ajax_request()
	{
		$request = Services::request();

        if ($request->isAJAX()) {
            // Handle AJAX request
            return true;
        }
		
		return false;
	}
}

if ( ! function_exists('h_is_get_post_request'))
{
	function h_is_get_post_request($type)
	{
		$request = Services::request();
		
        if ($request->getMethod() === $type) {
            return true;
        }
		
		return false;
	}
}

if ( ! function_exists('h_encrypt_decrypt'))
{
//function to encrypt and decrypt data like url ids account name codes etc
	function h_encrypt_decrypt($string, $action = false)
	{

	    $output = $string;

	    $encrypt_method = "AES-256-CBC";
	    //pls set your unique hashing key
	    $secret_key = 'hass';
	    $secret_iv = 'mtraby1';

	    // hash
	    $key = hash('sha256', $secret_key);

	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);


	    if( $action == 'decrypt' )
	    {
	    	//decrypt the given text/string/number
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
	    else
	    {
	    	//do the encyption given text/string/number
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);  	
	    }

    	return $output;
	}
}

if ( ! function_exists('h_buildTreeHtml'))
	{
	function h_buildTreeHtml($items, $tree_num = '') {
		$html = $tree_num != '' ? '<ul id="'. $tree_num .'" >': '<ul>';
		foreach ($items as $item) {

			$hasChild = !empty($item['children']) ? 'has-child-charts': '';
			$html .= '<li>';
			$html .= '<a class="'. $hasChild .'" href="javascript:void(0);">' . $item['name'] . '-'. $item['code'] . '</a>';
			
			// Check if the current item has children
			if (!empty($item['children'])) {
				// Recursively build the tree for child items
				$html .= h_buildTreeHtml($item['children']);
			}

			$html .= '</li>';
		}

		$html .= '</ul>';

		return $html;
	}
}

if ( ! function_exists('h_generateTreeView'))
{
	function h_generateTreeView($components, $assignedList = [])
	{
		$html = '';

		foreach ($components as $component) {
			$html .= '<li>';
			$html .= '<input '. (in_array($component->id, $assignedList ) ? 'checked': ''  ) .' data-id="'.$component->id.'" type="checkbox" id="comp_' . $component->id . '" class="' . (isset($component->children) && !empty($component->children) ? 'parent' : '') . '"> &nbsp;';
			$html .= '<label class="ml-4" for="comp_' . $component->id . '">' . htmlspecialchars($component->name) . '</label>';

			if (!empty($component->children)) {
				$html .= '<ul>' . h_generateTreeView($component->children, $assignedList) . '</ul>';
			}

			$html .= '</li>';
		}

		return $html;
	}
}

if ( ! function_exists('h_make_send_sms_request'))
{
	function h_make_send_sms_request($message, $phone_number) {		
		$phone_number = '256'. substr($phone_number, 1);	
		$username = "InocrateDigital"; 
		$password = "Inocrate@2023";
		$sender = "Egosms";	
		$api_url = 'https://www.egosms.co/api/v1/plain/?number='. urlencode($phone_number) .'&message='. urlencode($message) .'&username='. urlencode($username) .'&password='. urlencode($password) .'&sender='. urlencode($sender);

		// Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $api_url);          // Set the API URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   // Return the response as a string
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);   // Follow redirects
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification (optional, only for troubleshooting)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // Disable SSL host verification (optional, only for troubleshooting)

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check if the request was successful
        if(curl_errno($ch)) {
            return false;
        }

        // Get the HTTP response code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close the cURL session
        curl_close($ch);

        // Check if the response status is 200 (success)
        if ($http_code == 200 || $http_code == 201) {
            // Decode JSON response
            $data = json_decode($response, true);

            return true;
        } else {
            return false;
        }

		return false;
	}
}

if (!function_exists('h_generate_jwt')) {
    function h_generate_jwt($payload)
    {
        $config = config('JWT');
        $issuedAt = time();
        $expireAt = $issuedAt + (45 * 24 * 60 * 60); // 45 days in seconds

        $token = [
            'iss' => $config->issuer,
            'aud' => $config->audience,
            'iat' => $issuedAt,
            'exp' => $expireAt,
            'data' => $payload
        ];

        $key = $config->key;
        return ['expire' => date('Y-m-d H:i:s', $expireAt), 'key' => JWT::encode($token, $key, $config->algorithm)];
    }
}

if (!function_exists('h_validate_jwt')) {
    function h_validate_jwt($token)
    {
        $config = config('JWT');
        $key = $config->key;

        try {
            $decoded = JWT::decode($token, new Key($key, $config->algorithm));
			// Decode the token and check the 'exp' claim explicitly
            $now = time();
            if (isset($decoded->exp) && $decoded->exp < $now) {
                return 'expired';
            }

            return (array) $decoded->data; // Return the payload
        } catch (Exception $e) {
            // Token invalid or expired
            return 'error';
        }
    }
}
