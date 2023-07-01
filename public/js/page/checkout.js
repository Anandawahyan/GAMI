
Swal.fire({
    title: "Loading...",
    html: "Please wait a moment"
});
Swal.showLoading();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let alamats = [];

$.ajax({
    url: '/address',
    type: 'get',
    dataType: 'json',
    success: function(response) {
        alamats = response.data
        putAlamatToOptions(alamats);
        $('#alamatId').on('change', function(){
            let selectedAlamatId = $('#alamatId').val();
            response.data.forEach(alamat => {
              if(alamat.id === parseInt(selectedAlamatId)) {
                changeOngkir(alamat.ongkir);
                changeTotalPrice(alamat.ongkir);
              } else if (!parseInt(selectedAlamatId)) {
                changeOngkir(0);
                changeTotalPrice(0);
              }
            })
        });
        Swal.close();
    }, error: function(err) {
        Swal.close();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        });
        console.err(err.responseText);
    }
});

$('#alamatBaruForm').on('submit', function(e) {
    e.preventDefault();

    var alamatBaru = $("input[name=alamatBaru]").val();
    var kotaBaru = $("select[name=kotaBaru]").val();

    Swal.fire({
    title: "Loading...",
    html: "Please wait a moment"
    });
    Swal.showLoading();
    $.ajax({
        url: '/address',
        type: 'post',
        dataType: 'json',
        data: {alamatBaru: alamatBaru, kotaBaru: kotaBaru},
        success: function(response) {
            console.log(response.data);
            putAlamatToOptions(alamats, response.data);
            Swal.close();
        },
        error: function(err) {
            console.log(err);
            console.log(err.responseText);
        }
    })
})


function putAlamatToOptions(alamatArray, desiredAlamat = null) {
    if(!alamatArray) {
        $('#alamatId').prop('disabled', true);
        return
    }

    $('#alamatId').prop('disabled', false);
    if(desiredAlamat) {
        console.log(desiredAlamat);
        changeOngkir(desiredAlamat.ongkir);
        changeTotalPrice(desiredAlamat.ongkir);
        $('#alamatId').append(`<option selected value="${desiredAlamat.id}">${desiredAlamat.alamat_rumah}</option>`);
        // $('#alamatId').append(alamatArray.map(alamat => `<option ${desiredAlamatId === alamat.id ? 'selected' : ''} value="${alamat.id_kota}">${alamat.alamat_rumah}</option>`));
    } else {
        $('#alamatId').append(alamatArray.map((alamat, index) => `<option ${index === 0 ? 'selected' : ''} value="${alamat.id}">${alamat.alamat_rumah}</option>`));
        console.log(alamatArray[0].ongkir);
        changeOngkir(alamatArray[0].ongkir);
        changeTotalPrice(alamatArray[0].ongkir);
    }  
}

function changeOngkir(ongkir) {
    $('#ongkirInput').val(ongkir);
    $('#ongkirText').text(formatRupiah(ongkir));
}

function changeTotalPrice(ongkir) {
    totalPrice = parseInt($('#totalPrice').val());
    $('#totalPriceText').text(formatRupiah(totalPrice+ongkir));
}

function formatRupiah(amount) {
    const formatter = new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 2,
    });
  
    return formatter.format(amount);
}