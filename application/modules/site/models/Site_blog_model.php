<?php
class site_blog_model extends MY_Model{
    var $table = 'tb_posts';
    var $key = 'id';
    
    function update_counter($post_id) {
        // return current article views
        $this->db->where('id', urldecode($post_id));
        $this->db->select('views_count');
        $count = $this->db->get('tb_posts')->row();
        // then increase by one
        $this->db->where('id', urldecode($post_id));
        $this->db->set('views_count', ($count->views_count + 1));
        $this->db->update('tb_posts');
    }
    
    
    
}