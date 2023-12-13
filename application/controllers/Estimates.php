<?php
/* <!--  START 
===============================================
Version :- V.2 		Author : ''    23-July-2020
=============================================== 
-->
*/
defined('BASEPATH') or exit('No direct script access allowed');

class Estimates extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model(['workspace_model', 'estimates_model', 'notifications_model', 'users_model', 'items_model', 'tax_model', 'units_model']);
		$this->load->library(['ion_auth', 'form_validation', 'pagination', 'Pdf']);
		$this->load->helper(['url', 'language']);
		$this->load->library('session');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		} else {
			if (!is_admin()) {
				$this->session->set_flashdata('message', 'You are not authorized to access this page!');
				$this->session->set_flashdata('message_type', 'error');
				redirect('home', 'refresh');
				return false;
				exit();
			}
			$data['user'] = $user = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : array();

			$product_ids = explode(',', $user->workspace_id);

			$section = array_map('trim', $product_ids);

			$product_ids = $section;

			$data['workspace'] = $workspace = $this->workspace_model->get_workspace($product_ids);
			if (!empty($workspace)) {
				if (!$this->session->has_userdata('workspace_id')) {
					$this->session->set_userdata('workspace_id', $workspace[0]->id);
				}
			}
			$current_workspace_id = $this->workspace_model->get_workspace($this->session->userdata('workspace_id'));
			$user_ids = explode(',', $current_workspace_id[0]->user_id);
			$section = array_map('trim', $user_ids);
			$user_ids = $section;
			$workspace_id = $this->session->userdata('workspace_id');
			$data['total'] = $this->estimates_model->get_count($workspace_id);
			$data['sent'] = $this->estimates_model->get_count($workspace_id, 1);
			$data['accepted'] = $this->estimates_model->get_count($workspace_id, 2);
			$data['draft'] = $this->estimates_model->get_count($workspace_id, 3);
			$data['declined'] = $this->estimates_model->get_count($workspace_id, 4);
			$data['expired'] = $this->estimates_model->get_count($workspace_id, 5);
			$data['not_assigned'] = $this->estimates_model->get_not_assigned($workspace_id);
			$data['all_user'] = $this->users_model->get_user($user_ids);
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$this->load->view('estimates', $data);
		}
	}
	public function get_estimates_list()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		} else {
			if (!is_admin()) {
				$this->session->set_flashdata('message', 'You are not authorized to access this page!');
				$this->session->set_flashdata('message_type', 'error');
				redirect('home', 'refresh');
				return false;
				exit();
			}
			$workspace_id = $this->session->userdata('workspace_id');
			return $this->estimates_model->get_estimates_list($workspace_id);
		}
	}
	public function create_estimate()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		} else {
			if (!is_admin()) {
				$this->session->set_flashdata('message', 'You are not authorized to access this page!');
				$this->session->set_flashdata('message_type', 'error');
				redirect('home', 'refresh');
				return false;
				exit();
			}
			$data['user'] = $user = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : array();

			$product_ids = explode(',', $user->workspace_id);

			$section = array_map('trim', $product_ids);

			$product_ids = $section;

			$data['workspace'] = $workspace = $this->workspace_model->get_workspace($product_ids);
			if (!empty($workspace)) {
				if (!$this->session->has_userdata('workspace_id')) {
					$this->session->set_userdata('workspace_id', $workspace[0]->id);
				}
			}
			$current_workspace_id = $this->workspace_model->get_workspace($this->session->userdata('workspace_id'));
			$user_ids = explode(',', $current_workspace_id[0]->user_id);
			$section = array_map('trim', $user_ids);
			$user_ids = $section;
			$data['currency'] = get_currency_symbol();
			$data['items'] = $this->items_model->get_items($workspace[0]->id);
			$data['taxes'] = $this->tax_model->get_taxes($workspace[0]->id);
			$data['units'] = $this->units_model->get_units($workspace[0]->id);
			$data['all_user'] = $this->users_model->get_user($user_ids, ['3']);
			$workspace_id = $this->session->userdata('workspace_id');
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$this->load->view('create-estimate', $data);
		}
	}
	public function create()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		}
		if (!is_admin()) {
			$this->session->set_flashdata('message', 'You are not authorized to access this page!');
			$this->session->set_flashdata('message_type', 'error');
			redirect('home', 'refresh');
			return false;
			exit();
		}

		$this->form_validation->set_rules('client_id', 'Client', 'trim|required');
		$this->form_validation->set_rules('final_total', 'Final total', 'trim|required');

		if ($this->form_validation->run() === TRUE) {

			$data = array(
				'client_id' => strip_tags($this->input->post('client_id', true)),
				'status' => strip_tags($this->input->post('status', true)),
				'name' => strip_tags($this->input->post('name', true)),
				'address' => strip_tags($this->input->post('address', true)),
				'city' => strip_tags($this->input->post('city', true)),
				'state' => strip_tags($this->input->post('state', true)),
				'country' => strip_tags($this->input->post('country', true)),
				'zip_code' => strip_tags($this->input->post('zip_code', true)),
				'contact' => strip_tags($this->input->post('contact', true)),
				'note' => strip_tags($this->input->post('note', true)),
				'personal_note' => strip_tags($this->input->post('personal_note', true)),
				'amount' => strip_tags($this->input->post('final_total', true)),
				'status' => strip_tags($this->input->post('status', true)),
				'estimate_date' => strip_tags($this->input->post('estimate_date', true)),
				'valid_upto_date' => strip_tags($this->input->post('expiry_date', true)),
				'workspace_id' => $this->session->userdata('workspace_id')
			);
			$estimate_date = $this->input->post('estimate_date');
			$expiry_date = $this->input->post('expiry_date');
			if ($expiry_date < $estimate_date) {
				$response['error'] = true;
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				$response['message'] = 'Expiry date must be greater than estimate date';
				echo json_encode($response);
				return false;
				exit();
			}


			$titles = $this->input->post("title");
			$item_ids = $this->input->post("item");
			$descriptions = $this->input->post("description");
			$qtys = $this->input->post("quantity");
			$unit_ids = $this->input->post("unit");
			$rates = $this->input->post("rate");
			$tax_ids = $this->input->post("tax");
			if (!empty($titles)) {
				$estimate_id = $this->estimates_model->add_estimate($data);
				$estimate_item_ids = [];
				if ($estimate_id != false) {
					for ($i = 0; $i < count($titles); $i++) {
						$data = array(
							'estimate_id' => strip_tags($estimate_id, true),
							'item_id' => $item_ids[$i],
							'description' => $descriptions[$i],
							'qty' => $qtys[$i],
							'unit_id' => $unit_ids[$i],
							'rate' => $rates[$i],
							'tax_id' => $tax_ids[$i],
							'workspace_id' => $this->session->userdata('workspace_id')
						);
						$estimate_item_id = $this->estimates_model->add_estimate_item($data);
						if ($estimate_item_id != false) {
							array_push($estimate_item_ids, $estimate_item_id);
						}
						$estimate_item_ids = implode(",", $estimate_item_ids);
						$data = array(
							'estimate_items_ids' => $estimate_item_ids
						);
						$this->estimates_model->update_estimate($data, $estimate_id);
						$this->session->set_flashdata('message', 'Estimate created successfully.');
						$this->session->set_flashdata('message_type', 'success');
					}
				} else {
					$this->session->set_flashdata('message', 'Estimate could not Created! Try again!');
					$this->session->set_flashdata('message_type', 'error');
				}
			} else {
				$response['error'] = true;
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				$response['message'] = 'Please add at least one product/service';
				echo json_encode($response);
				return false;
				exit();
			}

			$response['error'] = false;
			$response['csrfName'] = $this->security->get_csrf_token_name();
			$response['csrfHash'] = $this->security->get_csrf_hash();
			$response['message'] = 'Successful';
			echo json_encode($response);
		} else {
			$response['error'] = true;
			$response['csrfName'] = $this->security->get_csrf_token_name();
			$response['csrfHash'] = $this->security->get_csrf_hash();
			$response['message'] = validation_errors();
			echo json_encode($response);
		}
		redirect('estimates', 'refresh');
	}
	public function edit()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		}
		if (!is_admin()) {
			$this->session->set_flashdata('message', 'You are not authorized to access this page!');
			$this->session->set_flashdata('message_type', 'error');
			redirect('home', 'refresh');
			return false;
			exit();
		}

		$this->form_validation->set_rules('client_id', 'Client', 'trim|required');
		$this->form_validation->set_rules('final_total', 'Final total', 'trim|required');

		if ($this->form_validation->run() === TRUE) {

			$data = array(
				'client_id' => strip_tags($this->input->post('client_id', true)),
				'status' => strip_tags($this->input->post('status', true)),
				'name' => strip_tags($this->input->post('name', true)),
				'address' => strip_tags($this->input->post('address', true)),
				'city' => strip_tags($this->input->post('city', true)),
				'state' => strip_tags($this->input->post('state', true)),
				'country' => strip_tags($this->input->post('country', true)),
				'zip_code' => strip_tags($this->input->post('zip_code', true)),
				'contact' => strip_tags($this->input->post('contact', true)),
				'note' => strip_tags($this->input->post('note', true)),
				'personal_note' => strip_tags($this->input->post('personal_note', true)),
				'amount' => strip_tags($this->input->post('final_total', true)),
				'status' => strip_tags($this->input->post('status', true)),
				'estimate_date' => strip_tags($this->input->post('estimate_date', true)),
				'valid_upto_date' => strip_tags($this->input->post('expiry_date', true)),
				'workspace_id' => $this->session->userdata('workspace_id')
			);
			$estimate_date = $this->input->post('estimate_date');
			$expiry_date = $this->input->post('expiry_date');
			if ($expiry_date < $estimate_date) {
				$response['error'] = true;
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				$response['message'] = 'Expiry date must be greater than estimate date';
				echo json_encode($response);
				return false;
				exit();
			}
			$titles = $this->input->post("title");
			$item_ids = $this->input->post("item");
			$descriptions = $this->input->post("description");
			$qtys = $this->input->post("quantity");
			$unit_ids = $this->input->post("unit");
			$rates = $this->input->post("rate");
			$tax_ids = $this->input->post("tax");
			$estimate_item_ids = $this->input->post("estimate_item_id");
			if (!empty($titles)) {
				$estimate_id = $this->input->post('estimate_id');
				$estimate_item_ids_array = [];
				if ($this->estimates_model->update_estimate($data, $estimate_id)) {
					for ($i = 0; $i < count($titles); $i++) {
						$data = array(
							'estimate_id' => strip_tags($estimate_id, true),
							'item_id' => $item_ids[$i],
							'description' => $descriptions[$i],
							'qty' => $qtys[$i],
							'unit_id' => $unit_ids[$i],
							'rate' => $rates[$i],
							'tax_id' => $tax_ids[$i],
							'workspace_id' => $this->session->userdata('workspace_id')
						);
						if (!empty($estimate_item_ids[$i])) {
							$this->estimates_model->update_estimate_item($data, $estimate_item_ids[$i]);
							array_push($estimate_item_ids_array, $estimate_item_ids[$i]);
						} else {
							$estimate_item_id = $this->estimates_model->add_estimate_item($data);
							if ($estimate_item_id != false) {
								array_push($estimate_item_ids_array, $estimate_item_id);
							}
						}
					}
					$estimate_item_ids = implode(",", $estimate_item_ids_array);
					$data = array(
						'estimate_items_ids' => $estimate_item_ids
					);
					$this->estimates_model->update_estimate($data, $estimate_id);
					if (!empty($_POST['deleted_item_ids'])) {
						$deleted_item_ids = explode(",", $_POST['deleted_item_ids']);
						for ($k = 0; $k < count($deleted_item_ids); $k++) {
							$this->estimates_model->delete_estimate_item($deleted_item_ids[$k]);
						}
					}


					$this->session->set_flashdata('message', 'Estimate updated successfully.');
					$this->session->set_flashdata('message_type', 'success');
				} else {
					$this->session->set_flashdata('message', 'Estimate could not update! Try again!');
					$this->session->set_flashdata('message_type', 'error');
				}

				$response['error'] = false;
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				$response['message'] = 'Successful';
				echo json_encode($response);
			} else {
				$response['error'] = true;
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				$response['message'] = 'Please add at least one product/service';
				echo json_encode($response);
				return false;
				exit();
			}
		} else {
			$response['error'] = true;
			$response['csrfName'] = $this->security->get_csrf_token_name();
			$response['csrfHash'] = $this->security->get_csrf_hash();
			$response['message'] = validation_errors();
			echo json_encode($response);
		}

		redirect('estimates', 'refresh');
	}
	public function edit_estimate()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		} else {
			if (!is_admin()) {
				$this->session->set_flashdata('message', 'You are not authorized to access this page!');
				$this->session->set_flashdata('message_type', 'error');
				redirect('home', 'refresh');
				return false;
				exit();
			}
			$estimate_id = $this->uri->segment(3);

			if (empty($estimate_id) || !is_numeric($estimate_id) || $estimate_id < 1) {
				redirect('estimates', 'refresh');
				return false;
				exit(0);
			}
			$data['user'] = $user = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : array();

			$product_ids = explode(',', $user->workspace_id);

			$section = array_map('trim', $product_ids);

			$product_ids = $section;

			$data['workspace'] = $workspace = $this->workspace_model->get_workspace($product_ids);
			if (!empty($workspace)) {
				if (!$this->session->has_userdata('workspace_id')) {
					$this->session->set_userdata('workspace_id', $workspace[0]->id);
				}
			}
			$current_workspace_id = $this->workspace_model->get_workspace($this->session->userdata('workspace_id'));
			$user_ids = explode(',', $current_workspace_id[0]->user_id);
			$section = array_map('trim', $user_ids);
			$user_ids = $section;
			$data['currency'] = get_currency_symbol();
			$data['items'] = $this->items_model->get_items($workspace[0]->id);
			$data['taxes'] = $this->tax_model->get_taxes($workspace[0]->id);
			$data['units'] = $this->units_model->get_units($workspace[0]->id);
			$data['all_user'] = $this->users_model->get_user($user_ids, ['3']);
			$data['estimate_id'] = $estimate_id;
			$data['estimate_items'] = $this->estimates_model->get_estimate_items($estimate_id);
			$workspace_id = $this->session->userdata('workspace_id');
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$this->load->view('edit-estimate', $data);
		}
	}

	public function estimate()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		} else {
			if (!is_admin()) {
				$this->session->set_flashdata('message', 'You are not authorized to access this page!');
				$this->session->set_flashdata('message_type', 'error');
				redirect('home', 'refresh');
				return false;
				exit();
			}
			$estimate_id = $this->uri->segment(3);

			if (empty($estimate_id) || !is_numeric($estimate_id) || $estimate_id < 1) {
				redirect('estimates', 'refresh');
				return false;
				exit(0);
			}
			$data['user'] = $user = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : array();

			$product_ids = explode(',', $user->workspace_id);

			$section = array_map('trim', $product_ids);

			$product_ids = $section;

			$data['workspace'] = $workspace = $this->workspace_model->get_workspace($product_ids);
			if (!empty($workspace)) {
				if (!$this->session->has_userdata('workspace_id')) {
					$this->session->set_userdata('workspace_id', $workspace[0]->id);
				}
			}
			$current_workspace_id = $this->workspace_model->get_workspace($this->session->userdata('workspace_id'));
			$user_ids = explode(',', $current_workspace_id[0]->user_id);
			$section = array_map('trim', $user_ids);
			$user_ids = $section;
			$data['items'] = $this->items_model->get_items($workspace[0]->id);
			$data['taxes'] = $this->tax_model->get_taxes($workspace[0]->id);
			$data['units'] = $this->units_model->get_units($workspace[0]->id);
			$data['all_user'] = $this->users_model->get_user($user_ids, ['3']);
			$estimate = $this->estimates_model->get_estimate_by_id($estimate_id);
			$data['estimate'] = $estimate[0];
			$data['estimate_items'] = $this->estimates_model->get_estimate_items($estimate_id);
			$workspace_id = $this->session->userdata('workspace_id');
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$this->load->view('estimate', $data);
		}
	}

	public function get_estimate_by_id()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		} else {
			if (!is_admin()) {
				$this->session->set_flashdata('message', 'You are not authorized to access this page!');
				$this->session->set_flashdata('message_type', 'error');
				redirect('home', 'refresh');
				return false;
				exit();
			}

			$estimate_id = $this->input->post('id');

			if (empty($estimate_id) || !is_numeric($estimate_id)) {
				redirect('estimates', 'refresh');
				return false;
				exit(0);
			}
			$data = $this->estimates_model->get_estimate_by_id($estimate_id);
			$data[0]['estimate_date'] = date('Y-m-d\TH:i', strtotime($data[0]['estimate_date']));
			$data[0]['valid_upto_date'] = date('Y-m-d\TH:i', strtotime($data[0]['valid_upto_date']));
			$data[0]['csrfName'] = $this->security->get_csrf_token_name();
			$data[0]['csrfHash'] = $this->security->get_csrf_hash();

			echo json_encode($data[0]);
		}
	}

	public function view_estimate()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		} else {
			if (!is_admin()) {
				$this->session->set_flashdata('message', 'You are not authorized to access this page!');
				$this->session->set_flashdata('message_type', 'error');
				redirect('home', 'refresh');
				return false;
				exit();
			}
			$estimate_id = $this->uri->segment(3);

			if (empty($estimate_id) || !is_numeric($estimate_id) || $estimate_id < 1) {
				redirect('estimates', 'refresh');
				return false;
				exit(0);
			}
			$data['user'] = $user = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : array();

			$product_ids = explode(',', $user->workspace_id);

			$section = array_map('trim', $product_ids);

			$product_ids = $section;

			$data['workspace'] = $workspace = $this->workspace_model->get_workspace($product_ids);
			if (!empty($workspace)) {
				if (!$this->session->has_userdata('workspace_id')) {
					$this->session->set_userdata('workspace_id', $workspace[0]->id);
				}
			}
			$current_workspace_id = $this->workspace_model->get_workspace($this->session->userdata('workspace_id'));
			$user_ids = explode(',', $current_workspace_id[0]->user_id);
			$section = array_map('trim', $user_ids);
			$user_ids = $section;
			$data['items'] = $this->items_model->get_items($workspace[0]->id);
			$data['taxes'] = $this->tax_model->get_taxes($workspace[0]->id);
			$data['units'] = $this->units_model->get_units($workspace[0]->id);
			$data['all_user'] = $this->users_model->get_user($user_ids, ['3']);
			$estimate = $this->estimates_model->get_estimate_by_id($estimate_id);
			$data['estimate'] = $estimate[0];
			// $estimate_items = 
			$data['my_fonts'] = file_get_contents("assets/fonts/my-fonts.json");
			$data['estimate_items'] = $this->estimates_model->get_estimate_items($estimate_id);
			$workspace_id = $this->session->userdata('workspace_id');
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$this->load->view('view-estimate', $data);
		}
	}

	public function delete()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		}
		if (!is_admin()) {
			$this->session->set_flashdata('message', 'You are not authorized to access this page!');
			$this->session->set_flashdata('message_type', 'error');
			redirect('home', 'refresh');
			return false;
			exit();
		}

		$id = $this->uri->segment(3);
		if (!empty($id) && is_numeric($id)  || $id < 1) {
			if ($this->estimates_model->delete_estimate($id)) {
				$this->session->set_flashdata('message', 'Estimate deleted successfully.');
				$this->session->set_flashdata('message_type', 'success');
			} else {
				$this->session->set_flashdata('message', 'Estimate could not be deleted! Try again!');
				$this->session->set_flashdata('message_type', 'error');
			}
		}
		redirect('estimates', 'refresh');
	}
}
/* 
// END
// ===============================================
// Version : V.2 		Author : ''    23-July-2020
// =============================================== 
*/
