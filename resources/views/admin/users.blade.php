@extends('layout') 

@section('content')
    <div class="titlebar">
        <h1>Users</h1>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Level</th>
                <th>Actions</th>
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
                    </td>
                    <!-- Add more columns as needed -->
                    
                </tr>
            @endforeach
        </tbody>
    </table>
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