@extends('client.main')

@section('title', 'Trang Chủ')

@section('styles')
    <style>
    </style>
@endsection

@section('header')
    @parent
@endsection

@section('main')
    <div class="row" id="list-courses">
    </div>
@endsection

@section('scripts')
    <script>
        var listCourses = $('#list-courses');

        function loadData() {
            $.get('/courses', function(response, status) {
                if (status === 'success') {
                    listCourses.empty();
                    if (response.success) {
                        let data = response.courses;
                        if (data.length) {
                            let courses = data.map(course =>
                                card(course.id, course.name, course.fake_cost, course.cost, course.thumbnail)
                            ).join('');
                            listCourses.append(courses);
                        } else {
                            listCourses.append(`<idv class='text-center'>KHÔNG CÓ KHÓA HỌC NÀO!</div>`);
                        }
                    } else {
                        listCourses.append(`<idv class='text-center'>${response.message}</div>`);
                    }
                }
            });
        }

        function card(id, name, fake_cost, cost, thumbnail) {
            return `<div class="col-lg-3 col-md-6 mb-3 mt-3">
                        <div class="card" data-id='${id}'>
                                <img src="${thumbnail}" class="card-img-top" alt="${name}" height="150px"/>
                                <div class="card-body">
                                    <h5 class="card-title">${name}</h5>
                                    <p class="card-text d-flex flex-column">
                                        <span class='text-decoration-line-through'>${formatCurrency(fake_cost)}</span>
                                        <strong class='fs-5 text-warning'>${formatCurrency(cost)}</strong>
                                    </p>
                                    <button class="btn btn-primary" id="btn-add-cart" data-mdb-ripple-init>
                                        <img src="{{ asset('assets/images/add-button.png') }}" alt="">
                                    </button>
                                </div>
                            </div>
                        </div>`;
        }

        $document.on('click', '#btn-add-cart', function() {
            let id = $(this).closest('.card').data('id');
            $.post('/carts/add', {
                id
            }, function(response, status) {
                if (status === 'success') {
                    handleCountCart();
                }
            });
        });

        $document.ready(function() {
            loadData();
        });
    </script>
@endsection
