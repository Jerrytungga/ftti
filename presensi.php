<?php
include 'Admin/koneksi.php';
$AKT = $_GET['akt'];
if ($AKT == "") {
  header("location: index.php");
}
$page = $_SERVER['REQUEST_URI'];
$sec = "40";
session_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Asia/Jakarta');
$hari_ini = date('Y-m-d');
$waktu_sekarang = date('H:i:s');

if (isset($_POST['nip'])) {
  $nip = $_POST['nip'];
  $sql_traines = mysqli_query($conn, "SELECT angkatan, semester FROM `traines` WHERE nip='$nip'");
  $data_angkatan = mysqli_fetch_array($sql_traines);
  $angkatan = $data_angkatan['angkatan'];
  $smt2 = $data_angkatan['semester'];
}

$cek_angkatan_jadwal = mysqli_query($conn, "SELECT * FROM `schedule` where batch='$AKT' and  status='Aktif' and date='$hari_ini'  and   `presensi_time` < '$waktu_sekarang' and  `end_time` > '$waktu_sekarang'");
$cek_batch = mysqli_fetch_array($cek_angkatan_jadwal);
$cek_batch['batch'];

// set alarm
$alert_alarm = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `schedule` WHERE  batch='$AKT' and status='Aktif' and  `date`='$hari_ini' and `presensi_time`  < '$waktu_sekarang' and  `timer` > '$waktu_sekarang' "));
$alarm = $alert_alarm['nada_alarm'];
if ($alert_alarm['presensi_time'] < $waktu_sekarang && $alert_alarm['start_time'] > $waktu_sekarang) { ?>
  <audio src="music/<?= $alarm; ?>" autoplay="autoplay" hidden="hidden"></audio>
<?php }


$jadwal1 = mysqli_query($conn, "SELECT * FROM schedule WHERE batch='$AKT' and status='Aktif' and  date='$hari_ini' and end_time > '$waktu_sekarang'   ORDER BY start_time ASC");
$cek_presensi = mysqli_fetch_array($jadwal1);
$cek = mysqli_num_rows($jadwal1);

if ($cek_batch['batch'] == 'ALL') {
  $sqli_jadwal_All = mysqli_query($conn, "SELECT * FROM `schedule` where status='Aktif' and `batch`='" . $cek_batch['batch'] . "' and  date='$hari_ini'  and   `presensi_time` < '$waktu_sekarang' and  `end_time` > '$waktu_sekarang'");
  $array_jadwal_ALL = mysqli_fetch_array($sqli_jadwal_All);
  $id_ = $array_jadwal_ALL['id'];
  $week = $array_jadwal_ALL['week'];
  $batch = $array_jadwal_ALL['batch'];
  $id_kegiatan1 = $array_jadwal_ALL['id_activity'];
  $info = $array_jadwal_ALL['info'];
  $waktu = $array_jadwal_ALL['start_time'];
  $jam_akhir = $array_jadwal_ALL['end_time'];
  $waktuabsent = $array_jadwal_ALL['presensi_time'];
  $timer = $array_jadwal_ALL['timer'];
  if ($batch) {
    // memasukan data jadwal kegiatan berdasarkan data angkatan dan waktu dan hari
    if ($waktuabsent < $waktu_sekarang && $jam_akhir > $waktu_sekarang) {
      if ($waktuabsent < $waktu_sekarang && $waktu > $waktu_sekarang) {
        $hasil = 'V';
      } else if ($waktu < $waktu_sekarang && $timer > $waktu_sekarang) {
        $hasil = 'O';
      } else {
        $hasil = 'X';
      }
    }
    if (isset($_POST['nip'])) {
      $nip = htmlspecialchars($_POST['nip']);
      $sql_cekdata_nip = mysqli_num_rows(mysqli_query($conn, "SELECT nip, angkatan FROM `traines` WHERE nip='$nip' and angkatan='$angkatan'"));
      if ($sql_cekdata_nip > 0) {
        $max = mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(`id_presensi`) As id FROM `presensi` WHERE presensi_date=date(now()) AND schedule_id='$id_'"));
        $idbr = $max['id'] + 1;
        $inputpresensi =  mysqli_query($conn, "INSERT INTO `presensi`(`nip`, `batch`, `week`, `id_activity`, `presensi_time`, `mark`, `info_schedule`, `id_presensi`, `schedule_id`,`semester`) VALUES ('$nip','$batch','$week','$id_kegiatan1','$waktu_sekarang','$hasil','$info','$idbr','$id_','$smt2')");
        if ($inputpresensi) {
          echo notice(2);
        } else {
          $cekdata = $_SESSION['cek_data'] = '<p class="text-danger"><strong>Hanya bisa 1 kali Presensi!</strong></p>';
          echo notice(3);
        }
      } else {
        $Announcement = $_SESSION['Announcement'] = 'QR Not Registered!';
        echo notice(4);
      }
    }
  }

  if (isset($_POST['nip'])) {
    if ($cek == 0) {
      $Announcement = $_SESSION['Announcement'] = 'No Schedule';
      echo notice(4);
    } else if ($cek_presensi['presensi_time'] > $waktu_sekarang) {
      $Announcement = $_SESSION['Announcement'] = 'Belum Saatnya Untuk Presensi!';
      echo notice(4);
    }
  }
}





