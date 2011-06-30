$(function(){
	$("#player-list_"+$("select[name=select_team]").val()).show();
	$("select[name=select_team]").change(function(e) {
		$(".player-list").hide();
		$("#player-list_"+$(this).val()).show();
	});
	$(".player.ACTIVE").click(function(){
		if (getPropertyCount(draft.players) < 8) {
			var elementId = $(this).attr("id");
			var id = elementId.substr(elementId.lastIndexOf("_") + 1);
			var name = $(this).text();
			draft.players[id] = name;
			draft.refresh();
		} else {
			alert("Only 8 Players Allowed");
		}
	});
	$.ajax({
		type: "POST",
		url: "index.php?fantasyleagues/team/draft/players/"+$("#input_fantasy-id").val(),
		dataType: "json",
		success: function(data, textStatus){
			for(var playerId in data) {
				draft.players[playerId] = data[playerId];
				draft.refresh();
			}
		},
		error: function(a,b,c) {alert(a.responseText+" "+b+" "+c);}
	});
	$("#form_fantasy-manage").submit(function(e) {
		e.preventDefault();
		var data = {
			'player_count':getPropertyCount(draft.players),
			'fantasy_id':$("input[name='fantasy_id']").val()
		};
		var count = 0;
		for(var playerId in draft.players) {
			data[count]=playerId;
			count++;
		}
		$.ajax({
			type: "POST",
			url: "index.php?fantasyleagues/team/draft/manage",
			data: data,
			dataType:'json',
			success: function(data, textStatus){
				if (data.error) {
					$("#errors").html(data.error);
				} else {
					window.location = 'index.php?teamleagues/fantasy/'+data.fantasy_id;
				}
			},
			error: function(a,b,c) {alert(a.responseText+" "+b+" "+c);}
		});
	});
});

var draft = {
	players:{}
};
draft.refresh = function() {
	$(".player-drafts").empty();
	for (var key in draft.players) {
		$("#player_"+key).removeClass("ACTIVE").addClass("UNACTIVE");
		var div = document.createElement("div");
		div.className = "player-draft";
		div.appendChild(document.createTextNode(draft.players[key]));
		$(".player-drafts").append(div);
	}
}

function getPropertyCount(obj) {
    var count = 0,
        key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) {
            count++;
        }
    }
    return count;
}
