function calcAll(){
	var nbrColor = ($(".wPostit").length);
	var color = new Array(nbrColor);
	var total = 0;
	for(i=0; i<nbrColor; i++){
		color[i] = $(".core .postit.c"+i).length;
		$(".colLeft .line").eq(i).find(".number").text(color[i]+"");
		total += color[i];
	}
	$("b.priceTotal").text(total);
	//console.log(total*0.015);
}

function canEdit(){

	var sizeCase = $(".dr").width();

	$(".dr").draggable({
		revert:"invalid",
		revertDuration: 10
	});

	$(".white").droppable({
		accept:'.dr',
		over:function(event,ui){$(this).addClass("hover");},
		out:function(event,ui){$(this).removeClass("hover");},
		drop:function(event,ui){
			var sizePI = $(".containerPostIt").attr("sizePI");
			var pi = ui.draggable;
			pi.removeClass("ui-draggable-dragging");
			pi.removeClass("ui-draggable");
			if(pi.hasClass("creatorz")){
				pi.removeClass("creatorz");
				pi.css({"top":"0","left":"0"});
				var aleaShadow = Math.round(Math.random()*5);
				var aleaRotation = Math.round(Math.random()*3);
				var ClassThisPostit = pi.attr("class")+" sh"+aleaShadow+" rot"+aleaRotation;
				pi.addClass("creatorz");
				$(this).attr("class",ClassThisPostit);
			}else{
				var ClassThisPostit = pi.attr("class");
				pi.attr("class","postit white ui-droppable").removeAttr("style").css({"width":sizePI,"height":sizePI,"position":"relative"});
				$(this).attr("class",ClassThisPostit);
			}
			$(".dr").droppable("disable").draggable("enable");
			$(".white").droppable("enable").draggable("disable");
			canEdit();
			calcAll();
		}
	})
	
	$(".trash").droppable({
		accept:'.dr',
		drop:function(event,ui){
			var sizePI = $(".containerPostIt").attr("sizePI");
			var pi = ui.draggable;
			pi.removeClass("ui-draggable-dragging");
			pi.removeClass("ui-draggable");			
			if(pi.hasClass("creatorz")){
				pi.css({"top":"0","left":"0"});
			}else{
				pi.attr("class","postit white ui-droppable").removeAttr("style").css({"width":sizePI,"height":sizePI,"position":"relative"});
			}						
			$(".dr").droppable("disable");
			$(".white").droppable("enable");
			canEdit();
			calcAll();
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
var wrapPi = $(".core");
var largeurPostIt = wrapPostIt.attr("data-largeur");

	$("#slider1").slider({
		value: 48,
		min: 5,
		max: 48,
		slide: function(event,ui){
			var w = largeurPostIt*(ui.value+2)+1+"px";/* Le +2 pour les bordures du postit et le +1 pour la border du conteneur */
			wrapPostIt.attr("sizePI",ui.value);
			//console.log(ui.value);
			wrapPostIt.css({"width":w});
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

	$(".print").click(function(e){
		e.preventDefault();
		window.print();
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