<?php

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\AdminLogin;
use App\Http\Livewire\AdminDashboard;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Billing;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\ExampleLaravel\UserManagement;
use App\Http\Livewire\ExampleLaravel\UserProfile;
use App\Http\Livewire\Notifications;
use App\Http\Livewire\Profile;
use App\Http\Livewire\RTL;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Tables;
use App\Http\Livewire\{VirtualReality,CustomerIndex,DesignationWisePermissions};
use GuzzleHttp\Middleware;
use App\Http\Livewire\Order\{OrderIndex, OrderNew, OrderInvoice,OrderEdit,OrderView,LedgerView,AddOrderSlip,InvoiceList,CancelOrderList,InvoiceEdit};
use App\Http\Livewire\Product\{MasterProduct,AddProduct,UpdateProduct,MasterCategory,MasterSubCategory,FabricIndex,CollectionIndex,GalleryIndex,MasterCatalogue};
use App\Http\Livewire\Staff\{DesignationIndex,StaffIndex,StaffAdd,StaffUpdate,StaffView,StaffTask,StaffTaskAdd,StaffCities,SalesmanBillingIndex,MasterBranch};
use App\Http\Livewire\Expense\{ExpenseIndex,DepotExpanse,DailyExpenses,DailyCollection};
use App\Http\Livewire\UserAddressForm; 
use App\Http\Livewire\CustomerEdit; 
use App\Http\Livewire\CustomerDetails; 
use App\Http\Livewire\Supplier\SupplierIndex;
use App\Http\Livewire\Supplier\SupplierAdd;
use App\Http\Livewire\Supplier\SupplierEdit;
use App\Http\Livewire\Supplier\SupplierDetails;
use App\Http\Livewire\Measurement\MeasurementIndex;
use App\Http\Livewire\Fabric\FabricsIndex;
use App\Http\Livewire\PurchaseOrder\{PurchaseOrderIndex,PurchaseOrderCreate,PurchaseOrderEdit,GenerateGrn,PurchaseOrderDetails,GeneratePdf};
use App\Http\Livewire\Stock\{StockIndex,UserLedger};
use App\Http\Livewire\Report\{UserLedgerReport};
use App\Http\Livewire\BusinessType\BusinessTypeIndex;
use App\Http\Livewire\Accounting\{AddPaymentReceipt,PaymentCollectionIndex,AddOpeningBalance,ListOpeningBalance,IndexExpense,AddExpense,EditExpense};
// purchase Order pdf
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PurchaseOrder;


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

Route::get('/', function(){
    return redirect('admin/login');
});

Route::get('/sign-in', function(){
    return redirect('admin/login');
});

Route::get('forgot-password', ForgotPassword::class)->middleware('guest')->name('password.forgot');
Route::get('reset-password/{id}', ResetPassword::class)->middleware('signed')->name('reset-password');

// Route::get('sign-up', Register::class)->middleware('guest')->name('register');
// Route::get('sign-in', Login::class)->middleware('guest')->name('login');

// Route::get('user-profile', UserProfile::class)->middleware('auth')->name('user-profile');
// Route::get('user-management', UserManagement::class)->middleware('auth')->name('user-management');

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('dashboard', Dashboard::class)->name('dashboard');
//     Route::get('billing', Billing::class)->name('billing');
//     Route::get('profile', Profile::class)->name('profile');
//     Route::get('tables', Tables::class)->name('tables');
//     Route::get('notifications', Notifications::class)->name("notifications");
//     Route::get('virtual-reality', VirtualReality::class)->name('virtual-reality');
//     Route::get('static-sign-in', StaticSignIn::class)->name('static-sign-in');
//     Route::get('static-sign-up', StaticSignUp::class)->name('static-sign-up');
//     Route::get('rtl', RTL::class)->name('rtl');
// });

Route::get('admin/login', AdminLogin::class)->middleware('guest')->name('admin.login');


