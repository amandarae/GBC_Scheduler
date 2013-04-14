<form id="semesterForm" action="query_service.php" method="post"  class="form-horizontal">
<div class="control-group">
 <label class='control-label' for='desc'>Semester Quarter</label> 
  <div class='controls'> 
   	<select name="quarter" id="quarter">
   		<option>Fall</option>
   		<option>Winter</option>
   		<option>Spring</option>
   		<option>Summer</option>
   	</select>
  </div>
</div>
 <div class="control-group">
 <label class='control-label' for='sstart'>Semester Start Date</label> 
  <div class='controls'> 
    <input id="start" name="start" size="10" class="hasDatepick">
  </div>
</div>
 <div class="control-group">
 <label class='control-label' for='code'>Semester End Date</label> 
  <div class='controls'> 
    <input id="end" name="end" size="10" class="hasDatepick">
  </div>
</div>