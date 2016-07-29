<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!--    Jeeva Abraham
		account:jadrn001
		project #3
-->
	<head>
		<title>sign up form</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/newsignup.css" />
		<script type="text/javascript" src="js/newsignup.js"></script>
	</head>
	<body>
	<div id="main">
		<div id="banner">
			<h1> Happy Days Summer Camp</h1>
		</div>
		<div id="mainnavigation">
			<div id="navigation">
				<ul>
					<li><a href="index.html">Home</a></li>
					<li><a href="newsignup.html">Signup Now</a></li>
				</ul>
			</div>
		</div>
	</div>
    <?php
      include('helpers.php');
      $db = get_db_handle();
      
	  // get the list of programs by querying program table
      $result = mysqli_query($db, 'SELECT description FROM program');
      if (!$result) {  
       $error = 'Error fetching description: ' . mysqli_error($db);  
       exit();  
      }
      while ($row = mysqli_fetch_array($result))  {  
       $programs[] = $row['description']; 
      }
	  
	  // create report for each programs
	  foreach ($programs as $program) {
		$sql = "select child.image_filename as ChildImage, child.first_name as ChildFName, child.last_name as ChildLName, child.nickname as ChildNName, child.birthdate as Cbirthdate, parent.first_name as ParentFName, parent.last_name as ParentLName, parent.primary_phone as PrimaryPhone, child.emergency_name as EmergencyContact, child.emergency_phone as EmergencyPhone from child join enrollment on child.id=enrollment.child_id join program on enrollment.program_id=program.id join parent on child.parent_id=parent.id where program.description = '$program'";
		$result = mysqli_query($db, $sql);
		
		// if entry exists for this program
		if ($result->num_rows > 0) {
		  echo "<div><h2>Children Enrolled for $program</h2></div>";
		  echo "<table><tr><th>Child Photo</th><th>Child Name</th><th>Preferred Name</th><th>Age</th><th>Parent/ Guardian Name</th><th>Primary Phone</th><th>Emergency Contact</th><th>Emergency Phone</th></tr>";
		  while($row = $result->fetch_assoc()) {
		    // calculate age
		    $childage = get_age($row["Cbirthdate"]);

		    echo "<tr><td><img src='imagix/".$row["ChildImage"]."' width='50px'  height ='50px' alt ='childimage'/></td><td>".$row["ChildFName"]." ".$row["ChildLName"]."</td><td>".$row["ChildNName"]."</td><td>".$childage."</td><td>".$row["ParentFName"]." ".$row["ParentLName"]."</td><td>".$row["PrimaryPhone"]."</td><td>".$row["EmergencyContact"]."</td><td>".$row["EmergencyPhone"]."</td></tr>";
		  }
		  echo "</table>";
		}
      }
	  mysqli_close($db);
    ?>
	</body>
</html>

