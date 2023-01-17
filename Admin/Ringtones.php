<?php
include 'koneksi.php';
error_reporting(E_ALL ^ E_NOTICE);
// proses input nada alarm
// proses input nada alarm
if (isset($_POST['addringtones'])) {
    $sumber = $_FILES['filUpload']['tmp_name'];
    $target = '../music/';
    $ringtones = $_FILES['filUpload']['name'];
    $max_id = mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(`id_alarm`) As id FROM `ringtones`"));
    $id_max = $max_id['id'] + 1;
    if ($ringtones != '') {
        if (move_uploaded_file($sumber, $target . $ringtones)) {
            $addnadaalarm =  mysqli_query($conn, "INSERT INTO `ringtones`(`id_alarm`, `Ringtones`) VALUES ('$id_max','$ringtones')");
        }
    }
}

if (isset($_POST['hapus'])) {
    $id =  $_POST['del'];
    // hapus file dalam folder
    $data1 = mysqli_query($conn, "SELECT * FROM `ringtones` WHERE `ringtones`.`id_alarm` = '$id'");
    $ringtones1 = mysqli_fetch_array($data1);
    $data_ = $ringtones1['Ringtones'];
    if (file_exists("../music/$ringtones1[Ringtones]")) {
        unlink("../music/$ringtones1[Ringtones]");
    }
    $menu = mysqli_query($conn, "DELETE FROM `ringtones` WHERE `ringtones`.`id_alarm` = '$id'");
?>
    <script>
        alert("Data Berhasil dihapus!!");
    </script>
<?php
}


include 'session.php';
$data2 = mysqli_query($conn, "SELECT * FROM `ringtones` ");
$ringtones2 = mysqli_fetch_array($data2);
?>

<!doctype html>
<html class="no-js" lang="en">

<?php
include 'head.php';
?>


<body>
    <?php
    include 'sidebar.php';
    ?>
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="logo-pro">
                        <a href="index.html"><img class="main-logo" src="img/logo/logo.png" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-advance-area">
            <?php
            include 'menu_header.php';
            include 'mode_mobile.php';
            ?>
            <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list single-page-breadcome">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <!-- <div class="breadcome-heading">
                                            <form role="search" class="sr-input-func">
                                                <input type="text" placeholder="Search..." class="search-int form-control">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                            </form>
                                        </div> -->
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <ul class="breadcome-menu">
                                            <li><a href="#">Home</a> <span class="bread-slash">/</span>
                                            </li>
                                            <li><span class="bread-blod">Ringtones</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Static Table Start -->
        <div class="data-table-area mg-b-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline13-list">
                            <div class="sparkline13-hd">
                                <div class="main-sparkline13-hd">
                                    <h1>Ringtones</h1>
                                </div>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div>
                                    <input type="file" name="filUpload"><br>
                                    <button type="submit" name="addringtones" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="false" data-show-pagination-switch="false" data-show-refresh="false" data-key-events="false" data-show-toggle="false" data-resizable="true" data-cookie="true" data-cookie-id-table="false" data-show-export="false" data-click-to-select="false" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <!-- <th data-field="state" data-checkbox="false"></th> -->
                                                <th data-field="id">ID</th>
                                                <th data-field="name" data-editable="false">Ringtones</th>
                                                <th data-field="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data2 as $row) :
                                            ?>
                                                <tr>

                                                    <td><?= $i; ?></td>
                                                    <td><?= $row['Ringtones'];  ?></td>
                                                    <!-- <td class="datatable-ct"><i class="fa fa-check"></i>
                                                    </td> -->
                                                    <td>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="del" value="<?= $row['id_alarm']; ?>">
                                                            <button type="submit" name="hapus" class="btn btn-danger">Delete</button>
                                                    </td>


                                                </tr>


                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Static Table End -->
        <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="footer-copy-right">
                            <p>Copyright © 2018. All rights reserved. Template by <a href="https://colorlib.com/wp/templates/">Colorlib</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery
		============================================ -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- wow JS
		============================================ -->
    <script src="js/wow.min.js"></script>
    <!-- price-slider JS
		============================================ -->
    <script src="js/jquery-price-slider.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="js/jquery.meanmenu.js"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/scrollbar/mCustomScrollbar-active.js"></script>
    <!-- metisMenu JS
		============================================ -->
    <script src="js/metisMenu/metisMenu.min.js"></script>
    <script src="js/metisMenu/metisMenu-active.js"></script>
    <!-- data table JS
		============================================ -->
    <script src="js/data-table/bootstrap-table.js"></script>
    <script src="js/data-table/tableExport.js"></script>
    <script src="js/data-table/data-table-active.js"></script>
    <script src="js/data-table/bootstrap-table-editable.js"></script>
    <script src="js/data-table/bootstrap-editable.js"></script>
    <script src="js/data-table/bootstrap-table-resizable.js"></script>
    <script src="js/data-table/colResizable-1.5.source.js"></script>
    <script src="js/data-table/bootstrap-table-export.js"></script>
    <!--  editable JS
		============================================ -->
    <script src="js/editable/jquery.mockjax.js"></script>
    <script src="js/editable/mock-active.js"></script>
    <script src="js/editable/select2.js"></script>
    <script src="js/editable/moment.min.js"></script>
    <script src="js/editable/bootstrap-datetimepicker.js"></script>
    <script src="js/editable/bootstrap-editable.js"></script>
    <script src="js/editable/xediable-active.js"></script>
    <!-- Chart JS
		============================================ -->
    <script src="js/chart/jquery.peity.min.js"></script>
    <script src="js/peity/peity-active.js"></script>
    <!-- tab JS
		============================================ -->
    <script src="js/tab.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>
    <!-- tawk chat JS
		============================================ -->
    <script src="js/tawk-chat.js"></script>
</body>

</html>