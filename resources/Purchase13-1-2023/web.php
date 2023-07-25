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

Route::get('/poreport', function () {
    return view('Transaction.purchase_order_receipt');    
});

Route::get('/checks', function () {
    return view('connection');    
});

Route::get('/clear', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    return "ok";
});

// Route::get('/', 'HomeController@check')->name('login');
Route::get('/',function (){
    return view('login-purchase');
});
Route::post('loginasuser','LoginController@loginasuser');

Route::get('/login/{username}/{pass}','LoginController@login');
Route::post('/logout','LoginController@logout')->name('logout');
Route::resource('/allitem', 'AllitemController');
Route::get('vendor-filter', 'itemfilterController@vendorfilter')->name('vendor-filter');
Route::get('category-filter', 'itemfilterController@categoryfilter')->name('category-filter');
Route::get('item-all-filter', 'itemfilterController@itemallfilter')->name('item-all-filter');
Route::get('date-filter', 'itemfilterController@datefilter')->name('date-filter');
Route::get('item-cat', 'ItemController@itemcat')->name('item-cat');
Route::get('items-filter', 'ItemController@itemsfilter')->name('items-filter');
Route::get('all-details-item/{id}', 'AllitemController@alldetailsitem')->name('all-details-item');
// Auth::routes(['register' => false]);

Route::get('/new_purchase', 'new_purchase_controller@new_purchase');
//Auth::routes();
// all
Route::get('/home', 'HomeController@index')->name('home');
//Route::resource('/itemrecord', 'ItemrecordsController');

// for Notification
Route::resource('/prch_Noti', 'PrchNotificationController');


// for Quotation

Route::get('vendor_form/{id}/{vid}/{pidnew}', 'QuotationReceivedController@VendorRFQFormData')->name('vendor_form');
Route::post('vendorformstore/{id}/{vid}', 'QuotationReceivedController@VendorRFQFormDataStore')->name('vendorformstore');
Route::get('po_accepts/{po_id}/{vid}', 'POSendToVendorsController@POAcceptsByVendor')->name('po_accepts');
Route::post('po_accepts_data/{po_id}/{vid}', 'POSendToVendorsController@POAcceptsByVendorDataStore')->name('po_accepts_data');
 Route::post('back-to-store/{id}', 'RequestForItemController@backtostore')->name('back-to-store');

 Route::get('mo-req-item', 'QuotationReceivedController@moreqitem')->name('mo-req-item');
 Route::get('m-send-item/{id}', 'QuotationReceivedController@msenditem')->name('m-send-item');
 Route::get('item-req/{id}', 'QuotationReceivedController@itemreq')->name('item-req');
 Route::get('po-sites/{id}/{site}', 'QuotationReceivedController@posites')->name('po-sites');
 Route::post('manage-site-item', 'QuotationReceivedController@managesiteitem')->name('manage-site-item');
 // vendore purchase Detail
 Route::get('pucharse-details', 'PurchaseDetailsController@pucharsedetails')->name('pucharse-details');
 Route::get('direct-to-site/{ids}', 'RequestForItemController@directtosite')->name('direct-to-site');


// Generate PO 
Route::get('generate_po', 'GeneratePOController@create')->name('generate_po');
Route::resource('/generate_po', 'GeneratePOController');
Route::get('company_full_detail', 'GeneratePOController@company_full_detail')->name('company_full_detail');
Route::get('company_sign_pics', 'GeneratePOController@company_sign_pics')->name('company_sign_pics');
Route::get('send_purchase_order/{id}', 'GeneratePOController@send_purchase_order');

Route::post('send_vendor', 'GeneratePOController@send_vendor')->name('send_vendor');
Route::post('item_details', 'GeneratePOController@item_details')->name('item_details');
Route::post('retrive_delivery_location', 'GeneratePOController@retrive_delivery_location')->name('retrive_delivery_location');
Route::get('/poreport', function () { 
    return view('Transaction.purchase_order_receipt');    
});

Route::post('send_mail', 'GeneratePOController@send_mail')->name('send_mail');
Route::post('update_PO/{id}', 'GeneratePOController@update_purchase_order');
Route::get('company_sign_pics_update', 'GeneratePOController@company_sign_pics_update')->name('company_sign_pics_update');
Route::get('pdf_download/{id}', 'GeneratePOController@download_pdf');
Route::get('test', 'GeneratePOController@test');


Route::get('/testpo', function () {
    return view('Generate_Purchase_Order.important');    
});

 
// Vendor Form
  
// Route::get('/quotation_form', 'transcation_controller@vendor_form');


