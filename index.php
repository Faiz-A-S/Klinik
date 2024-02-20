<?php require_once('config.php'); ?>
<?php 
if(isset($_SESSION['msg_status'])){
   $msg_status = $_SESSION['msg_status'];
   unset($_SESSION['msg_status']);
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
   $data = '';
   foreach($_POST as $k => $v){
      if(!empty($data)) $data .= " , ";
      $data .= " `{$k}` = '{$v}' ";
   }
   $sql  = "INSERT INTO `messages` set {$data}";
   $save = $conn->query($sql);
   if($save){
      $msg_status = "success";
      foreach($_POST as $k => $v){
         unset($_POST[$k]);
      }
      $_SESSION['msg_status'] = $msg_status;
      header('location:'.$_SERVER['HTTP_REFERER']);
   }else{
      $msg_status = "failed";
      echo "<script>console.log('".$conn->error."')</script>";
      echo "<script>console.log('Query','".$sql."')</script>";
   }
}

?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
   <?php require_once('inc/header.php') ?>
   <style>
      #about h2 {
         color: #2b2b2b;
      }
      #nav .active {
         color: #e43d0b; /* Change the color to your desired active color */
      }
   </style>
   <body>

      <!-- Header ================================================== -->
	 <header id="home" style="background: #161415 url(<?php echo validate_image($_settings->info('banner')) ?>) no-repeat center;">

         <nav id="nav-wrap">

            <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
            <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

            <ul id="nav" class="nav">
               <li><a class="smoothscroll active" href="#home">Home</a></li>
               <li><a class="smoothscroll" href="#services">Layanan</a></li>
               <li><a class="smoothscroll" href="#schedule">Jadwal Dokter</a></li>
               <li><a class="smoothscroll" href="#contact_us">Hubungi Kami</a></li>
            </ul> <!-- end #nav -->
         </nav> <!-- end #nav-wrap -->

            <!-- JavaScript -->
         <script>
            document.addEventListener("DOMContentLoaded", function () {
            var navLinks = document.querySelectorAll('.smoothscroll');

            function setActiveLink(link) {
               navLinks.forEach(function (navLink) {
                     navLink.classList.remove('active');
               });
               link.classList.add('active');
            }

            navLinks.forEach(function (link) {
               link.addEventListener('click', function (event) {
                     event.preventDefault();
                     var targetId = this.getAttribute('href').substring(1);
                     document.getElementById(targetId).scrollIntoView({
                        behavior: 'smooth'
                     });
                     setActiveLink(this);
               });
            });

            window.addEventListener('scroll', function () {
               var scrollPosition = window.scrollY;
               navLinks.forEach(function (link) {
                     var targetId = link.getAttribute('href').substring(1);
                     var targetSection = document.getElementById(targetId);
                     if (
                        targetSection.offsetTop <= scrollPosition &&
                        targetSection.offsetTop + targetSection.offsetHeight > scrollPosition
                     ) {
                        setActiveLink(link);
                     }
               });
            });
         });
         </script>

         <?php 
         $u_qry = $conn->query("SELECT * FROM users where id = 1");
         foreach($u_qry->fetch_array() as $k => $v){
            if(!is_numeric($k)){
               $user[$k] = $v;
            }
         }
         $c_qry = $conn->query("SELECT * FROM contacts");
         while($row = $c_qry->fetch_assoc()){
            $contact[$row['meta_field']] = $row['meta_value'];
         }
         ?>

         <div class="row banner">
            <div class="banner-text">
               <h1 class="responsive-headline"><?php echo $_settings->info('name') ?></h1>
               <h3><?php echo ($_settings->info('welcome_message')) ?></h3>
               <hr />
            </div>
         </div>

         <!--<p class="scrolldown">
            <a class="smoothscroll" href="#about"><i class="icon-down-circle"></i></a>
         </p>--> 

      </header> <!-- Header End -->

      <!-- Services Section ================================================== -->
      <section id="services" style="padding-top:5rem; background: #eaeaea;">
      <div class="row">

         <div class="three columns">
            <!-- Isi dengan gambar background atau sesuai dengan kebutuhan -->
         </div>

         <div class="twelve columns main-col">

            <h2>Layanan</h2>
            <p>Daftar layanan yang disediakan oleh klinik:</p>
         <div class="gallery">
            <?php 
            $e_qry = $conn->query("SELECT * FROM services order by title desc");
            while($row = $e_qry->fetch_assoc()):
            ?>
         
            <div class="gallery-item">
                  <img src="<?php echo validate_image($row['file_path']) ?>" alt="Image 1">
                     <div class="gallery-item-text">
                        <div class="gallery-item-text-desc">
                        <h3><?php echo $row['title'] ?></h3>
                     </div>
                  </div>
            </div>
         
     <!-- item end -->
            <?php endwhile; ?>
         </div>
         </div> <!-- main-col end -->

      </div> <!-- End Services -->
      </section>
      <!-- End of Service Section ================================================== -->
      <!-- Schedule Section ================================================== -->
      <section id="schedule" style="padding-top:5rem; background: #eaeaea;">

         <div class="row">

            <div class="twelve columns collapsed">
               <!-- Isi dengan gambar background atau sesuai dengan kebutuhan -->
            </div>

            <div class="twelve columns main-col">

               <h2 style="margin-bottom:10px;">Jadwal Dokter</h2>

