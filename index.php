<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="icon" href="dk.png">
    <title>Dewan Pagination</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>
    <nav class="navbar bg-light">
      <a class="navbar-brand" href="index.php">
        Dewan Komputer
      </a>
    </nav>

    <div class="container">
      <h3 align="center" class="mt-3">Dewan Demo Pagination Dengan First dan Last</h3>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama mahasiswa</th>
              <th>Alamat</th>
              <th>Jenis Kelamin</th>
              <th>Jurusan</th>
              <th>Foto</th>
            </tr>  
          </thead>
          <tbody>
            <?php
              $page = (isset($_GET['page']))? $_GET['page'] : 1;
              $limit = 5; 
              $limit_start = ($page - 1) * $limit;
              $no = $limit_start + 1;

              $query = "SELECT * FROM tbl_mahasiswa ORDER BY nama_mahasiswa ASC LIMIT $limit_start, $limit";
              $dewan1 = $db1->prepare($query);
              $dewan1->execute();
              $res1 = $dewan1->get_result();
              while ($row = $res1->fetch_assoc()) {
            ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row["nama_mahasiswa"]; ?></td>
                <td><?php echo $row["alamat"]; ?></td>
                <td><?php echo $row["jenis_kelamin"]; ?></td>
                <td><?php echo $row["jurusan"]; ?></td>
                <td><img src='<?php echo $row["avatar"]; ?>' height="30px"></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <?php
          $query_jumlah = "SELECT count(*) AS jumlah FROM tbl_mahasiswa";
          $dewan1 = $db1->prepare($query_jumlah);
          $dewan1->execute();
          $res1 = $dewan1->get_result();
          $row = $res1->fetch_assoc();
          $total_records = $row['jumlah'];
        ?>
        <p>Total baris : <?php echo $total_records; ?></p>
        <nav class="mb-5">
          <ul class="pagination justify-content-end">
            <?php
              $jumlah_page = ceil($total_records / $limit);
              $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
              $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
              $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
              
              if($page == 1){
                echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
              } else {
                $link_prev = ($page > 1)? $page - 1 : 1;
                echo '<li class="page-item"><a class="page-link" href="?page=1">First</a></li>';
                echo '<li class="page-item"><a class="page-link" href="?page='.$link_prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
              }

              for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' active' : '';
                echo '<li class="page-item '.$link_active.'"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
              }

              if($page == $jumlah_page){
                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
              } else {
                $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                echo '<li class="page-item"><a class="page-link" href="?page='.$link_next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item"><a class="page-link" href="?page='.$jumlah_page.'">Last</a></li>';
              }
            ?>
          </ul>
        </nav>
      </div>
    </div>
 
    <div class="navbar bg-light fixed-bottom">
      <div>© <?php echo date('Y'); ?> Copyright:
          <a href="https://dewankomputer.com/"> Dewan Komputer</a>
      </div>
    </div>
  </body>
</html>

