<div class="mb-3 row">
	<div class="col-md-4">
		<label for="cliff_start_date" class="form-label">Start Date</label>
		<input type="date" class="form-control" id="cliff_start_date" name="cliff_start_date" placeholder="yyyy-mm-yy" required="required">
	</div>
	<div class="col-md-4">
		<label for="cliff_start_time" class="form-label">Start Time</label>
		<input type="time" class="form-control cliff-time" id="cliff_start_time" name="cliff_start_time" placeholder="19:30">
	</div>
</div>
<div class="row mb-4">
	<div class="col-md-4">
		<label for="cliff_end_date" class="form-label">End Date</label>
		<input type="date" class="form-control " id="cliff_end_date" name="cliff_end_date" placeholder="yyyy-mm-yy">
	</div>
	<div class="col-md-4">
		<label for="cliff_end_time" class="form-label">End Time</label>
		<input type="time" class="form-control cliff-time" id="cliff_end_time" name="cliff_end_time" placeholder="22:30">
	    <div class="invalid-feedback end-time">
			End time must be after start time
	    </div>
	</div>
	<div class="col-md-4">
		<label for="cliff_duration" class="form-label">Duration</label>
		<input type="text" class="form-control cliff-time" id="cliff_duration" name="cliff_duration" placeholder="hh:mm">
	    <div class="invalid-feedback duration">
			<span class="negative invalid-feedback-child">
			Duration must be above 0
			</span>
			<span class="format invalid-feedback-child">
			Format must be h or h:m
			</span>
			<span class="fill-start-date invalid-feedback-child">
			Event must have a start time
			</span>
	    </div>
	</div>
</div>
<div class="row mb-4 duration-warning d-none">
	<div class="col-md-12">
		<div class="alert alert-warning" role="alert">
		  Duration seems long. For repeating events, put in the normal start and end date for the first event only, then setup the repeat.
		</div>
	</div>
</div>
<div class="form-check">
	<input class="form-check-input" type="checkbox" value="" name="cliff_all_day" id="cliff_all_day">
	<label class="form-check-label" for="cliff_all_day">
	All day event
	</label>
</div>

<!-- <div class="mb-3 row">
	<div class="col-md-4">
		<label for="cliff_timezone" class="form-label">Timezone</label>
		<?php //echo $this->get_tz_datalist(); ?>
	</div>
</div> -->