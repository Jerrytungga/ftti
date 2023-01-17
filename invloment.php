<?php
include 'Admin/koneksi.php';
$AKT = $_GET['akt'];
$wk = $_GET['week'];
$inv = $_GET['inv'];
error_reporting(E_ALL ^ E_NOTICE);
session_start();


if (isset($_POST['nip'])) {
  if ($inv == 'p') {
    $nip = htmlspecialchars($_POST['nip']);
    $inv = '1';
    $sql = "INSERT INTO `tb_doa`(`nip`, `batch`, `week`, `P`) VALUES ('$nip','$AKT','$wk','$inv')";
    $result = mysqli_query($conn, $sql);
  } else if ($inv == 'h') {
    $nip = htmlspecialchars($_POST['nip']);
    $inv = '1';
    $sql = "INSERT INTO `tb_kidung`(`nip`, `btach`, `week`, `H`) VALUES ('$nip','$AKT','$wk','$inv')";
    $result = mysqli_query($conn, $sql);
  } else if ($inv == 'e') {
    $nip = htmlspecialchars($_POST['nip']);
    $inv = '1';
    $sql = "INSERT INTO `tb_pameran`(`nip`, `batch`, `week`, `E`) VALUES ('$nip','$AKT','$wk','$inv')";
    $result = mysqli_query($conn, $sql);
  } else if ($inv == 'ts') {
    $nip = htmlspecialchars($_POST['nip']);
    $inv = '1';
    $sql = "INSERT INTO `tb_ts`(`nip`, `batch`, `week`, `TS`) VALUES ('$nip','$AKT','$wk','$inv')";
    $result = mysqli_query($conn, $sql);
  }


  header("Location: presensi.php?akt=$AKT");
}



?>
<!doctype html>
<html lang="en">
<?php
include 'Admin/head.php';
?>

<body style="background-color: #e3f2fd;">
  <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
  <div class="error-pagewrap">
    <div class="error-page-int">
      <div class="text-center m-b-md custom-login">
        <h3 style="color: #28A745;">PLEASE SCAN QR</h3>
        <h3>involvement</h3>
      </div>
      <div class=" content-error">
        <div class="hpanel">
          <div class="panel-body">
            <br>
            <center>
              <canvas class="btn-login"></canvas>
              <br>
              <br>
              <!-- <p>Silahkan Pilih Sumber kamera</p>
            <select></select> -->
            </center>
          </div>
        </div>
      </div>
      <div class="text-center login-footer">
        <p>PRESENSI QR CODE FTTI SURABAYA</a></p>
        <a href="presensi.php?akt=<?= $AKT ?>" style="color: #28A745;">Back</a>
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
  <!-- tab JS
		============================================ -->
  <script src="js/tab.js"></script>
  <!-- icheck JS
		============================================ -->
  <script src="js/icheck/icheck.min.js"></script>
  <script src="js/icheck/icheck-active.js"></script>
  <!-- plugins JS
		============================================ -->
  <script src="js/plugins.js"></script>
  <!-- main JS
		============================================ -->
  <script src="js/main.js"></script>
  <script type="text/javascript" src="scanner/js/jquery.js"></script>
  <script type="text/javascript" src="scanner/js/qrcodelib.js"></script>
  <script type="text/javascript" src="scanner/js/webcodecamjquery.js"></script>

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
    decoder.buildSelectMenu("select");
    decoder.play();
    $('select').on('change', function() {
      decoder.stop().play();
    });

    $.extend({
      redirectPost: function(location, args) {
        var form = '';
        $.each(args, function(key, value) {
          form += '<input type="text" name="' + key + '" value="' + value + '">';
        });
        $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body').submit();
      }
    });
  </script>



</body>

</html>

<?php
function notice($type)
{
  if ($type == 1) {
    return "<audio autoplay><source src='" . 'music/beep.mp3' . "'></audio>";
  }
}

?>