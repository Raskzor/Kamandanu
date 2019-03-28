<?php

  include 'koneksi.php';

  $salt = "Kamandanu123456789"; // Memperpanjang password

  $idpostingan = $_GET["id"];

  checkdataGET($idpostingan);

  $encRID = makeID($idpostingan, $salt);
  //print $encRID;
  // Ketika diambil id 1 , disimpan kedalam id postingan
  // Proses selanjutnya panggil bedasarkan query nya. 

  $sql = "SELECT * FROM postingan_adv WHERE encID = '$encRID'";

  if(!$result = mysqli_query($con, $sql)) // if ('dalam kurung selalu true, jika ada ! itu false')
  {
      die('Error: '.mysqli_error($con)); // check ada tidaknya id di tabel postingan 
  }else
  {
      $num_row  = mysqli_num_rows($result);

      if ($num_row > 0)
      {


        $row = mysqli_fetch_assoc($result);

        $date    = $row["date"]; // nama index kolom pada database
        $judul    = $row["judul"];
        $content = $row["content"];
        $author  = $row["penulis"];
      }else
      {
        $date    = "00-00-0000";
        $judul    = "Berita tidak ditemukan";
        $content = "Lagi galau sampe lupa nyari berita kemana ?";
        $author  = "Raskzor";
      }
  }


  function checkdataGET($string)
  {
    if(preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $string)) // Inputan di parameter get 
    {                 // regular expretion regex
        include "./log/attackerTracker.php"; // pemanggilan file log
        //print "ngga aman";
    }else
    {
      //print "aman";
    }
  }
// Ketika user melakukan incude
  
// Memanggil library SHA-256 pada PHP
  
  function makeID($id, $salt)    
  {
      return  hash('sha256', $id.$salt);
  }




?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./files/favicon.ico">

    <title>Halaman Berita</title>

    <!-- Bootstrap core CSS -->
    <link href="./files/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./files/starter-template.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">BeritaKampus</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


    </nav>

    <main role="main" class="container">

      <div class="starter-template">
        <h1><?php echo $judul; ?></h1>
        <p class="lead"><?php echo $content; ?>
          
          <br><br> <small><b>Author by <?php echo $author; ?></b></small>
        </p>
      </div>

    </main><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="./files/popper.min.js"></script>
    <script src="./files/bootstrap.min.js"></script>
  </body>
</html>
