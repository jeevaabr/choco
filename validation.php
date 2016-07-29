<?php

function validate_data($params) { 
    $msg = "";
     
    if(count($params[0]) == 0)
        $msg .= "Please select atleast one program<br />";  
    if(strlen($params[1]) == 0)
        $msg .= "Please enter parent first name<br />"; 
    if(strlen($params[3]) == 0)
        $msg .= "Please enter parent last name<br />"; 
    if(strlen($params[4]) == 0)
        $msg .= "Please select relationship with child<br />";   
    if(strlen($params[5]) == 0)
        $msg .= "Please enter adress<br />"; 
    if(strlen($params[7]) == 0)
        $msg .= "Please enter city<br />";  
	if(strlen($params[8]) == 0)
        $msg .= "Please select a state<br />"; 
    if(strlen($params[9]) == 0){
        $msg .= "Please enter zip code<br />";
    }elseif((strlen($params[9]) != 5) || (!is_numeric($params[9]))){ 
        $msg .= "Zip code may contain exact 5 numeric digits<br />";
    }
    if((strlen($params[10]) == 0) && (strlen($params[11]) == 0) && (strlen($params[12]) == 0))
        $msg .= "Please enter phone number<br />";
    elseif(((!is_numeric($params[10])) || (strlen($params[10]) != 3)) || ((!is_numeric($params[11])) || (strlen($params[11]) != 3)) || ((!is_numeric($params[12])) || (strlen($params[12]) != 4)))
        $msg .= "Please enter a valid phone number<br />";
    if((!strlen($params[13]) == 0) && (!strlen($params[14]) == 0) && (!strlen($params[15]) == 0))
    {if((!is_numeric($params[13])) || (strlen($params[13]) != 3) || (!is_numeric($params[14])) || (strlen($params[14]) != 3) || (!is_numeric($params[15])) || (strlen($params[15]) != 4))
        $msg .= "Please enter a valid cell phone number<br />";}
    if(strlen($params[16]) == 0)
        $msg .= "Please enter email<br />";
    elseif(!filter_var($params[16], FILTER_VALIDATE_EMAIL))
        $msg .= "Please enter a valid email id<br/>"; 
    if(strlen($params[17]) == 0)
        $msg .= "Please enter Child first name<br />"; 
    if(strlen($params[19]) == 0)
        $msg .= "Please enter child last name<br />"; 
    if (strlen($params[21]) == 0)  
       	$msg .= "Please select gender<br />"; 
    $check_date = $params[22];
	$date_arr  = explode('/', $check_date);
	if(strlen($params[22]) == 0)
        $msg .= "Please enter date of birth<br />";
    elseif(!checkdate($date_arr[0], $date_arr[1], $date_arr[2]))
   		{$msg .= "Please enter a valid date <br />"; }
    else{
    	$age = age_calculator($params[22]);
    	
    	if(($age < 7) || ($age > 16))
    	{$msg .= "Sorry your child is not in the age limit:(7-16 years as of June 1st 2016)<br />";
    	}	
    	}
    if(strlen($params[25]) == 0)
        $msg .= "Please enter emergency contact name<br />";
    if((strlen($params[26]) == 0) && (strlen($params[27]) == 0) && (strlen($params[28]) == 0))
        $msg .= "Please enter emergency contact number<br />";
    elseif((!is_numeric($params[26])) || (strlen($params[26]) != 3) || (!is_numeric($params[27])) || (strlen($params[27]) != 3) || (!is_numeric($params[28])) || (strlen($params[28]) != 4))
        $msg .= "Please enter a valid emergency contact number<br />";
    
 //image upload
    $UPLOAD_DIR = 'imagix';
    $COMPUTER_DIR = '/home/jadrn001/public_html/proj3/imagix/';
    $filename = $_FILES['photo']['name'];

    if(file_exists("$UPLOAD_DIR".$filename))  {
        $msg .= "Error, the file $filename already exists on the server<br />";
        }
    elseif($_FILES['photo']['error'] > 0) {
    	$err = $_FILES['photo']['error'];	
        $msg .= "Error Code: $err <br />";
	if($err == 1)
		$msg .= "The file was too big to upload, the limit is 2MB<br />";
        } 
    elseif(exif_imagetype($_FILES['photo']['tmp_name']) != IMAGETYPE_JPEG) {
        $msg .= "ERROR, not a jpg file<br />";   
        }
## file is valid, copy from /tmp to your directory.        
    else { 
        move_uploaded_file($_FILES['photo']['tmp_name'], "$UPLOAD_DIR/".$filename);
    	}

    if($msg) {
        write_form_error_page($msg,$params);
        exit;
        }
    
    }
