<form id="llScheduleForm" action="query_service.php" method="post"  class="form-horizontal">
  <?php
    if(isset($_SESSION['post'])){
      $post = array($_SESSION['post']);
      unset($_SESSION['post']);
    } 
  ?>
<div class="row">
  <div class="span12">
    <h3>Course</h3>
    <div class="control-group">
     <label class='control-label' for='semester'>Semester</label> 
      <div class='controls'> 
        <select name="semester" id="semester" >
          <?php 
            $result = select("semester_t","");
            $count=mysql_num_rows($result);
            $i=0;
            while ($i < $count) {
              $id=mysql_result($result,$i,"semester_id");
              $year=mysql_result($result,$i,"year");
              $quarter=mysql_result($result,$i,"quarter");
              if (isset($post)) {
                if($post[0]['semester'] == $id) {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$id'>$quarter $year</option>";
              $i++;
            }
          ?>
        </select>
      </div>
    </div>
    <div class="control-group">
     <label class='control-label' for='crn'>Course CRN</label> 
      <div class='controls'> 
        <select name="crn" id="crn">
          <?php 
            $result = select("course_t","");
            $count=mysql_num_rows($result);
            $i=0;
            while ($i < $count) {
              $crn=mysql_result($result,$i,"course_crn");
              $desc=mysql_result($result,$i,"course_desc");
              if (isset($post)) {
                if($post[0]['crn'] == $crn) {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$crn'>$crn $desc</option>";
              $i++;
            }
          ?>
        </select>
      </div>
    </div>
    <div class="control-group">
     <label class='control-label' for='section'>Section</label> 
      <div class='controls'> 
        <select name="section" id="section">
          <?php 
            $result = select("section_t","");
            $count=mysql_num_rows($result);
            $i=0;
            while ($i < $count) {
              $id=mysql_result($result,$i,"section_id");
              $name=mysql_result($result,$i,"section_name");
              if (isset($post)) {
                if($post[0]['section'] == $id) {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$id'>$name</option>";
              $i++;
            }
          ?>
        </select>
      </div>
    </div>
  </div>


<div class="span6">
    <label class="checkbox">
      <input type="checkbox" name="isLecture" checked="checked"> <h3>Lecture</h3>
    </label>
    <div class="control-group">
     <label class='control-label' for='day'>Day</label> 
      <div class='controls'> 
       <select name="day" id="day">
        <?php
          $days = array("monday","tuesday","wednesday","thursday", "friday");
          $count = count($days);
          for($i=0;$i<$count;$i++){
            if (isset($post)) {
                if($post[0]['day'] == $days[$i]) {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
            $day = ucfirst($days[$i]);
            echo "<option $sel value='$days[$i]'>$day</option>";
          }
        ?>
       </select>
      </div>
    </div>
     <div class="control-group">
     <label class='control-label' for='start'>Start Time</label> 
      <div class='controls'> 
        <select name="start" id="start">
          <?php 
            for($i=8;$i<=16;$i+=2) {
              if (isset($post)) {
                if($post[0]['start'] == $i.':00') {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$i:00'>$i:00</option>";
            }
          ?>
        </select>
      </div>
    </div>
     <div class="control-group">
     <label class='control-label' for='end'>End Time</label> 
      <div class='controls'> 
        <select name="end" id="end">
          <?php 
            for($i=10;$i<=18;$i+=2) {
              if (isset($post)) {
                if($post[0]['end'] == $i.':00') {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$i:00'>$i:00</option>";
            }
          ?>
        </select>
      </div>
    </div>
    <div class="control-group">
     <label class='control-label' for='room'>Room</label> 
      <div class='controls'> 
        <select name="room" id="room">
          <?php 
            $result = select("room_t","room_type='lecture'");
            $count=mysql_num_rows($result);
            $i=0;
            while ($i < $count) {
              $id=mysql_result($result,$i,"room_id");
              $room=mysql_result($result,$i,"room_number");
              $type=mysql_result($result,$i,"room_type");
              if (isset($post)) {
                if($post[0]['room'] == $id) {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$id'>$room ($type)</option>";
              $i++;
            }
          ?>
        </select>
      </div>
    </div>
    <div class="control-group">
     <label class='control-label' for='teacher'>Teacher</label> 
      <div class='controls'> 
        <select name="teacher" id="teacher">
          <?php 
            $result = select("user_t","admin <> 1");
            $count=mysql_num_rows($result);
            $i=0;
            while ($i < $count) {
              $id=mysql_result($result,$i,"employee_id");
              $first=mysql_result($result,$i,"first_name");
              $last=mysql_result($result,$i,"last_name");
              if (isset($post)) {
                if($post[0]['teacher'] == $id) {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$id'>$first $last</option>";
              $i++;
            }
          ?>
        </select>
      </div>
    </div>
  </div>

  <div class="span6">
    <label class="checkbox">
      <input type="checkbox" name="isLab" checked="checked"> <h3>Lab</h3>
    </label>
    <div class="control-group">
     <label class='control-label' for='aday'>Day</label> 
      <div class='controls'> 
       <select name="aday" id="aday">
        <?php
          $days = ["monday","tuesday","wednesday","thursday", "friday"];
          $count = count($days);
          for($i=0;$i<$count;$i++){
            if (isset($post)) {
                if($post[0]['aday'] == $days[$i]) {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
            $day = ucfirst($days[$i]);
            echo "<option $sel value='$days[$i]'>$day</option>";
          }
        ?>
       </select>
      </div>
    </div>
     <div class="control-group">
     <label class='control-label' for='astart'>Start Time</label> 
      <div class='controls'> 
        <select name="astart" id="astart">
          <?php 
            for($i=8;$i<=16;$i+=2) {
              if (isset($post)) {
                if($post[0]['astart'] == $i.':00') {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$i:00'>$i:00</option>";
            }
          ?>
        </select>
      </div>
    </div>
     <div class="control-group">
     <label class='control-label' for='aend'>End Time</label> 
      <div class='controls'> 
        <select name="aend" id="aend">
          <?php 
            for($i=10;$i<=18;$i+=2) {
              if (isset($post)) {
                if($post[0]['aend'] == $i.':00') {

                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$i:00'>$i:00</option>";
            }
          ?>
        </select>
      </div>
    </div>
    <div class="control-group">
     <label class='control-label' for='aroom'>Room</label> 
      <div class='controls'> 
        <select name="aroom" id="aroom">
          <?php 
            $result = select("room_t","room_type='lab'");
            $count=mysql_num_rows($result);
            $i=0;
            while ($i < $count) {
              $id=mysql_result($result,$i,"room_id");
              $room=mysql_result($result,$i,"room_number");
              $type=mysql_result($result,$i,"room_type");
              if (isset($post)) {
                if($post[0]['aroom'] == $id) {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$id'>$room ($type)</option>";
              $i++;
            }
          ?>
        </select>
      </div>
    </div>
    <div class="control-group">
     <label class='control-label' for='ateacher'>Teacher</label> 
      <div class='controls'> 
        <select name="ateacher" id="ateacher">
          <?php 
            $result = select("user_t","admin <> 1");
            $count=mysql_num_rows($result);
            $i=0;
            while ($i < $count) {
              $id=mysql_result($result,$i,"employee_id");
              $first=mysql_result($result,$i,"first_name");
              $last=mysql_result($result,$i,"last_name");
              if (isset($post)) {
                if($post[0]['ateacher'] == $id) {
                  $sel = 'selected="selected"';
                }
                else {
                  $sel = '';
                }
              }
              echo "<option $sel value='$id'>$first $last</option>";
              $i++;
            }
          ?>
        </select>
      </div>
    </div>
  </div>