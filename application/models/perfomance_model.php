<?php

class Perfomance_model extends CI_Model
{
    public function get_all_performance_data()
    {
        // Step 1: Get all active employees
        $this->db->select('em_code, CONCAT(first_name, " ", last_name) AS full_name, project');
        $this->db->from('employee');
        $this->db->where('status', 'ACTIVE');
        $employees = $this->db->get()->result();

        $data = [];

        foreach ($employees as $emp) {
            $em_code = $emp->em_code;

            // Step 2: Sum total orders from all tables (by order_count)
            $total_orders = $this->get_total_orders($em_code);

            // Step 3: Dummy mistake count
            $mistakes = rand(0, 5); // Replace this later with real mistake count

            // Step 4: Efficiency
            $efficiency = ($total_orders + $mistakes) > 0
                ? round(($total_orders / ($total_orders + $mistakes)) * 100)
                : 0;

            $data[] = [
                'em_code' => $em_code,
                'full_name' => $emp->full_name,
                'project' => $emp->project,
                'total_orders' => $total_orders,
                'mistakes' => $mistakes,
                'efficiency' => $efficiency
            ];
        }

        return $data;
    }

    public function get_total_orders($em_code)
    {
        // Format: 'table_name' => ['employee_column', 'order_count_column']
        $tables = [
            'w_order' => ['employee_id', 'order_count'],
            'atas_order' => ['employee_id', 'order_count'],
            'w1w_order' => ['employee_id', 'order_count'],
            'w1w_withdrawal' => ['employee_id', 'order_count'],
            // 'k8_deposit' => ['employee_id', 'order_count'],
            // 'k8_withdrawal' => ['employee_id', 'order_count'],
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