<!-- portfolio-wrapper -->
<div id="portfolio-wrapper" class="bgrid-quarters s-bgrid-thirds cf">
    <?php 
    $p_qry = $conn->query("SELECT * FROM doctors order by spesialis asc");
    $prevSpe = null;
    while($row = $p_qry->fetch_assoc()):
      if($row['spesialis'] != $prevSpe){
         echo '<h3 style="margin-bottom:10px; padding-top: 5px;">' . $row['spesialis'] . '</h3>';
      }
      $prevSpe = $row['spesialis'];
    ?>
<div class="portfolio-item">
        <div class="item-wrap">
            <h5 class="" style="color: black; text-align: left; padding-left: 20px; padding-top: 5px;"><?php echo $row['doctor_name'] ?></h5>
            <div class="doctor-info">
                <div class="doctor-pic">
                    <img alt="" src="<?php echo validate_image($row['file_path']) ?>">
                </div>
                <div class="schedule-table-container">
                    <div class="schedule-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Senin</th>
                                <th>Selasa</th>
                                <th>Rabu</th>
                                <th>Kamis</th>
                                <th>Jumat</th>
                                <th>Sabtu</th>
                                <!-- Add similar columns for other days -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $row['selasa'] ?></td>
                                <td><?php echo $row['rabu'] ?></td>
                                <td><?php echo $row['kamis'] ?></td>
                                <td><?php echo $row['jumat'] ?></td>
                                <td><?php echo $row['sabtu'] ?></td>
                                <!-- Add similar rows for other timeslots -->
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- item end -->
    <?php endwhile; ?>
</div>

            </div> <!-- portfolio-wrapper end -->

         </div> <!-- twelve columns end -->
   </section> 

      <!-- Contact Us Section ================================================== -->
      <section id="contact_us">
         <div class="d-flex">
            <div class="col-lg-12">
               <h2 class="text-center text-light">Hubungi Kami</h4>
               <center>
                  <!-- WhatsApp Chat Link -->
                <a href="https://wa.me/081278347843" target="_blank" class="btn btn-success btn-lg mb-3">Chat on WhatsApp</a>
                <div style="margin-bottom: 20px;"></div>
	       <div>
                  <h2 class="text-light">Contact Details</h2>
                  <p class="address">
                     <span><?php echo $contact['address'] ?></span><br>
                     <span><?php echo $contact['mobile'] ?></span><br>
                     <span><?php echo $contact['email'] ?></span>
                  </p>
               </div>
               </center>             
            </div>
         </div>
      </section>
   </body>
</html>
