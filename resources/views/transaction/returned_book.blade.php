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
                        <td>
                          <a href="javascript:void(0)" class="btn btn-info" data-toggle="modal" data-target="#ChangeDataBorrowBook">
                            Change
                          </a>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- @foreach($borrow as $br) --}}
<div class="modal fade" id="ChangeDataBorrowBook" tabindex="-1">
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
                      <input type="text" class="form-control" id="code_borrow" name="code_borrow" value="" readonly>
                  </div>

                  <input type="hidden" name="" id="br-iduser">
                  <input type="hidden" name="" id="br-idbook">

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
{{-- @endforeach --}}

@endsection()

@section('scripts')
  <script>
    function getEdtBr(cdbr, iduser, idbk)
    {
      let code_borrow = cdbr;
      let id_user = iduser;
      let id_book = idbk;
      console.log(code_borrow, id_user, id_book);

      document.getElementById('code_borrow').value = code_borrow;
      document.getElementById('br-iduser').value = id_user;
      document.getElementById('br-idbook').value = id_book;
    }
  </script>
@endsection
