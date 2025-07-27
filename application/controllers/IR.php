<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Input $input
 * @property IR_model $IR_model
 * @property employee_model $employee_model
 * @property settings_model $settings_model
 * @property leave_model $leave_model
 * /**
 * @property CI_DB_query_builder $db
 */



class IR extends CI_Controller {

    public function __construct() {
    parent::__construct();
    $this->load->model('IR_model');
    $this->load->model('employee_model');
    $this->load->model('settings_model');
    $this->load->model('leave_model'); // ✅ Add this
    $this->load->library('session');
    $this->load->helper('url');

    if (!$this->session->userdata('user_login_access')) {
        redirect('Login');
    }
}



    // List all IRs
    public function index() {
        $data['irview']   = $this->IR_model->getAllIRs();
        $data['employee'] = $this->employee_model->emselect();
        $this->load->view('backend/ir', $data);
    }

    // Add or Update IR
    public function Add_IR() {
    $id = $this->input->post('id');
    $emp_id = $this->input->post('emid');

    // Fetch full name from employee table
    $employee = $this->db->get_where('employee', ['em_id' => $emp_id])->row();
    $full_name = '';
    if ($employee) {
        $full_name = $employee->first_name . ' ' . $employee->last_name;
    }

    $data = array(
        'emp_id'      => $emp_id,
        'full_name'   => $full_name, // This will go into the DB
        'position'    => $this->input->post('position'),
        'ir_date'     => $this->input->post('ir_date'),
        'ir_details'  => $this->input->post('ir_details'),
        'prevent'     => $this->input->post('prevent')
    );

    if ($id) {
        $this->IR_model->updateIR($id, $data);
        $this->session->set_flashdata('feedback', 'Updated Successfully');
    } else {
        $this->IR_model->addIR($data);  // or insert_IR($data), whichever you use
        $this->session->set_flashdata('feedback', 'Added Successfully');
    }

    redirect('IR');
}


    // Get IR by ID (AJAX)
    public function ir_by_id() {
        $id = $this->input->get('id', TRUE);
        $data['irvalue'] = $this->IR_model->getIRById($id);
        echo json_encode($data);
    }
}
