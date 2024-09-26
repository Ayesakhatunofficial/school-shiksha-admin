<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

use App\Models\StudentModel;
use \CodeIgniter\HTTP\Files\UploadedFile;

function dd($data)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	die;
}

function getUserData()
{
	$request = \Config\Services::request();

	if (isset($request->user)) {
		$payload = $request->user;
		return $payload;
	}
}

function getSettingValue($setting_name, $settings)
{
	foreach ($settings as $setting) {
		if ($setting['setting_name'] == $setting_name) {
			return $setting['setting_value'];
		}
	}

	return '';
}

function getsetting($key)
{
	$db = db_connect();
	$sql = "SELECT setting_value FROM tbl_settings WHERE setting_name = '$key'";
	$result = $db->query($sql)->getRow();

	if (is_null($result)) {
		return null;
	}

	return $result->setting_value;
}

function fetchRoles()
{
	$db = db_connect();

	try {
		$query = $db->table('tbl_roles')->whereNotIn('role_name', ['super_admin', 'student']);

		$result = $query->get()->getResultArray();

		if ($result) {
			return $result; // Return the fetched rows
		} else {
			return []; // Return an empty array if no rows found
		}
	} catch (\Exception $e) {
		error_log('Error fetching roles: ' . $e->getMessage());
		return false; // Return false or appropriate value to indicate failure
	}
}
/**
 * Get next student id
 * 
 * @return string
 */
function getNextStudentId($role_name)
{
	$db = db_connect();

	$sql = "SELECT
            CASE
                WHEN r.role_name = 'super_admin' THEN CONCAT('ADM-', LPAD(IFNULL(COUNT(u.id), 0) + 1, 3, '0') ) 
                WHEN r.role_name = 'student' THEN CONCAT('STD-', LPAD(IFNULL(COUNT(u.id), 0) + 1, 3, '0') ) 
                WHEN r.role_name = 'master_distributor' THEN CONCAT('MDB-', LPAD(IFNULL(COUNT(u.id), 0) + 1, 3, '0') ) 
                WHEN r.role_name = 'distributor' THEN CONCAT('DB-', LPAD(IFNULL(COUNT(u.id), 0) + 1, 3, '0') ) 
                WHEN r.role_name = 'affiliate_agent' THEN CONCAT('AGT-', LPAD(IFNULL(COUNT(u.id), 0) + 1, 3, '0') ) 
            END AS next_student_id
        FROM tbl_users u 
        INNER JOIN tbl_roles r  ON r.id = u.role_id
        WHERE r.role_name = ?";

	$result = $db->query($sql, [$role_name])->getRow();

	return $result->next_student_id;
}


/**
 * Get roles 
 * 
 * @param string $role_name
 * @return int
 */
function getRoleId($role_name)
{
	$db = db_connect();

	$role = $db->table('tbl_roles')
		->where('role_name', $role_name)
		->get()
		->getRow();

	return $role->id;
}

/**
 * Get invoice id
 * 
 * @return string
 */
function getInvoiceId()
{
	$db = db_connect();

	// $sql = "SELECT 
	//         CONCAT('INV-', LPAD(IFNULL(COUNT(tbl_invoices.id), 0) + 1, 4, '0') ) AS next_inv_id
	//       FROM  
	//         tbl_invoices  
	//       ";

	$sql = "SELECT 
				CONCAT('INV-', LPAD(IFNULL(MAX(CAST(SUBSTRING(uniq_invoice_id, 5, 4) AS UNSIGNED)), 0) + 1, 4, '0')) AS next_inv_id
			FROM 
				tbl_invoices";

	$result = $db->query($sql)->getRow();

	return $result->next_inv_id;
}

function generateNumeric($n)
{
	$generator = "1357902468";
	$result = "";

	for ($i = 1; $i <= $n; $i++) {
		$result .= substr($generator, (rand() % (strlen($generator))), 1);
	}

	return $result;
}


/**
 * get role name bu role id 
 * 
 * @param string|null $role_id
 * @return string
 */
function getRole($role_id = NULL)
{
	$db = db_connect();

	if ($role_id == NULL) {
		$user = getUserData();

		$role_id = $user->role_id;
	}

	$role = $db->table('tbl_roles')->where('id', $role_id)->get()->getRow();

	return $role->role_name;
}

/**
 * Get user by id
 * 
 * @param int $user_id
 * @return object|null
 */
