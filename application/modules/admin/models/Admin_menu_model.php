<?php
Class admin_menu_model extends MY_Model{
    var $table = 'tb_menus';
    var $key = 'id';
    
    function get_menu($items,$class = 'dd-list') {
        
        $html = "<ol class=\"".$class."\" id=\"menu-id\">";
        
        foreach($items as $key=>$value) {
            $html.= '<li class="dd-item" data-id="'.$value['id'].'" >
						<div class="dd-handle">
							<span class="orange">'.$value['label'].'</span>
							<span class="lighter grey">
								&nbsp; '.$value['link'].'
							</span>
						</div>
						<div class="pull-right action-buttons-menu">
							<a class="edit-button" id="'.$value['id'].'" label="'.$value['label'].'" link="'.$value['link'].'" ><i class="fa fa-pencil"></i></a>
							<a class="del-button" id="'.$value['id'].'"><i class="fa fa-trash"></i></a>
						</div>';
            if(array_key_exists('child',$value)) {
                $html .= $this->get_menu($value['child'],'child');
            }
            $html .= "</li>";
        }
        $html .= "</ol>";
        
        return $html;
        
    }
}
