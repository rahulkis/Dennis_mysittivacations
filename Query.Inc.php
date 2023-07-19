<?php
session_start();
$On = $_SERVER['HTTP_HOST'];
define('SITEROOT', $On);	
//define('PAYPAPOWNERID', 'merchant1315@gmail.com');	
define('PAYPAPOWNERID', 'mysitti@mysittidev.com');

/************************ FACEBOOK APP ID AND SECRET ID *************************/
//define('FBAPPID', '892188017512472');
//define('FBAPPSECRET', '9d3e9135ec1abd32dba6d53fc306751b');

define('FBAPPID', '1027910397223837');
define('FBAPPSECRET', '00175be1ff4053b4cb22bca7b51b947a');
/************************ FACEBOOK APP ID AND SECRET ID *************************/

ob_start();
$SessionId = session_id();
// error_reporting(E_ERROR|E_WARNING);
require_once("Run_Query.Inc.php");
include("emoji/php/autoload.php");
use Emojione\Client;
use Emojione\Ruleset;
$emojione = new Client(new Ruleset());
// ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
// ini_set('post_max_size', '256M'); 

//echo "<pre>"; print_r($_SESSION); 

// date_default_timezone_set('America/Chicago');

//$script_tz = date_default_timezone_get();
//
//if (strcmp($script_tz, ini_get('date.timezone'))){
//    echo 'Script timezone differs from ini-set timezone.';
//} else {
//    echo 'Script timezone and ini-set timezone match.';
//}




$city = @$_SESSION['city'];


class Query extends Run_Query
{
    function Query($DBName)
	{
	    $this->Run_Query($DBName);
	}
	


/*--Start , Function for Parameter Master Table--*/	

    //Get PArameter by PArameterName
    function ParameterValue($Name)
	{    
		$Result = $this->Select_Dynamic_Query('parameter',array('Value'),array('Name'),array('='),array($Name)) ; ;
		return $Result[0]['Value'] ;
	}

/*--Start , Function for Role Parameter Table--*/

/*--Start , Function for Any master table with Two Field Name and Id--*/	

    //Get Name by Id
    function MasterById($TableName,$Id)
	{    
		$Result = $this->Select_Dynamic_Query($TableName,array('Name'),array('Id'),array('='),array($Id)) ;
		return $Result[0]['Name'] ;
	}
	

	
	
    //Get Id by Name
    function MasterByName($TableName,$Val)
	{
		$Result = $this->Select_Dynamic_Query($TableName,array('Id'),array('Name'),array('='),array($Val)) ;
		//print_r($Result) ;
		return $Result[0]['Id'] ;
	}

/*--End , Function for Any master table with Two Field Name and Id--*/


/*--Start , Function to get Path for Category--*/	
    function GetPath($Id)
	{
	    $ParentId = $Id ;
		while($ParentId != 0)
		{
			$sql = "select * from `category` where `Id` = '$ParentId'" ; 
			//echo $sql ;
			$result = $this->select($sql) ;
			$CategoryName[] = $result[0]['Name'] ;   
			$CategoryId[] = $result[0]['Id'] ; 
			$ParentId = $result[0]['ParentId'] ;
            
		}
		
		$countCategoryId = count($CategoryId) ;
		for($i = $countCategoryId - 1 ; $i >= 0 ; $i--)
		{
		    if($i>0)
			{
				echo $CategoryName[$i] . " > " ;
			}
			else
			{
				echo $CategoryName[$i] ;
			}
		}

	}
	
/*--End , Function to Get path for Category--*/




	
/*--Start , Function to Create Bredcrum forCategory--*/	

