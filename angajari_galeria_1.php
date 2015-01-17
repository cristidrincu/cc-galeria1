<?  
	require_once("classes/class.ocrcaptcha.php");
	$captcha = new ocr_captcha();

    if(isset($_POST['submitBtn']) && $_POST['submitBtn']=="Trimite") {   

		require_once("classes/debuglib.php");
		require_once("classes/auxiliary.php");
		require_once("classes/class.htmlMimeMail.php");
		require_once("classes/config.php");
	  
		$employmentErrorMessage = "";    
		if($captcha->check_captcha($_POST['public_key'],$_POST['private_key']))	 { 
				$employmentErrorMessage = checkEmploymentForm($_POST); 
				if($employmentErrorMessage=="") {
					$name          = $_POST['name'];					
					$address       = $_POST['address'];
					$city          = $_POST['city'];					
					$county        = $_POST['county'];					
					$phone         = $_POST['phone'];					
					$email         = $_POST['email'];
					$message       = $_POST['message'];

					$cvFile 	  		  = "";
					$cvFileMimeType 	  = "";
					$pictureFile1 		  = "";
					$pictureFile1MimeType = "";
					$pictureFile2 		  = "";
					$pictureFile2MimeType = "";
					
					if (is_uploaded_file($_FILES['UPLOAD_FILE_CV']['tmp_name']))
					  { 
						  $extensionArray = explode(".",$_FILES['UPLOAD_FILE_CV']['name']);
						  $extension = $extensionArray[count($extensionArray)-1];
						  $extension = strtoupper($extension);																									  
						  
							  if (($extension != "PDF") && ($extension!= "DOC")){																												  
									$employmentErrorMessage .= "Sunt permise doar fisiere de tip PDF sau DOC!!!";
							  }
							  else{
										  $filename = generateFilename("CV",$extension);																										  																				   
										  $UPLOAD_NAME_CV = "files/".$filename;
										   if (move_uploaded_file($_FILES['UPLOAD_FILE_CV']['tmp_name'],$UPLOAD_NAME_CV)) {																							   		   
										   		if($extension=="PDF")
													$cvFileMimeType = "application/pdf";
												else
													$cvFileMimeType = "application/msword";
												$cvFile = $filename;						
										   }
										   else
												$employmentErrorMessage .= " A aparut o eroare in cadrul trimiterii cererii dumneavoastre. Va rugam reincercati mai tarziu";
									}
					   }
					   else 
							$employmentErrorMessage = "Fisierul care contine CV-ul dumneavoastra este obligatoriu!!!<br/>";   

					  if (is_uploaded_file($_FILES['UPLOAD_FILE_PIC1']['tmp_name']))
					  { 
						  $extensionArray = explode(".",$_FILES['UPLOAD_FILE_PIC1']['name']);
						  $extension = $extensionArray[count($extensionArray)-1];
						  $extension = strtoupper($extension);																									  
						  
							  if (($extension!= "PJPEG") && ($extension != "JPEG")&& ($extension!= "JPG")){																												  
									$employmentErrorMessage .= "Sunt permise doar fisiere de tip JPG, JPEG, PJPEG!!!";
							  }
							  else{
										  $filename = generateFilename("poza1",$extension);																										  																				   
										  $UPLOAD_NAME_PIC1 = "files/".$filename;
										   if (move_uploaded_file($_FILES['UPLOAD_FILE_PIC1']['tmp_name'],$UPLOAD_NAME_PIC1)) {																							   		   
												$pictureFile1 = $filename;	
												$pictureFile1MimeType = "image/jpeg";					
										   }
										   else
												$employmentErrorMessage .= " A aparut o eroare in cadrul trimiterii cererii dumneavoastre. Va rugam reincercati mai tarziu";
									}
					   }
					   else 
						   $employmentErrorMessage = "Fiserul Poza 1 este obligatoriu!!!<br/>";   

					  if (is_uploaded_file($_FILES['UPLOAD_FILE_PIC2']['tmp_name']))
					  { 
						  $extensionArray = explode(".",$_FILES['UPLOAD_FILE_PIC2']['name']);
						  $extension = $extensionArray[count($extensionArray)-1];
						  $extension = strtoupper($extension);																									  
						  
							  if (($extension != "GIF") && ($extension!= "PJPEG") && ($extension != "JPEG")&& ($extension!= "JPG")){																												  
									$employmentErrorMessage .= "Sunt permise doar fisiere de tip JPG, JPEG, GIF, PJPEG!!!";
							  }
							  else{
										  $filename = generateFilename("poza2",$extension);																										  																				   
										  $UPLOAD_NAME_PIC2 = "files/".$filename;
										   if (move_uploaded_file($_FILES['UPLOAD_FILE_PIC2']['tmp_name'],$UPLOAD_NAME_PIC2)) {																							   		   
												$pictureFile2 = $filename;	
												$pictureFile2MimeType = "image/jpeg";										
										   }
										   else
												$employmentErrorMessage .= " A aparut o eroare in cadrul trimiterii cererii dumneavoastre. Va rugam reincercati mai tarziu";
									}
					   }
					   else 
						   $employmentErrorMessage = "Fiserul Poza 2 este obligatoriu!!!<br/>";   

					  
					if($employmentErrorMessage==""){					
						$htmlText="";
						$htmlText .=   '<table align="center" width="99%" style="font-weight:bold;" border="1">';
						$htmlText .=   '<tr style="font-weight:bold">';
						$htmlText .=   '    <td colspan="2">Cerere Contact</td>';
						$htmlText .=   '</tr>';
						$htmlText .=   '<tr>';
						$htmlText .=   '    <td width="200">Nume:&nbsp;</td>';
						$htmlText .=   '    <td>'.$name.'</td>';
						$htmlText .=   '</tr>';
						$htmlText .=   '<tr>';
						$htmlText .=   '    <td width="200">Adresa:&nbsp;</td>';
						$htmlText .=   '    <td>'.$address.'</td>';
						$htmlText .=   '</tr>';
						$htmlText .=   '<tr>';
						$htmlText .=   '    <td width="200">City:&nbsp;</td>';
						$htmlText .=   '    <td>'.$city.'</td>';
						$htmlText .=   '</tr>';
						$htmlText .=   '<tr>';
						$htmlText .=   '    <td width="200">County:&nbsp;</td>';
						$htmlText .=   '    <td>'.$county.'</td>';
						$htmlText .=   '</tr>';
						$htmlText .=   '<tr>';
						$htmlText .=   '    <td width="200">Phone:&nbsp;</td>';
						$htmlText .=   '    <td>'.$phone.'</td>';
						$htmlText .=   '</tr>';										
						$htmlText .=   '<tr>';                                        
						$htmlText .=   '    <td>Email:&nbsp;</td>';
						$htmlText .=   '    <td>'.$email.'</td>';
						$htmlText .=   '</tr>';
						$htmlText .=   '<tr>';
						$htmlText .=   '    <td>Mesaj:&nbsp;</td>';
						$htmlText .=   '    <td>'.nl2br($message).'</td>';
						$htmlText .=   '</tr>';
						$htmlText .=   '</table>';
						
						$text  = 'Cerere Contact\r\n';
						$text .= 'Nume:'.$name.'\r\n';
						$text .= 'Adresa:'.$address.'\r\n';
						$text .= 'Oras:'.$city.'\r\n';
						$text .= 'Judet:'.$county.'\r\n';					
						$text .= 'Telefon:'.$phone.'\r\n';
						$text .= 'Email:'.$email.'\r\n';
						$text .= 'Mesaj:'.nl2br($message).'\r\n';
			
						$to		 = EMPLOYMENT_DELIVERY_ADDRESS;                                                            
						$from 	 = "client@ccgaleria1.ro";
						$subject = "Cerere Angajare";    
						$html 	 = "<HTML><HEAD></HEAD><BODY>".$htmlText."</BODY></HTML>";
			
						$mail = new htmlMimeMail();
						
						$mail->addAttachment($mail->getFile('files/'.$cvFile), $cvFile, $cvFileMimeType);      
						$mail->addAttachment($mail->getFile('files/'.$pictureFile1), $pictureFile1, $pictureFile1MimeType);      
						$mail->addAttachment($mail->getFile('files/'.$pictureFile2), $pictureFile2, $pictureFile2MimeType);      

						$mail->setHtml($htmlText, $text);
						$mail->setReturnPath($to);
						$mail->setFrom($from);
						$mail->setSubject($subject);
						$mail->setHeader("X-Mailer","ccgaleria1.ro");
						$mail->setHeader("X-Priority","1");
						$mail->setHeader("X-Sender","<www.ccgaleria1.ro>");
						
						$result = @$mail->send(array($to));
						
						if (!$result){
							  header("location: send_message_failure.html");  
						}
						else {
							  header("location: send_message_ok.html");                          
						} 
						
						unlink("files/".$cvFile);
						unlink("files/".$pictureFile1);
						unlink("files/".$pictureFile2);
						 
					} // error message after upload
				} 
		} else {  // else captcha
			$employmentErrorMessage .= "Codul din imagine nu corespunde cu cel introdus de dumneavoastra";		
		}
    }                                                           
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="css/galeria.css"/>
	<title>Galeria 1 - Angajari</title>
