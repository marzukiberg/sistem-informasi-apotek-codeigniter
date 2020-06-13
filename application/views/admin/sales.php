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
          <h1>Penjualan</h1>
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
        <div>
          <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#addsale">Tambah Penjualan</button>
        </div>
        <br />
        <?= $this->session->flashdata("msg"); ?>
        <table class="table table-bordered table-hover table-responsive" id="table">
          <thead>
            <tr>
              <th>No.</th>
              <th>No. Nota</th>
              <th>Obat</th>
              <th>Tanggal</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($sales as $s):
            ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $s->nota_num; ?></td>
              <td><?= $s->dname; ?></td>
              <td><?php $newdate = date_create($s->date); echo date_format($newdate, "d M Y"); ?></td>
              <td><?= 'Rp. '. number_format($s->total); ?></td>
              <td>
                <a href="#" class="badge badge-success" data-toggle="modal" data-target="#saledetail" data-ids="<?= $s->ids ?>">Detail</a>
                <br />
                <a href="${base_url}/admin/deletesale/${item.ids}" class="badge badge-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL ADD SALE -->
<div class="modal fade" id="addsale">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Pembelian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/add_sale') ?>" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <label for="nota_num">Nomor Nota</label>
            <?php
            $last_row = $this->db->order_by('id', 'desc')
            ->limit(1)
            ->get('sales')
            ->row();
            ?>
            <input type="text" class="form-control" name="nota_num" id="nota_num" value="<?= $last_row === null? 1 : $last_row->nota_num + 1; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="id_obat">Obat</label>
            <select name="id_obat" id="id_obat" class="form-control" required>
              <option value="">-- OBAT --</option>
              <?php
              $obat = $this->db->get("drugs")->result();
              foreach ($obat as $o):
              ?>
              <option value="<?= $o->id ?>"> <?= $o->kode_obat . " - ". $o->name; ?>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="jumlah">Jumlah</label>
              <input type="number" name="jumlah" id="jumlah" placeholder="Jumlah penjualan... " class="form-control" required />
            </div>
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" name="tanggal" placeholder="Tanggal... " id="tanggal" class="form-control" required />
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Tambah</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!-- MODAL DETAIL -->
<div class="modal fade" id="saledetail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Penjualan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-hover table-responsive">
            <tbody>
              <tr>
                <th>No. Nota</th>
                <td><span id="slnota_num"></span></td>
                <th>Kode Obat</th>
                <td><span id="kode"></span></td>
              </tr>
              <tr>
                <th>Nama Obat</th>
                <td><span id="nama_obat"></span></td>
                <th>Jumlah</th>
                <td><span id="qty"></span></td>
              </tr>
              <tr>
                <th>Harga Jual</th>
                <td><span id="selling_price"></span></td>
                <th>Sub Total</th>
                <td><span id="sbqty"></span> &times; <span id="sbsp"></span> = <span id="subtotal"></span></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>