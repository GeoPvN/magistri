<head>
<style type="text/css">
 
</style>
<script type="text/javascript">
    var aJaxURL           = "server-side/report/all_call.action.php";
    var tName             = "table_";
    var dialog            = "add-edit-form";
    var colum_number      = 12;
    var main_act          = "get_list";
    var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";
     
    $(document).ready(function () {
    	GetButtons("add_button","delete_button");
    	GetDate('start_date');
    	GetDate('end_date');
    	LoadTable('index',colum_number,main_act,change_colum_main);
    	$('#operator_id,#tab_id').chosen({ search_contains: true });
    	$('.callapp_filter_body').css('display','none');
    	$.session.clear();
    });

    function LoadTable(tbl,col_num,act,change_colum){
    	GetDataTable(tName+tbl,
    	    	aJaxURL,
    	    	act,
    	    	col_num,
    	    	"start_date="+$('#start_date').val()+
    	    	"&end_date="+$('#end_date').val()+
    	    	"&operator_id="+$('#operator_id').val()+
    	    	"&filter_1="+$('#filter_1:checked').val()+
    	    	"&filter_2="+$('#filter_2:checked').val()+
    	    	"&filter_3="+$('#filter_3:checked').val()+
    	    	"&filter_4="+$('#filter_4:checked').val()+
    	    	"&filter_5="+$('#filter_5:checked').val()+
    	    	"&filter_6="+$('#filter_6:checked').val()+
    	    	"&filter_7="+$('#filter_7:checked').val(),
    	    	0,
    	    	"",
    	    	2,
    	    	"desc",
    	    	'',
    	    	change_colum);
    	setTimeout(function(){
	    	$('.ColVis, .dataTable_buttons').css('display','none');
	    	}, 90);
    }

    function LoadTable1(tbl,col_num,act,change_colum,custom_param,URL){
    	GetDataTable(tName+tbl, URL, act, col_num, custom_param, 0, "", 2, "desc", '', change_colum);
    	setTimeout(function(){
	    	$('.ColVis, .dataTable_buttons').css('display','none');
	    	}, 50);
    	$('.display').css('width','100%');
    }
    
    function LoadDialog(fName){

    }

    $(document).on("click", ".callapp_refresh", function () {
    	LoadTable('index',colum_number,main_act,change_colum_main);
    });

    $(document).on("change", "#operator_id", function () {
        if($(this).val() != 0){
            $.session.set("operator_id", "on");
        }else{
            $.session.remove('operator_id');
        }
    	my_filter();
    });
    $(document).on("change", "#tab_id", function () {
    	if($(this).val() != 0){
    	    $.session.set("tab_id", "on");
    	}else{
            $.session.remove('tab_id');
        }
    	my_filter();
    });
    $(document).on("click", "close", function () {
        var id = $(this).attr('cl');
        $.session.remove($(this).attr('cl'));
        $( "#"+id ).click();
        my_filter();
    });
    $(document).on("click", "#filter_1", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_1", "on");
    	    LoadTable('index',colum_number,main_act,change_colum_main);
    	}else{
    		$.session.remove('filter_1');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_2", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_2", "on");
    	}else{
    		$.session.remove('filter_2');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_3", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_3", "on");
    	}else{
    		$.session.remove('filter_3');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_4", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_4", "on");
    	}else{
    		$.session.remove('filter_4');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_5", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_5", "on");
    	}else{
    		$.session.remove('filter_5');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_6", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_6", "on");
    	}else{
    		$.session.remove('filter_6');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_7", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_7", "on");
    	}else{
    		$.session.remove('filter_7');
    	}
    	my_filter();
    });


    $(document).on("change", "#end_date", function () {
    	LoadTable('index',colum_number,main_act,change_colum_main);
    });

    $(document).on("change", "#start_date", function () {
    	LoadTable('index',colum_number,main_act,change_colum_main);
    });

    function my_filter(){
    	var myhtml = '';
    	if($.session.get("operator_id")=='on'){
    		myhtml += '<span>ექსთენშენი<close cl="operator_id">X</close></span>';
    	}else{
    		$('#operator_id option:eq(0)').prop('selected', true);
    	}
    	if($.session.get("tab_id")=='on'){
    		myhtml += '<span>ტაბი<close cl="tab_id">X</close></span>';
    	}else{
    		$('#tab_id option:eq(0)').prop('selected', true);
    	}
    	if($.session.get("filter_1")=='on'){
    		myhtml += '<span>შე. ნაპასუხები<close cl="filter_1">X</close></span>';
    	}
    	if($.session.get("filter_2")=='on'){
    		myhtml += '<span>შე. დაუმუშავებელი<close cl="filter_2">X</close></span>';
    	}
    	if($.session.get("filter_3")=='on'){
    		myhtml += '<span>შე. უპასუხო<close cl="filter_3">X</close></span>';
    	}
    	if($.session.get("filter_4")=='on'){
    		myhtml += '<span>გა. ნაპასუხები<close cl="filter_4">X</close></span>';
    	}
    	if($.session.get("filter_5")=='on'){
    		myhtml += '<span>გა. უპასუხო<close cl="filter_5">X</close></span>';
    	}
    	if($.session.get("filter_6")=='on'){
    		myhtml += '<span>ში. ნაპასუხები<close cl="filter_6">X</close></span>';
    	}
    	if($.session.get("filter_7")=='on'){
    		myhtml += '<span>ში. უპასუხო<close cl="filter_7">X</close></span>';
    	}
    	
    	$('.callapp_tabs').html(myhtml);
    	LoadTable('index',colum_number,main_act,change_colum_main);
    	$('#operator_id, #tab_id').trigger("chosen:updated");
    }

    function show_main(id,my_this){
    	$("#client_main,#client_other").hide();
    	$("#" + id).show();
    	$(".client_main,.client_other").css('border','none');
    	$(".client_main,.client_other").css('padding','6px');
    	$(my_this).css('border','1px solid #ccc');
    	$(my_this).css('border-bottom','1px solid #F1F1F1');
    	$(my_this).css('padding','5px');
    }

    $(document).on("click", "#show_copy_prit_exel", function () {
        if($(this).attr('myvar') == 0){
            $('.ColVis,.dataTable_buttons').css('display','block');
            $(this).css('background','#2681DC');
            $(this).children('img').attr('src','media/images/icons/select_w.png');
            $(this).attr('myvar','1');
        }else{
        	$('.ColVis,.dataTable_buttons').css('display','none');
        	$(this).css('background','#E6F2F8');
            $(this).children('img').attr('src','media/images/icons/select.png');
            $(this).attr('myvar','0');
        }
    });    
     
    $(document).on("click", "#callapp_show_filter_button", function () {
        if($('.callapp_filter_body').attr('myvar') == 0){
        	$('.callapp_filter_body').css('display','block');
        	$('.callapp_filter_body').attr('myvar',1);
        }else{
        	$('.callapp_filter_body').css('display','none');
        	$('.callapp_filter_body').attr('myvar',0);
        }        
    });

    function listen(file){
        var url = location.origin + "/records/" + file;
        $("audio source").attr('src',url);
        $("audio").load();
    }