function getUserById($user_id)
{
	$db = db_connect();

	$sql = "SELECT 
    tbl_roles.id as role_id,
    tbl_roles.role_name as role_name,
    tbl_users.* 
  FROM 
    tbl_users
  JOIN tbl_roles ON tbl_users.role_id = tbl_roles.id
  WHERE tbl_users.id = $user_id";

	$user = $db->query($sql)->getRow();

	if (!is_null($user)) {
		// find user current active plan
		$sql = "SELECT 
      s.*,
      CASE
        WHEN i.total = 0 THEN 'free_plan'
        ELSE 'paid_plan'
      END AS plan_type
    FROM tbl_user_subscriptions s
    INNER JOIN tbl_invoices i ON i.id = s.invoice_id
    WHERE s.user_id = ? AND s.subscription_status = ?";

		$user->current_plan = $db->query($sql, [$user->id, 'active'])->getRow();
	}

	return $user;
}

/**
 * Get plan commission 
 * 
 * @param int $role_id
 * @param int $plan_id
 * @return object|null
 */
function getPlanCommission($role_id, $plan_id)
{
	$db = db_connect();

	$sql = "SELECT 
              *
          FROM 
            tbl_plan_commission 
          WHERE plan_id = ? AND role_id = ? ";
	return $db->query($sql, [$plan_id, $role_id])->getRow();
}

/**
 * Get Wallet Balance 
 * 
 * @return string
 */
function getWallet()
{
	$user = getUserData();

	$db = db_connect();

	$wallet = $db->table('tbl_users')
		->where('id', $user->id)
		->get()
		->getRow();

	return $wallet->wallet;
}


/**
 * get User id
 * 
 * @param int $user_id
 * @return array[object]
 */
function getUserId($user_id)
{
	$db = db_connect();
	$result = $db->table('tbl_users')
		->select('id')
		->where('created_by', $user_id)
		->get()
		->getResult();

	$all_id = [];
	foreach ($result as $row) {
		$all_id[] = $row->id;
	}
	return $all_id;
}

/**
 * Get Notification  
 * 
 * @return array
 */
function getNotification()
{
	$user = getUserData();
	$db = db_connect();
	$notification = $db->table('tbl_notifications')
		->where('user_id', $user->id)
		->orderBy('id', 'DESC')
		->limit(5)
		->get()
		->getResultArray();
	return $notification;
}

/**
 * Get Active Notification Count
 * 
 * @return int|string
 */
function checkNotification()
{
	$user = getUserData();
	if (!$user || !isset($user->id)) {
		return "";
	}
	$db = db_connect();
	$count = $db->table('tbl_notifications')
		->where('user_id', $user->id)
		->where('is_read', '0')
		->countAllResults();
	return $count > 0 ? $count : "";
}

function timeElapsedString($datetime, $full = false)
{
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = [
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	];
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full)
		$string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}

/**
 * Upload a file
 * 
 * @param \CodeIgniter\HTTP\Files\UploadedFile|string $file
 * @return null|array
 */
function uploadFile(UploadedFile|string $file)
{
	if ($file instanceof UploadedFile) {
		if (!$file->isValid()) {
			return "Not a validate file";
		}

		if ($file->hasMoved()) {
			return;
		}

		$newFileName = $file->getRandomName();
		$status = $file->move(UPLOAD_PATH, $newFileName);

		if ($status == false) {
			return;
		}

		$file_path = UPLOAD_PATH . $newFileName;
	} else {
		$file_path = $file;
	}

	if (!file_exists($file_path)) {
		return;
	}

	$curl = curl_init();
	curl_setopt_array(
		$curl,
		array(
			CURLOPT_URL => UPLOAD_SERVER_BASE_URL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('image' => new CURLFILE($file_path), 'project_name' => 'school-shiksha'),
		)
	);

	$response = curl_exec($curl);

	curl_close($curl);

	$data = json_decode($response, true);

	// unlink current file
	\unlink($file_path);

	return $data['data'];
}


// Define global variables
global $currentController;
global $currentMethod;

$currentController = '';
$currentMethod = '';

/**
 * Get current controller name
 * 
 * @return string|null
 */
function getCurrentController()
{
	global $currentController;

	return $currentController;
}

/**
 * Set current controller name
 * 
 * @param string $controller
 */
