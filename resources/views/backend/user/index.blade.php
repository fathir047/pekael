@extends('layouts.backend')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data User</h4>
            <div>
                <a href="{{ route('backend.user.create') }}" class="btn btn-sm btn-light text-primary fw-semibold me-2">
                    Tambah Data
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Pesan -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <!-- Import Excel -->
            <div class="mb-3">
                <form action="{{ route('backend.users.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                    @csrf
                    <input type="file" name="file" class="form-control me-2" required>
                    <button type="submit" class="btn btn-primary">Import</button>
                </form>
            </div>

            <!-- SEARCH CUSTOM -->
            <div class="mb-3 d-flex justify-content-end">
                <div class="input-group w-25">
                    <span class="input-group-text">
                        <i class="ti ti-search"></i>
                    </span>
                    <input type="text" id="searchUser" class="form-control" placeholder="Search user...">
                </div>
            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" id="userTable">
                    <thead class="table-head">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->is_admin ? 'Admin' : 'User' }}</td>
                            <td class="text-center">
                                <a href="{{ route('backend.user.edit', $u) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="ti ti-pencil"></i>
                                </a>

                                @if (!($u->is_admin == 1 && $loop->first))
                                <form action="{{ route('backend.user.destroy', $u) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user?')">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

<script>
    $(document).ready(function () {

        // INIT DATATABLE TANPA SEARCH DEFAULT
        let table = $('#userTable').DataTable({
            dom: 't<"d-flex justify-content-between mt-2"ip>'
        });

        // SEARCH CUSTOM
        $('#searchUser').on('keyup', function () {
            table.search(this.value).draw();
        });

    });
</script>
@endpush
