
<?php
include 'header.php';
$error_fname='';
$error_price='';
$error_scat='';
$error_image='';
$pageload = true ;
$target_dir = 'images/';

include 'db_conn.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST['fname'])){
        $error_name="This Field is Required";
    }else if (preg_match('/[\!@#$%&*()~]/', $_POST['fname'])) {
        $error_name = 'only Alphabnumeric allow';
    }
    if(empty($_POST['price'])){
        $error_price='This Field is Required';
    } else if (!preg_match('/^\d{0,9}(\.\d{0,2})?$/', $_POST['price'])) {
        $error_price = "Input is not valid";
    }
    if(empty($_POST['catname'])){
        $error_scat="This Field is Required";
    }
    if (!($_FILES['uploadFile']['name'] == '')) {
        $ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
        if (!($ext == 'jpg' | $ext == 'png')) {
            $error_ext = "Invalid File";
        }
        if (empty($error_image)) {
            $img_name = 'Product_image_' . time() . '.' . $ext;
            $target_file = $target_dir . $img_name;
            move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target_file);
        }
    }

    if(empty($error_name) && empty($error_price) && empty($error_image) && empty($error_scat))
    {
        include 'db_conn.php';

    	$sqlquery= "UPDATE product SET fname ='".$_POST['fname']."' , price ='".$_POST['price']."' , uploadFile='".$img_name."' , catname = '".$_POST['catname']."' WHERE id='".$id ."' ";
        if(mysqli_query($conn, $sqlquery)){    	
    		$success="Record edited successfully";
    	}
    	else
    	{
    		echo "Error" . $sqlquery ."<br>". mysqli_error($conn);
       	}
    }
}
    else
    {
    	$pageload = true;
    }
    if($pageload)
    {
        include 'db_conn.php';

      $sql1 = "SELECT product.fname , product.price , product.uploadFile , product.catname , category1.id as cat_id FROM category1 left JOIN product ON product.catname = category1.catname where product.id='".$id."'";


    // $sql1 = "SELECT id, fname , price ,uploadFile ,catname from product where id=$id";
  $result= mysqli_query($conn, $sql1);
  $num= mysqli_num_rows($result);
  // print_r($num);
  if($num > 0)
  {
      while($row= mysqli_fetch_assoc($result))
      {
                $fname = $row['fname'];
                $price = $row['price'];
                $uploadFile = $row['uploadFile'];
                $catname = $row['catname'];
      }
  }

}
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
                        <div class="form_container_block">

		<form id="edit_product" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ."?id=" . $id ?>" method="post" enctype="multipart/form-data" class="cmxform">    


				<ul>
					<li class="fileds">
						<div class="name_fileds">
							<label>Product Name</label><label class="error" style="color: red"><?php echo $error_fname; ?></label> 
							<input name="fname" type="text" value="<?php echo $fname; ?>"> 
						</div>
					</li>
					<li class="fileds">
						<div class="name_fileds">
							<label>Product Price</label><label class="error" style="color:red"><?php echo $error_price; ?></label>
							<input name="price" type="text" value="<?php echo $price; ?>"> 
						</div>
					</li>
					<li class="fileds">
						<div class="upload_fileds">
							<label>Upload Image</label><?php echo $error_image; ?></label>
              <?php if (!empty($uploadFile) && file_exists('images/' . $uploadFile)) { ?>
                  <img src="images/<?php echo $uploadFile; ?>" style="width:100px; height:auto; margin: 2px;" alt="Image NOT Available"><?php } ?>
              <input name="uploadFile" id="uploadFile" type="file" style="width:380px">
						</div>						
					</li>
					<li class="fileds">
						<div class="name_fileds">
							<label>Select Category</label>
                

                                      <select name="catname" class="category custom_dropdown required">
                                        <?php
                                        $sqlquery = "SELECT id, catname From category1";

                                        $result = $conn->query($sqlquery);
                                        if ($result->num_rows > 0) {
                                            while ($row1 = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo $row1['catname'] ?>"
                                                <?php if ($id == $row1['id']) {
                                                    echo 'selected="selected"';
                                                } ?>
                                                        >
                                                <?php echo $row1['catname'];?>

                                                </option>
                                                <?php
                                            }
                                        }
                                        mysqli_close($conn);
                                        ?>
                                </select>

						</div>
					</li>
				</ul>
				<div class="next_btn_block">
                            <div class="next_btn">
                                <input type="submit" class="btn-success" value="Submit">
                            </div>				<!--<div class="next_btn">
						<a href="product.php">Submit  <span><img src="images/small_triangle.png" alt="small_triangle"> </span></a>
					</div>-->
				</div>
		</form>
                    </div>

		</div>
	</div>		
  </div>

      <script src="js/jquery.validate.min.js" type="text/javascript"></script> 
<!--
<script type="text/javascript">

                                $(document).ready(function () {
    <?php if (!empty($success)) { ?>
                                            alert('<?php echo $success; ?>');
    <?php } ?>
                                        $("#edit_product").validate({
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
                                    </script>-->

<?php

include 'footer.php';

  ?>