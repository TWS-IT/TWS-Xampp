<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emp_Perfomance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
        $this->load->model('Emp_Pr_Model');
        $this->load->model('employee_model');
        $this->load->model('leave_model');
    }

    public function index($employee_id = null)
    {
        if (!$employee_id) {
            show_error("Employee ID is required", 400);
            return;
        }


        $employee = $this->Emp_Pr_Model->get_employee_info($employee_id);

        if (!$employee) {
            show_error("Employee not found", 404);
            return;
        }


        $data = [
            'employee' => [
                'first_name' => $employee['first_name'] ?? 'N/A',
                'last_name' => $employee['last_name'] ?? '',
                'des_name' => $employee['des_name'] ?? 'N/A',
                'project' => $employee['project'] ?? 'N/A',
                'mistakes' => $employee['mistakes'] ?? 0,
                'efficiency' => $employee['efficiency'] ?? 0,
                'total_orders' => $employee['total_orders'] ?? 0,
                'profile_img' => $employee['profile_img'] ?? 'default.png',
            ],

        ];

        $this->load->view('backend/emp_perfomance', $data);
    }

  public function emp_perfomance($em_code = null)
{
    if (!$em_code) {
        show_error("Employee code is missing.", 400);
        return;
    }

    
    $employee = $this->db->get_where('employee', ['em_code' => $em_code])->row();

    if (!$employee) {
        show_error("Invalid employee code", 404);
        return;
    }

  
    $total_orders = $this->Emp_Pr_Model->get_total_orders($employee->em_code);

   
    $image_path = 'assets/images/users/' . $employee->em_image;
    $profile_img = (!empty($employee->em_image) && file_exists(FCPATH . $image_path))
        ? base_url($image_path)
        : base_url('assets/images/users/user.png');

   
    $data = [
        'profile_img'  => $profile_img,
        'first_name'   => $employee->first_name,
        'last_name'    => $employee->last_name,
        'des_id'       => $employee->des_id,
        'project'      => $employee->project,
        'total_orders' => $total_orders,
        'em_code'      => $employee->em_code,
        'employee'     => $employee,
        'employee_name' => $employee->first_name, 
    ];

   
    $this->load->view('backend/emp_perfomance', $data);
}

public function chart_view($em_code = null)
{
    if (!$em_code) {
        show_error("Employee code is required", 400);
        return;
    }

    $employee = $this->db->get_where('employee', ['em_code' => $em_code])->row();

    if (!$employee) {
        show_error("Invalid employee code", 404);
        return;
    }

   
    $performance_data = [];
    $dates = [];

   for ($day = 1; $day <= 31; $day++) {
    $date = date('Y-m-d', strtotime("2025-07-$day"));
    $order_count = $this->Emp_Pr_Model->get_daily_order_count($employee->em_code, $date);
    $dates[] = $day;
    $performance_data[] = $order_count;
}


    $data = [
        
        
        'employee_name' => $employee->first_name,
        'dates' => $dates,
        'performance_data' => $performance_data
    ];

    $this->load->view('backend/employee_performance', $data);
}

public function json_chart_data($em_code)
{
    if (!$em_code) {
        show_error("Employee code is required", 400);
        return;
    }

    $employee = $this->db->get_where('employee', ['em_code' => $em_code])->row();
    if (!$employee) {
        show_error("Invalid employee code", 404);
        return;
    }

    // Query performance data directly from your table
    $query = $this->db->query("
        SELECT DATE(order_date) AS date, SUM(order_count) AS total_orders
        FROM w_order
        WHERE employee_id = ?
        GROUP BY DATE(order_date)
        ORDER BY DATE(order_date) ASC
    ", [$em_code]);

    $performance_data = [];

    foreach ($query->result() as $row) {
        $performance_data[] = [
            'x' => strtotime($row->date) * 1000, 
            'y' => (int) $row->total_orders
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($performance_data);
}





}
