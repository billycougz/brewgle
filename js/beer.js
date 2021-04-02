                                //Global variables
var beerArray = [];
var searchArray = [];









//On page load
$(document).ready(function () {
	var url="data/beers.json";
	var beerCount = 0;
	var src = "";
	var beerList = '<select class="beerList" name="beerList" size="15" multiple="multiple">';
	
	$.getJSON(url, function (response) {
		$.each(response, function (index, beer) {
			src = "beer_img/" + beer.beerName + ".png";
			if(beer.beerName == "#9"){src = "beer_img/9.png";}
			
			beerArray.push(beer);
			beerArray[beerCount]['img'] = new Image();
			beerArray[beerCount]['img'].src = src;
			
			beerCount += 1;
		});

		beerArray.sort(compare);
		
		$(beerArray).each(function(index, beer){beerList += '<option>' + beer.beerName + '</option>';});
		beerList += '</select>';
		$('#beerListId').html(beerList);
		
		beerCount = beerCount + " Beers";
		$('#resultCountId').html(beerCount);

		searchArray = beerArray;
		
	}); //end getJSON
}); //end ready









//When text is entered into searchbox
$(document).ready(function () {

	var textSearch = "";
	var beerCount = 0;
	var beerList = '<select class="beerList" name="beerList" size="15" multiple="multiple">';
	
	$("body").on("keyup", "#textSearch", function(){
	
		beerList = '<select class="beerList" name="beerList" size="15" multiple="multiple">';
		beerCount = 0;
		textSearch = $( "#textSearch" ).val();
		searchArray = [];
	
		//Sort
		beerArray.sort(compare);
		$(beerArray).each(function(index, beer){if(beer.ibu < 10){beer.ibu.replace(/^0+/, '');};});
	
		//Filter
		$(beerArray).each(function(index, beer){
			if(beer.beerName.toLowerCase().indexOf(textSearch.toLowerCase()) >= 0 || 
				beer.brewer.toLowerCase().indexOf(textSearch.toLowerCase()) >= 0 || 
				beer.style.toLowerCase().indexOf(textSearch.toLowerCase()) >= 0 || 
				textSearch == ""){
					beerList+= '<option>' + beer.beerName + '</option>';
					searchArray.push(beer);
					beerCount += 1;
		}});
		
		beerCount = beerCount + " Beers";
		$('#resultCountId').html(beerCount);
		
		beerList += '</select>';
		$('#beerListId').html(beerList);
		
	}).trigger( "keyup" );
}); //end ready









//When the sort combo is changed
$(document).ready(function () {
	$("body").on("change", "#sortCombo", function(){
	
		var beerList = '<select class="beerList" name="beerList" size="15" multiple="multiple">';
		var beerCount = 0;

		searchArray.sort(compare);
		
		$(searchArray).each(function(index, beer){
			if(beer.ibu < 10){
				beer.ibu.replace(/^0+/, '');
			};
			
			beerList += '<option>' + beer.beerName + '</option>';
			beerCount += 1;
		});

		beerList += '</select>';
		beerCount = beerCount + " Beers";
		$('#resultCountId').html(beerCount);
		$('#beerListId').html(beerList);

	}).trigger( "change" );
}); //end ready









//When a beer (or multiple beers) is selected from the list
$(document).ready(function () {
	$("body").on("change", "select", function(){
	
		var beerObject = "";
		var listSelection = "";
		var selectCount = 0;
		
		$( "select option:selected" ).each(function() {
		
			listSelection = $( this ).text();
			var iterationCount = -1;
			
			$(beerArray).each(function(index, beer){
				iterationCount += 1; 
				if( listSelection == beer.beerName){
					selectCount += 1;
					beerObject += '<div class="beerObject">' +
					'<div id="beerImg"><img style="" src="' + beerArray[iterationCount]['img'].src + ' " alt=""></div>' +
					'<div id="beerProperties"><input class="beerName" type="text" value="' + beer.beerName + '" readonly>' +
					'<input style="" type="text" name="name" value="' + beer.brewer + '" readonly>' +
					'<input style="" type="text" name="name" value="' + beer.style + '" readonly>' +
					'<input class="beerNum" style="" type="text" name="name" value="' + beer.abv + '% ABV" readonly>' +
					'<input class="beerNum" style="float: right;" type="text" name="name" value="' + beer.ibu + ' IBU" readonly>' +
					'</div></div>';
		}});});
		
		selectCount = '<label>' + selectCount + ' Beer(s) Selected</label>';
		$( "#selectCountId" ).html(selectCount);
		
		$( "#beerInfo" ).html( beerObject );
	}).trigger( "change" );
}); //end ready








//Function called for sorting
function compare(a,b) {

	var tempA = 0;
	var tempB = 0;
	
	//Function restores original values for those altered
	function tempRestore(){
		if(tempA != 0){
			a.ibu = tempA;
		}
		if(tempB != 0){
			b.ibu = tempB;
		}
	}//end tempRestore function
	

	if($("#sortCombo").val() == 'name'){
		if (a.beerName< b.beerName)
			return -1;
		if (a.beerName> b.beerName)
			return 1;
	}
	
	if($("#sortCombo").val() == 'abv'){
		if (a.abv < b.abv)
			return 1;
		if (a.abv > b.abv)
			return -1;
	}
	
	if($("#sortCombo").val() == 'ibu'){

		//----------------------------------------------------Deals with   1.(sorting numbers 100 < x < 10)   and   2.(N/A values)
		if(a.ibu > 99 ){tempA = a.ibu; a.ibu = 9 + a.ibu;}
		if(b.ibu > 99 ){tempB = b.ibu; b.ibu = 9 + b.ibu;}
		
		if(a.ibu < 10 || a.ibu == 'N/A'){
			tempA = a.ibu;
			a.ibu = 0 + a.ibu;
			
			if(a.ibu == '0N/A'){a.ibu = 0 + a.ibu;}
		}
		
		if(b.ibu < 10 || b.ibu == 'N/A'){
			tempB = b.ibu;
			b.ibu = 0 + b.ibu;
			
			if(b.ibu == '0N/A'){b.ibu = 0 + b.ibu;}
		}
		
		//------------------------------------------------------------------------------------------------------------
		
		if (a.ibu < b.ibu){
			tempRestore();
			return 1;
		}
		
		if (a.ibu > b.ibu){
			tempRestore();
			return -1;
		}
	}

	tempRestore();
	return 0;
}
                            