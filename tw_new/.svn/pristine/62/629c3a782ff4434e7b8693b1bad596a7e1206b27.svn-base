<?php $this->display('inc_head_include', $a_view_data);?>
<ul id="tree1"></ul>
<script src="static/pc_default/script/jquery-2.1.4.min.js"></script>
<!--[if IE]>
<script src="static/pc_default/script/jquery-1.11.3.min.js"></script>
<![endif]-->
<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='static/pc_default/script/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="static/pc_default/script/bootstrap.min.js"></script>
<script src="static/pc_default/script/tree.min.js"></script>
<script src="static/pc_default/script/ace-elements.min.js"></script>
<script src="static/pc_default/script/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
	var sampleData = initiateDemoData();//see below
	$('#tree1').ace_tree({
		dataSource: sampleData['dataSource1'],
		multiSelect: true,
		cacheItems: true,
		'open-icon' : 'ace-icon tree-minus',
		'close-icon' : 'ace-icon tree-plus',
		'itemSelect' : true,
		'folderSelect': false,
		'selected-icon' : 'ace-icon fa fa-check',
		'unselected-icon' : 'ace-icon fa fa-times',
		loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'
	});
	
	$('#tree2').ace_tree({
		dataSource: sampleData['dataSource2'] ,
		loadingHTML:'<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
		'open-icon' : 'ace-icon fa fa-folder-open',
		'close-icon' : 'ace-icon fa fa-folder',
		'itemSelect' : true,
		'folderSelect': true,
		'multiSelect': true,
		'selected-icon' : null,
		'unselected-icon' : null,
		'folder-open-icon' : 'ace-icon tree-plus',
		'folder-close-icon' : 'ace-icon tree-minus'
	});
	
	
	/**
	//Use something like this to reload data	
	$('#tree1').find("li:not([data-template])").remove();
	$('#tree1').tree('render');
	*/
	
	
	/**
	//please refer to docs for more info
	$('#tree1')
	.on('loaded.fu.tree', function(e) {
	})
	.on('updated.fu.tree', function(e, result) {
	})
	.on('selected.fu.tree', function(e) {
	})
	.on('deselected.fu.tree', function(e) {
	})
	.on('opened.fu.tree', function(e) {
	})
	.on('closed.fu.tree', function(e) {
	});
	*/
	
	
	function initiateDemoData(){
		<?php
		//$this->load->model('user_model');
		$s_data = 'var tree_data = {';
		$a_data = [];
		$i = 0;
		foreach ($a_view_data['user'] as $u_key => $a_val) {
			$s_data .= "'{$u_key}' : {text: '" . $this->user_model->get_department_name($u_key) . "', type: 'folder'},";
			$a_data[$i] = "tree_data['{$u_key}']['additionalParameters'] = {" . PHP_EOL . "	'children' : {" . PHP_EOL;
			foreach ($a_val as $u_k => $a_v) {
				$a_data[$i] .= "		'appliances' : {text: '{$a_v['name_user']}', type: 'item'}," . PHP_EOL;
			}
			$a_data[$i] = rtrim($a_data[$i], ',' . PHP_EOL) . '}}' . PHP_EOL;
			$i++;
		}
		echo $s_data = rtrim($s_data, ',') . '}' . PHP_EOL;
		foreach ($a_data as $s_d) {
			echo $s_d;
		}
		?>

		var dataSource1 = function(options, callback){
			var $data = null
			if(!("text" in options) && !("type" in options)){
				$data = tree_data;//the root tree
				callback({ data: $data });
				return;
			}
			else if("type" in options && options.type == "folder") {
				if("additionalParameters" in options && "children" in options.additionalParameters)
					$data = options.additionalParameters.children || {};
				else $data = {}//no data
			}
			
			if($data != null)//this setTimeout is only for mimicking some random delay
				setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);

			//we have used static data here
			//but you can retrieve your data dynamically from a server using ajax call
			//checkout examples/treeview.html and examples/treeview.js for more info
		}

		return {'dataSource1': dataSource1}
	}

});
</script>