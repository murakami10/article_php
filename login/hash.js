		$("#name_fade").hide();
		$("#pass_fade").hide();
		$("#dele_fade").hide();
		$("#edit_fade").hide();
		$("#add_fade").hide();	
	if(location.hash == "#name"){
		$("#name_fade").fadeIn(200).delay(1000).fadeOut(100,function(){
			location.href = location.href.split("#")[0];
		});
	}else if(location.hash == "#pass"){
		$("#pass_fade").fadeIn(200).delay(1000).fadeOut(100,function(){
			location.href = location.href.split("#")[0];
		});
	}else if(location.hash == "#dele"){
		$("#dele_fade").fadeIn(200).delay(1000).fadeOut(100,function(){
			location.href = location.href.split("#")[0];
		});
	}else if(location.hash == "#edit"){
		$("#edit_fade").fadeIn(200).delay(1000).fadeOut(100,function(){
			location.href = location.href.split("#")[0];
		});
	}else if(location.hash == "#add"){
		$("#add_fade").fadeIn(200).delay(1000).fadeOut(100,function(){
			location.href = location.href.split("#")[0];
		});
	}else{
		$("#name_fade").hide();
		$("#pass_fade").hide();
		$("#dele_fade").hide();
		$("#edit_fade").hide();
		$("#add_fade").hide();
	}
