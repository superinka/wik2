<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends Public_Controller {

	function __construct(){
        parent::__construct();
       
        $message = $this->session->flashdata('message');
		$this->data['message'] = $message;
		
        $session_data = $this->session->userdata();
		$my_id = $this->my_id;
		if($my_id == 0){
			$this->session->set_flashdata('message','Không có quyền xem bài viết');
			$this->data['temp'] = 'login_modal';
			$this->load->view('login_modal', $this->data);
		}
    }

	public function index()
	{
        $my_id = $this->my_id;
        //pre($my_id);
		if($my_id != 0){
            $this->load->model('common_model');
            //pre($this->common_model->get_test());
            $this->data['temp'] = 'quiz';
			$this->load->view('quiz', $this->data);
		}
	}

	public function test(){
		$test_id  = $this->uri->segment(3);    
		$my_id = $this->my_id;
		if($my_id != 0){
            $this->load->model('admin/admin_test_model');
            $test_info = $this->admin_test_model->get_info($test_id);
            if(!$test_info){
                $this->session->set_flashdata('message','Không tồn tại thông tin');
                redirect(base_url('quiz'));
            }
            else {
                if ($test_info->test_type!= 1){
                    $this->load->model('admin/admin_test_user_model');
                    if($this->admin_test_user_model->check_exists($where=array('test_id'=>$test_id, 'user_id'=>$my_id))==false){
                        $this->session->set_flashdata('message','Bạn chưa có quyền thi bài này');
                        redirect(base_url('quiz'));
                    }
                    
                }

            }
            $this->load->view('test',$this->data);
			
		}
    }
    
    function do_test(){
        $test_id  = $this->uri->segment(3);    
        $my_id = $this->my_id;
        $this->load->model('common_model');
		if($my_id != 0){
            $this->load->model('admin/admin_test_user_model');
            $test_info = $this->admin_test_user_model->get_info($test_id);
            if(!$test_info){
                $this->session->set_flashdata('message','Không tồn tại thông tin');
                redirect(base_url('quiz'));
            }
            else {
                $this->load->model('admin/admin_test_model');
                $this->load->model('admin/admin_post_model');

                $test = $this->load->admin_test_model->get_info($test_info->test_id);
                if(!$test){
                    $this->session->set_flashdata('message','Không tồn tại thông tin');
                    redirect(base_url('quiz'));
                }
                if($test->test_type!= 1){
                    if(!$this->admin_test_user_model->check_exists($where=array('test_id'=>$test_info->test_id, 'user_id'=>$my_id))){
                        $this->session->set_flashdata('message','Bạn chưa có quyền thi bài này');
                        redirect(base_url('quiz'));
                    }
                }
                if($test_info->status == 2){
                    
                    $final_point = $this->common_model->get_final_point($test_info->result);
                    //pre($final_point);
                    $this->admin_test_user_model->update($test_id,$data=array('total_point'=>$final_point));
                    $this->session->set_flashdata('message','Bài thi đã kết thúc, Bạn được: '.$final_point. " Điểm");
                    redirect(base_url('quiz/test/'.$test_info->test_id));
                }
                else {
                    $today = date("Y-m-d H:i:s");
                    $start_date = date("Y-m-d H:i:s", strtotime($test->start_date));
                    $end_date = date("Y-m-d H:i:s", strtotime($test->end_date));

                    if($start_date != $end_date){
                        if(strtotime($today) < strtotime($start_date)){
                            $this->session->set_flashdata('message','Chưa đến giờ thi, trở lại sau: '.$start_date);
                            redirect(base_url('quiz/test/'.$test_info->test_id));
                        }
                        if(strtotime($today) > strtotime($end_date)){
                            $this->session->set_flashdata('message','Đề thi đã đóng lúc: '.$end_date);
                            redirect(base_url('quiz/test/'.$test_info->test_id));
                        }
                    }

                    $test_key =  $today.$test_id.$my_id;
                    $test_key = md5($test_key);
                    
                    do {
                        $test_key = generate_uuid($test_key);
                    } while ($this->admin_test_user_model->check_exists($where=array('test_key'=>$test_key))==true);

                    $this->load->model('admin/admin_test_question_model');
                    $list_added_questions = $this->admin_test_question_model->get_list([
                        'where' => ['test_id'=>$test->id]
                    ]);
                    
                    $result="";
                    $count = count($list_added_questions);
                    $dem=1;
                    foreach ($list_added_questions as $key => $value) {
                        if($dem == $count){
                            $result = $result.$value->question_id."-0";
                        }
                        else{
                            $result = $result.$value->question_id."-0,";
                        }
                        $dem++;
                    }
                    $max_end_at =null;
                    if($test->duration != 0){
                        $max_end_at =  strtotime(date("Y-m-d H:i:s",time())) + $test->duration*60;
                    }
                    $data = array(
                        'status' => 1,
                        'start_at' => $today,
                        'test_key' => $test_key,
                        'time_left' => $test->duration,
                        'result' => $result,
                        'max_end_at' =>  date("Y-m-d H:i:s",$max_end_at)
                    );
                    //pre(date("Y-m-d H:i:s",$max_end_at));
                    if($test_info->status == 0){
                        if($this->admin_test_user_model->update($test_id,$data)){
                            $this->load->view('do_test',$this->data);
                        }
                        else{
                            $this->session->set_flashdata('message','Có lỗi xảy ra');
                            redirect(base_url('quiz/test/'.$test_info->test_id));
                        }
                    }
                    if($test_info->status == 1){
                        //pre(strtotime($test_info->max_end_at));
                        $difference_to_now = strtotime($test_info->max_end_at) - strtotime($today);
                        //pre($difference_to_now);
                        $minutes_to_now = floor($difference_to_now / 60);
                        
                        $time_left = $minutes_to_now;
                        //pre($time_left);

                        if($test->duration > 0){
                            if($time_left<=0){
                                $this->session->set_flashdata('message','Bài thi đã kết thúc');
                                $this->admin_test_user_model->update($test_id,$data=array('status'=>2,'time_left'=>0));
                                redirect(base_url('quiz/test/'.$test_info->test_id));
                            }
                            else{
                                $this->admin_test_user_model->update($test_id,$data=array('time_left'=>$time_left));
                            }
                        }
                        else{

                        }


                        
                    }
                    $this->load->view('do_test',$this->data);


                    //pre($time_left);

                    
                }
                // if($test_info->start_at == "0000-00-00 00:00:00"){
                    
                // }
            }
            
			
		}
    }

    function end_test(){
        $test_id  = $this->uri->segment(3);    
        $my_id = $this->my_id;
        if($my_id != 0){
            $this->load->model('admin/admin_test_user_model');
            $test_info = $this->admin_test_user_model->get_info($test_id);
            if(!$test_info){
                $this->session->set_flashdata('message','Không tồn tại thông tin');
                redirect(base_url('quiz'));
            }else{
                $this->load->model('admin/admin_test_model');
                $test = $this->load->admin_test_model->get_info($test_info->test_id);
                if(!$test){
                    $this->session->set_flashdata('message','Không tồn tại thông tin');
                    redirect(base_url('quiz'));
                }
                if($test->test_type!= 1){
                    if($this->admin_test_user_model->check_exists($where=array('test_id'=>$test_info->test_id, 'user_id'=>$my_id))==false){
                        $this->session->set_flashdata('message','Bạn chưa có quyền thi bài này');
                        redirect(base_url('quiz'));
                    }
                }
                if($test_info->status == 2){
                    $this->session->set_flashdata('message','Bài thi đã kết thúc');
                    redirect(base_url('quiz/test/'.$test_info->test_id));
                }else{
                    $today = date("Y-m-d H:i:s");
                    $this->admin_test_user_model->update($test_id,$dat = array('status'=>2,'end_at'=>date_create('now' ,new \DateTimeZone( 'Asia/Ho_Chi_Minh' ))->format('Y-m-d H:i:s')));
                    $this->session->set_flashdata('message','Bạn vừa hoàn thành bài thi');
                    redirect(base_url('quiz/test/'.$test_info->test_id));
                }
            }

        }
    }

    function my_test(){

        $data = array();
        $my_id = $this->my_id;
        
        $this->load->view('my_test',$this->data);
    }

    function modal_login(){
        $errors = array(
            'error' => 0
        );
        $username     = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password     = isset($_POST['password']) ? trim($_POST['password']) : '';
        
        if (empty($username)){
            $errors['username'] = 'Bạn chưa nhập tên đăng nhập';
        }
        if (empty($password)){
            $errors['password'] = 'Xin nhập password';
        }
        if (count($errors) > 1){
            $errors['error'] = 1;
            die (json_encode($errors));
        }

        $this->load->model('login_model');
        $result = $this->login_model->login($username, $password);
        //echo $username . ' - ' . $password;

        if($result)
        {

            $sess_array = array();
            foreach($result as $row)
            {
            //pre($row);
            $sess_array = array(
                'id' => $row->id,
                'user_name' => $row->user_name,
                'role' => $row->role
            );
            $this->session->set_userdata('logged_in', $sess_array);
            }
        }
        else
        {
            $errors['error'] = 1;
            $errors['e'] = 'Sai tên đăng nhập hoặc mật khẩu';
            die (json_encode($errors));
        }
        die (json_encode($errors));
    }
}
