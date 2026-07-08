<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Seller\SellerAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    AdminOrderLifecycleController,
    DashboardController,
    CategoryController,
    ProductCategoryController,
    CustomerController,
    SellerController,
    PayoutController,
    ProductController,
    BrandController,
    InventoryController,
    ReviewController,
    WishlistController,
    OrderController,
    ReturnController,
    CancellationController,
    ReportController,
    SettingController,
    RoleController,
    WebsiteController,
    BlogController,
    SEOController,
    SupportTicketController,
    TicketReplyController,
    SettlementLogController,
    PaymentLogController,
    ShippingLogController,
    ShippingController,
    TrashController,
};
use App\Http\Controllers\Seller\{
    SellerDashboardController,
    SellerOrderController,
    SellerProductController,
    SellerSupportController,
    BulkUploadController,
    BulkImageController,
    SellerBulkDashboardController,
    SellerOrderLifecycleController
};
use App\Http\Controllers\Website\{
    PagesController,
    CustomerAuthController,
    CheckoutController,
    OrderLifecycleController,
    OrderTrackingController
};

use App\Models\Cart;
use App\Http\Controllers\Webhooks\ShiprocketWebhookController;
use App\Http\Controllers\Webhooks\RazorpayWebhookController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'index'])->name('customer.login');
    Route::post('/send-otp', [CustomerAuthController::class, 'sendOtp']);
    Route::post('/verify-otp', [CustomerAuthController::class, 'verifyOtp']);
    Route::post('/complete-profile', [CustomerAuthController::class, 'completeProfile']);
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
    Route::get('/profile', [CustomerAuthController::class, 'profile'])->name('customer.profile');
    Route::get('/google', [CustomerAuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/google/callback', [CustomerAuthController::class, 'handleGoogleCallback']);
});


Route::middleware('auth.customer')->group(function () {
    Route::get('/cart', [PagesController::class, 'cart'])->name('cart');
    Route::post('/cart/add', [PagesController::class, 'addToCart']);
    Route::get('/cart/count', function () {
        if (!auth('customer')->check()) {
            return response()->json(['count' => 0]);
        }
        $count = Cart::where('user_id', auth('customer')->id())
            ->where('is_ordered', false)
            ->sum('quantity');
        return response()->json(['count' => $count]);
    });
    Route::post('/cart/update', [PagesController::class, 'update']);
    Route::post('/cart/remove', [PagesController::class, 'remove']);
    Route::post('/checkout/initiate', [CheckoutController::class, 'initiate']);
    Route::post('/checkout/success', [CheckoutController::class, 'success']);
    Route::post('/checkout/save-address', [CheckoutController::class, 'saveAddress']);
    Route::post('/review/store', [ReviewController::class, 'CustomerReview'])->name('review.store');
    Route::get('/order-history', [CheckoutController::class, 'orderHistory'])->name('order-history');
    Route::post('/webhooks/shiprocket', ShiprocketWebhookController::class)->name('webhooks.shiprocket');
    Route::post('/webhooks/razorpay', RazorpayWebhookController::class)->name('webhooks.razorpay');

    Route::prefix('orders')->group(function () {
        Route::post('/items/{item}/cancel', [OrderLifecycleController::class, 'cancelItem'])->name('orders.items.cancel');
        Route::post('/items/{item}/return', [OrderLifecycleController::class, 'returnItem'])->name('orders.items.return');
        Route::post('/items/{item}/replace', [OrderLifecycleController::class, 'replaceItem'])->name('orders.items.replace');
        Route::get('/{order}/tracking', [OrderTrackingController::class, 'show']);
    });
});

Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('/product/{slug}', [PagesController::class, 'productDetails'])->name('product.details');
Route::post('/check-pincode', [PagesController::class, 'checkPincode']);
Route::post('/api/product/variant/resolve', [PagesController::class, 'resolveVariant']);

/*
|--------------------------------------------------------------------------
| Authentication Routes (Admin + Seller)
|--------------------------------------------------------------------------
*/

