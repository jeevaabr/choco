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
print <<<ENDBLOCK
    <h2>$params[1] $params[3], You have successfully enrolled $params[17] for Happy days summer camp</h2>
    
    <h3>Enrollment details</h3>
    <table>
        <tr>
            <td>Name</td>
            <td>$params[17] $params[18] $params[19]</td>
        </tr>
        <tr>
            <td>Nick Name</td>
            <td>$params[20]</td>
        </tr>
         <tr>
            <td>Photo</td>
            <td><img src="imagix/$params[29]" width="50px" height="50px"></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td>$params[21]</td>
        </tr>
        <tr>
            <td>Date of Birth</td>
            <td>$params[22]</td>
        </tr>
        <tr>
            <td>$params[4] Name</td>
            <td>$params[1] $params[2] $params[3]</td>
        </tr>
        <tr>
            <td>Adress</td>
            <td>$params[5] $params[6]</td>
        </tr>
        <tr>
            <td>Phone Number</td>
            <td>$params[10] $params[11] $params[12]</td>
        </tr>
        <tr>
            <td>Email Id</td>
            <td>$params[16]</td>
        </tr>
         <tr>
            <td>Emergency Contact name</td>
            <td>$params[25]</td>
        </tr>
         <tr>
            <td>Emergency contact number</td>
            <td>$params[26] $params[27] $params[28]</td>
        </tr>
         <tr>
            <td>Medical condition</td>
            <td>$params[23]</td>
        </tr>
         <tr>
            <td>Dietary condition</td>
            <td>$params[24]</td>
        </tr>
        <tr>
            <td>Program</td>
            <td>
ENDBLOCK;
foreach ($params[0] as $value)
		{            
            echo "$value,";
            }
        
       echo '</td></tr>           
    </table>';                         

?>
</body></html>
