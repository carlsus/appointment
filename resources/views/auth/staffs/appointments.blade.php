@extends('layouts.app')
@section('title', 'Appointment')


@section('content')

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
            <th>Student</th>
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
  @include('students.qr')


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
        ajax: "{{ route('staffappointment') }}",
        columns: [
            {data: 'student_name', name: 'student_name'},
            {
                data: 'appointment_date_start',
                render: function (data) {
                    return moment(data).format('MMM D YYYY  hh:mm a');
                }
            },
            {
                data: 'appointment_date_end',
                render: function (data) {
                    return moment(data).format('MMM D YYYY  hh:mm a');
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

        // dom: "lBtipr",
        //     buttons: {
        //     buttons: [
        //         {
        //         text: "Create New Appointment",
        //             action: function(e, dt, node, config) {
        //                 $('#modal .modal-title').html('New');
        //                 $('#form')[0].reset();
        //                 $('#form').find('input,small').removeClass('is-invalid').text('');
        //                 $('#modal').modal('show');
        //             }
        //         }
        //     ],
        //     dom: {
        //         button: {
        //         tag: "button",
        //         className: "btn btn-default group-vertical"
        //         },
        //         buttonLiner: {
        //         tag: null
        //         }
        //     }
        // },

        columnDefs: [
          { width: "20%", targets: 0 },
          { width: "25%", targets: 1 },
          { width: "25%", targets: 2 },
          { width: "15%", targets: 3 }
        ],
    });
    //approve
    $('.data-table').on('click', '.approve', function () {
      var id = $(this).data("id");
      let isExecuted = confirm("Are you sure to approve this appointment?");

      if(isExecuted==true){
        $.ajax({
			url: "{{ url('appointments/updateStatus') }}" +'/' + id ,
			type: "PATCH",
			cache: false,
			data:{
                _token:'{{ csrf_token() }}',
				id: id

			},
			success: function(dataResult){
                dataResult = JSON.parse(dataResult);

             if(dataResult.statusCode)
             {
                table.draw();
                toastr.success('Appointment approved');
                $.ajax({
                type: "get",
                url: "send_to_student/" + id,
                success: function(res){
                    console.log(res);
                },
                error:function(error)
                {
                console.log(error);
            }
            });
             }
             else{
                 alert("Internal Server Error");
             }

			}
		});
      }

    });

    $('.data-table').on('click', '.decline', function () {
      var id = $(this).data("id");

      let isExecuted = confirm("Are you sure to reject this appointment?");

        if(isExecuted==true){
        $.ajax({
            url: "{{ url('appointments/rejectStatus') }}" +'/' + id ,
            type: "PATCH",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                id: id

            },
            success: function(dataResult){
                dataResult = JSON.parse(dataResult);

            if(dataResult.statusCode)
            {
                table.draw();
                toastr.error('Appointement rejected');
            }
            else{
                alert("Internal Server Error");
            }

            }
        });
        }
    });

  });
</script>
@endsection
