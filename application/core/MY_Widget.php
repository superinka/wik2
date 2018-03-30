<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Widget 
{
        function __get($key)
    {
        $CI =& get_instance();
        return $CI->$key;
    }
         
        function __set($key, $val)
        {
                $CI =& get_instance();
                if (isset($CI->$key))
                    $CI->$key = $val;
                else
                    $this->$key = $val;
        }
}
?>