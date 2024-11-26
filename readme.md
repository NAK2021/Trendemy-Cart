## CÀI ĐẶT

Các bước để cài đặt và thiết lập môi trường cho dự án:

1. Clone repository:
   ```bash
   $ git clone https://github.com/.../Academy-Cart.git
   ```
2. Cài đặt các phụ thuộc:
   ```bash
   $ composer i
   ```
3. Sao chép tệp cấu hình môi trường:
   ```bash
   $ cp .env.example .env
   ```
4. Tạo khóa ứng dụng:
   ```bash
   $ php artisan key:generate
   ```

## CHỨC NĂNG: GIỎ HÀNG

### Class: CartService

#### Method: list()

**Mô tả**

Lấy danh sách các khóa học trong giỏ hàng của người dùng.

**Tham số**

Không có.

**Trả về**

- `JSON`: Đối tượng JSON chứa các thông tin sau:
  - `success` (boolean): Trạng thái của yêu cầu.
  - `type` (string): Kiểu thông báo.
  - `message` (string): Thông điệp phản hồi.
  - `data` (array): Danh sách các khóa học.

#### Method: add($courseId)

**Mô tả**

Thêm một khóa học vào giỏ hàng của người dùng.

**Tham số**

- `$courseId` (integer): ID của khóa học cần thêm vào giỏ hàng.

**Trả về**

- `JSON`: Đối tượng JSON chứa các thông tin sau:
  - `success` (boolean): Trạng thái của yêu cầu.
  - `type` (string): Kiểu thông báo.
  - `message` (string): Thông điệp phản hồi.

#### Method: summary($data)

**Mô tả**

Hàm này tính toán tổng quan về giá trị đơn hàng dựa trên các thông tin đầu vào và trả về một đối tượng JSON chứa các thông tin chi tiết về giá trị đơn hàng.

**Tham số**

- `$data` (object): Dữ liệu đầu vào, bao gồm ids và codes
  - `$data->ids` (array): Mảng các ID của các khóa học được chọn trong giỏ hàng.
  - `$data->codes` (array): Mảng các mã giảm giá được áp dụng.

**Trả về**

- `JSON`: Đối tượng JSON chứa các thông tin sau:
  - `success` (boolean): Trạng thái của yêu cầu.
  - `type` (string): Kiểu thông báo.
  - `message` (string): Thông điệp phản hồi.
  - `data` (array): chứa các thông tin giá trị của đơn hàng.
    • `basePrice` (string): Tổng giá niêm yết
    • `reducePrice` (string): Tổng giá khóa học được giảm
    • `discount` (string): Tổng giá được giảm khi áp dụng mã giảm giá
    • `totalPrice` (string): Tổng giá cuối cùng
    • `codes` (array): Danh sách mã giảm giá người dùng đã chọn
    • `coupons` (object): Danh sách mã giảm giá người dùng có thể sử dụng

#### Method: checkout($data)

**Mô tả**

Hàm này xử lý quá trình thanh toán đơn hàng dựa trên thông tin đầu vào và trả về một đối tượng JSON chứa các thông tin cần thiết.

**Tham số**

- `$data` (object): Dữ liệu đầu vào, bao gồm ids và codes
  - `$data->ids` (array): Mảng các ID của các khóa học được chọn trong giỏ hàng.
  - `$data->codes` (array): Mảng các mã giảm giá được áp dụng.

**Trả về**

- `JSON`: Đối tượng JSON chứa các thông tin sau:
  - `success` (boolean): Trạng thái của yêu cầu.
  - `type` (string): Kiểu thông báo.
  - `message` (string): Thông điệp phản hồi.
  - `data` (array): chứa route chuyển tiếp đến view thanh toán.

#### Method: remove($id)

**Mô tả**

Xóa khóa học ra khỏi giỏ hàng

**Tham số**

- `$id` (integer): ID của giỏ hàng.

**Trả về**

- `JSON`: Đối tượng JSON chứa các thông tin sau:
  - `success` (boolean): Trạng thái của yêu cầu.
  - `type` (string): Kiểu thông báo.
  - `message` (string): Thông điệp phản hồi.

#### Method: makeTotalCarts($ids)

**Mô tả**

