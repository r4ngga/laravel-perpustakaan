@extends('template/maindashboard')

@section('title','Show Report Request')

@section('container')
<div class="container mt-3 mb-5">

    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => ' Report Request Book', 'is_active' => true]),
                'title' => 'Request Book'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col">
            <h3> Report Request Book</h3>

            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
             @endif
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Number</th>
                    <th scope="col">Code Request</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Name</th>
                    <th scope="col">Time Request</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach($req as $rq)
                  <tr>
                    <th scope="row">{{$no++}}</th>
                    <td>{{$rq->code_request}}</td>
                    <td>{{$rq->name_book}}</td>
                    <td>{{$rq->name}}</td>
                    <td>{{$rq->time_request}}</td>
                    <td>{{$rq->status_request}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>



@endsection
