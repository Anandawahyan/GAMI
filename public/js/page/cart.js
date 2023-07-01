$.ajax({
  url: '/discount',
  type: 'get',
  dataType: 'json',
  success: function(response) {
    $('#discountForm').append(`<option selected value="">Silahkan pilih diskon</option>` ,response.data.map(discount => `<option value='${discount.id}'>${discount.name}</option>`));
    
    $('#discountForm').on('change', function(){
      let selectedDiscountId = $('#discountForm').val();
      response.data.forEach(discount => {
        if(discount.id === parseInt(selectedDiscountId)) {
          changeTotalPrice(discount.percentage);
        } else if (!parseInt(selectedDiscountId)) {
          changeTotalPrice(0);
        }
      })
    });

  },
  error: function(err) {
    console.log(err.responseText);
  }
});

function changeTotalPrice(discountPercentage) {
  const totalPriceInt = parseInt($('#totalPriceBeforeDiscount').val());
  const discountPrice = totalPriceInt * discountPercentage/100;
  const afterDiscountPrice = totalPriceInt - discountPrice;

  $('#priceText').text(formatRupiah(afterDiscountPrice));


}

function formatRupiah(amount) {
  const formatter = new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 2,
  });

  return formatter.format(amount);
}

