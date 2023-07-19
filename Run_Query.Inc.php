<?php 
require_once("Const.Inc.php");

class Run_Query
{
    var $CONN;
	function Run_Query($DBName)
	{
		global $DBHost , $DBUserName , $DBPassword;
		/*echo "<br>DataBase Name is :- " . $DBName;
		echo "<br>Host Name is :- " . $DBHost;
		echo "<br>DataBase User Name Name is :- " . $DBUserName;
		echo "<br>DataBase Password Name is :- " . $DBPassword;
		exit;
		*/
		$conn = @mysql_connect($DBHost,$DBUserName,$DBPassword);
		
		if(!($conn))
		{
			
			die("Not Connected to the Database");
			
		}
		else
		{
			
			$con = mysql_select_db($DBName,$conn);
			$this->CONN = $conn ;
			return $this->CONN ;
		}	
	}
	
	
	function select($sql = "")
	{
	    if(!$this->CONN)
			return false;
	    if($sql == "")
		    return false;
		else
		{
		    $res = mysql_query($sql , $this->CONN);
			if(!$res)			
			{
				echo mysql_error($this->CONN);
			    return false;
			}
			else
			{ 
			    $count = 0;
				while($row = mysql_fetch_array($res))
				{
				    $record[$count] = $row ;
					$count++ ;
				}
			    return @$record;
			}
		}
	}
	
	
	function insert($sql = "")
	{
	    if(!$this->CONN)
			return false;
	    if($sql == "")
		    return false;
		else
		{
		    $res = mysql_query($sql , $this->CONN);
			if(!$res)			
			{
			    return false;
			}
			else
			{
			    $insertid = mysql_insert_id();
			    return $insertid;
			}
		}
	}
	
    
	function update($sql = "")
	{
	    if(!$this->CONN)
			return false;
	    if($sql == "")
		    return false;
		else
		{
		    $res = mysql_query($sql , $this->CONN);
			if(!$res)			
			{
			    return false;
			}
			else
			{
			    return $res;
			}
		}
	}	
	
	
	function delete($sql = "")
	{
	    if(!$this->CONN)
			return false;
	    if($sql == "")
		    return false;
		else
		{
		    $res = mysql_query($sql , $this->CONN);
			if(!$res)			
			{
			    return false;
			}
			else
			{
			    return $res;
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	






/*---------------------------------------------------------------------------------
Start , Mostly Used Functions
---------------------------------------------------------------------------------*/
	function Redirect($Med)
	{
	    return header("location:$Med");
	}
/*---------------------------------------------------------------------------------
Start , Mostly Used Functions
---------------------------------------------------------------------------------*/
/*******************************************************
Start Function to Create Combo
********************************************************/

	function Combo($TBName,$ComboName,$FieldToSelect = "",$OnClick = "",$Lable = "",$FieldToShow = "",$Class = "")
	{
		
		$sql = "select * from `$TBName`" ;
		$ResultArray = $this->select($sql) ;
		
		//this is the field name shown in the optin of teh select
		if($FieldToShow == '') { $FieldToShow = "Name" ; }

		if(!empty($ResultArray))
		{
			$Combo = "<select name='$ComboName' onclick='$OnClick' class='$Class'>" ;
			if($Lable != "")
			{
				$Combo .= "<option value=''>$Lable</option>" ;
			}
			for($i=0;$i<count($ResultArray);$i++)
			{
				$Combo .= "<option value='" . $ResultArray[$i]['Id'] . "'" ;
				if($FieldToSelect == $ResultArray[$i]['Id']) 
				{ 
					$Combo .= "selected" ;
				}
				$Combo .= ">" . $ResultArray[$i][$FieldToShow] . "</option>" ; 
			}
			$Combo .= "</select>" ;
			return $Combo ;
		}
		
		return "Combo not Creatd" ;
	}





/*******************************************************
End Function to Create Combo
********************************************************/

	
	
}
?>
