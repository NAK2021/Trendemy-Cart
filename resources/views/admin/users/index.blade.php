@extends('admin.master')

@section('title', 'Người Dùng')

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="card table-responsive text-center p-3">
                <h3 class="text-uppercase fw-bold m-3">Danh Sách Người Dùng</h3>
                <div class="text-end">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">Tạo mới</a>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users ?? [] as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role == 'ADMIN')
                                        <span class="badge bg-primary">{{ $user->role }}</span>
                                    @elseif ($user->role == 'USER')
                                        <span class="badge bg-secondary">{{ $user->role }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-outline-success btn-sm">
                                        <i class='bx bxs-edit'></i>
                                    </a>
                                    <form action="/admin/users/{{ $user->id }}" method="POST"
                                        class="form-check-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Bạn muốn xóa người dùng này?');"
                                            class="btn btn-outline-danger btn-sm">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12">KHÔNG CÓ DỮ LIỆU</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">{{ $users->links('pagination::bootstrap-4') }}</div>
            </div>
        </div>
    </div>
@endsection