// 	function play(str){
// 		var win = window.open('http://'+location.hostname+':8000/'+str, '_blank');
// 		if(win){
// 		    //Browser has allowed it to be opened
// 		    win.focus();
// 		}else{
// 		    //Broswer has blocked it
// 		    alert('Please allow popups for this site');
// 		}
// 	}

</script>
<style type="text/css">
.callapp_tabs{
	margin-top: 5px;
	margin-bottom: 5px;
	float: right;
	width: 100%;
	height: 43px;
}
.callapp_tabs span{
	color: #FFF;
    border-radius: 5px;
    padding: 5px;
	float: left;
	margin: 0 3px 0 3px;
	background: #2681DC;
	font-weight: bold;
	font-size: 11px;
    margin-bottom: 2px;
}

.callapp_tabs span close{
	cursor: pointer;
	margin-left: 5px;
}

.callapp_head{
	font-family: pvn;
	font-weight: bold;
	font-size: 20px;
	color: #2681DC;
}
.callapp_head_hr{
	border: 1px solid #2681DC;
}
.callapp_refresh{
    padding: 5px;
    border-radius:3px;
    color:#FFF;
    background: #9AAF24;
    float: right;
    font-size: 13px;
    cursor: pointer;
}
.callapp_filter_show{
	margin-bottom: 50px;
	float: right;
	width: 100%;
}
.callapp_filter_show button{
    margin-bottom: 10px;
	border: none;
    background-color: white;
	color: #2681DC;
	font-weight: bold;
	cursor: pointer;
}
.callapp_filter_body{
	width: 100%;
	height: 83px;
	padding: 5px;
	margin-bottom: 0px;
}
.callapp_filter_body span {
	float: left;
    margin-right: 10px;
	height: 22px;
}
.callapp_filter_body span label {
	color: #555;
    font-weight: bold;
	margin-left: 20px;
}
.callapp_filter_body_span_input {
	position: relative;
	top: -17px;
}
.callapp_filter_header{
	color: #2681DC;
	font-family: pvn;
	font-weight: bold;
}

.ColVis, .dataTable_buttons{
	z-index: 50;
}
#flesh_panel{
    height: 630px;
    width: 150px;
    position: absolute;
    top: 0;
    padding: 15px;
    right: 2px;
	z-index: 49;
	background: #FFF;
}
#table_sms_length{
	position: inherit;
    width: 0px;
	float: left;
}
#table_sms_length label select{
	width: 60px;
    font-size: 10px;
    padding: 0;
    height: 18px;
}
#table_sms_paginate{
	margin: 0;
}
#table_mail_length{
	position: inherit;
    width: 0px;
	float: left;
}
#table_mail_length label select{
	width: 60px;
    font-size: 10px;
    padding: 0;
    height: 18px;
}
#table_mail_paginate{
	margin: 0;
}
</style>
</head>