    function BredCrum($Qstring,$Id)
	{
	    $ParentId = $Id ;
		while($ParentId != 0)
		{
			$sql = "select * from `category` where `Id` = '$ParentId'" ; 
			//echo $sql ;
			$result = $this->select($sql) ;
			$CategoryName[] = $result[0]['Name'] ;  
			$CategoryUrl[] = $result[0]['CategoryUrl'] ;
			$CategoryId[] = $result[0]['Id'] ; 
			$PId[] = $result[0]['ParentId'] ;
			$ParentId = $result[0]['ParentId'] ;
            
		}
		$CountCategoryId = count($CategoryId) ;
		for($i = $CountCategoryId - 1 ; $i >= 0 ; $i--)
		{
		    if($PId[$i] == 0)
			{
				$PageUrl = 'CategoryPage.php' ;
			}
			else
			{
				$PageUrl = 'PhotoFrames.php' ;
			}
		    echo " &raquo; " ;
?>
			
			<a href="<?php echo $PageUrl; ?>?CategoryLink=<?php echo $CategoryId[$i] . $Qstring ; ?>" class="AdverContentsOrange"><?php echo $CategoryName[$i] ; ?></a>
			
<?php
		}

	}
	
/*--End , Function to Create Bredcrum forCategory--*/		




	
/*-------------------------------------------------------------------------------
Start , Query for Select Record from table
-------------------------------------------------------------------------------*/	
//This Function Has Three Parameters 
//1. The Table Name from which data to be fetched	
//2. SelectFieldArray array of the Values to be fetched if blank then all field are fetched	
//3. WhereFieldArray array of the field name based on them , the Record is fetched 
//4. WhereSignArray Array of the comparision operator sign based on them the Record is fetched
//5. WherevalueArray Array of the Values needed for where clause based on them the Record is fetched
//6. LogicalArray Array of the Logical Operators placed b/w the conditions in Where clause
//7. OrderByFieldArray Array of the field name of the table based on them the record is sorted 
//8. OrderByArray Array has 'asc' or 'desc' for each field based on them the the record is sorted
//9. LimitArray Array has 'two' element 'startposition' and 'pagesize' for limit 
//10. ReturnWhat is the variable that hold two value if ReturnWhat = rr then return whole array 
//and if ReturnWhat == nr then return number of rows in Array record

	function Select_Dynamic_Query($TableName,$SelectFieldArray = "",$WhereFieldArray = "",$WhereSignArray = "",$WherevalueArray = "",$LogicalArray = "",$OrderByFieldArray = "",$OrderByArray = "",$LimitArray = "",$ReturnWhat = "rr")
	{
	    $CountSelectField = count($SelectFieldArray);
	    $CountWhereField = count($WhereFieldArray);
	    $CountWhereSign = count($WhereSignArray);
	    $CountWherevalue = count($WherevalueArray);
		if($LogicalArray != "")
		{
			$CountLogical = count($LogicalArray);    
		}
		else
		{
			$CountLogical = 0 ;
		}
		$CountLimit = count($LimitArray);
		$CountOrderByField = count($OrderByFieldArray);
		$CountOrderBy = count($OrderByArray);	 
	 
/*-------Start , Select and From Clause -------*/
	 	if($SelectFieldArray == "")
		{
			 $sql = "Select * from `$TableName`" ;
			
			
		}
		else
		{
		    $sql = "Select" ;
		    for($si=0;$si<$CountSelectField;$si++)
			{
			    if($si < $CountSelectField - 1)
				{
					$sql .= " `" . $SelectFieldArray[$si] . "` ," ;
				}
				else
				{
					$sql .= " `" . $SelectFieldArray[$si] ."`" ;
				}
			}
		    $sql .= " from `" . $TableName ."`" ;
		}	
		//echo "<br>".$sql; exit;	
/*-------End , Select and From Clause -------*/
		
	
/*-------Start , Where Clause if Where Related Array is not Empty-------*/		
		if(($WhereFieldArray != "") && ($WhereSignArray != "") && ($WherevalueArray != ""))
		{
		    if(($CountWhereField == $CountWhereSign) && ($CountWhereField == $CountWherevalue) && (($CountWhereField - 1) == $CountLogical))
			{ 
			    $sql .= " where" ;
			    for($wi=0;$wi<$CountWhereField;$wi++)
				{
				    if($wi < $CountWhereField - 1)
					{
			 			$sql .= " `" . $WhereFieldArray[$wi] . "` " . $WhereSignArray[$wi] . " '" . $WherevalueArray[$wi] . "' " . $LogicalArray[$wi] ;	
					}
					else
					{
				$sql .= " `" . $WhereFieldArray[$wi] . "` " . $WhereSignArray[$wi] . " '" . $WherevalueArray[$wi] . "'" ;
					}
				}
				
			}
			else
			{
			    die("Error in Where related Array Argument of Select_Dynamic Function on Page") ;
			}
		}
/*-------End , Where Clause if Where Related Array is not Empty-------*/


/*-------Start , Limit if OrderByFieldArray and OrderByArray is Not Empty-------*/
		if(($OrderByFieldArray != "") && ($OrderByArray != ""))
		{
		    if($CountOrderByField == $CountOrderBy)
			{
			    $sql .= " order by" ;
			    for($oi=0;$oi<$CountOrderBy;$oi++)
				{
				   if($oi < $CountOrderBy - 1)
				   {
					    $sql .= " `" . $OrderByFieldArray[$oi] . "` " . $OrderByArray[$oi] . "," ;
				   }
				   else
				   {
					   $sql .= " `" . $OrderByFieldArray[$oi] . "` " . $OrderByArray[$oi] ; 
				   }
				}
			}
			else
			{
			    die("Error in Order By Related Array ") ;
			}
		}
/*-------End , Limit if OrderByFieldArray and OrderByArray is Not Empty-------*/


/*-------Start , Limit if LimitArray is Not Empty-------*/
		if($LimitArray != "")
		{
		   $sql .= " limit " . $LimitArray[0] . "," . $LimitArray[1] ;
		}
/*-------End , Limit if LimitArray is Not Empty-------*/

		//echo "<br>" . $sql . "<br>" ;
		//echo $sql;
		$result = $this->select($sql);
		$CountRows = count($result) ;
		
		
		
		if($ReturnWhat == 'rr')
		{
			return $result;
		}
		else
		{
			return $CountRows;
		}
	}
	
	
	
/*-------------------------------------------------------------------------------
End , Query for Updating data into Table By Id
-------------------------------------------------------------------------------*/






	
/*-------------------------------------------------------------------------------
Start , Query for Updating data into Table By Id
-------------------------------------------------------------------------------*/	
//This Function Has Three Parameters 
//1. The Table Name in which data to be inserted	
//2. the array of the values to be inserted	
//3. The array of the field name in the table in 
//   which the value is to be inserted

