@extends('template/maindashboard')

@section('title','Borrowed Book')

@section('container')
<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'Borrowed Book', 'is_active' => true]),
                'title' => 'Borrow Books'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3> Borrowed Book</h3>
            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
             @endif
            <div class="card mb-2">
                <div class="card-body">
                  <form action="/borrowedbook" method="POST">
                  @csrf
                    <div class="form-row">
                        <div class="col">
                                <div class="form-group row ml-1">
                                    <div class="col-md-3">
                                        <label for="name">Code Borrowed </label>
                                    </div>
                                    <div class="col-md-6">
                                    <input type="text" class="form-control" name="code_borrow" id="code_borrow" value="{{$set_value}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row ml-1">
                                  <div class="col-md-3">
                                        <label for="name">Select User </label>
                                  </div>
                                   <div class="col-md-6">
                                       <a href="" class="btn btn-info" data-toggle="modal" data-target="#SelectUserModal">Select</a>
                                    </div>
                                </div>
                                <div class="form-group row ml-1">
                                    <div class="col-md-3">
                                        <label for="iduser">Id User </label>
                                    </div>
                                     <div class="col-md-6">
                                        <input type="text" class="form-control @error('id_user') is-invalid @enderror" id="id_user" name="id_user">
                                    @error('id_user')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                    </div>
                                </div>
                                <div class="form-group row ml-1">
                                    <div class="col-md-3">
                                        <label for="name">Name </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                     @error('name')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                    </div>
                               </div>
                               <div class="form-group row ml-1">
                                   <div class="col-md-3">
                                    <label for="phone number">Phone Number </label>
                                   </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                    </div>
                               </div>
                               <div class="form-group row ml-1">
                                   <div class="col-md-3">
                                        <label for="role">Role </label>
                                   </div>
                                     <div class="col-md-6">
                                         <input type="text" class="form-control @error('role') is-invalid @enderror" id="role" name="role" readonly>
                                     @error('role')
                                        <div class="invalid-feedback">{{$message}}</div>
                                     @enderror
                                     </div>
                                </div>
                                <div class="form-group row ml-1">
                                    <div class="col-md-3">
                                        <label for="date">Time Book Borrow </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control @error('time_borrow') is-invalid @enderror" id="time_borrow" name="time_borrow">
                                    @error('time_borrow')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                    </div>
                                </div>
                                <div class="form-group row ml-1">
                                    <div class="col-md-3">
                                        <label for="date">Time Book Return </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control @error('time_return') is-invalid @enderror" id="time_return" name="time_return">
                                    @error('time_return')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                    </div>
                                </div>
                        </div>
                        <div class="col">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="name">Select Book </label>
                                </div>
                                <div class="col-md-6">
                                        <a href="" class="btn btn-info" data-toggle="modal" data-target="#SelectBookModal">Select</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="idbook">Id Book </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="id_book" name="id_book">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="namebook">Name Book </label>
                                </div>
                                <div class="col-md-6">
                                     <input type="text" class="form-control" id="name_book" name="name_book">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="publisher">Publisher </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="publisher" name="publisher">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="pages">Book Pages</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control " id="pages_book" name="pages_book">
                                </div>
                            </div>

                            <div class="form-group row">
                                <a href="#" id="insertbooksementara" class="btn btn-info">Insert a Table</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Code Borrowed</th>
                                    <th scope="col">Id Book</th>
                                    <th scope="col">Name Book</th>
                                    <th scope="col">Act</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyborrowedbook">

                            </tbody>
                        </table>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        @error('code_borrowed')
                        <div class="alert alert-danger my-2" role="alert">Please select book first</div>
                        @enderror
                        </div>
                    </div>
                  </form>
                </div>
              </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="SelectUserModal" tabindex="-1">
   <div class="modal-dialog modal-xl">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Select User</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
        <table class="table" id="selectuser" >
            <thead>
              <tr>
                <th scope="col">Id User</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Role</th>
                <th scope="col">Act</th>
              </tr>
            </thead>
            <tbody>
                @foreach($user as $usr)
                @if($usr->role == 2)
              <tr>
                <th scope="row">{{$usr->id_user}}</th>
                <td>{{$usr->name}}</td>
                <td>{{$usr->email}}</td>
                <td>{{$usr->phone_number}}</td>
                <td>{{($usr->role == 1 || $usr->role == "1") ? 'Admin' : 'Client' }}</td>
                <td>
                    <button id="pilihuser" class="btn btn-success"
                    data-idusrm="{{$usr->id_user}}"
                    data-nmusrm="{{$usr->name}}"
                    data-phn_nmbrm="{{$usr->phone_number}}"
                    data-rolem="{{$usr->role}}">Select</button>
                </td>
              </tr>
              @endif
              @endforeach
            </tbody>
            <tfoot>
                    <tr>
                       <th scope="col">Id User</th>
                       <th scope="col">Name</th>
                       <th scope="col">Email</th>
                       <th scope="col">Phone Number</th>
                       <th scope="col">Role</th>
                       <th scope="col">Act</th>
                    </tr>
            </tfoot>
          </table>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       </div>
     </div>
   </div>
