
$(document).ready(function() {
 
    function loader()
	{
		var load = "<i class=\"fa fa-circle-o-notch fa-2x fa-spin\"></i>";
		return load;
	}

    $('#Tanggal').datepicker({
        format: 'yyyy-mm-dd',
		autoclose:true
    });

    var tables = $('#example').DataTable({
        "autoWidth": false,
        responsive: true,
        pagingType: 'full_numbers',
        "iDisplayLength": 15,
        "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "All"]],
        "columnDefs": 
        [
            {"targets": [0], "data": 'no', "width": "7%", "searchable":false, "orderable":false},
            {"targets": [1], className: "center", "data":'Nama_barang'},
            {"targets": [2], className: "center", "data":'Kode_barang'},
            {"targets": [3], className: "center", "data":'Jumlah_barang'},
            {"targets": [4], className: "center", "data":'Tanggal'},
            {"targets": [5], className: "center", "data":'Id', "sortable": false,
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
              $(nTd).html(action());
             }
            }
            
        ],
        "oLanguage": {"sProcessing": loader},
        "processing": true,
        "serverSide": true, 
        "ajax": {
            "url":$('#url2').val(),
            "type": "POST"
        }
    });

	function action(){
		html = '<button type="button" class="btn btn-danger" id="delete"> Delete</button>'+
        '<button type="button" class="btn btn-warning" id="edit" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap"> Update</button>';
		return html;	

	}
	

    $('#btnSave').click(function (){
		
        if($('#Id').val() != ""){
            var url = $('#url1').val();
        }else{
            var url = $('#url').val();
        }
		$.ajax({
			url : url,
			type: "POST",
			data: $('#formproduk').serialize(),
			dataType: "JSON",
			success: function(data)
			{
				if(data.status != "failedval") //if success close modal and reload ajax table
				{
                    alert(data.message);
					$('#exampleModal').modal('hide');
				//	$('#myModalDelete').modal('hide');
					tables.ajax.reload();
				}
			
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				alert('Error get data from ajax');
			}
		}); 
	});

    $('#add').click(function (){
		$('#formproduk')[0].reset();
		$('[name="Id"]').val("");

		$('#role').prop('selectedIndex',0);
		
		$('.form-group').removeClass('has-error');
		$('.help-block').empty(); 
		$('#exampleModal').modal('show');
		$('.modal-title').text('Tambah Produk');
	});

    $('#example').on( 'click', '#edit', function () {
		$('#formproduk')[0].reset(); // reset form on modals

		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string
		$('#myModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Edit Produk');
		var Produk = tables.row( $(this).parents('tr') ).data();

		$.ajax({
			url : $('#url3').val() + '/' + Produk.Id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				$('[name="Id"]').val(data.Id);
				$('[name="Nama_barang"]').val(data.Nama_barang);		
				$('[name="Kode_barang"]').val(data.Kode_barang);
                $('[name="Jumlah_barang"]').val(data.Jumlah_barang);		
				$('[name="Tanggal"]').val(data.Tanggal);

			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error get data from ajax');
			}
		})
       
    } );
	

    $('#example').on( 'click', '#delete', function () {
		
		var Produk = tables.row( $(this).parents('tr') ).data();

		$.ajax({
			url : $('#url4').val() + '/' + Produk.Id,
			type: "POST",
			dataType: "JSON",
			success: function(data)
			{
                tables.ajax.reload();
				alert(data.message);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error get data from ajax');
			}
		})
       
    } );
	


} );