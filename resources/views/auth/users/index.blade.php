@extends('layouts.app')
@section('title', 'Users')


@section('content')
@include('users.user-form')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Users</h3>
      <div class="card-tools">

      </div>
      <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <table class="table table-bordered table-hover data-table w-100">
          <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email Address</th>
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
 $( document ).ready(function() {


    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('allUsers') }}",
        columns: [
            {data: 'firstname', name: 'firstname'},
            {data: 'lastname', name: 'lastname'},
            {data: 'email', name: 'email'},
            {data: 'options', name: 'options', orderable: false, searchable: false}
        ],

        dom: "lBtipr",
            buttons: {
            buttons: [
                {
                text: "Create New",
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
          { width: "25%", targets: 1 },
          { width: "25%", targets: 2 },
          { width: "15%", targets: 3 }
        ],
    });


    $('#form').submit(function (e) {
        e.preventDefault();
        $('#form').find('input,small').removeClass('is-invalid').text('');
        var url;
        if($('#id').val()===""){
          url="{{ route('users.store') }}";
        }else{
          url="{{ route('users.update') }}";
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
    //edit
    $('.data-table').on('click', '.edit', function () {
      var id = $(this).data("id");
      $.get("{{ route('users.index') }}" +'/' + id +'/edit', function (data) {
          $('form[name=form]')[0].reset();
          $('#form').find('input,small').removeClass('is-invalid').text('');
          $('#modal .modal-title').html('Edit');
          $('#modal').modal('show');
          $('#id').val(data.id);
          $('#firstname').val(data.firstname);
          $('#lastname').val(data.lastname);
          $('#email').val(data.email);
          $('#id_number').val(data.id_number);
          $('#mobile_no').val(data.mobile_no);
          $('#address').val(data.address);
          $('#department_id').val(data.department_id);

      });
    });
    //delete
    $('.data-table').on('click', '.delete', function () {

          var id = $(this).data("id");
          $confirm =confirm("Are You sure want to delete !");

          if($confirm == true ){
              $.ajax({
                  type: "DELETE",
                  url: "{{ route('users.store') }}"+'/'+id,
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

  });
</script>
@endsection