/*Route::resource('quotation', 'QuotationController');
Route::get('export_quotation/{id}', 'QuotationController@export_quotation')->name('export_quotation');
Route::get('importExportView', 'QuotationController@importExportView');
Route::post('import', 'QuotationController@import')->name('import');*/


// access for roles
Route::group(['middleware' => ['role:purchase_admin']], function () {
    

    Route::get('quotation_received_levelone', 'QuotationReceivedController@QuotationReceivedAtLevelOne')->name('quotation_received_levelone');
    Route::get('qa_level_one/{id}', 'QuotationReceivedController@QuotationApprovalByLevelOne')->name('qa_level_one');
    Route::post('QuotationApprovalL1', 'QuotationReceivedController@QuotationApprovalByL1')->name('QuotationApprovalL1');

    Route::get('admin_request_quotation', 'transcation_controller@admin_request_show')->name('admin_approval');
    Route::get('check_admin_rfq/{id}', 'transcation_controller@check_admin_rfq')->name('check_admin_rfq');
    
    Route::resource('vendor_quotation','QuotationSendMailToVendorController');

    Route::get('create_quotation_excel', 'QuotationSendMailToVendorController@create_quotation_excel');

    Route::get('vendor_quotation_excel', 'QuotationSendMailToVendorController@vendor_quotation_excel');
    Route::post('items_details', 'QuotationSendMailToVendorController@item_details')->name('items_details');
    Route::post('vendore_company_email', 'QuotationSendMailToVendorController@vendore_company_email')->name('vendore_company_email');
    Route::get('quotation_pdf_download/{vendor_id}/{item_id}', 'QuotationSendMailToVendorController@Single_pdf_download');
    
    Route::post('/company_vendor_modal', 'QuotationSendMailToVendorController@company_vendor_modal');
    Route::post('/edit_vendor_quotation', 'QuotationSendMailToVendorController@edit_vendor_quotation');
    Route::post('/send_Quotation_mail', 'QuotationSendMailToVendorController@send_Quotation_mail');

    Route::resource('admin_view', RequestForItemAdminController::class);
    Route::post('/rfi_items_export', 'RequestForItemAdminController@rfi_items_export')->name('rfi_items_export');

    Route::post('/remove_reqitem_by_admin', 'RequestForItemAdminController@removereqitembyadmin')->name('remove_reqitem_by_admin');

    Route::post('/hold_reqitem_by_admin', 'RequestForItemAdminController@holdreqitembyadmin')->name('hold_reqitem_by_admin');

    Route::get('/purchase_reqitem_by_admin', 'RequestForItemAdminController@purchase_reqitem_by_admin')->name('purchase_reqitem_by_admin');
    Route::get('/export_items_excel/{prch_rfi_id}', 'RequestForItemAdminController@export_items_excel')->name('export_items_excel');

    Route::get('/export-users',[RequestForItemAdminController::class,'exportUsers'])->name('export-users');
    Route::get('/notificationTest', 'TestNotification@notify');
    Route::get('/newtestnoti', 'TestNotification@newtestnoti');
    Route::get('/newtiIndex', 'TestNotification@index');

});

