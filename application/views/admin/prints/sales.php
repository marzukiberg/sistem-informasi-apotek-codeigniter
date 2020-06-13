<body onload="window.print()">
  <div class="wrapper text-center">
    <h3>Laporan Penjualan <?= $ket; ?></h3>
    <br />
    <table class="table table-bordered table-hover" id="table">
      <thead>
        <tr>
          <th>No.</th>
          <th>No. Nota</th>
          <th>Obat</th>
          <th>Tanggal</th>
          <th>Total</th>
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
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script>
    const wrapper = document.getElementById("wrapper");
  </script>
</body>