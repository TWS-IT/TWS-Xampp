<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IR_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Insert a new Incident Report
    public function addIR($data) {
        return $this->db->insert('ir', $data);
    }

    // Get all Incident Reports with employee details
    public function getAllIRs() {
        $this->db->select('ir.*, employee.em_id, employee.first_name, employee.last_name, employee.em_code');

        $this->db->from('ir');
        $this->db->join('employee', 'ir.emp_id = employee.em_id', 'left');
        $this->db->order_by('ir.id', 'DESC');
        return $this->db->get()->result();
    }

    // Get IR by Employee ID
    public function getIRByEmpId($emp_id) {
        $this->db->select('ir.*, employee.em_id, first_name, last_name, em_code');
        $this->db->from('ir');
        $this->db->join('employee', 'ir.emp_id = employee.em_id', 'left');
        $this->db->where('ir.emp_id', $emp_id);
        return $this->db->get()->row();
    }

    // Get IR by IR ID
    public function getIRById($id) {
        $this->db->select('ir.*, employee.em_id, first_name, last_name, em_code');
        $this->db->from('ir');
        $this->db->join('employee', 'ir.emp_id = employee.em_id', 'left');
        $this->db->where('ir.id', $id);
        return $this->db->get()->row();
    }

    // Update IR by ID
    public function updateIR($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('ir', $data);
    }

    // Check if IR exists for a given employee
    public function checkEmployeeIR($emp_id) {
        return $this->db->get_where('ir', ['emp_id' => $emp_id])->row();
    }
}
