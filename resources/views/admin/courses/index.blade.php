@extends('admin.master')

@section('title', 'Khóa Học')
@section('styles')
    <style>
        .pagination .page-item .page-link {
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .pagination .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
@endsection
@section('main')
    @php
        use App\Helpers\NumberFormat;
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card table-responsive text-center p-3">
                <h3 class="m-3 text-uppercase">Danh Sách Khóa Học</h3>
                <div class="text-end">
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">Tạo mới</a>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên khóa học</th>
                            <th scope="col">Hình</th>
                            <th scope="col">Giảng viên</th>
                            <th scope="col">Giá gốc</th>
                            <th scope="col">Giá giảm</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses['data'] ?? [] as $course)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <th scope="row">{{ $course['name'] }}</th>
                                <th scope="row">
                                    <img src="{{ $course['thumbnail'] }}" alt="{{ $course['name'] }}" height="120px"
                                        class="rounded">
                                </th>
                                <th scope="row">{{ $course['lecturer'] }}</th>
                                <th scope="row">{{ NumberFormat::VND($course['fake_cost']) }}</th>
                                <th scope="row">{{ NumberFormat::VND($course['cost']) }}</th>
                                <td>
                                    <a href="{{ route('admin.courses.edit', $course['id']) }}"
                                        class="btn btn-outline-success btn-sm">
                                        <i class='bx bxs-edit'></i>
                                    </a>
                                    <form action="/admin/courses/{{ $course['id'] }}" method="POST"
                                        class="form-check-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Bạn muốn xóa khóa học này?');"
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

                @if (isset($courses['links']))
                    <div class="d-flex justify-content-center">
                        <nav>
                            <ul class="pagination">
                                @foreach ($courses['links'] as $link)
                                    @if ($link['url'])
                                        <li class="page-item {{ $link['active'] ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ url()->current() }}?{{ parse_url($link['url'], PHP_URL_QUERY) }}">{!! $link['label'] !!}</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled" aria-disabled="true">
                                            <span class="page-link">{!! $link['label'] !!}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
