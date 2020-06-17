<div class="container">
        <div class="row">
            <div class="col-md-12">
                
                    <div id="mi-slider" class="mi-slider">
					<ul>
				<li><a href="#">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_R9rfYUsdfpzMR4T9BjOLapBVIyacqEObhUQTtxbGDGY5dkkO" alt="img01" alt="" />
                            </a></li>
							<li><a href="#">
                               <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_R9rfYUsdfpzMR4T9BjOLapBVIyacqEObhUQTtxbGDGY5dkkO" alt="img01" alt="" />
                            </a></li>
				</ul>
				<ul>
				<li><a href="#">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_R9rfYUsdfpzMR4T9BjOLapBVIyacqEObhUQTtxbGDGY5dkkO" alt="img01" alt="" />
                            </a></li>
				<li><a href="#">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_R9rfYUsdfpzMR4T9BjOLapBVIyacqEObhUQTtxbGDGY5dkkO" alt="img01" alt="" />
                            </a></li>
				</ul>
                        <nav>
						<?php
						$sql = mysqli_query($connection, "SELECT * FROM
						fish_cats 
						ORDER BY id");
						while($row = mysqli_fetch_assoc($sql))
						{
							echo '<a href="#">' . $row['cat_name'] . '</a>';
			
						}
						?>
                        </nav>
                    </div>
                    

                <br />
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->