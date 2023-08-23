@extends('layout') 

@section('content')
    <form method="put" action="{{ route('updateUserLevel', ['id' => $users->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
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
                    <input type="text" id="form12" class="form-control" name="name" value="{{ $users->name }}" />
                    <label class="form-label" for="form12">Name</label>
                </div>
                <div class="form-outline mb-3">
                    <textarea class="form-control" id="textAreaExample" rows="4" name="description" value="{{ $users->email }}">{{ $users->email }}</textarea>
                    <label class="form-label" for="textAreaExample" >Description</label>
                </div>
                <select name="level">
                    <option value="1" {{ $users->level == 1 ? 'selected' : '' }}>1</option>
                    <option value="2" {{ $users->level == 2 ? 'selected' : '' }}>2</option>
                    <option value="3" {{ $users->level == 3 ? 'selected' : '' }}>3</option>
                </select>
            </div>
            
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
            <input type="hidden" name="hidden_id" value="{{ $users->id }}" />
            <button class="btn btn-primary">Save changes</button>
        </div>
    </form>
@endsection