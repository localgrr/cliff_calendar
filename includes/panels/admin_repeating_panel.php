<div class="row mb-4">
	<div class="col-md-12">
		<div id="repeating-events">
			<br>
			<h5 id="parent-event"></h2>
		</div>
	</div>
</div>
<div class="row align-items-center">
	<div class="col-md-auto">
		<label for="cliff_repeat_occurence" class="form-label-inline"><span class="text-end">Repeat every</span></label>
	</div>
	<div class="col-md-4">
		<label class="visually-hidden" for="cliff_repeat_occurence">Occurence</label>
		<input type="number" class="form-control" min="0" value="1" id="cliff_repeat_occurence" name="cliff_repeat_occurence" />
	</div>
	<div class="col-md-auto">
		<label class="visually-hidden" for="cliff_repeat_type">Preference</label>
		<select class="form-select" id="cliff_repeat_type" name="cliff_repeat_type">
			<option value="days">Days</option>
			<option value="weeks">Weeks</option>
			<option value="months">Months</option>
			<option value="years">Years</option>
		</select>
	</div>
</div>
<div class="row" id="cliff_weeks_panel">
	<div class="col-12">

	</div>
</div>




<!-- <div class="row mb-4">
	<div class="col-md-4">
		
		<?=cliff_add_event::get_repeat_select() ?>
	</div>
	<div class="col-md-4" id="cliff_repeat_interval">
		<label for="cliff_repeat_type" class="form-label">Repeat Type</label>
		<?=cliff_add_event::get_repeat_select() ?>
	</div>
</div> -->