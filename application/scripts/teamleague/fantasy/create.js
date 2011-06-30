$(function(){
	$("#form_fantasy-create").submit(function(e){
		e.preventDefault();
		var form = $(this)[0];
		$.ajax({
			type: "POST",
			url: "index.php?teamleague/fantasy/create",
			data: {
				'name':form.name.value, 
				'desc':form.desc.value, 
				'userLimit':form.userLimit.value,
				'leagueId':form.leagueId.value},
			dataType:'json',
			success: function(data, textStatus){
				if (data.error) {
					$("#errors").html(data.error);
				} else {
					window.location = 'index.php?teamleague/fantasy/'+data.fantasy_id;
				}
			},
			error: function(a,b,c) {alert(a.responseText+" "+b+" "+c);}
		});
	});
});