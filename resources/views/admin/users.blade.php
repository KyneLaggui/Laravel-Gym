@extends('layout') 

@section('content')
<div class="d-flex justify-content-around flex-column align-items-center mb-3  mt-3 ">
    <div class="titlebar">
        <h1>Users</h1>
        
    </div>
    <form method="GET" action="{{ route('usersList') }}" accept-charset="UTF-8" role="searchUser" class="d-flex justify-content-center">
        <div class="input-group w-100 p-3 ">
            <div class="form-outline">
                <input id="search-input" type="search" name="searchUser" name="searchUser" class="form-control" value="{{ request('searchUser') }}" />
                <label class="form-label" for="search-input">Search</label>
            </div>
            <button id="search-button" class="btn btn-primary searchUser-select" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
    <div class="d-flex justify-content-center w-75">
        <table class="table">
            <thead class="bg-primary">
                <tr>
                    <th class=" text-white">#</th>
                    <th class=" text-white">Name</th>
                    <th class=" text-white">Email</th>
                    <th class=" text-white">Level</th>
                    <th class=" text-white">Actions</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->level }}</td>
                        <td>
                            <div class="d-flex flex-row justify-content-flex-start">
                                <form method="post" action="{{ route('updateUserLevel', ['id' => $user->id]) }}">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="level" value="">
                                    <button class="btn btn-success m-1" onclick="editUser(event)">Edit</button>
                                        
                                    
                                    
                                    {{-- <select name="level">
                                        <option value="1" {{ $user->level == 1 ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ $user->level == 2 ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ $user->level == 3 ? 'selected' : '' }}>3</option>
                                    </select>
                                    <button type="submit">Update</button> --}}
                                </form>
                                <form method='post' action="{{ route('deleteUser', [$users[$index]->id]) }}">
                                    <button class="btn btn-danger m-1" onclick="deleteConfirm(event)">Delete
                                        @method('delete')
                                        @csrf
                                    </button>
                                </form>
                            </div>
                        </td>
                        <!-- Add more columns as needed -->
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>  
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
            'Equipments are Safe :)',
            'error'
            )
        }
        })
    }

    window.editUser = async function (e) {
        e.preventDefault();
        const form = e.target.form;

        const { value: level } = await Swal.fire({
            title: 'Select user level',
            input: 'select',
            inputOptions: {
                '1': 'Level 1',
                '2': 'Level 2',
                '3': 'Level 3',
            },
            inputPlaceholder: 'Select a Level',
            showCancelButton: true,
        });

        if (level) {
            // You can submit the form with the selected level value
            form.level.value = level; // Assuming your select input's name is "level"
            form.submit();
        }
    }
    
    </script>
@endsection