@extends('template/maindashboard')

@section('title','Request Borrow Book')

@section('container')
<div class="container mt-4 mb-5">

    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'Info Request Borrow Book', 'is_active' => true]),
                'title' => 'Info Request Books'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>

<h2 class="mb-4">Your Request Borrow a Book</h2>
  <div class="row">
    @foreach($req as $rq)
    {{-- @if($req->count() > 0) --}}
    <div class="col-md-4">
        <div class="card mb-3 mr-2 " style="width: 18rem;">
            <div class="card-body">
             <h5 class="card-title">Request Book</h5>
              <h6 class="card-subtitle mb-2 text-muted">Name User Request : {{$rq->name}}</h6>
              <p class="card-text">
                  Code Request : {{$rq->code_request}} . <br>
                  Name Book : {{$rq->name_book}} . <br>
                  Time Request : {{$rq->time_request}}. <br>
                  Status Request : {{$rq->status_request}}. <br>
                  @if($rq->status_request == "1" || $rq->status_request == 1) {{-- 1 request accept --}}
                  <h6>Let's take your book in library soon</h6>
                  @elseif($rq->status_request == "0" || $rq->status_request == 0) {{-- 0 request cancel --}}
                  <h6>Sorry your request cancelled by admin, please confirmation</h6>
                  @endif
              </p>
            </div>
        </div>
    </div>
    {{-- @endif --}}

    @endforeach
  </div>
</div>

@endsection
