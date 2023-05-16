
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Form Layouts</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">Layouts</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Insertion contenu</h5>

              <!-- Floating Labels Form -->
              <form class="row g-3" method="post" action="<?php echo site_url("Back-Office/SController/form_trait");?>" enctype="multipart/form-data">
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" name="titre">
                    <label for="floatingName">Titre</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="file" class="form-control" id="floatingPassword" placeholder="image" name="image">
                    <label for="floatingPassword">Image</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" type="textarea" name="description" placeholder="Description" id="floatingTextarea" style="height: 100px;"></textarea>
                    <label for="floatingTextarea">Description</label>
                  </div>
                </div>

                <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success">
                            <center><?php echo $this->session->flashdata('success'); ?></center>
                        </div>
                    <?php } ?>

                <div class="text-center">
                  <input type="submit" class="btn btn-primary" value="Submit">
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>
          </div>

        </div>

        
        <div class="col-lg-6">
          
            <div class="card-body">
            <?php 
                          for ($i=0; $i < sizeof($datas); $i++) 
                          {   
                              echo '';
                              echo '<div class="card">';
                              echo '<center>';
                              echo '<div class="col-md-4">'; 
                              echo '<img src="'. site_url('assets/img/'.$datas[$i]['picture']).'" class="img-fluid rounded-start" alt="...">';
                              echo '</div>';
                              echo '<div class="col-md-8">';
                              echo '<div class="card-body">';
                              echo '<h5 class="card-title">'.$datas[$i]['titre'].'</h5>';
                              echo '<p class="card-text">'.$datas[$i]['description'].'</p>';
                              echo '<div>';
                              echo '<p><a href="' . site_url('Back-Office/SController/update?idcontent=' . $datas[$i]['idcontent']) . '" style="cursor:pointer">modifier</a> | <a href="' . site_url('Back-Office/SController/delete?idcontent=' . $datas[$i]['idcontent']) . '"  style="cursor:pointer">supprimer</a></p>';
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                              echo '</center>';
                              echo '</div>';
                              /*if ($this->session->flashdata('success2')) { 
                                echo '<div class="alert alert-success">';
                                echo '<center>'. echo $this->session->flashdata('success2').'</center>';
                                echo '</div>'};*/
                              echo '';
                          }
                      ?>
            
            </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  