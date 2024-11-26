@extends('admin.master')

@section('title', 'Cấu Hình')

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="card table-responsive p-3">
                <h3 class="m-3 text-uppercase text-center">Danh Sách Cấu Hình</h3>
                <div class="text-end">
                    <a href="{{ route('admin.configs.create') }}" class="btn btn-primary btn-sm">Tạo mới</a>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Dữ liệu</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($configs ?? [] as $config)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <th scope="row">{{ $config->name }}</th>
                                <th scope="row">
                                    @php
                                        $data = json_decode($config->data, true);
                                    @endphp
                                    @if (is_array($data))
                                        @foreach ($data as $key => $value)
                                            <strong>{{ $key }}:</strong> {{ $value }}<br />
                                        @endforeach
                                    @else
                                        {{ $config->data }}
                                    @endif
                                </th>
                                <td>
                                    <a href="{{ route('admin.configs.edit', $config->id) }}"
                                        class="btn btn-outline-success btn-sm">
                                        <i class='bx bxs-edit'></i>
                                    </a>
                                    <form action="/admin/configs/{{ $config->id }}" method="POST"
                                        class="form-check-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Bạn muốn xóa cấu hình này?');"
                                            class="btn btn-outline-danger btn-sm">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
