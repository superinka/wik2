<?php 
	function public_url($url=''){
		return base_url('public/'.$url);
	}
	function admin_theme($url=''){
		return base_url('public/template/back-end/ace-master'.$url);
	}

	function site_theme($url=''){
		return base_url('public/template/front-end/acme-free'.$url);
	}

	function portal_theme($url=''){
		return base_url('public/template/front-end/Magz-master'.$url);
	}

	function pre($list,$exit=true){
		echo "<pre>";
		print_r($list);
		
		if($exit){
			die();
		}
	}

	function reg_status($status){
		if($status == 1) {
			return '<span class="label label-sm label-success">Kích hoạt</span>';
		}
		else {
			return '<span class="label label-sm label-inverse arrowed-in">Chưa kích hoạt</span>';
		}
	}
	
	function reg_process($status){
	    if($status == 1) {
	        return '<span class="label label-sm label-success">Hoàn Thành</span>';
	    }
	    else {
	        return '<span class="label label-sm label-inverse arrowed-in">Chưa Hoàn Thành</span>';
	    }
	}
	
	function reg_group($user_role){
		if($user_role == 1) {
			return '<span class="label label-danger arrowed-in">Admin</span>';
		}
		else {
			return '<span class="label label-success arrowed-in">Editor</span>';
		}
	}

	function limit_text($text, $limit) {
		if (str_word_count($text, 0) > $limit) {
			$words = str_word_count($text, 2);
			$pos = array_keys($words);
			$text = substr($text, 0, $pos[$limit]) . '...';
		}
		return $text;
	}

	function name_of_month($month){
		$month = intval($month);
		if($month > 0 && $month < 13 ){
			switch ($month) {
				case '1':
					return 'Tháng Một';
					break;
				case '2':
					return 'Tháng Hai';
					break;
				case '3':
					return 'Tháng Ba';
					break;		
				case '4':
					return 'Tháng Tư';
					break;
				case '5':
					return 'Tháng Năm';
					break;
				case '6':
					return 'Tháng Sáu';
					break;	
				case '7':
					return 'Tháng Bảy';
					break;
				case '8':
					return 'Tháng Tám';
					break;
				case '9':
					return 'Tháng Chín';
					break;		
				case '10':
					return 'Tháng Mười';
					break;
				case '11':
					return 'Tháng Mười Một';
					break;
				case '12':
					return 'Tháng Mười Hai';
					break;				
				default:
					return 'Không xác định';
					break;
			}
		}
		else {
			return 'Không xác định';
		}
	}

	function generate_uuid($str) {
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0x0C2f ) | 0x4000,
			mt_rand( 0, 0x3fff ) | 0x8000,
			mt_rand( 0, 0x2Aff ), mt_rand( 0, 0xffD3 ), mt_rand( 0, 0xff4B ),
			$str
		);
	
	}

	function generateRandomString($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	function get_thumb($str){
		$newstr =  substr($str,0,-4);
		$newstr = $newstr.substr($str,-4);
		return $newstr;
	}
	
	// This function will take $_SERVER['REQUEST_URI'] and build a breadcrumb based on the user's current path
	function breadcrumbs($separator = ' &raquo; ', $home = 'Home') {
	    // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
	    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
	    //pre($path);
	    // This will build our "base URL" ... Also accounts for HTTPS :)
	    $base = base_url();
	    
	    // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
	    $breadcrumbs = Array("<a href=\"$base\">$home</a>");
	    
	    // Find out the index for the last value in our path array
	    $last = end(array_keys($path));
	    
	    // Build the rest of the breadcrumbs
	    foreach ($path AS $x => $crumb) {
	        // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
	        $title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb));
	        
	        // If we are not on the last index, then display an <a> tag
	        if ($x != $last)
	            $breadcrumbs[] = "<a href=\"$base$crumb\">$title</a>";
	            // Otherwise, just display the title (minus)
	            else
	                $breadcrumbs[] = $title;
	    }
	    
	    // Build our temporary array (pieces of bread) into one big string :)
	    return implode($separator, $breadcrumbs);
	}

	function convert_time($str){
		$arr = explode(' ', $str);

		$day = $arr[0];
		$time = $arr[1];
		$type_of_time = $arr[2];
		$x = $time. ' ' .$type_of_time;
		
		$new_day = date("Y-m-d", strtotime($day));

		$new_time = DateTime::createFromFormat('h:i A', $x);
		$time_24 = $new_time->format('H:i:s');

		$string = $new_day.' '.$time_24;

		$date = date_create($string);

		return date_format($date, 'Y-m-d H:i:s');
	}

	function convert_time_to_text($str){
		$arr = explode(' ', $str);
		$day = $arr[0];
		$time = $arr[1];

		$new_day = date("m/d/Y", strtotime($day));
		$x = $time.' '.$new_day;

		$date = new DateTime($x);
		return $date->format('m/d/Y h:i a') ; 
	}

	function test_status($status){
		if($status == 0){
			return '<span class="label label-warning"><i class="ace-icon fa fa-exclamation-triangle bigger-120"></i> Chưa làm bài
		</span>';
		}
		if($status == 1){
			return '<span class="label label-danger"><i class="ace-icon fa fa-arrow-right bigger-120"></i> Đang làm bài
		</span>';
		}
		if($status == 2){
			return '<span class="label label-success"><i class="ace-icon fa fa-check bigger-120"></i> Kết thúc
		</span>';
		}
	}

	function my_sort($arr,$key){
		for ($i = 0; $i < count($arr) - 1; $i++)
		{
			for ($j = $i + 1; $j < count($arr); $j++) // lặp các phần tử phía sau
			{
				if ($arr[$i][$key] < $arr[$j][$key]) // nếu phần tử $i bé hơn phần tử phía sau
				{
					// hoán vị
					$tmp = $arr[$j];
					$arr[$j] = $arr[$i];
					$arr[$i] = $tmp;
				}
			}
		}

		return $arr;
	}

	function this_week(){
		$now = date("Y-m-d");
		return date("W", strtotime($now));
	}
	function this_month(){
		$now = date("Y-m-d");
		return date("M", strtotime($now));
	}

	function shorten_text($text, $max_length = 140, $cut_off = '...', $keep_word = false)
	{
		
        $exceptions = '<p>,<a>,<em>,<strong>,<br><img>'; //PRESERVE THESE TAGS, ADD/REMOVE AS NEEDED
		$text = my_strip_tags(htmlspecialchars_decode($text));
	
		if(strlen($text) <= $max_length) {
			return $text;
		}

		if(strlen($text) > $max_length) {
			if($keep_word) {
				$text = substr($text, 0, $max_length + 1);

				if($last_space = strrpos($text, ' ')) {
					$text = substr($text, 0, $last_space);
					$text = rtrim($text);
					$text .=  $cut_off;
				}
			} else {
				$text = substr($text, 0, $max_length);
				$text = rtrim($text);
				$text .=  $cut_off;
			}
		}

		return $text;
	}

	function my_strip_tags($str) {
		$strs=explode('<',$str);
		$res=$strs[0];
		for($i=1;$i<count($strs);$i++)
		{
			if(!strpos($strs[$i],'>'))
				$res = $res.'&lt;'.$strs[$i];
			else
				$res = $res.'<'.$strs[$i];
		}
		return strip_tags($res);   
	}


	function rip_tags($string) { 
		
		// ----- remove HTML TAGs ----- 
		$string = preg_replace ('/<[^>]*>/', ' ', $string); 
		
		// ----- remove control characters ----- 
		$string = str_replace("\r", '', $string);    // --- replace with empty space
		$string = str_replace("\n", ' ', $string);   // --- replace with space
		$string = str_replace("\t", ' ', $string);   // --- replace with space
		
		// ----- remove multiple spaces ----- 
		$string = trim(preg_replace('/ {2,}/', ' ', $string));
		
		return $string; 

	}


?>
