<!DOCTYPE html>
<html>
  <head>
    <title>Scan QR Code</title>
    @include('layouts.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script src="{{ asset('js/instascan.min.js')  }}"></script>
    <style>
        .center {
  margin: auto;
  width: 30%;

}
</style>
  </head>
  <body>

    <div class="row">

          <div class="center">
            <video id="preview"></video>

          </div>

    </div>

<div class="row">
  <div class="col-md-2">
  </div>
      <div class="col-md-8">
        <h5 class="text-center">Scan QR Code</h5>
      <div class="card card-default">
      <div class="card-header">
      <h3 class="card-title">
        &nbsp;

      </h3>
      </div>

      <div class="card-body">

        <div class="alert alert-success alert-dismissible" id="alert-success" style="display: none">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-info"></i> Welcome </h5>

        </div>
        <div class="alert alert-danger alert-dismissible" id="alert-danger" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="fas fa-exclamation-triangle"></i> No Scheduled Appointment</h5>

        </div>

          <strong><i class="fas fa-info mr-1"></i> Appointee</strong>
          <p class="text-muted" id="student_name">

          </p>
          <hr>
          <strong><i class="fas fa-clock"></i> Appointment Time</strong>
          <p class="text-muted" id="appointment_time"></p>
          <hr>
          <strong><i class="fas fa-user"></i> Teacher</strong>
          <p class="text-muted" id="staff_name">

          </p>

</div>
      </div>

      </div>
      </div>
      <div class="col-md-2">
      </div>
</div>

    <script type="text/javascript">

      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

      scanner.addListener('scan', function (content) {

        $.ajax({
            dataType: 'json',
            url: 'qrscan/' + content,

            success:function(data){

                if(data){
                    if(data.status==="withsched"){
                        $('#student_name').text(data.student_name);
                        $('#appointment_time').text(moment(data.appointment_date_start).format('MMM D YYYY  hh:mm a') + ' to ' + moment(data.appointment_date_end).format(' hh:mm a'));
                        $('#staff_name').text(data.staff_name);
                        $('#alert-success').attr('style', 'display:block');
                        $('#alert-danger').attr('style', 'display:none');
                    }else{
                        $('#alert-success').attr('style', 'display:none');
                        $('#alert-danger').attr('style', 'display:block');
                        $('#student_name').text('');
                        $('#appointment_time').text('');
                        $('#staff_name').text('');
                    }

                }else{
                  $('#student_name').text('');
                  $('#appointment_time').text('');
                  $('#staff_name').text('');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {



            }
        });

      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');

        }

      }).catch(function (e) {
        console.error(e);
      });

    </script>
    @include('layouts.scripts')
  </body>
</html>