// 🔹 ADMIN LOGIN (at /admin)
Route::get('/admin', [AdminController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin', [AdminController::class, 'login'])->name('admin.login.submit');

// 🔹 SELLER LOGIN (at /seller)
// Route::get('/seller', [AdminController::class, 'showSellerLoginForm'])->name('seller.login');
// Route::post('/seller', [AdminController::class, 'login'])->name('seller.login.submit');

Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/', [SellerAdminController::class, 'showSellerLoginForm'])->name('login');
    Route::post('/send-otp', [SellerAdminController::class, 'Login'])->name('login.submit');
    Route::post('/verify-otp', [SellerAdminController::class, 'verifyOtp'])->name('verify-otp');
    Route::get('/business-details', [SellerAdminController::class, 'businessDetails'])->name('business-details');
    Route::get('/captcha', [SellerAdminController::class, 'captcha'])->name('captcha');
    Route::post('/captcha/verify', [SellerAdminController::class, 'captchaVerify'])->name('captcha.verify');
    Route::post('/bank-account/verify', [SellerAdminController::class, 'bankAccountVerify'])->name('bank-account.verify');
    Route::post('/business-details/register', [SellerAdminController::class, 'businessDetailsRegister'])->name('business-details.register');
    Route::get('/api/validate/pincode/{pin}', [SellerAdminController::class, 'lookupPincode'])->name('pincode.lookup');
    Route::get('/registration-otp', [SellerAdminController::class, 'showRegistrationOtpForm'])->name('registration-otp');
    Route::post('/registration-otp', [SellerAdminController::class, 'verifyRegistrationOtp'])->name('registration-otp.verify');
    Route::post('/registration-otp/resend', [SellerAdminController::class, 'resendRegistrationOtp'])->name('registration-otp.resend');
});



// 🔹 LOGOUTS
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/seller/logout', [AdminController::class, 'logout'])->name('seller.logout');



Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/notifications', [NotificationController::class, 'adminNotifications']);
});

Route::middleware('auth:seller')->group(function () {
    Route::get('/seller/notifications', [NotificationController::class, 'sellerNotifications']);
    Route::get('/seller/notifications/{notification}', [NotificationController::class, 'showSellerNotification'])
        ->name('seller.notifications.show');
});

Route::middleware('auth:customer')->group(function () {
    Route::get('/customer/notifications', [NotificationController::class, 'customerNotifications']);
});







