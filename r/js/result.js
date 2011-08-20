function canEdit(){

	var sizeCase = $(".dr").width();
	$(".dr").draggable({
		revert:"invalid",
		revertDuration: 0
	});

	$(".white").droppable({
		accept:'.dr',
		over:function(event,ui){$(this).addClass("hover");},
		out:function(event,ui){$(this).removeClass("hover");},
		drop:function(event,ui){
			var sizePI = $(".containerPostIt").attr("sizePI");
			ui.draggable.removeClass("ui-draggable-dragging");
			ui.draggable.removeClass("ui-draggable");
			var ClassThisPostit = ui.draggable.attr("class");
			$(this).attr("class",ClassThisPostit);
			ui.draggable.attr("class","postit white").removeAttr("style").css({"width":sizePI,"height":sizePI});
			canEdit();
		}
	})
}

function checkCheck(wrapPostIt){

	if($("#grid:checked").length==1){
		wrapPostIt.addClass("gridded");
	}else{
		wrapPostIt.removeClass("gridded");
	}
	
	if($("#edit:checked").length==1){
		wrapPostIt.addClass("editable");
		canEdit();
	}else{
		wrapPostIt.removeClass("editable");
	}

}


$(function(){

var wrapPostIt = $(".containerPostIt");
var largeurPostIt = wrapPostIt.attr("data-largeur");

	$("#slider1").slider({
		value: 48,
		min: 5,
		max: 48,
		slide: function(event,ui){
			wrapPostIt.attr("sizePI",ui.value);
			wrapPostIt.css({"width":largeurPostIt*(ui.value+2)+"px"});
			$(".postit").css({"width":ui.value+"px","height":ui.value+"px"});
		}
	});

	$("#slider2").slider({
		value: 0,
		min: 0,
		max: 100,
		slide: function(event,ui){
			var percent = ui.value/100;
			$("#original").css({"opacity":percent});
		}
	});

	$("#urlImg").click(function(e){
		e.preventDefault();
		$(this).select();
	})
	
	checkCheck(wrapPostIt);
	
	/* Pour afficher la grille */
	$("#grid").change(function(){
		checkCheck(wrapPostIt);
	});
	
	/* Pour pouvoir éditer les post-it */
	$("#edit").change(function(){
		checkCheck(wrapPostIt);
	});
	
})