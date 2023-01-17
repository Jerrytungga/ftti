<?php
include 'koneksi.php';
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Asia/Jakarta');
$hari_ini = date('Y-m-d');
$waktu_sekarang = date('H:i:s');
include 'session.php';

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
                                            <li><span class="bread-blod">Schedule History</span>
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
                                    <h1>Schedule History</h1>
                                </div>
                            </div>
                            <form action="" method="POST" id="form_id">
                                <label for="">Filter :</label>
                                <select name="weekly" onChange="document.getElementById('form_id').submit();">
                                    <option value="">Select Week</option>
                                    <option value="Orientation">Orientation</option>
                                    <option value="PT1">PT1</option>
                                    <option value="PT2">PT2</option>
                                    <option value="PT3">PT3</option>
                                    <option value="R1">R1</option>
                                    <option value="R2">R2</option>
                                    <option value="R3">R3</option>
                                    <option value="R4">R4</option>
                                    <option value="R5">R5</option>
                                    <option value="R6">R6</option>
                                    <option value="R7">R7</option>
                                    <option value="R8">R8</option>
                                    <option value="R9">R9</option>
                                    <option value="R10">R10</option>
                                    <option value="R11">R11</option>
                                    <option value="R12">R12</option>
                                    <option value="R13">R13</option>
                                    <option value="R14">R14</option>
                                    <option value="R15">R15</option>
                                    <option value="R16">R16</option>
                                    <option value="R17">R17</option>
                                    <option value="R18">R18</option>
                                    <option value="Evaluasi">Evaluasi</option>
                                </select>
                            </form>

                            <!-- <a href="Add_schedule.php" class="btn btn-danger">Histori Schedule</a> -->
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">

                                    <!-- <div id="toolbar">
                                        <select class="form-control dt-tb">
                                            <option value="">Export Basic</option>
                                            <option value="all">Export All</option>
                                            <option value="selected">Export Selected</option>
                                        </select>
                                    </div> -->
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="false" data-show-pagination-switch="false" data-show-refresh="false" data-key-events="false" data-show-toggle="false" data-resizable="true" data-cookie="false" data-cookie-id-table="false" data-show-export="false" data-click-to-select="false" data-toolbar="#toolbar">
                                        <thead>
                                            <?php
                                            $data = mysqli_query($conn, "SELECT * FROM `schedule` where  end_time <'$waktu_sekarang' and week='" . $_POST['weekly'] . "' ");
                                            $data_Schedule = mysqli_fetch_array($data);
                                            ?>
                                            <tr>
                                                <!-- <th data-field="state" data-checkbox="false"></th> -->
                                                <th data-field="id">ID</th>
                                                <th>Batch</th>
                                                <th>Messange</th>
                                                <th>Week</th>
                                                <th>Activity</th>
                                                <th>Date</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Presensi Time</th>
                                                <th>Time Out Presensi</th>
                                                <!-- <th data-field="action">Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            function activity($activity)
                                            {
                                                global $conn;
                                                $sqly = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM activity WHERE id_activity='$activity'"));
                                                return $sqly['items'];
                                            }
                                            function news($news)
                                            {
                                                global $conn;
                                                $sqly2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_daftar_berita WHERE id_berita='$news'"));
                                                return $sqly2['daftar_berita'];
                                            }
                                            function trainer($trainer)
                                            {
                                                global $conn;
                                                $sqly3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM trainer WHERE id_trainer='$trainer'"));
                                                return $sqly3['nama_trainer'];
                                            }
                                            $i = 1;
                                            foreach ($data as $row) :

                                            ?>

                                                <tr>

                                                    <td><?= $i; ?></td>
                                                    <td><?= $row['batch'];  ?></td>
                                                    <td>
                                                        <h6 class="font-weight-bold text-success font-italic"><?= $row['info'];  ?></h6>
                                                    </td>
                                                    <td><?= $row['week'];  ?></td>
                                                    <td><?= activity($row['id_activity']);  ?><br>
                                                        <h6 class="font-weight-bold text-primary font-italic"><?= news($row['id_berita']);  ?></h6>
                                                        <br>
                                                        <h6 class="font-weight-bold text-danger font-italic"><?= trainer($row['id_trainer']);  ?></h6>
                                                    </td>
                                                    <td><?= $row['date'];  ?></td>
                                                    <td><?= $row['start_time'];  ?></td>
                                                    <td><?= $row['end_time'];  ?></td>
                                                    <td><?= $row['presensi_time'];  ?></td>
                                                    <td><?= $row['timer'];  ?></td>
                                                    <!-- <td class="datatable-ct"><i class="fa fa-check"></i>
                                                    </td> -->



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