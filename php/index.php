                                                                <?php 
$pageTitle = "Beer Search";
include('../../inc/header.php');

$numResults;
$beerArray = array();
$searchArray = array();
$brandCombo = $_POST['brandFilter'];

//When the "clear" button is clicked, the page refreshes
if(isset($_POST['clear'])){ 
	header( 'Location: http://www.billycougan.com/beer.php' );
}

//Creates file object "file" for beers.txt
//Foreach loop creates an array "beerArray" that contains an array for each individual beer
//Individual arrays contain brand,name,style,abv, and ibu
//I do not remember what I used the "i" counter for
$file = file("./beers.txt");
$i = 0;
	foreach($file as $line){
		list($brand,$name,$style,$abv,$ibu)=explode(",",$line);
		$beerArray[] = array($brand,$name,$style,$abv,$ibu);
		$i = $i + 1;
	}

	
//*************Defines what occurs when the "View Selected Beer's Information" button is clicked
//Loops through each beer in the beerArray and uses if statement to compare and find the beer selected beer from the list
//When it finds the selected beer, it assigns the selected beer's properties based on the properties' index in the individual array
//brandCombo variable holds the value for the selected brand in the combo box
if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['viewSelected']) ){

	for($x=0; $x < count($beerArray); $x++){

		if($_POST["beerList"] == $beerArray[$x][0] . $beerArray[$x][1]){
		
			$selectedBrand = $beerArray[$x][1];
			$selectedName = $beerArray[$x][0];
			$selectedStyle = $beerArray[$x][2];
			$selectedABV = $beerArray[$x][3] . "%";
			$selectedIBU = $beerArray[$x][4];
			
			$selectedIMG = "../beer_img/"  . $selectedName . ".png";
			
			$brandCombo = $_POST['brandFilter'];
			
		}
	}
}//******************************End View Selected



//**************************Defines what occurs when the "Add A Beer" button is clicked
//Write the delimited beer properties into a CSV file "beers'txt"

if(isset($_POST['addBeer'])){

	header( 'Location: http://www.billycougan.com/addbeer.php' );

}





if(isset($_POST['NOT IN USE'])){

	//Checks to see if the beer brand and name combination already exists
	//If so, variable "exists" is set to true
	for($x = 0; $x < count($beerArray); $x++){
		if($_POST['brand'].$_POST['name'] == $beerArray[$x][0] . $beerArray[$x][1]){
			$exists = true;
		}
	}

	//Beer is only added if it does not already exist
	if($exists != true){
	
		//Beer is only added if all fields are filled in
		if($_POST['brand'] != "" and $_POST['name'] != "" and $_POST['style'] != "" and $_POST['abv'] != "" and $_POST['ibu'] != ""){
			$thetext =  "\r\n" . $_POST['brand'] . "," . $_POST['name'] . "," . $_POST['style'] . "," . $_POST['abv'] . "," . $_POST['ibu'];
			$myFile = "beers.txt";
			//$thetext=$_POST['addBeer'];
			writemyfile($myFile,$thetext,"a");
		}
	}
}

//PHP function for writing to a file
function writemyfile($thefilename,$data,$mode){

	$myfile=fopen($thefilename,$mode);
	fwrite($myfile,$data);
	fclose($myfile);

}//******************************End Add Beer

//*********************************Defines what happens for sort
	function val_sort($array,$key) {
	
	//Loop through and get the values of our specified key
	foreach($array as $k=>$v) {
		$b[] = strtolower($v[$key]);
	}
	
	//print_r($b);
	
	asort($b);
	
	echo '<br />';
	//print_r($b);
	
	foreach($b as $k=>$v) {
		$c[] = $array[$k];
	}
	
	return $c;
	}

