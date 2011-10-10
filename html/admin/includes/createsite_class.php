<?

class uploadFiles{
	function export($e,$id){
		//create file to export
		$exportfile = "../templates/export".$id.".txt";
		$exportahandle = fopen($exportfile, 'w') or die("can't open file");
		fwrite($exportahandle,$e);
		fclose($exportahandle);
	}
	function server_connect($id,$server,$user,$pass,$folder){
		//connetc to server
		$connection = ftp_connect($server); 
		//login
		$login = ftp_login($connection,$user,$pass); 
		if ((!$connection) || (!$login)) {
			   echo "FTP connection has failed! Attempted to connect to $server for user $user";
		   } else {
		  	 echo "Connected to $server, for user $user";
		   }
		   
		 //put the files in the desired folder
		 echo $destfile=$folder."export.txt";
		 echo "<br>";
		 echo $sourcefile="../templates/export".$id.".txt";
		 echo "<br>";
		 if(file_exists($sourcefile)) echo "<br>fisierul exista<br>";
		 //ftp_chdir($connection,"test");
		 //$upload = ftp_put($connection,$destfile,$sourcefile,FTP_ASCII) or die("eroare upload");
		 //close connection
		 ftp_close($connection);
		 
	}
	function uploadFiles($e,$id,$server,$user,$pass,$folder){
		$this->export($e,$id);
		$this->server_connect($id,$server,$user,$pass,$folder);
	}
	
}



?>