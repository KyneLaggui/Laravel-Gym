@extends('layout')
@section('content')
    <main class="container">
        <section>
            <form method="put" action="{{ route('updateEquipments.put', $equipmentsEdit->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
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
                            <input type="text" id="form12" class="form-control" name="name" value="{{ $equipmentsEdit->name }}" />
                            <label class="form-label" for="form12">Name</label>
                        </div>
                        <div class="form-outline mb-3">
                            <textarea class="form-control" id="textAreaExample" rows="4" name="description" value="{{ $equipmentsEdit->description }}">{{ $equipmentsEdit->description }}</textarea>
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
                    <input type="hidden" name="hidden_id" value="{{ $equipmentsEdit->id }}" />
                    <button class="btn btn-primary">Save changes</button>
                </div>
            </form>
            {{-- <form method="PUT" action="{{ route('updateEquipments.put', $equipmentsEdit->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="titlebar">
                    <h1>Edit Product</h1>
                    <button>Save</button>
                </div>
                @if ($errors->any)
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                <div>
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $equipmentsEdit->name }}">
                        <label>Description (optional)</label>
                        <textarea cols="10" rows="5" name="description" value="{{ $equipmentsEdit->description }}">{{ $equipmentsEdit->description }}</textarea>
                        <label>Add Image</label>
                        <img src="{{ asset('imagesEquipments/'.$equipmentsEdit->image) }}" alt="" class="img-product" id="file-preview"/>
                        <input type="hidden" name="hidden_equipments_image" value= {{ $equipmentsEdit->image }} />
                        <input type="file" name= "image" accept="image/*" onchange="showFile(event)">
                    </div>
                <div>
                        <label>Category</label> 
                        <select  name="category" >
                            @foreach(json_decode('{"Legs":"Legs", "Chest":"Chest", "Arms": "Arms", "Back": "Back"}', true) as $optionKey => $optionValue)
                                <option value="{{ $optionKey }}" {{ (isset($equipmentsEdit->category) && $equipmentsEdit->category == $optionKey) ? 'selected': '' }}>{{ $optionValue}}</option>
                            @endforeach
                            
                        </select>
                        <hr>
                        
                </div>
                </div>
                <div class="titlebar">
                    <h1></h1>
                    <input type="hidden" name="hidden_id" value="{{ $equipmentsEdit->id }}" />
                    
                </div>
            </form> --}}
        </section>
    </main> 
    <script>
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
    </script>
@endsection
