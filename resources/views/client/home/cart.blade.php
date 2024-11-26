@extends('client.main')

@section('title', 'Giỏ Hàng')

@section('styles')
    <style></style>
@endsection

@section('main')
    <div class="row" id="list-courses">
        <div>
            <button class="btn-back mt-3">
                <i class="fa-solid fa-arrow-left"></i>
                &nbsp;Quay lại
            </button>
        </div>
        <h1 class="fw-bold mt-5 mb-3">Giỏ hàng</h1>
        <div class="col-xxl-8 col-xl-12">
            <ul class="responsive-table table-cart">
                <li class="table-header">
                    <div class="col col-1 d-flex gap-2">
                        <input type="checkbox" id="checkAll" class="form-check-input select-courses m-0" />
                        <label for="checkAll"> Tất cả (<span class="count-course">0</span> khóa học) </label>
                    </div>
                    <div class="col col-4" id="btn-removes">Xóa tất cả</div>
                </li>
                <div id="body-table" class="overflow-y-auto" style="max-height: 555px"></div>
            </ul>
        </div>
        <div class="col-xxl-4 col-xl-12">
            <div class="box-coupons box-shadow bg-light p-3 rounded">
                <div class="d-flex align-items-center mb-2">
                    <img src="./assets/icons/ticket.svg" height="30px" alt="" />
                    <span class="fs-5 fw-bold ms-2">Mã khuyến mãi</span>
                </div>
                <div class="form-coupon mb-3">
                    <input type="text" id="inputCode" placeholder="Nhập mã giảm giá" />
                    <button id="btn-apply" type="btn">Áp dụng</button>
                </div>
                <div class="d-flex flex-column gap-2 overflow-y-auto pb-1" id="list-coupons" style="max-height: 270px">
                </div>
            </div>
            <div class="box-summary box-shadow bg-light p-3 mt-3 rounded">
                <div class="d-flex justify-content-between fw-medium mb-2">
                    <span>Giá niêm yết:</span>
                    <span class="base-price">0 đ</span>
                </div>
                <div class="d-flex justify-content-between fw-medium mb-2">
                    <span>Giảm giá:</span>
                    <span class="reduce-price">0 đ</span>
                </div>
                <div class="d-flex justify-content-between fw-medium mb-3">
                    <span>Tạm tính:</span>
                    <span class="sub-total">0 đ</span>
                </div>
                <div class="fw-medium" id="list-codes">
                </div>
                <hr />
                <div class="d-flex justify-content-between fw-bold">
                    <span>Tổng giá:</span>
                    <span class="total-price">0 đ</span>
                </div>
            </div>
            <div class="col-md-12">
                <button id="btn-checkout" class="btn btn-info text-white text-uppercase fw-bold my-3 w-100 py-2">
                    Tiếp Tục
                </button>
            </div>
        </div>
        @if (count($listRecommend ?? []))
            <div class="col-md-12 mt-5">
                <h3 class="fw-bold">Các khóa học phổ biến khác:</h3>
                <div class="list-recommend wrapper-carousel">
                    <i id="left" class="fa-solid fa-angle-left"></i>
                    <ul id="carousel">
                        @foreach ($listRecommend ?? [] as $course)
                            <li class="box" data-id="{{ $course['id'] }}">
                                <div class="bg-light">
                                    <img src="{{ $course['thumbnail'] }}" alt="{{ $course['name'] }}" class="w-100"
                                        height="150px" />
                                    <div class="p-3 p-xxl-2">
                                        <h5 class="fw-bold">
                                            <a href="#" class="text-decoration-none">{{ $course['name'] }}</a>
                                        </h5>
                                        <p class="mb-0">
                                            <i class="fa-regular fa-clock"></i>
                                            {{ $course['duration'] }} giờ
                                        </p>
                                        <p class="mb-0">Bởi {{ $course['lecturer'] }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <i id="right" class="fa-solid fa-angle-right"></i>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    @if (count($listRecommend ?? []))
        <script src="{{ asset('assets/js/carousel.js') }}" defer></script>
    @endif
    <script>
        var ids = new Set();
        var codes = new Set();
        var listCourses = $('#list-courses');
        var listCoupons = $('#list-coupons');
        var listCodes = $('#list-codes');
        // var tableCart = $('.table-cart');
        var bodyTable = $('#body-table');
        var btnApply = $('#btn-apply');
        var inputCode = $('#inputCode');
        var countCourse = $('.count-course');
        var inputSelectCourses = $('input.select-courses');
        var btnCheckout = $('#btn-checkout');
        var basePrice = $('.base-price');
        var subTotal = $('.sub-total');
        var reducePrice = $('.reduce-price');
        var totalPrice = $('.total-price');
        var btnRemoves = $('#btn-removes'); //remove All
        let inputSelectCourse;

        $document.ready(function() {
            loadData();
        });

        $document.on('click', '.btn-back', function() {
            window.location.href = '/';
        });

        $document.on('click', '.btn-discovery', function() {
            window.location.href = '/';
        });

        function init() {
            inputSelectCourse = $('input.select-course');

        }

        function loadData() {
            $.get('/carts', function(response, status) {
                if (status === 'success') {
                    if (response.data) {
                        let data = response.data.map(cart =>
                            boxCourse(
                                cart.id,
                                cart.thumbnail,
                                cart.name,
                                cart.lecturer,
                                cart.fake_cost,
                                cart.cost,
                                cart.duration
                            )
                        ).join('');
                        bodyTable.append(data);
                        Summary();
                        init();
                        return;
                    }
                }
                showEmptyBox();
            });
        }

        function updateCourseChecked() {
            ids.clear();
            let selected = $('input.select-course:checked');
            countCourse.text(selected.length);
            selected.each(function() {
                let id = $(this).closest('.table-row').data('id');
                ids.add(id);
            });

            if (selected.length > 0) {
                btnRemoves.addClass('text-danger');
            } else {
                btnRemoves.removeClass('text-danger');
            }
            Summary();
        }

        function updateCodeChecked() {
            codes.clear();
            let selectedCode = $('input.select-code:checked');
            selectedCode.each(function() {
                codes.add($(this).val());
            });
        }

        $document.on('click', 'input.select-code', function() {
            let code = $(this).val();
            if ($(this).is(':checked')) {
                codes.add(code);
            } else {
                codes.delete(code);
            }
            Summary();
        })

        function Summary() {
            $.get('/carts/summary', {
                ids: Array.from(ids),
                codes: Array.from(codes)
            }, function(response, status) {
                if (status === 'success' && response.success) {
                    listCoupons.empty();
                    listCodes.empty();
                    const {
                        basePrice,
                        reducePrice,
                        subTotal,
                        totalPrice,
                        codes: resCodes,
                        coupons
                    } = response.data;
                    boxSummary(basePrice, reducePrice, subTotal, totalPrice);
                    codes = new Set(Object.keys(resCodes) ?? []);
                    if (resCodes) {
                        let lstCode = '';
                        $.each(resCodes, (key, value) => {
                            lstCode += `<div class="d-flex justify-content-between fw-medium mb-2">
                                            <span>Mã ưu đãi (${key})</span>
                                            <span class="reduce-price">- ${value}</span>
                                        </div>`
                        });
                        listCodes.append(lstCode);
                    }
                    if (coupons?.data?.length) {
                        let row = '';
                        $.each(coupons.data, (index, coupon) => {
                            let isChecked = Object.keys(resCodes).includes(coupon.code);
                            row += boxCoupons(coupon.code, coupon.description, isChecked, coupons
                                .limit);
                        });
                        listCoupons.append(row);
                    }
                    if (response.message) {
                        Toast({
                            message: response.message,
                            type: response.type
                        });
                    }
                }
            });
        }

        btnApply.click(function() {
            if (inputCode.val().trim() === '') return false;
            codes.add(inputCode.val());
            Summary();
            inputCode.val('');
        })

        //function remove course
        function removeCourse(id, callback) {
            $.post('/carts/remove', {
                id
            }, function(response, status) {
                if (status === 'success') {
                    callback(response);
                }
            });
            handleCountCart();
        }

        //Remove a course
        $document.on('click', '.btn-remove', function() {
            if (confirm('Bạn có chắc chắn xóa khóa học này!')) {
                let _this = $(this).closest('.table-row');
                let id = _this.data('id');
                removeCourse(id, (response) => {
                    if (response.success) {
                        if (response.data) {
                            _this.remove();
                            updateCourseChecked();
                        } else {
                            loadData();
                        }
                        Toast({
                            type: response.type,
                            message: response.message
                        });
                    }
                });
            }
        });

        //Remove courses
        btnRemoves.click(function() {
            let selected = $('input.select-course:checked');
            if (selected.length !== 0) {
                if (confirm(`Bạn có chắc chắn xóa ${selected.length} khóa học này!`)) {
                    let completed = 0;
                    let reload = false;
                    selected.each(function() {
                        let _this = $(this).closest('.table-row');
                        let id = _this.data('id');
                        removeCourse(id, (response) => {
                            if (response.success) {
                                if (response.data) {
                                    reload = true;
                                    _this.remove();
                                } else {
                                    reload = false;
                                    loadData();
                                }
                            }
                            completed++;
                            if (completed === selected.length) {
                                if (reload) updateCourseChecked();
                                Toast({
                                    type: response.type,
                                    message: response.message
                                });
                            }
                        });
                    });
                }
            }
        });

        btnCheckout.click(function() {
            $.post('/carts/checkout', {
                ids: Array.from(ids),
                codes: Array.from(codes)
            }, function(response, status) {
                if (status === 'success') {
                    if (response.success) {
                        window.location.href = response.data.link ?? '';
                    }
                    if (response.message) {
                        Toast({
                            message: response.message,
                            type: response.type
                        });
                    }
                }
            });
        });

        //checkbox select all or cancel
        $document.on('click', 'input.select-courses', function() {
            let checked = this.checked;
            inputSelectCourse.each(function(index, item) {
                item.checked = checked;
            });
            updateCourseChecked();
        });
        //check selected items
        $document.on('click', 'input.select-course', function() {
            let selected = $('input.select-course:checked');
            inputSelectCourses[0].checked = selected.length === inputSelectCourse.length;
            updateCourseChecked();
        });

        function showEmptyBox() {
            main.empty().append(boxEmpty()).css({
                'display': 'flex',
                'justify-content': 'center',
                'align-items': 'center'
            });
        }

        //Render UI

        function boxCourse(id, thumbnail, name, author, fake_cost, cost, duration) {
            return (`<li class="table-row" data-id="${id}">
                         <div class="col col-1">
                             <input type="checkbox" class="form-check-input select-course mt-0" />
                             <img src="${thumbnail}" height="150px" alt="" />
                             <div class="info-course">
                                 <p class="fw-bold fs-5">${name}</p>
                                 <p class="text-body-tertiary">
                                     <i class="fa-regular fa-clock"></i> ${duration} giờ
                                 </p>
                                 <p class="text-body-tertiary">Bởi ${author}</p>
                             </div>
                         </div>
                         <div class="col col-2 fw-bold">
                             <p class="text-dash">${fake_cost}</p>
                             <p>${cost}</p>
                         </div>
                         <div class="col col-4">
                             <button type="button" class="btn btn-danger btn-remove">
                                 <i class="fa-solid fa-trash"></i>
                             </button>
                         </div>
                     </li>`);
        }


        function boxSummary(base, reduce, sub, total) {
            basePrice.text(base);
            reducePrice.text('- ' + reduce);
            subTotal.text(sub);
            totalPrice.text(total);
        }


        function boxCoupons(code, desc, isChecked = false, disable = false) {
            return (`<div class="d-flex justify-content-between align-items-center border p-2 rounded">
                         <div class="form-check">
                             <input class="form-check-input select-code"
                                 type="checkbox"
                                 value="${code}"
                                 id="${code}"
                                 ${isChecked? 'checked': ''}
                                 ${disable && !isChecked ? 'disabled': ''}/>
                             <label class="form-check-label w-100" for="${code}">${code}</label>
                         </div>
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="icon-info" title="${desc}">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                         </svg>
                     </div>`);
        }

        function boxEmpty() {
            return (`<div class="text-center">
                         <div>
                            <img src="./assets/icons/cart-empty.svg" alt="" />
                         </div>
                         <p>Giỏ hàng của bạn đang trống.</p>
                         <p>Hãy thêm khóa học vào giỏ hàng nhé!</p>
                         <button class="btn-discovery btn btn-info text-white">
                             Khám phá khóa học
                         </button>
                     </div>`);
        }
    </script>
@endsection
