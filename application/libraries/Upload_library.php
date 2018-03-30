<?php 
Class Upload_library {
	var $CI = '';

	function __construct() {
		$this->CI = & get_instance();
		$this->CI->load->library('upload');
	}

	function upload($upload_path ='', $file_name =''){
		if($this->validate_upload_path($upload_path)){
			$config = $this->config($upload_path);

		
			if (empty($_FILES[$file_name]['name'])) {
	
			}
			$newFileName = time().$_FILES[$file_name]['name'].rand(0,999999);
			//pre($_FILES[$file_name]['size']);
			$config['file_name'] = md5($newFileName);
	
			$this->CI->upload->initialize($config);
			$this->CI->load->library('upload', $config);
			
	
			//pre($config);
	
			if($this->CI->upload->do_upload($file_name)) {
				$data_upload = $this->CI->upload->data();
			}
			else {
				$data_upload = $this->CI->upload->display_errors();
				//echo 'haha';
			}
	
			return $data_upload;
		}else {
			return "CÓ LỖI";
		}
		
		
	}

	function config($upload_path =''){

		//Khai bao bien cau hinh
         $config = array();
         //thuc mục chứa file
         $config['upload_path']   = $upload_path;
         //Định dạng file được phép tải
         $config['allowed_types'] = 'jpg|png|gif|doc|docx|pdf|zip|rar';
         //Dung lượng tối đa
         $config['max_size']      = '50000';
         //Chiều rộng tối đa
         $config['max_width']     = '2028';
         //Chiều cao tối đa
		 $config['max_height']    = '2028';
		 
		 $config['width']         = 640;
		 $config['height']       = 395;


         return $config;
		
	}

	public function validate_upload_path($upload_path)
    {
		$this->upload_path = $upload_path;
        if ($this->upload_path === '')
        {
            $this->set_error('upload_no_filepath', 'error');
            return FALSE;
        }

        if (realpath($this->upload_path) !== FALSE)
        {
            $this->upload_path = str_replace('\\', '/', realpath($this->upload_path));
        }

        if ( ! is_dir($this->upload_path))
        {
            // EDIT: make directory and try again
            if ( ! mkdir ($this->upload_path, 0777, TRUE))
            {
                $this->set_error('upload_no_filepath', 'error');
                return FALSE;
            }
        }

        if ( ! is_really_writable($this->upload_path))
        {
            // EDIT: change directory mode
            if ( ! chmod($this->upload_path, 0777))
            {
                $this->set_error('upload_not_writable', 'error');
                return FALSE;
            }
        }

        $this->upload_path = preg_replace('/(.+?)\/*$/', '\\1/',  $this->upload_path);
        return TRUE;
    }
}
?>