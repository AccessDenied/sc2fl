$(function(){
	$("#form_fantasy-create").submit(function(e){
		e.preventDefault();
		var form = $(this)[0];
		$.ajax({
			type: "POST",
			url: "http://localhost:8080/sc2fl/index.php?teamleagues/create",
			data: {
				'name':form.name.value, 
				'desc':form.desc.value, 
				'userLimit':form.userLimit.value,
				'leagueId':form.leagueId.value},
			dataType:'text',
			success: function(data, textStatus){
				if (data) {
					$("#errors").html(data);
				} else {
					window.location = 'teamleagues/fantasy/'+form.leagueId.value;
				}
			},
			error: function(a,b,c) {alert(a.responseText+" "+b+" "+c);}
		});
	});
});