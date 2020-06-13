<body onload="window.print()">
  <div class="wrapper text-center">
    <h3>Laporan Pembelian <?= $ket; ?></h3>
    <br />
    <table class="table table-bordered table-hover" id="table">
      <thead>
        <tr>
          <th>No.</th>
          <th>Nomor Faktur</th>
          <th>Obat</th>
          <th>Supplier</th>
          <th>Tanggal</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        foreach ($purchases as $p):
        ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= $p->invoice_num; ?></td>
          <td><?= $p->dname; ?></td>
          <td><?= $p->sname; ?></td>
          <td><?php $newdate = date_create($p->date); echo date_format($newdate, "d M Y"); ?></td>
          <td><?= 'Rp. '. number_format($p->total); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script>
    const wrapper = document.getElementById("wrapper");
  </script>
</body>