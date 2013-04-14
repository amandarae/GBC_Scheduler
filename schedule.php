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
  <div class="form-center">
    <h3 id="detailsID"></h3>

    <?php 
      if(isset($_GET['event'])){
        include('partials/_schedule_form.php'); 

        $frmbttm = <<<FORMEND
          <a href="admin.php" class="btn cl ">Back</a>
          <input type="hidden" name="eID" id="eID" value=""/>
          <input type='submit' class="delete-click btn btn-danger" id="eventDelete" name="eventDelete" value="Delete"/>
          <input type='submit' class="btn btn-primary" id="eventSave" value="Save changes"/>
        </form>

        <?php include('partials/_deleteModal.php') ?>
        </div>
FORMEND;
    echo $frmbttm;
    }
    else{
      include('partials/_lablec_schedule_form.php'); 
      $frmbttm = <<<FORMEND
         <a href="admin.php" class="btn cl ">Back</a>
          <input type="submit" class="btn btn-primary" id="addEvent" name="addEvent" value="Schedule"/>
        </form>
FORMEND;
    echo $frmbttm;
    }
  ?>
    <div id="response" style="color: red;"></div>
  </div>
</div>
<script>
 $(document).ready(function(){
    if(getParameterByName('add')){
      $('#llScheduleForm').submit(function(){
        return true;
      });
    }
    else if(getParameterByName('event')){
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
        $("#eventSave").on("click", function(e){
            var dataObj = { editEvent : getParameterByName('event'), semester : $("#semester").val(), day : $("#day").val(), start : $("#start").val(), end : $("#end").val(), crn : $("#crn").val(), teacher : $("#teacher").val(), room : $("#room").val(), section : $("#section").val() };
          $.ajax({
            type: 'POST',
            url: 'query_service.php',
            data: dataObj,
            dataType: 'JSON',
            success: function(response){
              window.location.replace("admin.php");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){$("#response").html("error: " + errorThrown);}
          });
        });
    }
  });
</script>
</body>
</html>