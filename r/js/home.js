function initDrag(){
	$('.dr').unbind("dblclick");
	$('.dr').bind("dblclick",function(){
		elt = $(this).attr("data-color");
		dispatchAll(elt);
	})
	
	$('.dr').draggable({
		revert: true
	});
	
	$('.colRight .list').droppable({
		accept: ".dr",
		activeClass: "hoverDrop",
		hoverClass: "hoverDrop",
		drop: function(event,ui){
			var elt = ui.draggable.attr("data-color");
			dispatchAll(elt);
		}
	});
}

function initDragBack(){
	$('.dr2').draggable({
		revert: true
	});
	
	$('.dr2').unbind("dblclick");
	$('.dr2').bind("dblclick",function(){
		VisseElt = $(this).attr("data-valuecolor");
		reDispatchAll(VisseElt);
	})
	
	$('.colLeft .list').droppable({
		accept: ".dr2",
		activeClass: "hoverDrop",
		hoverClass: "hoverDrop",
		drop: function(event, ui){
			var VisseElt = ui.draggable.attr("data-valuecolor");
			reDispatchAll(VisseElt);
		}
	});
	
}

function reDispatchAll(VisseElt){
	var daddy = $(".colRight div[data-valuecolor="+VisseElt+"]");
	clone = daddy.clone().css({"left":"auto","top":"auto","z-index":"0"}).removeClass("dr2").addClass("dr");
	clone.insertBefore(".colLeft .ui-droppable .addNew");
	daddy.remove();
	
	if($(".colRight .ui-droppable").children().length>1){
		$(".colRight .ui-droppable .default").hide();
	}else{
		$(".colRight .ui-droppable .default").show();
	}
	
	if($(".colRight div.dr2").length < 10){
		$(".warning").hide();
	}else{
		$(".warning").show();
	}
	
	if($(".colRight .ui-droppable").children().not("default").length==1){
		$(".choose .nextStep").addClass("inactive");
	}
	
	initDrag();
}

function initForm2(){
	$(".fileInput").change(function(e){
		$(".pushFile .nextStep").removeClass("inactive");
	})
}

function dispatchAll(elt){
	if(elt=="rainbow"){
		var daddy = $("#colorpicker div[data-color="+elt+"]");
		var valueRGB = reaplace(daddy.css("background-color"));
		if($(".colRight div[data-valuecolor="+valueRGB+"]").length == 0){
			if($(".colRight div.dr2").length < 10){
				clone = daddy.clone().css({"left":"auto","top":"auto","z-index":"0"}).removeClass("colorwell").removeClass("dr").addClass("dr2 post").removeAttr("id").attr("data-valuecolor",reaplace(daddy.css("background-color")));
				clone.appendTo(".colRight .ui-droppable");
				$(".warning").hide();
			}else{
				$(".warning").show();
			}
		}
	}else{
		var daddy = $("div[data-color="+elt+"]");
		var valueRGB = reaplace(daddy.attr("data-valuecolor"));
		if($(".colRight div[data-valuecolor="+valueRGB+"]").length == 0){
			if($(".colRight div.dr2").length < 10){
				clone = daddy.clone().css({"left":"auto","top":"auto","z-index":"0"}).removeClass("dr").addClass("dr2");
				clone.appendTo(".colRight .ui-droppable");
				daddy.remove();
				$(".warning").hide();
			}else{
				$(".warning").show();
			}
		}
	}
	
	if($(".colRight .ui-droppable").children().not("default").length>1){
		$(".colRight .ui-droppable .default").hide();
		$(".choose .nextStep").removeClass("inactive");
	}else{
		$(".colRight .ui-droppable .default").show();
	}
	
	initDragBack();
}


function cutHex(h){return (h.charAt(0)=="#") ? h.substring(1,7):h}
function hexToR(h){return parseInt((cutHex(h)).substring(0,2),16)}
function hexToG(h){return parseInt((cutHex(h)).substring(2,4),16)}
function hexToB(h){return parseInt((cutHex(h)).substring(4,6),16)}

function reaplace(chaine){
	if(chaine.length > 7){
		chaine = chaine.substring(4);
		var tmp;
		tmp = "";
		for(var i = 0; i < chaine.length; i++){
			tmp = tmp + chaine.charAt(i);
			if(chaine.charAt(i) == ","){
				tmp = tmp.replace(",","-");
			}
			if(chaine.charAt(i) == " "){
				tmp = tmp.replace(" ","");
			}
			if(chaine.charAt(i) == ")"){
				tmp = tmp.replace(")","");
			}
		}
		chaine = tmp.substring(-1);
	}else{
		var neo = hexToR(chaine)+"-"+hexToG(chaine)+"-"+hexToB(chaine);
		chaine = neo;
	}
	
	return chaine
}

$(document).ready(function(){

	$(".post").each(function(){
		$(this).attr("data-valueColor",reaplace($(this).css("background-color")));
	})

	$(".hwjs").hide();

	$(".addNew").click(function(e){
		e.preventDefault();
		$("#colorpicker").show();
	})

	/* Initialisation du drag'n'Drop dans un sens */
	initDrag();
	
	//$(".colRight .nextStep.inactive").click(function(e){e.preventDefault();})
	
	$(".colRight .nextStep").click(function(e){
		if($(this).hasClass("inactive")){
			e.preventDefault();
		}else{
			$(".choose").slideUp("slow",function(){
				var WrapPostIt = $("#YourChoice");
				var jsonValueColor = '{"colors":[';
				var CloneChoice = $(".choose .colRight .ui-droppable div:not('.default')").clone();
				var i = 0;
				WrapPostIt.html("");
				WrapPostIt.append(CloneChoice);
				var Postit = WrapPostIt.find("div");
				var nbrPostit = Postit.length;
				Postit.each(function(){
					i = i+1;
					jsonValueColor = jsonValueColor+'"'+$(this).attr("data-valuecolor")+'"';
					if(i!=nbrPostit){
						jsonValueColor = jsonValueColor+',';
					}
				})
				jsonValueColor = jsonValueColor+']}';
				$(".jsonValueColorPostIt").val(jsonValueColor);
				$(".file").slideDown();
				
				initForm2();
			})
		}
	})
	
	$(".prevStep").click(function(e){
		e.preventDefault();
		$(".file").slideUp("slow",function(){
			$(".choose").slideDown();
		})
	})
	
	var f = $.farbtastic('#picker');
	
    $('.colorwell')
		.each(function(){
			f.linkTo(this);
		})
		.focus(function(){
			f.linkTo(this);
		})
	;
	
});