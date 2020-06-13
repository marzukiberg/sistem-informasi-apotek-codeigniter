  <!-- Navbar -->
  <?php $this->load->view('module/navbar') ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php $this->load->view('module/sidebar') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Laporan Penjualan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">
                <?= $bc ?>
              </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Cetak Laporan data Penjualan</h3>
        </div>
        <div class="card-body">
          <br />
        <form action="<?= base_url('admin/printsale') ?>" method="get" target="_blank">
          <div id="alertdrugreport"></div>
          <div class="form-group text-center">
            <h4>Filter berdasarkan tanggal</h4>
            <div class="input-group col-md-5 col-sm-12 d-inline-block">
              <label for="tglmulai">Tanggal Mulai</label>
               <input type="date" name="tglmulai" class="form-control" >
               <br />
               <label for="tglhingga">Tanggal Hingga</label>
               <input type="date" name="tglhingga" class="form-control">
              <br />
              <button type="submit" class="btn btn-success" id="btnprint">Cetak</button>
            </div>
          </div>
        </form>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->