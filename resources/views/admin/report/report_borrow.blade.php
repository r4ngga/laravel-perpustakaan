@extends('template/maindashboard')

@section('title','Show Report Borrow')

@section('container')
<div class="container mt-3 mb-5">

    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'Show Report Borrow Book', 'is_active' => true]),
                'title' => 'Report Borrow Book'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col">
            <h3> Report Borrow Book</h3>

            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
             @endif
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Number</th>
                    <th scope="col">Code Borrow</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Name</th>
                    <th scope="col">Time Borrow</th>
                    <th scope="col">Time Return</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($borrow as $br)
                  <tr>
                    <th scope="row">{{$br->number_borrow}}</th>
                    <td>{{$br->code_borrow}}</td>
                    <td>{{$br->name_book}}</td>
                    <td>{{$br->name}}</td>
                    <td>{{$br->time_borrow}}</td>
                    <td>{{$br->time_return}}</td>
                    <td>{{$br->status}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>



@endsection
