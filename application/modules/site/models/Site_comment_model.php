<?php
class site_comment_model extends MY_Model{
    var $table = 'tb_comments';
    var $key = 'id';
    
    function get_blog_comments($post_id) {
        
        $this->load->model('site/site_blog_model');
        $this->load->model('site/site_comment_model');
        $list_comments = array();
        $list_comments = $this->site_comment_model->get_list([
            'where' => ['post_id' => $post_id, 'parent_id'=>0],
            'order' => ['id'=>'ASC']
        ]);
        
        if ($list_comments!=null) {
            
            foreach ($list_comments as $key => $value) {
                $comment_id = $value->id;
                $list_comments_chilren = $this->site_comment_model->get_list([
                    'where' => ['post_id' => $post_id, 'parent_id'=>$comment_id],
                    'order' => ['id'=>'ASC']
                ]);
                sort($list_comments_chilren);
                //$list_comments[$key]['chilren_comments'] = array();
                $list_comments[$key]->chilren_comments = $list_comments_chilren;
                
            }
            //pre($list_comments);
            
            
        }
        return $list_comments;
    }
    
    //add blog comment
    function add_blog_comment($data) {
        $this->load->model('site/site_comment_model');
        $this->site_comment_model->create($data);
        $inserted_id = $this->db->insert_id();
        if ($inserted_id > 0) {
            $info_comment = $this->site_comment_model->get_info($inserted_id);
            return $info_comment;
        }
        return NULL;
    }

    function get_top_post_comments($amount){
        $query = $this->db->query("select post_id, COUNT(post_id) AS MOST_FREQUENT
        from tb_comments
        GROUP BY post_id
        ORDER BY COUNT(post_id) DESC
        LIMIT ".$amount);
        return $query->result();
    }
    
    
}