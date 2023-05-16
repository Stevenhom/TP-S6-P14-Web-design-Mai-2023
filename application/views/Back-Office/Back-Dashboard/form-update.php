
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
              <?php  for ($i=0; $i < sizeof($datas); $i++) { ?>
              <!-- Floating Labels Form -->
              <form class="row g-3" method="post" action="<?php echo site_url('Back-Office/SController/form_trait_update?idcontent=' . $datas[$i]['idcontent']); ?>" style="cursor:pointer;" enctype="multipart/form-data">
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" name="titre" value="<?php echo $datas[$i]['titre'] ?>">
                    <label for="floatingName">Titre</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="file" class="form-control" id="floatingPassword"  name="image" value="<?php echo $datas[$i]['picture'] ?>">
                    <label for="floatingPassword">Image</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" type="textarea" name="description"  id="floatingTextarea" style="height: 100px;" value="<?php echo $datas[$i]['description'] ?>"></textarea>
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
              <?php } ?>    
            </div>
          </div>

        </div>

      </div>
    </section>

  </main><!-- End #main -->

  