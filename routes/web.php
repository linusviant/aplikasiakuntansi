<?php

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

Route::get('/password/reset/{lang?}', 'Auth\LoginController@showLinkRequestForm')->name('change.langPass');

Auth::routes();

Route::get('/register/{lang?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::get('/login/{lang?}', 'Auth\LoginController@showLoginForm')->name('login');


Route::prefix('customer')->as('customer.')->group(
    function (){
        Route::get('login/{lang}', 'Auth\LoginController@showCustomerLoginLang')->name('login.lang')->middleware(['xss']);
        Route::get('login', 'Auth\LoginController@showCustomerLoginForm')->name('login')->middleware(['xss']);
        Route::post('login', 'Auth\LoginController@customerLogin')->name('login')->middleware(['xss']);
        Route::get('dashboard', 'CustomerController@dashboard')->name('dashboard')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );

        Route::get('invoice', 'InvoiceController@customerInvoice')->name('invoice')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
        Route::get('proposal', 'ProposalController@customerProposal')->name('proposal')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );

        Route::get('proposal/{id}/show', 'ProposalController@customerProposalShow')->name('proposal.show')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );

        Route::get('invoice/{id}/send', 'InvoiceController@customerInvoiceSend')->name('invoice.send')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
        Route::post('invoice/{id}/send/mail', 'InvoiceController@customerInvoiceSendMail')->name('invoice.send.mail')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );

        Route::get('invoice/{id}/show', 'InvoiceController@customerInvoiceShow')->name('invoice.show')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
        Route::get('payment', 'CustomerController@payment')->name('payment')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
        Route::get('transaction', 'CustomerController@transaction')->name('transaction')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
        Route::post('logout', 'CustomerController@customerLogout')->name('logout')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
        Route::get('profile', 'CustomerController@profile')->name('profile')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );

        Route::put('update-profile', 'CustomerController@editprofile')->name('update.profile')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
        Route::put('billing-info', 'CustomerController@editBilling')->name('update.billing.info')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
        Route::put('shipping-info', 'CustomerController@editShipping')->name('update.shipping.info')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
        Route::put('change.password', 'CustomerController@updatePassword')->name('update.password')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
        Route::get('change-language/{lang}', 'CustomerController@changeLanquage')->name('change.language')->middleware(
            [
                'auth:customer',
                'xss',
            ]
        );
    }
);

Route::prefix('vender')->as('vender.')->group(
    function (){
        Route::get('login/{lang}', 'Auth\LoginController@showVenderLoginLang')->name('login.lang')->middleware(['xss']);
        Route::get('login', 'Auth\LoginController@showVenderLoginForm')->name('login')->middleware(['xss']);
        Route::post('login', 'Auth\LoginController@VenderLogin')->name('login')->middleware(['xss']);
        Route::get('dashboard', 'VenderController@dashboard')->name('dashboard')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );
        Route::get('bill', 'BillController@VenderBill')->name('bill')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );
        Route::get('bill/{id}/show', 'BillController@venderBillShow')->name('bill.show')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );


        Route::get('bill/{id}/send', 'BillController@venderBillSend')->name('bill.send')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );
        Route::post('bill/{id}/send/mail', 'BillController@venderBillSendMail')->name('bill.send.mail')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );


        Route::get('payment', 'VenderController@payment')->name('payment')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );
        Route::get('transaction', 'VenderController@transaction')->name('transaction')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );
        Route::post('logout', 'VenderController@venderLogout')->name('logout')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );

        Route::get('profile', 'VenderController@profile')->name('profile')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );

        Route::put('update-profile', 'VenderController@editprofile')->name('update.profile')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );
        Route::put('billing-info', 'VenderController@editBilling')->name('update.billing.info')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );
        Route::put('shipping-info', 'VenderController@editShipping')->name('update.shipping.info')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );
        Route::put('change.password', 'VenderController@updatePassword')->name('update.password')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );
        Route::get('change-language/{lang}', 'VenderController@changeLanquage')->name('change.language')->middleware(
            [
                'auth:vender',
                'xss',
            ]
        );

    }
);


Route::get('/', 'DashboardController@index')->name('dashboard')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('user/{id}/plan', 'UserController@upgradePlan')->name('plan.upgrade')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('user/{id}/plan/{pid}', 'UserController@activePlan')->name('plan.active')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('profile', 'UserController@profile')->name('profile')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::put('edit-profile', 'UserController@editprofile')->name('update.account')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('users', 'UserController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::put('change-password', 'UserController@updatePassword')->name('update.password');


Route::resource('roles', 'RoleController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('permissions', 'PermissionController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){
    Route::get('change-language/{lang}', 'LanguageController@changeLanquage')->name('change.language');
    Route::get('manage-language/{lang}', 'LanguageController@manageLanguage')->name('manage.language');
    Route::post('store-language-data/{lang}', 'LanguageController@storeLanguageData')->name('store.language.data');
    Route::get('create-language', 'LanguageController@createLanguage')->name('create.language');
    Route::post('store-language', 'LanguageController@storeLanguage')->name('store.language');
}
);

Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::resource('systems', 'SystemController');
    Route::post('email-settings', 'SystemController@saveEmailSettings')->name('email.settings');
    Route::post('company-settings', 'SystemController@saveCompanySettings')->name('company.settings');
    Route::post('stripe-settings', 'SystemController@saveStripeSettings')->name('stripe.settings');
    Route::post('system-settings', 'SystemController@saveSystemSettings')->name('system.settings');
    Route::get('company-setting', 'SystemController@companyIndex')->name('company.setting');
    Route::post('business-setting', 'SystemController@saveBusinessSettings')->name('business.setting');
}
);


