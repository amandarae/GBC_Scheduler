<?php
	include('partials/_dbinfo.inc.php');

	function sendResponse($json){
	    $response = json_encode( $json );
	    echo $response;
	}

	/*****USER TABLE*****/

	//GET
	if(isset($_POST['userID']))
	{
		$uID = $_POST['userID'];
		$json=array();
		$sql="SELECT * FROM user_t WHERE employee_id= " . $uID;
	    $result=mysql_query($sql);

	    while($row = mysql_fetch_assoc($result))  
	    {
		    $teacher = array(
		    	'id' => $row['employee_id'],
		        'first' => $row['first_name'],
		        'last' => $row['last_name'],
		        'user' => $row['username'],
		        'pass' => $row['password']
		    );
		    array_push($json, $teacher);
		}

		sendResponse($json);
	}

	//DELETE
	if(isset($_POST['deleteUser']))
	{
		$uID = $_POST['deleteUser'];
		$sql="DELETE FROM user_t WHERE employee_id= " . $uID;
	    $result=mysql_query($sql);
	    sendResponse($result);
	}

	//ADD & EDIT
	if(isset($_POST['addUser']) || isset($_POST['editUser'])) 
	{
	   	$errors = array();
	   	if (!isset($_POST['fName']) || trim($_POST['fName'])==='')
			array_push($errors,"Please enter a value for First Name");
		else
	   		$fName = filter_var(trim($_POST['fName']), FILTER_SANITIZE_STRING); 
	    if (!isset($_POST['lName']) || trim($_POST['lName'])==='')
			array_push($errors,"Please enter a value for Last Name");
		else
	   		$lName = filter_var(trim($_POST['lName']), FILTER_SANITIZE_STRING); 
	   	if (!isset($_POST['uName']) || trim($_POST['uName'])==='')
			array_push($errors,"Please enter a value for User Name");
		else
	   		$uName = filter_var(trim($_POST['uName']), FILTER_SANITIZE_STRING); 
	   	if (!isset($_POST['pass']) || trim($_POST['pass'])==='')
			array_push($errors,"Please enter a value for Password");
		else
	   		$pass = trim($_POST['pass']);
	   	if(isset($_POST['addUser'])){
		   	if(empty($errors)){
		   		$sql = "INSERT INTO user_t (first_name, last_name, username, password) VALUES ('$fName', '$lName', '$uName', '$pass')";
		   		$result = mysql_query($sql);
				if (!$result) 
	    			die('Invalid query: ' . mysql_error());
			   	header("location: teachers.php");
		   	}
		   	else{
		   		session_start();
		   		 $_SESSION['errors'] = $errors;
		   		 header("location: add.php?teacher");
		   	}
		}
		if(isset($_POST['editUser'])){
			if(empty($errors)){
				$uID = $_POST['editUser'];
				$sql="UPDATE user_t SET first_name='$fName', last_name='$lName', username='$uName', password='$pass' WHERE employee_id=$uID";
		   		$result = mysql_query($sql);
		   		if (!$result) 
	    			sendResponse( mysql_error());
	    		else
		   		sendResponse($result);
			}
			else{
	   			session_start();
	   		 	$_SESSION['errors'] = $errors;
	   		}
		}
	}

	/*****SECTION TABLE*****/

	//GET
	if(isset($_POST['sectionID']))
	{
		$sID = $_POST['sectionID'];
		$json=array();
		$sql="SELECT * FROM section_t WHERE section_id= " . $sID;
	    $result=mysql_query($sql);

	    while($row = mysql_fetch_assoc($result))  
	    {
		    $section = array(
		    	'id' => $row['section_id'],
		        'name' => $row['section_name'],
		        'desc' => $row['section_desc'],
		        'size' => $row['section_size']
		    );
		    array_push($json, $section);
		}

		sendResponse($json);
	}

	//DELETE
	if(isset($_POST['deleteSection']))
	{
		$sID = $_POST['deleteSection'];
		$sql="DELETE FROM section_t WHERE section_id= " . $sID;
	    $result=mysql_query($sql);
	    sendResponse($result);
	}

	//ADD & EDIT
	if(isset($_POST['addSection']) || isset($_POST['editSection'])) 
	{
	   	$errors = array();
	   	if (!isset($_POST['name']) || trim($_POST['name'])==='')
			array_push($errors,"Please enter a value for Section Name");
		else
	   		$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING); 
	    if (!isset($_POST['desc']) || trim($_POST['desc'])==='')
			array_push($errors,"Please enter a value for Section Description");
		else
	   		$desc = filter_var(trim($_POST['desc']), FILTER_SANITIZE_STRING); 
	   	if (!isset($_POST['size']) || trim($_POST['size'])==='' || !is_numeric($_POST['size']))
			array_push($errors,"Please enter a numeric value for Section Size");
		else
	   		$size = trim($_POST['size']); 
	   	if(isset($_POST['addSection'])){
		   	if(empty($errors)){
		   		$sql = "INSERT INTO section_t (section_name,section_desc,section_size) VALUES ('$name', '$desc', $size)";
		   		$result = mysql_query($sql);
				if (!$result) 
	    			die('Invalid query: ' . mysql_error());
			   	header("location: sections.php");
		   	}
		   	else{
		   		session_start();
		   		 $_SESSION['errors'] = $errors;
		   		 header("location: add.php?section");
		   	}
		}
		if(isset($_POST['editSection'])){
			if(empty($errors)){
				$sID = $_POST['editSection'];
				$sql="UPDATE section_t SET section_name='$name', section_desc='$desc', section_size=$size WHERE section_id=$sID";
		   		$result = mysql_query($sql);
		   		if (!$result) 
	    			sendResponse( mysql_error());
	    		else
		   		sendResponse($result);
			}
			else{
	   			session_start();
	   		 	$_SESSION['errors'] = $errors;
	   		}
		}
	}

