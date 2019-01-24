<?php
// 负责处理各类统计相关
class Total_model extends TW_Model {
	public function __construct() {
		parent :: __construct();
	}
	
	public function total($i_id_task, $i_id_task_group, $i_id_project, $i_id_project_parent) {
		$this->task_total($i_id_task);
		$this->group_total($i_id_task_group);
		$this->project_total($i_id_project);
		$this->project_parent_total($i_id_project_parent);
	}
	
	public function task_total($i_id_task) {
		// 未开始的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_task` = {$i_id_task} AND (`state` = 0 OR `state` = 60)");
		$f_not = 0;
		foreach ($o_data as $a_sum) {
			$f_not = $a_sum['total'];
		}
		// 已开始的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_task` = {$i_id_task} AND `state` = 10");
		$f_start = 0;
		foreach ($o_data as $a_sum) {
			$f_start = $a_sum['total'];
		}
		// 已完成的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_task` = {$i_id_task} AND `state` = 20");
		$f_finsh = 0;
		foreach ($o_data as $a_sum) {
			$f_finsh = $a_sum['total'];
		}
		
		$a_data['hour_plan'] = $f_not + $f_start + $f_finsh;
		$a_data['ratio_finsh'] = round($f_finsh / $a_data['hour_plan'] * 100, 2);
		$this->db->update('task', $a_data, ['id_task' => $i_id_task]);
	}
	
	public function group_total($i_id_task_group) {
		// 未开始的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_task_group` = {$i_id_task_group} AND (`state` = 0 OR `state` = 60)");
		$f_not = 0;
		foreach ($o_data as $a_sum) {
			$f_not = $a_sum['total'];
		}
		// 已开始的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_task_group` = {$i_id_task_group} AND `state` = 10");
		$f_start = 0;
		foreach ($o_data as $a_sum) {
			$f_start = $a_sum['total'];
		}
		// 已完成的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_task_group` = {$i_id_task_group} AND `state` = 20");
		$f_finsh = 0;
		foreach ($o_data as $a_sum) {
			$f_finsh = $a_sum['total'];
		}
		
		$a_data['task_total'] = $this->db->get_total('task', ['id_task_group' => $i_id_task_group, 'state <>' => 30]);
		$a_data['task_start'] = $this->db->get_total('task', ['id_task_group' => $i_id_task_group, 'state' => 10]);
		$a_data['task_finsh'] = $this->db->get_total('task', ['id_task_group' => $i_id_task_group, 'state' => 20]);
		$a_data['task_finsh_not'] = $this->db->get_total('task', ['id_task_group' => $i_id_task_group, 'state' => 0]);
		
		$a_data['task_time_total'] = $f_not + $f_start + $f_finsh;
		$a_data['task_time_start'] = $f_start;
		$a_data['task_time_finsh'] = $f_finsh;
		$a_data['task_time_finsh_not'] = $f_not;
		$a_data['task_ratio_start'] = round($f_start / $a_data['task_time_total'] * 100, 2);
		$a_data['task_ratio_finsh_not'] = round($f_not / $a_data['task_time_total'] * 100, 2);
		$a_data['task_ratio_finsh'] = 100 - $a_data['task_ratio_start'] - $a_data['task_ratio_finsh_not'];
		$this->db->update('task_group', $a_data, ['id_task_group' => $i_id_task_group]);
	}
	
