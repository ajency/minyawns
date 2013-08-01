<?php
/**
 * Template: Home page

 */

get_header(); ?>
			
		<div id="myModal" class="modal signup hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(images/pattern-bg.png)">
  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="images/delete.png"/></button>
    <h4 id="myModalLabel">Sign Up to <img src="images/logo.png"/> </h4>
  </div>
  <div class="modal-body">
    <div class="row-fluid">
		<div class="span6"> 
		<h6 class="align-center" style=" margin-bottom: 0px; ">
		Create an Account</h6>
<p class="align-center">Fill out the required information Below</p>
		<div class="control-group ">
            <input type="text" value="" placeholder="Email Address" class="span3">
          </div>
		<div class="control-group ">
            <input type="text" value="" placeholder="Password" class="span3">
          </div>
		  <div class="control-group span6 " style=" margin-left: 0px; ">
            <input type="text" value="" placeholder="First Name" class="span3">
          </div>
		<div class="control-group span6 ">
            <input type="text" value="" placeholder="Last Name" class="span3">
          </div>
		  <div class="clear"></div>
		  <a href="#fakelink" class="btn btn-large btn-block btn-inverse" >Sign Up</a>
		</div>
		
		<div class="span6">
			<h6 class="align-center" style=" margin-bottom: 0px; ">
		Sign Up Using Facebook</h6>
<p class="align-center">Get using minyawns, faster !</p><br><br>

		<a href="#"><img src="images/fbConnect_button.png" class="center-image"/></a>
		<br><br>
		<p class="align-center">Already a Minyawn?<a href="#"><b> Sign in here</b></a></p>
		</div>
		
	</div>
  </div>
  
</div>

<div id="mylogin" class="modal signup  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(images/pattern-bg.png)">
  <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="images/delete.png"/></button>
    <h4 id="myModalLabel">Login to <img src="images/logo.png"/> </h4>
  </div>
  <div class="modal-body">
    <div class="row-fluid">
		<div class="span6"> 
	
		<div class="control-group ">
            <input type="text" value="" placeholder="Email Address" class="span3">
          </div>
		<div class="control-group ">
            <input type="text" value="" placeholder="Password" class="span3">
          </div>
		  <div class="row-fluid">
			<div class="span4"><a href="#fakelink" class="btn btn-large btn-block btn-inverse " >Login</a></div>
				<div class="span8"><a href="#"  style=" line-height: 42px; color: #12B13E;font-weight:bold; ">Forget your password ?</a></div>
		  </div> 
		  </div>
		<div class="span6">
			<h6 class="align-center" style=" margin-bottom: 0px; ">
		Login Using Facebook</h6>
<p class="align-center">Get using minyawns, faster !</p><br>

		<a href="#"><img src="images/fbConnect_button.png" class="center-image"/></a>
		
		
		</div>
		
	</div>
  </div>
  
</div>
			
    <!-- Load JS here for greater good =============================-->
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script src="js/flatui-checkbox.js"></script>
    <script src="js/flatui-radio.js"></script>
    <script src="js/jquery.tagsinput.js"></script>
    <script src="js/jquery.placeholder.js"></script>
    <script src="js/jquery.stacktable.js"></script>
    <script src="js/application.js"></script>
	<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="js/jquery.pep.js"></script>
	<script src="js/jquery.dragsort-0.5.1.js"></script>
	

	
  </body>
</html>	
			
			

<?php get_footer(); ?>