/*****COURSE TABLE*****/

	//GET
	if(isset($_POST['courseID']))
	{
		$cID = $_POST['courseID'];
		$json=array();
		$sql="SELECT * FROM course_t WHERE course_crn='$cID'";
	    $result=mysql_query($sql);

	    while($row = mysql_fetch_assoc($result))  
	    {
		    $course = array(
		    	'crn' => $row['course_crn'],
		        'desc' => $row['course_desc'],
		        'code' => $row['course_code']
		    );
		    array_push($json, $course);
		}

		sendResponse($json);
	}

	//DELETE
	if(isset($_POST['deleteCourse']))
	{
		$cID = $_POST['deleteCourse'];
		$sql="DELETE FROM course_t WHERE course_crn='$cID'";
	    $result=mysql_query($sql);
	    sendResponse($result);
	}

	//ADD & EDIT
	if(isset($_POST['addCourse']) || isset($_POST['editCourse'])) 
	{
	   	$errors = array();
	   	if (!isset($_POST['crn']) || trim($_POST['crn'])==='' || !is_numeric($_POST['crn']))
			array_push($errors,"Please enter a numeric value for Course CRN");
		else
	   		$crn = trim($_POST['crn']); 
	    if (!isset($_POST['desc']) || trim($_POST['desc'])==='')
			array_push($errors,"Please enter a value for Course Description");
		else
	   		$desc = filter_var(trim($_POST['desc']), FILTER_SANITIZE_STRING); 
	   	if (!isset($_POST['code']) || trim($_POST['code'])==='')
			array_push($errors,"Please enter a value for Course Code");
		else
	   		$code = filter_var(trim($_POST['code']), FILTER_SANITIZE_STRING); 
	   	if(isset($_POST['addCourse'])){
		   	if(empty($errors)){
		   		$sql = "INSERT INTO course_t (course_crn, course_desc, course_code) VALUES ($crn, '$desc', '$code')";
		   		$result = mysql_query($sql);
				if (!$result) 
	    			die('Invalid query: ' . mysql_error());
			   	header("location: courses.php");
		   	}
		   	else{
		   		session_start();
		   		 $_SESSION['errors'] = $errors;
		   		 header("location: add.php?course");
		   	}
		}
		if(isset($_POST['editCourse'])){
			if(empty($errors)){
				$cID = $_POST['editCourse'];
				$sql="UPDATE course_t SET course_crn=$crn, course_desc='$desc', course_code='$code' WHERE course_crn='$cID'";
		   		$result = mysql_query($sql);
		   		if (!$result) 
	    			sendResponse( mysql_error());
	    		else
		   		sendResponse($result);
			}
			else{
	   			session_start();
	   		 	$_SESSION['errors'] = $errors;
	   		}
		}
	}

	/*****ROOM TABLE*****/

	//GET
	if(isset($_POST['roomID']))
	{
		$rID = $_POST['roomID'];
		$json=array();
		$sql="SELECT * FROM room_t WHERE room_id=$rID";
	    $result=mysql_query($sql);

	    while($row = mysql_fetch_assoc($result))  
	    {
		    $room = array(
		    	'id' => $row['room_id'],
		    	'size' => $row['room_size'],
		        'type' => $row['room_type'],
		        'number' => $row['room_number']
		    );
		    array_push($json, $room);
		}

		sendResponse($json);
	}

	//DELETE
	if(isset($_POST['deleteRoom']))
	{
		$rID = $_POST['deleteRoom'];
		$sql="DELETE FROM room_t WHERE room_id=$rID";
	    $result=mysql_query($sql);
	    sendResponse($result);
	}

	//ADD & EDIT
	if(isset($_POST['addRoom']) || isset($_POST['editRoom'])) 
	{
	   	$errors = array();
	   	if (!isset($_POST['size']) || trim($_POST['size'])==='' || !is_numeric($_POST['size']))
			array_push($errors,"Please enter a numeric value for Room Size");
		else
	   		$size = trim($_POST['size']); 
	    if (!isset($_POST['type']) || trim($_POST['type'])==='')
			array_push($errors,"Please enter a value for Room Type");
		else
	   		$type = filter_var(trim($_POST['type']), FILTER_SANITIZE_STRING); 
	   	if (!isset($_POST['number']) || trim($_POST['number'])==='')
			array_push($errors,"Please enter a value for Room Number");
		else
	   		$number = filter_var(trim($_POST['number']), FILTER_SANITIZE_STRING); 
	   	if(isset($_POST['addRoom'])){
		   	if(empty($errors)){
		   		$sql = "INSERT INTO room_t (room_size, room_type, room_number) VALUES ($size, '$type', '$number')";
		   		$result = mysql_query($sql);
				if (!$result) 
	    			die('Invalid query: ' . mysql_error());
			   	header("location: rooms.php");
		   	}
		   	else{
		   		session_start();
		   		 $_SESSION['errors'] = $errors;
		   		 header("location: add.php?room");
		   	}
		}
		if(isset($_POST['editRoom'])){
			if(empty($errors)){
				$rID = $_POST['editRoom'];
				$sql="UPDATE room_t SET room_size=$size, room_type='$type', room_number='$number' WHERE room_id=$rID";
		   		$result = mysql_query($sql);
		   		if (!$result) 
	    			sendResponse( mysql_error());
	    		else
		   		sendResponse($result);
			}
			else{
	   			session_start();
	   		 	$_SESSION['errors'] = $errors;
	   		}
		}
	}

	/*****SCHEDULE TABLE*****/

	//GET
	// if(isset($_POST['roomID']))
	// {
	// 	$rID = $_POST['roomID'];
	// 	$json=array();
	// 	$sql="SELECT * FROM room_t WHERE room_id=$rID";
	//     $result=mysql_query($sql);

	//     while($row = mysql_fetch_assoc($result))  
	//     {
	// 	    $room = array(
	// 	    	'id' => $row['room_id'],
	// 	    	'size' => $row['room_size'],
	// 	        'type' => $row['room_type'],
	// 	        'number' => $row['room_number']
	// 	    );
	// 	    array_push($json, $room);
	// 	}

	// 	sendResponse($json);
	// }

	//DELETE
	// if(isset($_POST['deleteRoom']))
	// {
	// 	$rID = $_POST['deleteRoom'];
	// 	$sql="DELETE FROM room_t WHERE room_id=$rID";
	//     $result=mysql_query($sql);
	//     sendResponse($result);
	// }

	//ADD & EDIT
	if(isset($_POST['addSchedule']) || isset($_POST['editSchedule'])) 
	{
	   	$day = trim($_POST['day']); 
	   	$start = trim($_POST['start']).':00'; 
	   	$end = trim($_POST['end']).':00'; 
	   	$crn = trim($_POST['crn']); 
	   	$room = trim($_POST['room']); 
	   	$teacher = trim($_POST['teacher']); 
	   	$section = trim($_POST['section']); 
	   	$semester = trim($_POST['semester']); 

	   	if(isset($_POST['addSchedule'])){
		   		$sql = "INSERT INTO schedule_t (day, startTime, endTime, course_crn, room_id, teacher_id, section_id, semester_id) VALUES ('$day', '$start', '$end', $crn, $room, $teacher, $section, $semester)";
		   		$result = mysql_query($sql);
				if (!$result) 
	    			sendResponse( mysql_error());
			   	else
			   		sendResponse($result);
		}
		// if(isset($_POST['editSchedule'])){
		// 	if(empty($errors)){
		// 		$rID = $_POST['editRoom'];
		// 		$sql="UPDATE room_t SET room_size=$size, room_type='$type', room_number='$number' WHERE room_id=$rID";
		//    		$result = mysql_query($sql);
		//    		if (!$result) 
	 //    			sendResponse( mysql_error());
	 //    		else
		//    		sendResponse($result);
		// 	}
		// 	else{
	 //   			session_start();
	 //   		 	$_SESSION['errors'] = $errors;
	 //   		}
		// }
	}
?>


