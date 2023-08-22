@extends('template/maindashboard')

@section('title','Logs')
@section('style')
<style>
     .card-total{
        position: absolute;
        /* right: 100%; */
        left: 65%;
        background: #D0D0D0;
        color: black;
        size: 5em;
        width: 100%;
        height: 100%;
        max-width: 10em;
        text-align: center;
        justify-content: space-around;
        /* padding-top: 1px; */
    }

    .position-col{
        right: 100%;
    }
</style>
@endsection

@section('container')
<div class="container mt-3 mb-5">

    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'All List Log', 'is_active' => true]),
                'title' => 'Show All Logs'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col">
            <h3> All History Logs System</h3>

            <div class="row mb-4">
                {{-- <div class="col col-lg-6">
                    <a href="#" data-toggle="modal" data-target="#insert-user" class="btn btn-primary my-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                      </svg> Insert a new user</a>
                </div> --}}
                <div class="col col-lg-6 pt-1">
                    <div class="card card-total">
                        <h5>Total Users {{ $countLogs ?? 0 }}</h5>
                    </div>
                </div>
            </div>

            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             @endif
            <table class="table table-bordered border-1 mb-2" id="tableUser">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Activity</th>
                    <th scope="col">Type Action</th>
                    <th scope="col">Description</th>
                    <th scope="col">Role</th>
                    {{-- <th scope="col">Data Old</th>
                    <th scope="col">Data New</th> --}}
                    <th scope="col">Log Time</th>
                    <th scope="col" style="text-align: center">Act</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                  <tr>
                    <th scope="row">{{$log->id_user}}</th>
                    <td>{{$log->activity ?? ''}}</td>
                    <td>{{$log->action ?? ''}}</td>
                    <td>{{$log->description ?? ''}}</td>
                    <td>{{$log->role ?? ''}}</td>
                    {{-- <td>{{$log->data_old ?? ''}}</td>
                    <td>{{$log->data_new ?? ''}}</td> --}}
                    <td>{{$log->log_time ?? ''}}</td>
                    <td>
                        {{-- <button onclick="getEdit({{ $usr->id_user }}, '{{ $usr->name }}', '{{ $usr->email }}', '{{$usr->phone_number}}', '{{$usr->address}}', '{{ $usr->gender }}')" data-toggle="modal" data-target="#edit-user" class="btn btn-sm btn-info">Edit</button> --}}
                        {{-- <a href="{{$usr->id_user}}/#ComfirmDeleteUserModal" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ComfirmDeleteUserModal{{$usr->id_user}}">Delete</a> --}}
                        <a href="" data-toggle="modal" data-target="#showlog" class="btn btn-sm btn-warning">Show</a>
                    </td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
        </div>
    </div>
</div>

{{-- @foreach($users as $usr) --}}
<div class="modal fade" id="showlog" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail a Log</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body m-2">
            <div class="card">
              <div class="card-header">
                <h5 id="titlecard"></h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col"> Name Log : </div>
                  <div class="col"> <p id="l-name"></p> </div>
                </div>
                <div class="row">
                  <div class="col"> Action : </div>
                  <div class="col"> <p id="l-action"></p> </div>
                </div>
                <div class="row">
                  <div class="col"> Description : </div>
                  <div class="col"> <p id="l-description"></p></div>
                </div>
                <div class="row">
                  <div class="col"> Role :</div>
                  <div class="col"> <p id="l-role"></p></div>
                </div>
                <div class="row">
                   <div class="col"> Log Time :  </div>
                   <div class="col"> <p id="l-time"></p></div>
                </div>
                <div class="row">
                  <div class="col"> Data Old :</div>
                  <div class="col"> <p id="l-data-old"></p></div>
                </div>
                <div class="row">
                  <div class="col"> Data New :</div>
                  <div class="col"> <p id="l-data-new"></p> </div>
                </div>

                <div class="row">
                    <div class="col"> Created at :</div>
                    <div class="col"> <p id="l-create"></p></div>
                </div>
              </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
{{-- @endforeach --}}

@endsection()

@section('scripts')
<script>
    $(document).ready(function(){
        // let msg_email_valid =  document.getElementById('msg-email').textContent;
        // let msg_phone_valid = document.getElementById('msg-phone').textContent;

        // let btn_set = document.getElementById('button-submit');
        // if(msg_email_valid == 'valid' && msg_phone_valid == 'valid'){
        //     btn_set.disabled = false;
        // }
    });

    function fetchLogDetail(id)
    {
        $.ajax({
            type: 'GET',
            url: '/logs/'+id,
            processdata: false,
            success:function(data){
                console.log(data);
            }
        });
    }
</script>
@endsection
