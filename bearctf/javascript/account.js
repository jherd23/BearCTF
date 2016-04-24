var get_user_public_information = function(){
	var req = new XMLHttpRequest();
	req.onreadystatechange = function(){
		if(req.readyState === 4 && req.status === 200){
			interpret_user_information(JSON.parse(req.responseText));
		}
	}
	req.open('POST','/bearctf/api/getuserinfo.php');
	req.send();
}

var interpret_user_information = function(userInfo){
	var a = '';
	if(userInfo.success === 'yes'){
		for(i in userInfo.attrs){
			a += "<p><b> &gt;" + userInfo.attrs[i].name + ":</b> " + userInfo.attrs[i].info + "</p>";
		}
	}else{
		a += "<p>User information could not be retrieved due to the following error(s):</p><p>" + userInfo.reason + "</p>";
	}
	document.getElementById('account_information').innerHTML = a;
	var teamForm = '<form id="team_form" onsubmit="';
	if(userInfo.attrs['1'].name === "Team"){
		teamForm += 'leave_team();return false"><p>Enter your password in order to leave team ' + userInfo.attrs['1'].info + ':</p><input type="password" id="confirmpassword"><input type="submit" value="Leave Team"></form>';
	}else{
		teamForm += 'create_new_team();return false"><p>Enter the name of a team you would like to create:</p><input type="text" id="createTeamName"><input type="submit" value="Create Team"></form>';
		teamForm += '<p><b>OR</b></p>'
		teamForm += '<form id="team_form_2" onsubmit="add_user_to_team();return false"><p>Enter the name of the team you would like to join:</p><input type="text" id="joinTeamName"><input type="submit" value="Join Team"></form>';
	}
	document.getElementById('team_form_target').innerHTML = teamForm;
}

var create_new_team = function(){
	var newTeamName = document.getElementById('createTeamName').value;
	var req = new XMLHttpRequest();
	req.onreadystatechange = function(){
		if(req.readyState === 4 && req.status === 200){
			var resp = JSON.parse(req.responseText);
			document.getElementById('account_information').innerHTML += resp.success === 'yes' ? '<p>' + resp.response + '</p>' : '<p>' + resp.reason + '</p>';
		}
	}
	var fd = new FormData();
	fd.append('teamname',newTeamName);
	req.open('POST','../api/register_team.php');
	req.send(fd);
}

var add_user_to_team = function(){
	var teamtoaddto = document.getElementById('joinTeamName').value;
	var req = new XMLHttpRequest();
	req.onreadystatechange = function(){
		if(req.readyState === 4 && req.status === 200){
			var resp = JSON.parse(req.responseText);
			document.getElementById('account_information').innerHTML += resp.success === 'yes' ? '<p>' + resp.response  + '</p>' : '<p>' + resp.reason + '</p>';
		}
	}
	var fd = new FormData();
	fd.append('team',teamtoaddto);
	req.open('POST','../api/add_to_team.php');
	req.send(fd);
}

var leave_team = function(){
	var password = document.getElementById('confirmpassword').value;
	var req = new XMLHttpRequest();
	req.onreadystatechange = function(){
		if(req.readyState === 4 && req.status === 200){
			var resp = JSON.parse(req.responseText);
			document.getElementById('team_response').innerHTML = resp.success === 'yes' ? '<p>' + resp.response + '</p>' : '<p>' + resp.reason + '</p>';
		}
	}
	var fd = new FormData();
	fd.append("password",password);
	req.open('POST','../api/leaveteam.php');
	req.send(fd);
}

inittasks.push(function(){
	get_user_public_information();
});
