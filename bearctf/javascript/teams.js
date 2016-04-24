var get_team_data = function(){
  var req = new XMLHttpRequest();
  req.onreadystatechange = function(){
    if(req.readyState === 4 && req.status === 200){
      create_leaderboard(JSON.parse(req.responseText));
    }
  }
  req.open('POST','../api/getallteaminfo.php');
  req.send();
}

var escape = function(teamName){
  var arr = teamName.split("");
  var ret = "";
  for(var i = 0; i < arr.length; i++){
    if("!\"#$%&'()*+,./:;<=>?@[\\]^`{|}~".indexOf(arr[i]) === -1){
      ret += arr[i];
    }
  }
  return ret;
}

var create_leaderboard = function(teamdata){
  if(teamdata.success === 'yes'){
    var teamArray = new Array();
    for(var key in teamdata.teams){
      teamdata.teams[key].fullName = key;
      teamdata.teams[key].teamName = escape(key);
      teamArray.push(teamdata.teams[key]);
    }
    teamArray.sort(function(a,b){
      return (parseInt(b.points) - parseInt(a.points));
    });
    var a = '';
    for(var i = 0; i < teamArray.length; i++){
      a += '<div id="' + teamArray[i].teamName + '_container" class="container' + (i === 0 ? ' top' : '') + '">';
        a += '<div id="' + teamArray[i].teamName + '_header" class="header" onclick="toggle_team(\'' + teamArray[i].teamName + '\')">';
          a += '<h3>&gt;' + (i + 1) + ' -- ' + teamArray[i].fullName + ' -- ' + teamArray[i].points + (teamArray[i].points == 1 ? ' point' : ' points') + '</h3>';
        a += '</div>';
        a += '<div id="' + teamArray[i].teamName + '_body" class="bod" style="display:none">';
          a += '<div id="' + teamArray[i].teamName + '_info">';
            a += '<p><b>';
              a += teamArray[i]['0'] ? (teamArray[i]['0']) : '';
              a += teamArray[i]['1'] ? (',' + teamArray[i]['1']) : '';
              a += teamArray[i]['2'] ? (',' + teamArray[i]['2']) : '';
              a += teamArray[i]['3'] ? (',' + teamArray[i]['3']) : '';
            a += '</b></p>';
          a += '</div>';
        a += '</div>';
      a += '</div>';
    }
    document.getElementById('main').innerHTML = a;
  }
}
var toggle_team = function(teamName){
	var temp = document.getElementById(teamName + '_body');
	temp.style.display = temp.style.display === 'none' ? 'block' : 'none';
}
inittasks.push(function(){
  get_team_data();
});