<body>
<div id="tabs">
<div class="callapp_head">ზარები/ საუბრის ჩანაწერები<span class="callapp_refresh"><img alt="refresh" src="media/images/icons/refresh.png" height="14" width="14">   განახლება</span><hr class="callapp_head_hr"></div>
<div class="callapp_tabs">

</div>
<div class="callapp_filter_show">
<button id="callapp_show_filter_button">ფილტრი v</button>
    <div class="callapp_filter_body" myvar="0">
    <div style="float: left; width: 292px;">
        <span>
        <label for="start_date" style="margin-left: 110px;">-დან</label>
        <input class="callapp_filter_body_span_input" type="text" id="start_date" style="width: 100px;">
        </span>
        <span>
        <label for="end_date" style="margin-left: 110px;">-მდე</label>
        <input class="callapp_filter_body_span_input" type="text" id="end_date" style="width: 100px;">
        </span>
        <span style="margin-top: 15px;">
        <select id="operator_id" style="width: 285px;">
        <option value="0">ყველა ექსთენშენი</option>
        <?php
        include '../../includes/classes/core.php';
        
        $res = mysql_query("SELECT  `ext`
                            FROM    `extension`
                            WHERE   `actived` = 1");
        $data = '';
        while ($req = mysql_fetch_array($res)){
            $data .= '<option value="'.$req[0].'" >'.$req[0].'</option>';
        }
        echo $data;
        ?>
        </select>
        </span>

    </div>
    <div style="float: left; width: 170px; margin-left: 20px;">
        <span >
        <div class="callapp_filter_header"><img alt="inc" src="media/images/icons/inc_call.png" height="14" width="14">  შემომავალი ზარი</div>
        </span>

        <span style="margin-left: 15px">
        <label for="filter_1" style="">ნაპასუხები</label>
        <input class="callapp_filter_body_span_input" id="filter_1" type="checkbox" value="1">
        </span>
        <span style="margin-left: 15px">
        <label for="filter_3">უპასუხო</label>
        <input class="callapp_filter_body_span_input" id="filter_3" type="checkbox" value="3">
        </span>        
        </div>
    <div style="float: left; width: 170px;">
        <span >
        <div class="callapp_filter_header"><img alt="out" src="media/images/icons/out_call.png" height="14" width="14">  გამავალი ზარი</div>
        </span>
        <span style="margin-left: 15px">
        <label for="filter_4">ნაპასუხები</label>
        <input class="callapp_filter_body_span_input" id="filter_4" type="checkbox" value="4">
        </span>
        <span style="margin-left: 15px">
        <label for="filter_5">უპასუხო</label>
        <input class="callapp_filter_body_span_input" id="filter_5" type="checkbox" value="5">
        </span>
        
        
        </div>
    <div style="float: left; width: 145px;">
        <span>
        <div class="callapp_filter_header"><img alt="inner" src="media/images/icons/inner_call_1.png" height="14" width="14">  შიდა ზარი</div>
        </span>
        <span style="margin-left: 15px">        
        <label for="filter_6">ნაპასუხები</label>
        <input class="callapp_filter_body_span_input" id="filter_6" type="checkbox" value="6">
        </span>
        <span style="margin-left: 15px">
        <label for="filter_7">უპასუხო</label>
        <input class="callapp_filter_body_span_input" id="filter_7" type="checkbox" value="7">
        </span>
        
    </div>
</div>
<table id="table_right_menu">
<tr>
<td><img alt="table" src="media/images/icons/table_w.png" height="14" width="14">
</td>
<td><img alt="log" src="media/images/icons/log.png" height="14" width="14">
</td>
<td id="show_copy_prit_exel" myvar="0"><img alt="link" src="media/images/icons/select.png" height="14" width="14">
</td>
</tr>
</table>

<table class="display" id="table_index" style="width: 100%;">
    <thead>
        <tr id="datatable_header">
            <th>ID</th>
            <th style="width: 46px;">№</th>
            <th style="width: 150px;">თარიღი</th>
            <th style="width: 120px;">ადრესატი</th>
            <th style="width: 120px;">წყარო</th>
            <th style="width: 25%;">ექსთენშენი</th>
            <th style="width: 25%;">საუბრის ხან.</th>
            <th style="width: 25%;">ზარის სტატუსი</th>
            <th style="width: 25%;">მოსმენა</th>
        </tr>
    </thead>
    <thead>
       <tr class="search_header">
            <th class="colum_hidden">
        	   <input type="text" name="search_id" value="ფილტრი" class="search_init" />
            </th>
            <th>
            	<input type="text" name="search_number" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
            </th>    
            <th>
                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_category" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_category" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_category" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_phone" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_category" value="ფილტრი" class="search_init" />
            </th>            
        </tr>
    </thead>
</table>
</div>

<!-- jQuery Dialog -->
<div  id="add-edit-form" class="form-dialog" title="ყველა ზარი">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-sms" class="form-dialog" title="ახალი SMS">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-mail" class="form-dialog" title="ახალი E-mail">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-mail-shablon" class="form-dialog" title="E-mail შაბლონი">
</div>

</body>