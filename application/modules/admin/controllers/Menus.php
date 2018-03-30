<?php
class Menus extends Admin_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin/admin_menu_model');
    }
    
    function index(){
        
        $list_menu = $this->admin_menu_model->get_list([
            'order' => ['sort', 'ASC']
        ]);
        //pre($list_menu);
        
        $ref   = [];
        $items = [];
        $html ='';
        
        if(true){
            foreach ($list_menu as $key => $value) {
                $thisRef = &$ref[$value->id];
                
                $thisRef['parent'] = $value->parent;
                $thisRef['label'] = $value->label;
                $thisRef['link'] = $value->link;
                $thisRef['id'] = $value->id;
                
                if($value->parent == 0) {
                    $items[$value->id] = &$thisRef;
                } else {
                    $ref[$value->parent]['child'][$value->id] = &$thisRef;
                }
            }
            
            $html = $this->admin_menu_model->get_menu($items,$class = 'dd-list');
            
            //pre($html);
        }
        
        $this->data['html'] = $html;
        $this->data['temp'] = 'menu';
        $this->load->view('admin/admin-layout/main', $this->data);
    }
    
    function save(){
        $data = json_decode($_POST['data']);
        //pre($data);
        
        $readbleArray = $this->parseJsonArray($data);
        
        $i=0;
        foreach($readbleArray as $row){
            $i++;
            $data_update = array(
                'parent' => $row['parentID'],
                'sort'   => $i
            );
            $this->admin_menu_model->update($row['id'], $data_update);
        }
        
    }
    
    function parseJsonArray($jsonArray, $parentID = 0) {
        
        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            if (isset($subArray->children)) {
                $returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
            }
            
            $return[] = array('id' => $subArray->id, 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }
        return $return;
    }
    
    function save_menu(){
        
        if($_POST['id'] != ''){
            $data_update = array(
                'label' => $_POST['label'],
                'link'   => $_POST['link']
            );
            $this->admin_menu_model->update($_POST['id'], $data_update);
            
            $arr['type']  = 'edit';
            $arr['label'] = $_POST['label'];
            $arr['link']  = $_POST['link'];
            $arr['id']    = $_POST['id'];
            
            die (json_encode($arr));
            
        } else {
            $label     = isset($_POST['label']) ? trim($_POST['label']) : '';
            $link     = isset($_POST['link']) ? trim($_POST['link']) : '';
            
            $data_insert = array(
                'label' => $label,
                'link'   => $link
            );
            $this->admin_menu_model->create($data_insert);
            
            $arr['menu'] = '<li class="dd-item" data-id="'.$this->db->insert_id().'" >
								<div class="dd-handle">
									<span class="orange">'.$_POST['label'].'</span>
									<span class="lighter grey">
										&nbsp; '.$_POST['link'].'
									</span>
								</div>
								<div class="pull-right action-buttons-menu">
									<a class="edit-button" id="'.$this->db->insert_id().'" label="'.$_POST['label'].'" link="'.$_POST['link'].'" ><i class="fa fa-pencil"></i></a>
									<a class="del-button" id="'.$this->db->insert_id().'"><i class="fa fa-trash"></i></a>
								</div>';
            
            $arr['type'] = 'add';
            die (json_encode($arr));
        }
        
        
        
        
        $this->data['temp'] = 'save_menu';
        $this->load->view('save_menu', $this->data);
    }
    
    function delete(){
        //pre('abc');
        
        $this->recursiveDelete($_POST['id']);
    }
    
    function recursiveDelete($id) {
        $query = $this->db->query("select * from tb_menus where parent = '".$id."' ");
        
        // $input = array();
        // $input['where']['parent'] = $id;
        // $list_menu = $this->admin_menu_model->get_list($input);
        
        if ($query->num_rows()>0) {
            while(mysql_fetch_array($query)) {
                recursiveDelete($current['id']);
            }
        }
        $this->db->query("delete from tb_menus where id = '".$id."' ");
    }
}