if ($angkatan == $cek_batch['batch']) {
  $angkatan_sama = mysqli_query($conn, "SELECT * FROM `schedule` where status='Aktif' and batch='$AKT' and date='$hari_ini'  and   `presensi_time` < '$waktu_sekarang' and  `end_time` > '$waktu_sekarang'");
  $jadwal_angkatan_sama = mysqli_fetch_array($angkatan_sama);
  $id_1 = $jadwal_angkatan_sama['id'];
  $week1 = $jadwal_angkatan_sama['week'];
  $batch1 = $jadwal_angkatan_sama['batch'];
  $id_kegiatan2 = $jadwal_angkatan_sama['id_activity'];
  $info1 = $jadwal_angkatan_sama['info'];
  $waktu1 = $jadwal_angkatan_sama['start_time'];
  $jam_akhir1 = $jadwal_angkatan_sama['end_time'];
  $waktuabsent1 = $jadwal_angkatan_sama['presensi_time'];
  $timer1 = $jadwal_angkatan_sama['timer'];

  if ($angkatan == $cek_batch['batch']) {
    // memasukan data jadwal kegiatan berdasarkan data angkatan dan waktu dan hari
    if ($waktuabsent1 < $waktu_sekarang && $jam_akhir1 > $waktu_sekarang) {
      if ($waktuabsent1 < $waktu_sekarang && $timer1 > $waktu_sekarang) {
        $hasil1 = 'V';
      } else
      if ($waktu1 < $waktu_sekarang && $timer1 > $waktu_sekarang) {
        $hasil1 = 'O';
      } else {
        $hasil1 = 'X';
      }
    }
    if (isset($_POST['nip'])) {
      $nip = htmlspecialchars($_POST['nip']);
      $sql_cekdata_nip2 = mysqli_num_rows(mysqli_query($conn, "SELECT nip, angkatan FROM `traines` WHERE nip='$nip' and angkatan='" . $cek_batch['batch'] . "'"));
      if ($sql_cekdata_nip2 > 0) {
        $max = mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(`id_presensi`) As id FROM `presensi` WHERE presensi_date=date(now()) AND schedule_id='$id_kegiatan2'"));
        $idbr2 = $max['id'] + 1;
        $inputpresensi1 =  mysqli_query($conn, "INSERT INTO `presensi`(`nip`, `batch`, `week`, `id_activity`, `presensi_time`, `mark`, `info_schedule`, `id_presensi`, `schedule_id`,`semester`) VALUES ('$nip','$batch1','$week1','$id_kegiatan2','$waktu_sekarang','$hasil1','$info1','$idbr2','$id_1','$smt2')");
        if ($inputpresensi1) {
          echo notice(2);
        } else {
          echo notice(4);
        }
      }
    }
  }
  if (isset($_POST['nip'])) {
    if ($sql_cekdata_nip2 == 0) {
      $Announcement = $_SESSION['Announcement'] = 'Not Your Schedule';
      echo notice(4);
    }
  }
  if (isset($_POST['nip'])) {
    if ($cek == 0) {
      $Announcement = $_SESSION['Announcement'] = 'No Schedule';
      echo notice(4);
    } else if ($cek_presensi['presensi_time'] > $waktu_sekarang) {
      $Announcement = $_SESSION['Announcement'] = 'Belum Saatnya Untuk Presensi!';
      echo notice(4);
    }
  }
}





