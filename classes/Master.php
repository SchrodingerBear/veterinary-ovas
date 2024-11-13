<?php
require_once('../config.php');
class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	function capture_err()
	{
		if (!$this->conn->error)
			return false;
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_message()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if (!empty($data))
					$data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (empty($id)) {
			$sql = "INSERT INTO `message_list` set {$data} ";
		} else {
			$sql = "UPDATE `message_list` set {$data} where id = '{$id}' ";
		}

		$save = $this->conn->query($sql);
		if ($save) {
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if (empty($id))
				$resp['msg'] = "Your message has successfully sent.";
			else
				$resp['msg'] = "Message details has been updated successfully.";
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		if ($resp['status'] == 'success' && !empty($id))
			$this->settings->set_flashdata('success', $resp['msg']);
		if ($resp['status'] == 'success' && empty($id))
			$this->settings->set_flashdata('pop_msg', $resp['msg']);
		return json_encode($resp);
	}
	function delete_message()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `message_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Message has been deleted successfully.");

		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_category()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if (!empty($data))
					$data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (empty($id)) {
			$sql = "INSERT INTO `category_list` set {$data} ";
		} else {
			$sql = "UPDATE `category_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `category_list` where `name` = '{$name}' and delete_flag = 0 " . ($id > 0 ? " and id != '{$id}'" : ""));
		if ($check->num_rows > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Category name already exists.";
		} else {
			$save = $this->conn->query($sql);
			if ($save) {
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				if (empty($id))
					$resp['msg'] = "Category has successfully added.";
				else
					$resp['msg'] = "Category details has been updated successfully.";
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error . "[{$sql}]";
			}
		}
		if ($resp['status'] == 'success')
			$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	function delete_category()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `category_list` set delete_flag=1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Category has been deleted successfully.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_service()
	{
		$_POST['category_ids'] = implode(',', $_POST['category_ids']);
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if (!empty($data))
					$data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (empty($id)) {
			$sql = "INSERT INTO `service_list` set {$data} ";
		} else {
			$sql = "UPDATE `service_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `service_list` where `name` ='{$name}' and category_ids = '{$category_ids}' and delete_flag = 0 " . ($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Service already exists.";
		} else {
			$save = $this->conn->query($sql);
			if ($save) {
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				if (empty($id))
					$resp['msg'] = "Service has successfully added.";
				else
					$resp['msg'] = "Service has been updated successfully.";
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error . "[{$sql}]";
			}
			if ($resp['status'] == 'success')
				$this->settings->set_flashdata('success', $resp['msg']);
		}
		return json_encode($resp);
	}
	function delete_service()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `service_list` set delete_flag = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Service has been deleted successfully.");

		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_product()
	{
		global $conn;

		if (!isset($_POST['id']) || empty($_POST['id'])) {
			return json_encode(['status' => 'error', 'message' => 'Invalid product ID.']);
		}

		$product_id = intval($_POST['id']);

		try {
			// Prepare the delete statement
			$stmt = $conn->prepare("UPDATE `products` SET delete_flag = 1 WHERE id = ?");
			$stmt->bind_param("i", $product_id);

			if ($stmt->execute()) {
				return json_encode(['status' => 'success', 'message' => 'Product deleted successfully.']);
			} else {
				return json_encode(['status' => 'error', 'message' => 'Failed to delete product.']);
			}
		} catch (Exception $e) {
			return json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
		}
	}
	function delete_record()
	{
		global $conn;

		if (!isset($_POST['id']) || empty($_POST['id'])) {
			return json_encode(['status' => 'error', 'message' => 'Invalid product ID.']);
		}

		$product_id = intval($_POST['id']);

		try {
			// Prepare the delete statement
			$stmt = $conn->prepare("UPDATE `medicalrecords` SET delete_flag = 1 WHERE record_id = ?");
			$stmt->bind_param("i", $product_id);

			if ($stmt->execute()) {
				return json_encode(['status' => 'success', 'message' => 'Product deleted successfully.']);
			} else {
				return json_encode(['status' => 'error', 'message' => 'Failed to delete product.']);
			}
		} catch (Exception $e) {
			return json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
		}
	}
	public function save_medical_record()
	{
		global $conn;

		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$pet_name = isset($_POST['pet_name']) ? $conn->real_escape_string($_POST['pet_name']) : '';
		$client_name = isset($_POST['client_name']) ? $conn->real_escape_string($_POST['client_name']) : '';
		$medical_condition = isset($_POST['medical_condition']) ? $conn->real_escape_string($_POST['medical_condition']) : '';
		$proposed_solution = isset($_POST['proposed_solution']) ? $conn->real_escape_string($_POST['proposed_solution']) : '';
		$date_of_record = isset($_POST['date_of_record']) ? $conn->real_escape_string($_POST['date_of_record']) : date("Y-m-d H:i:s");
		$delete_flag = isset($_POST['delete_flag']) ? intval($_POST['delete_flag']) : 0;

		if ($id) {
			$qry = $conn->query("UPDATE `medicalrecords` SET `pet_name` = '$pet_name', `client_name` = '$client_name', `medical_condition` = '$medical_condition', `proposed_solution` = '$proposed_solution', `delete_flag` = '$delete_flag' WHERE `record_id` = $id");
			if ($qry) {
				return json_encode(['status' => 'success', 'message' => 'Medical record updated successfully.']);
			} else {
				return json_encode(['status' => 'error', 'message' => 'Failed to update medical record.']);
			}
		} else {
			// Insert new medical record
			$qry = $conn->query("INSERT INTO `medicalrecords` (`pet_name`, `client_name`, `medical_condition`, `proposed_solution`, `date_of_record`, `delete_flag`) VALUES ('$pet_name', '$client_name', '$medical_condition', '$proposed_solution', '$date_of_record', '$delete_flag')");
			if ($qry) {
				$new_id = $conn->insert_id;
				return json_encode(['status' => 'success', 'message' => 'Medical record added successfully.']);
			} else {
				return json_encode(['status' => 'error', 'message' => 'Failed to add medical record.']);
			}
		}
	}

	public function save_product()
	{
		global $conn;

		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
		$price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
		$stocks = isset($_POST['stocks']) ? intval($_POST['stocks']) : 0;
		$description = isset($_POST['description']) ? $conn->real_escape_string($_POST['description']) : '';

		// Image upload handling
		$upload_dir = "../admin/products/";
		if (!is_dir($upload_dir)) {
			mkdir($upload_dir, 0777, true);
		}

		// Check if an image file is uploaded
		if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
			$image_path = $upload_dir . $id . ".png";
			move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
		}

		if ($id) {
			// Update existing product
			$qry = $conn->query("UPDATE `products` SET `name` = '$name', `price` = '$price', `stocks` = '$stocks', `description` = '$description' WHERE id = $id");
			if ($qry) {
				return json_encode(['status' => 'success', 'message' => 'Product updated successfully.']);
			} else {
				return json_encode(['status' => 'error', 'message' => 'Failed to update product.']);
			}
		} else {
			// Insert new product
			$qry = $conn->query("INSERT INTO `products` (`name`, `price`, `stocks`, `description`) VALUES ('$name', '$price', '$stocks', '$description')");
			if ($qry) {
				$new_id = $conn->insert_id;
				// Rename image file based on new product ID
				if (isset($image_path) && file_exists($image_path)) {
					rename($image_path, $upload_dir . $new_id . ".png");
				}
				return json_encode(['status' => 'success', 'message' => 'Product added successfully.']);
			} else {
				return json_encode(['status' => 'error', 'message' => 'Failed to add product.']);
			}
		}
	}


	function save_appointment()
	{
		if (empty($_POST['id'])) {
			$prefix = "OVAS-" . date("Ym");
			$code = sprintf("%'.04d", 1);
			while (true) {
				$check = $this->conn->query("SELECT * FROM `appointment_list` where code = '{$prefix}{$code}' ")->num_rows;
				if ($check <= 0) {
					$_POST['code'] = $prefix . $code;
					break;
				} else {
					$code = sprintf("%'.04d", ceil($code) + 1);
				}
			}
		}
		$_POST['service_ids'] = implode(",", $_POST['service_id']);
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_array($_POST[$k])) {
				if (!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if (!empty($data))
					$data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (empty($id)) {
			$sql = "INSERT INTO `appointment_list` set {$data} ";
		} else {
			$sql = "UPDATE `appointment_list` set {$data} where id = '{$id}' ";
		}
		$slot_taken = $this->conn->query("SELECT * FROM `appointment_list` where date(schedule) = '{$schedule}' and `status` in (0,1)")->num_rows;
		if ($slot_taken >= $this->settings->info('max_appointment')) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Sorry, the Appointment Schedule is already full.";
		} else {
			$save = $this->conn->query($sql);
			if ($save) {
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['id'] = $rid;
				$resp['code'] = $code;
				$resp['status'] = 'success';
				if (empty($id))
					$resp['msg'] = "New Appointment Details has successfully added.</b>.";
				else
					$resp['msg'] = "Appointment Details has been updated successfully.";

			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error . "[{$sql}]";
			}
		}

		if ($resp['status'] == 'success')
			$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	function delete_appointment()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `appointment_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Appointment Details has been deleted successfully.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_appointment_status()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `appointment_list` set `status` = '{$status}' where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Appointment Request status has successfully updated.");

		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_appointment':
		echo $Master->save_appointment();
		break;
	case 'delete_appointment':
		echo $Master->delete_appointment();
		break;
	case 'update_appointment_status':
		echo $Master->update_appointment_status();
		break;
	case 'save_message':
		echo $Master->save_message();
		break;
	case 'delete_message':
		echo $Master->delete_message();
		break;
	case 'save_category':
		echo $Master->save_category();
		break;
	case 'delete_category':
		echo $Master->delete_category();
		break;
	case 'save_service':
		echo $Master->save_service();
		break;
	case 'delete_service':
		echo $Master->delete_service();
		break;
	case 'delete_product':
		echo $Master->delete_product();
		break;
	case 'delete_record':
		echo $Master->delete_record();
		break;
	case 'save_product':
		echo $Master->save_product();
		break;
	case 'save_medical_record':
		echo $Master->save_medical_record();
		break;
	default:
		// echo $sysset->index();
		break;
}