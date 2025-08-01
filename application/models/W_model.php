<?php
class W_model extends CI_Model{
     function __construct()
    {
        parent::__construct();
        
    }
  public function Get_w() {
    $this->db->select('w_order.*, employee.first_name, employee.last_name');
    $this->db->from('w_order');
    $this->db->join('employee', 'employee.em_code = w_order.employee_id', 'left');
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
        $this->db->insert('w_order', $data);
    }

    public function get_orders_with_employee_names() {
    $this->db->select('w_order.order_id, w_order.employee_id, employee.employee_name, w_order.order_date, w_order.shift, w_order.order_count, w_order.pc_position');
    $this->db->from('w_order');
    $this->db->join('employee', 'employee.employee_id = w_order.employee_id', 'left');
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
		$this->db->update('w_order',$data);  
}
public function get_order_by_id($id) {
    $this->db->select('w_order.*, employee.first_name, employee.last_name');
    $this->db->from('w_order');
    $this->db->join('employee', 'employee.em_code = w_order.employee_id', 'left');
    $this->db->where('w_order.order_id', $id);
    return $this->db->get()->row();
}
public function DeleteWOrder($id) {
    $this->db->where('order_id', $id);
    return $this->db->delete('w_order');
}






public function get_filtered_barline_chart_se($start_date, $end_date, $employee_name = null) {
    $this->db->select("w.order_date, SUM(w.order_count) AS total_orders, AVG(w.order_count) AS avg_orders");
    $this->db->from("w_order w");
    $this->db->join("employee e", "e.em_code = w.employee_id", "left");

    $this->db->where("w.order_date >=", $start_date);
    $this->db->where("w.order_date <=", $end_date);

    if (!empty($employee_name)) {
        // ✅ This is the corrected part:
        $this->db->where("CONCAT(e.first_name, ' ', e.last_name) LIKE", "%$employee_name%");
    }

    $this->db->group_by("w.order_date");
    $this->db->order_by("w.order_date", "ASC");

    $query = $this->db->get();
    $result = $query->result();

    $barData = [];
    $lineData = [];

    foreach ($result as $row) {
        $timestamp = strtotime($row->order_date) * 1000; // for JS datetime axis
        $barData[] = [$timestamp, (int)$row->total_orders];
        $lineData[] = [$timestamp, round($row->avg_orders, 2)];
    }

    return [
        'total_orders' => $barData,
        'avg_orders'   => $lineData
    ];
}








// 2nd
public function get_all_orders_for_barline_chart() {
    $this->db->select("order_date, SUM(order_count) as total_orders, AVG(order_count) as avg_orders");
    $this->db->from("w_order");
    $this->db->where("order_date >=", "2025-01-01"); // 🔥 Only from 2025 onwards
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



// 3rd
// public function get_all_orders_for_barline_chart() {
//     // Get min and max order_date from DB
//     $this->db->select_min('order_date');
//     $this->db->select_max('order_date');
//     $range = $this->db->get('w_order')->row();

//     $start = new DateTime($range->order_date);
//     $end = new DateTime($range->order_date_max);

//     $interval = new DateInterval('P1D'); // Daily
//     $period = new DatePeriod($start, $interval, $end->modify('+1 day'));

//     // Build complete date range
//     $dateMap = [];
//     foreach ($period as $dt) {
//         $timestamp = $dt->getTimestamp() * 1000; // JS needs ms
//         $dateMap[$timestamp] = ['total' => 0, 'avg' => 0];
//     }

//     // Now fetch actual order data grouped by day
//     $this->db->select("order_date, SUM(order_count) as total_orders, AVG(order_count) as avg_orders");
//     $this->db->from("w_order");
//     $this->db->group_by("order_date");
//     $query = $this->db->get();
//     $result = $query->result();

//     foreach ($result as $row) {
//         $timestamp = strtotime($row->order_date) * 1000;
//         $dateMap[$timestamp] = [
//             'total' => (int)$row->total_orders,
//             'avg'   => round($row->avg_orders, 2)
//         ];
//     }

//     // Build final data arrays
//     $barData = [];
//     $lineData = [];
//     foreach ($dateMap as $timestamp => $data) {
//         $barData[] = [ $timestamp, $data['total'] ];
//         $lineData[] = [ $timestamp, $data['avg'] ];
//     }

//     return [
//         'total_orders' => $barData,
//         'avg_orders'   => $lineData
//     ];
// }




}
?>