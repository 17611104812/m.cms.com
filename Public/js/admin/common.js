$('#button-add').click(function(){
        window.location.href=SCOPE.add_url;
    })

//获取form表单内容
$('#singcms-button-submit').click(function(){
	//console.log(111);return
	var data = $('#singcms-form').serializeArray();
	postData = {};
	$(data).each(function(){
		postData[this.name] = this.value;
	})
	$.post(SCOPE.save_url,postData,function(d){
		if (d.status == 'success') {
			dialog.success(d.msg,SCOPE.jump_url);
		}else{
			dialog.error(d.msg);
		}
	},'json')
})
/*编辑*/
$('.glyphicon-edit').click(function(){
	var menu_id = $(this).attr('attr-id');
	window.location.href = SCOPE.edit_url + '/id/' +menu_id;
})

/*删除*/

$('#singcms-delete').click(function(){
	var menu_id = $(this).attr('attr-id');
	var url = SCOPE.set_status_url;
	var message = $(this).attr('attr-message');
	var status = -1;
	layer.open({
		type:0,
		title:'是否提交？',
		btn:['YES','NO'],
		icon:3,
		closeBtn:2,
		content:'是否确定'+message,
		scrollBar:true,
		yes:function(){
			setMenustatus(url,menu_id,status);
		}
	})
})

function setMenustatus(url,menu_id,status){
	$.post(url,{'menu_id':menu_id,'status':status},function(d){
		if (d.status=='success') {
			dialog.success(d.msg,SCOPE.jump_url);
		}else{
			dialog.error(d.msg);
		}
	})
}

/*更新排序*/
$('#button-listOrder').click(function(){
	var data = $('#singcms-listorder').serializeArray();
	postData = {};
	$(data).each(function(){
		postData[this.name] = this.value;
	})
	$.post(SCOPE.listorder_url,postData,function(d){
		if (d.status == 'success') {
			dialog.success(d.msg,d.data.jump_url);
		}else{
			dialog.error(d.msg);
		}
	},'json')

})

/*推送推荐位*/
$('#singcms-push').click(function(){
	var positionId = $('#select-push').val();
	if (!positionId || positionId == 0) {
		return dialog.error('请选择推荐位！');
	}

	push = {};
	postData = {};
	$("input[name='pushcheck']:checked").each(function(i){
		push[i]= $(this).val();
	})
	if (!push || push == {}) {
		return dialog.error('请选择要推荐的文章！');
	}
	postData['push'] = push;
	postData['positionId'] = positionId;
	url = SCOPE.push_url;

	$.post(url,postData,function(d){
		if (d.status=='success') {
			dialog.success(d.msg,d.data.jump_url);
		}else{
			dialog.error(d.msg);
		}
	},'json')
	
})