Route::group(['middleware' => ['role:purchase_superadmin']], function(){
    Route::resource('vendor', 'VendorController');
        Route::resource('/um', 'UnitofmeasurementController');
        Route::resource('/role', 'RoleController');
        Route::resource('/category', 'ItemCategoryController');
        Route::resource('/warehouse', 'WarehouseController');
        Route::resource('/gst_state_code', 'GSTStateCodeController');
        Route::resource('/members', 'MemberController');
        Route::resource('/location', 'LocationController');
        Route::resource('item', 'ItemController');
        Route::resource('purchase', 'PurchaseController');
        Route::resource('company_side_name', 'CompanySideNameController');
        Route::resource('companys_name', 'CompanysNameController');
        Route::resource('ConsigneePersonDetails', 'ConsigneePersonDetailsController');
        Route::resource('teams', 'PurchaseTeamsController');

        Route::post('company_side_name_send', 'CompanySideNameController@store');
        Route::post('company_side_name_update/{id}', 'CompanySideNameController@update');
        Route::post('remove_req_purchase_order', 'PurchaseController@remove_req_purchase_order')->name('remove_req_purchase_order');
        Route::post('approve_req_purchase_order','PurchaseController@approve_req_purchase_order')->name('approve_req_purchase_order');

        Route::POST('filter', 'ItemController@filter')->name('filter');
        Route::get('export_pdf', 'ItemController@export_pdf')->name('export_pdf');
        Route::POST('excel_import', 'ItemController@excelImportItems')->name('excel_import');
        //04-09-2021 all item impotgistory
        Route::POST('excel_import_all', 'AllitemController@excelItemsall')->name('excel_import_all');
        // Route::POST('excel_import_new', 'ItemController@excelItemsnew')->name('excel_import_new');
        Route::get('excel_export', 'ItemController@excelItemsExport')->name('excel_export');
        Route::get('avhi-sheet', 'ItemController@abcderf')->name('avhi-sheet');
        Route::resource('/department', 'DepartmentController');
        Route::resource('/subcategory', 'BrandController');
        Route::post('/purchase/fetch', 'PurchaseController@fetch')->name('fetch');
        Route::post('/purchase/fetch_unit', 'PurchaseController@fetch_unit')->name('fetch_unit');
        Route::post('/purchase/updateQty', 'PurchaseController@updateQty')->name('updateQty');
        Route::get('/holdStatus', 'PurchaseController@holdStatus')->name('holdStatus');
        Route::get('invoice', 'PurchaseController@invoice')->name('invoice');
        Route::get('cartRestore', 'PurchaseController@cartRestore')->name('cartRestore');
        Route::get('generateInvoiceNumber', 'PurchaseController@generateInvoiceNumber')->name('generateInvoiceNumber');
        Route::resource('/item_purchase_history', 'ItemPurchaseHistoryController');
        Route::POST('date_filter', 'ItemPurchaseHistoryController@date_filter')->name('date_filter');
        Route::get('/unique_invoice/{id}/', 'ItemPurchaseHistoryController@show')->name('show');
        Route::get('purchase_history_pdf', 'ItemPurchaseHistoryController@purchase_history_pdf')->name('purchase_history_pdf');

        Route::get('items_approval', 'LevelTwo@LevelTwoApproval')->name('items_approval');
        Route::get('edit_leveltwo_approval/{id}', 'LevelTwo@EditLevelTwoApproval')->name('edit_leveltwo_approval');
        Route::post('discard-reason-admin/{id}', 'LevelTwo@discardreasonadmin')->name('discard-reason-admin');
    Route::put('update_leveltwo_approval/{id}', 'LevelTwo@UpdateLevelTwoApproval')->name('update_leveltwo_approval');

    Route::get('quotation_received_leveltwo', 'QuotationReceivedController@QuotationReceivedAtLevelTwo')->name('quotation_received_leveltwo');
    Route::get('qa_level_two/{id}', 'QuotationReceivedController@QuotationApprovalByLevelTwo')->name('qa_level_two');
    Route::post('QuotationApprovalL2', 'QuotationReceivedController@QuotationApprovalByL2')->name('QuotationApprovalL2');

     //filter on podetail
    Route::get('prchvendor', 'PurchaseDetailsController@prchvendor')->name('prchvendor');
    Route::get('prchsite', 'PurchaseDetailsController@prchsite')->name('prchsite');
    Route::post('pofilter', 'PurchaseDetailsController@pofilter')->name('pofilter');

});

Route::group(['middleware' => ['role:purchase_manager']], function () {
    
});

Route::group(['middleware' => ['role:purchase_user|purchase_manager']], function () {
    Route::resource('request_for_item', 'RequestForItemController');
    Route::post('/request_for_item/fetch', 'RequestForItemController@fetch')->name('fetch');
    Route::get('/item_of_stock', 'RequestForItemController@itemofstock')->name('item_of_stock');
    Route::get('/un_item_of_stock', 'RequestForItemController@unitemofstock')->name('un_item_of_stock');

    Route::resource('transcation', 'transcation_controller');
    Route::get('so_create', 'transcation_Controller@so_create');
    Route::get('oc_create', 'transcation_Controller@oc_create');
    Route::get('sc_create', 'transcation_Controller@sc_create');
    Route::get('inc_create', 'transcation_Controller@inc_create');
    Route::get('adhinc_create', 'transcation_Controller@adhinc_create');
    Route::get('quotation_manager', 'transcation_controller@request_qutation_manager');
    Route::get('check_users_rfq/{id}', 'transcation_controller@check_users_rfq')->name('check_users_rfq');
    Route::get('check_manager_rfq/{id}', 'transcation_controller@check_manager_rfq')->name('check_manager_rfq');
    Route::get('/remove_req_quo/{id}', 'transcation_controller@removerequestquotation')->name('remove_req_quo');
    Route::post('send_rfq_manager/{id}', 'transcation_controller@send_manager_rfq')->name('send_rfq_manager');
});


