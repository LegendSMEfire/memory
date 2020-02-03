<?php
	function required($form) 
	{
		foreach($form as $input) 
		{
			if(empty($input)) 
			{
				return false;
				break;
			}
		}
		return true;
	}
	
	
	function sql_request($request, bool $isData=false, bool $isSingle=false) 
	{
		$conn = mysqli_connect("localhost", "root", "","memory");
		$query = mysqli_query($conn, $request);
		
		if($isData)
		{
			if($isSingle) 
			{
				return mysqli_fetch_row($query);
			}
			else
			{
				return mysqli_fetch_all($query);
			}
		}
	}



?>