<?php
class W_model extends CI_Model{
     function __construct()
    {
        parent::__construct();
        
    }
    public function Get_w(){
        $sql = "SELECT * FROM `w_order`";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;          
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

     
         


}
?>