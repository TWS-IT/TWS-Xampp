<?php
class w1w_model extends CI_Model{
     function __construct()
    {
        parent::__construct();
        
    }
  public function Get_w() {
    $this->db->select('w1w_order.*, employee.first_name, employee.last_name');
    $this->db->from('w1w_order');
    $this->db->join('employee', 'employee.em_code = w1w_order.employee_id', 'left');
    $query = $this->db->get();
    return $query->result();
}


    public function getPINFromID($employee_ID) 
    {
      $sql = "SELECT `em_code` FROM `employee`
      WHERE `em_id`='$employee_ID'";
      $query=$this->db->query($sql);
      $result = $query->row();
      return $result;
    } 
     public function Add_w($data)
    {
        $this->db->insert('w1w_order', $data);
    }

    public function get_orders_with_employee_names() {
    $this->db->select('w1w_order.order_id, w1w_order.employee_id, employee.employee_name, w1w_order.order_date, w1w_order.shift, w1w_order.order_count, w1w_order.pc_position');
    $this->db->from('w1w_order');
    $this->db->join('employee', 'employee.employee_id = w1w_order.employee_id', 'left');
    $query = $this->db->get();
    return $query->result();
}

     public function search_by_name($q) {
   $this->db->select('em_code, first_name, last_name');
    if ($q) {
        $this->db->like('first_name', $q);
        $this->db->or_like('last_name', $q);
    }
    $query = $this->db->get('employee');
    return $query->result();
}
public function update_W($id,$data) {
        $this->db->where('order_id', $id);
		$this->db->update('w1w_order',$data);  
}
public function get_order_by_id($id) {
    $this->db->select('w1w_order.*, employee.first_name, employee.last_name');
    $this->db->from('w1w_order');
    $this->db->join('employee', 'employee.em_code = w1w_order.employee_id', 'left');
    $this->db->where('w1w_order.order_id', $id);
    return $this->db->get()->row();
}
public function DeleteWOrder($id) {
    $this->db->where('order_id', $id);
    return $this->db->delete('w1w_order');
}


// 2nd
public function get_all_orders_for_barline_chart($startDate = null, $endDate = null) {
    $this->db->select("order_date, SUM(order_count) as total_orders, AVG(order_count) as avg_orders");
    $this->db->from("w1w_order");
    
    if ($startDate && $endDate) {
        $this->db->where("order_date >=", $startDate);
        $this->db->where("order_date <=", $endDate);
    } else {
        $this->db->where("order_date >=", "2025-01-01");
    }
    
    $this->db->group_by("order_date");
    $this->db->order_by("order_date", "ASC");

    $query = $this->db->get();
    $result = $query->result();

    $barData = [];
    $lineData = [];

    foreach ($result as $row) {
        $timestamp = strtotime($row->order_date) * 1000; // JavaScript uses ms
        $barData[] = [$timestamp, (int)$row->total_orders];
        $lineData[] = [$timestamp, round($row->avg_orders, 2)];
    }

    return [
        'total_orders' => $barData,
        'avg_orders'   => $lineData
    ];
}


// public function get_all_orders_for_barline_chart($startDate = null, $endDate = null, $employeeId = null) {
//     $this->db->select("w1w_order.order_date, 
//         SUM(w1w_order.order_count) as total_orders, 
//         AVG(w1w_order.order_count) as avg_orders");
//     $this->db->from("w1w_order");

//     if (!empty($employeeId)) {
//         $this->db->where("w1w_order.employee_id", $employeeId);
//     }
//     if (!empty($startDate)) {
//         $this->db->where("w1w_order.order_date >=", $startDate);
//     }
//     if (!empty($endDate)) {
//         $this->db->where("w1w_order.order_date <=", $endDate);
//     }

//     $this->db->group_by("w1w_order.order_date");
//     $this->db->order_by("w1w_order.order_date", "ASC");

//     $query = $this->db->get();
//     $result = $query->result();

//     // Get employee full name if employeeId provided
//     $employeeName = '';
//     if (!empty($employeeId)) {
//         $this->db->select("CONCAT(first_name, ' ', last_name) AS full_name");
//         $this->db->from("employee");
//         $this->db->where("em_code", $employeeId);
//         $empQuery = $this->db->get();
//         $empRow = $empQuery->row();
//         $employeeName = $empRow ? $empRow->full_name : '';
//     }

//     $barData = [];
//     $lineData = [];

//     foreach ($result as $row) {
//         $timestamp = strtotime($row->order_date) * 1000;
//         $barData[] = [$timestamp, (int)$row->total_orders];
//         $lineData[] = [$timestamp, round($row->avg_orders, 2)];
//     }

//     return [
//         'total_orders' => $barData,
//         'avg_orders'   => $lineData,
//         'employee_name' => $employeeName
//     ];
// }







}
?>