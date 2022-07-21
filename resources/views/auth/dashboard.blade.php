@extends('layouts.app')
@section('title', 'Home')


@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Dashboard</h3>
      <div class="card-tools">

      </div>
      <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    {{-- <div class="card-body">
        @if(Auth::user()->user_type == "Student")
        <script>window.location = "/students";</script>
        @elseif (Auth::user()->user_type == "Users")
        <script>window.location = "/";</script>
        @endif
    </div> --}}

    <!-- /.card-footer -->
  </div>
@endsection

