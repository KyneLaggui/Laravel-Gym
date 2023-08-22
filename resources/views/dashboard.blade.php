@extends('layout')
@section('content')
<main class="container">
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
                
                {{-- {{ $equipments->links('pagination') }} --}}
                
            </div>
        </div>
    </section>
</main>
<script>
    window.deleteConfirm = function (e)
    {
        e.preventDefault();
        var form = e.target.form;
        //Lagyan pop up
    }
</script>
@endsection