</head>
<body>

	<div id="headerBackground">
		<!--comment-->
		<div id="baraMeniu">
			<div id="containerLogoMeniu">
				<div id="pozaLogo">
				  <img src="jpg/temp/logo.gif" alt="" border="0" width="299" height="108"/>				</div><!--ends pozaLogo-->
				
				<div id="meniu">	
						<ul class="meniuTop">
							<li>
								<a class="linkMeniu" href="index.html" target="_self">prezentare</a>							</li>
							  
							<li>
								<a class="linkMeniu" href="standuri_galeria1.html" target="_self">standuri</a>							</li>
							  
							<li>
								<a class="linkMeniu" href="inchirieri_standuri.php" target="_self">inchirieri</a>							</li>
							  
							<li>
								<a class="linkMeniu" href="angajari_galeria_1.php" target="_self">angajari</a>							</li>
							  
							<li>
								<a class="linkMeniu" href="sugestii_galeria_1.php" target="_self">sugestii</a>							</li>
							  
							<li>
								<a class="linkMeniu" href="contact_galeria_1.php" target="_self">contact</a>							</li>
						</ul>
				</div><!--ends meniu div-->	
		  </div><!--ends containerLogoMeniu-->
		  
		  
		  
		  <div id="containerSloganPoza">
				<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="800" height="273">
				  <param name="movie" value="swf/header_flash.swf" />
				  <param name="quality" value="high" />
				   <param name="wmode" value="transparent" />
				  <embed src="swf/header_flash.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="800" height="273" wmode="transparent"></embed>
				</object>
				<script type="text/javascript" src="js/ieupdate.js"></script>
		  </div>
		  <!--ends slogan div-->
	  </div><!--ends baraMeniu-->
	  
	  <div id="backgroundLinie">
	  		<!--comment-->
	  </div><!--ends backgroundLinie-->
	  
	</div>
	<!--ends headerBackground-->	
	
	
	<div id="mainBox">
		
	
		<div id="middleColumnLarge">
			<h3 style="color: #FF6600; font-size:16px;">Angajari</h3>
			
			
			
			<div class="containerTextLeftColumnLarge">
				<form id="formularJob" enctype="multipart/form-data" method="post" action="angajari_galeria_1.php" >
					<fieldset>
						<legend>FORMULAR ANGAJARI</legend>
							<table id="tableGetAJob">
										<?
											if(isset($employmentErrorMessage)) {
										?>
										<tr>
											<td colspan="3">&nbsp;</td>
										</tr>										
										<tr>
											<td colspan="3" align="center">
												<span style="color:#f00; font-weight:bold; text-transform:uppercase;">
												<?
													echo $employmentErrorMessage;
												?>
												</span>
											</td>
										</tr>
										<tr>
											<td colspan="3">&nbsp;</td>
										</tr>										
										<?
										}
										?>			
		
										<tr>
											<td colspan="3"><hr/></td>
										</tr>
									
										<tr>
											<td colspan="3"><span style="color:#f00; font-weight:bold; text-transform:uppercase;">toate campurile sunt obligatorii! 
											formularele completate incorect nu vor fi luate in considerare!</span></td>
										</tr>
										
										
									
										<tr>
											<td colspan="3"><hr/></td>
										</tr>
										
										<tr>
											<td><b>Nume si prenume:</b></td>
											<td colspan="2">
											<input type="text" name="name" tabindex="1" size="30" value="<?=(isset($_POST['name']) ? $_POST['name'] : "")?>"/></td>
										</tr>
										
										
										<tr>
											<td><b>Adresa:</b></td>
											<td colspan="2"><input type="text" name="address" tabindex="3" size="30" value="<?=(isset($_POST['address']) ? $_POST['address'] : "")?>"/></td>
										</tr>
										
										<tr>
											<td><b>Telefon:</b></td>
											<td><input type="text" name="phone" tabindex="4" size="30" value="<?=(isset($_POST['phone']) ? $_POST['phone'] : "")?>"/></td>
										</tr>
										
										<tr>
											<td><b>Localitate:</b></td>
											<td><input type="text" name="city" tabindex="5" size="30" value="<?=(isset($_POST['city']) ? $_POST['city'] : "")?>"/></td>
										</tr>
										
										<tr>
											<td><b>Judet:</b></td>
											<td><input type="text" name="county" tabindex="6" size="30" value="<?=(isset($_POST['county']) ? $_POST['county'] : "")?>"/></td>
										</tr>
							
										<tr>
											<td><b>E-mail:</b></td>
											<td>
												<input type="text" name="email" tabindex="3" size="30" value="<?=(isset($_POST['email']) ? $_POST['email'] : "")?>"/>
											</td>
										</tr>
										
										<tr>
											<td colspan="3"><b>Upload Cv-ul dumneavoastra si 2 poze</b></td>
										</tr>
										
										<tr>
											<td colspan="3"><hr/></td>
										</tr>
										
										<tr>
											<td><b>Upload CV:</b></td>
											<td><input type="file" name="UPLOAD_FILE_CV" tabindex="7" size="30"/></td>
											<td>&nbsp;</td>
										</tr>
										
										<tr>
											<td><b>Upload poza 1:</b></td>
											<td><input type="file" name="UPLOAD_FILE_PIC1" tabindex="8" size="30"/></td>
											<td>&nbsp;</td>
										</tr>
										
										<tr>
											<td><b>Upload poza 2:</b></td>
											<td><input type="file" name="UPLOAD_FILE_PIC2" tabindex="9" size="30"/></td>
											<td>&nbsp;</td>
										</tr>
										
										<tr>
											<td colspan="3"><span style="color:#f00; font-weight:bold;">*Pozele trebuie sa fie de tip pasaport si sa nu depaseasca 1mb ca marime.</span></td>
										</tr>
										
										<tr>
											<td colspan="3"><hr/></td>
										</tr>
										
										<tr>
											<td colspan="3"><b>De ce doriti sa deveniti membru al echipei Galeria 1?</b></td>
										</tr>
										
										<tr>
											<td colspan="3"><hr/></td>
										</tr>
										
										<tr>
											<td colspan="3"><textarea name="message" rows="10" cols="60" tabindex="10"><?=(isset($_POST['message']) ? $_POST['message'] : "")?></textarea></td>
										</tr>

										<tr>
											<td colspan="2" align="center">				
												<table cellpadding="0" cellspacing="2" border="0" width="95%">
													<tr>
														<td colspan="2" align="center">
															<a href="angajari_galeria_1.php">
																Daca nu vedeti imaginea de mai jos da-ti click aici
															</a>
															<br/>
															<span class="greenText">
																Va rugam introduceti codul din imagine
															</span><br/>
														</td>
													</tr>
													<tr>
														<td align="center" colspan="2" valign="middle">
															<?
																echo $captcha->display_captcha(true);
																					
															?>
														</td>
													</tr>
													<tr>
														<td colspan="2">&nbsp;</td>
													</tr>
												</table>
											</td>
										</tr>
									
										<tr>
											<td colspan="3"><hr/></td>
										</tr>
										
										<tr>
											<td><input type="submit" name="submitBtn" value="Trimite"  tabindex="11"/> </td>
										</tr>
				
							</table>				
				</fieldset>
		</form>
	
	</div><!--ends containerTextLeftColumnLarge-->
