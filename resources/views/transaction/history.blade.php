@extends('template/maindashboard')

@section('title','Show History')

@section('container')
<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col">
            <h3> History Borrow & Request Book</h3>
            <div class="row mb-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#historyRequest">History Request</button>
            </div>
            <div class="row">
                <button class="btn btn-primary" data-toggle="modal" data-target="#historyBorrow">History Borrow</button>
            </div>


        </div>
    </div>
</div>

<div class="modal fade" id="historyRequest" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">History Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table" id="tableHistoryRequest">
                <thead>
                  <tr>
                    <th scope="col">Code Request</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Time Request</th>
                    <th scope="col">Status Request</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($req as $rq)
                  <tr>
                    <td>{{$rq->code_request}}</td>
                    <td>{{$rq->name_book}}</td>
                    <td>{{$rq->time_request}}</td>
                    <td>{{$rq->status_request}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="historyBorrow" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">History Borrow</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table" id="tableHistoryBorrow">
                <thead>
                  <tr>
                    <th scope="col">Code Borrow</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Time Borrow</th>
                    <th scope="col">Time Return</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($borrow as $br)
                  <tr>
                    <td>{{$br->code_borrow}}</td>
                    <td>{{$br->name_book}}</td>
                    <td>{{$br->time_borrow}}</td>
                    <td>{{$br->time_return}}</td>
                    <td>{{$br->status}}</td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

@endsection