// Route::group(['prefix' => 'admin'], function () {
Route::group(['prefix' => 'admin','middleware' => 'admin'], function () {
// Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard'); // Ensure route name is correct
        }
        return redirect()->route('login'); // Redirect to login if not authenticated
    });
    
    Route::get('dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('billing', Billing::class)->name('billing');
    Route::get('profile', Profile::class)->name('profile');
    Route::get('tables', Tables::class)->name('tables');
    Route::get('notifications', Notifications::class)->name("notifications");
    Route::get('virtual-reality', VirtualReality::class)->name('virtual-reality');
    Route::get('static-sign-in', StaticSignIn::class)->name('static-sign-in');
    Route::get('static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('rtl', RTL::class)->name('rtl');

    
    
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', MasterProduct::class)->name('product.view')->middleware('check.permission');
        Route::get('/products/import', MasterProduct::class)->name('product.import');
        Route::get('/add/products', AddProduct::class)->name('product.add')->middleware('check.permission');
        Route::get('/update/products/{product_id}', UpdateProduct::class)->name('product.update')->middleware('check.permission');
        Route::get('/categories', MasterCategory::class)->name('admin.categories')->middleware('check.permission');
        Route::get('/subcategories', MasterSubCategory::class)->name('admin.subcategories');
        Route::get('/measurements/{product_id}', MeasurementIndex::class)->name('measurements.index')->middleware('check.permission');
        Route::get('/fabrics/{product_id}', FabricsIndex::class)->name('product_fabrics.index')->middleware('check.permission');
        Route::post('/measurements/update-positions', [MeasurementIndex::class, 'updatePositions'])->name('measurements.updatePositions');
        Route::get('/fabrics', FabricIndex::class)->name('admin.fabrics.index')->middleware('check.permission');

        Route::get('/collections', CollectionIndex::class)->name('admin.collections.index')->middleware('check.permission');
        Route::get('/gallery/{product_id}', GalleryIndex::class)->name('product.gallery');
        Route::get('/catalogue', MasterCatalogue::class)->name('product.catalogue')->middleware('check.permission');

    });

    // Purchase Order
    Route::group(['prefix' => 'purchase-order'], function () {
       Route::get('/',PurchaseOrderIndex::class)->name('purchase_order.index')->middleware('check.permission');
       Route::get('/create',PurchaseOrderCreate::class)->name('purchase_order.create')->middleware('check.permission');
       Route::get('/edit/{purchase_order_id}',PurchaseOrderEdit::class)->name('purchase_order.edit')->middleware('check.permission');
       Route::get('/details/{purchase_order_id}',PurchaseOrderDetails::class)->name('purchase_order.details')->middleware('check.permission');
       Route::get('/generate-grn/{purchase_order_id}',GenerateGrn::class)->name('purchase_order.generate_grn')->middleware('check.permission');
       Route::get('/pdf/{purchase_order_id}',function($purchase_order_id){
            $purchaseOrder = PurchaseOrder::with('supplier', 'orderproducts')->findOrFail($purchase_order_id);
            $pdf = Pdf::loadView('livewire.purchase-order.generate-pdf', compact('purchaseOrder'));
            return $pdf->download('purchase_order_' . $purchase_order_id . '.pdf');
       })->name('purchase_order.generate_pdf');
    });

    // Business Type
    Route::group(['prefix'=> 'business-type'], function (){
       Route::get('/',BusinessTypeIndex::class)->name('business_type.index');
    });

    // Stock Report
    Route::group(['prefix' => 'stock'], function () {
       Route::get('/',StockIndex::class)->name('stock.index')->middleware('check.permission');
       Route::get('/user-ledger',UserLedger::class)->name('user.ledger');
    });

    Route::get('/branch',MasterBranch::class)->name('branch.index')->middleware('check.permission');
    Route::get('/designation',DesignationIndex::class)->name('staff.designation')->middleware('check.permission');
    Route::get('/designation-wise-permission/{id}',DesignationWisePermissions::class)->name('admin.staff.designation_wise_permission');
    
    // Staff
    Route::prefix('staff')->group(function() {
        Route::get('/',StaffIndex::class)->name('staff.index')->middleware('check.permission');
        Route::get('/add',StaffAdd::class)->name('staff.add')->middleware('check.permission');
        Route::get('/update/{staff_id}',StaffUpdate::class)->name('staff.update')->middleware('check.permission');
        Route::get('/view/{staff_id}',StaffView::class)->name('staff.view')->middleware('check.permission');
        Route::get('/task/{staff_id}',StaffTask::class)->name('staff.task');
        Route::get('/task/add/{staff_id}',StaffTaskAdd::class)->name('staff.task.add');
        Route::get('cities/add/{salesman_id}',StaffCities::class)->name('staff.cities.add');
    });
    
     // Salesman
    Route::prefix('staff/bill-books')->group(function() {
        Route::get('/',SalesmanBillingIndex::class)->name('salesman.index')->middleware('check.permission');
    });
    
    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', CustomerIndex::class)->name('customers.index')->middleware('check.permission');
        Route::get('/add', UserAddressForm::class)->name('admin.user-address-form')->middleware('check.permission');
        Route::get('/{id}/edit', CustomerEdit::class)->name('admin.customers.edit')->middleware('check.permission');
        Route::get('/{id}', CustomerDetails::class)->name('admin.customers.details')->middleware('check.permission');
    });

    Route::prefix('suppliers')->group(function() {
        Route::get('/', SupplierIndex::class)->name('suppliers.index')->middleware('check.permission');
        Route::get('/add', SupplierAdd::class)->name('suppliers.add')->middleware('check.permission');
        Route::get('/edit/{id}', SupplierEdit::class)->name('suppliers.edit')->middleware('check.permission');
        Route::get('/details/{id}', SupplierDetails::class)->name('suppliers.details')->middleware('check.permission');
    });
    // Expense
    Route::prefix('expense')->name('expense.')->group(function() {
        Route::get('/{parent_id}', ExpenseIndex::class)->name('index')->middleware('check.permission');

    });
    Route::prefix('accounting')->group(function() {
        Route::get('/collection-and-expenses', DepotExpanse::class)->name('admin.accounting.collection_and_expenses');
        Route::get('/daily/expenses', DailyExpenses::class)->name('admin.accounting.daily.expenses');
        Route::get('/payment-collection', PaymentCollectionIndex::class)->name('admin.accounting.payment_collection')->middleware('check.permission');
        Route::get('/add-payment-receipt/{payment_voucher_no?}', AddPaymentReceipt::class)->name('admin.accounting.add_payment_receipt')->middleware('check.permission');
        Route::get('/add-opening-balance', AddOpeningBalance::class)->name('admin.accounting.add_opening_balance')->middleware('check.permission');
        Route::get('/list-opening-balance', ListOpeningBalance::class)->name('admin.accounting.list_opening_balance')->middleware('check.permission');
        Route::get('/list/depot-expense', IndexExpense::class)->name('admin.accounting.list.depot_expense')->middleware('check.permission');
        Route::get('/add-depot-expense', AddExpense::class)->name('admin.accounting.add_depot_expense')->middleware('check.permission');
        Route::get('/edit-depot-expense/{expenseId}', EditExpense::class)->name('admin.accounting.edit_depot_expense')->middleware('check.permission');
    });

    Route::prefix('report')->group(function() {
        Route::get('/user-ledger', UserLedgerReport::class)->name('admin.report.user_ledger')->middleware('check.permission');
    });

    Route::prefix('daily-collection')->name('daily-collection.')->group(function() {
        // Route::get('/', DepotExpanse::class)->name('index');
        Route::get('/add', DailyCollection::class)->name('add');

    });

    
    // Route::get('/measurements/add', MeasurementAdd::class)->name('measurements.add');
    // Route::get('/measurements/edit/{id}', MeasurementEdit::class)->name('measurements.edit');
    // Route::get('/measurements/details/{id}', MeasurementDetails::class)->name('measurements.details');

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/list/{customer_id?}', OrderIndex::class)->name('admin.order.index')->middleware('check.permission');
        Route::get('/confirm/{id}', AddOrderSlip::class)->name('admin.order.add_order_slip')->middleware('check.permission');
        Route::get('/invoice/{id}', OrderInvoice::class)->name('admin.order.invoice');
        Route::get('/new', OrderNew::class)->name('admin.order.new')->middleware('check.permission');
        Route::get('/edit/{id}', OrderEdit::class)->name('admin.order.edit')->middleware('check.permission');
        Route::get('/view/{id}', OrderView::class)->name('admin.order.view')->middleware('check.permission');
        Route::get('/ledger/{id}', LedgerView::class)->name('admin.order.ledger.view');
        Route::get('/invoice', InvoiceList::class)->name('admin.order.invoice.index')->middleware('check.permission');
        Route::get('/cancel-order', CancelOrderList::class)->name('admin.order.cancel-order.index')->middleware('check.permission');
    });
});