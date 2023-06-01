<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ImportBillController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductCatController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\UserController;
use App\Models\ImportBill;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseClietController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientHomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\InfoAccountController;
use App\Http\Controllers\LoginClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostClientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShowCatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**router in client */
Route::get('/', [ClientHomeController::class,'HomeView']) ->name('client.index');
Route::get('/client/index', [ClientHomeController::class,'HomeView']) ->name('client.index');
Route::get('/', [ClientHomeController::class,'HomeView']) ->name('client.index');
Route::get('/client/baby_boy', [ClientHomeController::class,'BoyView']) ->name('client.baby_boy');
Route::get('/client/baby_girl', [ClientHomeController::class,'GirlView']) ->name('client.baby_girl');
Route::get('/client/man', [ClientHomeController::class,'ManView']) ->name('client.man');
Route::get('/client/women', [ClientHomeController::class,'WomenView']) ->name('client.women');
Route::get('/client/customner-account', [ClientHomeController::class,'HomeView']) ->name('client.customner-account');
Route::get('/client/news-detail', [ClientHomeController::class,'HomeView']) ->name('client.news-detail');
Route::get('/client/news-home', [ClientHomeController::class,'HomeView']) ->name('client.news-home');
Route::get('/client/order-history', [ClientHomeController::class,'HomeView']) ->name('client.order-history');
Route::get('/client/outlet', [ClientHomeController::class,'HomeView']) ->name('client.outlet');
Route::get('/client/product-detail/{id}', [ClientHomeController::class,'detail']) ->name('client.product-detail');

/**cart */
Route::get('/client/cart', [CartController::class,'CartView']) ->name('client.cart');
Route::get('/client/infoBill/{id}', [CartController::class,'infoBill']);

Route::post('/client/cart/getNewCart', [CartController::class,'getNewCart']);
Route::post('/client/cart/CheckQuantity', [CartController::class,'checkQuantity']);
Route::post('/client/cart/order', [CartController::class,'order']);
Route::get('/client/cart/paymentPage', [CartController::class,'paymentPage'])->name('client.paymentPage');


/**show Cat */
Route::get('/client/showCat/{id}', [ShowCatController::class,'showCat']) ->name('client.showCat');
Route::get('/client/showProCat/{id}', [ShowCatController::class,'showProCat']) ->name('client.showProCat');
Route::get('/client/getCatData', [ShowCatController::class,'getCatData']);
Route::get('/client/getProCatData', [ShowCatController::class,'getProCatData']);

/**Post */
Route::get('/client/post', [PostClientController::class,'index']) ->name('client.posts');
Route::get('/client/post/getPageData', [PostClientController::class,'getPageData']) ;
Route::get('/client/detailPost/{id}', [PostClientController::class,'detailPost'])->name('client.detailPost');

/**outlet */
Route::get('/client/outlet/FilterOutlet', [ClientHomeController::class,'FilterOutlet']) ;
Route::get('/client/outlet', function(){
    return view('client.outlet');
})->name('client.outlet');

/**infoAccount */
Route::get('/client/infoaccount/infoCustomer', [InfoAccountController::class,'infoCustomer'])->name('client.infoCustomer') ;
Route::post('/client/infoaccount/updateInfoCustomer', [InfoAccountController::class,'updateInfoCustomer']) ;
Route::get('/client/infoaccount/orderHistory', [InfoAccountController::class,'orderHistory'])->name('client.orderHistory') ;
Route::get('/client/infoaccount/getOrderByCusId', [InfoAccountController::class,'getOrderByCusId']) ;
Route::get('/client/infoaccount/cancelOrder/{id}', [InfoAccountController::class,'cancelOrder']) ;

/**login client */
Route::post('/client/register', [LoginClientController::class, 'register']);
Route::post('/client/login', [LoginClientController::class, 'login']);
Route::get('/client/logout', [LoginClientController::class, 'logout']);
Route::get('/client/ConfirmPhone/{id}', [LoginClientController::class, 'ConfirmPhone']);



/**router in admin */
/**login */
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin',function(){
    return view('admin.welcome');
});

/**category */
Route::get('/admin/category', [CategoryController::class,'index']) ->name('admin.Category')->middleware('auth', 'permission:Danh sách danh mục');
Route::get('/admin/category/getPageData', [CategoryController::class,'getPageData']);
Route::get('/admin/category/getByType/{id}',[CategoryController::class,'getByType']);
Route::get('/admin/category/getById/{id}',[CategoryController::class,'getById']);
Route::post('/admin/category/create', [CategoryController::class,'create'])->name('category.create');
Route::post('/admin/category/update/{id}', [CategoryController::class,'update']);
Route::get('/admin/category/destroy/{id}', [CategoryController::class,'destroy']);
Route::get('/admin/category/changeStatus/{id}', [CategoryController::class,'changeStatus']);

