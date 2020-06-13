<body onload="window.print()">
  <div class="wrapper text-center">
    <h3>Laporan Obat dengan <?= $ket; ?></h3>
    <br />
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Kode</th>
          <th>Nama</th>
          <th>Stok</th>
          <th>Harga Beli</th>
          <th>Harga Jual</th>
          <th>Satuan</th>
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
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script>
    const wrapper = document.getElementById("wrapper");
  </script>
</body>