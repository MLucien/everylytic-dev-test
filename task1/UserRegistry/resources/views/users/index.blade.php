@extends('layouts.app')

@section('content')
<div class="banner">
  <h1 style="text-align: center;">User Listing</h1>
</div>
<div class="container">
  @if ($users->isEmpty())
    <p>No users found.</p>
  @else
      <div class="ml-auto text-right">
      <h2></h2>
      <button type="button" class="btn btn-black add-user-btn" data-toggle="modal" data-target="#addUserModal">Add New User</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Surname</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->surname }}</td>
            <td>{{ $user->email }}</td>
            <td>
              <button type="button" class="btn btn-warning edit-btn" data-toggle="modal" data-target="#editModal{{ $user->id }}">Edit</button>
              <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $user->id }}">
                <i class="bi bi-trash"></i> Delete
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

<!-- Delete Modal -->
@foreach ($users as $user)
    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-black">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!-- End Delete Modal -->

<!-- Edit Modal -->
@foreach ($users as $user)
    @include('users.edit', ['user' => $user])
@endforeach
<!-- End Edit Modal -->

<!-- Add User Modal -->
@include('users.add')
<!-- End Add User Modal -->

<!-- Add footer -->
<footer class="footer" style="background-color: black;">
  <div class="container text-center">
    <!-- Footer content -->
    <p>© 2023 User Listing App. All rights reserved.</p>
  </div>
</footer>


@endsection
