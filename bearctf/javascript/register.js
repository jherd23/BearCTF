var register_user = function(redirect){
	if(redirect == null){
		redirect = "none";
	}
	var name = document.getElementById('username_r').value;
	var pass = document.getElementById('password_r').value;
	var req = new XMLHttpRequest();
	var fd = new FormData();
	fd.append('username',name);
	fd.append('password',pass);
	fd.append("redirect",redirect);
	req.onreadystatechange = function(){
		if(req.readyState === 4 && req.status === 200){
			var t = JSON.parse(req.responseText);
			if(t.success === "yes"){
				if(t.redirect){
					redirect_to(t.redirect);
				}
			}else{
				var o = document.getElementById('register_response');
				o.innerHTML = t.reason;
				o.style.display = "block";
			}
		}
	}
	req.open('POST','/bearctf/api/register.php');
	req.send(fd);
}