Route::group(['middleware' => ['role:purchase_accountant']], function () {
    Route::get('accountant_grr_index', 'GoodsReceivedNoteController@accountant_grr_index');
    Route::get('accountant_grr_view/{id}', 'GoodsReceivedNoteController@accountant_grr_view');
    Route::get('sendapprove/{id}', 'GoodsReceivedNoteController@sendapprove');
    Route::get('invoicedownloadaccountant/{id}', 'GoodsReceivedNoteController@invoicedownloadaccountant');
    Route::get('purchase_order_inform', 'PurchaseController@purchase_order_inform');
    Route::get('purchase_order_inform_download/{id}', 'PurchaseController@purchase_order_inform_download');
    Route::get('purchase_order_view/{id}', 'PurchaseController@purchase_order_view');

});

Route::group(['middleware' => ['role:purchase_user']], function () {
    Route::resource('GoodsReceivedNote', 'GoodsReceivedNoteController');
    Route::post('send_vendor_invoice', 'GoodsReceivedNoteController@send_vendor_invoice');
    Route::get('company_details', 'GoodsReceivedNoteController@company_details');
    Route::get('sendmanager/{id}', 'GoodsReceivedNoteController@sendmanager');
    Route::get('invoicedownload/{id}', 'GoodsReceivedNoteController@invoicedownload');
});

Route::group(['middleware' => ['role:purchase_manager']], function () {
    Route::resource('rfq', 'QuotationReceivedController');
    Route::get('user_request', 'RequestForItemController@UsersRequest')->name('user_request');
    Route::get('dispatch_item', 'RequestForItemController@dispatchitem')->name('dispatch_item');
    Route::get('showdisitem/{id}', 'RequestForItemController@showdisitem')->name('showdisitem');
    Route::get('dispatch_to_user/{id}', 'RequestForItemController@dispatchtouser')->name('dispatch_to_user');
    Route::get('up-rfi-le-one', 'RequestForItemController@uprfi_le_one')->name('up-rfi-le-one');
    Route::get('user_req_status/{id}', 'RequestForItemController@UsersRequestStatus')->name('user_req_status');
    Route::put('user_req_update/{id}', 'RequestForItemController@UsersRequestUpdate')->name('user_req_update');
    Route::get('applyforquotation/{id}', 'RequestForItemController@ApplyForQuotation')->name('applyforquotation');
    Route::post('rfiquotationtomail/{id}', 'RequestForItemController@RfiQuotationToMail')->name('rfiquotationtomail');

    Route::get('up-rfi-address', 'RequestForItemController@uprfiaddress')->name("up-rfi-address");
    Route::get('receivedQuotation/{id}', 'QuotationReceivedController@ReceivedQuotation')->name('receivedQuotation');
    Route::post('QuotationApproval', 'QuotationReceivedController@QuotationApproval')->name('QuotationApproval');
    Route::get('approval_quotation', 'QuotationReceivedController@ApprovalQuotation')->name('approval_quotation');
    Route::get('approvalQuotation_item/{id}', 'QuotationReceivedController@ApprovalQuotationItems')->name('approvalQuotation_item');
    Route::post('approvalQuotation_item_send/{id}/{rfi}', 'QuotationReceivedController@ApprovalQuotationItemSend')->name('approvalQuotation_item_send');

    Route::get('manager_request', 'RequestForItemController@ManagerRequest')->name('manager_request');
    Route::get('getstore_info', 'RequestForItemController@getstoreinfo')->name('getstore_info');
    Route::get('disable-to-dispatch', 'RequestForItemController@disabletodispatch')->name('disable-to-dispatch');
    Route::get('showdisbleForquo/{id}', 'RequestForItemController@showdisbleForquo')->name('showdisbleForquo');
    Route::get('check_users_rfi/{id}', 'RequestForItemController@CheckUsersRFI')->name('check_rfi');
    Route::post('/request_for_item/set_warehouse', 'RequestForItemController@SetWareHouse')->name('set_warehouse');
    Route::get('/managr-apv', 'RequestForItemController@managrapv')->name('managr-apv');
    // Route::get('/remove_reqitem/{id}', 'RequestForItemController@removereqitem')->name('remove_reqitem');
    // Route::post('/filter_dis_quo/{id}', 'RequestForItemController@filterdisquo')->name('filter_dis_quo');


    // Route::resource('manager_view', 'RequestForItemManagerController');
    Route::resource('manager_view', RequestForItemManagerController::class);
    Route::post('/remove_reqitem', 'RequestForItemManagerController@removereqitem')->name('remove_reqitem');
    Route::post('/hold_reqitem', 'RequestForItemManagerController@holdrequestitem')->name('hold_reqitem');
    Route::post('/filter_dis_quo/{id}', 'RequestForItemManagerController@filterdisquo')->name('filter_dis_quo');
   
    Route::get('edit_levelone_approval/{id}', 'LevelOne@LevelOneApproval')->name('edit_levelone_approval');
    Route::post('discard-reason/{id}', 'LevelOne@discardreason')->name('discard-reason');
    Route::put('update_levelone_approval/{id}', 'LevelOne@UpdateLevelOneApproval')->name('update_levelone_approval');
});