	public function project_total($i_id_project) {
		// 未开始的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_project` = {$i_id_project} AND (`state` = 0 OR `state` = 60)");
		$f_not = 0;
		foreach ($o_data as $a_sum) {
			$f_not = $a_sum['total'];
		}
		// 已开始的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_project` = {$i_id_project} AND `state` = 10");
		$f_start = 0;
		foreach ($o_data as $a_sum) {
			$f_start = $a_sum['total'];
		}
		// 已完成的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_project` = {$i_id_project} AND `state` = 20");
		$f_finsh = 0;
		foreach ($o_data as $a_sum) {
			$f_finsh = $a_sum['total'];
		}
		
		$a_data['task_total'] = $this->db->get_total('task', ['id_project' => $i_id_project, 'state <>' => 30]);
		$a_data['task_start'] = $this->db->get_total('task', ['id_project' => $i_id_project, 'state' => 10]);
		$a_data['task_finsh'] = $this->db->get_total('task', ['id_project' => $i_id_project, 'state' => 20]);
		$a_data['task_finsh_not'] = $this->db->get_total('task', ['id_project' => $i_id_project, 'state' => 0]);
		
		$a_data['task_time_total'] = $f_not + $f_start + $f_finsh;
		$a_data['task_time_start'] = $f_start;
		$a_data['task_time_finsh'] = $f_finsh;
		$a_data['task_time_finsh_not'] = $f_not;
		$a_data['task_ratio_start'] = round($f_start / $a_data['task_time_total'] * 100, 2);
		$a_data['task_ratio_finsh_not'] = round($f_not / $a_data['task_time_total'] * 100, 2);
		$a_data['task_ratio_finsh'] = 100 - $a_data['task_ratio_start'] - $a_data['task_ratio_finsh_not'];
		$this->db->update('project', $a_data, ['id_project' => $i_id_project]);
	}
	
