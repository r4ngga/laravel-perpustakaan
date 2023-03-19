@extends('template/maindashboard')

@section('title','Returned Book')

@section('container')


<div class="container mt-3 mb-5">

    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'Return Book', 'is_active' => true]),
                'title' => 'Return Books'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col">
            <h3> Returned Book</h3>
            @if(session('notify'))
                <div class="alert alert-success my-2" role="alert">
               {{session('notify')}}
               </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Code Borrow</th>
                        <th scope="col">Id User</th>
                        <th scope="col">Time Borrow</th>
                        <th scope="col">Time Return</th>
                        <th scope="col">Status</th>
                        <th scope="col">Act</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($borrow as $br)
                    @if($br->status == "borrow")
                    <tr>
                        <th scope="row">{{$br->code_borrow}}</th>
                        <td>{{$br->id_user}}</td>
                        <td>{{$br->time_borrow}}</td>
                        <td>{{$br->time_return}}</td>
                        <td>{{$br->status}}</td>
                        <td><a href="{{$br->code_borrow}}/#ChangeDataBorrowBook" class="btn btn-info" data-toggle="modal" data-target="#ChangeDataBorrowBook{{$br->code_borrow}}">Change</a></td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($borrow as $br)
<div class="modal fade" id="ChangeDataBorrowBook{{$br->code_borrow}}" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Are You Sure This User Has Return Book ?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="/returnedbook" method="POST">
                  @csrf
                  <div class="form-group">
                      <label for="">Code Borrow</label>
                      <input type="text" class="form-control" id="code_borrow" name="code_borrow" value="{{$br->code_borrow}}" readonly>
                  </div>

                  <div class="form-group">
                        <label for="exampleFormControlSelect1">Change Status</label>
                        <select class="form-control" id="status" name="status">
                          <option>Please Select </option>
                          <option value="return">return</option>
                        </select>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">Confirm</button>
                  </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
</div>
@endforeach

@endsection()
