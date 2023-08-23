@extends('layout')
@section('content')
    <main class="container">
        <section>
            <form method="PUT" action="{{ route('updateEquipments.put', $equipmentsEdit->id)}}" enctype="multipart/form-data">
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
            </form>
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
