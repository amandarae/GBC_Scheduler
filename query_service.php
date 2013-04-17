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
		$errors = array();
		$uID = $_POST['deleteUser'];
		$sql="SELECT schedule_id FROM schedule_t WHERE teacher_id=$uID";
		$result=mysql_query($sql);
		if(mysql_num_rows($result) >=1){
			array_push($errors,"This teacher has been found in the schedule. Please reassign all classes that this teacher is scheduled for before deletion.");
			sendResponse($errors);
			exit;
		}
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
	   			//crn = 5 digit unique
				$sql = "SELECT course_crn FROM course_t WHERE course_crn=$crn";
		   		$result = mysql_query($sql);
		   	 	while ($row = mysql_fetch_assoc($result)) {
		   	 		$prevID = $row['course_crn'];
		   	 	}
		   		if(@$prevID){
		   			array_push($errors, "This course crn is already in use, please choose another one");
		   			session_start();
		   		 	$_SESSION['errors'] = $errors;
		   		 	header("location: add.php?course");
		   		 	exit;
		   		}
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

	/*****SEMESTER TABLE*****/

	//GET
	if(isset($_POST['semesterID']))
	{
		$sID = $_POST['semesterID'];
		$json=array();
		$sql="SELECT * FROM semester_t WHERE semester_id= " . $sID;
	    $result=mysql_query($sql);

	    while($row = mysql_fetch_assoc($result))  
	    {
		    $event = array(
		    	'id' => $row['semester_id'],
		        'year' => $row['year'],
		        'start' => $row['startDate'],
		        'end' => $row['endDate'],
		        'quarter' => $row['quarter'],
		    );
		    array_push($json, $event);
		}

		sendResponse($json);
	}

	//DELETE
	if(isset($_POST['deleteSemester']))
	{
		$sID = $_POST['deleteSemester'];
		$sql="DELETE FROM semester_t WHERE semester_id=$sID";
	    $result=mysql_query($sql);
	    sendResponse($result);
	}

	//ADD & EDIT
	if(isset($_POST['addSemester']) || isset($_POST['editSemester'])) 
	{
		$errors = array();
	   	$year = trim($_POST['year']); 
	   	$quarter = trim($_POST['quarter']); 
	   	$start = trim($_POST['start']); 
	   	$end = trim($_POST['end']); 

	   	if(isset($_POST['addSemester'])){
	   		$sql = "INSERT INTO semester_t (year, quarter, startDate, endDate) VALUES ('$year', '$quarter', '$start', '$end')";
	   		$result = mysql_query($sql);
			if (!$result) 
    			die('Invalid query: ' . mysql_error());
		   	header("location: semesters.php");
	   	}
	   	else{
	   		session_start();
	   		 $_SESSION['errors'] = $errors;
	   		 header("location: add.php?semester");
	   	}
		if(isset($_POST['editSemester'])){
			if(empty($errors)){
				$sID = $_POST['editSemester'];
				$sql="UPDATE semester_t SET year='$year', quarter='$quarter', startDate='$start', endDate='$end' WHERE semeseter_id=$sID";
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
	if(isset($_POST['eventID']))
	{
		$eID = $_POST['eventID'];
		$json=array();
		$sql="SELECT * FROM schedule_t WHERE schedule_id= " . $eID;
	    $result=mysql_query($sql);

	    while($row = mysql_fetch_assoc($result))  
	    {
		    $event = array(
		    	'id' => $row['schedule_id'],
		        'day' => $row['day'],
		        'start' => $row['startTime'],
		        'end' => $row['endTime'],
		        'crn' => $row['course_crn'],
		        'room' => $row['room_id'],
		        'teacher' => $row['teacher_id'],
		        'section' => $row['section_id'],
		        'semester' => $row['semester_id']
		    );
		    array_push($json, $event);
		}

		sendResponse($json);
	}

	//DELETE
	if(isset($_POST['eventDelete']))
	{
		$eID = $_POST['eID'];
		$sql="DELETE FROM schedule_t WHERE schedule_id=$eID";
	    $result=mysql_query($sql);
	    if($result)
	    	header("location: admin.php");
	    else{
    		session_start();
   		 	$_SESSION['errors'] = mysql_error();
   		 	header("location: schedule.php?event=$eID");
	    }

	}

	//ADD & EDIT
	if(isset($_POST['addEvent']) || isset($_POST['eID'])) 
	{
		$errors = array();
	   	$day = trim($_POST['day']); 
	   	$start = trim($_POST['start']); 
	   	$end = trim($_POST['end']); 
	   	$crn = trim($_POST['crn']); 
	   	$room = trim($_POST['room']); 
	   	$teacher = trim($_POST['teacher']); 
	   	$section = trim($_POST['section']); 
	   	$semester = trim($_POST['semester']); 

	   	if(isset($_POST['addEvent'])){
			$aday = trim($_POST['aday']); 
			$astart = trim($_POST['astart']); 
			$aend = trim($_POST['aend']); 
			$aroom = trim($_POST['aroom']); 
			$ateacher = trim($_POST['ateacher']); 
			//1 section can have up to 6 courses per semester
			$sql = "SELECT schedule_id FROM schedule_t WHERE semester_id=$semester AND section_id=$section";
			$result = mysql_query($sql);
			$count=mysql_num_rows($result);
			if($count > 6){
				array_push($errors, "There are already 6 courses per semester in this section");
			}
			//LECTURE
			if(isset($_POST['isLecture'])){
				//1 teacher <= 4 courses
				$sql = "SELECT schedule_id FROM schedule_t WHERE teacher_id=$teacher AND semester_id=$semester";
				$result = mysql_query($sql);
				$count=mysql_num_rows($result);
				if($count > 4){
					array_push($errors, "The lecture teacher is already assigned the maximum of 4 classes this semester");
				}
				//schedule conflicts 
				//day & time & room conflict 
				$sql = "SELECT schedule_id FROM schedule_t WHERE day=$day AND startTime=$start AND room_id=$room AND semester_id=$semester";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)>=1){
					array_push($errors, "[Lecture] There is already a class scheduled in this room at this time this semester");
				}
				//day & time & teacher conflict 
				$sql = "SELECT schedule_id FROM schedule_t WHERE day=$day AND startTime=$start AND teacher_id=$teacher AND semester_id=$semester";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)>=1){
					array_push($errors, "[Lecture] This teacher is already scheduled at this time this semester");
				}
				//crn & type conflict 
				$sql = "SELECT room_type FROM room_t INNER JOIN schedule_t ON room_t.room_id = schedule_t.room_id WHERE course_crn = $crn AND room_type='Lecture' AND semester_id=$semester";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)>=1){
					array_push($errors, "This course already has a lecture scheduled this semester");
				}
				if(!$errors) {
					$sql = "INSERT INTO schedule_t (day, startTime, endTime, course_crn, room_id, teacher_id, section_id, semester_id) VALUES ('$day', '$start', '$end', $crn, $room, $teacher, $section, $semester)";
					$result = mysql_query($sql);
				}
			}
			else{
				$result = true;
			}

			if (!$result) 
				sendResponse( mysql_error());

			//LAB
			if(isset($_POST['isLab'])){
				//1 teacher <= 4 courses
				$sql = "SELECT schedule_id FROM schedule_t WHERE teacher_id=$ateacher AND semester_id=$semester";
				$result = mysql_query($sql);
				$count=mysql_num_rows($result);
				if(count > 4){
					array_push($errors, "The lab teacher is already assigned the maximum of 4 classes this semester");
				}
				//schedule conflicts 
				//day & time & room conflict 
				$sql = "SELECT schedule_id FROM schedule_t WHERE day=$aday AND startTime=$astart AND room_id=$aroom AND semester_id=$semester";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)>=1){
					array_push($errors, "[Lab] There is already a class scheduled in this room at this time this semester");
				}
				//day & time & teacher conflict 
				$sql = "SELECT schedule_id FROM schedule_t WHERE day=$aday AND startTime=$astart AND teacher_id=$ateacher AND semester_id=$semester";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)>=1){
					array_push($errors, "[Lab] This teacher is already scheduled at this time this semester");
				}
				//crn & type conflict 
				$sql = "SELECT room_type FROM room_t INNER JOIN schedule_t ON room_t.room_id = schedule_t.room_id WHERE course_crn = $crn AND room_type='Lab' AND semester_id=$semester";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)>=1){
					array_push($errors, "This course already has a lab scheduled this semester");
				}
				if(!$errors) {
					$sql = "INSERT INTO schedule_t (day, startTime, endTime, course_crn, room_id, teacher_id, section_id, semester_id) VALUES ('$aday', '$astart', '$aend', $crn, $aroom, $ateacher, $section, $semester)";
					$result = mysql_query($sql);
				}
			}
			else
				$result = true;
			if($errors) {
				session_start();
				$_SESSION['errors'] = $errors;
				$_SESSION['post'] = $_POST;
				header("location: schedule.php?add");
				exit;
			}
			if (!$result) 
				die('Invalid query: ' . mysql_error());
			else
				header("location: admin.php");
		}

		if(isset($_POST['eID'])){
			if(empty($errors)){
				$eID = $_POST['eID'];
				//1 section can have up to 6 courses per semester
				$sql = "SELECT schedule_id FROM schedule_t WHERE semester_id=$semester AND section_id=$section";
				$result = mysql_query($sql);
				$count=mysql_num_rows($result);
				if($count > 6){
					array_push($errors, "There are already 6 courses per semester in this section");
					session_start();
					$_SESSION['errors'] = $errors;
					header("location: schedule.php?event=$eID");
					exit;
				}
				//1 teacher <= 4 courses
				$sql = "SELECT schedule_id FROM schedule_t WHERE teacher_id=$teacher AND semester_id=$semester";
				$result = mysql_query($sql);
				$count=mysql_num_rows($result);
				if($count > 4){
					array_push($errors, "The teacher is already assigned the maximum of 4 classes this semester");
					session_start();
				 	$_SESSION['errors'] = $errors;
				 	header("location: schedule.php?event=$eID");
				 	exit;
				}
				//schedule conflicts 
				//day & time & room conflict 
				$sql = "SELECT schedule_id FROM schedule_t WHERE day=$day AND startTime=$start AND room_id=$room AND semester_id=$semester";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)>=1){
					array_push($errors, "There is already a class scheduled in this room at this time this semester");
					session_start();
				 	$_SESSION['errors'] = $errors;
				 	header("location: schedule.php?event=$eID");
				 	exit;
				}
				//day & time & teacher conflict 
				$sql = "SELECT schedule_id FROM schedule_t WHERE day=$day AND startTime=$start AND teacher_id=$teacher AND semester_id=$semester";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)>=1){
					array_push($errors, "This teacher is already scheduled at this time this semester");
					session_start();
				 	$_SESSION['errors'] = $errors;
				 	header("location: schedule.php?event=$eID");
				 	exit;
				}
				//crn & type conflict 
				$sql = "SELECT room_type FROM room_t WHERE room_id=$room";
				$result = mysql_query($sql);
				$type=mysql_result($result,0,"room_type");
				$sql = "SELECT room_type FROM room_t INNER JOIN schedule_t ON room_t.room_id = schedule_t.room_id WHERE course_crn = $crn AND room_type=$type AND semester_id=$semester";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)>=1){
					array_push($errors, "This course already has a $type scheduled this semester");
					session_start();
				 	$_SESSION['errors'] = $errors;
				 	header("location: schedule.php?event=$eID");
				 	exit;
				}
				$sql="UPDATE schedule_t SET day='$day', startTime='$start', endTime='$end', course_crn='$crn', room_id='$room', teacher_id='$teacher', section_id='$section', semester_id='$semester' WHERE schedule_id=$eID";
				$result = mysql_query($sql);
				if($result)
					header("location: admin.php");
				else{
					session_start();
					$_SESSION['errors'] = $errors;
					header("location: schedule.php?event=$eID");
				}
			}			
			else{
				session_start();
				$_SESSION['errors'] = $errors;
				header("location: schedule.php?event=$eID");
			}
		}
	}
?>