?>
<style>body{background-image: url('BeerWallpaper.jpg');}</style>
		<div id="container" style=" width: 600px; border: 1px #7C510D solid; border-radius: 1em" >
		
			

			<form name ="loadForm" style="display: inline-block; margin-left: 10px; padding: 0px" action="index.php" method="post">
	<h1>Beer Search</h1>
			<div id="filter" style="display: inline">
				<select name="brandFilter" style=" width: 275px" value="">
					<option value="Any Brand">Any Brand (Brewing Company)</option>
					<?php 
					if($beerArray[0][1] == $brandCombo){
						$selected = "selected";
					}else{
						$selected = "";
					}
					
					$beerArray = val_sort($beerArray, '0');
					for($x = 1; $x < count($beerArray); $x++){
						if($beerArray[$x][1] != $beerArray[$x - 1][1]){
							if($beerArray[$x][1] == $brandCombo){$selected = "selected";}else{$selected = "";}
								echo '<option value="'. $beerArray[$x][1] . '"' .  $selected. '>'. $beerArray[$x][1] . '</option>';

						}
					}
					?>
				</select>
	
				<?php //****Style combo box
				$postStyle = $_POST['styleFilter']; ?>
				<select name="styleFilter" style=" width: 275px">
					<option value="Any Style">Any Style</option>
					<option value="Ale" <?php if($postStyle == "Ale"){echo "selected";}?>>Ale</option>
					<option value="IPA" <?php if($postStyle == "IPA"){echo "selected";}?>>IPA</option>
					<option value="Lager" <?php if($postStyle == "Lager"){echo "selected";}?>>Lager</option>
					<option value="Belgian" <?php if($postStyle == "Belgian"){echo "selected";}?>>Belgian</option>
				</select>
			
				<br>
				
				<?php //*****TextSearch
				$postText= $_POST['textSearch']; ?>
				<input style="margin-left: ; width: 550px; display:inline-block" type="text" name="textSearch" <?php echo 'value="' . $postText . '"' ;?> placeholder="Search for a Specific Beer Name">
				
				<br>
			
				<?php //****ABV combo box
				$postabvFilter= $_POST['abvFilter']; ?>
				<select name="abvFilter" style=" width: 175px">
					<option value="anyABV">Any ABV</option>
					<option value="abvGreat" <?php if($postabvFilter== "abvGreat"){echo "selected";}?>>ABV Greater Than:</option>
					<option value="abvLess" <?php if($postabvFilter== "abvLess"){echo "selected";}?>>ABV Less Than:</option>
				</select>
			
				<?php //****ABV slider
				$postabvSlider= $_POST['abvSlider']; ?>
				<input name="abvSlider" style=" display: inline-block; width: 350px" type="range" min="0" max="10" 
				 value="<?php echo $postabvSlider; ?>" step=".1" onchange="showValue(this.value)"/>
				<span id="range"><?php if($_POST["abvFilter"] == "abvGreat" or $_POST["abvFilter"] == "abvLess"){ 
				 echo $postabvSlider ;}else{echo "Any";}?></span>
				<script type="text/javascript"> function showValue(newValue) {document.getElementById("range").innerHTML=newValue;} </script>
			
				<br>
			
				<?php //****IBU combo box
				$postibuFilter= $_POST['ibuFilter']; ?>
				<select name="ibuFilter" style=" width: 175px">
					<option value="anyIBU">Any IBU</option>
					<option value="ibuGreat" <?php if($postibuFilter== "ibuGreat"){echo "selected";}?>>IBU Greater Than:</option>
					<option value="ibuLess" <?php if($postibuFilter== "ibuLess"){echo "selected";}?>>IBU Less Than:</option>
				</select>
			
				<?php //****IBU slider
				 $postibuSlider= $_POST['ibuSlider']; ?>
				<input name="ibuSlider" style=" display: inline-block; width: 350px" type="range" min="0" max="100" 
				 value="<?php echo $postibuSlider; ?>" step="1" onchange="showValue2(this.value)"/>
				<span id="range2"><?php if($_POST["ibuFilter"] == "ibuGreat" or $_POST["ibuFilter"] == "ibuLess"){ 
				 echo $postibuSlider ;}else{echo "Any";}?></span>
				<script type="text/javascript">function showValue2(newValue2){document.getElementById("range2").innerHTML=newValue2;} </script>
			
				<br>
			
				<?php //Sort combo box   
				$postSort = $_POST['sortCombo']; ?>
				Sort By: <select name="sortCombo" style="width: 110px; margin-top: 8px;">
					<option value="brand" <?php if($postSort == 'brand'){echo "selected";}?>>Beer Name</option>
					<option value="abv" <?php if($postSort == 'abv'){echo "selected";}?>>ABV</option>
					<option value="ibu" <?php if($postSort == 'ibu'){echo "selected";}?>>IBU</option>
				</select>
				
			</div>
				
			<br>
			
			<div id="filterButtons" style="display: inline-block; ">
			
				<?php //Creates buttons ?>
				<input style="margin-bottom: ;width: 133px" type="submit" value="Load Beers" name="loadBeer">
				<input style="margin-bottom: ;width: 133px" type="submit" value="Clear Filter" name="">
			
				<!--<button style=" width: 100px" type="button" onclick="alert('Hello world!')">Search</button>-->
			
				<br>
				


				<?php //This creates the list of beers with the filtered search ?>
				
				<select style="height: 400px; width: 275px; margin-top: 10px;margin-bottom: 0px; display: inline-block;" name="beerList" size="6">

					<?php
					if(isset($_POST['loadBeer']) or (isset($_POST['viewSelected']) ) ){
					

						$brandCombo = $_POST['brandFilter'];
						
						$searchCount = 0;
						for($x=0; $x < count($beerArray); $x++){
						
							if($beerArray[$x][1] == $_POST["brandFilter"] or $_POST["brandFilter"] == "Any Brand"){
							
							 if(strpos($beerArray[$x][2],$_POST["styleFilter"]) !== false or $_POST["styleFilter"] == "Any Style"){
							 
							 if(strpos(strtolower($beerArray[$x][0]),strtolower($_POST["textSearch"])) !== false or $_POST["textSearch"] == ""){
								 
								 if(($_POST["abvFilter"] == "abvGreat" and $beerArray[$x][3] >= $_POST["abvSlider"])
								 
								 or	($_POST["abvFilter"] == "abvLess" and $beerArray[$x][3] <= $_POST["abvSlider"])
								 
								 or $_POST["abvFilter"] == "anyABV"){
							
							
							if($beerArray[$x][4] < 10){$beerArray[$x][4] = 0 . $beerArray[$x][4];}
							if($beerArray[$x][4] < 1){$beerArray[$x][4] = 0.0;}
									if(($_POST["ibuFilter"] == "ibuGreat" and $beerArray[$x][4] >= $_POST["ibuSlider"])
								 or	($_POST["ibuFilter"] == "ibuLess" and $beerArray[$x][4] <= $_POST["ibuSlider"])
								 
								 or $_POST["ibuFilter"] == "anyIBU"){
									
								$searchArray[] = $beerArray[$x];
								
								
								
								}//ibuSlider
								}//abvSlider
							      }//textSearch
							 }//style
							}//brand
						}//End for loop
						
						if($_POST['sortCombo'] == 'brand'){
							$sorted = val_sort($searchArray, '0'); 
						}
						
						if($_POST['sortCombo'] == 'abv'){
							$sorted = val_sort($searchArray, '3'); 
						}
						
						if($_POST['sortCombo'] == 'ibu'){
							$sorted = val_sort($searchArray, '4'); 
						}
						
						
						
								
								
						for($x=0; $x < count($sorted); $x++){	
							echo '<option value="'.$sorted[$searchCount][0].$sorted[$searchCount][1].'">'.
							$sorted[$searchCount][0].'</option>';
							$searchCount = $searchCount + 1;
						}
						
						
						
						
					}//End if statement for "load beers" button clicked
				echo '</select>';
					$numResults = count($sorted);
			echo '<br><h2 style="display: inline-block; margin-top: 15px;">Number of Results:&nbsp;</h2><input style="margin-bottom: ;width: 123px" type="text" value="' . $numResults . ' " name="results">'
					?>
				
			</div>



				<?php //Creates the text fields for when the individual beer is selected ?>
				<div style="display: inline-block; margin-left: 10px; height = 500px;">
				<img style=" margin-left: auto;margin-right: auto; display:block ;margin-top: -100px; margin-bottom: 2px; max-height: 150px" src="<?php echo $selectedIMG ?>" alt="">
					<input style="margin-left: 0px; width: 275px; display:inline-block" type="submit" name="viewSelected" value="View Selected Beer's Information">
					<br>
					<input style="margin-top: 10px; width: 275px; display:inline-block" type="submit" value="Add A Beer" name="addBeer">
				
					<h2>Beer Name:</h2> <input class="beerInfo" style="width: 275px;" type="text" name="brand" value="<?php echo $selectedName ?>" readonly><br>
					<h2>Brand (Brewing Company):</h2> <input class="beerInfo" style="width: 275px;" type="text" name="name" value="<?php echo $selectedBrand ?>" readonly><br>
					<h2>Style:</h2> <input class="beerInfo" style="width: 275px;" type="text" name="style" value="<?php echo $selectedStyle ?>" readonly><br>
					<h2>ABV:</h2> <input class="beerInfo"  style="width: 275px;" type="text" name="abv" value="<?php echo $selectedABV ?>" readonly><br>
					<h2>IBU:</h2> <input class="beerInfo" style="width: 275px;" type="text" name="ibu" value="<?php echo $selectedIBU ?>" readonly><br>
					<div style="margin-top: 17px">	&nbsp; </div>
				</div>
			
				
			</form>	
		</div>
		

<?php include('../../inc/footer.php');?>
                            
                            