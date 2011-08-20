function checkCheck(wrapPostIt){

	if($("#grid:checked").length==1){
		wrapPostIt.addClass("gridded");
	}else{
		wrapPostIt.removeClass("gridded");
	}

}

$(function(){

var wrapPostIt = $(".containerPostIt");
var largeurPostIt = wrapPostIt.attr("data-largeur");

	$( "#slider" ).slider({
		value: 50,
		min: 5,
		max: 50,
		slide: function(event,ui){
			wrapPostIt.css({"width":largeurPostIt*ui.value+"px"});
			$(".postit").css({"width":ui.value+"px","height":ui.value+"px"});
		}
	});

	$("#urlImg").click(function(e){
		e.preventDefault();
		$(this).select();
	})
	
	checkCheck(wrapPostIt);
	$("#grid").change(function(){
		checkCheck(wrapPostIt);
	});
	
})