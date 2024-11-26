@extends('admin.master')

@section('title', 'Sửa Khóa Học')

@section('main')
    <div class="row">
        <div class="col-md-12 p-3 card">
            <div class="text-start m-2">

                <a href="{{ route('admin.courses.index') }}" class="d-flex align-items-center">
                    <i class='bx bx-chevron-left'></i>
                    <span>Trở về</span>
                </a>
            </div>
            <h3 class="m-3 text-uppercase text-center">Sửa Khóa Học</h3>
            <div class="col-md-12 m-3 d-flex justify-content-center">
                <form method="POST" action="/admin/courses/{{ $course['id'] }}" class="col-md-3"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-floating mb-4">
                        <input type="text" id="name" name="name" placeholder=""
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') ?? $course['name'] }}" />
                        <label for="name">Tên khóa học</label>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" id="lecturer" name="lecturer" placeholder=""
                            class="form-control @error('lecturer') is-invalid @enderror"
                            value="{{ old('lecturer') ?? $course['lecturer'] }}" />
                        <label for="lecturer">Giảng viên</label>
                        @error('lecturer')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Hình ảnh</label>
                        <input class="form-control" type="file" id="thumbnail" name="thumbnail"
                            onchange="previewImage(event)">
                        @error('thumbnail')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <img id="preview" src="{{ $course['thumbnail'] }}" alt="Preview"
                            style="max-width: 100%; max-height: 200px; display: none;">
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" id="fake_cost" name="fake_cost" placeholder=""
                            class="form-control @error('fake_cost') is-invalid @enderror"
                            value="{{ old('fake_cost') ?? $course['fake_cost'] }}" />
                        <label for="fake_cost">Giá gốc</label>
                        @error('fake_cost')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" id="cost" name="cost" placeholder=""
                            class="form-control @error('cost') is-invalid @enderror"
                            value="{{ old('cost') ?? $course['cost'] }}" />
                        <label for="cost">Giá giảm</label>
                        @error('cost')
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
@section('scripts')
    <script>
        function previewImage(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('preview').style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection
