<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function token_post()
    {
        $dataPost = $this->input->post();
        $user = $this->user_model->login($dataPost['username'], $dataPost['password']);
        //pre($user);
        if ($user != null) {
            $sess_array = array(
                'id' => $user->id,
                'user_name' => $user->user_name,
                'role' => $user->role    
              );
            $this->session->set_userdata('logged_in', $sess_array);

            $tokenData = array();
            $tokenData['id'] = $user->id;
            $tokenData['timestamp'] = now();

            $response['token'] = Authorization::generateToken($tokenData);
            $this->set_response($response, REST_Controller::HTTP_OK);
            //pre($response);
            return;
        }
        $response = [
            'status' => REST_Controller::HTTP_UNAUTHORIZED,
            'message' => 'Unauthorized',
        ];
        $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
    }
}
