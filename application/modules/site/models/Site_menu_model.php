<?php
Class site_menu_model extends MY_Model{
    var $table = 'tb_menus';
    var $key = 'id';
    
    function get_menu_top($items,$class = 'dd-list') {
        
        $html = "<ol class=\"".$class."\" id=\"menu-id\">";
        
        foreach($items as $key=>$value) {
            //pre($value);
            $html.= '<li class="dd-item dd3-item" data-id="'.$value->id.'" >
						<div class="dd-handle dd3-handle">Drag</div>
						<div class="dd3-content"><span id="label_show'.$value->id.'">'.$value->label.'</span>
							<span class="span-right">/<span id="link_show'.$value->id.'">'.$value->link.'</span> &nbsp;&nbsp;
								<a class="edit-button" id="'.$value->id.'" label="'.$value->label.'" link="'.$value->link.'" ><i class="fa fa-pencil"></i></a>
								<a class="del-button" id="'.$value->id.'"><i class="fa fa-trash"></i></a></span>
						</div>';
            if(array_key_exists('child',$value)) {
                $html .= $this->get_menu_top($value->child,'child');
            }
            $html .= "</li>";
        }
        $html .= "</ol>";
        
        return $html;
        
    }
}
