var login = {

	check : function(){
		var username = $('input[name="username"]').val();
		var password = $('input[name="password"]').val();
		if (!username || !password) {
			dialog.error('用户名或密码不能为空！');
			return;
		}
		var data = {'username':username,'password':password};
		$.post('/admin/login/check',data,function(res){
			if (res.status=='error') {
				return dialog.error(res.msg);
			}else if(res.status=='success'){
				return dialog.success(res.msg,'/admin/index/index');
			}
		},'json')
	}
}