function age_calculator($check_date)
	{
	$date_arr  = explode('/', $check_date);
	$dob = $date_arr[2].'-'.$date_arr[0].'-'.$date_arr[1];
	if(!empty($dob)){
        $birthdate = new DateTime($dob);
        $deadline = '2016-06-01';
        $deadlinedate = new DateTime($deadline);
        $age = $birthdate->diff($deadlinedate);
        return $age->y;
    }else{
        return 0;
    	}
	}
  

function write_form_error_page($msg,$params) {
    write_header();
    echo "<h2>Sorry, an error occurred<br />",
    $msg,"</h2>";
    write_form($params);
    write_footer();
    }  
function write_form($params) {
    print <<<ENDBLOCK
	<form name="personal_info" 
		onsubmit="return validate_form()"
            action="process_request.php"
              method="post" enctype="multipart/form-data">
        <fieldset>
        	<legend>Select program</legend>
        	<p>Please select at least one program</p>
        	<p>
ENDBLOCK;

       	
			echo '<input type="checkbox" name="program[]" id="basketball" value="basketball camp"'.(in_array("basketball camp",$params[0])?"checked":"").'>
			
				<label for="basketball_camp">Basketball camp</label>
				<input type="checkbox" name="program[]" id="baseball" value="baseball camp"'.(in_array("baseball camp",$params[0])?"checked":"").' >
				<label for="baseball_camp">Baseballball camp</label>
				<input type="checkbox" name="program[]"  id="physical"value="physical training"'.(in_array("physical training",$params[0])?"checked":"").' >
				<label for="physical_training">Physical training</label>
				<input type="checkbox" name="program[]" id="band" value="band camp"'.(in_array("band camp",$params[0])?"checked":"").' >
				<label for="band_camp">Band camp</label>
				<input type="checkbox" name="program[]" id="swimming" value="swimming"'.(in_array("swimming",$params[0])?"checked":"").' >
				<label for="swimming">Swimming</label>
				<input type="checkbox" name="program[]"  id="nature" value="nature discovery"'.(in_array("nature discovery",$params[0])?"checked":"").' >
				<label for="nature_discovery">Nature discovery</label>';
		print <<<ENDBLOCK
		</p>
		</fieldset>
		<fieldset>
			<legend>Parent/guardian Information</legend>
        	<ul>
           		 <li><label>First Name<span class="required">*</span></label>
               	 <input type="text" name="parent_fname" value="$_POST[parent_fname]" size="25" 
                    onfocus="has_focus(1);" onblur="clear_border(1)" />
            	 <label>Middle Name</label>
              	  <input type="text" name="parent_mname" value="$_POST[parent_mname]" size="25" 
                    />                     
           		 <label>Last Name<span class="required">*</span></label>
              	  <input type="text" name="parent_lname" value="$_POST[parent_lname]" size="25" 
                    onfocus="has_focus(2);" onblur="clear_border(2)" /></li>
                    <li><span>Relationship to child<span class="required">*</span></span>
ENDBLOCK;
				if($_POST['relationship'] == "Father"){
				
			echo '<input type="radio" name="relationship" id="Father" value="Father" checked >
				<label for="relationship[]">Father</label>
				<input type="radio" name="relationship" id="Mother" value="Mother" >
				<label for="relationship[]">Mother</label>
				<input type="radio" name="relationship"id="Guardian" value="Guardian">
				<label for="relationship[]">Guardian</label></li> ';}
				
				elseif($_POST['relationship'] == "Mother"){
				
			echo '<input type="radio" name="relationship" id="Father" value="Father"  >
				<label for="relationship[]">Father</label>
				<input type="radio" name="relationship" id="Mother" value="Mother" checked >
				<label for="relationship[]">Mother</label>
				<input type="radio" name="relationship"id="Guardian" value="Guardian">
				<label for="relationship[]">Guardian</label></li> ';}
				
				elseif($_POST['relationship'] == "Guardian"){
				
				echo '<input type="radio" name="relationship" id="Father" value="Father"  >
				<label for="relationship[]">Father</label>
				<input type="radio" name="relationship" id="Mother" value="Mother"  >
				<label for="relationship[]">Mother</label>
				<input type="radio" name="relationship"id="Guardian" value="Guardian" checked >
				<label for="relationship[]">Guardian</label></li> ';}
				else {
				echo '<input type="radio" name="relationship" id="Father" value="Father"  >
				<label for="relationship[]">Father</label>
				<input type="radio" name="relationship" id="Mother" value="Mother"  >
				<label for="relationship[]">Mother</label>
				<input type="radio" name="relationship"id="Guardian" value="Guardian" >
				<label for="relationship[]">Guardian</label></li> ';}

echo '<li><label>Address line1<span class="required">*</span></label>
                <input type="text" name="address1" value="'.$_POST[address1].'" size="30" 
                    onfocus="has_focus(4);" onblur="clear_border(4)" />
                    <label>Address line2</label>
                <input type="text" name="address2" value="'.$_POST[address2].'" size="30" 
                    /></li>        
           		 <li><label>City<span class="required">*</span></label>
                <input type="text" name="city" value="'.$_POST[city].'" size="25" 
                    onfocus="has_focus(5);" onblur="clear_border(5)" /> 
              	  <label>State<span class="required">*</span></label>
                    <select name="state"  onfocus="has_focus(6);" onblur="clear_border(6)">
                    <option value="nada">Select State</option>
                    <option value="AL"'.($_POST[state]=="AL"?"selected":"").'>Alabama</option>
					  <option value="AK"'.($_POST[state]=="AK"?"selected":"").' >Alaska</option>
					  <option value="AZ"'.($_POST[state]=="AZ"?"selected":"").' >Arizona</option>
					  <option value="AR"'.($_POST[state]=="AR"?"selected":"").' >Arkansas</option>
					  <option value="CA"'.($_POST[state]=="CA"?"selected":"").' >California</option>
					  <option value="CO" '.($_POST[state]=="CO"?"selected":"").'>Colorado</option>
					  <option value="CT" '.($_POST[state]=="CT"?"selected":"").'>Connecticut</option>
					  <option value="DE" '.($_POST[state]=="DE"?"selected":"").'>Delaware</option>
					  <option value="DC" '.($_POST[state]=="DC"?"selected":"").'>Dist of Columbia</option>
					  <option value="FL" '.($_POST[state]=="FL"?"selected":"").'>Florida</option>
					  <option value="GA" '.($_POST[state]=="GA"?"selected":"").'>Georgia</option>
					  <option value="HI" '.($_POST[state]=="HI"?"selected":"").'>Hawaii</option>
					  <option value="ID" '.($_POST[state]=="ID"?"selected":"").'>Idaho</option>
					  <option value="IL" '.($_POST[state]=="IL"?"selected":"").'>Illinois</option>
					  <option value="IN" '.($_POST[state]=="IN"?"selected":"").'>Indiana</option>
					  <option value="IA" '.($_POST[state]=="IA"?"selected":"").'>Iowa</option>
					  <option value="KS" '.($_POST[state]=="KS"?"selected":"").'>Kansas</option>
					  <option value="KY" '.($_POST[state]=="KY"?"selected":"").'>Kentucky</option>
					  <option value="LA" '.($_POST[state]=="LA"?"selected":"").'>Louisiana</option>
					  <option value="ME" '.($_POST[state]=="ME"?"selected":"").'>Maine</option>
					  <option value="MD" '.($_POST[state]=="MD"?"selected":"").'>Maryland</option>
					  <option value="MA" '.($_POST[state]=="MA"?"selected":"").'>Massachusetts</option>
					  <option value="MI" '.($_POST[state]=="MI"?"selected":"").'>Michigan</option>
					  <option value="MN" '.($_POST[state]=="MN"?"selected":"").'>Minnesota</option>
					  <option value="MS" '.($_POST[state]=="MS"?"selected":"").'>Mississippi</option>
					  <option value="MO" '.($_POST[state]=="MO"?"selected":"").'>Missouri</option>
					  <option value="MT" '.($_POST[state]=="MT"?"selected":"").'>Montana</option>
					  <option value="NC" '.($_POST[state]=="NC"?"selected":"").'>North Carolina</option>
					  <option value="NE" '.($_POST[state]=="NE"?"selected":"").'>Nebraska</option>
					  <option value="NV" '.($_POST[state]=="NV"?"selected":"").'>Nevada</option>
					  <option value="NH" '.($_POST[state]=="NH"?"selected":"").'>New Hampshire</option>
					  <option value="NJ" '.($_POST[state]=="NJ"?"selected":"").'>New Jersey</option>
					  <option value="NM" '.($_POST[state]=="NM"?"selected":"").'>New Mexico</option>
					  <option value="NY" '.($_POST[state]=="NY"?"selected":"").'>New York</option>
					  <option value="ND" '.($_POST[state]=="ND"?"selected":"").'>North Dakota</option>
					  <option value="OH" '.($_POST[state]=="OH"?"selected":"").'>Ohio</option>
					  <option value="OK" '.($_POST[state]=="OK"?"selected":"").'>Oklahoma</option>
					  <option value="OR" '.($_POST[state]=="OR"?"selected":"").'>Oregon</option>
					  <option value="PA" '.($_POST[state]=="PA"?"selected":"").'>Pennsylvania</option>
					  <option value="RI" '.($_POST[state]=="RI"?"selected":"").'>Rhode Island</option>
					  <option value="SC" '.($_POST[state]=="SC"?"selected":"").'>South Carolina</option>
					  <option value="SD" '.($_POST[state]=="SD"?"selected":"").'>South Dakota</option>
					  <option value="TN" '.($_POST[state]=="TN"?"selected":"").'>Tennessee</option>
					  <option value="TX" '.($_POST[state]=="TX"?"selected":"").'>Texas</option>
					  <option value="UT" '.($_POST[state]=="UT"?"selected":"").'>Utah</option>
					  <option value="VT" '.($_POST[state]=="VT"?"selected":"").'>Vermont</option>
					  <option value="VA" '.($_POST[state]=="VA"?"selected":"").'>Virginia</option>
					  <option value="WA" '.($_POST[state]=="WA"?"selected":"").'>Washington</option>
					  <option value="WV" '.($_POST[state]=="WV"?"selected":"").'>West Virginia</option>
					  <option value="WI" '.($_POST[state]=="WI"?"selected":"").'>Wisconsin</option>
					  <option value="WY" '.($_POST[state]=="WY"?"selected":"").'>Wyoming</option>
					</select>';
				print <<<ENDBLOCK
				<label>Zip<span class="required">*</span></label>
                <input type="text" name="zip" value="$_POST[zip]" size="5" maxlength="5" 
                    onfocus="has_focus(7);"  onblur="clear_border(7)" /></li>      
           		 <li><label>Home/main Phone<span class="required">*</span></label>
                (<input type="text" name="area_phone" value="$_POST[area_phone]" size="3" maxlength="3" 
                    onfocus="has_focus(8);" onblur="clear_border(8);" 
                    onkeyup="transfer_focus(8);" />)  &nbsp;&nbsp;
                 <input type="text" name="prefix_phone" value="$_POST[prefix_phone]" size="3" maxlength="3" 
                    onfocus="has_focus(9);" onblur="clear_border(9)" 
                    onkeyup="transfer_focus(9)" />&nbsp;-&nbsp;
                <input type="text" name="phone" value="$_POST[phone]" size="4" maxlength="4" 
                    onfocus="has_focus(10);" onblur="clear_border(10)" />
                    <label>cell Phone</label>
                (<input type="text" name="area_cellphone" value="$_POST[area_cellphone]" size="3" maxlength="3"
                  />)  &nbsp;-&nbsp;
                 <input type="text" name="prefix_cellphone" value="$_POST[prefix_cellphone]" size="3" maxlength="3"
                   /> &nbsp;-&nbsp;
                <input type="text" name="cellphone" value="$_POST[cellphone]" size="4" maxlength="4"
                  />
                    </li> 
            <li><label>EMail<span class="required">*</span></label>
                <input type="text" name="email" value="$_POST[email]" size="15" 
                    onfocus="has_focus(11);" onblur="clear_border(11)" /></li> </ul>
       </fieldset>
       <fieldset>
              <legend>Child Information</legend>
              <ul>
            <li><label>First Name<span class="required">*</span></label>
                <input type="text" name="child_fname" value="$_POST[child_fname]" size="25" 
                    onfocus="has_focus(12);" onblur="clear_border(12)" /> 
             <label>Middle Name</label>
                <input type="text" name="child_mname" value="$_POST[child_mname]" size="25" 
                     />                     
            <label>Last Name<span class="required">*</span></label>
                <input type="text" name="child_lname" value="$_POST[child_lname]" size="25" 
                    onfocus="has_focus(13);" onblur="clear_border(13)" /></li>
				<li><label>Nick Name</label>
                <input type="text" name="child_nname" value="$_POST[child_nname]" size="25" 
                  /></li>
                 <li><label >Child Photo</label>
			<input type="file" name="photo" id="photo" value="$_FILES[photo][name]" /> </li>
             <li><span>Gender<span class="required">*</span><span>
ENDBLOCK;
				if($_POST['gender'] == "Male"){
				
				echo '<input type="radio" name="gender" id="male" value="Male" class="short_label" checked>
				<label for="gender">Male</label>
				<input type="radio" name="gender" id="female" value="Female" class="short_label">
				<label for="gender">Female</label></li>';}
				
				elseif($_POST['gender'] == "Female") {
				
				echo '<input type="radio" name="gender" id="male" value="Male" class="short_label" >
				<label for="gender">Male</label>
				<input type="radio" name="gender" id="female" value="Female" class="short_label" checked>
				<label for="gender">Female</label></li>';}
				
				else {
				echo '<input type="radio" name="gender" id="male" value="Male" class="short_label" >
				<label for="gender">Male</label>
				<input type="radio" name="gender" id="female" value="Female" class="short_label" >
				<label for="gender">Female</label></li>';}
				
print <<<ENDBLOCK
<li><label for="date_of_birth">Date of birth<span class="required">*</span></label>
				<input type="text" name="date_of_birth" value="$_POST[date_of_birth]" id="date_of_birth" 
				onfocus="has_focus(15);" onblur="clear_border(15)"><span>mm/dd/yyyy<span></li> 
				<li><label for="medical_condition" >Medical Conditions</label>
				<textarea name="medical_condition" value="$_POST[medical_condition]" id="medical_condition" rows="5" cols="50" placeholder="Enter any medical conditions here ..."></textarea></li> 
				<li><label for="special_dietary">Special dietary requirements</label>
				<textarea name="special_dietary" value="$_POST[special_dietary]" id="special_dietary" rows="5" cols="50" placeholder="Enter any special dietary here..."></textarea></li>
				<li><label>Emergency Contact<span class="required">*</span></label>
                <input type="text" name="emergency_name" value="$_POST[emergency_name]" size="50" 
                    onfocus="has_focus(16);" onblur="clear_border(16)" />
                    <label>Phone number<span class="required">*</span></label>
                (<input type="text" name="emergency_area_phone" value="$_POST[emergency_area_phone]" size="3" maxlength="3" 
                    onfocus="has_focus(17);" onblur="clear_border(17);" 
                    onkeyup="transfer_efocus(17);" />)  &nbsp;-&nbsp;
                 <input type="text" name="emergency_prefix_phone" value="$_POST[emergency_prefix_phone]" size="3" maxlength="3" 
                    onfocus="has_focus(18);" onblur="clear_border(18)" 
                    onkeyup="transfer_efocus(18)" />&nbsp;-&nbsp;
                <input type="text" name="emergency_phone" value="$_POST[emergency_phone]" size="4" maxlength="4" 
                    onfocus="has_focus(19);" onblur="clear_border(19)" /></li>   
				    
           </ul>
      </fieldset>
        <div id="button_panel">  
            <input type="reset" value="Clear" class="button" id="reset"/>
            <input type="submit" value="Submit"  class="button" id="submit"/> 
            <h2 id="status"></h2>
        </div>              
</form>
ENDBLOCK;
}                        

function process_parameters() {
    global $bad_chars;
    $params = array();
    $params[] = $_POST['program'];
    $params[] = trim(str_replace($bad_chars, "",$_POST['parent_fname']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['parent_mname']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['parent_lname']));
    $params[] = $_POST['relationship'];
    $params[] = trim(str_replace($bad_chars, "",$_POST['address1']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['address2']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['city']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['state']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['zip']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['area_phone']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['prefix_phone']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['phone']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['area_cellphone']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['prefix_cellphone']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['cellphone']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['email']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['child_fname']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['child_mname']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['child_lname']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['child_nname']));
    $params[] = $_POST['gender'];
    $params[] = trim(str_replace($bad_chars, "",$_POST['date_of_birth']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['medical_condition']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['special_dietary']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['emergency_name']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['emergency_area_phone']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['emergency_prefix_phone']));
    $params[] = trim(str_replace($bad_chars, "",$_POST['emergency_phone']));
    $params[] = $_FILES['photo']['name'];
	
    return $params;
}


function store_data_in_db($params) {
 	$db = get_db_handle();
	 // inserting to parent table
 	$parent_id = 0;
 	$parent_phone=$_POST['area_phone']. '.' .$_POST['prefix_phone']. '.' .$_POST['phone'];
	$sql = "SELECT id from parent where primary_phone='$parent_phone';";
	$result = mysqli_query($db,$sql);
 	if(mysqli_num_rows($result) >0) {
   		$row = mysqli_fetch_array($result);
   		$parent_id = $row[0];
 	}
 	else{
  		$sql = "insert into parent(first_name,middle_name,last_name,address1,address2,city,state,zip,primary_phone,secondary_phone,email) values('$params[1]','$params[2]','$params[3]','$params[5]','$params[6]','$params[7]','$params[8]','$params[9]','$params[10].$params[11].$params[12]','$params[13].$params[14].$params[15]','$params[16]');";
  		mysqli_query($db,$sql);
  		$sql = "SELECT id from parent where primary_phone='$parent_phone';";
 		$result = mysqli_query($db,$sql);
  		$row = mysqli_fetch_array($result);
  		$parent_id = $row[0];
 	}
 
 // inserting to child table starts here   
 	$child_id = 0;
 	$cname=$_POST['child_fname'];
 	$sql = "SELECT id from child where parent_id=$parent_id and first_name='$cname';";
 	$result = mysqli_query($db,$sql);
 	if(mysqli_num_rows($result) >0) {
  		$row = mysqli_fetch_array($result);
  		$child_id = $row[0];
 	}
 	else{
 		$date_arr  = explode('/', $params[22]);
		$dob = $date_arr[2].'-'.$date_arr[0].'-'.$date_arr[1];
 		$insertbday = date("Y-m-d", strtotime($dob));
		// echo "$insertbday";
		$filename = $_FILES['photo']['name'];
  		$sql = "insert into child(parent_id,relation,first_name,middle_name,last_name,nickname,image_filename,gender,birthdate,conditions,diet,emergency_name,emergency_phone) values ('$parent_id','$params[4]','$params[17]','$params[18]','$params[19]','$params[20]','$filename','$params[21]','$insertbday','$params[23]','$params[24]','$params[25]','$params[26].$params[27].$params[28]');";

  			if (mysqli_query($db, $sql)) {
  			// echo "New child record created successfully";
  			} 
  			else {
  			// echo "Error: " . $sql . "<br>" . mysqli_error($db);
  			}
   
  		$sql = "SELECT id from child where parent_id=$parent_id and first_name='$cname';";
  		$result = mysqli_query($db,$sql);
  		$row = mysqli_fetch_array($result);
  		$child_id = $row[0];
 		}
 
 		// check for enrolled programs and insert to enrollment table 
 	$enrollment = 0;
 	$flag = 1;
	$program = $_POST['program'];
 	for($i = 0; $i < count($program); $i++) {
    	// get program_id here for child id
    	$result = mysqli_query($db, "select id from program where description = '$program[$i]'");
    	$program_id = mysqli_fetch_row($result);
    	$program_name = $program[$i];
    	// echo "<br> Program id for $program[$i] is $program_id[0]";
   
   		// validate if entry exists
   		$sql = "SELECT * from enrollment where program_id = '$program_id[0]' and child_id = $child_id;";
   		$result = mysqli_query($db,$sql);
   		if(mysqli_num_rows($result) >0) {
     		$row = mysqli_fetch_array($result);
     		$enrollment = 1;
     		$flag = 0;
     		break;
   		}
   
   // insert into enrollment table
  	 	else
   		{
    		$sql = "insert into enrollment(program_id,child_id) values ('$program_id[0]','$child_id');";
    		$result = mysqli_query($db,$sql);
    		$row = mysqli_fetch_array($result);
    
   		}
 	}
 	   		if($parent_id && $child_id && $enrollment)
       	{ $msg .= "DUPlicate entry your child already enrolled for $program_name<br/> ";}
		if($msg) {
        write_form_error_page($msg,$params);
        exit;
        }

 mysqli_close($db);
}
 
?>   
