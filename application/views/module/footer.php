<?= current_url() == base_url() || current_url() == base_url("auth")
? null :
'<footer class="main-footer">
<div class="float-right d-none d-sm-block">
<b>Version</b> 3.0.4
</div>
<strong>Copyright &copy; 2020 <a href="'.base_url('admin').'">Apotek Admin</a>.</strong>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>'
?>

<!-- jQuery -->
<script src="<?= base_url() ?>/assets/plugins/jquery/jquery-3.5.1.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/jquery-print/jQuery.print.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url('assets/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<!-- page script -->
<script>
  $(document).ready(() => {
    $("#table").DataTable();

    const origin = document.location.origin;
    const apotek_url = document.location.pathname.split('/')[1];
    const base_url = origin+"/"+apotek_url;

    // CUSTOM FUNCTION
    const allUrl = () => {
      if (document.location.href === base_url+'/admin/drugs' || document.location.href === base_url+'/admin/drugs#') {
        drugs();
      } else if (document.location.href === base_url+'/admin/purchases' || document.location.href === base_url+'/admin/purchases#') {
        purchaseDetail();
      } else if (document.location.href === base_url+'/admin/sales' || document.location.href === base_url+'/admin/sales#') {
        saleDetail();
      } else if (document.location.href === base_url+'/admin/units' || document.location.href === base_url+'/admin/units#') {
        editunit();
      } else if (document.location.href === base_url+'/admin/suppliers' || document.location.href === base_url+'/admin/suppliers#') {
        editsupplier();
      } else if (document.location.href === base_url+'/admin/drug_report' || document.location.href === base_url+'/admin/drug_report#') {
        drug_report();
      } else if (document.location.href === base_url+'/admin/purchase_report' || document.location.href === base_url+'/admin/purchase_report#') {
        purchase_report();
      }
    }
    const torupiah = (angka, prefix = "Rp. ") => {
      let number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        separator = sisa ? '.': '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1]: rupiah;
      return prefix == undefined ? rupiah: (rupiah ? 'Rp. ' + rupiah: '');
    }

    // DRUG
    const drugs = () => {
      const editdrug = () => {
        $("#editdrug").on('show.bs.modal', function(e) {
          const id = $(e.relatedTarget).data('drug-id');

          $.getJSON(base_url+"/ajax/editdrug/"+id, (res)=> {
            res.forEach(item=> {
              $("#edtid_obat").val(item.id);
              $("#edtkode_obat").val(item.kode_obat);
              $("#edtnama_obat").val(item.name);
              $("#edtharga_beli").val(item.purchase_price);
              $("#edtharga_jual").val(item.selling_price);
              $("#edtsatuan").val(item.id_unit);
              $("#edtstok").val(item.stock);
            })
          })
        })
      }

      const addkode_obat = $("#addkode_obat");
      addkode_obat.keyup(()=>autoFillModalAddDrug());
      $(".alert").fadeOut(4000);

      const autoFillModalAddDrug = () => {
        const kode_obat = addkode_obat.val();
        $.getJSON(base_url+"/ajax/adddrug/"+kode_obat, (res)=> {
          if (res.length === 0) {
            $("#autofilldrug").show();
            $("#adddrugalert").html("");
            $("#btnadddrug").removeAttr("disabled");
          } else {
            res.forEach(item=> {
              $("#autofilldrug").hide();
              $("#adddrugalert").html(`<div class="alert alert-danger">Obat sudah ada, tidak perlu ditambah, obat dengan kode ${item.kode_obat} sudah dimiliki oleh ${item.name}</div>`);
              $("#btnadddrug").attr("disabled", true)
            })
          }
        })
      }
    }

    // PURCHASES
    const purchaseDetail = () => {
      $("#purchasedetail").on("show.bs.modal",
        (e) => {
          const idp = $(e.relatedTarget).data("idp");

          $.ajax({
            url: base_url+"/ajax/purchasedetail",
            method: "get",
            data: {
              id: idp
            },
            success: (res) => {
              arrpurchases = JSON.parse(res)

              arrpurchases.forEach(item => {
                $("#invnum").text(item.invoice_num);
                $("#kode").text(item.kode_obat);
                $("#nama_obat").text(item.name);
                $("#qty").text(item.qty);
                $("#purchaseprice").text(torupiah(item.purchase_price));
                $("#sbqty").text(item.qty);
                $("#sbpp").text(item.purchase_price);
                $("#subtotal").text(torupiah(item.total));
              })
            },
            error: (err) => {
              alert("error mendapatkan data! ");
            }
          })
        })
    }

    // SALES
    const saleDetail = () => {
      $("#saledetail").on("show.bs.modal",
        (e) => {
          const ids = $(e.relatedTarget).data("ids");

          $.ajax({
            url: base_url+"/ajax/saledetail",
            method: "get",
            data: {
              id: ids
            },
            success: (res) => {
              arrsales = JSON.parse(res)
              arrsales.forEach((item, index) => {
                $("#slnota_num").text(item.nota_num);
                $("#kode").text(item.kode_obat);
                $("#nama_obat").text(item.name);
                $("#qty").text(item.qty);
                $("#selling_price").text(torupiah(item.selling_price));
                $("#sbqty").text(item.qty);
                $("#sbsp").text(item.selling_price);
                $("#subtotal").text(torupiah(item.total));
              })
            },
            error: (err) => {
              alert("error mendapatkan data!");
            }
          })
        })
    }

    // UNIT
    const editunit = () => {
      $("#editunit").on("show.bs.modal",
        (e) => {
          const idUnit = $(e.relatedTarget).data('id-unit');
          const unitName = $(e.relatedTarget).data('unit-name');

          $("#idunit").val(idUnit);
          $("#unitname").val(unitName);
        })
    }

    // SUPPLIER
    const editsupplier = () => {
      $("#editsupplier").on("show.bs.modal",
        (e) => {
          const idSupplier = $(e.relatedTarget).data('id-supplier');
          const supplierName = $(e.relatedTarget).data('name');
          const supplierPhone = $(e.relatedTarget).data('hp');
          const supplierAddress = $(e.relatedTarget).data('address');

          $("#id_supplier").val(idSupplier);
          $("#editsuppliername").val(supplierName);
          $("#editsupplierphone").val(supplierPhone);
          $("#editsupplieraddress").val(supplierAddress);
        })
    }

    // DRUG REPORT
    const drug_report = () => {
      $("#drugfilter").change(() => {
        const selected = $("#drugfilter option:selected").val();
        const hiddenchoice = $("#hiddenchoice");

        if (selected === 'stok' || selected === 'hargabeli' || selected === 'hargajual') {
          hiddenchoice.html(`
            <input type='number' name='mulaidari' id='mulaidari' class='form-control' placeholder='Mulai dari...' required />
            <input type='number' name='hingga' id='hingga' class='form-control' placeholder='Hingga...' required />
            `);
          $("#mulaidari").keyup(() => cekRange());
          $("#hingga").keyup(() => cekRange());

          const cekRange = () => {
            const mulaidari = parseInt($("#mulaidari").val());
            const hingga = parseInt($("#hingga").val());

            if (mulaidari >= hingga) {
              $('#alertdrugreport').html(`
                <div class='alert alert-danger'>Angka mulai tidak boleh lebih besar dari angka akhir</div>
                `);
              $("#btnprint").attr('disabled', true)
            } else if (mulaidari < hingga) {
              $("#alertdrugreport").html(``);
              $('#btnprint').removeAttr('disabled');
            }
          }
        } else if (selected === 'satuan') {
          hiddenchoice.html(
            $(`
              <select name='satuan' id='satuan' class='form-control' required>
              <option value=''>-- PILIH SATUAN --</option>
              ${
              $.ajax({
                url: base_url + "/ajax/getunit/",
                method: "get",
                success: (res) => {
                  const arr = JSON.parse(res)
                  arr.forEach(i => {
                    $("#satuan").append($(`<option value='${i.id}'>${i.name}</option>`));
                  })
                },
                error: (err) => {}
              })
              }
              </select>
              `)
          )
        } else {
          hiddenchoice.html(``)
        }
      })
    }


    // PURCHASE REPORT
    const purchase_report = () => {
      $("#pfilter").change(() => {
        const selected = $("#pfilter option:selected").val();
        const hiddenchoice = $("#hiddenchoice");

        alert(selected)
      })
    }

    // EKSEKUSI FUNGSI
    allUrl();
  })
</script>
</body>
</html>