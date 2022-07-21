@extends('layouts.app')
@section('title', 'Appointment')


@section('content')
@include('students.form')
@include('students.qr')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Appointment</h3>
      <div class="card-tools">

      </div>
      <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <table class="table table-bordered table-hover data-table w-100">
          <thead>
          <tr>
            <th>Teacher</th>
            <th>Start</th>
            <th>End</th>
            <th>Status</th>
            <th width="80px"></th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>

    <!-- /.card-footer -->
  </div>
@endsection

@section('scripts')
<script type="text/javascript">
$(function () {

    $('.select2').select2({
          theme: 'bootstrap4'
      });

      $('#appointment_date_start').datetimepicker({ icons: { time: 'far fa-clock' } });
      $('#appointment_date_end').datetimepicker({ icons: { time: 'far fa-clock' } });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('myappointment') }}",
        columns: [
            {data: 'staff_name', name: 'staff_name'},
            {
                data: 'appointment_date_start',
                render: function (data) {

                    return moment(data).format('MMM D YYYY  hh:mm a');

                }
            },
            {
                data: 'appointment_date_end',
                render: function (data) {

                   return moment(data).format('hh:mm a');
                }
            },

            {
                            'data': 'status',
                            'render': function (data) {
                                if(data==='Pending'){
                                    return '<label class="badge badge-info">Pending</label>';
                                }else if(data==='Approved'){
                                    return '<label class="badge badge-success">Approved</label>';
                                }else{
                                    return '<label class="badge badge-danger">Decline</label>';
                                }
                            }
                        },

            {data: 'options', name: 'options', orderable: false, searchable: false}
        ],

        dom: "lBtipr",
            buttons: {
            buttons: [
                {
                text: "Create New Appointment",
                    action: function(e, dt, node, config) {
                        $('#modal .modal-title').html('New');
                        $('#form')[0].reset();
                        $('#form').find('input,small').removeClass('is-invalid').text('');
                        $('#modal').modal('show');
                    }
                }
            ],
            dom: {
                button: {
                tag: "button",
                className: "btn btn-default group-vertical"
                },
                buttonLiner: {
                tag: null
                }
            }
        },

        columnDefs: [
          { width: "20%", targets: 0 },
          { width: "15%", targets: 1 },
          { width: "15%", targets: 2 },
          { width: "10%", targets: 3 },
          { width: "15%", targets: 4},

        ],
    });


    $('#form').submit(function (e) {
        e.preventDefault();
        $('#form').find('input,small').removeClass('is-invalid').text('');
        var url;
        if($('#id').val()===""){
          url="{{ route('appointments.store') }}";
        }else{
          url="{{ route('appointments.update') }}";
        }
        $.ajax({
          data: $('#form').serialize(),
          url: url,
          type: "POST",
          dataType: 'json',
          success: function (data) {
            $('#form').trigger("reset");
            $('#modal').modal('hide');
            table.draw();
            toastr.success(data.success);
            $.ajax({
                type: "get",
                url: "send_to_staff/" + data.id,
                success: function(res){
                    console.log(res);
                },
                error:function(error)
                {
                console.log(error);
            }
            });
          },
          error:function(err)
            {
                if(err.status===422){
                  var errors =$.parseJSON(err.responseText);
                  $.each(errors.errors, function(key, value){
                    $('#' +key).addClass('is-invalid');
                    $('#' +key).focus();
                    $('#'+key+"_help").text(value[0]);
                  })
                }
            }
      });
    });

    //delete
    $('.data-table').on('click', '.delete', function () {

          var id = $(this).data("id");
          $confirm =confirm("Are You sure want to delete !");

          if($confirm == true ){
              $.ajax({
                  type: "DELETE",
                  url: "{{ route('appointments.store') }}"+'/'+id,
                  success: function (data) {
                      table.draw();
                      toastr.error('Record successfully deleted');
                  },
                  error: function (data) {
                      console.log('Error:', data);
                  }
              });
          }
    });

    $('.data-table').on('click', '.view', function () {

      var id = $(this).data("id");
      var file_path='./public/storage/img/' + id + '.svg';
      $('#qrimage').attr('src',file_path);
      $('#qrcode').val(id);
      $('#qrmodal').modal('show');
    });
  });
</script>
@endsection