Hàm này tính toán tổng giá trị của các khóa học trong giỏ hàng dựa trên danh sách các ID được cung cấp và trả về một mảng chứa giá trị basePrice và totalPrice.

**Tham số**

- `$ids` (array): danh sách id giỏ hàng được chọn.

**Trả về**

- `[$basePrice, $totalPrice]` (array):
  - `$basePrice` (integer): Tổng giá niêm yết của các khóa học.
  - `$totalPrice` (integer): Tổng giá cuối cùng sau khi áp dụng các chiết khấu (nếu có).

#### Method: listRecommend()

**Mô tả**

Tạo danh sách gợi ý khóa học trong phần giỏ hàng

**Tham số**

Không có

**Trả về**

- `courses` (array): Mảng danh sách khóa học.

### Class: CouponService

#### Method: checkValidCode($code)

**Mô tả**

Kiểm tra mã giảm giá đó còn sử dụng được hay không

**Tham số**

- `code` (string): mã giảm giá

**Trả về**

- `Boolean`: Trả về true hoặc false

#### Method: findByCode($code)

**Mô tả**

Tìm Coupon bằng code

**Tham số**

- `code` (string): mã giảm giá

**Trả về**

- `Coupon`: Trả về đối tượng Coupon đầu tiên trong bảng

### Class: OrderService

#### Method: show()

**Mô tả**

Hàm này lấy thông tin chi tiết giỏ hàng từ session và trả về một mảng dữ liệu được định dạng để hiển thị lên giao diện người dùng.

**Tham số**

Không có

**Trả về**

- `courses` (array): Mảng danh sách khóa học.

#### Method: createOrder()

**Mô tả**

Hàm này lấy thông tin chi tiết giỏ hàng để tạo hóa đơn.

**Tham số**

Không có

**Trả về**

- `order` (array): Các thông tin của hóa đơn.
  - `orderId` (integer): id hóa đơn.
  - `orderCode` (string): mã truy xuất hóa đơn.
  - `total` (integer): tổng giá trị hóa đơn.

#### Method: makeDiscount($codes, $total)

**Mô tả**

Hàm này tính toán tổng giá trị giảm giá của các phiếu giảm giá dựa trên tổng giá hóa đơn.

**Tham số**

- `$codes` (array): danh sách mã giảm giá.
- `$toal` (array): tổng giá trị đơn hàng.

**Trả về**

- `discount` (integer): Giá giảm

### Class: TransactionService

#### Method: create($request, $method)

**Mô tả**

Tạo một giao dịch mới dựa trên yêu cầu thanh toán và phương thức thanh toán, cập nhật trạng thái đơn hàng và giỏ hàng.

**Tham số**

- `$request` (object): Yêu cầu chứa thông tin thanh toán.
  - `orderId` (integer): mã hóa đơn
  - `statusCode` (string): trạng thái đơn hàng
- `$method` (string): Phương thức thanh toán

**Trả về**

- `status` (boolean): Trạng thái thanh toán.

### Trait: DiscountTrait

#### Method: makeDiscountCost($code, $cost)

**Mô tả**

Tính toán chiết khấu dựa trên mã giảm giá và chi phí.

**Tham số**

- `$code` (string): mã giảm giá
- `$cost` (integer): Tổng giá

**Trả về**

- `integer`: Giá trị chiết khấu. Trả về 0 nếu mã giảm giá không hợp lệ hoặc có lỗi xảy ra.

#### Method: findValidCouponsByCost($total)

**Mô tả**

Phương thức này tìm các mã giảm giá hợp lệ dựa trên tổng giá trị của đơn hàng.

**Tham số**

- `$total` (integer): Tổng giá

**Trả về**

- `array|null`: Danh sách các mã giảm giá hợp lệ hoặc null nếu có lỗi xảy ra.

#### Method: getUsedCodes()

**Mô tả**

Phương thức này lấy danh sách các mã giảm giá đã sử dụng bởi người dùng.

**Tham số**

Không có.

**Trả về**

- `array`: Danh sách các mã giảm giá đã sử dụng.

#### Method: limitTest($total, $discount)

**Mô tả**

Phương thức này kiểm tra giới hạn chiết khấu dựa trên tổng giá trị của đơn hàng và tổng giá giảm.

