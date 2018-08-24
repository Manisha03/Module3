
  
<?php
$i = 0;
$offset = 0;
$limit = 10;
if (isset($_GET['page'])) {
    $offset = ($_GET['page'] - 1) * $limit;
}
include 'db_connc.php';
include 'header.php'; 
?>

  <!--header-ends-->

  <div class="section banner_section who_we_help">
  	<div class="container">
  		<h4>Manage Category</h4>
  	</div>
  </div>

  <!-- Content Section Start-->
  <div class="section content_section">
	<div class="container">
		<div class="filable_form_container">
			<div class="mange_buttons">
				<ul>
					<!--<li class="search_div">
				 <div class="Search">
				 	<input name="search" type="text" /> 
				 	<input type="submit" class="submit" value="submit">
				 </div>
					</li> -->
					<li><a href="createc.php">Create Category</a></li>
					<li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_categories.html#">Delete</a></li>
				</ul>
			</div>
			<div class="table_container_block">
				<table width="100%">
					<thead>
						<tr>
						<th width="10%">
							<input type="checkbox" class="checkbox" id="checkbox_sample18"> <label class="css-label mandatory_checkbox_fildes" for="checkbox_sample18"></label>
						</th>
						<th style="width:60%">Name <!--<a href="#" class="sort_icon"><img src="images/sort.png"></a>--></th>
						<th>Action</th>
						</tr>
					</thead>
					<tbody>

					 <?php
						   $sqlquery = "SELECT id , catname from category1";
                        $result = $conn->query($sqlquery);
                        if ($result-> num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>

						<tr>
							<td>
								<input type="checkbox" class="checkbox" id="checkbox_sample19"> <label class="css-label mandatory_checkbox_fildes" for="checkbox_sample19"></label>
							</td>
							<td><?php echo $row['catname'] ?></td>


							<td>
								<div class="buttons">
								 <a href="editc.php?<?php echo "id=".$row['id']; ?>"> <button class="btn btn_edit">Edit</button></a>
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
					<li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_categories.html#">first</a></li>
					<li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_categories.html#">1</a></li>
					<li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_categories.html#">2</a></li>
					<li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_categories.html#">3</a></li>
					<li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_categories.html#">4</a></li>
					<li><a href="http://wireframes.php-dev.in/training/v1.2/php/assignment/list_categories.html#">Last</a></li>
				</ul>
			</div>

		</div>
	</div>		
  </div>
  <!-- Content Section End-->

  <?php include 'footer.php'; ?>
