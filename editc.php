<?php


$error = '';
$success = '';
$page_load = true;


if(isset($_GET['id'])){
    $id=$_GET['id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['edit_category_name'])) {
        $error = "This is required";
    } else if (!preg_match('/^[a-zA-Z]/', $_POST['edit_category_name'])) {
        $error = 'Only Alphabets ';
    }
    if (empty($error)) {
        include 'db_conn.php';
        $catname = $_POST['edit_category_name'];
        $sqlquery = "UPDATE category1 SET catname='" . $catname . "' where id='".$id."'";
        if ($conn->query($sqlquery)) {
             $success = 'Category Edited Succesfully';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error();
        }
        mysqli_close($conn);
    } else {
        $page_load = true;
    }
} else {
    $page_load = true;
}
if ($page_load) {
    include 'db_conn.php';

    $sqlquery="SELECT * from category1 where id='".$id."'";
    $res=$conn->query($sqlquery);
    $edit_name = $res->fetch_assoc()['catname'];
    mysqli_close($conn);
    ?>
<?php include 'header.php'; ?>
    <div class="section banner_section who_we_help">
        <div class="container">
            <h4>EDIT CATEGORY</h4>
        </div>
    </div>
    <div class="section content_section">
        <div class="container">
            <div class="filable_form_container">
                <div class="form_container_block">
                    <form id="add_category" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?id=".$id); ?>" method="post" class="cmxform">
                        <ul>
                            <li class="fileds">
                                <div class="name_fileds">
                                    <label>Edit Category Name</label>
                                    <input name="edit_category_name" type="text" value="<?php echo $edit_name?>"> 
                                </div>
                                <label class="error"><?php echo $error; ?><label>
                            </li>
                        </ul>
                        <div class="next_btn_block">
                            <div class="next_btn">
                                <input type="submit" class="btn-success" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>      
    </div>  
    <script src="../js/jquery.validate.min.js" type="text/javascript"></script> 
    <script src="../js/custom_validation.js" type="text/javascript"></script>
    <script type="text/javascript">
     $(document).ready(function () {
         /*
         * Validates the Catergory field , if proper sumbits the  form
         */
    <?php if (!empty($success)) { ?>
            alert('<?php echo $success; ?>');
   <?php } ?>

            $("#add_category").validate({
                rules: {
                    edit_category_name: {
                        required: true,
                        pass: true
                    }
                },
                messages: {
                    edit_category_name: {
                        required: 'This field is Required*'
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>

    <?php
    include 'footer.php';
}
    ?>