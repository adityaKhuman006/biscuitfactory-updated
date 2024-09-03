<?php

use App\Http\Controllers\materialController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::get('/', [materialController::class, 'index'])->name('index');
Route::get('select-category', [materialController::class, 'selectCategory'])->name('select.category');

Route::get('admin', [materialController::class, 'admin'])->name('admin');
// Route::post('/create', [materialController::class, 'create'])->name('create');

Route::post('/product-add', [materialController::class, 'productAdd'])->name('product.add');
Route::get('/production', [materialController::class, 'production'])->name('production');
Route::post('/production-add', [materialController::class, 'productionAdd'])->name('production.add');

Route::get('/create', [materialController::class, 'create'])->name('create');

// Route::get('/products-fatch', [materialController::class, 'index'])->name('products.fatch');
Route::get('/product/edit/{id}', [materialController::class, 'edit'])->name('product.edit');

Route::get('/choose', [materialController::class, 'choose'])->name('choose');
Route::get('/rep', [materialController::class, 'rep'])->name('rep');
Route::get('/view', [materialController::class, 'view'])->name('view');
Route::post('/product-update', [materialController::class, 'productUpdate'])->name('product.update');
Route::post('get-production-data', [materialController::class, 'getProductionData'])->name('get.production.data');
Route::post('get-material', [materialController::class, 'getMaterial'])->name('get.material');
Route::get('/security', [materialController::class, 'security'])->name('security');
// Route::get('/raw-material-out', [materialController::class, 'finishedgoodOut'])->name('finishedgood.out');



// raw-material
Route::get('/raw-material-in', [materialController::class, 'RawMaterialIn'])->name('raw.material.in');
Route::get('/raw-material-out', [materialController::class, 'RawMaterialOut'])->name('raw.material.out');
Route::post('/raw-material-create', [materialController::class, 'RawMaterialCreate'])->name('raw.material.create');
Route::post('/raw-material-create-out', [materialController::class, 'RawMaterialCreateOut'])->name('raw.material.create.out');

// Packing-material
Route::get('/packing-material-in', [materialController::class, 'PackingMaterialIn'])->name('packing.material.in');
Route::get('/packing-material-out', [materialController::class, 'PackingMaterialOut'])->name('packing.material.out');
Route::post('/Packing-material-create', [materialController::class, 'PackingMaterialCreate'])->name('packing.material.create');
Route::post('/Packing-material-create-out', [materialController::class, 'PackingMaterialCreateOut'])->name('packing.material.create.out');

// machinery-material
Route::get('/machinery-material-in', [materialController::class, 'machineryMaterialIn'])->name('machinery.material.in');
Route::get('/machinery-material-out', [materialController::class, 'machineryMaterialOut'])->name('machinery.material.out');
Route::post('/machinery-material-create', [materialController::class, 'machineryMaterialCreate'])->name('machinery.material.create');
Route::post('/machinery-material-create-out', [materialController::class, 'machineryMaterialCreateOut'])->name('machinery.material.create.out');

// finishedgood-material
Route::get('/finished-good-in', [materialController::class, 'finishedgoodMaterialIn'])->name('finishedgood.material.in');
Route::get('/finished-good-out', [materialController::class, 'finishedgoodMaterialOut'])->name('finishedgood.material.out');
Route::post('/finishedgood-material-create', [materialController::class, 'finishedgoodMaterialCreate'])->name('finishedgood.material.create');
Route::post('/finishedgood-material-create-out', [materialController::class, 'finishedgoodMaterialCreateOut'])->name('finishedgood.material.create.out');


Route::get('/product-master', [materialController::class, 'productMaster'])->name('product.master');
Route::post('update-product-name', [materialController::class, 'updateproductName'])->name('update.product.name');
Route::post('update-type', [materialController::class, 'updatetype'])->name('update.type');
Route::post('update-uom', [materialController::class, 'updateuom'])->name('update.uom');
Route::post('update-packing', [materialController::class, 'updatepacking'])->name('update.packing');
Route::post('update-remark', [materialController::class, 'updateremark'])->name('update.remark');


