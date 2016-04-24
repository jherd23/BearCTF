var set_cookie = function(name,value,days){
	var newDate = new Date();
	if(days === null){
		days = 1;
	}
	newDate.setTime(newDate.getTime + days*24*60*60*1000);
	document.cookie = name + "=" + value + "; expires=" + newDate.toGMTString();
	return true;
}

var get_cookie = function(name){
	var temp = document.cookie;
	var sp = temp.split(';');
	if(name === null || name === '' || name === ';' || name === '='){
		return null;
	}
	for(var i = 0; i < sp.length; i++){
		if(sp[i].indexOf(name) > -1){
			var sp2 = sp[i].split('=');
			return sp2[1];
		}
	}
	return null;
}

var delete_cookie = function(name){
	var date = new Date();
  date.setTime(date.getTime()+(-1*24*60*60*1000));
  var expires = "; expires="+date.toGMTString();
	document.cookie = name + '=' + expires;
	return true;
}

var redirect_to = function(newPage){
	setTimeout(function(){window.location = newPage},100);
}

var logout = function(redirect){
	var req = new XMLHttpRequest();
	var fd = new FormData();
	fd.append('redirect',redirect === null ? 'none' : redirect);
	req.onreadystatechange = function(){
		if(req.readyState === 4 && req.status === 200){
			var an = JSON.parse(req.responseText);
			if(an.redirect !== 'none'){
				redirect_to(an.redirect);
			}
		}
	}
	req.open('POST','/bearctf/api/logout.php');
	req.send(fd);
}

var inittasks = new Array();

inittasks.push(function(){ //Add "Login" and "Register" buttons if the user is not logged in. Add "Account" and "Logout" buttons if they are.
	if(get_cookie("username") === null){
		document.getElementById('loginer').innerHTML = "<h2 id=\"LOGIN_BUTTON\"><a href=\"../login/\">Login</a></h2><h2 id=\"REGISTER_BUTTON\"><a href=\"../register/\">Register</a></h2>";
	}else{
		document.getElementById('loginer').innerHTML = "<h2 id=\"ACCOUNT_BUTTON\"><a href=\"../account/\">Account</a></h2><h2 id=\"LOGOUT_BUTTON\"><a href=\"#\" onclick='logout(\"..\")'>Logout</a></h2>";
	}
});

inittasks.push(function(){ //Adds footer to pages
	var bod = document.getElementsByTagName('body')[0];
	var footer = document.createElement('div');
	footer.id = "footer";
	footer.class = "footer";
	var footerText = document.createElement('p');
	footerText.innerHTML = "Created By Jack Herd, &copy; 2015-16";
	footer.appendChild(footerText);
	bod.appendChild(footer);
});

window.onload = function(){
	for(var i = 0; i < inittasks.length; i++){
		inittasks[i]();
	}
}
