@extends('template/maindashboard')

@section('title','Confirm Request Borrow Book')

@section('container')


<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col">
            <h3>Confrim Request Borrow a Book</h3>
            @if(session('notify'))
                <div class="alert alert-success my-2" role="alert">
               {{session('notify')}}
               </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Code Request</th>
                        <th scope="col">Id User</th>
                        <th scope="col">Name User</th>
                        <th scope="col">Id Book</th>
                        <th scope="col">Name Book</th>
                        <th scope="col">Time Request</th>
                        <th scope="col">Status Request</th>
                        <th scope="col">Act</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($req as $rq)
                    @if($rq->status_request == "request pending")
                    <tr>
                        <th scope="row">{{$rq->code_request}}</th>
                        <td>{{$rq->id_user}}</td>
                        <td>{{$rq->name}}</td>
                        <td>{{$rq->id_book}}</td>
                        <td>{{$rq->name_book}}</td>
                        <td>{{$rq->time_request}}</td>
                        <td>{{$rq->status_request}}</td>
                        <td><a href="{{$rq->code_request}}/#ChangeDataRequestBook" class="btn btn-info" data-toggle="modal" data-target="#ChangeDataRequestBook{{$rq->code_request}}">Change</a></td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($req as $rq)
<div class="modal fade" id="ChangeDataRequestBook{{$rq->code_request}}" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Are You Sure This User Has Request Book for Borrow ?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="/requestedbook" method="POST">
                  @csrf
                  <div class="form-group">
                      <label for="">Code Request</label>
                      <input type="text" class="form-control" id="code_request" name="code_request" value="{{$rq->code_request}}" readonly>
                  </div>

                  <div class="form-group">
                        <label for="exampleFormControlSelect1">Change Status</label>
                        <select class="form-control" id="status_request" name="status_request">
                          <option>Please Select </option>
                          <option value="request accept">request accept</option>
                          <option value="request cancel">request cancel</option>
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
