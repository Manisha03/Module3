<?php
/*
 * Adds the product in database by firing query on database also creates a folder to store uploaded files
 */
$error_name = '';
$error_price = '';
$error_select = '';
$error_ext = '';
$target_dir = 'images/';
$pageload = true;
include 'db_conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!file_exists('images')){
    $oldumask = umask(0);
    mkdir('images', 0777, true);
    umask($oldumask); 
    }
    if (empty($_POST['fname'])) {
        $error_name = "This is required";
    } else if (preg_match('/[\!@#$%&*()~]/', $_POST['catname'])) {
        $error_name = 'Only Alphabnumeric ';
    }
    if (empty($_POST['price'])) {
        $error_price = "This is required";
    } else if (!preg_match('/^\d{0,9}(\.\d{0,2})?$/', $_POST['price'])) {
        $error_price = "Input is not valid";
    }
    if (empty($_POST['catname'])) {
        $error_select = "This is required";
    }
    if (!($_FILES['uploadFile']['name'] == '')) {
        $ext = pathinfo($_FILES["uploadFile"]["name"], PATHINFO_EXTENSION);
        if (!($ext == "jpg" || $ext == "png")) {
            $error_ext = "Invalid File";
        }
        if (empty($error_ext)) {
            $img_name = 'Product_image_' . time() . '.' . $ext;
            $target_file = $target_dir . $img_name;
            move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file);
        }
    }
    if (empty($error_name) && empty($error_price) && empty($error_select) && empty($error_ext)) {
        $sqlquery = "INSERT INTO product(fname,price,uploadFile,catname) values('" . $_POST['fname'] . "','" . $_POST['price'] . "','" . $img_name . "','" . $_POST['catname'] . "')";
        if ($conn->query($sqlquery)) {
            $success = 'product added Succesfully';
        } 
        else {
            echo "Error: " . $sqlquery . "<br>" . $conn->error();
        }
    }
} else {
    $pageload = true;
}
if ($pageload) {
    include 'header.php';
    ?>


  <div class="section banner_section who_we_help">
  	<div class="container">
  		<h4>Create Category</h4>
  	</div>
  </div>

  <!-- Content Section Start-->
  <div class="section content_section">
	<div class="container">
		<div class="filable_form_container">
			<form id="add_product" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  enctype="multipart/form-data" method="POST">    

			<div class="form_container_block">
				<ul>
					<li class="fileds">
						<div class="name_fileds">
							<label>Product Name</label> <label clas="error"><?php echo $error_name; ?></label>
							<input name="fname" id="fname" type="text" required> 
						</div>
					</li>
					<li class="fileds">
						<div class="name_fileds">
							<label>Product Price</label><label class="error"><?php echo $error_price; ?></label>
							<input name="price" id="price" type="text" required=""> 
						</div>
					</li>
					<li class="fileds">
						<div class="upload_fileds">
							<label>Upload Image</label><label class="error"><?php echo $error_ext; ?></label>
                             <input name="uploadFile" id="uploadFile" type="file" placeholder="Choose File" style="width:380px">

						</div>						
					</li>
					<li class="fileds">
						<div class="name_fileds">
							<label>Select Category</label> <label class="error"><?php echo $error_select; ?></label>
							<select name="catname" class="select category" id="catname"><!-- style="z-index: 10; opacity: 0;"-->
                    <option value="">Select Category</option>
                                        <?php
                                        $sqlquery = "SELECT catname,id From category1";
                                        $result = $conn->query($sqlquery);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?><option value="<?php echo $row['catname'] ?>"><?php echo $row['catname'] ?></option>
                                                <?php
                                            }
                                        }
                                        mysqli_close($conn);
                                        ?>
							</select>
							<!--<span class="select">Mobile</span> -->
						</div>
					</li>
				</ul>
				<div class="next_btn_block">
                  <center><input type="submit" name="submit" value="submit"/></center>
				<!--	<div class="next_btn">
						<a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/add_product.html#">Submit  <span><img src="images/small_triangle.png" alt="small_triangle"> </span></a>
					</div>-->
				</div>
			</div>
		</form>
		</div>
	</div>		
  </div>

  <script type="text/javascript">
     /*
      * Validates the product name field ,price,category field and uploaded file extension then sumbits the  form if it is proper
      */
    $(document).ready(function () {
    <?php if (!empty($success)) { ?>
            alert('<?php echo $success; ?>');
    <?php } ?>
        $("#add_product").validate({
            rules: {
                fname: {
                    required: true,
                    pass1: true
                },
                price: {
                    required: true,
                    money: true
                },
                catname: {
                    required: true
                },
                uploadFile: {
                    accept: "image/jpeg, image/png"
                }
            },
            messages: {
                fname: {
                    required: 'This field is Required*'
                     },
                     price: {
                         required: 'This field is Required*'
                     },
                     catname: {
                         required: 'Please Select a Category*'
                     }
            },
            submitHandler: function (form) {
                 form.submit();
            }
        });
     });
    </script>

 <!-- <script type="text/javascript">
  	function Validation()
  	{

  		var correct_way=/^[A-Za-z]+$/;

  		//product name
  		 var fname =document.getElementById('fname').value;
        if (fname == "")
         {
            document.getElementById('fname_error').innerHTML="Please fill Product name";
            return false;
         }
                if (fname.length<3)
         {
            document.getElementById('fname_error').innerHTML="Product name must be 3 character";
            return false;
         }
                if (fname.length>10)
         {
            document.getElementById('fname_error').innerHTML="Product name should be less then 10 character";
            return false;
         }
         if(fname.match(correct_way))
            true;
         else
         {
            document.getElementById('fname_error').innerHTML="Only alphabets are allow";
            return false;
         }

         //price
         var price = document.getElementById('price').value;
         if (price=="") {
         	document.getElementById('price_error').innerHTML="Please fill price";
         }
         if(isNaN(price))
         {
         	document.getElementById('price_error').innerHTML="Only numbers are allowed";
         }

  	}

  </script>-->
  <!-- Content Section End-->

  <?php
include 'footer.php';
}
  ?>