Route::get('productservice/index', 'ProductServiceController@index')->name('productservice.index');
Route::resource('productservice', 'ProductServiceController')->middleware(
    [
        'auth',
        'xss',
    ]
);


Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::get('customer/{id}/show', 'CustomerController@show')->name('customer.show');
    Route::resource('customer', 'CustomerController');

}
);
Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::get('vender/{id}/show', 'VenderController@show')->name('vender.show');
    Route::resource('vender', 'VenderController');

}
);

Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::resource('bank-account', 'BankAccountController');

}
);
Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::get('transfer/index', 'TransferController@index')->name('transfer.index');
    Route::resource('transfer', 'TransferController');

}
);
Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::get('transaction/index', 'TransactionController@index')->name('transaction.index');
    Route::resource('transaction', 'TransactionController');

}
);


Route::resource('taxes', 'TaxController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('product-category', 'ProductServiceCategoryController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('product-unit', 'ProductServiceUnitController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('payment-method', 'PaymentMethodController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::get('invoice/pdf/{id}', 'InvoiceController@invoice')->name('invoice.pdf')->middleware(
    [
        'xss',
    ]
);
Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){


    Route::get('invoice/{id}/duplicate', 'InvoiceController@duplicate')->name('invoice.duplicate');
    Route::get('invoice/{id}/shipping/print', 'InvoiceController@shippingDisplay')->name('invoice.shipping.print');
    Route::get('invoice/{id}/payment/reminder', 'InvoiceController@paymentReminder')->name('invoice.payment.reminder');
    Route::get('invoice/index', 'InvoiceController@index')->name('invoice.index');
    Route::post('invoice/product/destroy', 'InvoiceController@productDestroy')->name('invoice.product.destroy');
    Route::post('invoice/product', 'InvoiceController@product')->name('invoice.product');
    Route::post('invoice/customer', 'InvoiceController@customer')->name('invoice.customer');
    Route::get('invoice/{id}/sent', 'InvoiceController@sent')->name('invoice.sent');
    Route::get('invoice/{id}/payment', 'InvoiceController@payment')->name('invoice.payment');
    Route::post('invoice/{id}/payment', 'InvoiceController@createPayment')->name('invoice.payment');
    Route::post('invoice/{id}/payment/{pid}/destroy', 'InvoiceController@paymentDestroy')->name('invoice.payment.destroy');
    Route::resource('invoice', 'InvoiceController');

}
);

Route::get(
    '/invoices/preview/{template}/{color}', [
                                              'as' => 'invoice.preview',
                                              'uses' => 'InvoiceController@previewInvoice',
                                          ]
);
Route::post(
    '/invoices/template/setting', [
                                    'as' => 'template.setting',
                                    'uses' => 'InvoiceController@saveTemplateSettings',
                                ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){


    Route::get('credit-note', 'CreditNoteController@index')->name('credit.note');
    Route::get('custom-credit-note', 'CreditNoteController@customCreate')->name('invoice.custom.credit.note');
    Route::post('custom-credit-note', 'CreditNoteController@customStore')->name('invoice.custom.credit.note');
    Route::get('credit-note/invoice', 'CreditNoteController@getinvoice')->name('invoice.get');
    Route::get('invoice/{id}/credit-note', 'CreditNoteController@create')->name('invoice.credit.note');
    Route::post('invoice/{id}/credit-note', 'CreditNoteController@store')->name('invoice.credit.note');
    Route::get('invoice/{id}/credit-note/edit/{cn_id}', 'CreditNoteController@edit')->name('invoice.edit.credit.note');
    Route::put('invoice/{id}/credit-note/edit/{cn_id}', 'CreditNoteController@update')->name('invoice.edit.credit.note');
    Route::delete('invoice/{id}/credit-note/delete/{cn_id}', 'CreditNoteController@destroy')->name('invoice.delete.credit.note');

}
);

Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){


    Route::get('debit-note', 'DebitNoteController@index')->name('debit.note');
    Route::get('custom-debit-note', 'DebitNoteController@customCreate')->name('bill.custom.debit.note');
    Route::post('custom-debit-note', 'DebitNoteController@customStore')->name('bill.custom.debit.note');
    Route::get('debit-note/bill', 'DebitNoteController@getbill')->name('bill.get');
    Route::get('bill/{id}/debit-note', 'DebitNoteController@create')->name('bill.debit.note');
    Route::post('bill/{id}/debit-note', 'DebitNoteController@store')->name('bill.debit.note');
    Route::get('bill/{id}/debit-note/edit/{cn_id}', 'DebitNoteController@edit')->name('bill.edit.debit.note');
    Route::put('bill/{id}/debit-note/edit/{cn_id}', 'DebitNoteController@update')->name('bill.edit.debit.note');
    Route::delete('bill/{id}/debit-note/delete/{cn_id}', 'DebitNoteController@destroy')->name('bill.delete.debit.note');

}
);


