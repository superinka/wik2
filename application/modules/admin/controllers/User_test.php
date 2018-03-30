<?php
class User_test extends Admin_Controller {
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
        $this->load->model('admin_home_model');

        $list_now_testing = array();
        $list_now_testing = $this->admin_test_user_model->get_list([
            'order' => ['id', 'DESC'],
            'where' => ['status'=>1]
        ]);

        foreach ($list_now_testing as $key => $value) {
            $user_id = $value->user_id;
            $user_info=array();
            $user_info = $this->admin_home_model->get_info($user_id);
            $value->tester = $user_info->last_name . ' ' .$user_info->first_name;

            $test_id = $value->test_id;
            $test_info=array();
            $test_info = $this->admin_test_model->get_info($test_id);
            $value->test_info = $test_info;
        }

        $list_today_testing = array();
        $list_today_testing = $this->admin_test_user_model->get_list([
            'order' => ['id', 'DESC'],
            'where' => ['valid'=>1]
        ]);

       

        foreach ($list_today_testing as $key => $value) {
            if (date('Y-m-d') == date('Y-m-d', strtotime($value->start_at))) {
                
                $user_id = $value->user_id;
                $user_info=array();
                $user_info = $this->admin_home_model->get_info($user_id);
                $value->tester = $user_info->last_name . ' ' .$user_info->first_name;

                $test_id = $value->test_id;
                $test_info=array();
                $test_info = $this->admin_test_model->get_info($test_id);
                $value->test_info = $test_info;
            }
            else{
                unset($list_today_testing[$key]);
            }

        }
        //pre($list_today_testing);

        $this->data['list_now_testing'] = $list_now_testing;
        $this->data['list_today_testing'] = $list_today_testing;

        $this->data['temp'] = 'test/user_test';
        $this->load->view('admin/admin-layout/main', $this->data);
    }

    function view_test(){
        $this->load->model('admin/admin_test_user_model');
        $this->load->model('admin/admin_test_model');
        $test = array();
        $test_id            = $_POST['test_id'];
        $test_info = $this->admin_test_user_model->get_info($test_id);

        $test = $this->admin_test_model->get_info($test_info->test_id);

        //pre($test_info);

        $this->data['test_info'] = $test_info;
        $this->data['test'] = $test;

        $this->load->model('common_model');
        $html = $this->common_model->get_result_test($test_info->result);
        $this->data['html'] = $html;

        $this->data['temp'] = 'test/view_user_test_modal';
        $this->load->view('test/view_user_test_modal', $this->data);
    }

    function today_testing(){
        $list_today_testing = array();
        $list_today_testing = $this->admin_test_user_model->get_list([
            'order' => ['id', 'DESC'],
            'where' => ['valid'=>1]
        ]);

       

        foreach ($list_today_testing as $key => $value) {
            if (date('Y-m-d') == date('Y-m-d', strtotime($value->start_at))) {
                
                $user_id = $value->user_id;
                $user_info=array();
                $user_info = $this->admin_home_model->get_info($user_id);
                $value->tester = $user_info->last_name . ' ' .$user_info->first_name;

                $test_id = $value->test_id;
                $test_info=array();
                $test_info = $this->admin_test_model->get_info($test_id);
                $value->test_info = $test_info;
            }
            else{
                unset($list_today_testing[$key]);
            }

        }

        return $list_today_testing;
    }

    function complete_testing(){
        $list_complete_testing = array();
        $list_complete_testing = $this->admin_test_user_model->get_list([
            'order' => ['id', 'DESC'],
            'where' => ['status'=>2]
        ]);
        foreach ($list_complete_testing as $key => $value) {
            $user_id = $value->user_id;
            $user_info=array();
            $user_info = $this->admin_home_model->get_info($user_id);
            $value->tester = $user_info->last_name . ' ' .$user_info->first_name;

            $test_id = $value->test_id;
            $test_info=array();
            $test_info = $this->admin_test_model->get_info($test_id);
            $value->test_info = $test_info;
        }

        return $list_complete_testing;
    }

    function not_start_testing(){
        $list_not_start_testing = array();
        $list_not_start_testing = $this->admin_test_user_model->get_list([
            'order' => ['id', 'DESC'],
            'where' => ['status'=>0]
        ]);
        foreach ($list_not_start_testing as $key => $value) {
            $user_id = $value->user_id;
            $user_info=array();
            $user_info = $this->admin_home_model->get_info($user_id);
            $value->tester = $user_info->last_name . ' ' .$user_info->first_name;

            $test_id = $value->test_id;
            $test_info=array();
            $test_info = $this->admin_test_model->get_info($test_id);
            $value->test_info = $test_info;
        }

        return $list_not_start_testing;
    }

    function all_testing(){
        $list_all_testing = array();
        $list_all_testing = $this->admin_test_user_model->get_list([
            'order' => ['id', 'DESC'],
            'where' => ['valid'=>1]
        ]);
        foreach ($list_all_testing as $key => $value) {
            $user_id = $value->user_id;
            $user_info=array();
            $user_info = $this->admin_home_model->get_info($user_id);
            $value->tester = $user_info->last_name . ' ' .$user_info->first_name;

            $test_id = $value->test_id;
            $test_info=array();
            $test_info = $this->admin_test_model->get_info($test_id);
            $value->test_info = $test_info;
        }

        return $list_all_testing;
    }

    function filter(){

        $select_id = $_POST['select_id'];
        $result=array();

        if($select_id == 1){
            $result = $this->today_testing();
        }
        if($select_id == 2){
            $result = $this->complete_testing();
        }
        if($select_id == 3){
            $result = $this->not_start_testing();
        }
        if($select_id == 4){
            $result = $this->all_testing();
        }

        //pre($result);

        $this->data['result'] = $result;
        //die (json_encode($result));

        $this->data['temp'] = 'test/filter_test_result';
        $this->load->view('test/filter_test_result', $this->data);
        
    }

}