**Tham số**

- `$total` (integer): Tổng giá trị đơn hàng.
- `$discount` (integer): Tổng giá giảm.

**Trả về**

- `array`: Mảng chứa hai phần tử:
  - `boolean`: Kết quả kiểm tra (true nếu chiết khấu hợp lệ, false nếu không).
  - `float`: Giá trị chiết khấu tối đa.

### Class: MomoService

#### Method: execPostRequest($url, $data)

**Mô tả**

Gửi yêu cầu POST tới URL chỉ định với dữ liệu được cung cấp.

**Tham số**

- `$url` (string): Địa chỉ URL để gửi yêu cầu POST.
- `$data` (string): Dữ liệu JSON để gửi.

**Trả về**

- `string`: Kết quả trả về từ yêu cầu POST.

#### Method: create($request)

**Mô tả**

Tạo một yêu cầu thanh toán với Momo và trả về URL thanh toán.

**Tham số**

- `$request` (object): Yêu cầu chứa thông tin đơn hàng.
  - `orderCode` (string): Mã đơn hàng.
  - `orderId` (integer): ID đơn hàng.
  - `total` (integer): Tổng số tiền cần thanh toán.

**Trả về**

- `string`: URL thanh toán.

#### Method: response($request)

**Mô tả**

Xử lý phản hồi từ Momo và tạo giao dịch nếu chữ ký hợp lệ.

**Tham số**

- `$request` (object): Yêu cầu chứa thông tin phản hồi từ Momo.
  - `partnerCode` (string): Mã đối tác.
  - `orderId` (string): Mã đơn hàng.
  - `requestId` (string): ID đơn hàng.
  - `amount` (string): Số tiền.
  - `orderInfo` (string): Thông tin đơn hàng.
  - `orderType` (string): Loại đơn hàng.
  - `transId` (string): ID giao dịch.
  - `resultCode` (string): Mã kết quả.
  - `message` (string): Thông điệp.
  - `payType` (string): Loại thanh toán.
  - `responseTime` (string): Thời gian phản hồi.
  - `extraData` (string): Dữ liệu bổ sung.
  - `signature` (string): Chữ ký Momo.

**Trả về**

- Trả về kết quả của phương thức `create` từ `transactionService` nếu chữ ký hợp lệ, ngược lại trả về `false`.

### Class: MomoService

#### Method: create($request)

**Mô tả**

Tạo URL thanh toán VNPay dựa trên yêu cầu thanh toán.

**Tham số**

- `$request` (object): Yêu cầu chứa thông tin đơn hàng.
  - `orderCode` (string): Mã đơn hàng.
  - `orderId` (integer): ID đơn hàng.
  - `total` (integer): Tổng số tiền cần thanh toán.

**Trả về**

- `string`: URL thanh toán.

#### Method: response($request)

**Mô tả**

Xử lý phản hồi từ VNPay, xác minh chữ ký và tạo giao dịch.

**Tham số**

- `$request` (object): Yêu cầu chứa thông tin phản hồi từ VNPay.

**Trả về**

- Trả về kết quả của phương thức `create` từ `transactionService` nếu chữ ký hợp lệ, ngược lại trả về `false`.

### Class: BankService

#### Method: create($request)

**Mô tả**

Tạo liên kết thanh toán PayOS và tạo mã QR cho thanh toán ngân hàng.

**Tham số**

- `$request` (object): Yêu cầu chứa thông tin đơn hàng.
  - `orderCode` (string): Mã đơn hàng.
  - `orderId` (integer): ID đơn hàng.
  - `total` (integer): Tổng số tiền cần thanh toán.

**Trả về**

- `JsonResponse`: Trả về JSON chứa liên kết QR nếu thành công hoặc thông báo lỗi nếu thất bại.

#### Method: checkBank()

**Mô tả**

Kiểm tra trạng thái thanh toán của đơn hàng thông qua PayOS và cập nhật giao dịch nếu thanh toán thành công.

**Tham số**

- Không có tham số.

**Trả về**

- `JsonResponse`: Trả về JSON chứa kết quả kiểm tra trạng thái thanh toán nếu thành công sẽ trả kèm link đến trang thanh toán thành công.
