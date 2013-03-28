<?php ob_start(); ?>
<?php
include('partials/_dbinfo.inc.php');
include('partials/_adminlock.php');
?>
<!DOCTYPE html>
<html>
<head>
	    <title>GBC Mini-Scheduling System - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
     </head>
<body>
<div class="container">
  <?php
  include "partials/_header.php";
  ?>

  <ul class="nav nav-tabs">
    <li id="admin" >
      <a href="admin.php">Current Schedule</a>
    </li>
    <li id="teachers"><a href="teachers.php">Teachers</a></li>
    <li id="courses"><a href="courses.php">Courses</a></li>
     <li id="sections"><a href="sections.php">Sections</a></li>
    <li id="rooms"><a href="rooms.php">Rooms</a></li>
  </ul>

  <div class="well">
    <?php 
      if(isset($_SESSION['errors'])){
        $errors = array($_SESSION['errors']);
        unset($_SESSION['errors']);
        foreach($errors as $e){
          foreach($e as $r)
            echo "<span style='color:red;'> $r <br></span>";
        }
      }
     ?>
     <form method="post" action="query_service.php" class="form-horizontal">
      <?php 
      	if(isset($_GET['teacher'])){
          echo "<h3>Add a Teacher</h3>";
      		include('partials/_teacher_form.php');
          echo "<div class='controls'><a href='teachers.php' class='btn'>Cancel</a><input type='submit' name='addUser' class='btn btn-primary' value='Save'/>";
        }
        if(isset($_GET['section'])){
          echo "<h3>Add a Section</h3>";
          include('partials/_section_form.php');
          echo "<div class='controls'><a href='sections.php' class='btn'>Cancel</a><input type='submit' name='addSection' class='btn btn-primary' value='Save'/>";
        }
        if(isset($_GET['course'])){
          echo "<h3>Add a Course</h3>";
          include('partials/_course_form.php');
          echo "<div class='controls'><a href='courses.php' class='btn'>Cancel</a><input type='submit' name='addCourse' class='btn btn-primary' value='Save'/>";
        }
        if(isset($_GET['room'])){
          echo "<h3>Add a Room</h3>";
          include('partials/_room_form.php');
          echo "<div class='controls'><a href='rooms.php' class='btn'>Cancel</a><input type='submit' name='addRoom' class='btn btn-primary' value='Save'/>";
        }
      ?>
      </div>
    </form>
  </div>


</div>
<script>
 var url = $(location).attr('href').split('?');
    if($.inArray('teacher', url) > -1)
      $("#teachers").addClass("active");
    else if($.inArray('section', url) > -1)
      $("#sections").addClass("active");
    else if($.inArray('course', url) > -1)
      $("#courses").addClass("active");
    else if($.inArray('room', url) > -1)
      $("#rooms").addClass("active");
</script>
</body>
</html>