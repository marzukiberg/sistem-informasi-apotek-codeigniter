$(document).ready(()=> {
  $("#filterKategori").hide()

  const loadDrug = () => {
    $.ajax({
      url: 'http://localhost:8000/apotek-ci/ajax/drugs',
      method: 'post',
      success: (res) => {
        $('#liveData').html(res);
      },
      error: (err) => {
        alert('error mendapatkan data');
      }
    })
  }

  $("#filter").change(function() {
    const selected = $("#filter option:selected").val();

    if (selected === 'kategori') {
      $("#filterKategori").show();
      $("#filterKategori").change(function() {
        const selectedCategory = $("#filterKategori option:selected").val();

        $.ajax({
          url: 'http://localhost:8000/apotek-ci/ajax/drugs',
          method: 'post',
          data: {
            filter: selected, kategori: selectedCategory
          },
          success: (res) => {
            $('#liveData').html(res);
          },
          error: (err) => {
            alert('error mendapatkan data');
          }
        })
      })
    } else {
      $("#filterKategori").hide();
      $.ajax({
        url: 'http://localhost:8000/apotek-ci/ajax/drugs',
        method: 'post',
        data: {
          filter: selected
        },
        success: (res) => {
          $('#liveData').html(res);
        },
        error: (err) => {
          alert('error mendapatkan data');
        }
      })
    }
  })

  const autoFillModalAddDrug = () => {
    $("#mdkode_obat").keyup(()=> {
      alert("Changed")
    })
  }

  loadDrug()
  autoFillModalAddDrug
})