<?php
/*******************************************************************************
*  @Author:  Красимир 'Jeff' Колев
*******************************************************************************/

class DataBase
{
	protected $db_name = 'ribki';
	protected $db_user = 'root';
	protected $db_pass = '';
	protected $db_host = 'localhost';
	public $connect_db;
	public $users_table = 'users';
	public $listings_table = 'listings';
	public $contact_table = 'contacts';
	public $message_box;

	public function connect()
	{
        $this->connect_db = new mysqli( $this->db_host, $this->db_user, $this->db_pass, $this->db_name );

        if ( mysqli_connect_errno() ) {
            printf("Connection failed: %s\
", mysqli_connect_error());
            exit();
        }
        return $this->connect_db;

    }
	
	public function get_connection()
	{
        return $this->connect_db;
    }
	
	public function message_box($msg_type, $msg_body)
	{
		$msg_type = strtoupper($msg_type);
		switch ($msg_type)
		{
			case "ERROR": case "1":
				$class_name = "error_msg_003";
			break;
			case "SUCCESS": case "2":
				$class_name = "success_msg_003";
			break;
			case "INFO": case "3":
				$class_name = "info_msg_003";
			break;
			case "WARNING": case "4":
				$class_name = "warning_msg_003";
			break;
		}
		echo'<div id="msg_1" class="'.$class_name.'">
		<div id="image" class="msg_003_image"></div>
		'.$msg_body.'
		</div>';
	}
	
	public function save($username, $password, $email, $time_registered, $user_ip)
    {
		$sql = $this->connect_db->prepare("INSERT INTO " . $this->users_table . " (username, password, email, time_registered, user_ip) VALUES(?, ?, ?, ?, ?)") or die ($this->connect_db->error($sql));
			$sql->bind_param("sssss", $username, $password, $email, $time_registered, $user_ip);
			if($sql->execute())
			{
				$sql->close();
				$this->connect_db->close();
				return true;
			}
	}
	
	public function new_listing($title, $fish_cat, $description, $price, $time_added, $newfilename, $user_id)
    {
		$sql = $this->connect_db->prepare("INSERT INTO " . $this->listings_table . " (title, fish_cat, description, price, time_added, photo_url, user_id) VALUES(?, ?, ?, ?, ?, ?, ?)") or die ($this->connect_db->error($sql));
			$sql->bind_param("ssssssi", $title, $fish_cat, $description, $price, $time_added, $newfilename, $user_id);
			if($sql->execute())
			{
				$sql->close();
				$this->connect_db->close();
				return true;
			}
	}
	
	public function send_email_to_us($name, $email, $message, $user_ip, $date)
    {
		$sql = $this->connect_db->prepare("INSERT INTO " . $this->contact_table . " (name, email, message, user_ip, date) VALUES(?, ?, ?, ?, ?)") or die ($this->connect_db->error($sql));
			$sql->bind_param("sssss", $name, $email, $message, $user_ip, $date);
			if($sql->execute())
			{
				$sql->close();
				$this->connect_db->close();
				return true;
			}
	}
	
	public function update_user_password($new_password, $new_password2, $user_id)
    {
		$sql = $this->connect_db->prepare("UPDATE " . $this->users_table . " SET password=? WHERE id=?") or die ($this->connect_db->error($sql));
			$sql->bind_param("si", $new_password, $user_id);
			if($sql->execute())
			{
				$sql->close();
				$this->connect_db->close();
				return true;
			}
	}
	
	public function delete_user_profile($user_id)
    {
		$sql = $this->connect_db->prepare("DELETE FROM " . $this->users_table . " WHERE id=?") or die ($this->connect_db->error($sql));
			$sql->bind_param("i", $user_id);
			if($sql->execute())
			{
				$sql->close();
				$this->connect_db->close();
				return true;
			}
	}
	
	public function delete_listing($id)
    {
		$sql = $this->connect_db->prepare("DELETE FROM " . $this->listings_table . " WHERE id=?") or die ($this->connect_db->error($sql));
			$sql->bind_param("i", $id);
			if($sql->execute())
			{
				$sql->close();
				$this->connect_db->close();
				return true;
			}
	}
	
	public function save_user_info($name, $user_from, $user_gsm, $user_id)
    {
		$sql = $this->connect_db->prepare("UPDATE " . $this->users_table . " SET name=?, user_from=?, user_gsm=? WHERE id=?") or die ($this->connect_db->error($sql));
			$sql->bind_param("sssi", $name, $user_from, $user_gsm, $user_id);
			if($sql->execute())
			{
				$sql->close();
				$this->connect_db->close();
				return true;
			}
	}

	public function login($email, $password)
    {
            if($result = $this->connect_db->query("SELECT * FROM " . $this->users_table . " WHERE email = '$email' AND password = '$password'"))
            {
                if($result->num_rows > 0)
                {
                    while($row = $result->fetch_assoc())
                    {
                        $_SESSION['online'] = true;
                        $_SESSION['username'] = $row['username'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['id'] = $row['id'];
						$_SESSION['user_ip'] = $row['user_ip'];
						$_SESSION['money'] = $row['money'];
						$_SESSION['time_registered'] = $row['time_registered'];
						
						$this->message_box(2, "Вие успешно влезнахте в акаунта си!");
						header("refresh:2; url=index.php");
                    }
                }
					else
                {
					$this->message_box(1, "Не успешен вход!");
					header("refresh:2; url=profile.php");
                    $_SESSION['online'] = false;
                }
            }
				else
            {
                $_SESSION['online'] = false;
				$this->message_box(1, "Не успешен вход!");
				header("refresh:2; url=profile.php");
			}
            $result->close();
            $this->connect_db->close();
        }
}

$database = new DataBase();
$database->connect();
$connection = $database->get_connection();

mysqli_query($connection, "SET NAMES UTF8");
?>