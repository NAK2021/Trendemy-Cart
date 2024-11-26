@extends('admin.master')

@section('title', 'Trang Chủ')
@php
    use App\Helpers\NumberFormat;
    use App\Enums\CouponType;
@endphp
@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="card table-responsive text-center p-3">
                <h3 class="m-3 text-uppercase">Danh Sách Mã Giảm Giá</h3>
                <div class="text-end">
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm">Tạo mới</a>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Giá trị</th>
                            <th scope="col">Kiểu</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Tối thiểu</th>
                            <th scope="col">Tối đa</th>
                            <th scope="col">Giới hạn</th>
                            <th scope="col">Đã sử dụng</th>
                            <th scope="col">Ngày bắt đầu</th>
                            <th scope="col">Ngày hêt hạn</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coupons ?? [] as $coupon)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $coupon->code }}</td>
                                @if ($coupon->type === CouponType::FIXED)
                                    <td>{{ NumberFormat::VND($coupon->value) }}</td>
                                @elseif ($coupon->type === CouponType::PERCENT)
                                    <td>{{ $coupon->value }}%</td>
                                @endif
                                <td>{{ $coupon->type }}</td>
                                <td>{{ $coupon->description }}</td>
                                <td>{{ NumberFormat::VND($coupon->min_amount) }}</td>
                                <td>{{ NumberFormat::VND($coupon->max_amount) }}</td>
                                <td>{{ $coupon->usage_limit }}</td>
                                <td>{{ $coupon->usage_count }}</td>
                                <td>{{ $coupon->start_date }}</td>
                                <td>{{ $coupon->expiry_date }}</td>
                                <td>
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                        class="btn btn-outline-success btn-sm">
                                        <i class='bx bxs-edit'></i>
                                    </a>
                                    <form action="/admin/coupons/{{ $coupon->id }}" method="POST"
                                        class="form-check-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Bạn muốn xóa mã ưu đãi này?');"
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
                <div class="d-flex justify-content-center">{{ $coupons->links('pagination::bootstrap-4') }}</div>
            </div>
        </div>
    </div>
@endsection
