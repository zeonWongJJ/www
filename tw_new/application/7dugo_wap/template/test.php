<html>
<script src="script/jquery-1.js"></script>
<select>
<?php
foreach($a_view_data as $key=>$value){ ?>
	
<option value=<?php echo $value['area_id']?>><?php echo $value['area_name']?></option>
	<?php } ?>
</select>
<select>
</select>
<select>
</select>
<script>
$(function(){
	        $.ajaxSettings.async = false;
            $.getJSON("script/address_json_data.js", function(jsonString){
            json_address_data=jsonString;
            });

       $("select").change(function(){
       	$(this).nextAll().children("option").remove();
       	var address_id=$(this).attr("value");
       	var children_data=json_address_data[address_id];
       	var string;
       	 for(var item in children_data){ 
       	 	string+="<option value="+item+">"+children_data[item]+"</option>";
       	 }
       	 $(this).next().append(string);

       })

})
</script>
</html>