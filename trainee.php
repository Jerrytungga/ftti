<?php
include 'Admin/koneksi.php';
$AKT = $_GET['akt'];
error_reporting(E_ALL ^ E_NOTICE);
session_start();
if (!isset($_SESSION['id'])) {
  echo "<script type='text/javascript'>
  alert('Anda harus login terlebih dahulu!');
  window.location = 'login.php'
</script>";
} else {
  date_default_timezone_set('Asia/Jakarta');
  $hari_ini = date('Y-m-d');
  $hari_ini2 = date('F j, Y');
  $waktu_sekarang = date('H:i:s');
  $id = $_SESSION['id'];
  $get_data = mysqli_query($conn, "SELECT * FROM traines WHERE nip='$id'");
  $data = mysqli_fetch_array($get_data);
  $ambil = $data['nip'];
  $get_presensi = mysqli_query($conn, "SELECT * FROM presensi WHERE nip='$ambil' and presensi_date='$hari_ini'");
  $data_presensi = mysqli_fetch_array($get_presensi);
  $id_jadwal =  $data_presensi['schedule_id'];
  $ambil_jadwal = mysqli_query($conn, "SELECT * FROM schedule WHERE id='$id_jadwal'");
  $data__jadwal = mysqli_fetch_array($ambil_jadwal);
  $waktu_jadwal = $data__jadwal['start_time'];



  $Sqli_presensi = mysqli_query($conn, "SELECT * FROM presensi WHERE nip='$ambil' ");
  $array_presensi = mysqli_fetch_array($Sqli_presensi);
  $mark_V = $array_presensi['mark'] = 'V';
  $mark_O = $array_presensi['mark'] = 'O';
  $mark_X = $array_presensi['mark'] = 'X';
  $mark_I = $array_presensi['mark'] = 'I';
  $mark_S = $array_presensi['mark'] = 'S';
  $date = $array_presensi['presensi_date'];
  $batch = $array_presensi['batch'];

  $Sqli_cek_week = mysqli_query($conn, "SELECT MAX(week) as minggu FROM `presensi` WHERE nip='$ambil' ");
  $array_weekly = mysqli_fetch_array($Sqli_cek_week);
  $ambil_minggu = $array_weekly['minggu'];


  $tampil_mark_V = mysqli_query($conn, "SELECT *, COUNT(mark) as total FROM `presensi` WHERE week='$ambil_minggu'and nip='$ambil' and mark='$mark_V'");
  $arraytampil_mark_V = mysqli_fetch_array($tampil_mark_V);

  $tampil_mark_O = mysqli_query($conn, "SELECT *, COUNT(mark) as total FROM `presensi` WHERE week='$ambil_minggu'and nip='$ambil' and mark='$mark_O'");
  $arraytampil_mark_O = mysqli_fetch_array($tampil_mark_O);


  $tampil_mark_X = mysqli_query($conn, "SELECT *, COUNT(mark) as total FROM `presensi` WHERE week='$ambil_minggu'and nip='$ambil' and mark='$mark_X'");
  $arraytampil_mark_X = mysqli_fetch_array($tampil_mark_X);

  $tampil_mark_I = mysqli_query($conn, "SELECT *, COUNT(mark) as total FROM `presensi` WHERE week='$ambil_minggu'and nip='$ambil' and mark='$mark_I'");
  $arraytampil_mark_I = mysqli_fetch_array($tampil_mark_I);

  $tampil_mark_S = mysqli_query($conn, "SELECT *, COUNT(mark) as total FROM `presensi` WHERE week='$ambil_minggu'and nip='$ambil' and mark='$mark_S'");
  $arraytampil_mark_S = mysqli_fetch_array($tampil_mark_S);

  $points = $arraytampil_mark_V['total'] + $arraytampil_mark_O['total'] - $arraytampil_mark_X['total'] * 2 + $arraytampil_mark_I['total'] + $arraytampil_mark_S['total'];
}
function activity($activity)
{
  global $conn;
  $sqly = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM activity WHERE id_activity='$activity'"));
  return $sqly['items'];
}
?>
<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

  <title></title>
</head>