/*
|--------------------------------------------------------------------------
| Admin Panel (Protected by admin.auth)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('admin.auth', 'verify.admin.session', 'admin.timeout')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Sellers Management
    Route::prefix('sellers')->name('admin.sellers.')->group(function () {
        // Route::get('/applications', [SellerController::class, 'applications'])->name('applications');
        // Route::get('/{seller}/download-docs', [SellerController::class, 'viewDocs'])->name('applications.viewDocs');
        // // Route::get('/compliance', [SellerController::class, 'compliance'])->name('compliance');
        // Route::patch('/{seller}/accept', [SellerController::class, 'KYCaccept'])->name('kyc.verify');
        // Route::patch('/{seller}/reject', [SellerController::class, 'KYCreject'])->name('kyc.reject');
        // Route::get('/bank/{seller}', [SellerController::class, 'bankDetails'])->name('bank');
        Route::patch('/{seller}/toggle-active', [SellerController::class, 'toggleActive'])->name('toggle-active');
        Route::patch('/{seller}/toggle-onboard', [SellerController::class, 'toggleOnboard'])->name('toggle-onboard');
        Route::resource('/', SellerController::class)->parameters(['' => 'seller']);
        Route::post('/{seller}/delete', [SellerController::class, 'deleteSeller'])->name('delete');
    });

    // Payouts
    Route::prefix('payouts')->name('admin.payouts.')->group(function () {
        Route::get('/', [PayoutController::class, 'index'])->name('index');
        Route::get('/create', [PayoutController::class, 'create'])->name('create');
        Route::get('/{id}', [PayoutController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PayoutController::class, 'edit'])->name('edit');
        Route::get('/{id}/update', [PayoutController::class, 'update'])->name('update');
        Route::post('/', [PayoutController::class, 'store'])->name('store');
        Route::delete('/{payout}', [PayoutController::class, 'destroy'])->name('destroy');
    });

    // Webhooks
    // Route::post('webhooks/razorpayx', [WebhookController::class, 'razorpayx'])->name('admin.webhooks.razorpayx');

    // Products, Categories, Brands, Inventory
    Route::resource('products', ProductController::class)->names('admin.products');
    Route::get('products/{id}/quick-view', [ProductController::class, 'quickView'])->name('quickView');
    Route::post('products/bulk-feature', [ProductController::class, 'bulkFeature'])->name('bulkFeature');
    Route::post('products/bulk-approve', [ProductController::class, 'bulkApprove'])->name('bulkApprove');
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    Route::get('category-explorer/children/{level}/{id?}', [CategoryController::class, 'children'])->name('admin.category-explorer.children');
    Route::get('category-explorer/products', [CategoryController::class, 'products'])->name('admin.category-explorer.products');
    Route::post('categories/upload-image', [CategoryController::class, 'uploadImage'])->name('admin.categories.uploadImage');
    Route::resource('product-categories', ProductCategoryController::class)->names('admin.product-categories');
    Route::get('product-categories/category-attributes/{category}', [ProductController::class, 'getCategoryAttributes'])->name('admin.product-categories.attributes');
    Route::resource('brands', BrandController::class)->names('admin.brands');
    Route::resource('inventory', InventoryController::class)->names('admin.inventory');
    Route::post('inventory/{inventory}/reserve', [InventoryController::class, 'reserveStock'])->name('admin.inventory.reserve');
    Route::post('inventory/{inventory}/release', [InventoryController::class, 'releaseStock'])->name('admin.inventory.release');
    Route::post('inventory/{inventory}/adjust', [InventoryController::class, 'adjustStock'])->name('admin.inventory.adjust');

    // Orders, Returns, Cancellations
    Route::resource('orders', OrderController::class)->names('admin.orders');

    Route::get('orders/get-addresses/{id}', [OrderController::class, 'getAddresses']);
    Route::get('orders/{id}/quick-view', [OrderController::class, 'quickView'])->name('quickView');
    Route::resource('returns', ReturnController::class)->names('admin.returns');
    // Route::resource('cancellations', CancellationController::class)->names('admin.cancellations');
    // Route::patch('cancellations/{id}/approve', [CancellationController::class, 'approve'])->name('admin.cancellations.approve');
    // Route::patch('cancellations/{id}/reject', [CancellationController::class, 'reject'])->name('admin.cancellations.reject');

    // Customers, Reviews, Wishlists
    Route::resource('customers', CustomerController::class)->names('admin.customers');
    Route::post('customers/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('admin.customers.bulkDelete');
    Route::patch('customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('admin.customers.toggle-status');
    Route::resource('reviews', ReviewController::class)->names('admin.reviews');
    Route::post('reviews/bulk-delete', [ReviewController::class, 'bulkDelete'])->name('admin.reviews.bulkDelete');
    Route::resource('wishlists', WishlistController::class)->names('admin.wishlists');
    Route::post('wishlists/bulk-delete', [WishlistController::class, 'bulkDelete'])->name('admin.wishlists.bulkDelete');


    // Website
    Route::prefix('website')->name('admin.website.')->group(function () {
        // Home Page Sections
        Route::get('home', [WebsiteController::class, 'index'])->name('home');
        Route::get('home/preview/{homeSection}', [WebsiteController::class, 'show'])->name('home.preview');
        Route::get('home/{homeSection}/edit', [WebsiteController::class, 'edit'])->name('home.edit');
        Route::put('home/{homeSection}', [WebsiteController::class, 'update'])->name('home.update');
        Route::post('home/reorder', [WebsiteController::class, 'reorder'])->name('home.reorder');
        Route::patch('home/{homeSection}/toggle', [WebsiteController::class, 'toggle'])->name('home.toggle');

        Route::get('banners', [WebsiteController::class, 'banners'])->name('banners');
        Route::get('pages', [WebsiteController::class, 'pages'])->name('pages');
        Route::resource('blogs', BlogController::class)->names('blogs');
        Route::get('seo', [SEOController::class, 'index'])->name('seo');
        Route::post('seo/update', [SEOController::class, 'update'])->name('seo.update');
    });

    // ========================== SUPPORT MODULE ==========================
    Route::prefix('support')->name('admin.support.')->group(function () {

        // 🎧 Seller Support
        Route::get('/seller', [SupportTicketController::class, 'seller'])->name('seller');
        Route::get('/seller/{id}/messages', [SupportTicketController::class, 'getMessagesforSeller'])->name('seller.messages');
        Route::post('/seller/{id}/messages', [SupportTicketController::class, 'storeMessageforSeller'])->name('seller.messages.store');
        Route::post('/seller/{id}/status', [SupportTicketController::class, 'updateStatus'])->name('seller.status');

        // 👤 Customer Support
        Route::get('/customer', [SupportTicketController::class, 'customer'])->name('customer');
        Route::get('/customer/{id}/messages', [SupportTicketController::class, 'getMessagesforCustomer'])->name('customer.messages');
        Route::post('/customer/{id}/messages', [SupportTicketController::class, 'storeMessageforCustomer'])->name('customer.messages.store');

        // 🎫 All Tickets
        Route::get('/tickets', [SupportTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [SupportTicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [SupportTicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{id}', [SupportTicketController::class, 'show'])->name('tickets.show');
        Route::delete('/tickets/{id}', [SupportTicketController::class, 'destroy'])->name('tickets.destroy');
        Route::post('/tickets/{id}/assign', [SupportTicketController::class, 'assign'])->name('tickets.assign');
        Route::get('/fetch-users', [SupportTicketController::class, 'fetchUsers'])->name('fetch-users');
        Route::get('/poll/{ticket}', [SupportTicketController::class, 'poll'])->name('poll');
        Route::post('/reply', [TicketReplyController::class, 'adminReply'])->name('reply');
    });
    // ========================== PAYMENTS ==========================
    Route::prefix('payments')->name('admin.payments.')->group(function () {
        Route::get('settlements', [SettlementLogController::class, 'index'])->name('settlements');
        Route::get('logs', [PaymentLogController::class, 'index'])->name('logs');
    });
    // ========================== SHIPPING LOGS ==========================
    Route::prefix('shipping')->name('admin.shipping.')->group(function () {
        Route::get('logs', [ShippingLogController::class, 'index'])->name('logs');
    });
    Route::post('orders/{order}/shipping/create', [ShippingController::class, 'createShipment'])->name('admin.orders.shipping.create');
    Route::post('orders/{order}/shipping/mark-delivered', [ShippingController::class, 'markDelivered'])->name('admin.orders.shipping.markDelivered');
    Route::get('orders/{order}/shipping/logs', [ShippingController::class, 'logs'])->name('admin.orders.shipping.logs');
    Route::get('orders/{id}/shipping/status', [OrderController::class, 'shippingStatus'])->name('admin.orders.shipping.status');

    // Reports
    Route::prefix('reports')->name('admin.reports.')->group(function () {
        Route::get('sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('sales/report', [ReportController::class, 'fetchSalesData'])->name('sales.data');
        Route::get('revenue', [ReportController::class, 'revenue'])->name('revenue');
        Route::get('revenue/report', [ReportController::class, 'fetchRevenueData'])->name('revenue.data');
        Route::get('seller-performance', [ReportController::class, 'sellerPerformance'])->name('seller-performance');
        Route::get('sellers/data', [ReportController::class, 'fetchSellerPerformanceData'])->name('sellers.data');
        Route::get('customer-insights', [ReportController::class, 'customerInsights'])->name('customer-insights');
        Route::get('customers/data', [ReportController::class, 'customerInsightsData'])->name('customers.data');
    });

    // Settings
    Route::prefix('settings')->name('admin.settings.')->group(function () {
        Route::get('general', [SettingController::class, 'general'])->name('general');
        Route::post('general/update', [SettingController::class, 'updateGeneral'])->name('general.update');
        Route::get('payments', [SettingController::class, 'payments'])->name('payments');
        Route::post('settings/payments', [SettingController::class, 'updatePayment'])->name('payments.update');
        Route::get('shipping', [SettingController::class, 'shipping'])->name('shipping');
    });

    // Roles & Admin Users
    Route::resource('roles', RoleController::class)->names('admin.roles');
    Route::post('roles/assign', [RoleController::class, 'assignRole'])->name('admin.roles.assign');
    Route::resource('users', AdminController::class)->names('admin.users');

    //trash
    Route::get('trash', [TrashController::class, 'index'])->name('admin.trash.index');
    Route::post('trash/restore/{type}/{id}', [TrashController::class, 'restore'])->name('admin.trash.restore');
    Route::delete('trash/delete/{type}/{id}', [TrashController::class, 'delete'])->name('admin.trash.delete');
    Route::post('trash/bulk', [TrashController::class, 'bulkAction'])->name('admin.trash.bulk');

    Route::prefix('orders')->group(function () {
        Route::post('/cancellations/{cancellation}/approve', [AdminOrderLifecycleController::class, 'approveCancellation']);
        Route::post('/cancellations/{cancellation}/reject', [AdminOrderLifecycleController::class, 'rejectCancellation']);
        Route::post('/cancellations/{cancellation}/complete', [AdminOrderLifecycleController::class, 'completeCancellation']);
        Route::post('/returns/{return}/approve', [AdminOrderLifecycleController::class, 'approveReturn']);
        Route::post('/returns/{return}/reject', [AdminOrderLifecycleController::class, 'rejectReturn']);
        Route::post('/replacements/{replacement}/approve', [AdminOrderLifecycleController::class, 'approveReplacement']);
        Route::post('/replacements/{replacement}/reject', [AdminOrderLifecycleController::class, 'rejectReplacement']);
        Route::post('/shipments/{shipment}/status', [AdminOrderLifecycleController::class, 'forceShipmentStatus']);
        Route::post('/shipments/{shipment}/settlement', [AdminOrderLifecycleController::class, 'releaseSettlement']);
    });
});

/*
|--------------------------------------------------------------------------
| Seller Panel (Protected by seller.auth)
|--------------------------------------------------------------------------
*/
Route::prefix('seller/{seller:slug}')->middleware('seller.auth')->group(function () {
    Route::get('dashboard', [SellerDashboardController::class, 'index'])->name('seller.dashboard');
    Route::get('products/search', [SellerProductController::class, 'search'])->name('seller.products.search');
    Route::get('add-products', [SellerProductController::class, 'create'])->name('seller.add.products');

    Route::get('/products/bulk-upload', [SellerProductController::class, 'bulkCreate'])->name('seller.products.bulk.create');

    Route::post('/products/bulk-upload', [SellerProductController::class, 'bulkStore'])->name('seller.products.bulk.store');

    Route::post('/products/update-price/{id}', [SellerProductController::class, 'updatePrice'])->name('seller.products.update-price');

    Route::post('/products/update-stock/{id}', [SellerProductController::class, 'updateStock'])->name('seller.products.update-stock');

    Route::post('/products/variant/toggle-featured/{id}', [SellerProductController::class, 'toggleFeatured'])->name('seller.products.toggle-featured');

    Route::get('/check-bank-details/{type}', [SellerProductController::class, 'checkBankDetails'])->name('seller.check.bank.details');

    Route::get('/bank-details/{type}', [SellerProductController::class, 'showBankDetailsForm'])->name('seller.bank.details.form');

    Route::post('bank-details/{type}', [SellerProductController::class, 'storeBankDetails'])->name('seller.bank.details.store');

    Route::resource('orders', SellerOrderController::class)->names('seller.orders');
    Route::post('ckeditor-image-upload', [SellerProductController::class, 'ckeditorImageUpload'])->name('seller.ckeditor-image-upload');
    Route::resource('products', SellerProductController::class)->names('seller.products');
    // Route::resource('payouts', SellerPayoutController::class)->names('seller.payouts');
    // Route::get('profile', [SellerProfileController::class, 'index'])->name('seller.profile');
    // Route::post('profile/update', [SellerProfileController::class, 'update'])->name('seller.profile.update');
    Route::get('support', [SellerSupportController::class, 'index'])->name('seller.support.index');
    Route::get('support/poll/{ticket}', [SellerSupportController::class, 'poll'])->name('seller.support.poll');
    Route::post('support/reply', [SellerSupportController::class, 'sendReply'])->name('seller.support.reply');
    Route::get('notifications', [NotificationController::class, 'sellerNotifications'])->name('seller.notifications');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllSellerRead'])->name('seller.notifications.mark-all-read');



    Route::get(
        '/bulk',
        [SellerBulkDashboardController::class, 'index']
    )->name('seller.bulk.dashboard');

    Route::prefix('bulk/template')
        ->name('seller.bulk.template.')
        ->group(function () {

            // TEMPLATE BUILDER PAGE
            Route::get(
                '/',
                [SellerBulkDashboardController::class, 'showWizard']
            )->name('builder');

            // GENERATE TEMPLATE
            Route::post(
                '/generate',
                [SellerBulkDashboardController::class, 'generateTemplate']
            )->name('generate');
        });

    Route::post(
        'bulk/subcategories',
        [SellerProductController::class, 'bulkSubcategories']
    )->name('seller.bulk.subcategories');

    Route::prefix('bulk')
        ->name('seller.bulk.')
        ->group(function () {

            Route::get(
                '/upload',
                [BulkUploadController::class, 'index']
            )->name('upload.index');

            Route::post(
                '/upload/process',
                [BulkUploadController::class, 'process']
            )->name('upload.process');

            Route::get(
                '/batches',
                [BulkUploadController::class, 'batches']
            )->name('batches.index');

            Route::get(
                '/batch/{batchId}',
                [BulkUploadController::class, 'review']
            )->name('batch.review');

            Route::post(
                '/batch/{productId}/approve',
                [BulkUploadController::class, 'approve']
            )->name('batch.approve');
            Route::post(
                '/batch/bulk/bulk-approve',
                [BulkUploadController::class, 'bulkApprove']
            )->name('batch.bulk-approve');
            Route::post(
                '/batch/{productId}/reject',
                [BulkUploadController::class, 'reject']
            )->name('batch.reject');

            Route::post(
                '/batch/{batchId}/commit',
                [BulkUploadController::class, 'commit']
            )->name('batch.commit');
        });

    Route::prefix('bulk/images')
        ->name('seller.bulk.images.')
        ->group(function () {
            Route::get(
                '/product/{productId}/details',
                [BulkImageController::class, 'productDetails']
            )->name('product.details');

            Route::post(
                '/ajax-upload',
                [BulkImageController::class, 'ajaxUpload']
            )->name('ajax.upload');

            Route::get(
                '/{batchId}',
                [BulkImageController::class, 'gateway']
            )->name('gateway');

            Route::get(
                '/zip-template/{batchId}',
                [BulkImageController::class, 'downloadZipTemplate']
            )->name('zip.template');

            Route::post(
                '/{batchId}/zip-upload',
                [BulkImageController::class, 'uploadZip']
            )->name('zip.upload');

            Route::get(
                '/{batchId}/manual',
                [BulkImageController::class, 'manual']
            )->name('manual');

            Route::post(
                '/{batchId}/manual-upload',
                [BulkImageController::class, 'manualUpload']
            )->name('manual.upload');

            Route::get(
                '/{batchId}/review',
                [BulkImageController::class, 'review']
            )->name('review');

            Route::post(
                '/{batchId}/commit',
                [BulkImageController::class, 'commitImages']
            )->name('commit');

            Route::post(
                '/{batchId}/skip',
                [BulkImageController::class, 'skipForNow']
            )->name('skip');
        });

    Route::prefix('orders')
        ->group(function () {
            Route::post(
                '/cancellations/{cancellation}/approve',
                [SellerOrderLifecycleController::class, 'approveCancellation']
            )->name('seller.orders.cancellations.approve');

            Route::post(
                '/cancellations/{cancellation}/reject',
                [SellerOrderLifecycleController::class, 'rejectCancellation']
            )->name('seller.orders.cancellations.reject');

            Route::post(
                '/returns/{return}/approve',
                [SellerOrderLifecycleController::class, 'approveReturn']
            )->name('seller.orders.returns.approve');

            Route::post(
                '/returns/{return}/reject',
                [SellerOrderLifecycleController::class, 'rejectReturn']
            )->name('seller.orders.returns.reject');

            Route::post(
                '/replacements/{replacement}/approve',
                [SellerOrderLifecycleController::class, 'approveReplacement']
            )->name('seller.orders.replacements.approve');

            Route::post(
                '/replacements/{replacement}/reject',
                [SellerOrderLifecycleController::class, 'rejectReplacement']
            )->name('seller.orders.replacements.reject');
        });
});



Route::get('product-categories/category-attributes/{category}', [ProductController::class, 'getCategoryAttributes'])->name('product-categories.attributes');




Route::get('/{master:slug}/{sectionType:slug}/{category:slug}', [PagesController::class, 'show'])->name('category.show');
Route::get('/category/{master}/{section}/{category}/products', [PagesController::class, 'loadTabProducts'])->name('category.tab.products');
Route::get('orders/view', [SellerOrderController::class, 'viewAction'])->name('orders');
