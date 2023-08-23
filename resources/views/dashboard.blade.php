@extends('layout')
@section('content')

<div class="titlebar ">
    <div class="d-flex justify-content-around align-items-center mb-3  mt-3">
        <div>
            <h1>Equipments</h1>
        </div>
        <div>
            @if (Auth::user()->level == 1 || Auth::user()->level == 10)
                <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal"
                data-mdb-ripple-color="dark">Add Product</button>
            @endif
        </div>
        
    </div>
    <form method="GET" action="{{ route('dashboard') }}" accept-charset="UTF-8" role="search" class="d-flex justify-content-center">
        <div class="input-group w-50 p-3 ">
            <div class="form-outline">
              <input id="search-input" type="search" id="form1" class="form-control name="search"  name="search" value="{{ request('search') }}"/>
              <label class="form-label" for="form1">Search</label>
            </div>
            <button id="search-button"  class="btn btn-primary search-select">
              <i class="fas fa-search"></i>
            </button>
            
        </div>
          
    </form>
    @if ($message = Session::get('success'))
    <div class="d-flex justify-content-center">
        <ul>
            <li>{{ $message }}</li>
        </ul>
        </div>
    @endif

</div>

<div class="d-flex justify-content-center">
    <table class="table align-middle mb-0 bg-white w-75 p-3  ">
        
        <thead class="bg-primary">
    
            <tr>
                <th class=" text-white">#</th>
                <th class=" text-white">Name</th>
                <th class=" text-white">Category</th>
                <th class=" text-white">Description</th>
                <th class=" text-white">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (count($equipments) > 0)
                
                @foreach ($equipments as $index => $equipment)
                
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                            <p class="fw-bold mb-1">{{$equipments[$index]->name}}</p>
                        
                            </div>
                        </div>
                        </td>
                        <td>
                        <p class="fw-normal mb-1">{{$equipments[$index]->category}}</p>
                        
                        </td>
                        <td>{{$equipments[$index]->description}}</td>
                        <td>
                        <div class="d-flex flex-row justify-content-flex-start">
                            @if (Auth::user()->level == 1 || Auth::user()->level == 2 || Auth::user()->level == 10)
                                        <a href="{{ route('editEquipments', [$equipments[$index]->id]) }}">
                                            <button class="btn btn-success m-1">Edit</button>
                                        </a>
                            @endif
                            @if (Auth::user()->level == 1 || Auth::user()->level == 10)
                                <form method='post' action="{{ route('deleteEquipments', [$equipments[$index]->id]) }}">
                                    <button class="btn btn-danger m-1" onclick="deleteConfirm(event)">Delete
                                        @method('delete')
                                        @csrf
                                    </button>
                                </form>
                            @endif
                            
                            
                        </div>
                    
                        </td>
                    </tr>
                @endforeach   
                
            @else
                <p>No Equipments found.</p>
            @endif
        
        </tbody>
    </table>
</div>
  <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('storeProducts.post')}}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title">Add Product</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any)
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <div class="form-outline mb-3">
                        <input type="text" id="form12" class="form-control" name="name" />
                        <label class="form-label" for="form12">Name</label>
                    </div>
                    <div class="form-outline mb-3">
                        <textarea class="form-control" id="textAreaExample" rows="4" name="description"></textarea>
                        <label class="form-label" for="textAreaExample" >Description</label>
                    </div>
                    <select class="browser-default custom-select w-100 p-1 " name="category">
                        @foreach(json_decode('{"Legs":"Legs", "Chest":"Chest", "Arms": "Arms", "Back": "Back"}', true) as $optionKey => $optionValue)
                                <option value="{{ $optionKey }}" >{{ $optionValue}}</option>
                        @endforeach
                    </select>
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                <button class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  
   
{{-- Old Table --}}
{{-- <main class="container">
    <section>
        <div class="titlebar">
            <h1>Equipments</h1>
            <a href= "{{ url('createProduct') }}" class="btn-link">Add Product</a>
        </div>
        @if ($message = Session::get('success'))
            <div>
                <ul>
                    <li>{{ $message }}</li>
                </ul>
            </div>
        @endif
        <div class="table">
            <div class="table-filter">
                <div>
                    <ul class="table-filter-list">
                        <li>
                            <p class="table-filter-link link-active">All</p>
                        </li>
                    </ul>
                </div>
            </div>
            <form method="GET" action="{{ route('dashboard') }}" accept-charset="UTF-8" role="search">
                <div class="table-search">   
                    <div>
                        <button class="search-select">
                        Search Product
                        </button>
                        <span class="search-select-arrow">
                            <i class="fas fa-caret-down"></i>
                        </span>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Search product..." name="search" value="{{ request('search') }}">
                    </div>
                </div>
            </form>
            <div class="table-product-head">
                <p>Image</p>
                <p>Name</p>
                <p>Category</p>
                <p>Description</p>
                <p>Actions</p>
            </div>
            <div class="table-product-body">
                @if (count($equipments) > 0)
                    @foreach ($equipments as $equipments)
                    <img src="{{ asset('imagesEquipments/' . $equipments->image )}}"/>
                    <p> {{$equipments->name}} </p>
                    <p>{{$equipments->category}} </p>
                    <p>{{$equipments->description}} </p>
                    <div>     
                        <a href="{{ route('editEquipments', [$equipments->id]) }}">
                            <i class="fas fa-pencil-alt" ></i> 
                        </a>
                        <form method='post' action="{{ route('deleteEquipments', [$equipments->id]) }}">
                            <button class="btn-danger button" onclick="submit" >
                                @method('delete')
                                @csrf
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                @else
                    <p>No Equipments found.</p>
                @endif
                
            </div>
            <div class="table-paginate">
                
                {{-- {{ $equipments->links('pagination') }} 
                
            </div>
        </div>
    </section>--}}
{{-- </main>  --}}

<script>
    window.deleteConfirm = function (e)
    {
        e.preventDefault();
        var form = e.target.form;
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
        }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
            swalWithBootstrapButtons.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            )
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your Equipments are safe',
            'error'
            )
        }
        })
    }

    function showFile(event){
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function()
            {
                var dataURL = reader.result;
                var output = document.getElementById('file-preview');
                output.src = dataURL;

            };
            reader.readAsDataURL(input.files[0]);
    }
    function openEditModal(id) {
        const modal = document.getElementById(`editModal${id}`);
        const mdbModal = new mdb.Modal(modal);
        mdbModal.show();
    }
</script>
@endsection