$presensi = mysqli_query($conn, "SELECT * FROM `presensi` where batch='$AKT' ");
$list = mysqli_fetch_array($presensi);

$jadwal = mysqli_query($conn, "SELECT * FROM schedule where batch='$AKT' and status='Aktif' and   date='$hari_ini' and end_time > '$waktu_sekarang'   ORDER BY start_time ASC");
$list = mysqli_fetch_array($jadwal);
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.15.2/dist/sweetalert2.all.min.js"></script>

  <title>Pure Experience</title>
  <link rel="icon" type="image/x-icon" href="img/logo.png">
  <style>
    canvas {
      height: 250px;
      width: 100%;
      border-radius: 10px;
      margin-right: 10px;
    }

    .formscaner {
      height: 450px;
    }

    body {
      height: 100%;
      width: 100%;
      background-color: #F9F9F9;

    }

    @media screen and (max-width: 575px) {
      canvas {
        height: 100px;
        width: 50px;
        border-radius: 10px;

      }
    }
  </style>

</head>

<body>
  <!-- <nav class="navbar  navbar-light shadow" style="background-color: #e3f2fd;">
    <a class="navbar-brand text-success font-italic  font-weight-bold">Pure Experience</a>
    <a href="login.php" class="btn btn-success text-light font-italic  font-weight-bold my-2 my-sm-0" type="submit">Login</a>
  </nav> -->

  <!-- navbar -->
  <nav class="navbar navbar-light fixed-bottom" style="background-color: #28A745; ">

    <a href="index.php" class="navbar-brand text-light font-italic  font-weight-bold">Pure Experience <small><sup>V1.0</sup></small></a>

    <?php
    $ambil_minggu = mysqli_query($conn, "SELECT MAX(week) as total FROM `presensi` ");
    $max_minggu = mysqli_fetch_array($ambil_minggu);
    $R = $max_minggu['total'];

    ?>

    <a href="invloment.php?akt=<?= $AKT ?>&week=<?= $R ?>&inv=p"><button type="button" class="btn btn-warning">Prayer</button></a>
    <a href="invloment.php?akt=<?= $AKT ?>&week=<?= $R ?>&inv=h"><button type="button" class="btn btn-warning">Hymns</button></a>
    <a href="invloment.php?akt=<?= $AKT ?>&week=<?= $R ?>&inv=e"><button type="button" class="btn btn-warning">Exhibition</button></a>
    <a href="invloment.php?akt=<?= $AKT ?>&week=<?= $R ?>&inv=ts"><button type="button" class="btn btn-warning">Tutur Sabda</button></a>

    <!--
    <a href="./login1.php?akt=<?= $AKT ?>" class="btn text-light my-2 my-sm-0">
      <svg xmlns="http://www.w3.org/2000/svg" width="35" height="30" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
      </svg>
    </a> -->


  </nav>

  <!-- <div class="card shadow m-3">
    <div class="card-header  bg-success text-light">
      <h3>
        <center>
          <?php
          echo date('d F Y');
          ?>
        </center>
      </h3>
    </div>
    <div class="card-body">
      <h1 style=" text-align:center; font-size: 50pt; font-family: arial;" id="jam"></h1>
    </div>
  </div> -->

  <div class="container-fluid m-md-5 m-2 ">
    <div class="form-row mx-auto">
      <div class="card formscaner shadow mr-3 p-3 mt-2 col-md-3">
        <div class="card-header text-light bg-success">
          <center>
            <h4>
              <meta http-equiv="refresh" content="<?= $sec ?>;URL='<?= $page ?>'">
              Scan Qr Code
            </h4>
          </center>
        </div>
        <div class="card-body">
          <br>
          <center>
            <canvas></canvas>
            <br>
            <br>
            <!-- <p>Silahkan Pilih Sumber kamera</p>
            <select></select> -->
          </center>
        </div>
      </div>
      <!-- <audio src="music/BellStasiun.mp3" autoplay="autoplay" hidden="hidden"></audio> -->

      <!-- script tampilan absensi -->
      <div class="card shadow formdailypresence mr-3 p-3  mt-2 col-md-5">
        <div class="card-header text-light bg-success">
          <center>
            <h4>
              Attendance Result
            </h4>
          </center>
        </div>
        <div class="card-body">
          <table>
            <tr>
              <th width="150">&nbsp;&nbsp;&nbsp;&nbsp;No</th>
              <th width="220">Name</th>
              <th width="120"><span class="badge badge-pill badge-success">V</span></th>
              <th width="110"><span class="badge badge-pill badge-warning">O</span></th>
              <th width="110"><span class="badge badge-pill badge-danger">X</span></th>
              <!-- <th width="100"><span class="badge badge-pill badge-primary">I</span></th>
              <th width="100"><span class="badge badge-pill badge-dark">S</span></th> -->
              <!-- <th width="100">Poin</th> -->
            </tr>
          </table>

          <div class="modal-body " style="height: 300px;overflow: scroll;">
            <table class=" table table-striped">
              <tbody>
                <?php $j = 1; ?>
                <?php
                function name($nama_)
                {
                  global $conn;
                  $sqly = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM traines WHERE nip='$nama_'"));
                  return $sqly['name'];
                }
                $tampilan_presensi = mysqli_query($conn, "SELECT * FROM presensi where batch='$AKT' and presensi_date='$hari_ini' group by nip order by presensi_time DESC");
                while ($array_presensi = mysqli_fetch_array($tampilan_presensi)) {
                  $nip = $array_presensi['nip'];
                  $mark_V = $array_presensi['mark'] = 'V';
                  $mark_O = $array_presensi['mark'] = 'O';
                  $mark_X = $array_presensi['mark'] = 'X';

                  $tampil_mark_V = mysqli_query($conn, "SELECT nip, count(mark) as total FROM presensi where nip='$nip' and mark='$mark_V' AND presensi_date='$hari_ini' ");
                  $arraytampil_mark_V = mysqli_fetch_array($tampil_mark_V);

                  $tampil_mark_O = mysqli_query($conn, "SELECT nip, count(mark) as total FROM presensi where nip='$nip' and mark='$mark_O'AND presensi_date='$hari_ini' ");
                  $arraytampil_mark_O = mysqli_fetch_array($tampil_mark_O);

                  $tampil_mark_X = mysqli_query($conn, "SELECT nip, count(mark) as total FROM presensi where nip='$nip' and mark='$mark_X' AND presensi_date='$hari_ini'");
                  $arraytampil_mark_X = mysqli_fetch_array($tampil_mark_X);


                  $tampil3 = mysqli_query($conn, "SELECT * FROM presensi where batch='$AKT' and nip='$nip' group by nip ");
                  $arraytampil3 = mysqli_fetch_array($tampil3); ?>

                  <?php foreach ($tampil3  as $data) :
                  ?>
                    <tr>
                      <th width="200"><?= $j; ?></th>
                      <td width="350"><?= name($data["nip"]); ?></td>
                      <td width="165"><span class="badge badge-pill badge-success"><?= $arraytampil_mark_V['total']; ?></span></td>
                      <td width="140"><span class="badge badge-pill badge-warning"><?= $arraytampil_mark_O['total'] * -1; ?></span></td>
                      <td width="70"><span class="badge badge-pill badge-danger"><?= $arraytampil_mark_X['total'] * -2; ?></span></td>
                      <!-- <td></td> -->
                      <?php $j++; ?>
                  <?php endforeach;
                }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- akhir script tampilan absent -->








      <!-- tabel schedule -->
      <div class="card today shadow mr-3 p-3 mt-2 col-md-3">
        <table class="table bg-success text-light">

          <tr>
            <th width="170">&nbsp;&nbsp;No</th>
            <th width="290">Schedule Today</th>
            <th width="120">Start Time</th>
          </tr>

        </table>
        <div class="card-body" style="height: 300px;overflow: scroll;">
          <table class="table table-striped">
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
              ?>
              <?php $i = 1; ?>
              <?php foreach ($jadwal as $row) :
              ?>
                <tr>
                  <th scope="row"><?= $i; ?></th>
                  <!-- menampilkan pesan jika pesan dijadwal ada -->
                  <td><?= activity($row['id_activity']);  ?><br>
                    <h7 class="font-weight-bold text-primary font-italic"><?= news($row['id_berita']);  ?></h7>
                    <br>
                    <h7 class="font-weight-bold text-danger font-italic"><?= trainer($row['id_trainer']);  ?></h7>
                    <?php
                    if ($row["info"] != NULL) { ?>
                      <br>
                      <div class="alert alert-success mt-2" role="alert">
                        <h6 class="alert-heading">Message!</h6>
                        <p><?= $row["info"]; ?></p>
                      </div>
                    <?php    }
                    ?>
                  </td>
                  <td><?= $row['start_time'];  ?></td>
                </tr>
                <?php $i++; ?>
              <?php endforeach;
              ?>
            </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>




  <!-- Custom scripts for all pages-->
  <script type="text/javascript" src="scanner/js/jquery.js"></script>
  <script type="text/javascript" src="scanner/js/qrcodelib.js"></script>
  <script type="text/javascript" src="scanner/js/webcodecamjquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
  <script type="text/javascript">
    var arg = {
      resultFunction: function(result) {

        var redirect = '';
        $.redirectPost(redirect, {
          nip: result.code
        });
      }
    };

    var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
    decoder.buildSelectMenu("selet");
    decoder.play();
    // $('selct').on('change', function() {
    //   decoder.stop().play();
    // });

    $.extend({
      redirectPost: function(location, args) {
        var form = '';
        $.each(args, function(key, value) {
          form += '<input type="hidden" name="' + key + '" value="' + value + '">';
        });
        $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body').submit();
      }
    });
  </script>


  <script type="text/javascript">
    window.onload = function() {
      jam();
    }

    function jam() {
      var e = document.getElementById('jam'),
        d = new Date(),
        h, m, s;
      h = d.getHours();
      m = set(d.getMinutes());
      s = set(d.getSeconds());

      e.innerHTML = h + ':' + m + ':' + s;

      setTimeout('jam()', 1000);
    }

    function set(e) {
      e = e < 10 ? '0' + e : e;
      return e;
    }
  </script>
  <?php
  include 'alert.php';
  ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.15.2/dist/sweetalert2.all.min.js"></script>

</body>

</html>
<?php
function notice($type)
{
  if ($type == 2) {
    return "<audio autoplay><source src='" . 'music/beep.mp3' . "'></audio><br><audio autoplay><source src='" . 'music/voice.mp3' . "'></audio>";
  } elseif ($type == 1) {
    return "<audio autoplay><source src='" . 'music/success.wav' . "'></audio>";
  } elseif ($type == 3) {
    return "<audio autoplay><source src='" . 'music/beep.mp3' . "'></audio>";
  } elseif ($type == 4) {
    return "<audio autoplay><source src='" . 'music/Akses_ditolak.mp3' . "'></audio>";
  }
}
?>