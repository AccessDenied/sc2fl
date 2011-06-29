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
		url: "index.php?servlets/fantasy/playerdraft/"+$("#input_fantasy-id").val(),
		dataType: "json",
		success: function(data, textStatus){
			for(var playerId in data) {
				draft.players[playerId] = data[playerId];
				draft.refresh();
			}
		},
		error: function(a,b,c) {alert(a.responseText+" "+b+" "+c);}
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