/**ProductCategory */
Route::get('/admin/productcat', [ProductCatController::class,'index']) ->name('admin.ProductCat')->middleware('auth', 'permission:Quản lý loại sản phẩm');
Route::get('/admin/productcat/getPageData', [ProductCatController::class,'getPageData']);
Route::get('/admin/productcat/getById/{id}',[ProductCatController::class,'getById']);
Route::post('/admin/productcat/create', [ProductCatController::class,'create']);
Route::post('/admin/productcat/update/{id}', [ProductCatController::class,'update']);
Route::get('/admin/productcat/destroy/{id}', [ProductCatController::class,'destroy']);
Route::get('/admin/productcat/changeStatus/{id}', [ProductCatController::class,'changeStatus']);

/**Product */
Route::get('/admin/product', [ProductController::class,'index']) ->name('admin.Product')->middleware('auth', 'permission:Quản lý sản phẩm');
Route::get('/admin/product/createView', [ProductController::class,'createView']) ->name('admin.Product.Create');
Route::get('/admin/product/updateView/{id}', [ProductController::class,'updateView']) ->name('admin.Product.Update');
Route::get('/admin/product/getSearchData', [ProductController::class,'getSearchData']);
Route::get('/admin/product/getSearchDataClient', [ProductController::class,'getSearchDataClient']);
Route::get('/admin/product/getPageData', [ProductController::class,'getPageData']);
Route::post('/admin/product/create', [ProductController::class,'create']);
Route::post('/admin/product/uploadProImg', [ProductController::class,'uploadProImg']);
Route::post('/admin/product/update', [ProductController::class,'update']);
Route::post('/admin/product/uploadUpdateProImg', [ProductController::class,'uploadUpdateProImg']);
Route::get('/admin/product/destroy/{id}', [ProductController::class,'destroy']);
Route::get('/admin/productVariation/destroy/{id}', [ProductController::class,'destroyVariation']);
Route::get('/admin/product/changeStatus/{id}', [ProductController::class,'changeStatus']);
    