</div>

<div class="modal fade" id="SelectBookModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Book</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <table class="table" id="selectbook">
           <thead>
             <tr>
               <th scope="col">Id Book</th>
               <th scope="col">Book Name</th>
               <th scope="col">Author</th>
               <th scope="col">Publisher</th>
               <th scope="col">Time Release</th>
               <th scope="col">Book Pages</th>
               <th scope="col">Act</th>
             </tr>
           </thead>
           <tbody>
               @foreach($book as $bk)
             <tr>
               <th scope="row">{{$bk->id_book}}</th>
               <td>{{$bk->name_book}}</td>
               <td>{{$bk->author}}</td>
               <td>{{$bk->publisher}}</td>
               <td>{{$bk->time_release}}</td>
               <td>{{$bk->pages_book}}</td>
               <td>
                    <button id="pilihbuku" class="btn btn-success"
                    data-idbkm="{{$bk->id_book}}"
                    data-nmbkm="{{$bk->name_book}}"
                    data-publism="{{$bk->publisher}}"
                    data-tmrlsm="{{$bk->time_release}}"
                    data-pgsbkm="{{$bk->pages_book}}">Select</button>
               </td>
             </tr>
             @endforeach
           </tbody>
           <tfoot>
                <tr>
                   <th scope="col">Id Book</th>
                   <th scope="col">Book Name</th>
                   <th scope="col">Author</th>
                   <th scope="col">Publisher</th>
                   <th scope="col">Time Release</th>
                   <th scope="col">Book Pages</th>
                   <th scope="col">Act</th>
                </tr>
            </tfoot>
         </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="warningborrowbook" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Please complete data a book
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
</div>




<script type="text/javascript">
$(document).ready(function() {
    $(document).on('click', '#insertbooksementara', function() {
        if ($('#id_book').val() == '' || $('#name_book').val() == '' || $('#publisher').val() == '' || $('#pages_book').val() == '') {
                    $('#warningborrowbook').modal('show');
        }else{
            var id_book = document.getElementById('id_book').value;
            var nm_book = document.getElementById('name_book').value;
            var codeborrow = document.getElementById('code_borrow').value;
            var deleterow = '<a href="" id="deleterowborrowbook" class="btn btn-danger btn-sm ml-1" data-toggle="modal" data-target="#">Delete</a>';

            var newrow = '<tr> ';
            newrow += '<td> <input type="text" class="form-control" style="border-style: hidden; background-color: white; " id="codeborrowed" name="code_borrowed[]" value="' + codeborrow + '" readonly> </td>';
            newrow += '<td> <input type="text" class="form-control" style="border-style: hidden; background-color: white; " id="idbook" name="id_book[]" value="' + id_book + '" readonly> </td>';
            newrow += '<td> <input type="text" class="form-control" style="border-style: hidden; background-color: white; " id="namebook" name="name_book[]" value="' + nm_book + '" readonly> </td>';
            newrow += '<td> ' + deleterow + ' </td>';
            newrow += '</tr>';
            $('#tbodyborrowedbook').append(newrow);

            $('#id_book').val('');
            $('#name_book').val('');
            $('#publisher').val('');
            $('#pages_book').val('');
            
        }
    });

    $(document).on('click', '#deleterowborrowbook', function() {
        $(this).closest("tr").remove();
    });
});
</script>

@endsection()
