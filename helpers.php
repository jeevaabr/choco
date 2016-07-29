<?php

$bad_chars = array('$','%','?','<','>','php','{','}','//');

function check_post_only() {
if(!$_POST) {
    write_error_page("This script can only be called from a form.");
    exit;
    }
}

function get_db_handle() {
    $server = 'opatija.sdsu.edu:3306';
    $user = 'jadrn001';
    $password = 'orange';
    $database = 'jadrn001';
    
    if(!($db = mysqli_connect($server, $user, $password, $database))) {
        write_error_page("Cannot Connect!");
        }
    return $db;
    }

function write_error_page($msg) {
    write_header();
    echo "<h2>Sorry, an error occurred<br />",
    $msg,"</h2>";
    write_footer();
    }
    
function write_header() {

print <<<ENDBLOCK
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;
    charset=iso-8859-1" />
    <title>Sign up form confirmation</title>
<link rel="stylesheet" type="text/css" href="css/newsignup.css" />
    
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
ENDBLOCK;
}

function write_footer() {
    echo "</body></html>";
}

function get_age($check_date) {
 if(!empty($check_date)){
        $birthdate = new DateTime($check_date);
        $today = new DateTime();
        $age = $today->diff($birthdate);
        return $age->y;
    }else{
        return 0;
    }
}

?>
