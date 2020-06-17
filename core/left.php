<div class="row">
            <div class="col-md-3">
			<?php
			$sql = mysqli_query($connection, "SELECT * FROM
			fish_cats 
			ORDER BY id");
			while($row = mysqli_fetch_assoc($sql))
			{
				$sum = mysqli_query($connection, "SELECT count(id) as total FROM listings WHERE fish_cat = '" . $row['cat_id'] . "'"); 
				$row_s = mysqli_fetch_assoc($sum);
			?>
                <div>
                    <a href="#" class="list-group-item active <?php echo $row['cat_class']; ?>"><?php echo $row['cat_name']; ?></a>
                    <ul class="list-group">
                        <li class="list-group-item">Общо обяви<span class="label <?php if($row['cat_id'] == '1') { echo 'label-primary'; } else { echo 'label-success' ;} ?> pull-right"><?php echo $row_s['total']; ?></span></li>
                    </ul>
                </div>
				<?php
			}
			?>
                
                <!-- /.div -->
                <div class="well well-lg offer-box offer-colors">
                    <span class="glyphicon glyphicon-star-empty"></span>VIP Оферта             
                   <br />
        #
		<br />
                    <a href="#">Виж</a>
                </div>
                <!-- /.div -->
            </div>