	public function project_parent_total($i_id_project) {
		// 未开始的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_project_parent` = {$i_id_project} AND (`state` = 0 OR `state` = 60)");
		$f_not = 0;
		foreach ($o_data as $a_sum) {
			$f_not = $a_sum['total'];
		}
		// 已开始的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_project_parent` = {$i_id_project} AND `state` = 10");
		$f_start = 0;
		foreach ($o_data as $a_sum) {
			$f_start = $a_sum['total'];
		}
		// 已完成的总时间
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_project_parent` = {$i_id_project} AND `state` = 20");
		$f_finsh = 0;
		foreach ($o_data as $a_sum) {
			$f_finsh = $a_sum['total'];
		}
		
		$a_data['task_total'] = $this->db->get_total('task', ['id_project_parent' => $i_id_project, 'state <>' => 30]);
		$a_data['task_start'] = $this->db->get_total('task', ['id_project_parent' => $i_id_project, 'state' => 10]);
		$a_data['task_finsh'] = $this->db->get_total('task', ['id_project_parent' => $i_id_project, 'state' => 20]);
		$a_data['task_finsh_not'] = $this->db->get_total('task', ['id_project_parent' => $i_id_project, 'state' => 0]);
		
		$a_data['task_time_total'] = $f_not + $f_start + $f_finsh;
		$a_data['task_time_start'] = $f_start;
		$a_data['task_time_finsh'] = $f_finsh;
		$a_data['task_time_finsh_not'] = $f_not;
		$a_data['task_ratio_start'] = round($f_start / $a_data['task_time_total'] * 100, 2);
		$a_data['task_ratio_finsh_not'] = round($f_not / $a_data['task_time_total'] * 100, 2);
		$a_data['task_ratio_finsh'] = 100 - $a_data['task_ratio_start'] - $a_data['task_ratio_finsh_not'];
		$this->db->update('project', $a_data, ['id_project' => $i_id_project]);
	}
	
	/**
	public function procedure_finsh($i_procedure) {
		try {
			// 开启事务
			$this->db->begin();
			
			$a_procedure = $this->db->get_row('procedure', ['id_procedure' => $i_procedure]);
			
			// 检测是不是整个任务完成，如果全部完成，把任务更新为完成
			$b_task_finsh = false;
			if ( ! $this->db->get_total('procedure', ['id_task' => $a_procedure['id_task'], 'state <>' => 20]) ) {
				$b_task_finsh = true;
				$this->db->update('task', ['state' => 20], ['id_task' => $a_procedure['id_task']]);
			}
			$a_task = $this->db->get_row('task', ['id_task' => $a_procedure['id_task']], 'id_task_group, hour_plan, hour_used');
			// 更新任务的已使用时间
			$a_set = [];
			$a_set['hour_used'] = $a_task['hour_used'] + $a_procedure['plan_hour'];
			$a_set['ratio_finsh'] = ($a_set['hour_used'] > $a_task['hour_plan']) ? 100 : round($a_set['hour_used'] / $a_task['hour_plan'] * 100, 2);
			$a_set['hour_overflow'] = ($a_set['hour_used'] > $a_task['hour_plan']) ? ($a_set['hour_used'] - $a_task['hour_plan']) : 0;
			$this->db->update('task', $a_set, ['id_task' => $a_procedure['id_task']]);
			
			// 任务组
			$a_group = $this->db->get_row('task_group', ['id_task_group' => $a_task['id_task_group']]);
			$a_set = [];
			if ($b_task_finsh) {
				$a_set['task_start'] = $a_group['task_start'] - 1;
				$a_set['task_finsh'] = $a_group['task_start'] + 1;
				$a_set['task_time_start'] = $a_group['task_time_start'] - $a_task['hour_plan'];
				$a_set['task_time_finsh'] = $a_group['task_time_finsh'] + $a_task['hour_plan'];
			} else {
				$a_set['task_time_start'] = $a_group['task_time_start'] - $a_procedure['plan_hour'];
				$a_set['task_time_finsh'] = $a_group['task_time_finsh'] + $a_procedure['plan_hour'];
			}
			$a_set['task_ratio_start'] = round($a_set['task_time_start'] / $a_group['task_time_total'] * 100, 2);
			$a_set['task_ratio_finsh_not'] = round($a_group['task_time_finsh_not'] / $a_group['task_time_total'] * 100, 2);
			$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
			$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
			$this->db->update('task_group', $a_set, ['id_task_group' => $a_task['id_task_group']]);
			
			// 子项目
			$a_project = $this->db->get_row('project', ['id_project' => $a_group['id_project']]);
			$a_set = [];
			if ($b_task_finsh) {
				$a_set['task_start'] = $a_project['task_start'] - 1;
				$a_set['task_finsh'] = $a_project['task_start'] + 1;
				$a_set['task_time_start'] = $a_project['task_time_start'] - $a_task['hour_plan'];
				$a_set['task_time_finsh'] = $a_project['task_time_finsh'] + $a_task['hour_plan'];
			} else {
				$a_set['task_time_start'] = $a_project['task_time_start'] - $a_procedure['plan_hour'];
				$a_set['task_time_finsh'] = $a_project['task_time_finsh'] + $a_procedure['plan_hour'];
			}
			$a_set['task_ratio_start'] = round($a_set['task_time_start'] / $a_project['task_time_total'] * 100, 2);
			$a_set['task_ratio_finsh_not'] = round($a_project['task_time_finsh_not'] / $a_project['task_time_total'] * 100, 2);
			$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
			$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
			$this->db->update('project', $a_set, ['id_project' => $a_group['id_project']]);
			
			// 父项目
			$a_project = $this->db->get_row('project', ['id_project' => $a_group['id_project_parent']]);
			$a_set = [];
			if ($b_task_finsh) {
				$a_set['task_start'] = $a_project['task_start'] - 1;
				$a_set['task_finsh'] = $a_project['task_start'] + 1;
				$a_set['task_time_start'] = $a_project['task_time_start'] - $a_task['hour_plan'];
				$a_set['task_time_finsh'] = $a_project['task_time_finsh'] + $a_task['hour_plan'];
			} else {
				$a_set['task_time_start'] = $a_project['task_time_start'] - $a_procedure['plan_hour'];
				$a_set['task_time_finsh'] = $a_project['task_time_finsh'] + $a_procedure['plan_hour'];
			}
			$a_set['task_ratio_start'] = round($a_set['task_time_start'] / $a_project['task_time_total'] * 100, 2);
			$a_set['task_ratio_finsh_not'] = round($a_project['task_time_finsh_not'] / $a_project['task_time_total'] * 100, 2);
			$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
			$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
			$this->db->update('project', $a_set, ['id_project' => $a_group['id_project_parent']]);
			
			// 提交事务
			$this->db->commit();
		} catch (Exception $e) {
			// 事务回滚
			$this->db->roll_back();
		}//file_put_contents('d:/1.txt', $this->db->get_sql());
	}
	
	public function procedure_create($i_task, $i_project, $f_hour) {
		$a_project = $this->project_model->get_names($i_project);
		$a_data = $this->db->get_row('task', ['id_task' => $i_task]);
		$i_task_group = $a_data['id_task_group'];
		if (empty($a_project['project_id_parent'])) {
			return false;
		}
		try {
			// 开启事务
			$this->db->begin();
			
			// 增加时间
			$this->_time_add($i_task, $f_hour);
			// 更新开始时间
			$this->_time_start($i_task, $f_hour);
			
			
			// 提交事务
			$this->db->commit();
		} catch (Exception $e) {
			// 事务回滚
			$this->db->roll_back();
		}
	}
	
	public function task_create($i_task, $i_task_group, $i_project, $i_project_parent, $f_hour) {
		try {
			// 开启事务
			$this->db->begin();
			
			// 处理任务组数据
			$this->_group_add($i_task, $i_task_group, $f_hour);
			
			// 处理项目数据
			$this->_project_add($i_project, $f_hour);
			$this->_project_add($i_project_parent, $f_hour);
			
			// 提交事务
			$this->db->commit();
		} catch (Exception $e) {
			// 事务回滚
			$this->db->roll_back();
		}//file_put_contents('d:/1.txt', $this->db->get_sql());
	}
	
	public function action_create($i_procedure) {
		try {
			// 开启事务
			$this->db->begin();
			
			// 判断流程是否已完成，如果已完成，那当前需要把状态变更为未完成，同时更新任务、任务组、项目的时间
			$a_procedure = $this->db->get_row('procedure', ['id_procedure' => $i_procedure]);
			if ($a_procedure['state'] == 20) {
				// 流程
				$a_set = [];
				$a_set['state'] = 10;
				$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
				$this->db->update('procedure', $a_set, ['id_procedure' => $i_procedure]);
				
				// 任务
				$a_task = $this->db->get_row('task', ['id_task' => $a_procedure['id_task']]);
				$a_set = [];
				$a_set['state'] = 50;
				$a_set['ratio_finsh'] = round(($a_task['hour_plan'] - $a_procedure['plan_hour']) / $a_task['hour_plan'] * 100, 2);
				$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
				$this->db->update('task', $a_set, ['id_task' => $a_procedure['id_task']]);
				
				// 任务组
				$a_group = $this->db->get_row('task_group', ['id_task_group' => $a_task['id_task_group']]);
				$a_set = [];
				$a_set['task_time_start'] = $a_group['task_time_start'] + $a_procedure['plan_hour'];
				$a_set['task_time_finsh'] = $a_group['task_time_finsh'] - $a_procedure['plan_hour'];
				$a_set['task_ratio_start'] = round($a_set['task_time_start'] / $a_group['task_time_total'] * 100, 2);
				$a_set['task_ratio_finsh_not'] = round($a_group['task_time_finsh_not'] / $a_group['task_time_total'] * 100, 2);
				$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
				$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
				$this->db->update('task_group', $a_set, ['id_task_group' => $a_task['id_task_group']]);
				
				// 子项目
				$a_project = $this->db->get_row('project', ['id_project' => $a_task['id_project']]);
				$a_set = [];
				$a_set['task_time_start'] = $a_project['task_time_start'] + $a_procedure['plan_hour'];
				$a_set['task_time_finsh'] = $a_project['task_time_finsh'] - $a_procedure['plan_hour'];
				$a_set['task_ratio_start'] = round($a_set['task_time_start'] / $a_project['task_time_total'] * 100, 2);
				$a_set['task_ratio_finsh_not'] = round($a_project['task_time_finsh_not'] / $a_project['task_time_total'] * 100, 2);
				$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
				$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
				$this->db->update('project', $a_set, ['id_project' => $a_task['id_project']]);
				
				// 父项目
				$a_project = $this->db->get_row('project', ['id_project' => $a_task['id_project_parent']]);
				$a_set = [];
				$a_set['task_time_start'] = $a_project['task_time_start'] + $a_procedure['plan_hour'];
				$a_set['task_time_finsh'] = $a_project['task_time_finsh'] - $a_procedure['plan_hour'];
				$a_set['task_ratio_start'] = round($a_set['task_time_start'] / $a_project['task_time_total'] * 100, 2);
				$a_set['task_ratio_finsh_not'] = round($a_project['task_time_finsh_not'] / $a_project['task_time_total'] * 100, 2);
				$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
				$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
				$this->db->update('project', $a_set, ['id_project' => $a_task['id_project_parent']]);
			}
			
			// 提交事务
			$this->db->commit();
		} catch (Exception $e) {
			// 事务回滚
			$this->db->roll_back();
		}
	}
	
	private function _task_ratio_finsh($i_task, &$a_task = '') {
		if (! is_array($a_task) ) {
			$a_task = $this->db->get_row('task', ['id_task' => $i_task]);
		}
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_task` = {$i_task}");
		$i_total = 0;
		foreach ($o_data as $a_sum) {
			$i_total = $a_sum['total'];
		}
		$o_data = $this->db->query("SELECT sum(`plan_hour`) as total FROM `" . $this->db->get_prefix('procedure') . "` WHERE `id_task` = {$i_task} AND `state`=20");
		$i_total_finsh = 0;
		foreach ($o_data as $a_sum) {
			$i_total_finsh = $a_sum['total'];
		}
		return round($i_total_finsh / $i_total * 100, 2);
	}
	
