<div class="col-md-12 footer-box">
        <div class="row">
            <div class="col-md-4">
                <strong>ЗА ВРЪЗКА С НАС</strong>
                <hr>
				<?php
				if(isset($_POST['send_email']))
				{
					$name = mysqli_real_escape_string($connection, $_POST['name']);
					$email = mysqli_real_escape_string($connection, $_POST['email']);
					$message = mysqli_real_escape_string($connection, $_POST['message']);
					$user_ip = getenv('REMOTE_ADDR');
					$date = time();

					$database->send_email_to_us($name, $email, $message, $user_ip, $date);
					$database->message_box(2, "Вие успешно изпратихте имейл до нас.");
					echo "<meta http-equiv='refresh' content='3;url=index.php'>";
					echo '<br />';
				}
				?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" required="required" placeholder="Име">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" required="required" placeholder="Имейл адрес">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <textarea name="message" id="message" required="required" class="form-control" rows="3" placeholder="Съобщение"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="send_email" class="btn btn-primary">Изпрати</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <strong>ЗА НАС</strong>
                <hr>
                <p>
                   Някъв текст<br>
                </p>
            </div>
            <div class="col-md-4 social-box">
                <strong>Последвайте ни в... </strong>
                <hr>
                <a href="#"><i class="fa fa-facebook-square fa-3x "></i></a>
                <a href="#"><i class="fa fa-twitter-square fa-3x "></i></a>
            </div>
        </div>
        <hr>
    </div>