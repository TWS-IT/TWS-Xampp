<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Input $input
 * @property Warning_model $Warning_model
 * @property employee_model $employee_model
 * @property settings_model $settings_model
 */

class Warning extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Warning_model');
        $this->load->model('employee_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->library('session');
        $this->load->helper('url');

        if (!$this->session->userdata('user_login_access')) {
            redirect('Login');
        }
    }

    // List all Warnings
    public function index()
    {
        $data['warnings'] = $this->Warning_model->getAllWarnings();
        $data['employee'] = $this->employee_model->emselect();

        $this->load->view('backend/warning', $data);
    }

    // Show form to create new warning
    public function create()
    {
        $data['employee'] = $this->employee_model->emselect();
        $this->load->view('backend/add_warning', $data);
    }

    // Show form to edit an existing warning
    public function edit($id)
    {
        $data['employee'] = $this->employee_model->emselect();
        $data['warning'] = $this->Warning_model->getWarningById($id);

        if (!$data['warning']) {
            show_404();
        }

        $this->load->view('backend/add_warning', $data);
    }

    // Insert or update warning
    public function save()
    {
        $id = $this->input->post('id');
        $emp_id = $this->input->post('emid');

        $this->db->where(['em_id' => $emp_id]);
        $employee = $this->db->get('employee')->row();

        $data = array(
            'employee_id'         => $employee ? $employee->em_code : null,
            'employee_name' => $employee ? $employee->first_name . ' ' . $employee->last_name : null,
            'designation' => $employee ? $employee->em_role : null,
            'reason_for_warning' => $this->input->post('reason_for_warning'),
            'sub_reasons' => $this->input->post('sub_reasons'),
            'brief_explanation' => $this->input->post('brief_explanation'),
            'supervisors_comments' => $this->input->post('supervisors_comments'),
            'acknowledgement' => $this->input->post('acknowledgement'),
            'skp_requested_approval' => $this->input->post('skp_requested_approval'),
            'dh_requested_approval' => $this->input->post('dh_requested_approval')
        );

        if ($id) {
            $this->Warning_model->updateWarning($id, $data);
            $this->session->set_flashdata('feedback', 'Warning Updated Successfully');
        } else {
            $result = $this->Warning_model->insertWarning($data);
            if ($result) {
                $this->session->set_flashdata('feedback', 'Warning Added Successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to add warning');
            }
        }

        redirect('Warning');
    }

    // Delete Warning
    public function delete_warning()
    {
        $id = $this->input->post('id');
        if ($this->Warning_model->deleteWarning($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
        }
    }

    // Get employee’s project by em_id
    public function get_employee_project($em_id)
    {
        $this->db->select('project');
        $this->db->from('employee');
        $this->db->where('em_id', $em_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            echo json_encode(['project' => $query->row()->project]);
        } else {
            echo json_encode(['project' => '']);
        }
    }

    public function get_employee_details($em_id)
    {
        $this->db->select('employee.em_code, designation.des_name');
        $this->db->from('employee');
        $this->db->join('designation', 'designation.id = employee.des_id', 'left');
        $this->db->where('employee.em_id', $em_id);
        $employee = $this->db->get()->row();

        if ($employee) {
            echo json_encode([
                'em_code' => $employee->em_code,
                'designation' => $employee->des_name
            ]);
        } else {
            echo json_encode([]);
        }
    }




}
