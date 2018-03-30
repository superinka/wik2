<?php
class Reports extends Admin_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('admin/admin_test_model');
        $this->load->model('admin/admin_test_question_model');
        $this->load->model('admin/admin_question_model');
        $this->load->model('admin/admin_home_model');
        $this->load->model('admin/admin_test_user_model');

        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
    }

    function index(){

        $this->load->model('common_model');
        // get top 5 today
        $top_av_point_today = array();
        $top_av_point_today = $this->common_model->get_top_av_point_today(5,'today');

        $top_total_point_today = array();
        $top_total_point_today = $this->common_model->get_top_total_point_today(5,'today');

        $top_number_of_test_today = array();
        $top_number_of_test_today = $this->common_model->get_top_number_of_test_today(5,'today');

        //get top 5 this week
        $top_av_point_thisweek = array();
        $top_av_point_thisweek = $this->common_model->get_top_av_point_today(5,'thisweek');

        $top_total_point_thisweek = array();
        $top_total_point_thisweek = $this->common_model->get_top_total_point_today(5,'thisweek');

        $top_number_of_test_thisweek = array();
        $top_number_of_test_thisweek = $this->common_model->get_top_number_of_test_today(5,'thisweek');

        //get top 5 this month
        $top_av_point_thismonth = array();
        $top_av_point_thismonth = $this->common_model->get_top_av_point_today(5,'thismonth');

        $top_total_point_thismonth = array();
        $top_total_point_thismonth = $this->common_model->get_top_total_point_today(5,'thismonth');

        $top_number_of_test_thismonth = array();
        $top_number_of_test_thismonth = $this->common_model->get_top_number_of_test_today(5,'thismonth');

        $this->data = [
            'top_av_point_today'            => $top_av_point_today,
            'top_total_point_today'         => $top_total_point_today,
            'top_number_of_test_today'      => $top_number_of_test_today,
            'top_av_point_thisweek'         => $top_av_point_thisweek,
            'top_total_point_thisweek'      => $top_total_point_thisweek,
            'top_number_of_test_thisweek'   => $top_number_of_test_thisweek,
            'top_av_point_thismonth'        => $top_av_point_thismonth,
            'top_total_point_thismonth'     => $top_total_point_thismonth,
            'top_number_of_test_thismonth'  => $top_number_of_test_thismonth,
            'temp'                          => 'report'
        ];

        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function report_by_test(){
        $this->load->model('common_model');

        $list_all_test = $this->admin_test_model->get_list(
            [
                'order' => ['id', 'DESC'],
                'where' => ['valid'=> 1]
            ]
        );
        //pre($this->common_model->get_top_point_of_test(1,5));

        $this->data = [
            'list_all_test'                 => $list_all_test,
            'temp'                          => 'report_by_test'
        ];
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function report_by_test_filter(){
        $this->load->model('common_model');
        $select_id = $_POST['select_id'];
        $result=array();
        $result = $this->common_model->get_top_point_of_test($select_id,5);
        foreach ($result as $key => $value) {
            $user_id = $value->user_id;
            $user_info=array();
            $user_info = $this->admin_home_model->get_info($user_id);
            $value->tester = $user_info->last_name . ' ' .$user_info->first_name;

            $test_id = $value->test_id;
            $test_info=array();
            $test_info = $this->admin_test_model->get_info($test_id);
            $value->test_info = $test_info;
        }
        $this->data['result'] = $result;
        //die (json_encode($result));
        //pre($result);
        $this->data['temp'] = 'test/filter_test_result';
        $this->load->view('test/filter_test_result', $this->data);
        
    }

    function report_by_user(){
        $this->load->model('common_model');
        $list_all_test = $this->admin_test_user_model->get_list(
            [
                'order' => ['id', 'DESC'],
                'where' => ['valid'=> 1]
            ]
        );

        $list_all_tester = array();
        foreach ($list_all_test as $key => $value) {
            $tester_id = $value->user_id;
            if(in_array($tester_id, $list_all_tester)==false){
                $list_all_tester[] = $tester_id;
            }
        }

        $this->data = [
            'list_all_test'                 => $list_all_test,
            'list_all_tester'               => $list_all_tester,
            'temp'                          => 'report_by_user'
        ];
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function report_by_user_filter(){
        $this->load->model('common_model');
        $select_id = $_POST['select_id'];
        $result=array();
        $result = $this->common_model->get_top_point_of_user($select_id,5);
        foreach ($result as $key => $value) {
            $user_id = $value->user_id;
            $user_info=array();
            $user_info = $this->admin_home_model->get_info($user_id);
            $value->tester = $user_info->last_name . ' ' .$user_info->first_name;

            $test_id = $value->test_id;
            $test_info=array();
            $test_info = $this->admin_test_model->get_info($test_id);
            $value->test_info = $test_info;
        }
        $this->data['result'] = $result;
        //die (json_encode($result));
        //pre($result);
        $this->data['temp'] = 'test/filter_test_result';
        $this->load->view('test/filter_test_result', $this->data);
        
    }

}