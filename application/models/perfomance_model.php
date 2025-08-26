<?php

class Perfomance_model extends CI_Model
{
    
<<<<<<< HEAD
  public function get_all_performance_data()
{
    $this->db->select('employee.em_code, CONCAT(employee.first_name, " ", employee.last_name) AS full_name, employee.em_image, project.pro_name AS project_name');
    $this->db->from('employee');
    $this->db->join('project', 'employee.pro_id = project.id', 'left'); // join to get project name
    $this->db->where('employee.status', 'ACTIVE');
=======
    public function get_all_performance_data()
{

    $this->db->select('em_code, CONCAT(first_name, " ", last_name) AS full_name, project, em_image');
    $this->db->from('employee');
    $this->db->where('status', 'ACTIVE');
>>>>>>> d2b80f29b3e75409dba6e05677707d905edac65f
    $employees = $this->db->get()->result();

    $data = [];

    foreach ($employees as $emp) {
        $em_code = $emp->em_code;
<<<<<<< HEAD
        $total_orders = $this->get_total_orders($em_code);

        $efficiency = $total_orders > 0 ? round(($total_orders / $total_orders) * 100) : 0;
=======

        $total_orders = $this->get_total_orders($em_code);

        $mistakes = rand(0, 5); 

        $efficiency = ($total_orders + $mistakes) > 0
            ? round(($total_orders / ($total_orders + $mistakes)) * 100)
            : 0;
>>>>>>> d2b80f29b3e75409dba6e05677707d905edac65f

        $data[] = [
            'em_image' => base_url('assets/images/users/' . $emp->em_image),
            'em_code' => $em_code,
            'full_name' => $emp->full_name,
<<<<<<< HEAD
            'project' => $emp->project_name ?? 'N/A', // now shows project name
            'total_orders' => $total_orders,
=======
            'project' => $emp->project,
            'total_orders' => $total_orders,
            'mistakes' => $mistakes,
>>>>>>> d2b80f29b3e75409dba6e05677707d905edac65f
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
<<<<<<< HEAD

=======
>>>>>>> d2b80f29b3e75409dba6e05677707d905edac65f
}
