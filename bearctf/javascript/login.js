var login = function(redirect){
	if(redirect == null){
		redirect = "none";
	}
	var username = document.getElementById('username_l').value;
	var password = document.getElementById('password_l').value;
	var req = new XMLHttpRequest();
	var fd = new FormData();
	fd.append('username',username);
	fd.append('password',password);
	fd.append("redirect",redirect);
	req.onreadystatechange = function(){
		if(req.readyState === 4 && req.status === 200){
			console.log(req.responseText);
			var ans = JSON.parse(req.responseText);
			if(ans.success === 'yes' && ans.redirect !== 'none'){
				if(ans.redirect){
					redirect_to(ans['redirect']);
				}
			}else{
				post_message(ans.reason);
			}
		}
	}
	req.open('POST','/bearctf/api/login.php');
	req.send(fd);
}

var post_message = function(message){
	var message_holder = document.getElementById('login_response');
	message_holder.style.display = 'block';
	message_holder.innerHTML = message;
}
