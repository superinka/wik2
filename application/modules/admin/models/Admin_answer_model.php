<?php
Class admin_answer_model extends MY_Model{
	var $table = 'tb_answers';
	var $key = 'id';

	function list_answers($question_id){

		$list_answers = array();
		$list_answers = $this->admin_answer_model->get_list([
			'order' => ['id', 'DESC'],
			'where' => ['question_id'=>$question_id]
		]);

		return $list_answers;
	}
}