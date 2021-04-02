<?php 
$pageTitle = "AJAX Beer Search";
include('inc/header.php');
?>
<style>
body{
	background-color: #F7F3D9;
}

header{
	background-color: #FFCC00;
	border-bottom: 1px solid #CC6600;
}

nav ul li:hover ul{
	border-left: 1px solid #FFCC00;
	border-right: 1px solid #FFCC00;
	border-bottom: 1px solid #FFCC00;
}


</style>		
		<div id="container" style="border-radius: 0.5em; width: 670px; margin-bottom: 10px" >
		
			
				
				<h1 style="font-size: x-large; margin-bottom: -5px">Brewgle</h1><hr style="margin: 5px 0px 10px 0px;">
				<h2 id="resultCountId" style="display: inline-block;"></h2>
				<label style="font-weight: normal; display: inline-block;">Sorted By:</label>
				<select id="sortCombo" style="display: inline-block;">
					<option value="name">Beer Name</option>
					<option value="abv">ABV (Descending)</option>
					<option value="ibu">IBU (Descending)</option>
				</select>
				<input id="textSearch" class="textSearch" type="text" autocomplete="off" placeholder="Search by beer name, brewer, or style">			
				<div class="beerListClass" id="beerListId">
				</div>
				
				<div style="text-align: center; vertical-align: top; float: ; display: inline-block; width: 300px">
				<img style="text-align: center; vertical-align: top; border-radius: 0.5em; width: 300px" src="beer_img/uc.jpg" />
				<h1 style="white-space: nowrap; text-align: center; margin-top: 75px; ">Welcome to Brewgle.</h1>
				<h1 style="white-space: nowrap;text-align: center;">May all your wildest dreams come true.</h1>
				</div>
				

			
				
				<h1 style="font-size: x-large; margin-bottom: -5px">Selected Beer(s)</h1><hr style="margin: 5px 0px 0px 0px;">
				<h2 id="selectCountId">0 Beer(s) Selected</h2>
				<div id="beerInfo">
				</div>
	
			

		</div>
		
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="js/jquery-1.6.1.min.js"></script>
<script src="js/beerTest.js"></script>
<?php include('inc/footer.php');?>