/**role */
Route::get('roles/', [RoleController::class, 'index'])->name('roles.index')->middleware('auth', 'permission:Danh sách chức vụ');
Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('auth', 'permission:Thêm chức vụ');
Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
Route::get('roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit')->middleware('auth', 'permission:Sửa chức vụ');
Route::put('roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('auth', 'permission:Xóa chức vụ');

/**users */
Route::get('users/', [UserController::class, 'index'])->name('users.index')->middleware('auth', 'permission:Quản lý nhân viên');
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users/store', [UserController::class, 'store'])->name('users.store');
Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');

/**feedback */
Route::get('/admin/feedback', [FeedbackController::class,'index']) ->name('admin.feedback')->middleware('auth', 'permission:Quản lý feedback');
Route::get('/admin/feedback/getPageData', [FeedbackController::class,'getPageData']);
Route::get('/admin/feedback/getById/{id}', [FeedbackController::class,'getById']);
Route::get('/admin/feedback/changeStatus/{id}', [FeedbackController::class,'changeStatus']);
Route::post('/admin/feedback/create', [FeedbackController::class,'create']);
Route::post('/admin/feedback/update/{id}', [FeedbackController::class,'update']);
Route::get('/admin/feedback/getByProduct', [FeedbackController::class,'getByProduct']);
Route::get('/admin/feedback/getTotalReview/{id}', [FeedbackController::class,'getTotalReview']);

    /**Report */
Route::post('/admin/getReportDay', [ReportController::class,'getReportDay'])->middleware('auth', 'permission:Xem báo cáo');
Route::post('/admin/getReportMonth', [ReportController::class,'getReportMonth'])->middleware('auth', 'permission:Xem báo cáo');
Route::post('/admin/getReportYear', [ReportController::class,'getReportYear'])->middleware('auth', 'permission:Xem báo cáo');
Route::get('/admin/report', function(){
    return view('admin.Report');
})->name('report.index')->middleware('auth', 'permission:Xem báo cáo');

Route::get('/admin/reportproduct', [ReportController::class,'reportproduct'])->name('admin.ReportProduct')->middleware('auth', 'permission:Xem báo cáo');
Route::post('/admin/reportProductDay', [ReportController::class,'getReportProductDay'])->middleware('auth', 'permission:Xem báo cáo');
Route::post('/admin/reportProductMonth', [ReportController::class,'getReportProductMonth'])->middleware('auth', 'permission:Xem báo cáo');
Route::post('/admin/reportProductYear', [ReportController::class,'getReportProductYear'])->middleware('auth', 'permission:Xem báo cáo');

/**Discount */
Route::get('/admin/discount', [DiscountController::class,'index']) ->name('admin.Discount')->middleware('auth', 'permission:Quản lý khuyến mại');
Route::get('/admin/discount/createView', [DiscountController::class,'createView']) ->name('admin.Discount.Create');
Route::get('/admin/discount/updateView/{id}', [DiscountController::class,'updateView']) ->name('admin.Discount.Update');
Route::get('/admin/discount/getPageData', [DiscountController::class,'getPageData']);
Route::get('/admin/discount/getProductOnly', [DiscountController::class,'getProductOnly']);
Route::get('/admin/discount/getById/{id}', [DiscountController::class,'getById']);
Route::post('/admin/discount/create', [DiscountController::class,'create']);
Route::post('/admin/discount/update', [DiscountController::class,'update']);
Route::get('/admin/discount/destroy/{id}', [DiscountController::class,'destroy']);

/**importbill */
Route::get('/admin/importbill', [ImportBillController::class,'index']) ->name('admin.ImportBill')->middleware('auth', 'permission:Quản lý hóa đơn nhập');
Route::get('/admin/importbill/create', [ImportBillController::class,'createView']) ->name('admin.ImportBill.Create');
Route::get('/admin/importbill/getPageData', [ImportBillController::class,'getPageData']);
Route::get('/admin/importbill/getById/{id}', [ImportBillController::class,'getById']);
Route::post('/admin/importbill/create', [ImportBillController::class,'create']);
Route::get('/admin/importbill/destroy/{id}', [ImportBillController::class,'destroy']);

/**post */
Route::get('/admin/post', [PostController::class,'index']) ->name('admin.Post')->middleware('auth', 'permission:Quản lý bài viết');
Route::get('/admin/post/createView', [PostController::class,'createView']) ->name('admin.Post.Create');
Route::get('/admin/post/updateView/{id}', [PostController::class,'updateView']) ->name('admin.Post.Update');
Route::get('/admin/post/getPageData', [PostController::class,'getPageData']);
Route::get('/admin/post/getById/{id}', [PostController::class,'getById']);
Route::post('/admin/post/update/{id}', [PostController::class,'update']);
Route::post('/admin/post/create', [PostController::class,'create']);
Route::get('/admin/post/destroy/{id}', [PostController::class,'destroy']);


/**Customer */
Route::get('/admin/customer', [CustomerController::class,'index']) ->name('admin.Customer')->middleware('auth', 'permission:Quản lý khách hàng');
Route::get('/admin/getPageData', [CustomerController::class,'getPageData']);
Route::get('/admin/changeStatus/{id}', [CustomerController::class,'changeStatus']) ->name('admin.changeStatus');

/**login */
/**Order */
Route::get('/admin/order/WaitProcess', [OrderController::class,'WaitProcess']) ->name('admin.WaitProcess')->middleware('auth', 'permission:Quản lý đơn hàng');
Route::get('/admin/order/Tranfering',[OrderController::class,'Tranfering'] ) ->name('admin.Tranfering')->middleware('auth', 'permission:Quản lý đơn hàng');
Route::get('/admin/order/Success',[OrderController::class,'Success']) ->name('admin.Success')->middleware('auth', 'permission:Quản lý đơn hàng');
Route::get('/admin/order/Canceled', [OrderController::class,'Canceled']) ->name('admin.Canceled')->middleware('auth', 'permission:Quản lý đơn hàng');

Route::get('/admin/order/getPageData', [OrderController::class,'getPageData']);
Route::get('/admin/order/getOrderById/{id}', [OrderController::class,'getOrderById']);
Route::get('/admin/order/changeStatus/{id}', [OrderController::class,'changeStatus']);
Route::get('/admin/order/cancelOrder/{id}', [OrderController::class,'cancelOrder']);
Route::get('/admin/order/delete/{id}', [OrderController::class,'delete']);

/**ProductColor */
Route::get('/admin/productcolor/getAll', [ProductColorController::class,'getAll']);
Route::post('/admin/productcolor/create', [ProductColorController::class,'create']);
Route::post('/admin/productcolor/update/{id}', [ProductColorController::class,'update']);
Route::get('/admin/productcolor/destroy/{id}', [ProductColorController::class,'destroy']);

/**ProductSize */
Route::get('/admin/productsize/getAll', [ProductSizeController::class,'getAll']);
Route::post('/admin/productsize/create', [ProductSizeController::class,'create']);
Route::post('/admin/productsize/update/{id}', [ProductSizeController::class,'update']);
Route::get('/admin/productsize/destroy/{id}', [ProductSizeController::class,'destroy']);




