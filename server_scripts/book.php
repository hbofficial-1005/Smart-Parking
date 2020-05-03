<?php
echo "This is book.php";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	require 'connection.php';
	createSpot();
}

function createSpot()
{
	global $connect;
	$query = "SELECT * from spot";
	$result = mysqli_query($connect,$query);
	$number_of_rows = mysqli_num_rows($result);
	$spot=$_POST["spot"];
	$user=$_POST["user"];
	while($row = $result->fetch_assoc())
	{
		if($user == '1')
		{
			if($spot == '1' AND $row["status"]== '0')
			{
				$sql = "UPDATE spot SET status=1,booked_by=1 WHERE spot='1'";
		    	echo json_encode(array("status" => "1"));
		    }
		    if($spot == '2' AND $row["status"]== '0')
			{
				$sql = "UPDATE spot SET status=1,booked_by=1 WHERE spot='2'";
		    	echo json_encode(array("status" => "1"));
		    }
		    if($spot == '3' AND $row["status"]== '0')
			{
				$sql = "UPDATE spot SET status=1,booked_by=1 WHERE spot='3'";
		    	echo json_encode(array("status" => "1"));
		    }
		    if($spot == '4' AND $row["status"]== '0')
			{
				$sql = "UPDATE spot SET status=1,booked_by=1 WHERE spot='4'";
		    	echo json_encode(array("status" => "1"));
		    }
		    if($spot == '5' AND $row["status"]== '0')
			{
				$sql = "UPDATE spot SET status=1,booked_by=1 WHERE spot='5'";
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