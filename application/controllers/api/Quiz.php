<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Quiz extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->model('admin/admin_test_model');
        $this->load->model('admin/admin_home_model');
       
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            $x = $headers['Authorization'];
            //pre($x);
            $y = explode(" ", $x);
            $token = Authorization::validateToken($y[1]);
            $decodedToken = AUTHORIZATION::validateTimestamp($y[1]);
            if ($decodedToken == false) {
                redirect(base_url('login'), 'refresh');
            }
            
        }
        else{
            redirect(base_url('login'), 'refresh');
        }
    }

    public function tests_get()
    {
        $result = array();
        $this->load->model('common_model');
        $result = $this->common_model->get_test($id=null);
        $id = $this->get('id');
           
        if ($id == NULL)
        {
            if ($result)
            {
                // Set the response and exit
                $this->response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No tests were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $test = NULL;

 

        if (!empty($result))
        {
            foreach ($result as $key => $value)
            {
                //pre($value);
                if (isset($value['id']) && ($value['id'] == $id))
                {
                    $test = $value;

                }
            }
        }

        if (!empty($test))
        {
            $this->set_response($test, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Test could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }


    public function tests_post()
    {

        $test_id = $this->post('test_id');
        $user_id = $this->post('user_id');

        $this->load->model('common_model');
        $result = $this->common_model->get_test($test_id);
        if ($result)
        {
            $this->load->model('admin/admin_test_user_model');
            if($this->admin_test_user_model->check_exists($where=array('test_id'=>$test_id, 'user_id'=>$user_id))==false){
                $this->admin_test_user_model->create($data_test_user = array('test_id'=>$test_id, 'user_id'=>$user_id));
            }
            $test = $this->admin_test_user_model->get_list([
                'where' => ['test_id'=>$test_id, 'user_id'=>$user_id]
            ]);
            if($test[0]->status==0){$status_text="Chưa làm bài";}
            if($test[0]->status==1){$status_text="Đang làm bài";}
            if($test[0]->status==2){$status_text="Đã kết thúc";}

            $info_user = $this->admin_home_model->get_info($user_id);
            $result['total_point'] = $test[0]->total_point;
            $result['start_at'] = $test[0]->start_at;
            $result['end_at'] = $test[0]->end_at;
            $result['status'] = $test[0]->status;
            $result['status_text'] = $status_text;
            $result['tester'] = $info_user->last_name.' '.$info_user->first_name;
            $result['tester_id'] = $info_user->id;
            $result['test_id'] = $test[0]->id;
            // Set the response and exit
            $this->set_response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No tests were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            $this->set_response($response, REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function infotest_get()
    {

        $test_id = $this->get('id');
        $user_id = $this->get('user_id');

        $this->load->model('admin/admin_test_user_model');
        $test_info = $this->admin_test_user_model->get_info($test_id);

        $this->load->model('common_model');
        $this->load->model('admin/admin_answer_model');
        $this->load->model('admin/admin_test_question_model');
        $this->load->model('admin/admin_question_model');

        $test = $this->load->admin_test_model->get_info($test_info->test_id);


        $list_added_questions = $this->admin_test_question_model->get_list([
            'where' => ['test_id'=>$test->id]
        ]);



        if($list_added_questions){
            $today = date("Y-m-d H:i:s");
            $start_date = date("Y-m-d H:i:s", strtotime($test->start_date));
            $end_date = date("Y-m-d H:i:s", strtotime($test->end_date));

            $time_left =0;
            $difference = strtotime($end_date) - strtotime($start_date);

            if($difference ==0){
                if($test->duration == 0){
                    $time_left =0;
                }
                else {
                    $time_left = $test_info->time_left;
                }
            }
            else{
                if($test_info->time_left == 0){
                    $time_left =0;
                }
                else {
                    
                    $minutes = floor($difference / 60);

                    $difference_to_now = strtotime($end_date) - strtotime($today);
                    $minutes_to_now = floor($difference_to_now / 60);

                    if($minutes_to_now >= $test_info->time_left){
                        $time_left = $test_info->time_left;
                    }
                    else {
                        $time_left = $minutes_to_now;
                    }
                }
            }
            
            $dem =0;
            $list = array();
            //$list['info'] = array('time_left'=> $time_left, 'test_key'=>$test_info->test_key);
            $list = (object) array('info' => (object) array('time_left'=> $time_left, 'duration'=> $test->duration, 'test_key'=>$test_info->test_key));
            $list_question = array();
            $result = array();
            $re = $test_info->result;
            $result = explode(",", $re);

            foreach ($list_added_questions as $key => $value) {
                
                $question_id = $value->question_id;
                $info_question = $this->admin_question_model->get_info($question_id);
                if($info_question) {
                    $value->info_question = $info_question;
                    $list_question[$key]['question_id'] = $value->question_id;
                    $list_question[$key]['question_title'] = $info_question->title;
                    $list_answer = array();
                    $list_answers = $this->admin_answer_model->get_list([
                        'where' => ['question_id'=>$info_question->id]
                    ]);
    
                    if(count($list_answers)==0){
                        $dem++;
                    }
                    $l_a = array();

                    foreach ($list_answers as $k => $v) {
                        $l_a[$k]['answer_id'] = $v->id;
                        $l_a[$k]['title'] = $v->title;
                    }
    
                    $value->list_answer = $list_answers;
                    $list_question[$key]['list_answer'] = $l_a;
                    if(isset($result[$key])){
                        $list_question[$key]['result'] = $result[$key];
                    }
                    else{
                        $list_question[$key]['result'] = "0";
                    }
                    
        
                }
            }
            //pre($list_question);
            $list->question = $list_question;
            $list->result = $result;
            //pre($list);
            $this->set_response($list, REST_Controller::HTTP_OK);
        }
        else
        {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No tests were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            $this->set_response($response, REST_Controller::HTTP_FORBIDDEN);
        }

    }

    function infotestresult_post(){
        $test_id = $this->post('test_id');
        $user_id = $this->post('user_id');
        $data = $this->post('data');

        $this->load->model('admin/admin_test_user_model');
        $test_info = $this->admin_test_user_model->get_info($test_id);

        $this->load->model('common_model');
        $this->load->model('admin/admin_answer_model');
        $this->load->model('admin/admin_test_question_model');
        $this->load->model('admin/admin_question_model');

        $test = $this->load->admin_test_model->get_info($test_info->test_id);

        if($test_info->time_left==0 && $test->duration > 0){
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        
        if($test_info->status == 2){
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        if($test_info->status==1){
            $result = array();
            $re = $test_info->result;
            $result = explode(",", $re);
            //pre($result);
            foreach ($result as $k => $v) {
                $v1 = explode("-", $v);
                if($v1[0] == $data[0]){
                    $v1[1] = $data[1];
                    $v2 = implode("-",$v1);
                    $result[$k] = $v2;
                }
            }
            $result = array_unique($result);
            $result = implode(",", $result);
            $dat = array('result'=>$result);
            if($this->admin_test_user_model->update($test_id,$dat)){
                $this->response("ANSWER UPDATED!", REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'No found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        
    }

    function infotesttime_post(){
        
        $test_id = $this->post('test_id');
        $user_id = $this->post('user_id');
        $time_left = $this->post('time_left');

        $this->load->model('admin/admin_test_user_model');
        $test_info = $this->admin_test_user_model->get_info($test_id);

        $this->load->model('common_model');
        $this->load->model('admin/admin_answer_model');
        $this->load->model('admin/admin_test_question_model');
        $this->load->model('admin/admin_question_model');

        $test = $this->load->admin_test_model->get_info($test_info->test_id);

        $this->admin_test_user_model->update($test_id,$dat = array('time_left'=>$time_left));
        if($time_left==0){
            $this->admin_test_user_model->update($test_id,$dat = array('status'=>2,'end_at'=>date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')));
        }

        if($test_info->status == 1){
            $this->response("TIME UPDATED!", REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }

        if($test_info->status == 2){
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        
    }

    public function mytests_post(){
        $user_id = $this->post('user_id');
        //pre($user_id);
        $this->load->model('common_model');
        $result = $this->common_model->get_all_test_of_user($user_id);

        if ($result)
        {
            // Set the response and exit
            $this->response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No tests were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function users_get()
    {
        // Users from a data store e.g. database
        $users = [
            ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
            ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
            ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
        ];

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($users)
            {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $user = NULL;

        if (!empty($users))
        {
            foreach ($users as $key => $value)
            {
                if (isset($value['id']) && $value['id'] === $id)
                {
                    $user = $value;
                }
            }
        }

        if (!empty($user))
        {
            $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

}

?>