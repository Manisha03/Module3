<?php
$i=0;
$offset=0;
$limit=6;
if(isset($_GET['page']))
{
    $offset=($_GET['page']-1)*$limit;
}
if(isset($_GET['id'])) {
    $id = $_GET['id'];

}
include 'db_conn.php';
include 'header.php';
?>

  <div class="section banner_section who_we_help">
  	<div class="container">
  		<h4> Category List</h4>
  	</div>
  </div>

  <!-- Content Section Start-->
  <div class="section content_section">
	<div class="container">
		<div class="filable_form_container">
			<div class="mange_buttons">
				<ul>
					<!--<li class="search_div" >
				 <div class="Search">
				 	<input name="search" type="text" /> 
				 	<input type="submit" class="submit" value="submit">
				 </div>
					</li>-->
					<li><a href="createp.php">Create Product</a></li>
					<li><a href="#">Delete</a></li>
				</ul>
			</div>
			<div class="table_container_block">
				<table width="100%">
					<thead>
						<tr>
						<th width="10%">
							<input type="checkbox" class="checkbox" id="checkbox_sample18"> <label class="css-label mandatory_checkbox_fildes" for="checkbox_sample18"></label>
						</th>
					<!--	<th style="">Product Id</th>-->
						<th style="">Product Name <!--<a href="#" class="sort_icon"><img src="images/sort.png"></a>--></th>
						<th style="">Product Image</th>
						<th style="">Product Price</th>
						<th style="">Product Category <!--<a href="#" class="sort_icon"><img src="images/sort.png"></a>--></th>
						<th>Action</th>
						</tr>
					</thead>
					<tbody>

                        <?php
                        /*
                         * Displays the list of product as per the given category Id's after applying limit and offset on it 
                         */
                        include 'db_connc.php';

                     /*   if (empty($id)) {
                            $sqlquery = "SELECT product.id AS prod_id,product.fname,product.uploadFile,  
                                     product.price,category1.catname AS cat_name 
                                     FROM   category1  
                                     LEFT JOIN product  
                                     ON category1.id = product.catname WHERE product.status = 1 LIMIT ".$limit." OFFSET ".$offset;

                        } else {
                            $sqlquery = "SELECT product.id AS prod_id,product.fname,product.uploadFile,  
                                     product.price,category1.catname AS cat_name 
                                     FROM   category1  
                                     LEFT JOIN product  
                                     ON category1.id = product.catname WHERE 
                                     product.catname = '" . $id . "' AND product.status = 1 LIMIT ". $limit." OFFSET ". $offset;
                                                                          print_r($id);

                        //}
                        $result = $conn->query($sqlquery);
                        if($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {*/
 
                              
                    $sqlquery= "SELECT id ,fname , price, uploadFile, catname FROM product";
                $result = $conn->query($sqlquery);
                    if($result->num_rows > 0)
                    {
                      while ($row =$result->fetch_assoc()) {

                    ?>




                               
              <tr>
							<td>
								<input type="checkbox" class="checkbox" id="<?php echo $row['prod_id']; ?>" value="<?php echo $row['prod_id']; ?>"> <label class="css-label mandatory_checkbox_fildes" for="<?php echo $row['prod_id'] ?>"></label>
							</td>
							<!--<td><?php echo $row['id']; ?> </td>-->
							<td><?php echo $row['fname']; ?></td>

                                    <td style="text-align:center">
                                        <?php if (!empty($row['uploadFile'])) { ?>
                                            <?php if (!file_exists('images/' . $row['uploadFile'])) { ?>
                                                <img src="images/noimage.jpg" style="width:80px; height:auto;" alt="Image NOT Available">
                                            <?php } else { ?>
                                                <img src="images/<?php echo $row['uploadFile']; ?>" style="width:80px; height:auto;">
                                            <?php }
                                        } else { ?>    
                    <img src="images/noimage.jpg" style="width:80px; height:auto;" alt="Image NOT Available"><?php } ?></td>




							<td style="text-align:right"><?php echo $row['price']; ?></td>
							<td><?php echo $row['catname']; ?></td>

							<td>
								<div class="buttons">
								 <a href="editp.php?<?php echo "id=" . $row['id'] . "" ?>"><button class="btn btn_edit" >Edit</button></a>
								  <button class="btn btn_delete">Delete</button>
								</div>								
							</td>
						</tr>
					<?php
                    
                    	}
                    }
                   ?>

					</tbody>

				</table>
			</div>

          <div class="pagination_listing">
        <ul>
          <li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_products.html#">first</a></li>
          <li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_products.html#">1</a></li>
          <li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_products.html#">2</a></li>
          <li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_products.html#">3</a></li>
          <li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_products.html#">4</a></li>
          <li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_products.html#">Last</a></li>
        </ul>
      </div>
			

         <!--   <div class="pagination">
                <ul>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?page=1" ?>">first</a></li>
                    <?php 
                
                                            include 'db_connc.php';

                    if (empty($id)){
                    $sql= "SELECT count(*) as count from product where status=1";
                    }else{
                        $sql= "SELECT count(*) as count from product where catname=".$id." AND status=1";
                    }
                    $result = $conn->query($sql);
//                    print_r($result);
                    $row = $result->fetch_assoc();
                    $total_entry= $row['count'];
                    do{
                    ?>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?page=".($i+1) ?>"<?php if(($i*$limit)==($offset)){echo 'class="selected"';}?>><?php echo $i+1;?></a>
                    <?php $i++; 
                    } while($i<$total_entry/$limit);
                    mysqli_close($conn);?>
                    <li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?page=".$i ?>">last</a></li>
                </ul>
</div>-->

		</div>
	</div>		
  </div>

  <script type="text/javascript">
   
    $(document).ready(function () {
        $("#checkall").change(function () {
            if (this.checked) {
                $("input.checkbox_check").each(function () {
                    this.checked = true;
                })
            } else {
                $("input.checkbox_check").each(function () {
                    this.checked = false;
                })
            }
        });
        $("input.checkbox_check:checkbox").click(function () {
            if (!this.checked) {
                $("#checkall").prop('checked', false);
            }
        });
    });
</script>

  <?php
include 'footer.php';
  ?>