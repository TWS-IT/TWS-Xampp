<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Colombo');
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('settings_model');
        $this->load->model('notice_model');
        $this->load->model('project_model');
        $this->load->model('leave_model');
    }

    public function mistake_count()
    {
        $project = $this->input->post('project'); 

        $this->db->from('mistake_records m');
        $this->db->join('employee e', 'e.em_code = m.emp_id', 'inner');

        if (!empty($project)) {
            $this->db->where('e.project', $project); 
        }

        $count = $this->db->count_all_results();

        echo json_encode(['count' => $count]);
    }


    public function index()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
        $data = array();
        #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
        $this->load->view('login');
    }
    function Dashboard()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $this->load->view('backend/dashboard');
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function add_todo()
    {
        $userid = $this->input->post('userid');
        $tododata = $this->input->post('todo_data');
        $date = date("Y-m-d h:i:sa");
        $this->load->library('form_validation');
        //validating to do list data
        $this->form_validation->set_rules('todo_data', 'To-do Data', 'trim|required|min_length[5]|max_length[150]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            $data = array();
            $data = array(
                'user_id' => $userid,
                'to_dodata' => $tododata,
                'value' => '1',
                'date' => $date
            );
            $success = $this->dashboard_model->insert_tododata($data);
            #echo "successfully added";
            if ($this->db->affected_rows()) {
                echo "Successfully Added";
            } else {
                echo "validation Error";
            }
        }
    }
    public function Update_Todo()
    {
        $id = $this->input->post('toid');
        $value = $this->input->post('tovalue');
        $data = array();
        $data = array(
            'value' => $value
        );
        $update = $this->dashboard_model->UpdateTododata($id, $data);
        $inserted = $this->db->affected_rows();
        if ($inserted) {
            $message = "Successfully Added";
            echo $message;
        } else {
            $message = "Something went wrong";
            echo $message;
        }
    }


    public function get_order_comparison_chart($filter = 'all')
    {
        $shiftCondition = ""; // Default no filter
        if ($filter !== 'all') {
            // Assuming your shift column values are exactly 'Morning', 'Noon', 'Night'
            $shiftCondition = "AND shift = " . $this->db->escape($filter);
        }

        $query = $this->db->query("
        SELECT 
            d.order_date,
            IFNULL(w.total_orders, 0) AS w_order_count,
            IFNULL(w1w_deposit_order.total_orders, 0) AS w1w_d_order_count,
            IFNULL(w1w_w.total_orders, 0) AS w1w_w_order_count,
            IFNULL(k8_d.total_orders, 0) AS k8_d_order_count,
            IFNULL(k8_w.total_orders, 0) AS k8_w_order_count,
            IFNULL(atas.total_orders, 0) AS atas_order_count
        FROM (
            SELECT DISTINCT order_date FROM (
                SELECT order_date FROM w_order
                UNION 
                SELECT order_date FROM w1w_deposit_order
                UNION
                SELECT order_date FROM w1w_w
                UNION 
                SELECT order_date FROM k8_d
                UNION
                SELECT order_date FROM atas_order
            ) AS all_dates
        ) d
        LEFT JOIN (
            SELECT order_date, SUM(order_count) AS total_orders 
            FROM w_order 
            WHERE 1=1 $shiftCondition
            GROUP BY order_date
        ) w ON w.order_date = d.order_date
        LEFT JOIN (
            SELECT order_date, SUM(order_count) AS total_orders 
            FROM w1w_deposit_order 
            WHERE 1=1 $shiftCondition
            GROUP BY order_date
        ) w1w_deposit_order ON w1w_deposit_order.order_date = d.order_date
        LEFT JOIN (
            SELECT order_date, SUM(order_count) AS total_orders 
            FROM w1w_w 
            WHERE 1=1 $shiftCondition
            GROUP BY order_date
        ) w1w_w ON w1w_w.order_date = d.order_date
        LEFT JOIN (
            SELECT order_date, SUM(order_count) AS total_orders 
            FROM k8_d 
            WHERE 1=1 $shiftCondition
            GROUP BY order_date
        ) k8_d ON k8_d.order_date = d.order_date
        LEFT JOIN (
            SELECT order_date, SUM(order_count) AS total_orders 
            FROM k8_w 
            WHERE 1=1 $shiftCondition
            GROUP BY order_date
        ) k8_w ON k8_w.order_date = d.order_date
        LEFT JOIN (
            SELECT order_date, SUM(order_count) AS total_orders 
            FROM atas_order 
            WHERE 1=1 $shiftCondition
            GROUP BY order_date
        ) atas ON atas.order_date = d.order_date
        ORDER BY d.order_date
    ");

        echo json_encode($query->result());
    }



    public function get_total_order_count($timeRange)
    {

        $currentDate = new DateTime();
        $startDate = clone $currentDate;


        switch ($timeRange) {
            case 'today':

                break;
            case 'week':

                $startDate->modify('-7 days');
                break;
            case 'month':

                $startDate->modify('first day of last month');
                break;
            case 'year':

                $startDate->modify('first day of January this year');
                break;
            default:

                $startDate = null;
                break;
        }


        $tables = ['w_order', 'w1w_w', 'atas_order', 'k8_d', 'k8_w', 'w1w_deposit_order'];


        $totalOrderCount = 0;


        foreach ($tables as $table) {
            $this->db->select_sum('order_count');


            if ($startDate) {
                $this->db->where('order_date >=', $startDate->format('Y-m-d'));
            }


            $query = $this->db->get($table);
            $result = $query->row();
            $totalOrderCount += $result->order_count;
        }


        echo json_encode(['success' => true, 'orderCount' => $totalOrderCount]);
    }



    // W_Order.php (controller)
    public function getMistakeCountByProject()
    {
        $project = $this->input->get('project');

        $this->db->from("mistake_records m");
        $this->db->join("employee e", "e.em_code = m.employee_id", "inner");

        if (!empty($project)) {
            $this->db->where("e.project", $project);
        }

        $count = $this->db->count_all_results();

        echo json_encode(['count' => $count]);
    }




}