	// 任务的时间变成开始
	private function _time_start($i_task, $f_hour) {
		$a_task = $this->db->get_row('task', ['id_task' => $i_task]);
		$a_set = [];
		$a_set['state'] = 10;
		$a_set['ratio_finsh'] = $this->_task_ratio_finsh($i_task, $a_task);
		$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
		$this->db->update('task', $a_set, ['id_task' => $i_task]);
		
		// 任务组的时间变化及比例变化
		$a_group = $this->db->get_row('task_group', ['id_task_group' => $a_task['id_task_group']]);
		$a_set = [];
		$a_set['task_time_start'] = $a_group['task_time_start'] + $f_hour;
		$a_set['task_time_finsh_not'] = $a_group['task_time_finsh_not'] - $f_hour;
		$a_set['task_ratio_start'] = round($a_set['task_time_start'] / $a_group['task_time_total'] * 100, 2);
		$a_set['task_ratio_finsh_not'] = round($a_set['task_time_finsh_not'] / $a_group['task_time_total'] * 100, 2);
		$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
		$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
		$this->db->update('task_group', $a_set, ['id_task_group' => $a_task['id_task_group']]);
		
		// 子项目的时间变化及比例变化
		$a_project = $this->db->get_row('project', ['id_project' => $a_task['id_project']]);
		$a_set = [];
		$a_set['task_time_start'] = $a_project['task_time_start'] + $f_hour;
		$a_set['task_time_finsh_not'] = $a_project['task_time_finsh_not'] - $f_hour;
		$a_set['task_ratio_start'] = round($a_set['task_time_start'] / $a_project['task_time_total'] * 100, 2);
		$a_set['task_ratio_finsh_not'] = round($a_set['task_time_finsh_not'] / $a_project['task_time_total'] * 100, 2);
		$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
		$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
		$this->db->update('project', $a_set, ['id_project' => $a_task['id_project']]);
		
		// 父项目的时间变化及比例变化
		$a_project = $this->db->get_row('project', ['id_project' => $a_task['id_project_parent']]);
		$a_set = [];
		$a_set['task_time_start'] = $a_project['task_time_start'] + $f_hour;
		$a_set['task_time_finsh_not'] = $a_project['task_time_finsh_not'] - $f_hour;
		$a_set['task_ratio_start'] = round($a_set['task_time_start'] / $a_project['task_time_total'] * 100, 2);
		$a_set['task_ratio_finsh_not'] = round($a_set['task_time_finsh_not'] / $a_project['task_time_total'] * 100, 2);
		$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
		$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
		$this->db->update('project', $a_set, ['id_project' => $a_task['id_project_parent']]);
	}
	
