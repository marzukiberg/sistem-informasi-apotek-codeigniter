<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->model('apotek_models');
    $this->clear_cache();
    $this->cek_login();
  }

  // Custom Function
  function cek_login() {
    if ($this->session->login === null) {
      redirect("auth");
    }
  }
  function clear_cache() {
    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    $this->output->set_header("Pragma: no-cache");
  }

  public function index() {
    $data['title'] = 'Admin | Dashboard';
    $data['bc'] = 'Dashboard';
    $this->load->view('module/header', $data);
    $this->load->view('admin/dashboard', $data);
    $this->load->view('module/footer');
  }

  // READ DATA
  public function drugs() {
    $data['title'] = 'Admin | Obat';
    $data['drugs'] = $this->apotek_models->get_data_query('select drugs.*, drugs.name as dname, drugs.id as did, units.name as uname, units.id as uid, units.* from drugs inner join units on drugs.id_unit = units.id')->result();
    $data['bc'] = 'Data Master / Obat';
    $this->load->view('module/header', $data);
    $this->load->view('admin/drugs', $data);
    $this->load->view('module/footer');
  }

  public function purchases() {
    $data['title'] = 'Admin | Pembelian';
    $data['purchases'] = $this->apotek_models->get_data_query('select purchase.*, purchase.id as idp, drugs.name as dname, suppliers.name as sname from purchase, drugs, suppliers where purchase. id_supplier = suppliers.id and purchase.id_drug = drugs.id')->result();
    $data['bc'] = 'Data Master / Pembelian';
    $this->load->view('module/header', $data);
    $this->load->view('admin/purchases', $data);
    $this->load->view('module/footer');
  }

  public function sales() {
    $data['title'] = 'Admin | Penjualan';
    $data['bc'] = 'Data Master / Penjualan';
    $data['sales'] = $this->db->query("select sales.*, sales.id as ids, drugs.name as dname from sales inner join drugs on sales.id_drug = drugs.id")->result();

    $this->load->view('module/header', $data);
    $this->load->view('admin/sales', $data);
    $this->load->view('module/footer');
  }

  public function units() {
    $data['title'] = 'Admin | Satuan';
    $data['bc'] = 'Data Ekstra / Satuan';
    $data['units'] = $this->apotek_models->get_data('units');
    $this->load->view('module/header', $data);
    $this->load->view('admin/units', $data);
    $this->load->view('module/footer');
  }

  public function suppliers() {
    $data['title'] = 'Admin | Pemasok';
    $data['bc'] = 'Data Ekstra / Pemasok';
    $data['suppliers'] = $this->apotek_models->get_data('suppliers');
    $this->load->view('module/header', $data);
    $this->load->view('admin/suppliers', $data);
    $this->load->view('module/footer');
  }

  public function drug_report() {
    $data['title'] = 'Admin | Laporan Obat';
    $data['bc'] = 'Laporan / Obat';
    $data['obat'] = $this->apotek_models->get_data_query('select drugs.*, units.name as unit_name from drugs, units where drugs.id_unit = units.id')->result();
    $this->load->view('module/header', $data);
    $this->load->view('admin/drug_report', $data);
    $this->load->view('module/footer');
  }

  public function purchase_report() {
    $data['title'] = 'Admin | Laporan Pembelian';
    $data['bc'] = 'Laporan / Pembelian';
    $this->load->view('module/header', $data);
    $this->load->view('admin/purchase_report', $data);
    $this->load->view('module/footer');
  }

  public function sale_report() {
    $data['title'] = 'Admin | Laporan Penjualan';
    $data['bc'] = 'Laporan / Penjualan';
    $data['sales'] = $this->apotek_models->get_data_query('select sales_detail.*, drugs.name as drug_name from sales_detail, drugs where sales_detail.id_drug = drugs.id')->result();
    $this->load->view('module/header', $data);
    $this->load->view('admin/sale_report', $data);
    $this->load->view('module/footer');
  }


  // ADD DATA
  public function add_drug() {
    $kode_obat = $this->input->post("kode_obat");
    $nama_obat = $this->input->post("nama_obat");
    $id_unit = $this->input->post("satuan");
    $harga_beli = $this->input->post("harga_beli");
    $harga_jual = $this->input->post("harga_jual");
    $satuan = $this->input->post("satuan");

    $arr = [
      "id" => null,
      "kode_obat" => $kode_obat,
      "name" => $nama_obat,
      "id_unit" => $id_unit,
      "stock" => 0,
      "purchase_price" => $harga_beli,
      "selling_price" => $harga_jual
    ];

    $this->db->insert("drugs", $arr);
    $this->session->set_flashdata("msg", "<div class='alert alert-success'>Obat baru dengan nama ". $nama_obat. " dan kode ". $kode_obat. " ditambahkan</div>");
    redirect("admin/drugs");
  }
  public function add_purchase() {
    $invoice_num = $this->input->post("invoice_num");
    $id_obat = $this->input->post("id_obat");
    $jumlah = $this->input->post("jumlah");
    $tanggal = $this->input->post("tanggal");
    $supplier = $this->input->post("supplier");

    $obat = $this->db->get_where("drugs", ["id" => $id_obat])->row_array();
    $purchase_price = $obat["purchase_price"];
    $total = ($purchase_price * $jumlah);

    $query = $this->db->insert("purchase", [
      "id" => null,
      "invoice_num" => $invoice_num,
      "id_drug" => $id_obat,
      "id_supplier" => $supplier,
      "date" => $tanggal,
      "qty" => $jumlah,
      "total" => $total
    ]);

    if ($query) {
      $this->db->where("id", $id_obat);
      $this->db->update("drugs", ["stock" => ($obat["stock"]+$jumlah)]);
      $this->session->set_flashdata("msg", "<div class='alert alert-success'>Pembelian ". $obat["name"]. " sebanyak ". $jumlah. " berhasil</div>");
      redirect("admin/purchases");
    } else {
      $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Pembelian gagal! </div>");
      redirect("admin/purchases");
    }
  }
  public function add_sale() {
    $nota_num = $this->input->post("nota_num");
    $id_obat = $this->input->post("id_obat");
    $jumlah = $this->input->post("jumlah");
    $tanggal = $this->input->post("tanggal");

    $obat = $this->db->get_where("drugs", ["id" => $id_obat])->row_array();
    $selling_price = $obat["selling_price"];
    $total = ($selling_price * $jumlah);

    if ($jumlah > $obat["stock"]) {
      $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Gagal! jumlah penjual melebihi stok yang ada, jumlah pembelian = ".$jumlah. ", sedangkan stok obat ". $obat["name"]. " hanya sebanyak ". $obat["stock"]. "</div>");
      redirect("admin/sales");
    } else {
      $query = $this->db->insert("sales", [
        "id" => null,
        "nota_num" => $nota_num,
        "id_drug" => $id_obat,
        "qty" => $jumlah,
        "date" => $tanggal,
        "total" => $total
      ]);

      if ($query) {
        $this->db->where("id", $id_obat);
        $this->db->update("drugs", ["stock" => ($obat["stock"]-$jumlah)]);
        $this->session->set_flashdata("msg", "<div class='alert alert-success'>Penjualan ". $obat["name"]. " sebanyak ". $jumlah. " berhasil</div>");
        redirect("admin/sales");
      } else {
        $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Pembelian gagal! </div>");
        redirect("admin/purchases");
      }
    }
  }
  public function addunit() {
    $unitname = $this->input->post("unitname");

    $cek = $this->db->get_where("units", array("name" => $unitname))->result();

    if (count($cek) != 0) {
      $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Terdapat nama satuan yang sama! </div>");
      redirect("admin/units");
    } else {
      $arr = ["name" => $unitname];
      $this->db->insert("units", $arr);
      $this->session->set_flashdata("msg", "<div class='alert alert-success'>Berhasil menambahkan data! </div>");
      redirect("admin/units");
    }
  }
  public function addsupplier() {
    $name = $this->input->post("name");
    $phone = $this->input->post("phone");
    $address = $this->input->post("address");

    $arr = [
      "id" => null,
      "name" => $name,
      "hp" => $phone,
      "address" => $address
    ];
    $query = $this->db->insert("suppliers", $arr);
    if ($this->db->affected_rows() > 0) {
      $this->session->set_flashdata("msg", "<div class='alert alert-success'>Berhasil menambahkan data! </div>");
      redirect("admin/suppliers");
    } else {
      $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Gagal menambahkan data! </div>");
      redirect("admin/suppliers");
    }
  }

  // EDIT DATA
  public function editdrug() {
    $id_obat = $this->input->post("id_obat");
    $kode_obat = $this->input->post("kode_obat");
    $nama_obat = $this->input->post("nama_obat");
    $id_unit = $this->input->post("satuan");
    $harga_beli = $this->input->post("harga_beli");
    $harga_jual = $this->input->post("harga_jual");

    $this->db->where("id", $id_obat);
    $this->db->update("drugs", [
      "name" => $nama_obat,
      "id_unit" => $id_unit,
      "purchase_price" => $harga_beli,
      "selling_price" => $harga_jual
    ]);
    $this->session->set_flashdata("msg", "<div class='alert alert-success'>Data berhasil diperbarui! </div>");
    redirect("admin/drugs");
  }

  public function editunit() {
    $id = $this->input->post("id_unit");
    $name = $this->input->post("unitname");

    $cek = $this->db->query("select * from units where id != ".$id)->result();
    foreach ($cek as $c) {
      if (strtolower($name) == strtolower($c->name)) {
        $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Gagal, terdapat nama yang sama! </div>");
        redirect("admin/units");
      } else {
        $this->db->where("id", $id);
        $this->db->update("units", ["name" => $name]);
        $this->session->set_flashdata("msg", "<div class='alert alert-success'>Data berhasil diperbarui! </div>");
        redirect("admin/units");
      }
    }
  }
  public function editsupplier() {
    $id = $this->input->post("id_supplier");
    $name = $this->input->post("name");
    $hp = $this->input->post("phone");
    $address = $this->input->post("address");

    $this->db->where("id", $id);
    $this->db->update("suppliers", [
      "name" => $name,
      "hp" => $hp,
      "address" => $address
    ]);
    if ($this->db->affected_rows() > 0) {
      $this->session->set_flashdata("msg", "<div class='alert alert-success'>Data berhasil diperbarui! </div>");
      redirect("admin/suppliers");
    } else {
      $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Data gagal diperbarui! </div>");
      redirect("admin/suppliers");
    }
  }

  // DELETE DATA
  public function deletedrug($id) {
    $this->db->delete("drugs", ["id" => $id]);
    $this->session->set_flashdata("msg", "<div class='alert alert-success'>Obat berhasil dihapus!</div>");
    redirect("admin/drugs");
  }

  public function deletepurchase($id) {

    $query = $this->db->delete("purchase", ["id" => $id]);
    if ($query) {
      $this->session->set_flashdata("msg", "<div class='alert alert-success'>Pembelian berhasil dihapus!</div>");
      redirect("admin/purchases");
    } else {
      $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Gagal dihapus!</div>");
      redirect("admin/purchases");
    }
  }

  public function deletesale($id) {
    $cek = $this->db->query('select sales.*, drugs.id as ido, drugs.* from sales inner join drugs on sales.id_drug = drugs.id where sales.id = '. $id)->result();

    $this->db->where(['id' => $cek[0]->ido]);
    $this->db->update('drugs', ['stock' => $cek[0]->stock+$cek[0]->qty]);

    $this->db->delete("sales", ["id" => $id]);
    $this->session->set_flashdata("msg", "<div class='alert alert-success'>Data berhasil dihapus!</div>");
    redirect("admin/sales");
  }
  public function deleteunit($id) {
    $query = $this->db->delete("units", ["id" => $id]);

    if ($query) {
      $this->session->set_flashdata("msg", "<div class='alert alert-success'>Data berhasil dihapus!</div>");
      redirect("admin/units");
    } else {
      $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Data gagal dihapus!</div>");
      redirect("admin/units");
    }
  }
  public function deletesupplier($id) {
    $query = $this->db->delete("suppliers", ["id" => $id]);
    if ($this->db->affected_rows() > 0) {
      $this->session->set_flashdata("msg", "<div class='alert alert-success'>Data berhasil dihapus!</div>");
      redirect("admin/suppliers");
    } else {
      $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Data gagal dihapus!</div>");
      redirect("admin/suppliers");
    }
  }

  public function printdrugs() {
    $filter = $this->input->get("filter");

    $data["title"] = "Cetak Laporan";
    if ($filter == 'stok' || $filter == 'hargabeli' || $filter == 'hargajual') {
      $mulaidari = $this->input->get('mulaidari');
      $hingga = $this->input->get('hingga');

      if ($filter == 'stok') {
        $data["drugs"] = $this->db->query("select drugs.*, drugs.name as dname, units.name as uname from drugs inner join units on drugs.id_unit = units.id where drugs.stock between $mulaidari and $hingga")->result();
        $data["ket"] = "Stok mulai dari ".$mulaidari." hingga ".$hingga;
      } elseif ($filter == 'hargabeli') {
        $data["drugs"] = $this->db->query("select drugs.*, drugs.name as dname, units.name as uname from drugs inner join units on drugs.id_unit = units.id where drugs.purchase_price between $mulaidari and $hingga")->result();
        $data["ket"] = "Harga beli mulai dari ".$mulaidari." hingga ".$hingga;
      } elseif ($filter == 'hargajual') {
        $data["drugs"] = $this->db->query("select drugs.*, drugs.name as dname, units.name as uname from drugs inner join units on drugs.id_unit = units.id where drugs.selling_price between $mulaidari and $hingga")->result();
        $data["ket"] = "Harga jual mulai dari ".$mulaidari." hingga ".$hingga;
      }
    } else {
      $satuan = $this->input->get("satuan");
      $data["drugs"] = $this->db->query("select drugs.*, drugs.name as dname, units.name as uname from drugs inner join units on drugs.id_unit = units.id where drugs.id_unit = $satuan")->result();
      $uname = $this->db->get_where("units", ["id" => $satuan])->row_array();
      $data["ket"] = "satuan ".$uname["name"];
    }

    $this->load->view("module/header", $data);
    $this->load->view("admin/prints/drugs", $data);
  }
  
  public function printpurchase(){
    $tglmulai = $this->input->get("tglmulai");
    $tglhingga = $this->input->get("tglhingga");
    
    $data['title'] = "Laporan data pembelian";
    $data['purchases'] = $this->db->query("SELECT purchase.*, drugs.name as dname, suppliers.name as sname from purchase inner join drugs on purchase.id_drug = drugs.id inner join suppliers on purchase.id_supplier = suppliers.id where purchase.date BETWEEN CAST('$tglmulai' as DATE) and CAST('$tglhingga' as DATE)")->result();
    
    $dcm = date_create($tglmulai);
    $dch = date_create($tglhingga);
    $ftglmulai = date_format($dcm, 'd M Y');
    $ftglhingga = date_format($dch, 'd M Y');
    $data['ket'] = $ftglmulai.' hingga '.$ftglhingga;
    
    $this->load->view("module/header", $data);
    $this->load->view("admin/prints/purchases", $data);
  }
  
  public function printsale(){
    $tglmulai = $this->input->get("tglmulai");
    $tglhingga = $this->input->get("tglhingga");
    
    $data['title'] = "Laporan data penjualan";
    $data['sales'] = $this->db->query("select sales.*, drugs.name as dname from sales inner join drugs on sales.id_drug = drugs.id where sales.date BETWEEN CAST('$tglmulai' as DATE) and CAST('$tglhingga' as DATE)")->result();
    
    $dcm = date_create($tglmulai);
    $dch = date_create($tglhingga);
    $ftglmulai = date_format($dcm, 'd M Y');
    $ftglhingga = date_format($dch, 'd M Y');
    $data['ket'] = $ftglmulai.' hingga '.$ftglhingga;
    
    $this->load->view("module/header", $data);
    $this->load->view("admin/prints/sales", $data);
  }
}