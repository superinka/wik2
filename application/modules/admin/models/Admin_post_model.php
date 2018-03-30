<?php
class admin_post_model extends MY_Model{
    var $table = 'tb_posts';
    var $key = 'id';
    
    function get_filter($data){
        $search_term     = $data['search_term'];
        $search_category     = $data['search_category'];
        $author   = $data['author'];
        $access  =$data['access'];
        
        // //pre($author);
        
        $array= array();
        if($search_category!=0){
            $array = ['category'=>$search_category];
        }
        $this->db->where($array);
        $q = '';
        //pre($author);
        if($author!=0){
            $q = ['created_by'=>$author];
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

    public function get_autocomplete($search_term)
    {
        $this->db->like('name',$search_term);
        $this->db->or_like('description',$search_term);
        $this->db->or_like('content',$search_term);
        $query = $this->db->get('tb_posts',10);
        return $query->result();
    }

    function get_top_writer($amount){
        $query = $this->db->query("select created_by, COUNT(created_by) AS MOST_FREQUENT
        from tb_posts
        GROUP BY created_by
        ORDER BY COUNT(created_by) DESC
        LIMIT ".$amount);
        return $query->result();
    }
}
