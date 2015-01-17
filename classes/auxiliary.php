<?php
    function checkEmailAdress($email) { 
        if( (preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $email)) || 
            (preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/',$email)) ) { 
            return true;
        }
        return false;
    }
    
    function checkContactForm($values){
        $error = "";
        if(isset($values)){
                if(trim($values['name'])=="")
                    $error .= "Campul Nume nu poate fi vid!<br/>";
                if(trim($values['email'])=="" && !checkEmailAdress($values['email']))
                    $error .= "Campul Email nu poate fi vid!<br/>";
                if(trim($values['message'])=="")
                    $error .= "Campul Mesaj nu poate fi vid!<br/>";
        }
    return $error;
    }

    function checkInchirieriStanduriForm($values){
        $error = "";
        if(isset($values)){
                if(trim($values['firstName'])=="")
                    $error .= "Campul Nume nu poate fi vid!<br/>";
                if(trim($values['lastName'])=="")
                    $error .= "Campul Prenume nu poate fi vid!<br/>";
                if(trim($values['lastName'])=="")
                    $error .= "Campul Prenume nu poate fi vid!<br/>";
                if(trim($values['company'])=="")
                    $error .= "Campul Companie nu poate fi vid!<br/>";
                if(trim($values['companyProfile'])=="")
                    $error .= "Campul Profilul Companiei nu poate fi vid!<br/>";
                if(trim($values['address'])=="")
                    $error .= "Campul Adresa nu poate fi vid!<br/>";
                if(trim($values['city'])=="")
                    $error .= "Campul Oras nu poate fi vid!<br/>";
                if(trim($values['county'])=="")
                    $error .= "Campul Judet nu poate fi vid!<br/>";
                if(trim($values['postalCode'])=="")
                    $error .= "Campul Cod Postal nu poate fi vid!<br/>";
                if(trim($values['phone'])=="")
                    $error .= "Campul Phone nu poate fi vid!<br/>";
                if(trim($values['mobile'])=="")
                    $error .= "Campul Mobil nu poate fi vid!<br/>";
                if(trim($values['fax'])=="")
                    $error .= "Campul Fax nu poate fi vid!<br/>";					
                if(trim($values['email'])=="" && !checkEmailAdress($values['email']))
                    $error .= "Campul Email nu poate fi vid!<br/>";
        }
    return $error;
    }

    function checkSuggestionForm($values){
        $error = "";
        if(isset($values)){
                if(trim($values['name'])=="")
                    $error .= "Campul Nume nu poate fi vid!<br/>";
                if(trim($values['email'])=="" && !checkEmailAdress($values['email']))
                    $error .= "Campul Email nu poate fi vid!<br/>";
                if(trim($values['message'])=="")
                    $error .= "Campul Mesaj nu poate fi vid!<br/>";
        }
    return $error;
    }

	function checkEmploymentForm($values){
        $error = "";
        if(isset($values)){
                if(trim($values['name'])=="")
                    $error .= "Campul Nume nu poate fi vid!<br/>";
                if(trim($values['address'])=="")
                    $error .= "Campul Adresa nu poate fi vid!<br/>";
                if(trim($values['city'])=="")
                    $error .= "Campul Oras nu poate fi vid!<br/>";
                if(trim($values['county'])=="")
                    $error .= "Campul Judet nu poate fi vid!<br/>";
                if(trim($values['phone'])=="")
                    $error .= "Campul Telefon nu poate fi vid!<br/>";
					
                if(trim($values['email'])=="" && !checkEmailAdress($values['email']))
                    $error .= "Campul Email nu poate fi vid!<br/>";
                if(trim($values['message'])=="")
                    $error .= "Campul Mesaj nu poate fi vid!<br/>";
        }
    return $error;
	}
        
	function generateFilename($type, $extension) {
		return $type.date("dmYHis").".".$extension;		
	}			
?>