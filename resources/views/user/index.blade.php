@extends('template/maindashboard')

@section('title','User Dashboard')

@section('container')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col col-lg-4">
            <div class="card">
              <div class="card-body">
                @if(session('notify'))
                <div class="alert alert-success my-2" role="alert">
                    {{session('notify')}}
                </div>
                @endif
                <p>Your Id User : {{$user->id_user ?? ''}}</p>
                <p>Welcome {{$user->name ?? ''}}</p>
                <p>User Dashboard</p>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {

  $.ajax({
      type: 'GET',
      url: '{{ route('book-count') }}',
      processdata: false,
      success: function(data){
        console.log(data);
      }
  });

  $.ajax({
      type: 'GET',
      url: '{{ route('request-count') }}',
      processdata: false,
      success: function(data){
        console.log(data);
      }
  });

  $.ajax({
      type: 'GET',
      url: '{{ route('borrow-count') }}',
      processdata: false,
      success: function(data)
      {
        console.log(data);
      }
  });

});
</script>  
@endsection
