<?php

//Checks to see if submit button is pressed (if method = POST)
//If so, code runs to submit form and creates get variable for "thanks"
if($_SERVER["REQUEST_METHOD"] == "POST"){

	//"Trim" verifies that the value is not just a space
	$name = trim($_POST["name"]);
	$email = trim($_POST["email"]);
	$message = trim($_POST["message"]);
	
	$beerName = trim($_POST["beerName"]);
	$brand = trim($_POST["brand"]);
	$style = trim($_POST["style"]);
	$abv = trim($_POST["abv"]);
	$ibu = trim($_POST["ibu"]);
	$source= trim($_POST["source"]);

	//If any field is blank, an error is returned
	if($name == "" OR $beerName== "" OR $brand== "" OR $style == "" OR $abv == "" OR $ibu== "" OR $source== ""){
		echo 'You musy specify a value for anything that is not labeled "Optional".';
		exit;
	}
	
	//Checks each POST value for malicious values
	foreach( $_POST as $value){
		if( stripos($value, 'Content-Type:') !== FALSE){
			echo "There was a problem with the information you entered.";
			exit;
		}
	}
	
	//If the hidden "address" field is filled in, it is most likely a hacker and an error is returned
	if($_POST["address"] != "") {
		echo "Your form submission has an error.";
		exit;
	}
	
	//Includes the phpmailer file once
	require_once("inc/phpmailer/class.phpmailer.php");
	
	//Creates a new PHPMailer object
	//This can be found in the phpmailer examples folder, file test_mail_basic.php
	$mail = new PHPMailer(); // defaults to using php "mail()"
	
	//Uses ValidateAddress method
	if( !$mail->ValidateAddress($email)){
		echo 'You must specify a valid email address.' ;
		exit;
	}
	
	$email_body = "";
	$email_body = $email_body . "Name: " . $name . "<br>";
	$email_body = $email_body . "Email: " . $email . "<br>";
	$email_body = $email_body . "Message: " . $message. "<br><br><br>";
	$email_body = $email_body . "Source: " . $source . "<br>";
	$email_body = $email_body . $beerName . "," . $brand. "," . $style. "," . $abv. "," . $ibu;
	
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = "smtp.postmarkapp.com";
	$mail->Port = 2525;
	$mail->Username = "e2bd03ec-a7b6-46dd-b333-300cfd398ea9";
	$mail->Password = "e2bd03ec-a7b6-46dd-b333-300cfd398ea9";
	
	//Contents of test_mail_basic.php
	$mail->SetFrom("contact@billycougan.com", "Add Beer Form");
	$address = "wpcougan@syr.edu"; //"contact@billycougan.com"
	$mail->AddAddress($address, "Billy Cougan");
	$mail->Subject    = $beerName . " | " . $name;
	$mail->MsgHTML($email_body);
	//If email will have attachments
	//$mail->AddAttachment("images/phpmailer.gif");
	//$mail->AddAttachment("images/phpmailer_mini.gif");
	
	//Sends email
	if(!$mail->Send()) {
	  echo "There was a problem sending the email: " . $mail->ErrorInfo;
	  exit;
	}
	
	//Only runs if email was sent (becasue of the send mail if statement
	header("Location: addbeer.php?status=thanks");	//Sets the http header to add GET variable "thanks", redirects to thank you
	exit;	//Stops all php code from running
}

?>


<?php 
$pageTitle = "Add A Beer";
include('inc/header.php');?>

		<div id="container" class="contact">

			<h1>Add A Beer</h1>
			
			
	<!---------If status = thanks (form was submitted and GET variable "thanks" was added), output thank you message
	Otherwise (else) display form------------------>
	
			<?php if(isset($_GET["status"]) == "thanks"){?>
				<p>Thank you for your submission. Your beer will be reviewed.</p>
				<?php 
					//sleep(5);
					//header( 'Location: http://www.billycougan.com/beer.php' ); 
				?>
			<?php } else{ ?>
			
				<form class="contactForm" method="post" action="addbeer.php">
					<table>
						<tr>
							<th>
								<label for="beerName">Beer Name:</label>
							</th>
							<td>
								<input type="text" name="beerName" id="beerName">
							</td>
						</tr>
						<tr>
							<th>
								<label for="brand">Brand (Brewing Company):</label>
							</th>
							<td>
								<input type="text" name="brand" id="brand">
							</td>
						</tr>
						<tr>
							<th>
								<label for="style">Style:</label>
							</th>
							<td>
								<input type="text" name="style" id="style">
							</td>
						</tr>
						<tr>
							<th>
								<label for="abv">ABV:</label>
							</th>
							<td>
								<input type="text" name="abv" id="abv">
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibu">IBU:</label>
							</th>
							<td>
								<input type="text" name="ibu" id="ibu">
							</td>
						</tr>
						<tr>
							<th>
								<label for="source">Source of Information:</label>
							</th>
							<td>
								<input type="text" name="source" id="source">
							</td>
						</tr>
						
						
						
						
						
						<tr>
							<th>
								<label for="name">Your Name:</label>
							</th>
							<td>
								<input type="text" name="name" id="name">
							</td>
						</tr>
						<tr>
							<th>
								<label for="email">Your Email (Optional):</label>
							</th>
							<td>
								<input type="text" name="email" id="email">
							</td>
						</tr>
						<tr>
							<th>
								<label for="message">Additional Info (Optional):</label>
							</th>
							<td>
								<textarea name="message" id="message"></textarea>
							</td>
						</tr>
						<!--This next table row is hidden and used to protect against hacking robots-->
						<tr style="display: none;">
							<th>
								<label for="address">Address:</label>
							</th>
							<td>
								<input type="text" name="address" id="address">
								<p>Please leave this field blank.</p>
							</td>
						</tr>
					</table>
					<input type="submit" value="Send" style="width: 29%; margin-left: 200px">
				</form>
			
			<?php } ?> <!--End else-->



<?php include('inc/footer.php');?>