	function Update_Dynamic_Query($TableName,$ValueArray,$FieldArray,$Field,$Id)
	{
	    $CountField = count($FieldArray);
	    $CountValue = count($ValueArray);
		if($CountField == $CountValue)	
		{
		    $sql = "update `$TableName` set ";
			
		    for($fi=0;$fi<$CountField;$fi++)
			{
			    if($fi == $CountField-1)
				{
					$sql .= "`" . $FieldArray[$fi] . "` = ";
					$sql .= "'" . $ValueArray[$fi] . "'";	
				}
				else
				{
					$sql .= "`" . $FieldArray[$fi] . "` = ";
					$sql .= "'" . $ValueArray[$fi] . "',";	
				}
			}
			
		     $sql .= " where `$Field` = '$Id'";  
			
			$result = $this->update($sql);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function Update_Dynamic_Query1($TableName,$ValueArray,$FieldArray,$Id)
	{
	    $CountField = count($FieldArray);
	    $CountValue = count($ValueArray);
		if($CountField == $CountValue)	
		{
		    $sql = "update `$TableName` set ";
			
		    for($fi=0;$fi<$CountField;$fi++)
			{
			    if($fi == $CountField-1)
				{
					$sql .= "`" . $FieldArray[$fi] . "` = ";
					$sql .= "'" . $ValueArray[$fi] . "'";	
				}
				else
				{
					$sql .= "`" . $FieldArray[$fi] . "` = ";
					$sql .= "'" . $ValueArray[$fi] . "',";	
				}
			}
			
		    $sql .= " where `Id` = '$Id'";
			//"<br>" . $sql . "<br>";
			$result = $this->update($sql);
			return $result;
		}
		else
		{
			return false;
		}
	}
/*-------------------------------------------------------------------------------
End , Query for Updating data into Table By Id
-------------------------------------------------------------------------------*/	

	
/*-------------------------------------------------------------------------------
Start , Query for Insertig data into Table
-------------------------------------------------------------------------------*/	
//This Function Has Three Parameters 
//1. The Table Name in which data to be inserted	
//2. the array of the values to be inserted	
//3. The array of the field name in the table in 
//   which the value is to be inserted

	function Insert_Dynamic_Query($TableName,$ValueArray,$FieldArray)
	{
	    $CountField = count($FieldArray);
	    $CountValue = count($ValueArray);
		
		if($CountField == $CountValue)	
		{
		    $sql = "insert into `$TableName` (";
			
		    for($fi=0;$fi<$CountField;$fi++)
			{
			    if($fi == $CountField-1)
				{
					$sql .= "`" . $FieldArray[$fi] . "`";	
				}
				else
				{
					$sql .= "`" . $FieldArray[$fi] . "`,";
				}
			}
			
		    $sql .= ") values (";
			
		    for($i=0;$i<$CountValue;$i++)
			{
			    if($i == $CountValue-1)
				{
					$sql .= "'" . $ValueArray[$i] . "'";	
				}
				else
				{
					$sql .= "'" . $ValueArray[$i] . "',";
				}
			}
		     $sql .= ")";
			 
			
			$result = $this->insert($sql);
			return $result;
			// return "success";
		}
		else
		{
			return mysql_error();
		}
	}
/*-------------------------------------------------------------------------------
End , Query for Insertig data into Table
-------------------------------------------------------------------------------*/	




/*-------------------------------------------------------------------------------
Start , Function for Deleting a Record from a table
-------------------------------------------------------------------------------*/
//Parameters are 
//1. The Table Name from which the Field to be deleted
//2. The id of the field which is to be deleted

	function Delete_By_Id($TableName,$Id)
	{
		$sql = "delete from `$TableName` where `Id` = '$Id'";
		
		$result = $this->delete($sql);
		return $result;
	}
	
		function Delete_records($TableName,$field,$Id)
	{
		$sql = "delete from `$TableName` where ".$field." = '$Id'";
		
		$result = $this->delete($sql);
		return $result;
	}
	function delmultiple($TableName,$field,$Id)
	{
	   $sql = "delete from `$TableName` where ".$field." IN($Id)";
		$q=mysql_query($sql);
		return $q;
	}
	
	
	
	function link($title)
	{
		$link = $title;
		$link = strtolower($link);
		$link = str_replace(' ','',$link);
		$link = str_replace('/','-',$link);
		$link = str_replace('\'','-',$link);
		$link = str_replace('"','-',$link);
		$link = str_replace('&','-',$link);
		$link = str_replace(',','-',$link);	
		$link = str_replace('@','-',$link);
		$link = str_replace('%','-',$link);
		$link = str_replace('$','-',$link);
		$link = str_replace('#','-',$link);
		$link = str_replace('*','-',$link);
		$link = str_replace('(','-',$link);
		$link = str_replace(')','-',$link);
		$link = str_replace('!','-',$link);
		$link = str_replace('~','-',$link);
		$link = str_replace('`','-',$link);
		$link = str_replace('^','-',$link);
		$link = str_replace('_','-',$link);
		$link = str_replace('=','-',$link);
		$link = str_replace('+','-',$link);
		$link = str_replace('?','-',$link);
		$link = str_replace(':','-',$link);
		$link = str_replace(';','-',$link);
		$link = str_replace('<','-',$link);
		$link = str_replace('>','-',$link);
		$link = str_replace('[','-',$link);
		$link = str_replace(']','-',$link);
		$link = str_replace('|','-',$link);
		$link = str_replace('--','-',$link);
		$link = str_replace('--','-',$link);
		
		$link = trim($link , '');
		return $link;
	}
	
/*-------------------------------------------------------------------------------
End , Function for Deleting a Recoprd from a table
-------------------------------------------------------------------------------*/
	
}//End of Class


//echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;
//$myquery = @mysql_fetch_array("SELECT * FROM `user` WHERE  ");
if(isset($_SESSION['keepmelogin']))
{
	if($_SESSION['keepmelogin'] == "1")
	{
		ob_start();
		setcookie("loggedinuserID", $_SESSION['user_id'],time() + (10 * 365 * 24 * 60 * 60) );
		setcookie("loggedinuserType", $_SESSION['user_type'],time() + (10 * 365 * 24 * 60 * 60) );
		ob_end_clean();
	}
}
/*else
{
	if(isset($_COOKIE['loggedinuserID']) )
	{
		if($_COOKIE['loggedinuserType'] == 'user')
		{
			$myquery  = @mysql_query("SELECT * FROM `user` WHERE `id` = '".$_COOKIE['loggedinuserID']."' ");
			$ftechuser = @mysql_fetch_array($myquery);
			echo "<pre>";print_r($ftechuser); die;
		}
		
	}
}*/

/* function added on Feb 26,2014 by Kbihm */

function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

include("helper_functions.php");
?>
