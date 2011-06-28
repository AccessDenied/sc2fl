$(function() {
	// if the function argument is given to overlay,
	// it is assumed to be the onBeforeLoad event listener
	$("a[rel='#overlay_fantasy-create']").overlay({
		mask: 'darkred',
		effect: 'apple',
		onBeforeLoad: function() {
			// grab wrapper element inside content
			var wrap = this.getOverlay().find(".contentWrap");
			
			// load the page specified in the trigger
			wrap.load(this.getTrigger().attr("href"));
		}
	});
	$(".anchor_fantasy-join").click(function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: $(this).attr("href"),
			success: function(data, textStatus){
				if (data) {
					$("#errors").html(data);
				} else {
					window.location = '';
				}
			},
			error: function(a,b,c) {alert(a.responseText+" "+b+" "+c);}
		});
	});
	$(".anchor_fantasy-leave").click(function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: $(this).attr("href"),
			success: function(data, textStatus){
				if (data) {
					$("#errors").html(data);
				} else {
					window.location = '';
				}
			},
			error: function(a,b,c) {alert(a.responseText+" "+b+" "+c);}
		});
	});
	$(".anchor_fantasy-delete").click(function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: $(this).attr("href"),
			success: function(data, textStatus){
				if (data) {
					$("#errors").html(data);
				} else {
					window.location = '';
				}
			},
			error: function(a,b,c) {alert(a.responseText+" "+b+" "+c);}
		});
	});
});