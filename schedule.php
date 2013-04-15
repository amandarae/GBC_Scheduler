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
  <script src="js/jquery-1.9.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootbox.min.js"></script>
  <script>
    function getParameterByName(name)
    {
      name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
      var regexS = "[\\?&]" + name + "=([^&#]*)";
      var regex = new RegExp(regexS);
      var results = regex.exec(window.location.search);
      if(results == null)
        return "";
      else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    </script>
</head>
<body>
<div class="container">
  <?php
  include "partials/_header.php";
  ?>

  <ul class="nav nav-tabs">
    <li class="active">
      <a href="admin.php">Current Schedule</a>
    </li>
    <li ><a href="teachers.php">Teachers</a></li>
    <li><a href="courses.php">Courses</a></li>
     <li><a href="sections.php">Sections</a></li>
    <li><a href="rooms.php">Rooms</a></li>
    <li><a href="semesters.php">Semesters</a></li>
  </ul>
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
     <div id="response" style="color: red;"></div>
  <div class="form-center">
    <?php 
      if(isset($_SERVER['QUERY_STRING']=='event')){
        include('partials/_schedule_form.php'); 

        $frmbttm = '
          <a href="admin.php" class="btn cl ">Back</a>
          <input type="hidden" name="eID" id="eID" value=""/>
          <input type="submit" class="delete-click btn btn-danger" id="eventDelete" name="eventDelete" value="Delete"/>
          <input type="submit" class="btn btn-primary" id="saveEvent" value="Save changes"/>
        </form>

        <?php include("partials/_deleteModal.php") ?>
        </div>';
    echo $frmbttm;
    }
    if(isset($_SERVER['QUERY_STRING']=='add')){
      include('partials/_lablec_schedule_form.php'); 
      $frmbttm = '
         <a href="admin.php" class="btn cl ">Back</a>
          <input type="submit" class="btn btn-primary" id="addEvent" name="addEvent" value="Schedule"/>
        </form>';
    echo $frmbttm;
    }
  ?>
    
  </div>
</div>
<script>
 $(document).ready(function(){
    var errors=""; 
    $('#llScheduleForm').submit(function(){
      errors=""; 
      var s = $('#start').val().split(":");
      var e = $('#end').val().split(":");
      var as = $('#astart').val().split(":");
      var ae = $('#aend').val().split(":");
      if(s[0] >  e[0] || e[0] - s[0] || as[0] >  ae[0] || ae[0] - as[0] > 2)
        errors += "A lab and or lecture must be blocked in successive 2 hr blocks<br>";
      if(errors != ""){
        $('#response').html(errors);
        return false;
      }
      return true;
    });
    $('#scheduleForm').submit(function(){
      errors=""; 
      var s = $('#start').val().split(":");
      var e = $('#end').val().split(":");
      if(s[0] >  e[0] || e[0] - s[0] > 2)
        errors += "A lab and or lecture must be blocked in successive 2 hr blocks<br>";
      if(errors != ""){
        $('#response').html(errors);
        return false;
      }
      return true;
    });
    if(getParameterByName('event')){
      $(".delete-click").data("detail-id", getParameterByName('event'));
       var dataObj = { eventID : getParameterByName('event') };
        $.ajax({
          type: 'POST',
          url: 'query_service.php',
          data: dataObj,
          dataType: 'JSON',
          success: function(response)
          {
            $('#eID').val(response[0]['id']);
            $('#day').val(response[0]['day']);
            $('#start').val(response[0]['start']);
            $('#end').val(response[0]['end']);
            $('#crn').val(response[0]['crn']);
            $('#room').val(response[0]['room']);
            $('#teacher').val(response[0]['teacher']);
            $('#section').val(response[0]['section']);
            $('#semester').val(response[0]['semester']);
          }
        });
    }
  });
</script>
</body>
</html>