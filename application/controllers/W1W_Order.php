<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Loader $load
 * @property CI_DB $db
 * @property login_model $login_model
 * @property dashboard_model $dashboard_model
 * @property employee_model $employee_model
 * @property w1w_model $w1w_Model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */


class W1W_Order extends CI_Controller {
    function __construct(){
       parent::__construct();
    $this->load->database();
    $this->load->model('login_model');
    $this->load->model('dashboard_model');
    $this->load->model('employee_model');
    $this->load->model('settings_model');
    $this->load->model('w1w_model');
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
         $data['orders'] = $this->w1w_model->get_orders_with_employee_names();
        $this->load->view('orders_view', $data);
		#$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
		$this->load->view('login');
	}

    public function Get_Data(){
        $data['employee']    = $this->employee_model->emselectW1WDeposit();
        $data['w1w_order'] = $this->w1w_model->Get_w();
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

            $this->w1w_model->Add_w($data);  // Make sure your model handles this
            $this->session->set_flashdata('feedback', 'Successfully Added');
            log_action($this, 'Save', "Order for employee '{$data['employee_id']}' added.");
            redirect('W1W_Order/w1w_order'); 
        }
    } else {
        redirect(base_url(), 'refresh');
    }        
}

    function w1w_order()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['employee'] = $this->employee_model->emselectW1WDeposit();
			if ($this->session->userdata('user_type') == 'EMPLOYEE') {
				$id               = $this->session->userdata('user_login_id');
				$data['w1w_order'] = $this->w1w_model->Get_w();
			} else {
				$data['w1w_order'] = $this->w1w_model->Get_w();
			}

			$this->load->view('backend/w1w_order', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
    public function update_W() {
    if ($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('order_id');

        $data = array(
            'pc_position' => $this->input->post('pc_position'),
            'employee_id' => $this->input->post('employee_id'),
            'order_date'  => $this->input->post('order_date'),
            'shift'       => $this->input->post('shift'),
            'order_count' => $this->input->post('order_count'),
        );

        $this->w1w_model->update_W($id, $data);
        $this->session->set_flashdata('feedback', 'Order Updated Successfully');
        redirect('W1W_Order/w1w_order');
    } else {
        redirect(base_url(), 'refresh');
    }
}

public function Edit_W($id) {
    if ($this->session->userdata('user_login_access') != False) {
        $data['employee'] = $this->employee_model->emselectW1WDeposit();
        $data['order'] = $this->w1w_model->get_order_by_id($id);

        $this->load->view('backend/edit_w1w_order', $data); 
    } else {
        redirect(base_url(), 'refresh');
    }
}

public function Delete_W($id) {
    if ($this->session->userdata('user_login_access') != False) {
        $this->w1w_model->DeleteWOrder($id);
        $this->session->set_flashdata('feedback', 'Order Deleted Successfully');
        redirect('W1W_order/w1w_order');
    } else {
        redirect(base_url(), 'refresh');
    }
}

// public function get_all_orders_barline_chart_se()
// {
//     if (!$this->session->userdata('user_login_access')) {
//         echo json_encode(['error' => 'Unauthorized']);
//         return;
//     }

//     $start_date  = $this->input->get('start_date');
//     $end_date    = $this->input->get('end_date');
//     $employee_id = $this->input->get('employee_id'); 

//     if (empty($start_date) || empty($end_date)) {
//         echo json_encode(['error' => 'Start and end dates are required.']);
//         return;
//     }

//     $data = $this->w1w_model->get_filtered_barline_chart_se($start_date, $end_date, $employee_id);
//     echo json_encode($data);
// }




// 2nd

public function get_all_orders_barline_chart() {
    if ($this->session->userdata('user_login_access') != False) {
        $startDate = $this->input->get('date_from');
        $endDate   = $this->input->get('date_to');

        $data = $this->w1w_model->get_all_orders_for_barline_chart($startDate, $endDate);
        echo json_encode($data);
    } else {
        show_error("Unauthorized access", 403);
    }
}


// public function get_all_orders_barline_chart() {
//     if ($this->session->userdata('user_login_access') != False) {
//         $startDate   = $this->input->get('date_from');
//         $endDate     = $this->input->get('date_to');
//         $employee_id = $this->input->get('employee_id');

//         // Debugging: log the received inputs
//         log_message('debug', "Filter inputs - startDate: $startDate, endDate: $endDate, employee_id: $employee_id");

        
//         // You can also temporarily output them for quick debugging (remove or comment this in production)
//         // echo "startDate: $startDate, endDate: $endDate, employee_id: $employee_id";
//         // exit;

//         $data = $this->w1w_model->get_all_orders_for_barline_chart($startDate, $endDate, $employee_id);
//         echo json_encode($data);
//     } else {
//         show_error("Unauthorized access", 403);
//     }
// }





}

?>