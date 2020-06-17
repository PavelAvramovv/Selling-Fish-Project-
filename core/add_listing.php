<div class="form">
<?php
$target_dir = "uploads/";
$newfilename = $target_dir . time() . '_' . rand(100, 999) . '.' . end(explode(".",$_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($newfilename,PATHINFO_EXTENSION));

if(isset($_POST['add']))
		 {
			   $fileToUpload = mysqli_real_escape_string($connection, $_POST['fileToUpload']);
			   $title = mysqli_real_escape_string($connection, $_POST['title']);
			   $fish_cat = mysqli_real_escape_string($connection, $_POST['fish_cat']);
			   $description = mysqli_real_escape_string($connection, $_POST['description']);
			   $price = mysqli_real_escape_string($connection, $_POST['price']);
			   $time_added = time();
			   $file_temp = $_FILES["fileToUpload"]['tmp_name'];   
    $check = getimagesize($file_temp);
	
    if($check !== false)
	{
        $uploadOk = 1;
    }
		else
	{
        $database->message_box(4,"Файлът трябва да е изображение!");
		echo "<meta http-equiv='refresh' content='2;url=adding.php'>";
        $uploadOk = 0;
    }
if ($_FILES["fileToUpload"]["size"] > 500000)
{
    echo "Прекалено е голямо е изображението!";
	echo "<meta http-equiv='refresh' content='2;url=adding.php'>";
    $uploadOk = 0;
}
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" )
{
	echo '<br />';
	$database->message_box(4,"Разрешените формати са: <b>.jpg</b>, <b>.png</b>, <b>.gif</b>");
	echo "<meta http-equiv='refresh' content='2;url=adding.php'>";
    $uploadOk = 0;
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename))
	{
        echo "";
    }
		else
	{
        echo "Възникна грешка с качването на изображението.";
    }
			   $database->new_listing($title, $fish_cat, $description, $price, $time_added, $newfilename, $_SESSION['id']);
			   $database->message_box(2, "Вие успешно добавихте обявата!");
			   echo "<meta http-equiv='refresh' content='2;url=my_profile.php'><br />";
}
		   }
		   ?>
      <ul class="tab-group">
	  <li class="tab active"><a href="#add">Добави обява</a></li>
	  <li class="tab"><a href="#contact">Данни за контакт</a></li>
      </ul>
      
      <div class="tab-content">
	  <div id="add">   
          <form action="" method="post" enctype="multipart/form-data">
            <div class="field-wrap">
            Заглавие на обявата
            <input type="text" name="title" required autocomplete="off"/>
          </div>
          <div class="field-wrap">
            Категория
			<select name="fish_cat">
			<option disabled>-Избери-</option>
			<?php
			$cat = mysqli_query($connection, "SELECT cat_id, cat_name 
			FROM fish_cats");
			while($row_cat = mysqli_fetch_assoc($cat))
			{
				echo '<option value="' . $row_cat['cat_id'] . '">' . $row_cat['cat_name'] . '</option>';
			}
			?>
			</select>
          </div>
		  <div class="field-wrap">
            Снимка
            <input type='file' name='fileToUpload' id='fileToUpload' />
          </div>
		  
         <div class="field-wrap">
            Описание
            <textarea type="text" name="description" rows="5"> </textarea>
          </div>
		  <div class="field-wrap">
            Цена (.лв)
            <input type="text" name="price" required autocomplete="off"/>
          </div>
          <button type="submit" name="add" class="button button-block">Напред</button>
          </form>
        </div>
	  
        <div id="contact">   
          <form action="" method="post">
		  <?php 
		  $sql = mysqli_query($connection, "SELECT * FROM users WHERE id= '" . $_SESSION['id'] . "'");
		  $row = mysqli_fetch_assoc($sql);
		  ?>
          <div class="field-wrap">
		  Имейл адрес
            <input type="email" name="email" value="<?php echo $row['email']; ?>" disabled>
          </div>
        
          </form>
        </div>
      </div>
</div>

<link href="templates/default/css/login_register.css" rel="stylesheet">