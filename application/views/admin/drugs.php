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
          <h1>Data Obat</h1>
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
    <?= $this->session->flashdata("msg") ?>
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tabel</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#add-drug">Tambah</button>
            &nbsp;
          </div>
        </div>
        <br />
        <table class="table table-bordered table-hover table-responsive" id="table">
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
          <tbody>
            <?php
            $no = 1;
            foreach ($drugs as $d):
            ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $d->kode_obat; ?></td>
              <td><?= $d->dname; ?></td>
              <td><?= number_format($d->stock); ?></td>
              <td><?= 'Rp. '. number_format($d->purchase_price); ?></td>
              <td><?= 'Rp. '. number_format($d->selling_price); ?></td>
              <td><?= $d->uname; ?></td>
              <td>
                <a href="#" class="badge badge-primary" data-drug-id="<?= $d->did ?>" data-toggle="modal" data-target="#editdrug"><i class="fa fa-edit"></i></a>
                <a href="<?= base_url('admin/deletedrug/'. $d->did) ?>" class="badge badge-danger" id="deletedrug" onclick="return confirm('Hapus data ini?')"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <!--</div>-->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- modal add drug -->
<div class="modal fade" id="add-drug">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Obat</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/add_drug') ?>" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <label for="addkode_obat">Kode Obat</label>
            <?php
            $last_row = $this->db->order_by('id', "desc")
            ->limit(1)
            ->get('drugs')
            ->row();
            $arrstr = str_split($last_row->kode_obat);
            $last = number_format($arrstr[2]);
            $laststr = "OB".($last+1);
            ?>
            <input type="text" class="form-control" name="kode_obat" id="addkode_obat" value="<?= $laststr; ?>" placeholder="Kode obat... " required>
          </div>
          <div id="adddrugalert"></div>
          <div id="autofilldrug">
            <div class="form-group">
              <label for="addnama_obat">Nama Obat</label>
              <input type="text" class="form-control" name="nama_obat" id="addnama_obat" placeholder="Nama obat... " required>
            </div>
            <div class="form-group">
              <label for="addharga_beli">Harga Beli</label>
              <input type="number" class="form-control" name="harga_beli" id="addharga_beli" placeholder="Harga beli... " required>
            </div>
            <div class="form-group">
              <label for="addharga_jual">Harga Jual</label>
              <input type="number" class="form-control" name="harga_jual" id="addharga_jual" placeholder="Harga jual..." required>
            </div>
            <div class="form-group">
              <label for="addsatuan">Satuan</label>
              <select name="satuan" id="addsatuan" class="form-control" required>
                <option value="">-- SATUAN -- </option>
                <?php
                $satuan = $this->db->get("units")->result();
                foreach ($satuan as $s):
                ?>
                <option value="<?= $s->id ?>"><?= $s->name ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" id="btnadddrug" class="btn btn-primary">Tambah</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal edit drug -->
<div class="modal fade" id="editdrug">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title">
          <h5>Edit Data</h5>
        </div>
      </div>
      <form action="<?= base_url('admin/editdrug') ?>" method="POST">
        <div class="modal-body">
          <input type="hidden" name="id_obat" id="edtid_obat">
          <div class="form-group">
            <label for="edtkode_obat">Kode Obat</label>
            <input type="text" class="form-control" name="kode_obat" id="edtkode_obat" placeholder="Kode obat... " required readonly>
          </div>
          <div class="form-group">
            <label for="edtnama_obat">Nama Obat</label>
            <input type="text" class="form-control" name="nama_obat" id="edtnama_obat" placeholder="Nama obat... " required>
          </div>
          <div class="form-group">
            <label for="edtharga_beli">Harga Beli</label>
            <input type="number" class="form-control" name="harga_beli" id="edtharga_beli" placeholder="Harga beli... " required>
          </div>
          <div class="form-group">
            <label for="edtharga_jual">Harga Jual</label>
            <input type="number" class="form-control" name="harga_jual" id="edtharga_jual" placeholder="Harga jual..." required>
          </div>
          <div class="form-group">
            <label for="edtsatuan">Satuan</label>
            <select name="satuan" id="edtsatuan" class="form-control" required>
              <option value="">-- SATUAN -- </option>
              <?php
              $satuan = $this->db->get("units")->result();
              foreach ($satuan as $s):
              ?>
              <option value="<?= $s->id ?>"><?= $s->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Ubah</button>
        </div>
      </form>
    </div>
  </div>
</div>