@extends('layouts.app')
@section('title', 'Home')


@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Department</h3>
      <div class="card-tools">

      </div>
      <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @if(Auth::user()->user_type == "Student")
        <script>window.location = "/appointments";</script>
        @elseif (Auth::user()->user_type == "Users")
        <script>window.location = "/dashboard";</script>
        @else
        <script>window.location = "/showappointment";</script>
        @endif
    </div>

    <!-- /.card-footer -->
  </div>
@endsection

