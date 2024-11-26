@extends('admin.master')

@section('title', 'Sửa Mã')

@section('main')
    @php
        use App\Enums\CouponType;
    @endphp
    <div class="row">
        <div class="col-md-12 p-3 card">
            <div class="text-start m-2">

                <a href="{{ route('admin.coupons.index') }}" class="d-flex align-items-center">
                    <i class='bx bx-chevron-left'></i>
                    <span>Trở về</span>
                </a>
            </div>
            <h3 class="m-3 text-uppercase text-center">Sửa Mã Ưu Đãi</h3>
            <div class="col-md-12 m-3 d-flex justify-content-center">
                <form method="POST" action="/admin/coupons/{{ $coupon->id }}" class="col-md-3">
                    @csrf
                    @method('PUT')
                    <div class="form-floating mb-4">
                        <input type="text" id="code" name="code" placeholder=""
                            class="form-control @error('code') is-invalid @enderror"
                            value="{{ old('code') ?? $coupon->code }}" />
                        <label for="code">Mã ưu đãi</label>
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" id="value" name="value" placeholder=""
                            class="form-control @error('value') is-invalid @enderror"
                            value="{{ old('value') ?? $coupon->value }}" />
                        <label for="value">Giá trị</label>
                        @error('value')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <select class="form-select @error('type') is-invalid @enderror" aria-label="Default select example"
                            id="type" name="type">
                            <option selected>Chọn kiểu giảm giá</option>
                            @foreach (CouponType::getValues() as $type)
                                <option value="{{ $type }}"
                                    {{ old('type') ?? $coupon->type == $type ? 'selected' : '' }}>
                                    {{ $type == 'FIXED' ? 'Tiền tươi' : 'Phần trăm' }}
                                </option>
                            @endforeach
                        </select>
                        <label for="type">Kiểu</label>
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <textarea class="form-control @error('description') is-invalid @enderror" placeholder="" id="description"
                            name="description" style="height: 100px">{{ old('description') ?? $coupon->description }}</textarea>
                        <label for="description">Mô tả</label>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" id="usage_limit" name="usage_limit" placeholder=""
                            class="form-control @error('usage_limit') is-invalid @enderror"
                            value="{{ old('usage_limit') ?? $coupon->usage_limit }}" />
                        <label for="usage_limit">Lượt sử dụng</label>
                        @error('usage_limit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" id="min_amount" name="min_amount" placeholder=""
                            class="form-control @error('min_amount') is-invalid @enderror"
                            value="{{ old('min_amount') ?? $coupon->min_amount }}" />
                        <label for="min_amount">Giá tối thiểu</label>
                        @error('min_amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" id="max_amount" name="max_amount" placeholder=""
                            class="form-control @error('max_amount') is-invalid @enderror"
                            value="{{ old('max_amount') ?? $coupon->max_amount }}" />
                        <label for="max_amount">Giá tối đa</label>
                        @error('max_amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