	// 任务的未完成时间增加
	private function _time_add($i_task, $f_hour) {
		// 任务的时间变化
		$a_task = $this->db->get_row('task', ['id_task' => $i_task]);
		$a_set = [];
		if ($this->db->get_total('procedure', ['id_task' => $i_task]) == 1) {
			// 减去任务创建时初始化的10小时
			$a_set['hour_plan'] = $f_hour;
			$f_hour = ($f_hour - $a_task['hour_plan']);
		} else {
			$a_set['hour_plan'] = $a_task['hour_plan'] + $f_hour;
		}
		$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
		$this->db->update('task', $a_set, ['id_task' => $i_task]);
		
		// 任务组的时间变化及比例变化
		$this->_group_add($i_task, $a_task['id_task_group'], $f_hour, 0);
		//$a_set = [];
		//$a_group = $this->db->get_row('task_group', ['id_task_group' => $a_task['id_task_group']]);
		//$a_set['task_time_total'] = $a_group['task_time_total'] + $f_hour;
		//$a_set['task_time_finsh_not'] = $a_group['task_time_finsh_not'] + $f_hour;
		//$a_set['task_ratio_start'] = round($a_group['task_time_start'] / $a_set['task_time_total'] * 100, 2);
		//$a_set['task_ratio_finsh_not'] = round($a_set['task_time_finsh_not'] / $a_set['task_time_total'] * 100, 2);
		//$a_set['task_ratio_finsh'] = 100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'];
		//$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
		//$this->db->update('task_group', $a_set, ['id_task_group' => $a_task['id_task_group']]);
		
		// 子项目的时间变化及比例变化
		$this->_project_add($a_task['id_project'], $f_hour, 0);
		
		// 父项目的时间变化及比例变化
		$this->_project_add($a_task['id_project_parent'], $f_hour, 0);
	}
	
