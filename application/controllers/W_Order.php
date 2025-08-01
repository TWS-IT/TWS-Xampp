<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Loader $load
 * @property CI_DB $db
 * @property login_model $login_model
 * @property dashboard_model $dashboard_model
 * @property employee_model $employee_model
 * @property W_model $W_Model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */


class W_Order extends CI_Controller {
    function __construct(){
       parent::__construct();
    $this->load->database();
    $this->load->model('login_model');
    $this->load->model('dashboard_model');
    $this->load->model('employee_model');
    $this->load->model('settings_model');
    $this->load->model('W_model');
    $this->load->model('leave_model');
    // $this->load->library('csvimport');
    // $this->load->library('form_validation');
    $this->load->helper('log');
    }
    
    public function index()
	{
        
		#Redirect to Admin dashboard after authentication
		if ($this->session->userdata('user_login_access') == 1)
			redirect('dashboard/Dashboard');
		$data = array();
         $data['orders'] = $this->W_model->get_orders_with_employee_names();
        $this->load->view('orders_view', $data);
		#$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
		$this->load->view('login');
	}

    public function Get_Data(){
        $data['employee']    = $this->employee_model->emselect();
        $data['w_order'] = $this->W_model->Get_w();
    }
public function Save_W() {
    if ($this->session->userdata('user_login_access') != False) { 
        $this->load->library('form_validation');

        // Validation rules based on form fields
        $this->form_validation->set_rules('pc_position', 'pc_position', 'trim|required|xss_clean');
        $this->form_validation->set_rules('employee_id', 'employee_id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('order_date', 'order_date', 'required');
$this->form_validation->set_rules('shift', 'shift', 'required');
$this->form_validation->set_rules('order_count', 'order_count', 'required');


        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            $data = array(
                'pc_position' => $this->input->post('pc_position'),
                'employee_id' => $this->input->post('employee_id'),
                'order_date'   => $this->input->post('order_date'),
                'shift'        => $this->input->post('shift'),
                'order_count' => $this->input->post('order_count'),
            );

            $this->W_model->Add_w($data);  // Make sure your model handles this
            $this->session->set_flashdata('feedback', 'Successfully Added');
            log_action($this, 'Save', "Order for employee '{$data['employee_id']}' added.");
            redirect('W_Order/W_order'); 
        }
    } else {
        redirect(base_url(), 'refresh');
    }        
}

    function W_order()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['employee'] = $this->employee_model->emselect();
			if ($this->session->userdata('user_type') == 'EMPLOYEE') {
				$id               = $this->session->userdata('user_login_id');
				$data['w_order'] = $this->W_model->Get_w();
			} else {
				$data['w_order'] = $this->W_model->Get_w();
			}

			$this->load->view('backend/w_order', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

   


}

?>