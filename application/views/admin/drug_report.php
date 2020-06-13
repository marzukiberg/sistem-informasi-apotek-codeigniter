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
          <h1>Laporan Data Obat</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">
              <?= $bc ?>
            </li>
          </ol>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tabel</h3>
      </div>
      <div class="card-body text-center">
        <h2 class="d-inline">Cetak Laporan data Obat </h2>
        <br />
        <br />
        <form action="<?= base_url('admin/printdrugs') ?>" method="get">
          <div id="alertdrugreport"></div>
          <div class="form-group text-center">
            <div class="input-group col-md-5 col-sm-12 d-inline-block">
              <select name="filter" id="drugfilter" class="form-control" required>
                <option value="">-- PILIH FILTER --</option>
                <option value="stok">Stok</option>
                <option value="satuan">Satuan</option>
                <option value="hargabeli">Harga Beli</option>
                <option value="hargajual">Harga Jual</option>
              </select>
              <div id="hiddenchoice"></div>
              <br />
              <button type="submit" class="btn btn-success" id="btnprint">Cetak</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- MODAL ALL DRUG -->
<div class="modal fade" id="modalprintall">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Cetak Data</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<table class="table table-bordered table-hover" id="drugreportall">
<thead>
<tr>
<th>No.</th>
<th>Kode</th>
<th>Nama</th>
<th>Stok</th>
<th>Harga Beli</th>
<th>Harga Jual</th>
<th>Satuan</th>
<th>Aksi</th>
</tr>
</thead>
</table>

</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
<button class="btn btn-success" id="cetakdrugunit">Cetak</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<!-- MODAL DRUG UNIT -->
<div class="modal fade" id="modalprint">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Cetak Data</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<table class="table table-bordered table-hover" id="drugreportunit">
<tbody>
<tr class="text-center">
<th colspan="4"><h4>Laporan Data Obat</h4><h5>Apotek Admin</h5></th>
</tr>
<tr>
<th>Kode Obat</th>
<td><span id="kodeobat"></span></span>
<th>Nama Obat</th>
<td><span id="namaobat"></span></td>
</tr>
<tr>
<th>Stok</th>
<td><span id="stokobat"></span></td>
<th>Harga Beli</th>
<td><span id="hargabeli"></span></td>
</tr>
<tr>
<th>Harga Jual</th>
<td><span id="hargajual"></span></td>
<th>Satuan</th>
<td><span id="satuan"></span></td>
</tr>
</tbody>
</table>

</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
<button class="btn btn-success" id="cetakdrugunit">Cetak</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>