Route::get(
    '/bill/preview/{template}/{color}', [
                                          'as' => 'bill.preview',
                                          'uses' => 'BillController@previewBill',
                                      ]
);
Route::post(
    '/bill/template/setting', [
                                'as' => 'bill.template.setting',
                                'uses' => 'BillController@saveBillTemplateSettings',
                            ]
);

Route::resource('taxes', 'TaxController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::get('revenue/index', 'RevenueController@index')->name('revenue.index')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('revenue', 'RevenueController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::get('bill/pdf/{id}', 'BillController@bill')->name('bill.pdf')->middleware(
    [
        'xss',
    ]
);
Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::get('bill/{id}/duplicate', 'BillController@duplicate')->name('bill.duplicate');
    Route::get('bill/{id}/shipping/print', 'BillController@shippingDisplay')->name('bill.shipping.print');
    Route::get('bill/index', 'BillController@index')->name('bill.index');
    Route::post('bill/product/destroy', 'BillController@productDestroy')->name('bill.product.destroy');
    Route::post('bill/product', 'BillController@product')->name('bill.product');
    Route::post('bill/vender', 'BillController@vender')->name('bill.vender');
    Route::get('bill/{id}/sent', 'BillController@sent')->name('bill.sent');
    Route::get('bill/{id}/payment', 'BillController@payment')->name('bill.payment');
    Route::post('bill/{id}/payment', 'BillController@createPayment')->name('bill.payment');
    Route::post('bill/{id}/payment/{pid}/destroy', 'BillController@paymentDestroy')->name('bill.payment.destroy');

    Route::resource('bill', 'BillController');

}
);


Route::get('payment/index', 'PaymentController@index')->name('payment.index')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('payment', 'PaymentController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::resource('income-summary', 'IncomeSummaryController');

}
);

Route::resource('plans', 'PlanController')->middleware(
    [
        'auth',
        'xss',
    ]
);


Route::resource('expenses', 'ExpenseController')->middleware(
    [
        'auth',
        'xss',
    ]
);


Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::get('/orders', 'StripePaymentController@index')->name('order.index');
    Route::get('/stripe/{code}', 'StripePaymentController@stripe')->name('stripe');
    Route::post('/stripe', 'StripePaymentController@stripePost')->name('stripe.post');

}
);
Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::get('report/income-summary', 'ReportController@incomeSummary')->name('report.income.summary');
    Route::get('report/expense-summary', 'ReportController@expenseSummary')->name('report.expense.summary');
    Route::get('report/income-vs-expense-summary', 'ReportController@incomeVsExpenseSummary')->name('report.income.vs.expense.summary');
    Route::get('report/tax-summary', 'ReportController@taxSummary')->name('report.tax.summary');
    Route::get('report/profit-loss-summary', 'ReportController@profitLossSummary')->name('report.profit.loss.summary');

    Route::get('report/invoice-summary', 'ReportController@invoiceSummary')->name('report.invoice.summary');
    Route::get('report/bill-summary', 'ReportController@billSummary')->name('report.bill.summary');

    Route::get('report/invoice-report', 'ReportController@invoiceReport')->name('report.invoice');
    Route::get('report/account-statement-report', 'ReportController@accountStatement')->name('report.account.statement');
}
);

Route::resource('coupons', 'CouponController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::get('proposal/pdf/{id}', 'ProposalController@proposal')->name('proposal.pdf')->middleware(
    [
        'xss',
    ]
);
Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ], function (){

    Route::get('proposal/{id}/status/change', 'ProposalController@statusChange')->name('proposal.status.change');
    Route::get('proposal/{id}/convert', 'ProposalController@convert')->name('proposal.convert');
    Route::get('proposal/{id}/duplicate', 'ProposalController@duplicate')->name('proposal.duplicate');
    Route::post('proposal/product/destroy', 'ProposalController@productDestroy')->name('proposal.product.destroy');
    Route::post('proposal/customer', 'ProposalController@customer')->name('proposal.customer');
    Route::post('proposal/product', 'ProposalController@product')->name('proposal.product');
    Route::get('proposal/{id}/sent', 'ProposalController@sent')->name('proposal.sent');
    Route::resource('proposal', 'ProposalController');

}
);

Route::get(
    '/proposal/preview/{template}/{color}', [
                                              'as' => 'proposal.preview',
                                              'uses' => 'ProposalController@previewProposal',
                                          ]
);
Route::post(
    '/proposal/template/setting', [
                                    'as' => 'proposal.template.setting',
                                    'uses' => 'ProposalController@saveProposalTemplateSettings',
                                ]
);

Route::resource('goal', 'GoalController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('account-assets', 'AssetController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('custom-field', 'CustomFieldController')->middleware(
    [
        'auth',
        'xss',
    ]
);