function setCurrentController($controller)
{
	global $currentController;

	$function = new \ReflectionClass($controller);
	$short_controller = $function->getShortName();
	$currentController = preg_replace('/Controller$/', '', $short_controller);
}

/**
 * Get current method name
 * 
 * @return string|null
 */
function getCurrentMethod()
{
	global $currentMethod;

	return $currentMethod;
}

/**
 * Set current method name
 * 
 * @param string $method
 */
function setCurrentMethod($method)
{
	global $currentMethod;

	$Words = preg_replace('/(?<!\ )[A-Z]/', ' $0', $method);
	$currentMethod = ucwords($Words);
}

/**
 * Set addTextToImage
 *  
 * @param int $fontSize
 * @param string $imagePath
 * @param array $textArray
 * 
 * @return string|null
 */
function addTextToImage($imagePath, $textArray, $fontSize)
{
	// Load the image
	$image = imagecreatefrompng($imagePath);

	// Define the text color
	$textColor = imagecolorallocate($image, 0, 0, 0);

	// Path to your font file
	$fontPath = FCPATH . '/assets/fonts/Ubuntu/Ubuntu-Regular.ttf'; // Use FCPATH to get the absolute path

	// Check if the font file exists
	if (!file_exists($fontPath)) {
		throw new Exception("Font file not found: $fontPath");
	}
	// Loop through each text item and add it to the image
	foreach ($textArray as $text) {
		// $position = $positions[$key];
		imagettftext($image, $fontSize, 0, $text['x_cord'], $text['y_cord'], $textColor, $fontPath, $text['text']);
	}

	// Save the image with a new name or overwrite the existing one
	$outputPath = FCPATH . 'assets/images/output.png';
	imagepng($image, $outputPath);

	// Free up memory
	imagedestroy($image);

	return $outputPath;
}

/**
 * Generate student id card
 * 
 * @param array $student
 * @return bool
 */
function idCardGenerate(array $student)
{
	$id = $student['id'];
	$date_of_birth = $student['date_of_birth'] ? date("d-m-Y", strtotime($student['date_of_birth'])) : "";
	$newDate = $student['plan_period_end'] ? date("d-m-Y", strtotime($student['plan_period_end'])) : "";

	$textArray = [
		[
			'text' => $student['name'],
			'x_cord' => 400,
			'y_cord' => 260
		],
		[
			'text' => $student['username'],
			'x_cord' => 765,
			'y_cord' => 260
		],
		[
			'text' => $student['plan_name'],
			'x_cord' => 400,
			'y_cord' => 345
		],
		[
			'text' => $student['mobile'],
			'x_cord' => 765,
			'y_cord' => 345
		],
		[
			'text' => $student['address'],
			'x_cord' => 400,
			'y_cord' => 430
		],
		[
			'text' => $date_of_birth,
			'x_cord' => 765,
			'y_cord' => 430
		],
		[
			'text' => $newDate,
			'x_cord' => 400,
			'y_cord' => 530
		],
	];

	$frontImagePath = FCPATH . '/assets/images/1.png';
	$outputPath = addTextToImage($frontImagePath, $textArray, 18);
	$imageData = uploadFile($outputPath);

	$id_card_data = [
		'id_card_front' => $imageData['file_name'],
		'id_card_back' => base_url('public/assets/images/5.png'),
		'id_card_data' => json_encode([
			'plan_id' => $student['plan_id'],
			'plan_name' => $student['plan_name']
		])
	];

	$model = new StudentModel();
	$result = $model->update($id, $id_card_data);

	if ($result) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check file type
 * 
 * @param string $url
 * @return string 
 */
function checkFileType($url)
{
	$client = \Config\Services::curlrequest();

	$response = $client->request('HEAD', $url);
	$contentType = $response->getHeaderLine('Content-Type');

	if (strpos($contentType, 'image/') !== false) {
		return 'Image';
	} elseif ($contentType === 'application/pdf') {
		return 'PDF';
	} else {
		return 'Other';
	}
}

/**
 * Show from validation error
 * 
 * @string $attribute
 * @return null|string
 */
function showValidationError($attribute)
{
	$errors = session()->getFlashdata('_ci_validation_errors');
	if (is_null($errors)) {
		return;
	}

	if (isset($errors[$attribute])) {
		return '<small style="color: red;">' . $errors[$attribute] . '</small>';
	}
}
