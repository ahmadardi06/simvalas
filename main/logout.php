<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:58
 */
?>
<div class="col-sm-offset-4 col-sm-4 text-center">
    <div class="panel panel-danger">
        <div class="panel-heading">Peringatan Sistem</div>
        <div class="panel-body">
            Apakah anda yakin mau keluar sistem?
            <br><br>
            <form action="prosesLogout.php" method="post">
                <a href="index.php" class="btn btn-default">Kembali</a>
                <button class="btn btn-danger" type="submit" name="btnLogout" value="OK">Logout Sekarang</button>
            </form>
        </div>
    </div>
</div>