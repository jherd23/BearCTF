var submit_problem = function(problemName){
	var answer = document.getElementById(problemName).value;
	var req = new XMLHttpRequest();
	var fd = new FormData();
	fd.append("problem",problemName);
	fd.append("answer",answer);
	req.onreadystatechange = function(){
		if(req.readyState === 4 && req.status === 200){
			var respJSON = JSON.parse(req.responseText);
			if(respJSON.success === 'yes'){
				document.getElementById(problemName + '_response').innerHTML = respJSON.response;
			}else{
				document.getElementById(problemName + '_response').innerHTML = respJSON.reason;
			}
		}
	}
	req.open('POST','/bearctf/api/handlesubmit.php');
	req.send(fd);
}

var toggle_hint = function(problemName){
	var temp = document.getElementById(problemName + '_hint');
	temp.style.display = temp.style.display === 'block' ? 'none' : 'block';
}

var toggle_problem = function(problemName){
	var temp = document.getElementById(problemName + '_body');
	temp.style.display = temp.style.display === 'none' ? 'block' : 'none';
}

var get_problems = function(){
	var req = new XMLHttpRequest();
	req.onreadystatechange = function(){
		if(req.readyState === 4 && req.status === 200){
			interpret_problems(JSON.parse(req.responseText));
		}
	}
	req.open('POST','/bearctf/api/getproblems.php');
	req.send();
}

var interpret_problems = function(problemObject){
	var main = document.getElementById('main');
	var add = '';
	if(problemObject.success === "yes"){
		for(i in problemObject['probs']){
			add += "<div id=\"" + problemObject.probs[i].sysname + "_container\" class=\"container prob" + (add === "" ? " top\">" : "\">");
				add += "<div id=\"" + problemObject.probs[i].sysname + "_header\" class=\"header\" onclick=\"toggle_problem(\'" + problemObject.probs[i].sysname + "\')\">";
					add += "<h3>&gt;" + problemObject.probs[i].name + " -- " + problemObject.probs[i].pointValue + " Points" + (problemObject.probs[i].completed === 'tru' ? " - Completed" : "") + "</h3>";
				add += "</div>";
				add += "<div id=\"" + problemObject.probs[i].sysname + "_body\" class=\"bod\"";
				if(problemObject.probs[i].completed === 'tru'){
					add += "style=\"display:none\"";
				}
				add += ">";
					add += "<p>" + problemObject.probs[i].body + '</p>';
					add += "<form onsubmit=\"submit_problem(\'" + problemObject.probs[i].sysname + "\');return false\" autocomplete=\"off\">";
						add += "<button type=\"button\" onclick=\"toggle_hint(\'" + problemObject.probs[i].sysname + "\')\">Show Hint</button>";
						add += "<input type=\"text\" id=\"" + problemObject.probs[i].sysname + "\">";
						add += "<input type=\"submit\" value=\"Submit\">";
					add += "</form>";
					add += "<p id=\"" + problemObject.probs[i].sysname + "_hint\" class=\"hint\">" + problemObject.probs[i].hint + "</p>";
					add += "<p id=\"" + problemObject.probs[i].sysname + "_response\"></p>";
				add += "</div>";
			add += "</div>";
		}
	}else{
		add = "<div id=\"error_container\" class=\"container top\">";
			add += "<div id=\"error_header\" class=\"header\">";
				add += "<h3>&gt;Error</h3>";
			add += "</div>";
			add += "<div id=\"error_body\" class=\"bod\">";
				add += "<p id=\"error_response\">" + problemObject.reason + "</p>";
			add += "</div>";
		add += "</div>";
	}
	main.innerHTML += add;
}

inittasks.push(function(){
	get_problems();
});
