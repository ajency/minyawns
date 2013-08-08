<div class="container">
	<div class="main-content bg-white">
		<div class="breadcrumb-text">
			<p>
				<a href="myjobs.html">View All Jobs</a> Add a Job
			</p>
		</div>
		<form class="form-horizontal frm_job">
			<div class="control-group small">
				<label class="control-label" for="inputtask">Tasks</label>
				<div class="controls ">
					<input type="text" value="" placeholder="" class="span3">
				</div>
			</div>
			<div class="control-group small">
				<label class="control-label" for="inputtask">Start</label>
				<div class="controls">
					<div class="input-prepend input-datepicker">
						<button type="button" class="btn">
							<span class="fui-calendar"></span>
						</button>
						<input type="text" class="span1" value="14 March, 2013"
							id="datepicker-01">
					</div>
					<input class="span2 timepicker" id="prependedInput-03" type="text">
					&nbsp;PDT
				</div>
			</div>
			<div class="control-group small">
				<label class="control-label" for="inputtask">End</label>
				<div class="controls">
					<div class="input-prepend input-datepicker">
						<button type="button" class="btn">
							<span class="fui-calendar"></span>
						</button>
						<input type="text" class="span1" value="14 March, 2013">
					</div>
					<input class="span2 timepicker" id="prependedInput-03" type="text">
					&nbsp;PDT
				</div>
			</div>
			<div class="control-group small">
				<label class="control-label" for="inputtask">Required</label>
				<div class="controls ">
					<input type="text" id="spinner-01" placeholder="" value="0"
						class="spinner">
				</div>
			</div>
			<div class="control-group small">
				<label class="control-label" for="inputtask">Location</label>
				<div class="controls ">
					<input type="text" value="" placeholder="" class="span3">
				</div>
			</div>
			<div class="control-group small">
				<label class="control-label" for="inputtask">Details</label>
				<div class="controls ">
					<textarea class="span6" rows="10" cols="4"
						placeholder="Add comment..." style="height: 70px;"></textarea>
				</div>
			</div>
			<hr>
			<a href="#" id="add-job-submit" class="btn btn-large btn-block btn-inverse span2">Submit</a>
			<div class="clear"></div>
		</form>
	</div>
	<footer>
		<hr style="border-top: 1px solid #C7C3C3;">
		<ul class="footer_menu">
			<li><a href="#">About</a>
			</li>
			<li><a href="#">Careers</a>
			</li>
			<li><a href="#">Blog</a>
			</li>
			<li><a href="#">Tech City</a>
			</li>
			<li><a href="#">Directory</a>
			</li>
		</ul>
		<div class="social-icon">
			<a href="#"><img
				src="<?php echo get_template_directory_uri() ?>/images/twiiter.png" />
			</a>&nbsp;&nbsp;<a href="#"><img
				src="<?php echo get_template_directory_uri() ?>/images/facebook.png" />
			</a>
		</div>
		<div class="site_link">All rights reserved 2013 @ Minyawn</div>
	</footer>

</div>
<script
	type="text/javascript"
	data-main="<?php echo get_template_directory_uri(); ?>/templates/job/js/job.js"
	src="<?php echo get_template_directory_uri(); ?>/js/require.js"></script>

</body>
</html>
