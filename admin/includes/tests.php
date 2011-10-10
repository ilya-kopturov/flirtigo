<?
require("cnn.php");
	//if($_POST["submit"]=="submit"){
	for($i=0;$i<500;$i++){
		if($_POST[$i]!=""){
		$qry="insert into tblState (Id,Name) values ('".$i."','".$_POST[$i]."')";
		$qry=mysql_query($qry);
		}
	}
	
	//}
?>
<form name="form1" action="tests.php" method="post">
<textarea name="300">Alabama</textarea>
<textarea name="301">Alaska</textarea>
<textarea name="303">Arizona</textarea>
<textarea name="304">Arkansas</textarea>
<textarea name="306">California</textarea>
<textarea name="307">Colorado</textarea>
<textarea name="308">Connecticut</textarea>
<textarea name="309">Washington D.C.</textarea>
<textarea name="310">Delaware</textarea>
<textarea name="311">Florida</textarea>
<textarea name="312">Georgia</textarea>
<textarea name="313">Hawaii</textarea>
<textarea name="314">Idaho</textarea>
<textarea name="315">Illinois</textarea>
<textarea name="316">Indiana</textarea>
<textarea name="317">Iowa</textarea>
<textarea name="318">Kansas</textarea>
<textarea name="319">Kentucky</textarea>
<textarea name="320">Louisiana</textarea>
<textarea name="321">Maine</textarea>
<textarea name="323">Maryland</textarea>
<textarea name="324">Massachusetts</textarea>
<textarea name="325">Michigan</textarea>
<textarea name="326">Minnesota</textarea>
<textarea name="327">Mississippi</textarea>
<textarea name="328">Missouri</textarea>
<textarea name="329">Montana</textarea>
<textarea name="330">Nebraska</textarea>
<textarea name="331">Nevada</textarea>
<textarea name="333">Newfoundland</textarea>
<textarea name="334">New Hampshire</textarea>
<textarea name="335">New Jersey</textarea>
<textarea name="336">New Mexico</textarea>
<textarea name="337">New York</textarea>
<textarea name="338">North Carolina</textarea>
<textarea name="339">North Dakota</textarea>
<textarea name="342">Ohio</textarea>
<textarea name="343">Oklahoma</textarea>
<textarea name="345">Oregon</textarea>
<textarea name="346">Pennsylvania</textarea>
<textarea name="348">Puerto Rico</textarea>
<textarea name="350">Rhode Island</textarea>
<textarea name="352">South Carolina</textarea>
<textarea name="353">South Dakota</textarea>
<textarea name="354">Tennessee</textarea>
<textarea name="355">Texas</textarea>
<textarea name="356">Utah</textarea>
<textarea name="357">Vermont</textarea>
<textarea name="358">Virginia</textarea>
<textarea name="359">Washington</textarea>
<textarea name="360">West Virginia</textarea>
<textarea name="361">Wisconsin</textarea>
<textarea name="362">Wyoming</textarea>
<textarea name="363">Yukon Territory</textarea>
<textarea name="364">District of Columbia</textarea>

<input type="submit" name="submit" value="submit" />
</form>