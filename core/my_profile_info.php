 <div class="well">
 <?php
	   if(isset($_POST['user_info']))
		 {
			   $name = mysqli_real_escape_string($connection, $_POST['name']);
			   $user_from = mysqli_real_escape_string($connection, $_POST['user_from']);
			   $user_gsm = mysqli_real_escape_string($connection, $_POST['user_gsm']);
			   
			   $database->save_user_info($name, $user_from, $user_gsm, $_SESSION['id']);
			   $database->message_box(2, "Вие успешно направихте промени по профила си!");
			   echo "<meta http-equiv='refresh' content='2;url=my_profile.php'>";
		   } else if(isset($_POST['change_password']))
		   {
			   $new_password = mysqli_real_escape_string($connection, $_POST['new_password']);
			   $new_password2 = mysqli_real_escape_string($connection, $_POST['new_password2']);
			   if ($new_password <> $new_password2)
			   {
					$database->message_box(1, "Паролите не съвпадат!");
					echo "<meta http-equiv='refresh' content='2;url=my_profile.php'>";
			   }
					else
			   {
					$database->update_user_password($old_password, $new_password, $new_password2, $_SESSION['id']);
			   
					$database->message_box(2, "Вие успешно променихте вашата парола!");
					echo "<meta http-equiv='refresh' content='2;url=my_profile.php'>";
				}
		   } else if(isset($_POST['delete_profile']))
		   {
			   session_start();
			   session_destroy();
				
			   $database->delete_user_profile($_SESSION['id']);
			   $database->message_box(2, "Вие успешно изтрихте вашият профил!");
			   echo "<meta http-equiv='refresh' content='2;url=index.php'>";
		   }
		   ?>
		   <br />
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
		<div class="row">
		  <?php
		  $sql = mysqli_query($connection, "SELECT l.id, l.user_id, l.time_added, l.title, l.fish_cat, l.description, l.price, l.photo_url, c.cat_button_class, c.cat_id
		  FROM listings l, fish_cats c 
		  WHERE l.user_id = '" . $_SESSION['id'] . "' AND l.fish_cat = c.cat_id 
		  ORDER BY l.time_added DESC");
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
								if($row['cat_id'] == '1') { echo $row['cat_button_class']; } elseif($row['cat_id'] == '2') { echo $row['cat_button_class']; }
								echo '" role="button">' . $row['price'] . 'лв.</a>
								<form >
								<input class="btn btn-danger"';?> onclick="location.href='delete_listing.php?id=<?php echo $row['id']; ?>';" <?php echo 'value="Изтрий" /></p>
                            </div>
                        </div>
                    </div>';
		  }
		  }
			else
		  {
			  echo '<center>Нямаш активни обяви<br /><br /><button class="button button-block"'; ?>onclick="location.href='adding.php';<?php echo '">Добави обява</button></center>';
		  }
		  echo '</div>';
		  ?>
        </div>
        <div class="tab-pane fade in" id="tab2">
         <center> Нямаш съобщения</center>
        </div>
        <div class="tab-pane fade in" id="tab3">
		<style>
		.details { display: none; }
		.details2 { display: none; }
		.details3 { display: none; }
		</style>
          <button class="button button-block project" type="button" onclick="location.href='javascript:project();'">Редакция на профила</button>
		  <div class="details">
		  <br />
		   <div class="form">
		   <?php
		   $sql = mysqli_query($connection, "SELECT * FROM users WHERE id= '" . $_SESSION['id'] . "'");
		   $row = mysqli_fetch_assoc($sql);
		   ?>
		   <form action="" method="post">
		  <div class="field-wrap">
            Име
            <input type="username" name="name" value="<?php echo $row['name']; ?>" required autocomplete="off"/>
          </div>
          <div class="field-wrap">
            Населено място
            <input type="text" name="user_from" value="<?php echo $row['user_from']; ?>" required autocomplete="off"/>
          </div>
          <div class="field-wrap">
            Телефонен номер
            <input type="text" name="user_gsm" value="<?php echo $row['user_gsm']; ?>" required autocomplete="off"/>
          </div>
           <center><button type="submit" name="user_info">Запази</button></center>
          </form>
		  </div>
		  </div><br />
		   <button class="button button-block project2" type="button" onclick="location.href='javascript:project2();'">Промяна на парола</button>
		   <div class="details2">
		   <br />
		   <div class="form">
		   <form action="" method="post">
          <div class="field-wrap">
            <label>
              Нова парола<span class="req">*</span>
            </label>
            <input type="password" name="new_password" required autocomplete="off"/>
          </div>
          <div class="field-wrap">
            <label>
              Повторете паролата<span class="req">*</span>
            </label>
            <input type="password" name="new_password2" required autocomplete="off"/>
          </div>
           <center><button type="submit" name="change_password">Промени</button></center>
          </form>
		  </div>
		  </div><br />
		   <button class="button button-block project3" type="button" onclick="location.href='javascript:project3();'">Действия по моя профил</button>
		   <div class="details3"><br />
		   <form action="" method="post" name="delete_profile">
		   <center><button type="submit" name="delete_profile">Изтриване на профила</button></center>
		   </form>
		   </div>
        </div>
      </div>
    </div>
    
    </div>