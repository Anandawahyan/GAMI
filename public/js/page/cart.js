$.ajax({
  url: '/discount',
  type: 'get',
  dataType: 'json',
  success: function(response) {
    $('#discountForm').append(`<option selected>Silahkan pilih diskon</option>` ,response.data.map(discount => `<option value='${discount.id}'>${discount.name}</option>`));
  },
  error: function(err) {
    console.log(err.responseText)
  }
});