<?php
Class site_post_model extends MY_Model{
    var $table = 'tb_posts';
    var $key = 'id';
    
    function get_search($search_term) {
        $match = $this->input->post('search_term');
        $this->db->like('name',$search_term);
        $this->db->or_like('description',$search_term);
        $this->db->or_like('content',$search_term);
        $this->db->or_like('slug',$search_term);
        $query = $this->db->get('tb_posts');
        return $query->result();
    }
    
    function get_filter($data){
        $search_term     = $data['search_term'];
        $search_category     = $data['search_category'];
        $framework   = $data['framework'];
        $access  =$data['access'];
        
        // //pre($framework);
        
        $array= array();
        if($search_category!=0){
            $array = ['category'=>$search_category];
        }
        $this->db->where($array);
        $q = '';
        //pre($framework);
        if($framework!=0){
            for ($i=0; $i < count($framework) ; $i++) {
                $q = $q . 'created_by="'.$framework[$i].'"';
                if($i+1 < count($framework)){
                    $q = $q.' OR ';
                }
            }
            $q = '(' . $q. ')';
            //pre($q);
            $this->db->where($q);
        }
        else {
            $this->db->where($arr = array());
        }
        $this->db->where($array = ['access'=>$access]);
        $this->db->like('name',$search_term);
        $this->db->order_by('ID','DESC');
        //$this->db->or_like('content',$search_term);
        $query = $this->db->get('tb_posts');
        //$str = $this->db->last_query();
        //pre($str);
        return $query->result();
    }
}
