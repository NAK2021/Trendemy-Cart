@extends('admin.master')

@section('title', 'Tạo Cấu Hình')

@section('main')
    <div class="row">
        <div class="col-md-12 p-3 card">
            <div class="text-start m-2">

                <a href="{{ route('admin.configs.index') }}" class="d-inline-flex align-items-center">
                    <i class='bx bx-chevron-left'></i>
                    <span>Trở về</span>
                </a>
            </div>
            <h3 class="m-3 text-uppercase text-center">Tạo Cấu Hình</h3>
            <div class="col-md-12 m-3 d-flex justify-content-center">
                <form method="POST" action="/admin/configs" class="col-md-3">
                    @csrf
                    <div class="form-floating mb-4">
                        <input type="text" id="name" name="name" placeholder=""
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" />
                        <label for="name">Tên cấu hình</label>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <textarea class="form-control @error('data') is-invalid @enderror" placeholder="" id="data" name="data"
                            style="height: 150px">{{ old('data') }}</textarea>
                        <label for="data">Dữ liệu</label>
                        @error('data')
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