	// 任务组的增加任务
	private function _group_add($i_task, $i_task_group, $f_hour, $i_task_number = 1) {
		$a_group = $this->db->get_row('task_group', ['id_task_group' => $i_task_group]);
		$a_set = [];
		$a_set['task_time_total'] = $a_group['task_time_total'] + $f_hour;
		$a_set['task_time_finsh_not'] = $a_group['task_time_finsh_not'] + $f_hour;
		$a_set['task_total'] = $a_group['task_total'] + $i_task_number;
		$a_set['task_finsh_not'] = $a_group['task_finsh_not'] + $i_task_number;
		
		$a_set['task_ratio_start'] = round($a_group['task_time_start'] / $a_set['task_time_total'] * 100, 2);
		$a_set['task_ratio_finsh_not'] = round($a_set['task_time_finsh_not'] / $a_set['task_time_total'] * 100, 2);
		$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
		$a_set['time_update'] = $_SERVER['REQUEST_TIME'];
		
		$this->db->update('task_group', $a_set, ['id_task_group' => $i_task_group]);
	}
	
	// 项目的任务增加
	private function _project_add($i_project, $f_hour, $i_task_number = 1) {
		$a_project = $this->db->get_row('project', ['id_project' => $i_project]);
		$a_set = [];
		$a_set['task_total'] = $a_project['task_total'] + $i_task_number;
		$a_set['task_finsh_not'] = $a_project['task_finsh_not'] + $i_task_number;
		$a_set['task_time_total'] = $a_project['task_time_total'] + $f_hour;
		$a_set['task_time_finsh_not'] = $a_project['task_time_finsh_not'] + $f_hour;
		$a_set['task_ratio_start'] = round($a_project['task_time_start'] / $a_set['task_time_total'] * 100, 2);
		$a_set['task_ratio_finsh_not'] = round($a_set['task_time_finsh_not'] / $a_set['task_time_total'] * 100, 2);
		$a_set['task_ratio_finsh'] = round(100 - $a_set['task_ratio_finsh_not'] - $a_set['task_ratio_start'], 2);
		
		$this->db->update('project', $a_set, ['id_project' => $i_project]);
	}
	*/
}
?>