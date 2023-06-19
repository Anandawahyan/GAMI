"use strict";


$("[data-checkboxes]").each(function() {
  var me = $(this),
    group = me.data('checkboxes'),
    role = me.data('checkbox-role');

  me.change(function() {
    var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
      checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
      dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
      total = all.length,
      checked_length = checked.length;

    if(role == 'dad') {
      if(me.is(':checked')) {
        all.prop('checked', true);
      }else{
        all.prop('checked', false);
      }
    }else{
      if(checked_length >= total) {
        dad.prop('checked', true);
      }else{
        dad.prop('checked', false);
      }
    }
  });
});

$(document).ready( function () {
  moment.locale('id')
  $.fn.dataTable.moment("ddd, D-MMM-YY");
  var table = $('#table-1').DataTable( {
      "dom": 'lrtip',
      "scrollX": false,
      columnDefs: [{
          target: 3, //index of column
      }],
      order: [[3, 'desc']],
  } );

  table.columns.adjust().draw();
  
  $('#table-search').on( 'keyup click', function () {
      table.search($('#table-search').val()).draw();
  } );
  });

  $('#buttonHapus').on('click', function() {
  swal({
      title: 'Apakah kamu yakin menghapus item?',
      text: 'Setelah dihapus, Kamu tidak akan bisa merestore itemnya loh!',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
  })
  .then((willDelete) => {
      if (willDelete) {
      $('#formToDelete').trigger('submit');
      }
  });
  });

  $('#buttonHapusSemua').on('click', function() {
  swal({
      title: 'Apakah kamu yakin menghapus semua?',
      text: 'Setelah dihapus, Kamu tidak akan bisa merestore itemnya loh!',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
  })
  .then((willDelete) => {
      if (willDelete) {
      $('#hapusSemua').trigger('submit');
      }
  });
  });

