<?php
/* $Id: join.php 378 2008-05-30 22:41:41Z bogdan $ */

class join
{
	var $db;
	var $data;
	var $pass;
	var $error;
	var $looking;
	var $for;

	function join($db, $data)
	{
		$this->db   = $db;

		//foreach ($data as $key => $value) {
			//$data[$key] = trim($value);
		//}
		$this->data = $data;

		if($this->checkdata())
		{
			$this->savedata();
		}
	}

	function checkdata()
	{
        if (!$this->data['screen_name'])
        {
            $this->error = "Please enter your Screen Name.";
            return false;
        }
        elseif(strlen($this->data['screen_name']) < 4)
        {
            $this->error = "Screen Name must be at least 4 characters.";
            return false;
        }
        elseif(strlen($this->data['screen_name']) > 12)
        {
            $this->error = "Screen Name must be at most 12 characters.";
            return false;
        }

    	if (!ereg("^[A-Za-z0-9\._]+$", $this->data['screen_name']))
    	{
            $this->error = "Screen name must contain only letters and numbers.";
            return false;
        }
        else
        {
            if ($this->db->get_var("SELECT `screenname` FROM `tblUsers` WHERE `screenname` = '".$this->db->escape($this->data['screen_name'])."'")) {
                $this->error = "Screen name already in use.";
                return false;
            }
        }

/////////////////////////////////////////////////////////////////////////////

        if (!$this->data['email'])
        {
            $this->error = "Please enter your Email Address.";
            return false;
        }
        elseif(strlen($this->data['email']) > 50)
        {
            $this->error = "E-mail must be at most 50 characters.";
            return false;
        }

    	if (!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $this->data['email']))
    	{
            $this->error = "Please enter a valid Email Address.";
            return false;
        }
        else
        {
            if ($this->db->get_var("SELECT `email` FROM `tblUsers` WHERE `email` = '".$this->db->escape($this->data['email'])."'")) {
                $this->error = "Email address already exists in our database. - <A HREF='password.php' STYLE='color: white;'>please use the password reminder tool</A> .";
                return false;
            }
        	elseif ($this->data['email'] != $this->data['email2']){
                $this->error = "Emails do not match.";
                return false;
        	}
        }
/////////////////////////////////////////////////////////////////////////////

		if(isset($this->data['looking']))
		{
		    $looking_arr = array();
		    $looking_arr = $this->data['looking'];

		    $this->looking = 0;
	        foreach ($looking_arr as $param)
	        {
		        $this->looking |= (1 << $param);
		    }
	     }
	     else
	     {
	     	$this->error = "Please select what you are looking for.";
	     	return False;
	     }
/////////////////////////////////////////////////////////////////////////////

        if (!$this->data['country'])
        {
            $this->error = "Please select country.";
            return false;
        }
        elseif($this->data['country'] == 1 && !$this->data['state'])
        {
            $this->error = "Please select state if USA.";
            return false;
        }
        elseif($this->data['country'] != 1)
        {
        	$this->data['state'] = 0;
        }


        if (!$this->data['city'])
        {
            $this->error = "Please enter city.";
            return false;
        }
//////////////////////////////////////////////////////////////////////////////

		if(isset($this->data['for']))
		{
		    $for_arr = array();
		    $for_arr = $this->data['for'];

		    $this->for = 0;
	        foreach ($for_arr as $param)
	        {
		        $this->for |= (1 << $param);
		    }
	     }
	     else
	     {
	     	$this->error = "Please select For some.";
	     	return False;
	     }
/////////////////////////////////////////////////////////////////////////////

        if(!@checkdate($this->data['month'],$this->data['day'],$this->data['year'])){
                $this->error = "Invalid Birth Date.";
                return false;
        }
        else
        {
        	$this->data['birthdate'] = $this->data['year'] . "-" . $this->data['month'] . "-" . $this->data['day'];
        }
/////////////////////////////////////////////////////////////////////////////
        /*
        if(!$this->data['random'])
        {
            $this->error = "Please enter code.";
            return false;
        }
        elseif(strtolower($this->data['random']) != strtolower($_SESSION['active_code']))
        {
            $this->error = "Code not Matching !! Try again.";
            return false;
        }
        */
//////////////////////////////////////////////////////////////////////////////

        if(!$this->data['terms'])
        {
            $this->error = "You have to read and check the agree to terms checkbox.";
            return false;
        }

        return true;
	}

	function savedata()
	{
		$this->pass = verify(8);

		$sql_insert = "INSERT INTO `tblUsers`
		               (`screenname`,
		                `pass`,
		                `email`,
		                `sex`,
		                `looking`,
		                `for`,
		                `birthdate`,
		                `country`,
		                `state`,
		                `city`,
		                `lastip`,
		                `approved`,
		                `joined`,
		                `promcode`
		               )
		               VALUES
		               ('" . addslashes( $this->data['screen_name'] ) . "',
		                '" . addslashes( $this->pass ) . "',
		                '" . addslashes( $this->data['email'] ) . "',
		                '" . addslashes( $this->data['sex'] ) . "',
		                '" . addslashes( $this->looking ) . "',
		                '" . addslashes( $this->for ) . "',
		                '" . addslashes( $this->data['birthdate'] ) . "',
		                '" . addslashes( $this->data['country'] ) . "',
		                '" . addslashes( $this->data['state'] ) . "',
		                '" . addslashes( $this->data['city'] ) . "',
		                '" . $_SERVER['REMOTE_ADDR'] . "',
		                'Y',
		                NOW(),
		                '" . addslashes( $this->data['promcode'] ) . "'
		               )";

		if($this->db->query($sql_insert))
		{
			$this_data_id = mysql_insert_id();
			
			$mail = $this->db->get_row("SELECT `subject`,`message` FROM `tblMailerMachine` WHERE `for` = 'join' AND `type` = 'external'");

			$subject = str_replace("[%to_name%]", $this->data['screen_name'], $mail['subject']);
			$message = str_replace(array("[%to_name%]","[%to_password%]","[%login_link%]"), array($this->data['screen_name'],$this->pass,"<a href='http://www.flirtigo.com/?screen_name=".$this->data['screen_name']."'>http://www.flirtigo.com</a>"), $mail['message']);

			send_mail($this->data['email'], $this->data['screen_name'], $subject, $message);
			
			mailermachine($this->db, null, 'join', 'internal', (int) $this_data_id, 1);
			
			echo "<script type=\"text/javascript\">window.location = '/welcome.php?screen_name=" . $this->data['screen_name'] . "'</script>";
			//header("Location: /welcome.php?screen_name=" . $this->data['screen_name']);
			exit(0);
		}
	}
}
?>