<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emp_Perfomance extends CI_Controller
{
     private $project_tables = [
        'w_order',
        'atas_order',
        'w1w_deposit_order',
        'w1w_w',
        'k8_d',
        'k8_w',
    ];
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
                'pro_name' => $employee['pro_name'] ?? 'N/A',
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
        'pro_name'      => $employee->pro_name,
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

    $combined_data = [];

    foreach ($this->project_tables as $table) {
        $query = $this->db->query("
            SELECT DATE(order_date) AS date, SUM(order_count) AS total_orders
            FROM $table
            WHERE employee_id = ?
            GROUP BY DATE(order_date)
            ORDER BY DATE(order_date) ASC
        ", [$em_code]);

        foreach ($query->result() as $row) {
            if (isset($combined_data[$row->date])) {
                $combined_data[$row->date] += (int)$row->total_orders;
            } else {
                $combined_data[$row->date] = (int)$row->total_orders;
            }
        }
    }

    // Sort by date ascending
    ksort($combined_data);

    // Format for chartjs (or frontend)
    $performance_data = [];
    foreach ($combined_data as $date => $total_orders) {
        $performance_data[] = [
            'x' => strtotime($date) * 1000,
            'y' => $total_orders
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($performance_data);
}
public function get_shift_order_data($em_code, $shift = null)
{
    if (!$em_code) {
        show_error("Employee code is required", 400);
        return;
    }

    $combined_results = [];

    foreach ($this->project_tables as $table) {
        $this->db->select("employee_id, order_date, shift, pc_position, SUM(order_count) as order_count", false);
        $this->db->from($table);
        $this->db->where("employee_id", $em_code);

        if (!empty($shift)) {
            $this->db->where("shift", $shift);
        }

        $this->db->group_by(["order_date", "shift", "pc_position"]);
        $this->db->order_by("order_date", "ASC");

        $query = $this->db->get();

        foreach ($query->result() as $row) {
            // Use a key to combine rows by date, shift and position
            $key = $row->order_date . '|' . $row->shift . '|' . $row->pc_position;

            if (isset($combined_results[$key])) {
                // Add order_count if duplicate group found across tables
                $combined_results[$key]->order_count += $row->order_count;
            } else {
                // Add new record
                $combined_results[$key] = $row;
            }
        }
    }

    // Sort combined results by order_date ascending
    usort($combined_results, function($a, $b) {
        return strtotime($a->order_date) - strtotime($b->order_date);
    });

    header('Content-Type: application/json');
    echo json_encode(array_values($combined_results));
}







}
