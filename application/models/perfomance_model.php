<?php

class Perfomance_model extends CI_Model
{
    
  public function get_all_performance_data()
{
    $this->db->select('employee.em_code, CONCAT(employee.first_name, " ", employee.last_name) AS full_name, employee.em_image, project.pro_name AS project_name');
    $this->db->from('employee');
    $this->db->join('project', 'employee.pro_id = project.id', 'left'); // join to get project name
    $this->db->where('employee.status', 'ACTIVE');
    $employees = $this->db->get()->result();

    $data = [];

    foreach ($employees as $emp) {
        $em_code = $emp->em_code;
        $total_orders = $this->get_total_orders($em_code);

        $efficiency = $total_orders > 0 ? round(($total_orders / $total_orders) * 100) : 0;

        $data[] = [
            'em_image' => base_url('assets/images/users/' . $emp->em_image),
            'em_code' => $em_code,
            'full_name' => $emp->full_name,
            'project' => $emp->project_name ?? 'N/A', // now shows project name
            'total_orders' => $total_orders,
            'efficiency' => $efficiency
        ];
    }

    return $data;
}


    public function get_total_orders($em_code)
    {
       
        $tables = [
            'w_order' => ['employee_id', 'order_count'],
            'atas_order' => ['employee_id', 'order_count'],
            'w1w_order' => ['employee_id', 'order_count'],
            'w1w_withdrawal' => ['employee_id', 'order_count'],
            'k8_deposit' => ['employee_id', 'order_count'],
            'k8_withdrawal' => ['employee_id', 'order_count'],
        ];

        $total = 0;

        foreach ($tables as $table => [$employeeColumn, $orderCountColumn]) {
            if ($this->db->table_exists($table)) {
                $this->db->select_sum($orderCountColumn);
                $this->db->where($employeeColumn, $em_code);
                $query = $this->db->get($table);
                $result = $query->row();

                $sum = $result->$orderCountColumn ?? 0;
                $total += $sum;
            }
        }

        return $total;
    }

}
