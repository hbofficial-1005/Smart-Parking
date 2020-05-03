<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	require 'connection.php';
	freeSpot();
}

function freeSpot()
{
	global $connect;
	$query = "SELECT * from spot";
	$result = mysqli_query($connect,$query);
	$number_of_rows = mysqli_num_rows($result);
	$spot=$_POST["spot"];
	$user=$_POST["user"];
	$sql;
	while($row = $result->fetch_assoc())
	{
		if($user == '1')
		{
		    if($spot == '6' AND $row["booked_by"] == 1)
		    {
		    	$id = $row["id"];
		    	$sql = "UPDATE spot SET status=0,booked_by=0 WHERE spot='$id'";
		    	echo json_encode(array("status" => "1"));
		    }
		    else
		    {
		    	echo json_encode(array("status" => "1"));
		    }	
		}
		
	}    
    mysqli_query($connect,$sql) or die(mysqli_error($connect));
    mysqli_close($connect);
}