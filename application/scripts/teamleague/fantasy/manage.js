var userId;
$(function(){
	userId = $("input[name='user_id']").val();
	$("#player-list_"+$("select[name=select_team]").val()).show();
	$("select[name=select_team]").change(function(e) {
		$(".player-list").hide();
		$("#player-list_"+$(this).val()).show();
	});
	$(".player.ACTIVE").click(function(){
		if (getUserDraftCount(draft.players) < 8) {
			var elementId = $(this).attr("id");
			var id = elementId.substr(elementId.lastIndexOf("_") + 1);
			var name = $(this).text();
			if (!draft.players[id]) draft.players[id] = {};
			draft.players[id]['name'] = name;
			draft.players[id]['ownerId'] = userId;
			draft.refresh();
		} else {
			alert("Only 8 Players Allowed");
		}
	});
	$.ajax({
		type: "POST",
		url: "index.php?teamleague/fantasy/playerdraft/"+$("input[name='fantasy_id']").val(),
		dataType: "json",
		success: function(data, textStatus){
			draft.players = data['players'];
			draft.users = data['users'];
			draft.refresh();
		},
		error: function(a,b,c) {alert(a.responseText+" "+b+" "+c);}
	});
	$("#form_fantasy-manage").submit(function(e) {
		e.preventDefault();
		var data = {};
		var count = 0;
		$(".player-draft").each(function(e){
			var playerDraftId = $(this).attr("id");
			var id = playerDraftId.substr(playerDraftId.lastIndexOf("_")+1);
			data[count]=id;
			count++;
		});
		data['fantasy_id'] = $("input[name='fantasy_id']").val();
		data['count'] = count;
		data['teamId'] = $("input[name='radio_team']:checked").val();
		$.ajax({
			type: "POST",
			url: "index.php?teamleague/fantasy/updatedraft",
			data:data,
			success: function(data, textStatus){
				location.href = 'index.php?teamleague/fantasy/'+$("input[name='fantasy_id']").val();
			},
			error: function(a,b,c) {alert(a.responseText+" "+b+" "+c);}
		});
	});
	$(".player-draft").live("click", function(e){
		var elementId = $(this).attr("id");
		var id = elementId.substr(elementId.lastIndexOf("_") + 1);
		delete(draft.players[id]);
		$("#player_"+id).removeClass("UNACTIVE").addClass("ACTIVE");
		$("#player_"+id).find(".owned-by").empty();
		draft.refresh();
	});
});

var draft = {};
draft.refresh = function() {
	$(".player-drafts").empty();
	for (var key in draft.players) {
		$("#player_"+key).removeClass("ACTIVE").addClass("UNACTIVE");
		if (draft.players[key]['ownerId'] == userId) {
			var div = document.createElement("div");
			div.className = "player-draft";
			div.setAttribute("id","player-draft_"+key);
			div.appendChild(document.createTextNode(draft.players[key]['name']));
			$(".player-drafts").append(div);
		}
		if (draft.users[draft.players[key]['ownerId']])
			$("#player_"+key).find(".owned-by").html(document.createTextNode("owned by:"+draft.users[draft.players[key]['ownerId']]));
	}
}

function getUserDraftCount(obj) {
    var count = 0, key;
    for (key in obj) {
    	if (obj[key]['ownerId']==userId) {
	        if (obj.hasOwnProperty(key)) {
	            count++;
	        }
    	}
    }

    return count;
}
