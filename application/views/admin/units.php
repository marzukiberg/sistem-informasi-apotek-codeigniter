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
          <h1>Satuan</h1>
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
      <div class="card-body">
        <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#addunit">Tambah</button>
        <br />
        <?= $this->session->flashdata("msg"); ?>
        <br />
        <table class="table table-bordered table-hover table-responsive" id="table">
          <thead>
            <tr>
              <th>No.</th>
              <th>Nama</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($units as $u): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $u->name ?></a></td>
            <td><a href="#" class="badge badge-primary" data-toggle="modal" data-target="#editunit"
              data-id-unit="<?= $u->id ?>"
              data-unit-name="<?= $u->name ?>">Ubah</a>&nbsp;<a href="<?= base_url("admin/deleteunit/". $u->id) ?>" onclick="return confirm('Lanjutkan menghapus data?')" class="badge badge-danger">Hapus</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="addunit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url("admin/addunit") ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="addunitname">Nama</label>
            <input type="text" class="form-control" name="unitname" id="addunitname" placeholder="Masukkan nama... ">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" id="btneditunit" class="btn btn-primary">Tambah</button> 
        </div>
      </form>
    </div>
  </div>
</div>
<!-- modal edit unit -->
<div class="modal fade" id="editunit">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Edit</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<form action="<?= base_url('admin/editunit') ?>" method="POST">
<div class="modal-body">
<input type="hidden" name="id_unit" id="idunit">
<div class="form-group">
<label for="name">Nama</label>
<input type="text" class="form-control" name="unitname" id="unitname" placeholder="Masukkan nama satuan..">
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
<button type="submit" id="btneditunit" class="btn btn-primary">Ubah</button>
</div>
</form>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</div>