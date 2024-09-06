@extends('template/maindashboard')

@section('title','Show Categories')
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

    .mini-img-cover{
        max-width: 100px;
        width: 100%;
        max-height: 100px;
        height: 100%;
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
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'Category', 'is_active' => true]),
                'title' => 'All Categories'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            <h3> All Categories</h3>
            <?php
            $cekrole = auth()->user()->role
            ?>
            <div class="row mb-4">
                <div class="col col-lg-6">
                    <a href="{{route('category.create')}}" class="btn btn-primary my-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                      </svg> Insert a new categories</a>
                </div>
                <div class="col col-lg-6 pt-1">
                    <div class="card card-total">
                        <h5>Total Categories {{ $countCategories ?? 0 }}</h5>
                    </div>
                </div>
            </div>

      

             <div id="aler-success" class="alert alert-success my-3" role="alert" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <table class="table table-bordered border-1 mb-2" id="tableCategory">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Category Name</th>
                    
                    <th scope="col" style="text-align: center">Act</th>
                    
                  </tr>
                </thead>
                <tbody id="row-table-category">
                    @foreach($categories as $ct)
                  <tr>
                    <th scope="row">{{$ct->id ?? ''}}</th>
                    
                    <td>{{$ct->name ?? ''}}</td>                    
                   
                    <td>                        
                        <a onclick="fetchEdit({{ $ct->id }})" data-toggle="modal" data-target="#editcategories" class="btn btn-sm btn-info"> <i class="fas fa-edit"></i> </a>
                        <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ComfirmDeleteModalCtgry"> <i class="far fa-trash-alt"></i> </a>
                    </td>
                   
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>

 <!-- Modal -->

 <div class="modal fade" id="ComfirmDeleteModalCtgry" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('category/delete')}}" method="POST">
                @csrf
                {{-- @method('delete') --}}
                    <div class="form group">
                        <input type="hidden" name="category_id" id="del-categoryid">
                    </div>
                    <div class="form-group">
                            <label for="pages">Are you sure delete? Please Type "Delete" or "delete" </label>
                            <input type="text" class="form-control" id="validation" name="validation" placeholder="Type here">
                    </div>
                    <button type="submit" class="btn btn-primary">Confirm</button>
            </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="editcategory" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit a category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body m-2">
            <form action="" id="form-edt" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                {{-- @method('delete') --}}
                {{-- <div class="form-group">
                            <label for="pages">Are you sure delete? Please Type "Delete" or "delete" </label>
                            <input type="text" class="form-control" id="validation" name="validation" placeholder="Type here">
                </div> --}}
                <input type="hidden" id="id-category" value="">

                <div class="form-group">
                    <label for="name">Name</label> <span style="color: red;">*</span>
                    <input type="text" class="form-control" id="name-category" name="name_category" value="" required>
                </div>              
                
                <button type="submit" id="btn-edtcategory" class="btn btn-primary">Confirm</button>
            </form>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>


@endsection()

@section('scripts')
<script>
    function getEdtCategory(id, nm){
        const category_id = id;
        const category_name = nm;

        console.log(category_id, category_name);
        document.getElementById('id-category').value = category_id;
        document.getElementById('name-category').value = category_name;

    }

    function fetchEdit(id)
    {
        $.ajax({
            type: 'GET',
            url: '/category/'+id,
            processdata: false,
            // type: 'JSON',
            success:function(data){
                console.log(data);
                document.getElementById('id-category').value = data.id;
            }
        });
    }

    function editApi(id, category_name){
            $.ajax({
                type: 'PUT',
                enctype: 'multipart/form-data',
                // url : '{{ url("/category/update/'+category_id+'") }}',
                url: '/category/update/'+id ,
                headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data : {
                    id: id,
                    name: category_name,
                },
                success: function(data){
                alert("okay");
                console.log(data);
                },
                error: function(){
                    alert("failure From php side!!! ");
                }
            });
    }

    $("#btn-edtcategory").click(function(e) {
        e.preventDefault();

        let category_id = $('#id-category').val();
        let category_name = $('#name-category').val();

        // console.log(replace_name_img);
        $.ajax({
                // method: 'PUT',
                type: 'POST',
                enctype: 'multipart/form-data',
                // url : "{{ route('category.update', "category_id") }}",
                url: '/category/update/'+category_id ,
                headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
                },
                dataType: 'json',
                processData: false,
                contentType: false,
                data : {
                    id: category_id,
                    name: category_name,
                },
                success: function(data){
                //   console.log(data.data);
                  $('#editcategory').modal('hide');

                    $("#aler-success").css("display", "block");
                    // $("#aler-success").append("<p>Success</p>");
                    $("#aler-success").append(data.data);
                    fetchcategory();
                }
            });

        $.ajax();
    });

    function fetchcategory(){
        $.ajax({
            type: 'GET',
            url: '{{ route('category.fetch-index') }}',
            processdata: false,
            success:function(data){
                // console.log(data);
                $('#row-table-category').html(data.html);
            }
        });
    }

</script>
@endsection
