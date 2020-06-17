<div class="col-md-9">
                <!-- /.div -->
                <div class="row">
                    <div class="btn-group alg-right-pad">
					<?php
					$sql_count_all = mysqli_query($connection, "SELECT count(id) as total FROM listings");
					$count_all = mysqli_fetch_assoc($sql_count_all);
					?>
                        <button type="button" class="btn btn-default"><strong><?php echo $count_all['total']; ?>  </strong>обяви</button>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
		  <?php
		  $sql = mysqli_query($connection, "SELECT l.id, l.user_id, l.time_added, l.title, l.fish_cat, l.description, l.price, l.photo_url, c.cat_button_class, c.cat_id
		  FROM listings l, fish_cats c 
		  WHERE l.fish_cat = c.cat_id ORDER BY l.time_added DESC");
		  if(mysqli_num_rows($sql) > 0)
          {
		  while($row = mysqli_fetch_assoc($sql))
		  {
			echo '<div class="col-md-4 text-center col-sm-6 col-xs-6">
                        <div class="thumbnail product-box">
                            <img src="' . $row['photo_url'] . '" style="width:250px;height:200px" alt="" />
                            <div class="caption">
                                <h3><a href="view.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h3>
                                <p><a class="btn ';
								if($row['fish_cat'] == '1') { echo $row['cat_button_class']; } elseif($row['fish_cat'] == '2') { echo $row['cat_button_class']; }
								echo '" role="button">' . $row['price'] . 'лв.</a></p>
                            </div>
                        </div>
                    </div>';
		  }
		  }
			else
		  {
			  if(isset($_SESSION['online']) && $_SESSION['online'] === true)
				{
					echo '<center>Няма активни обяви<br /><br /><button class="button button-block"'; ?>onclick="location.href='adding.php';<?php echo '">Добави обява</button></center>';
				}
					else
				{
					echo '<center>Няма активни обяви<br /><br />';
				}
		 }
		  echo '</div>';
		  ?>
                <!-- /.row -->
                <div class="row">
                    <ul class="pagination alg-right-pad">
                        <li><a href="#">&laquo;</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>
                <!-- /.row -->
                </div>