<body>
  <div class="card m-5">
    <h5 class="card-header bg-success text-light"><?= $data['name']; ?> - <?= $data['angkatan']; ?>
      <a href="presensi.php?akt=<?= $AKT ?>">Kembali</a>
    </h5>
    <div class="card-body">
      <h5 class="card-title">Presensi Hari ini</h5>
      <p class="card-text"><?= $hari_ini2 ?></p>
      <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
      <p></p>
      <div class="row">

        <div class="col">
          <!-- <img src="..." class="card-img-top" alt="..."> -->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Name Activity</th>
                <th scope="col">Time Presensi</th>
                <th scope="col">Start Time </th>
                <th scope="col">Status</th>

              </tr>
            </thead>
            <tbody>
              <?php $j = 1; ?>
              <?php foreach ($get_presensi  as $data_absent) :
              ?>
                <tr>
                  <th scope="row"><?= $j; ?></th>
                  <td><?= activity($data_absent['id_activity']) ?></td>
                  <td>Pukul <?= $data_absent['presensi_time'] ?></td>
                  <td>Pukul <?= $waktu_jadwal ?></td>
                  <td>
                    <center>
                      <?php
                      if ($data_absent['mark'] == 'V') { ?>
                        <span class="badge badge-pill badge-primary"><?= $data_absent['mark']; ?></span>
                      <?php  } else if ($data_absent['mark'] == 'O') { ?>
                        <span class="badge badge-pill badge-warning"><?= $data_absent['mark']; ?></span>
                      <?php   } else if ($data_absent['mark'] == 'X') { ?>
                        <span class="badge badge-pill badge-danger"><?= $data_absent['mark']; ?></span>
                      <?php  } else if ($data_absent['mark'] == 'I') { ?>
                        <span class="badge badge-pill badge-info"><?= $data_absent['mark']; ?></span>
                      <?php   }
                      ?>
                    </center>
                  </td>

                </tr>
                <?php $j++; ?>
              <?php endforeach;

              ?>
            </tbody>
            <tfoot>
              <tr>
                <th class=" bg-warning" colspan="5">Total Poin <br><?= $points ?></th>
              </tr>
            </tfoot>
          </table>
        </div>

        <div class="row">
          <div class="col">
            <div class="card bg-danger shadow mb-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-1 ">
                    <center>
                      <div class="text-m font-weight-bold text-light text-uppercase mb-1">
                        Total X</div>
                      <div class="h5 mb-0 font-weight-bold text-light">
                        <?= $arraytampil_mark_X['total'] * 2 ?></div>
                    </center>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-warning shadow mb-2 ">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-1 ">
                    <center>
                      <div class="text-m font-weight-bold text-light text-uppercase mb-1">
                        Total O</div>
                      <div class="h5 mb-0 font-weight-bold text-light">
                        <?= $arraytampil_mark_O['total'] ?></div>
                    </center>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-success shadow mb-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-1 ">
                    <center>
                      <div class="text-m font-weight-bold text-light text-uppercase mb-1">
                        Total I</div>
                      <div class="h5 mb-0 font-weight-bold text-light">
                        <?= $arraytampil_mark_I['total'] ?> </div>
                    </center>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-primary shadow mb-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-1 ">
                    <center>
                      <div class="text-m font-weight-bold text-light text-uppercase mb-1">
                        Total V</div>
                      <div class="h5 mb-0 font-weight-bold text-light">
                        <?= $arraytampil_mark_V['total'] ?>
                      </div>
                    </center>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card bg-danger shadow mb-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-1 ">
                    <center>
                      <div class="text-m font-weight-bold text-light text-uppercase mb-1">
                        Kidung</div>
                      <div class="h5 mb-0 font-weight-bold text-light">
                        <?php
                        $ambil_tabel_kidung  = mysqli_query($conn, "SELECT SUM(H) as total FROM `tb_kidung` WHERE nip='$ambil' AND week='$ambil_minggu'");
                        $data_kidung = mysqli_fetch_array($ambil_tabel_kidung);
                        ?>
                        <?= $data_kidung['total']; ?>
                      </div>
                    </center>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-warning shadow mb-2 ">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-1 ">
                    <center>
                      <div class="text-m font-weight-bold text-light text-uppercase mb-1">
                        DOA</div>
                      <div class="h5 mb-0 font-weight-bold text-light">
                        <?php
                        $ambil_tabel_doa  = mysqli_query($conn, "SELECT SUM(P) as total FROM `tb_doa` WHERE nip='$ambil' AND week='$ambil_minggu'");
                        $data_doa = mysqli_fetch_array($ambil_tabel_doa);
                        ?>
                        <?= $data_doa['total']; ?> </div>
                    </center>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-success shadow mb-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-1 ">
                    <center>
                      <div class="text-m font-weight-bold text-light text-uppercase mb-1">
                        Sharing</div>
                      <div class="h5 mb-0 font-weight-bold text-light">
                        <?php
                        $ambil_tabel_pameran  = mysqli_query($conn, "SELECT SUM(E) as total FROM `tb_pameran` WHERE nip='$ambil' AND week='$ambil_minggu'");
                        $data_pameran = mysqli_fetch_array($ambil_tabel_pameran);
                        ?>
                        <?= $data_pameran['total']; ?>
                      </div>
                    </center>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-primary shadow mb-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-1 ">
                    <center>
                      <div class="text-m font-weight-bold text-light text-uppercase mb-1">
                        TS</div>
                      <div class="h5 mb-0 font-weight-bold text-light">
                        <?php
                        $ambil_tabel_TS  = mysqli_query($conn, "SELECT SUM(TS) as total FROM `tb_ts` WHERE nip='$ambil' AND week='$ambil_minggu'");
                        $data_TS = mysqli_fetch_array($ambil_tabel_TS);
                        ?>
                        <?= $data_TS['total']; ?> </div>
                    </center>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>




      </div>
    </div>

  </div>




  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>


</body>

</html>