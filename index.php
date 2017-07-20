<?php
session_start();
include_once("libs/database.php");
?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Silahkan Login Ke Sistem</title>
    <link rel="icon" href="img/logo.png"/>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/stylelogin.css">
</head>

<body>
  <div class="form">
      <ul class="tab-group">
          <li class="tab active"><a href="#login">Masuk Sistem</a></li>
          <li class="tab"><a href="#signup">Daftar ke Sistem</a></li>
          <li class="tab"><a href="#backupdata">Backup Data</a></li>
          <li class="tab"><a href="#restoredata">Restore Data</a></li>
      </ul>
      <div class="tab-content">
          <div id="login">
              <?php
              ini_set('display_errors', 1);
              if(isset($_POST['login'])){
                  $user   = htmlentities($_POST['username']);
                  $pass   = htmlentities($_POST['password']);

                  $sql = $db->prepare("SELECT COUNT(*) FROM PEGAWAI WHERE USERNAMA=:userr AND PASSWORD=:pass");
                  $sql->bindParam(":userr", $user);
                  $sql->bindParam(":pass", $pass);
                  $sql->execute();
                  $itung = $sql->fetchColumn();

                  $sql1 = $db->prepare("SELECT * FROM PEGAWAI WHERE USERNAMA=:userr AND PASSWORD=:pass");
                  $sql1->bindParam(":userr", $user);
                  $sql1->bindParam(":pass", $pass);
                  $sql1->execute();
                  $dd = $sql1->fetchAll();

                  if($itung == 1){
                      $_SESSION['iduser'] = $dd[0][0];
                      header("location: main/index.php");
                  }else{
                     echo "<h1>Username atau Password Salah!</h1>";
                  }
              }else { ?>
                <h1>Selamat Datang</h1>
              <?php } ?>
              <form action="" method="post">
                  <div class="field-wrap">
                      <label>Username<span class="req">*</span></label>
                      <input type="text" name="username" required autocomplete="off"/>
                  </div>
                  <div class="field-wrap">
                      <label>Password<span class="req">*</span></label>
                      <input type="password" name="password" required autocomplete="off"/>
                  </div>
                  <button type="submit" name="login" value="Login" class="button button-block"/>Masuk Sekarang</button>
              </form>
          </div>

          <div id="signup" style="display: none">
              <?php
              if(isset($_POST['signup'])){
                  $sql2 = $db->prepare("INSERT INTO PEGAWAI VALUES (:u0, :u1, :u2, :u3, :u4)");
                  $sql2->bindParam(":u0", $_POST['idpeg']);
                  $sql2->bindParam(":u1", $_POST['nama']);
                  $sql2->bindParam(":u2", $_POST['alamat']);
                  $sql2->bindParam(":u3", $_POST['user']);
                  $sql2->bindParam(":u4", $_POST['pass']);
                  $sql2->execute();
                  if($sql2->execute()){
                      echo "<h1>Anda Sudah Terdaftar. Silahkan Login!</h1>";
                  }
              }else { ?>
                  <h1>Daftar ke Sistem</h1>
              <?php } ?>
              <form action="" method="post">
                  <div class="field-wrap">
                      <label>IDPegawai<span class="req">*</span></label>
                      <input type="text" name="idpeg" required autocomplete="off"/>
                  </div>
                  <div class="field-wrap">
                      <label>Nama Anda<span class="req">*</span></label>
                      <input type="text" name="nama" required autocomplete="off"/>
                  </div>
                  <div class="field-wrap">
                      <label>Username<span class="req">*</span></label>
                      <input type="text" name="user" required autocomplete="off"/>
                  </div>
                  <div class="field-wrap">
                      <label>Password<span class="req">*</span></label>
                      <input type="password" name="pass" required autocomplete="off"/>
                  </div>
                  <div class="field-wrap">
                      <label>Alamat<span class="req">*</span></label>
                      <input type="text" name="alamat" required autocomplete="off"/>
                  </div>
                  <button type="submit" name="signup" value="SignUp" class="button button-block"/>Daftar Sekarang</button>
              </form>
          </div>
		  
		  <div id="backupdata" style="display: none">
			<h1>Form Backup Data</h1>
			<?php
			if(isset($_POST['backup']))
			{
				exec("c:/xampp/mysql/bin/mysqldump -uroot dbvalas > f:/valasbackup/dbvalas".date("Y-m-d").".sql");
			}
			?>
			<form method="post" action="">
				<button type="submit" name="backup" value="backupdata" class="button button-block"/>Backup Data</button>
			</form>
		  </div>
		  
		  <div id="restoredata" style="display: none">
			<h1>Form Restore Data</h1>
			<?php
			if(isset($_POST['restore']))
			{
				$tempdir 	= "temp/";
				$target		= $tempdir.basename($_FILES['datasql']['name']);
				move_uploaded_file($_FILES['datasql']['tmp_name'], $target);
				exec('c:/xampp/mysql/bin/mysql -uroot -e "drop database dbvalas"');
				exec('c:/xampp/mysql/bin/mysql -uroot -e "create database dbvalas"');
				exec('c:/xampp/mysql/bin/mysql -uroot dbvalas < c:/xampp/htdocs/valas/'.$target);
			}
			?>
			<form method="post" action="" enctype="multipart/form-data">
				<input type="file" name="datasql" /><br>
				<button type="submit" name="restore" value="restoredata" class="button button-block"/>Restore Data</button>
			</form>
		  </div>
      </div><!-- tab-content -->
      
</div> <!-- /form -->
<script src='js/jquery.min.js'></script>
<script src="js/jslogin.js"></script>
</body>
</html>