Route::group(['middleware' => ['role:store_admin|purchase_manager|purchase_superadmin|purchase_admin']], function () {
    Route::resource('store_item', 'store_inventory\StoreItemController');
    Route::post('update_qty', 'store_inventory\StoreItemController@update_qty')->name("update_qty");
});

Route::group(['middleware' => ['role:store_admin']], function () {
Route::resource('store_management', 'StoreManagementController');
Route::get('view_accepted_po/{id}', 'StoreManagementController@ViewAcceptedPO')->name("view_accepted_po");
Route::get('view-stored/{id}', 'StoreManagementController@viewstored')->name("view-stored");
Route::get('cs-item/{id}', 'StoreManagementController@csitem')->name("cs-item");
Route::get('view_grn', 'StoreManagementController@FetchAllGRN')->name("view_grn");
Route::get('add_grn', 'StoreManagementController@AddGRN')->name("add_grn");
// Route::get('upstock/{id}/{ids}', 'StoreManagementController@upstock')->name("upstock");
Route::post('upstock', 'StoreManagementController@upstock')->name("upstock");
});
Route::post('upwareqty', 'StoreManagementController@upwareqty')->name("upwareqty");
Route::get('get-ware-details', 'StoreManagementController@getwaredetails')->name("get-ware-details");




/*   Receivings   start   */

Route::get('receiving', 'receivings\ReceivingsController@index')->name('receiving');
Route::post('get_receiving_item', 'receivings\ReceivingsController@fetchItems')->name('get_receiving_item');
Route::post('receivings_item_save', 'receivings\ReceivingsController@store')->name('receivings_item_save');
Route::post('save_receiving_items', 'receivings\ReceivingsController@saveReceivingItems')->name('save_receiving_items');
Route::get('generate_dc', 'receivings\ReceivingsController@generateDC')->name('generate_dc');
Route::get('decline_dc/{id}', 'receivings\ReceivingsController@declineDC')->name('decline_dc');
Route::get('session_distroy', 'receivings\ReceivingsController@sessionDistroy')->name('session_distroy');
Route::post('remove_entry_session', 'receivings\ReceivingsController@remove_entry_session')->name('remove_entry_session');

Route::get('/receiving_chalan/{id}','receivings\chalanController@show');
Route::get('see_chalan/{id}', 'receivings\chalanController@show')->name('see_chalan');

Route::get('manage_transfer', 'receivings\ManagetransferController@index')->name('manage_transfer');
Route::get('site_item_req/{id}', 'receivings\ManagetransferController@sitereq')->name('site_item_req');
Route::get('freceiving/{id}', 'receivings\ManagetransferController@freceiving')->name('freceiving');
Route::get('back', 'receivings\chalanController@back')->name('back');

    /*----------Approve Stock Transfer---------*/
Route::get('approve_dc', 'receivings\ApproveTransferController@index')->name('approve_dc');
Route::get('admin_approve/{id}', 'receivings\ApproveTransferController@adminApprove')->name('admin_approve');
Route::get('super_admin_approve/{id}', 'receivings\ApproveTransferController@superAdminApprove')->name('super_admin_approve');
Route::get('decline_by_admins/{id}', 'receivings\ApproveTransferController@declineDC')->name('decline_by_admins');

/*   Receivings   end    */

/*--------------- User Module Start--------------------------------*/

Route::get('users', 'accoUserController@index')->name('users');
Route::post('user_add', 'accoUserController@userAdd')->name('user_add');
Route::get('edit_acco_user/{id}', 'accoUserController@editaccouser')->name('edit_acco_user');
Route::post('ac_siteuser_update/{id}', 'accoUserController@acsiteuserupdate')->name('ac_siteuser_update');
Route::get('delete_acco_user/{id}', 'accoUserController@deleteaccouser')->name('delete_acco_user');

/*--------------- User Module Start--------------------------------*/


/*$cat_id = 01;
$unit_id = 02;
$cat = str_pad($cat_id, 2, '0', STR_PAD_LEFT);
$unit = str_pad($unit_id, 2, '0', STR_PAD_LEFT);
$item = str_pad($cat_id, 4, '0', STR_PAD_LEFT);
echo $cat.$unit.$item;
//printf("%02d", $cat_id).printf("%02d", $unit_id).printf("%04d", $cat_id);*/