</div><!--ends middleColumn div-->
		
		
	  <div id="rightColumn">
			<h3 style="color: #666666; font-size:16px;">Firme prezente in Galeria 1</h3>
			
				
			
				<!--<div class="logoFirma">
					<img src="jpg/pic_logos/nike.jpg" alt="Galeria 1" border="0" width="55" height="55"/>
				</div>
				
				<div class="logoFirma">
					<img src="jpg/pic_logos/adidas.jpg" alt="Galeria 1" border="0" width="55" height="55"/>
				</div>
				
				<div class="logoFirma">
					<img src="jpg/pic_logos/Puma.jpg" alt="Galeria1" border="0" width="55" height="55"/>
				</div>-->

			<div class="clearFloats">
				<!--comment-->
			</div><!--ends clearFloats-->
			
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>LUNEX</li>
					<li><span class="blackLI">Stand:</span> E1</li>
					<li><span class="blackLI">Domeniu activitate:</span> MOBILA</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>IROKO</li>
					<li><span class="blackLI">Stand:</span> E3/4</li>
					<li><span class="blackLI">Domeniu activitate:</span> MOBILA</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>CULLINAN</li>
					<li><span class="blackLI">Stand:</span> E5</li>
					<li><span class="blackLI">Domeniu activitate:</span> MOBILIER TERASE SI GRADINI</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>BGG CONSTRUCT</li>
					<li><span class="blackLI">Stand:</span> E6</li>
					<li><span class="blackLI">Domeniu activitate:</span> MOBILIER TAPITAT</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>ZASS PROTEUS</li>
					<li><span class="blackLI">Stand:</span> E7</li>
					<li><span class="blackLI">Domeniu activitate:</span> ELECTROCASNICE</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>17 MARKS RETAIL</li>
					<li><span class="blackLI">Stand:</span> E7A</li>
					<li><span class="blackLI">Domeniu activitate:</span> MOBILA</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>MOBILA BONTAS</li>
					<li><span class="blackLI">Stand:</span> E8 + E10-14</li>
					<li><span class="blackLI">Domeniu activitate:</span> MOBILA</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>PRO DOOR</li>
					<li><span class="blackLI">Stand:</span> Et. Central</li>
					<li><span class="blackLI">Domeniu activitate:</span> MOBILA SI USI INTERIOR/EXTERIOR</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>SORAZMI</li>
					<li><span class="blackLI">Stand:</span> P3</li>
					<li><span class="blackLI">Domeniu activitate:</span> IMBRACAMINTE</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>EYSSETTE</li>
					<li><span class="blackLI">Stand:</span> P4</li>
					<li><span class="blackLI">Domeniu activitate:</span> INCALTAMINTE</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>AUTOWELT</li>
					<li><span class="blackLI">Stand:</span> P5 + EG1</li>
					<li><span class="blackLI">Domeniu activitate:</span> MOBILA</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>ELGA STIL</li>
					<li><span class="blackLI">Stand:</span> P6</li>
					<li><span class="blackLI">Domeniu activitate:</span> DECORATIUNI INTERIOARE</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>SIRIUS</li>
					<li><span class="blackLI">Stand:</span> P7</li>
					<li><span class="blackLI">Domeniu activitate:</span> MOBILA</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>FUGIAMIS</li>
					<li><span class="blackLI">Stand:</span> P10 + P11</li>
					<li><span class="blackLI">Domeniu activitate:</span> ARTICOLE PENTRU COPII</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>ART DIMA</li>
					<li><span class="blackLI">Stand:</span> P12</li>
					<li><span class="blackLI">Domeniu activitate:</span> ARTICOLE PENTRU COPII</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>BODO SPORT</li>
					<li><span class="blackLI">Stand:</span> P13</li>
					<li><span class="blackLI">Domeniu activitate:</span> ARTICOLE SPORTIVE</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>MEDUSA TEXTILE</li>
					<li><span class="blackLI">Stand:</span> P13*</li>
					<li><span class="blackLI">Domeniu activitate:</span> ARTICOLE SPORTIVE</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>OLTEANU MARIAN</li>
					<li><span class="blackLI">Stand:</span> P14</li>
					<li><span class="blackLI">Domeniu activitate:</span> IMBRACAMINTE</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>MALENA LUX</li>
					<li><span class="blackLI">Stand:</span> P15</li>
					<li><span class="blackLI">Domeniu activitate:</span> IMBRACAMINTE</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>MODA CRISTINA</li>
					<li><span class="blackLI">Stand:</span> P16</li>
					<li><span class="blackLI">Domeniu activitate:</span> IMBRACAMINTE</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<div class="containerTextRightColumn">
				<ul style="list-style:none; margin-left:-10px !important; margin-left:0; font-weight:bold; color:#990000; margin-bottom:-10px !important; margin-bottom:7px;">
					<li>FORTUNA</li>
					<li><span class="blackLI">Stand:</span> P18</li>
					<li><span class="blackLI">Domeniu activitate:</span> MOBILA</li>
				</ul>
			</div><!--ends containerTextRightColumn-->
			
			<br/>
			
		  <a class="redLinksRightColumn" href="lista_firme_galeria_1.html" target="_self">click aici pentru intreaga lista de firme</a>		</div>
		<!--ends rightColumn div-->
	
	<div class="clearFloats">
		<!--comment-->
	</div><!--ends clearFloats-->
	
	</div><!--ends mainBox div-->
	
	
	
	
	<div id="footer">
		<div id="lineFooter">
			<!--comment-->
		</div><!--ends lineFooter comment-->
		
		<div id="containerHeadereFooter">
			<div class="headerFooter">
				<h3 style="color:#fff; font-size:16px; border-left: 1px solid white; padding-left:10px;">Orar zilnic Galeria 1</h3>
				<p style="width:260px; margin-right:10px;color:#fff; font-weight:bold;">Luni-Sambata: 10-20
				<br/>
				Duminica: INCHIS				</p>
			</div><!--ends headerFooter-->
			
			<div class="headerFooter">
				<h3 style="color:#fff; font-size:16px; border-left: 1px solid white; padding-left:10px;">Alte informatii utile</h3>
				
				<p style="width:260px; color:#fff; font-weight:bold;">
				Accesul cu mijloacele de transport in comun se poate face cu Expresul nr.1, troleibuzul nr.14 sau autobuzul nr.40.				</p>
			</div><!--ends headerFooter-->
			
			<div class="headerFooterRight">
				<h3 style="color:#fff; font-size:16px; border-left: 1px solid white; padding-left:10px;">Informatii de contact</h3>
				<p style="width:220px; color:#fff; font-weight:bold;">
				Calea Sever Bocu nr. 2 (fosta Cl. Lipovei), Timisoara, 300242
				<br/><br/>
				Telefoane: 0256 21 00 44, 0356 42 44 08, 0356 42 44 09
				<br/>
				Fax: 0256 21 00 46
				<br/>
				Pentru inchirieri: 0744 628 779
				<br/><br/>
				e-mail:office@ccgaleria1.ro
				web:www.ccgaleria1.ro				</p>
			</div><!--ends headerFooter-->
			
			<div class="clearFloats">
				<!--comment-->
			</div>
			
			<div id="copyRightInfo">
				<p style="color:#fff; font-weight:bold;">&copy;2007 Galeria1. Toate drepturile rezervate.
				<br/>
				Site realizat de <a style="color:#fff;" href="http://www.globe-studios.com" target="_blank">Globe-Studios</a>				</p>
			</div><!--ends copyRightInfo-->
		</div><!--ends containerHeadereFooter-->
	</div>
	<!--footer-->
	
	

</body>
</html>
