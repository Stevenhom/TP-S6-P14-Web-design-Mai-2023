
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo site_url('Front-Office/SController/home');?>">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row align-items-top">
        <center>
        <div class="col-lg-6">

            <!-- Card with an image on left -->
            
              
                
                  
                    <?php 
                          for ($i=0; $i < sizeof($datas); $i++) 
                          {   
                              echo '<div class="card mb-3">';
                              echo '<div class="row g-0">';
                              echo '<center>';
                              echo '<div class="col-md-4">'; 
                              echo '<img src="'. site_url('assets/img/'.$datas[$i]['picture']).'" class="img-fluid rounded-start custom-image-size" alt="...">';
                              echo '</div>';
                              echo '<div class="col-md-8">';
                              echo '<div class="card-body">';
                              echo '<h5 class="card-title">'.$datas[$i]['titre'].'</h5>';
                              echo '<class="card-text">'.$datas[$i]['description'].'</p>';
                              echo '</div>';
                              echo '</div>';
                              echo '</center>';
                              echo '</div>';
                              echo '</div>';
                          }
                      ?>
                    
                    <!--<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>-->
                  
                
              
            <!-- End Card with an image on left -->

          </div>

        </div>
                        </center>
    </section>

  </main><!-- End #main -->

  