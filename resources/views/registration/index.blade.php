@extends('layouts.login')
@section('content')
@section('title', 'Registration')

<div class="register-box">
    <div class="register-logo">
        <a href="{{ url('/home')}}"><b>Appointment</b> System</a>
    </div>
    <div class="card">
    <div class="card-body register-card-body">
    <p class="login-box-msg">Register</p>
    <form id="form" name="form">
        @csrf
      <div>
        <div class="form-group">
            <select id='user_type' name='user_type' class="select2 form-control">
                <option value=''>Select Type</option>
                <option value="Student">Student</option>
                <option value="Staff">Staff</option>

            </select>
            <small id="user_type_help" class="text-danger"></small>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" id="id_number" name="id_number" placeholder="ID Number">
              <small id="id_number_help" class="text-danger"></small>
            </div>
          <div class="form-group">
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname">
              <small id="firstname_help" class="text-danger"></small>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname">
              <small id="lastname_help" class="text-danger"></small>
            </div>
            <div class="form-group">
              <textarea name="address" id="address" class="form-control" rows="2" placeholder="Address"></textarea>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile No.">
              <small id="mobile_no_help" class="text-danger"></small>
            </div>

            <div class="form-group">
              <select id='department_id' name='department_id' class="select2 form-control">
                <option value='0'>Select Department</option>
                @foreach($department['data'] as $department)
                  <option value='{{ $department->id }}'>{{ $department->department }}</option>
                @endforeach
              </select>
              <small id="department_id_help" class="text-danger"></small>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="email" name="email" placeholder="Email address">
              <small id="email_help" class="text-danger"></small>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              <small id="password_help" class="text-danger"></small>
            </div>


      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Register</button>
      </div>
    </form>


    </div>

    </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
$(function () {

    $('.select2').select2({
          theme: 'bootstrap4'
    })

    $('#form').submit(function (e) {
        e.preventDefault();


        $.ajax({
          data: $('#form').serialize(),
          url: "{{ route('users.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            $('#form').trigger("reset");

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



  });
</script>
@endsection