Route::get('/master-type', [materialController::class, 'masterType'])->name('master.type');
Route::post('/master-type-create', [materialController::class, 'masterTypeCreate'])->name('master.type.create');
Route::post('update-type-name', [materialController::class, 'updatetypeName'])->name('update.type.name');
Route::post('update-rm', [materialController::class, 'updaterm'])->name('update.rm');
Route::post('delete-type', [materialController::class, 'deleteType'])->name('delete.type');



Route::get('master-company', [materialController::class, 'masterCompany'])->name('master.company');
Route::get('master-uom', [materialController::class, 'masterUom'])->name('master.uom');
Route::post('master-company-create', [materialController::class, 'masterCompanyCreate'])->name('master.company.create');
Route::post('update-company-name', [materialController::class, 'updateCompanyName'])->name('update.company.name');
Route::post('delete-company', [materialController::class, 'deleteCompanyRecord'])->name('delete.company');


Route::get('master-account', [materialController::class, 'masterAccount'])->name('master.account');
Route::post('master-account-create', [materialController::class, 'masterAccountCreate'])->name('master.account.create');
Route::post('update-account-name', [materialController::class, 'updateAccountName'])->name('update.account.name');
Route::post('update-account-address', [materialController::class, 'updateAccountAddress'])->name('update.account.address');
Route::post('update-account-type', [materialController::class, 'updateAccountType'])->name('update.account.type');
Route::post('delete-account', [materialController::class, 'deleteAccount'])->name('delete.account');


Route::get('master-brand', [materialController::class, 'masterBrand'])->name('master.brand');
Route::post('master-brand-create', [materialController::class, 'masterBrandCreate'])->name('master.brand.create');
Route::post('update-brand-name', [materialController::class, 'updateBrandName'])->name('update.brand.name');
Route::post('update-brand-type', [materialController::class, 'updatebrandtype'])->name('update.brand.type');
Route::post('update-brand-owner', [materialController::class, 'updateBrandOwner'])->name('update.brand.owner');
Route::post('delete-brand', [materialController::class, 'deletebrand'])->name('delete.brand');


Route::get('master-employe', [materialController::class, 'masterEmploye'])->name('master.employe');
Route::post('master-employe-create', [materialController::class, 'masterEmployeCreate'])->name('master.employe.create');
Route::post('update-employe-name', [materialController::class, 'updateEmployeName'])->name('update.employe.name');
Route::post('delete-employe-master', [materialController::class, 'deleteEmployeMaster'])->name('delete.employe.master');

Route::get('master-biscuit', [materialController::class, 'masterBiscuit'])->name('master.biscuit');
Route::post('master-biscuit-create', [materialController::class, 'masterBiscuitCreate'])->name('master.biscuite.create');
Route::post('update-biscuite-name', [materialController::class, 'updateBiscuitName'])->name('update.biscuite.name');
Route::post('update-biscuite-img', [materialController::class, 'updateBiscuitImg'])->name('update.biscuite.img');
Route::post('delete-biscuite-master', [materialController::class, 'deletebiscuiteMaster'])->name('delete.biscuite.master');

Route::get('pack-masters', [materialController::class, 'packMasters'])->name('pack.masters');
Route::post('pack-masters-create', [materialController::class, 'packMastersCreate'])->name('pack.masters.create');
Route::post('pack-masters-delete', [materialController::class, 'packMastersDelete'])->name('pack.masters.delete');

Route::get('pack-masters-update/{id}',[materialController::class,'packMastersUpdate'])->name('pack.masters.update');
Route::post('pack-masters-edit',[materialController::class,'packMastersEdit'])->name('pack.masters.edit');






Route::get('/transfer-material', [materialController::class, 'transferMaterial'])->name('transfer.material');
Route::post('/transfer-material-create', [materialController::class, 'transferMaterialCreate'])->name('transfer.material.create');
Route::post('/transfer-Reaport-Data', [materialController::class, 'transferReaportData'])->name('transfer.Reaport.Data');

