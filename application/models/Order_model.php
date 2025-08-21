<?php
class Order_model extends CI_Model
{

    public function get_orders($project_id = 0, $shift = 'ALL', $date_from = null, $date_to = null)
    {
        // $this->db->select('d.*, p.pro_name, e.em_code', 'e.first_name', 'e.last_name');
        $this->db->from('daily_order d');
        $this->db->join('project p', 'd.project_id = p.id', 'left');
        $this->db->join('employee e', 'd.employee_code = e.em_code', 'left');
        $this->db->select('
            p.pro_name,
            e.em_code,
            e.first_name,
            e.last_name,
            d.order_date,
            d.shift,
            d.order_count,
            d.pc_position
        ');


        if ($project_id !== 'ALL') {   // <-- allow ALL
            $this->db->where('d.project_id', $project_id);
        }

        // if ($project_id && $project_id != 0) {
        //     $this->db->where('d.project_id', $project_id);
        // }

        if ($shift != 'ALL') {
            $this->db->where('d.shift', $shift);
        }

        if ($date_from) {
            $this->db->where('d.order_date >=', $date_from);
        }

        if ($date_to) {
            $this->db->where('d.order_date <=', $date_to);
        }

        $this->db->order_by('d.order_date', 'DESC');

        return $this->db->get()->result_array();
    }


    public function get_orders_chart_data($projectId = 'ALL', $startDate = null, $endDate = null, $shiftid = 'ALL')
    {
        $this->db->select('order_date, SUM(order_count) as total');
        $this->db->from('daily_order');

        if ($startDate && $endDate) {
            $this->db->where('order_date >=', $startDate);
            $this->db->where('order_date <=', $endDate);
        }

        if (!empty($shiftid) && strtoupper($shiftid) !== 'ALL') {
            $this->db->where('shift', $shiftid);
        }

        if (!empty($projectId) && strtoupper($projectId) !== 'ALL') {
            $this->db->where('project_id', $projectId);
        }

        $this->db->group_by('order_date');
        $this->db->order_by('order_date', 'ASC');
        $query = $this->db->get();

        $total_orders = [];
        foreach ($query->result() as $row) {
            $total_orders[] = ['x' => $row->order_date, 'y' => (int) $row->total];
        }

        $avg_orders = [];
        foreach ($total_orders as $row) {
            $avg_orders[] = ['x' => $row['x'], 'y' => round($row['y'] / 2)]; 
        }

        return ['total_orders' => $total_orders, 'avg_orders' => $avg_orders];
    }

public function getMistakesByProject($projectId = 'ALL')
{
    $this->db->select('m.id, m.mistake_type, m.date, m.project_id, p.pro_name');
    $this->db->from('mistake_records m');
    $this->db->join('project p', 'm.project_id = p.id', 'left');

    if (!empty($projectId) && strtoupper($projectId) !== 'ALL') {
        $this->db->where('m.project_id', $projectId);
    }

    $query = $this->db->get();
    return $query->result_array();
}


public function get_all_projects()
{
    $this->db->select('id, pro_name');
    $this->db->from('project');
    $this->db->order_by('pro_name', 'ASC');
    return $this->db->get()->result();
}


}
