<?php
/* <!--  START 
===============================================
Version :- V.2 		Author : ''    23-July-2020
=============================================== 
-->
*/
defined('BASEPATH') or exit('No direct script access allowed');

class Invoices extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model(['workspace_model', 'invoices_model', 'notifications_model', 'users_model', 'items_model', 'tax_model', 'units_model', 'projects_model', 'payments_model']);
		$this->load->library(['ion_auth', 'form_validation', 'Pdf']);
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
			$workspace_id = $this->session->userdata('workspace_id');
			$data['total'] = $this->invoices_model->get_count($workspace_id);
			$data['fully_paid'] = $this->invoices_model->get_count($workspace_id, 1);
			$data['partially_paid'] = $this->invoices_model->get_count($workspace_id, 2);
			$data['draft'] = $this->invoices_model->get_count($workspace_id, 3);
			$data['cancelled'] = $this->invoices_model->get_count($workspace_id, 4);
			$data['due'] = $this->invoices_model->get_count($workspace_id, 5);
			$data['not_assigned'] = $this->invoices_model->get_not_assigned($workspace_id);
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$this->load->view('invoices', $data);
		}
	}
	public function create_invoice()
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
			$projects = $this->projects_model->get_projects($workspace[0]->id);
			$data['projects'] = $projects;
			$data['items'] = $this->items_model->get_items($workspace[0]->id);
			$data['taxes'] = $this->tax_model->get_taxes($workspace[0]->id);
			$data['units'] = $this->units_model->get_units($workspace[0]->id);
			$data['all_user'] = $this->users_model->get_user($user_ids, ['3']);
			$workspace_id = $this->session->userdata('workspace_id');
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$this->load->view('create-invoice', $data);
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
				'workspace_id' => $this->session->userdata('workspace_id'),
				'client_id' => strip_tags($this->input->post('client_id', true)),
				'project_id' => strip_tags($this->input->post('project_id', true)),
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
				'invoice_date' => strip_tags($this->input->post('invoice_date', true)),
				'due_date' => strip_tags($this->input->post('due_date', true))
			);
			$invoice_date = $this->input->post('invoice_date');
			$due_date = $this->input->post('due_date');
			if ($due_date < $invoice_date) {
				$response['error'] = true;
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				$response['message'] = 'Due date must be greater than invoice date';
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
				$invoice_id = $this->invoices_model->add_invoice($data);
				$invoice_item_ids = [];
				if ($invoice_id != false) {

					for ($i = 0; $i < count($titles); $i++) {
						$data = array(
							'invoice_id' => strip_tags($invoice_id, true),
							'item_id' => $item_ids[$i],
							'description' => $descriptions[$i],
							'qty' => $qtys[$i],
							'unit_id' => $unit_ids[$i],
							'rate' => $rates[$i],
							'tax_id' => $tax_ids[$i],
							'workspace_id' => $this->session->userdata('workspace_id')
						);
						$invoice_item_id = $this->invoices_model->add_invoice_item($data);
						if ($invoice_item_id != false) {
							array_push($invoice_item_ids, $invoice_item_id);
						}
					}
					$invoice_item_ids = implode(",", $invoice_item_ids);
					$data = array(
						'invoice_items_ids' => $invoice_item_ids
					);
					$this->invoices_model->update_invoice($data, $invoice_id);
					$this->session->set_flashdata('message', 'Invoice created successfully.');
					$this->session->set_flashdata('message_type', 'success');
				} else {
					$this->session->set_flashdata('message', 'Invoice could not Created! Try again!');
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
		redirect('invoices', 'refresh');
	}
	public function edit_invoice()
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
			$invoice_id = $this->uri->segment(3);

			if (empty($invoice_id) || !is_numeric($invoice_id) || $invoice_id < 1) {
				redirect('invoices', 'refresh');
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
			$projects = $this->projects_model->get_projects($workspace[0]->id);
			$data['projects'] = $projects;
			$data['items'] = $this->items_model->get_items($workspace[0]->id);
			$data['taxes'] = $this->tax_model->get_taxes($workspace[0]->id);
			$data['units'] = $this->units_model->get_units($workspace[0]->id);
			$data['all_user'] = $this->users_model->get_user($user_ids, ['3']);
			$data['invoice_id'] = $invoice_id;
			$data['invoice_items'] = $this->invoices_model->get_invoice_items($invoice_id);
			$workspace_id = $this->session->userdata('workspace_id');
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$this->load->view('edit-invoice', $data);
		}
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
				'workspace_id' => $this->session->userdata('workspace_id'),
				'project_id' => strip_tags($this->input->post('project_id', true)),
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
				'invoice_date' => strip_tags($this->input->post('invoice_date', true)),
				'due_date' => strip_tags($this->input->post('due_date', true))
			);
			$invoice_date = $this->input->post('invoice_date');
			$due_date = $this->input->post('due_date');
			if ($due_date < $invoice_date) {
				$response['error'] = true;
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				$response['message'] = 'Due date must be greater than invoice date';
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
			$invoice_item_ids = $this->input->post("invoice_item_id");
			if (!empty($titles)) {
				$invoice_id = $this->input->post('invoice_id');
				$invoice_item_ids_array = [];
				if ($this->invoices_model->update_invoice($data, $invoice_id)) {

					for ($i = 0; $i < count($titles); $i++) {
						$data = array(
							'invoice_id' => strip_tags($invoice_id, true),
							'item_id' => $item_ids[$i],
							'description' => $descriptions[$i],
							'qty' => $qtys[$i],
							'unit_id' => $unit_ids[$i],
							'rate' => $rates[$i],
							'tax_id' => $tax_ids[$i],
							'workspace_id' => $this->session->userdata('workspace_id')
						);
						if (!empty($invoice_item_ids[$i])) {
							$this->invoices_model->update_invoice_item($data, $invoice_item_ids[$i]);
							array_push($invoice_item_ids_array, $invoice_item_ids[$i]);
						} else {
							$invoice_item_id = $this->invoices_model->add_invoice_item($data);
							if ($invoice_item_id != false) {
								array_push($invoice_item_ids_array, $invoice_item_id);
							}
						}
					}
					$invoice_item_ids = implode(",", $invoice_item_ids_array);
					$data = array(
						'invoice_items_ids' => $invoice_item_ids
					);
					$this->invoices_model->update_invoice($data, $invoice_id);
					if (!empty($_POST['deleted_item_ids'])) {
						$deleted_item_ids = explode(",", $_POST['deleted_item_ids']);
						for ($k = 0; $k < count($deleted_item_ids); $k++) {
							$this->invoices_model->delete_invoice_item($deleted_item_ids[$k]);
						}
					}


					$this->session->set_flashdata('message', 'Invoice updated successfully.');
					$this->session->set_flashdata('message_type', 'success');
				} else {
					$this->session->set_flashdata('message', 'Invoice could not update! Try again!');
					$this->session->set_flashdata('message_type', 'error');
				}
			}else{
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
	public function get_invoices_list()
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
			return $this->invoices_model->get_invoices_list($workspace_id);
		}
	}
	public function view_invoice()
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
			$invoice_id = $this->uri->segment(3);

			if (empty($invoice_id) || !is_numeric($invoice_id) || $invoice_id < 1) {
				redirect('invoices', 'refresh');
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
			$invoice = $this->invoices_model->get_invoice_by_id($invoice_id);
			$data['invoice'] = $invoice[0];
			$data['my_fonts'] = file_get_contents("assets/fonts/my-fonts.json");
			$data['invoice_items'] = $this->invoices_model->get_invoice_items($invoice_id);
			$workspace_id = $this->session->userdata('workspace_id');
			$data['payments'] = $this->payments_model->get_payments_by_invoice_id($invoice_id);
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$this->load->view('view-invoice', $data);
		}
	}
	public function invoice()
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
			$invoice_id = $this->uri->segment(3);

			if (empty($invoice_id) || !is_numeric($invoice_id) || $invoice_id < 1) {
				redirect('invoices', 'refresh');
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
			$data['all_user'] = $this->users_model->get_user($user_ids, ['1', '2', '3']);
			$invoice = $this->invoices_model->get_invoice_by_id($invoice_id);
			$data['invoice'] = $invoice[0];
			$data['invoice_items'] = $this->invoices_model->get_invoice_items($invoice_id);
			$workspace_id = $this->session->userdata('workspace_id');
			$data['invoices'] = $this->invoices_model->get_invoices($workspace_id);
			$data['payment_modes'] = $this->payments_model->get_payment_modes($workspace_id);
			$data['payments'] = $this->payments_model->get_payments_by_invoice_id($invoice_id);
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$this->load->view('invoice', $data);
		}
	}
	public function get_invoice_by_id()
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

			$invoice_id = $this->input->post('id');

			if (empty($invoice_id) || !is_numeric($invoice_id)) {
				redirect('invoices', 'refresh');
				return false;
				exit(0);
			}
			$data = $this->invoices_model->get_invoice_by_id($invoice_id);
			$data[0]['invoice_date'] = date('Y-m-d\TH:i', strtotime($data[0]['invoice_date']));
			$data[0]['due_date'] = date('Y-m-d\TH:i', strtotime($data[0]['due_date']));
			$data[0]['csrfName'] = $this->security->get_csrf_token_name();
			$data[0]['csrfHash'] = $this->security->get_csrf_hash();

			echo json_encode($data[0]);
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
			if ($this->invoices_model->delete_invoice($id)) {
				$this->session->set_flashdata('message', 'Invoice deleted successfully.');
				$this->session->set_flashdata('message_type', 'success');
			} else {
				$this->session->set_flashdata('message', 'Invoice could not be deleted! Try again!');
				$this->session->set_flashdata('message_type', 'error');
			}
		}
		redirect('invoices', 'refresh');
	}
}
/* 
// END
// ===============================================
// Version : V.2 		Author : ''    23-July-2020
// =============================================== 
*/