Route::post('update-material-name', [materialController::class, 'updateMaterialName'])->name('update.material.name');
Route::post('update-material-weight', [materialController::class, 'updateMaterialWeight'])->name('update.material.weight');
Route::post('update-material-uom', [materialController::class, 'updateMaterialUom'])->name('update.material.uom');
Route::post('update-material-delete', [materialController::class, 'updateMaterialDelete'])->name('update.material.delete');

Route::get('/transfer-reaport', [materialController::class, 'transferReaport'])->name('transfer.reaport');


Route::post('/out-raw-fatch', [materialController::class, 'outRawFatch'])->name('out.raw.fatch');
Route::post('/out-get-fatch', [materialController::class, 'outGetFatch'])->name('out.get.fatch');


Route::post('/in-raw-fatch', [materialController::class, 'inRawFatch'])->name('in.raw.fatch');
Route::post('/in-get-fatch', [materialController::class, 'inGetFatch'])->name('in.get.fatch');



Route::get('/in-out-stock', [materialController::class, 'inOutStock'])->name('in.out.stock');
Route::post('/in-out-Stock-Data', [materialController::class, 'inOutStockData'])->name('in.out.stock.data');
Route::post('/in-out-Stock-fatch', [materialController::class, 'inOutStockfatch'])->name('in.out.stock.fatch');
Route::post('/in-out-stock-rendar', [materialController::class, 'inOutStockRendar'])->name('in.out.stock.rendar');


Route::post('master-uom-create', [materialController::class, 'masterUomCreate'])->name('master.uom.create');
Route::post('update-uom', [materialController::class, 'updateUom'])->name('update.uom');
Route::post('delete-uom', [materialController::class, 'deleteUom'])->name('delete.uom');

Route::get('master-items', [materialController::class, 'masterItem'])->name('master.items');
Route::post('update-items', [materialController::class, 'updateItems'])->name('update.items');
Route::post('delete-items', [materialController::class, 'deleteItems'])->name('delete.items');

Route::post('delete-product', [materialController::class, 'deleteProduct'])->name('delete.product');




Route::get('order-create', [materialController::class, 'OrderCreate'])->name('Order.Create');
Route::post('order-create-add', [materialController::class, 'OrderCreateAdd'])->name('Order.Create.add');
Route::post('order-create-delete', [materialController::class, 'OrderCreateDelete'])->name('Order.Create.Delete');

Route::get('order-create-update/{id}',[materialController::class,'OrderCreateUpdate'])->name('order.create.update');
Route::post('order-create-edit',[materialController::class,'OrderCreateEdit'])->name('order.create.edit');
Route::post('order-render', [materialController::class, 'OrderRender'])->name('Order.Render');

Route::post('master-product-create', [materialController::class, 'productMasterCreate'])->name('product.master.create');
Route::get('product-edit/{id}', [materialController::class, 'productEdit'])->name('product.edit');

Route::post('get-data-by-date', [materialController::class, 'getDataByDate'])->name('get.data.by.date');
Route::post('master-items-create', [materialController::class, 'masterItemsCreate'])->name('master.items.create');
Route::post('update-product-items', [materialController::class, 'updateProductItems'])->name('update.product.items');
Route::post('product-items-delete', [materialController::class, 'productItemsDelete'])->name('product.items.delete');

Route::get('/getin', [materialController::class, 'getin'])->name('getin');
Route::post('get-in-create', [materialController::class, 'getInCreate'])->name('get.in.create');

Route::get('/getout', [materialController::class, 'getout'])->name('getout');
Route::post('get-out-create', [materialController::class, 'getOutCreate'])->name('get.out.create');

Route::get('/get-in-view', [materialController::class, 'getInView'])->name('get.in.view');
Route::get('/get-out-view', [materialController::class, 'getOutView'])->name('get.out.view');

Route::get('/migrate',function (){
    Artisan::call('migrate');
});



// Route::get('/main-Order', [materialController::class, 'mainOrder'])->name('mainOrder');
// Route::post('/main-Order-create', [materialController::class, 'mainOrderCreate'])->name('main.Order.Create');

// Route::get('orders/{id}/edit', [materialController::class, 'editOrder'])->name('Order.edit');
// Route::put('orders/{id}', [materialController::class, 'updateOrder'])->name('Order.update');
