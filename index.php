                                                                <!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Brewgle is the Google for beer."/>
	<meta name="author" content="Billy Cougan">
	<title>Brewgle | Billy Cougan</title>
	<link rel="icon" type="image/png" href="../favicon.ico">
	
	<link rel="stylesheet" type="text/css" href="../css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
   	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/bootstrap-theme.min.css" rel="stylesheet">
	
	
</head>

<body>
	<header>
	    <!-- Fixed navbar -->
	    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="http://billycougan.com/">BillyCougan.com</a>
	        </div>
	      </div>
	    </div>
	</header>

	<div id="content">		
		<div id="container" style="border-radius: 0.5em; width: 670px; margin-bottom: 10px" >
		
			
				
				<h1 style="; margin-bottom: -5px">Brewgle</h1><hr style="margin: 5px 0px 10px 0px;">
				<label id="resultCountId" style="display: inline-block;"></label>
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
					<h1 style="white-space: nowrap; text-align: center; margin-top: 75px;font-size: x-large">Welcome to Brewgle.</h1>
					<!--<h1 style="white-space: nowrap;text-align: center;font-size: x-large">May all your wildest dreams come true.</h1>-->
				</div>
				

			
				
				<h1 style="font-size: x-large; margin-bottom: -5px">Selected Beer(s)</h1><hr style="margin: 5px 0px 0px 0px;">
				<label id="selectCountId">0 Beer(s) Selected</label>
				<div id="beerInfo">
				</div>
		</div>
		
<?php include('inc/footer.php');?>
                            
                            