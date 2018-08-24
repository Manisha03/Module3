    
<?php
include 'header.php'; 
?>


  <div class="section content_section">
	<div class="container">
		<div class="filable_form_container">

	  <form action="connectionc.php" method="POST">    

   			 <div class="form_container_block">
				<ul>
					<li class="fileds">
						<div class="name_fileds">
							<label>Category Name</label><span id="catname_error" class="error"> </span>
							<input name="catname" type="text" id="catname" required/> 
						</div>
					</li>
				</ul>
             <div class="next_btn_block">
                 <input type="submit" name="submit" value="submit"/>
              </div>
          </div>
       </form> 
   </div>
   		</div> 
	</div>	

    <script type="text/javascript">
        /*
         * Validates the Catergory field , if proper sumbits the  form
         */   
    function validation()
    {
        var correct_way =/^[A-Za-z]+$/;

        var catname =document.getElementById('catname').value;
        if (catname == "")
         {
            document.getElementById('catname_error').innerHTML="Please fill name";
            return false;
         }
                if (catname.length<3)
         {
            document.getElementById('catname_error').innerHTML="Category name must be 3 character";
            return false;
         }
                if (catname.length>10)
         {
            document.getElementById('catname_error').innerHTML="Category name  should be less then 10 character";
            return false;
         }
         if(catname.match(correct_way))
            true;
         else
         {
            document.getElementById('catname_error').innerHTML="Only alphabets are allow";
            return false;
         }
    </script>
  <?php include 'footer.php'; ?>