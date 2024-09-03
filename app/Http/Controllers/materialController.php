<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\BiscuitMaster;
use App\Models\BrandMaster;
use App\Models\EmployeMaster;
use App\Models\getIn;
use App\Models\getInItem;
use App\Models\getOut;
use App\Models\getOutItem;
// use App\Models\inwardRawFinishedgood;
// use App\Models\inwardRawFinishedgoodItem;
// use App\Models\inwardRawMachinery;
// use App\Models\inwardRawMachineryItem;
// use App\Models\inwardRawMaterial;
// use App\Models\inwardRawMaterialItem;
// use App\Models\inwardRawPacking;
// use App\Models\inwardRawPackingItem;
use App\Models\itemsMaster;
use App\Models\mainOrder;
use App\Models\mainOrderItem;
use App\Models\masterAccount;
use App\Models\masterCompany;
use App\Models\masterProduct;
use App\Models\material;
use App\Models\Order;
use App\Models\OrderProduct;
// use App\Models\outwardFinishedgoodMaterial;
// use App\Models\outwardFinishedgoodMaterialItem;
// use App\Models\outwardMachineryMaterial;
// use App\Models\outwardMachineryMaterialItem;
// use App\Models\outwardPackingMaterial;
// use App\Models\outwardPackingMaterialItem;
// use App\Models\outwardRawMaterial;
// use App\Models\outwardRawMaterialItem;
use App\Models\PackMaster;
use App\Models\Product;
use App\Models\ProductItems;
use App\Models\ProductMaster;
use App\Models\transferMaterial;
use App\Models\transferMaterialItem;
use App\Models\TypeMaster;
use App\Models\UomMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Tests\Mail\MailableStub;

class materialController extends Controller
{
    function index(Request $request)
    {
        return view('home');
    }

    public function admin(Request $request)
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('index', ['products' => $products]);
    }

    public function selectCategory(Request $request)
    {
        return view('select-category');
    }

    public function productAdd(Request $request)
    {
        // Validation rules for product
        $productRules = [
            'product_name' => 'required|string|max:255',
            'batch_size' => 'required|numeric',
            'batch_required' => 'required|numeric',
            'product_id' => 'nullable|exists:products,id',
        ];
        $validatedData = $request->validate($productRules);

        $product = Product::create([
            'product_name' => $request->input('product_name'),
            'batch_size' => $request->input('batch_size'),
            'batch_required' => $request->input('batch_required'),
        ]);

        // Retrieve the product ID
        $productId = $product->id;

        // // Get the items from the request
        $data = $request->all();
        $items = $data['category-group'] ?? [];

        foreach ($items as $item) {
            if (!empty($item['item_id']) && !empty($item['recipie_weight']) && !empty($item['umd'])) {

                $masterProduct = MasterProduct::where('product_name', $item['item_id'])->first();

                Material::create([
                    'product_id' => $productId,
                    'item_id' => $masterProduct->id,
                    'recipie_weight' => $item['recipie_weight'],
                    'umd' => $item['umd'],
                ]);
            }
        }

        return redirect()->route('admin');
    }

    public function ProductFatch(Request $request)
    {
        $materials = Material::all();
        $products = Product::all();
        return view('products.fatch', ['products' => $products], compact('materials'));
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        $materials = Material::where('product_id', $id)->get();
        return view('product-edit', compact('product', 'materials'));
    }

    function production(Request $request)
    {
        $materials = Material::with('getItem')->get();
        $product = Product::all();
        return view('production', compact('materials', 'product'));
    }

    function productionAdd(Request $request)
    {
        // Retrieve all the input data
        $data = $request->all();
        foreach ($data['material_id'] as $materialId) {
            $actualWeightKey = 'actual_weight_' . $materialId;
            Material::where('id', $materialId)->update([
                'actual_weight' => $data[$actualWeightKey],
            ]);
        }

        foreach ($data['material_id'] as $key => $materialId) {
            $actualWeightKey = 'actual_weight_' . $materialId;
            $batchNumber = $data['batch_number'] ?? 1;
            Batch::create([
                'product_id' => $data['product_id'],
                'material_id' => $materialId,
                'item_id' => $data['item_id'][$key],
                'actual_weight' => $data[$actualWeightKey],
                'batch_number' => $batchNumber + 1,
                'date' => $data['date'],
                'time' => $data['time'],
            ]);
        }

        return redirect()->route('production');
    }

    function choose(Request $request)
    {
        $materials = Material::all();
        return view('choose', compact('materials'));
    }

    function rep(Request $request)
    {
        $products = Batch::with(['getProduct', 'getMaterial'])
            ->groupBy('product_id')
            ->get();

        $productMaster = Product::all();

        return view('rep', compact('products', 'productMaster'));
    }

    function create(Request $request)
    {
        $UOM = UomMaster::all();
        $raw = masterProduct::all();
        $materials = Material::all();
        return view('create', compact('materials', 'raw', 'UOM'));
    }

    public function getProductionData(Request $request)
    {
        $id = $request->id;
        $product = Product::where('id', $id)->first();
        $materials = Material::where('product_id', $id)->get();

        $batch = Batch::where('product_id', $id)
            ->orderBy('batch_number', 'desc')
            ->first();

        $batchNumber = $batch ? (int)$batch->batch_number : 0;

        if ($batchNumber == 0) {
            $batchNumber = 1;
        }

        $html = view('production-data', compact('product', 'materials', 'batchNumber'))->render();

        return response()->json([
            "html" => $html
        ]);
    }

    public function getMaterial(Request $request)
    {
        $materials = Batch::with(['getProduct', 'getMaterial'])
            ->where('product_id', $request->productId)
            ->where('batch_number', $request->batchId)
            ->get();
        $html = view('material-data', compact('materials'))->render();
        return response()->json([
            'html' => $html,
        ]);
    }

    // raw matiriyal -------------------------------------------------------------------

    public function RawMaterialIn(Request $request)
    {
        $UOM = UomMaster::all();
        $raw = masterProduct::all();
        $company = masterCompany::all();
        return view('raw-material-in', compact('raw', 'company', 'UOM'));
    }

    public function RawMaterialOut()
    {
        $UOM = UomMaster::all();
        $raw = masterProduct::all();
        $company = masterCompany::all();
        return view('raw-material-out', compact('raw', 'company', 'UOM'));
    }

    // public function RawMaterialCreate(Request $request)
    // {
    //     $originalFile = '';
    //     if ($request->hasFile('img')) {
    //         $file = $request->file('img');
    //         $destinationPath = 'public/img/';
    //         $originalFile = $file->getClientOriginalName();
    //         $file->move($destinationPath, $originalFile);
    //     }

    //     $inwardRawMaterial = inwardRawMaterial::create([
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'compaey_name' => $request->compaey_name,
    //         'location' => $request->location,
    //         'inv_challan_number' => $request->inv_challan_number,
    //         'inv_challan_date' => $request->inv_challan_date,
    //         'vehicle_number' => $request->vehicle_number,
    //         'mobile' => $request->mobile,
    //         'img' => $originalFile,
    //     ]);


    //     $data = $request->all();
    //     $items = $data['category-group'] ?? [];


    //     foreach ($items as $itemAdd) {
    //         if (isset($itemAdd['item'], $itemAdd['quantity'], $itemAdd['uom'], $itemAdd['rate'], $itemAdd['amount'], $itemAdd['remark']) && !empty($itemAdd['item']) && !empty($itemAdd['quantity']) && !empty($itemAdd['uom']) && !empty($itemAdd['rate']) && !empty($itemAdd['amount']) && !empty($itemAdd['remark'])) {

    //             $masterProduct = MasterProduct::where('product_name', $itemAdd['item'])->first();

    //             inwardRawMaterialItem::create([
    //                 'material_id' => $inwardRawMaterial->id,
    //                 'item' => $itemAdd['item'],
    //                 'item_id' => $masterProduct->id,
    //                 'quantity' => $itemAdd['quantity'],
    //                 'uom' => $itemAdd['uom'],
    //                 'rate' => $itemAdd['rate'],
    //                 'amount' => $itemAdd['amount'],
    //                 'remark' => $itemAdd['remark'],

    //             ]);
    //         }
    //     }
    //     return response()->json([]);
    // }

    // public function RawMaterialCreateOut(Request $request)
    // {
    //     $originalFile = '';
    //     if ($request->hasFile('img')) {
    //         $file = $request->file('img');
    //         $destinationPath = 'public/img/';
    //         $originalFile = $file->getClientOriginalName();
    //         $file->move($destinationPath, $originalFile);
    //     }

    //     $inwardRawMaterial = outwardRawMaterial::create([
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'compaey_name' => $request->compaey_name,
    //         'location' => $request->location,
    //         'inv_challan_number' => $request->inv_challan_number,
    //         'inv_challan_date' => $request->inv_challan_date,
    //         'vehicle_number' => $request->vehicle_number,
    //         'mobile' => $request->mobile,
    //         'img' => $originalFile,
    //     ]);

    //     // $masterProduct = masterProduct::where('id', $request->id);

    //     $data = $request->all();
    //     $items = $data['category-group'] ?? [];

    //     foreach ($items as $itemAdd) {
    //         if (isset($itemAdd['item'], $itemAdd['quantity'], $itemAdd['uom'], $itemAdd['rate'], $itemAdd['amount'], $itemAdd['remark']) && !empty($itemAdd['item']) && !empty($itemAdd['quantity']) && !empty($itemAdd['uom']) && !empty($itemAdd['rate']) && !empty($itemAdd['amount']) && !empty($itemAdd['remark'])) {

    //             $masterProduct = MasterProduct::where('product_name', $itemAdd['item'])->first();

    //             outwardRawMaterialItem::create([
    //                 'material_out_id' => $inwardRawMaterial->id,
    //                 'item' => $itemAdd['item'],
    //                 'item_id' => $masterProduct->id,
    //                 'quantity' => $itemAdd['quantity'],
    //                 'uom' => $itemAdd['uom'],
    //                 'rate' => $itemAdd['rate'],
    //                 'amount' => $itemAdd['amount'],
    //                 'remark' => $itemAdd['remark'],

    //             ]);
    //         }
    //     }
    //     return response()->json([]);
    // }

    // Packing-material-------------------------------------------------------------------

    public function PackingMaterialIn()
    {
        $UOM = UomMaster::all();
        $raw = masterProduct::all();
        $company = masterCompany::all();
        return view('packing-material-in', compact('raw', 'company', 'UOM'));
    }

    public function PackingMaterialOut()
    {
        $UOM = UomMaster::all();
        $raw = masterProduct::all();
        $company = masterCompany::all();

        return view('packing-material-out', compact('raw', 'company', 'UOM'));
    }

    // public function PackingMaterialCreate(Request $request)
    // {
    //     $originalFile = '';
    //     if ($request->hasFile('img')) {
    //         $file = $request->file('img');
    //         $destinationPath = 'public/img/';
    //         $originalFile = $file->getClientOriginalName();
    //         $file->move($destinationPath, $originalFile);
    //     }

    //     $inwardPackingMaterial = inwardRawPacking::create([
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'compaey_name' => $request->compaey_name,
    //         'location' => $request->location,
    //         'inv_challan_number' => $request->inv_challan_number,
    //         'inv_challan_date' => $request->inv_challan_date,
    //         'vehicle_number' => $request->vehicle_number,
    //         'mobile' => $request->mobile,
    //         'img' => $originalFile,
    //     ]);

    //     // $masterProduct = masterProduct::where('id', $request->id);

    //     $data = $request->all();
    //     $items = $data['category-group'] ?? [];

    //     foreach ($items as $itemAdd) {
    //         if (isset($itemAdd['item'], $itemAdd['quantity'], $itemAdd['uom'], $itemAdd['rate'], $itemAdd['amount'], $itemAdd['remark']) && !empty($itemAdd['item']) && !empty($itemAdd['quantity']) && !empty($itemAdd['uom']) && !empty($itemAdd['rate']) && !empty($itemAdd['amount']) && !empty($itemAdd['remark'])) {

    //             $masterProduct = MasterProduct::where('product_name', $itemAdd['item'])->first();

    //             inwardRawPackingItem::create([
    //                 'packing_id' => $inwardPackingMaterial->id,
    //                 'item' => $itemAdd['item'],
    //                 'item_id' => $masterProduct->id,
    //                 'quantity' => $itemAdd['quantity'],
    //                 'uom' => $itemAdd['uom'],
    //                 'rate' => $itemAdd['rate'],
    //                 'amount' => $itemAdd['amount'],
    //                 'remark' => $itemAdd['remark'],

    //             ]);
    //         }
    //     }
    //     return response()->json([]);
    // }

    // public function PackingMaterialCreateOut(Request $request)
    // {
    //     $originalFile = '';
    //     if ($request->hasFile('img')) {
    //         $file = $request->file('img');
    //         $destinationPath = 'public/img/';
    //         $originalFile = $file->getClientOriginalName();
    //         $file->move($destinationPath, $originalFile);
    //     }

    //     $inwardRawMaterial = outwardPackingMaterial::create([
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'compaey_name' => $request->compaey_name,
    //         'location' => $request->location,
    //         'inv_challan_number' => $request->inv_challan_number,
    //         'inv_challan_date' => $request->inv_challan_date,
    //         'vehicle_number' => $request->vehicle_number,
    //         'mobile' => $request->mobile,
    //         'img' => $originalFile,
    //     ]);

    //     // $masterProduct = masterProduct::where('id', $request->id);

    //     $data = $request->all();
    //     $items = $data['category-group'] ?? [];

    //     foreach ($items as $itemAdd) {
    //         if (isset($itemAdd['item'], $itemAdd['quantity'], $itemAdd['uom'], $itemAdd['rate'], $itemAdd['amount'], $itemAdd['remark']) && !empty($itemAdd['item']) && !empty($itemAdd['quantity']) && !empty($itemAdd['uom']) && !empty($itemAdd['rate']) && !empty($itemAdd['amount']) && !empty($itemAdd['remark'])) {

    //             $masterProduct = MasterProduct::where('product_name', $itemAdd['item'])->first();

    //             outwardPackingMaterialItem::create([
    //                 'Packing_out_id' => $inwardRawMaterial->id,
    //                 'item' => $itemAdd['item'],
    //                 'item_id' => $masterProduct->id,
    //                 'quantity' => $itemAdd['quantity'],
    //                 'uom' => $itemAdd['uom'],
    //                 'rate' => $itemAdd['rate'],
    //                 'amount' => $itemAdd['amount'],
    //                 'remark' => $itemAdd['remark'],

    //             ]);
    //         }
    //     }
    //     return response()->json([]);
    // }

    // machinery-material--------------------------------------------------------------

    public function machineryMaterialIn()
    {
        $UOM = UomMaster::all();
        $raw = masterProduct::all();
        $company = masterCompany::all();
        return view('machinery-items-in', compact('raw', 'company', 'UOM'));
    }

    public function machineryMaterialOut()
    {
        $UOM = UomMaster::all();
        $raw = masterProduct::all();
        $company = masterCompany::all();
        return view('machinery-items-out', compact('raw', 'company', 'UOM'));
    }

    // public function machineryMaterialCreate(Request $request)
    // {
    //     $originalFile = '';
    //     if ($request->hasFile('img')) {
    //         $file = $request->file('img');
    //         $destinationPath = 'public/img/';
    //         $originalFile = $file->getClientOriginalName();
    //         $file->move($destinationPath, $originalFile);
    //     }

    //     $machinery = inwardRawMachinery::create([
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'compaey_name' => $request->compaey_name,
    //         'location' => $request->location,
    //         'inv_challan_number' => $request->inv_challan_number,
    //         'inv_challan_date' => $request->inv_challan_date,
    //         'vehicle_number' => $request->vehicle_number,
    //         'mobile' => $request->mobile,
    //         'img' => $originalFile,
    //     ]);

    //     // $masterProduct = masterProduct::where('id', $request->id);

    //     $data = $request->all();
    //     $items = $data['category-group'] ?? [];

    //     foreach ($items as $itemAdd) {
    //         if (isset($itemAdd['item'], $itemAdd['quantity'], $itemAdd['uom'], $itemAdd['rate'], $itemAdd['amount'], $itemAdd['remark']) && !empty($itemAdd['item']) && !empty($itemAdd['quantity']) && !empty($itemAdd['uom']) && !empty($itemAdd['rate']) && !empty($itemAdd['amount']) && !empty($itemAdd['remark'])) {

    //             $masterProduct = MasterProduct::where('product_name', $itemAdd['item'])->first();

    //             inwardRawMachineryItem::create([
    //                 'machinery_id' => $machinery->id,
    //                 'item' => $itemAdd['item'],
    //                 'item_id' => $masterProduct->id,
    //                 'quantity' => $itemAdd['quantity'],
    //                 'uom' => $itemAdd['uom'],
    //                 'rate' => $itemAdd['rate'],
    //                 'amount' => $itemAdd['amount'],
    //                 'remark' => $itemAdd['remark'],

    //             ]);
    //         }
    //     }
    //     return response()->json([]);
    // }

    // public function machineryMaterialCreateOut(Request $request)
    // {
    //     $originalFile = '';
    //     if ($request->hasFile('img')) {
    //         $file = $request->file('img');
    //         $destinationPath = 'public/img/';
    //         $originalFile = $file->getClientOriginalName();
    //         $file->move($destinationPath, $originalFile);
    //     }

    //     $inwardRawMaterial = outwardMachineryMaterial::create([
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'compaey_name' => $request->compaey_name,
    //         'location' => $request->location,
    //         'inv_challan_number' => $request->inv_challan_number,
    //         'inv_challan_date' => $request->inv_challan_date,
    //         'vehicle_number' => $request->vehicle_number,
    //         'mobile' => $request->mobile,
    //         'img' => $originalFile,
    //     ]);

    //     // $masterProduct = masterProduct::where('id', $request->id);

    //     $data = $request->all();
    //     $items = $data['category-group'] ?? [];

    //     foreach ($items as $itemAdd) {
    //         if (isset($itemAdd['item'], $itemAdd['quantity'], $itemAdd['uom'], $itemAdd['rate'], $itemAdd['amount'], $itemAdd['remark']) && !empty($itemAdd['item']) && !empty($itemAdd['quantity']) && !empty($itemAdd['uom']) && !empty($itemAdd['rate']) && !empty($itemAdd['amount']) && !empty($itemAdd['remark'])) {

    //             $masterProduct = MasterProduct::where('product_name', $itemAdd['item'])->first();

    //             outwardMachineryMaterialItem::create([
    //                 'machinery_out_id' => $inwardRawMaterial->id,
    //                 'item' => $itemAdd['item'],
    //                 'item_id' => $masterProduct->id,
    //                 'quantity' => $itemAdd['quantity'],
    //                 'uom' => $itemAdd['uom'],
    //                 'rate' => $itemAdd['rate'],
    //                 'amount' => $itemAdd['amount'],
    //                 'remark' => $itemAdd['remark'],

    //             ]);
    //         }
    //     }
    //     return response()->json([]);
    // }

    // finishedgood-material---------------------------------------------------------------

    public function finishedgoodMaterialIn()
    {
        $UOM = UomMaster::all();
        $raw = masterProduct::all();
        $company = masterCompany::all();

        return view('finished-good-in', compact('raw', 'company', 'UOM'));
    }

    public function finishedgoodMaterialOut()
    {
        $UOM = UomMaster::all();
        $raw = masterProduct::all();
        $company = masterCompany::all();

        return view('finished-good-out', compact('raw', 'company', 'UOM'));
    }

    // public function finishedgoodMaterialCreate(Request $request)
    // {
    //     $originalFile = '';
    //     if ($request->hasFile('img')) {
    //         $file = $request->file('img');
    //         $destinationPath = 'public/img/';
    //         $originalFile = $file->getClientOriginalName();
    //         $file->move($destinationPath, $originalFile);
    //     }

    //     $finishedgood = inwardRawFinishedgood::create([
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'compaey_name' => $request->compaey_name,
    //         'location' => $request->location,
    //         'inv_challan_number' => $request->inv_challan_number,
    //         'inv_challan_date' => $request->inv_challan_date,
    //         'vehicle_number' => $request->vehicle_number,
    //         'mobile' => $request->mobile,
    //         'img' => $originalFile,
    //     ]);

    //     // $masterProduct = masterProduct::where('id', $request->id);

    //     $data = $request->all();
    //     $items = $data['category-group'] ?? [];

    //     foreach ($items as $itemAdd) {
    //         if (isset($itemAdd['item'], $itemAdd['quantity'], $itemAdd['uom'], $itemAdd['rate'], $itemAdd['amount'], $itemAdd['remark']) && !empty($itemAdd['item']) && !empty($itemAdd['quantity']) && !empty($itemAdd['uom']) && !empty($itemAdd['rate']) && !empty($itemAdd['amount']) && !empty($itemAdd['remark'])) {

    //             $masterProduct = MasterProduct::where('product_name', $itemAdd['item'])->first();

    //             inwardRawFinishedgoodItem::create([
    //                 'finishedgood_id' => $finishedgood->id,
    //                 'item' => $itemAdd['item'],
    //                 'item_id' => $masterProduct->id,
    //                 'quantity' => $itemAdd['quantity'],
    //                 'uom' => $itemAdd['uom'],
    //                 'rate' => $itemAdd['rate'],
    //                 'amount' => $itemAdd['amount'],
    //                 'remark' => $itemAdd['remark'],

    //             ]);
    //         }
    //     }
    //     return response()->json([]);
    // }

    // public function finishedgoodMaterialCreateOut(Request $request)
    // {
    //     $originalFile = '';
    //     if ($request->hasFile('img')) {
    //         $file = $request->file('img');
    //         $destinationPath = 'public/img/';
    //         $originalFile = $file->getClientOriginalName();
    //         $file->move($destinationPath, $originalFile);
    //     }

    //     $inwardRawMaterial = outwardFinishedgoodMaterial::create([
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'compaey_name' => $request->compaey_name,
    //         'location' => $request->location,
    //         'inv_challan_number' => $request->inv_challan_number,
    //         'inv_challan_date' => $request->inv_challan_date,
    //         'vehicle_number' => $request->vehicle_number,
    //         'mobile' => $request->mobile,
    //         'img' => $originalFile,
    //     ]);

    //     // $masterProduct = masterProduct::where('id', $request->id);

    //     $data = $request->all();
    //     $items = $data['category-group'] ?? [];

    //     foreach ($items as $itemAdd) {
    //         if (isset($itemAdd['item'], $itemAdd['quantity'], $itemAdd['uom'], $itemAdd['rate'], $itemAdd['amount'], $itemAdd['remark']) && !empty($itemAdd['item']) && !empty($itemAdd['quantity']) && !empty($itemAdd['uom']) && !empty($itemAdd['rate']) && !empty($itemAdd['amount']) && !empty($itemAdd['remark'])) {

    //             $masterProduct = MasterProduct::where('product_name', $itemAdd['item'])->first();

    //             outwardFinishedgoodMaterialItem::create([
    //                 'finishedgood_out_id' => $inwardRawMaterial->id,
    //                 'item' => $itemAdd['item'],
    //                 'item_id' => $masterProduct->id,
    //                 'quantity' => $itemAdd['quantity'],
    //                 'uom' => $itemAdd['uom'],
    //                 'rate' => $itemAdd['rate'],
    //                 'amount' => $itemAdd['amount'],
    //                 'remark' => $itemAdd['remark'],
    //             ]);
    //         }
    //     }
    //     return response()->json([]);
    // }

    public function productMaster()
    {
        $uoms = UomMaster::all();
        $items = itemsMaster::all();
        $products = ProductMaster::all();
        return view('product-master', compact('items', 'uoms', 'products'));
    }

    public function updateproductName(Request $request)
    {
        $data = $request->all();
        masterProduct::where('id', $data['id'])->update(['product_name' => $data['product_name'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function updatetype(Request $request)
    {
        $data = $request->all();
        masterProduct::where('id', $data['id'])->update(['type' => $data['type'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    //    public function updateuom(Request $request)
    //    {
    //        $data = $request->all();
    //        masterProduct::where('id', $data['id'])->update(['uom' => $data['uom'] ?? '']);
    //        return response()->json(['success' => 'true'], 201);
    //    }

    public function updatepacking(Request $request)
    {
        $data = $request->all();
        masterProduct::where('id', $data['id'])->update(['packing' => $data['packing'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function updateremark(Request $request)
    {
        $data = $request->all();
        masterProduct::where('id', $data['id'])->update(['remark' => $data['remark'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }


    public function productMasterCreate(Request $request)
    {
        $data = $request->all();

        $product = ProductMaster::create([
            "name" => $data['product_name'],
            "pack_size" => $data['pack_size']
        ]);

        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $category) {
                ProductItems::create([
                    "product_id" => $product->id,
                    "item_id" => $category['item'],
                    "recipie_weight" => $category['resepi_weight'],
                    "uom" => $category['uom'],
                ]);
            }
        }
        return redirect()->route('product.master');
    }

    public function masterType()
    {
        $items = TypeMaster::all();
        return view('master-type', compact('items'));
    }

    public function updatetypeName(Request $request)
    {
        $data = $request->all();
        TypeMaster::where('id', $data['id'])->update(['short_name' => $data['smName'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function updaterm(Request $request)
    {
        $data = $request->all();
        TypeMaster::where('id', $data['id'])->update(['full_name' => $data['fullName'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function deleteType(Request $request)
    {
        $data = $request->all();
        TypeMaster::where('id', $data['id'])->delete();
        return response()->json(['success' => 'true'], 201);
    }

    public function masterTypeCreate(Request $request)
    {
        $data = $request->all();
        if ($data && isset($data['category-group']) && $data['category-group']) {

            foreach ($data['category-group'] as $type) {
                TypeMaster::create([
                    "short_name" => $type['short_name'],
                    "full_name" => $type['full_Name']
                ]);
            }
        }
        return redirect()->route('master.type');
    }


    public function masterCompany(Request $request)
    {
        $items = masterCompany::all();
        return view('master-company', compact('items'));
    }

    public function masterCompanyCreate(Request $request)
    {
        masterCompany::create([
            'compaey_name' => $request->compaey_name,
        ]);

        return redirect()->route('master.company');
    }

    public function updateCompanyName(Request $request)
    {
        $data = $request->all();
        masterCompany::where('id', $data['id'])->update(['compaey_name' => $data['compaey_name'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function deleteCompanyRecord(Request $request)
    {
        $data = $request->all();
        masterCompany::where('id', $data['id'])->delete();
        return response()->json(['success' => 'true'], 201);
    }


    public function security()
    {
        return view('security');
    }


    public function transferMaterial()
    {
        $UOM = UomMaster::all();
        $raw = masterProduct::all();
        return view('transfer-material', compact('raw', 'UOM'));
    }

    public function transferMaterialCreate(Request $request)
    {

        $originalFile = '';
        if ($request->hasFile('item_images')) {
            $file = $request->file('item_images');
            $originalFile = $file->store('item_images', 'public');
        }

        $transfer_material = transferMaterial::create([
            'date' => $request->date,
            'time' => $request->time,
            'item_images' => $originalFile,
        ]);

        $items = $request->input('category-group', []);
        foreach ($items as $masterProduct) {
            if (
                isset($masterProduct['item'], $masterProduct['quantity'], $masterProduct['uom'], $masterProduct['from'], $masterProduct['to'], $masterProduct['person'], $masterProduct['remark']) &&
                !empty($masterProduct['item']) && !empty($masterProduct['quantity']) && !empty($masterProduct['uom']) && !empty($masterProduct['from']) && !empty($masterProduct['to']) && !empty($masterProduct['person'])
            ) {
                transferMaterialItem::create([
                    'transfer_material_id' => $transfer_material->id,
                    'item' => $masterProduct['item'],
                    'quantity' => $masterProduct['quantity'],
                    'uom' => $masterProduct['uom'],
                    'from' => $masterProduct['from'],
                    'to' => $masterProduct['to'],
                    'person' => $masterProduct['person'],
                    'remark' => $masterProduct['remark'],
                ]);
            }
        }

        return redirect()->route('transfer.material');
    }

    public function transferReaport()
    {
        $raw = masterProduct::all();
        return view('transfer-reaport', compact('raw'));
    }

    public function transferReaportData(Request $request)
    {
        if ($request->product_name) {

            // $transferItem = masterProduct::all();
            $transferReaport = transferMaterialItem::where('item', $request->product_name)->get();
            // dd($transferReaport);

            if ($transferReaport) {
                $html = view('transfer-Material-Item', compact('transferReaport'))->render();
                return response()->json(['html' => $html]);
            }
        }

        return response()->json(['error' => 'Invalid Request'], 400);
    }


    public function typeMaster()
    {
        return view('type-master');
    }

    public function updateMaterialName(Request $request)
    {
        Material::where('id', $request->id)->update([
            'item_name' => $request->material_name,
        ]);
        return response()->json(
            [
                'messages' => 'success',
            ],
            201,
        );
    }

    public function updateMaterialWeight(Request $request)
    {
        Material::where('id', $request->id)->update([
            'recipie_weight' => $request->weight,
        ]);
        return response()->json(
            [
                'messages' => 'success',
            ],
            201,
        );
    }

    public function updateMaterialUom(Request $request)
    {
        Material::where('id', $request->id)->update([
            'umd' => $request->uom,
        ]);
        return response()->json(
            [
                'messages' => 'success',
            ],
            201,
        );
    }

    public function updateMaterialDelete(Request $request)
    {
        Material::where('id', $request->id)->delete();

        return response()->json([
            'meassages' => 'success',
        ]);
    }


    // public function outRawFatch(Request $request)
    // {
    //     if (outwardRawMaterial::RAW_MATERIAL == $request->name) {

    //         $outRawId = outwardRawMaterial::RAW_MATERIAL;

    //         $outwardRawMaterial = outwardRawMaterial::all();

    //         if ($outwardRawMaterial) {
    //             $html = view('outward-Raw-Material-render', compact('outwardRawMaterial', 'outRawId'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::PACKING_MATERIAL == $request->name) {

    //         $outRawId = outwardRawMaterial::PACKING_MATERIAL;

    //         $outwardRawMaterial = outwardPackingMaterial::all();

    //         if ($outwardRawMaterial) {
    //             $html = view('outward-Raw-Material-render', compact('outwardRawMaterial', 'outRawId'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::MACHINERY_ITEM == $request->name) {

    //         $outRawId = outwardRawMaterial::MACHINERY_ITEM;

    //         $outwardRawMaterial = outwardMachineryMaterial::all();

    //         if ($outwardRawMaterial) {
    //             $html = view('outward-Raw-Material-render', compact('outwardRawMaterial', 'outRawId'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::FINISH_GOOD == $request->name) {

    //         $outRawId = outwardRawMaterial::FINISH_GOOD;

    //         $outwardRawMaterial = outwardFinishedgoodMaterial::all();

    //         if ($outwardRawMaterial) {
    //             $html = view('outward-Raw-Material-render', compact('outwardRawMaterial', 'outRawId'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }
    // }

    // function outGetFatch(Request $request)
    // {
    //     if (outwardRawMaterial::RAW_MATERIAL == $request->outRawId) {
    //         // dd($request);

    //         $outwardRawMaterial = outwardRawMaterial::where('id', $request->id)->first();
    //         $outwardRawMaterialitem = outwardRawMaterialItem::where('material_out_id', $outwardRawMaterial->id)->get();

    //         if ($outwardRawMaterial) {
    //             $html = view('outward-Raw-Model-render', compact('outwardRawMaterial', 'outwardRawMaterialitem'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::PACKING_MATERIAL == $request->outRawId) {
    //         $outwardRawMaterial = outwardPackingMaterial::where('id', $request->id)->first();
    //         $outwardRawMaterialitem = outwardPackingMaterialItem::where('Packing_out_id', $outwardRawMaterial->id)->get();

    //         if ($outwardRawMaterial) {
    //             $html = view('outward-Raw-Model-render', compact('outwardRawMaterial', 'outwardRawMaterialitem'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::MACHINERY_ITEM == $request->outRawId) {
    //         $outwardRawMaterial = outwardMachineryMaterial::where('id', $request->id)->first();
    //         $outwardRawMaterialitem = outwardMachineryMaterialItem::where('machinery_out_id', $outwardRawMaterial->id)->get();

    //         if ($outwardRawMaterial) {
    //             $html = view('outward-Raw-Model-render', compact('outwardRawMaterial', 'outwardRawMaterialitem'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::FINISH_GOOD == $request->outRawId) {
    //         $outwardRawMaterial = outwardFinishedgoodMaterial::where('id', $request->id)->first();
    //         $outwardRawMaterialitem = outwardFinishedgoodMaterialItem::where('finishedgood_out_id', $outwardRawMaterial->id)->get();

    //         if ($outwardRawMaterial) {
    //             $html = view('outward-Raw-Model-render', compact('outwardRawMaterial', 'outwardRawMaterialitem'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }
    // }

    // // in

    // public function inRawFatch(Request $request)
    // {
    //     if (outwardRawMaterial::RAW_MATERIAL == $request->name) {
    //         $outRawId = outwardRawMaterial::RAW_MATERIAL;

    //         $outwardRawMaterial = inwardRawMaterial::all();

    //         if ($outwardRawMaterial) {
    //             $html = view('inward-Raw-Material-render', compact('outwardRawMaterial', 'outRawId'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::PACKING_MATERIAL == $request->name) {
    //         $outRawId = outwardRawMaterial::PACKING_MATERIAL;

    //         $outwardRawMaterial = inwardRawPacking::all();

    //         if ($outwardRawMaterial) {
    //             $html = view('inward-Raw-Material-render', compact('outwardRawMaterial', 'outRawId'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::MACHINERY_ITEM == $request->name) {
    //         $outRawId = outwardRawMaterial::MACHINERY_ITEM;

    //         $outwardRawMaterial = inwardRawMachinery::all();

    //         if ($outwardRawMaterial) {
    //             $html = view('inward-Raw-Material-render', compact('outwardRawMaterial', 'outRawId'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::FINISH_GOOD == $request->name) {
    //         $outRawId = outwardRawMaterial::FINISH_GOOD;

    //         $outwardRawMaterial = inwardRawFinishedgood::all();

    //         if ($outwardRawMaterial) {
    //             $html = view('inward-Raw-Material-render', compact('outwardRawMaterial', 'outRawId'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }
    // }


    // function inGetFatch(Request $request)
    // {
    //     if (outwardRawMaterial::RAW_MATERIAL == $request->outRawId) {
    //         // dd($request);

    //         $outwardRawMaterial = inwardRawMaterial::where('id', $request->id)->first();
    //         $outwardRawMaterialitem = inwardRawMaterialItem::where('material_id', $outwardRawMaterial->id)->get();

    //         if ($outwardRawMaterial) {
    //             $html = view('inward-Raw-Model-render', compact('outwardRawMaterial', 'outwardRawMaterialitem'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::PACKING_MATERIAL == $request->outRawId) {
    //         $outwardRawMaterial = inwardRawPacking::where('id', $request->id)->first();
    //         $outwardRawMaterialitem = inwardRawPackingItem::where('Packing_id', $outwardRawMaterial->id)->get();

    //         if ($outwardRawMaterial) {
    //             $html = view('inward-Raw-Model-render', compact('outwardRawMaterial', 'outwardRawMaterialitem'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::MACHINERY_ITEM == $request->outRawId) {
    //         $outwardRawMaterial = inwardRawMachinery::where('id', $request->id)->first();
    //         $outwardRawMaterialitem = inwardRawMachineryItem::where('machinery_id', $outwardRawMaterial->id)->get();

    //         if ($outwardRawMaterial) {
    //             $html = view('inward-Raw-Model-render', compact('outwardRawMaterial', 'outwardRawMaterialitem'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }

    //     if (outwardRawMaterial::FINISH_GOOD == $request->outRawId) {
    //         $outwardRawMaterial = inwardRawFinishedgood::where('id', $request->id)->first();
    //         $outwardRawMaterialitem = inwardRawFinishedgoodItem::where('finishedgood_id', $outwardRawMaterial->id)->get();

    //         if ($outwardRawMaterial) {
    //             $html = view('inward-Raw-Model-render', compact('outwardRawMaterial', 'outwardRawMaterialitem'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //             ]);
    //         }
    //         return response()->json(['error' => 'User Personal Details not found'], 404);
    //     }
    // }


    // function inOutStock(Request $request)
    // {
    //     $raw = masterProduct::all();
    //     return view('in-out-stock', compact('raw'));
    // }

    // public function inOutStockData(Request $request)
    // {
    //     if (outwardRawMaterial::RAW_MATERIAL == $request->materialId) {
    //         $product = MasterProduct::find($request->id);

    //         $inwardItems = InwardRawMaterialItem::where('item_id', $product->id)->get();
    //         $outwardItems = OutwardRawMaterialItem::where('item_id', $product->id)->get();
    //         $productsItem = Batch::where('material_id', $product->id)->get();
    //         // dd($productsItem);

    //         if ($inwardItems->isEmpty() && $outwardItems->isEmpty()) {
    //             return response()->json([
    //                 'message' => 'No data available',
    //                 'html' => ''
    //             ]);
    //         }

    //         $totalInwardQuantity = $inwardItems->sum('quantity');
    //         // $totalInwardUom = $inwardItems->sum('uom');
    //         // $totalInwardRate = $inwardItems->sum('rate');
    //         // $totalInwardAmount = $inwardItems->sum('amount');

    //         $totalOutwardQuantity = $outwardItems->sum('quantity');
    //         $totalProductsItem = $productsItem->sum('actual_weight');
    //         // $totalOutwardUom = $outwardItems->sum('uom');
    //         // $totalOutwardRate = $outwardItems->sum('rate');
    //         // $totalOutwardAmount = $outwardItems->sum('amount');

    //         $netQuantity = $totalInwardQuantity - $totalOutwardQuantity - $totalProductsItem;
    //         // $netUom = $totalInwardUom - $totalOutwardUom;
    //         // $netRate = $totalInwardRate - $totalOutwardRate;
    //         // $netAmount = $totalInwardAmount - $totalOutwardAmount;

    //         $html = view('in-out-stock-fatch', compact('netQuantity', 'product'))->render();

    //         return response()->json([
    //             'html' => $html,
    //             // 'message' => 'Data available'
    //         ]);
    //     }

    //     if (outwardRawMaterial::PACKING_MATERIAL == $request->materialId) {
    //         $product = MasterProduct::find($request->id);

    //         $inwardItems = inwardRawPackingItem::where('item_id', $product->id)->get();
    //         $outwardItems = outwardPackingMaterialItem::where('item_id', $product->id)->get();
    //         $productsItem = Batch::where('material_id', $product->id)->get();


    //         if ($inwardItems->isEmpty() && $outwardItems->isEmpty()) {
    //             return response()->json([
    //                 'message' => 'No data available',
    //                 'html' => ''
    //             ]);
    //         }

    //         $totalInwardQuantity = $inwardItems->sum('quantity');
    //         // $totalInwardUom = $inwardItems->sum('uom');
    //         // $totalInwardRate = $inwardItems->sum('rate');
    //         // $totalInwardAmount = $inwardItems->sum('amount');

    //         $totalOutwardQuantity = $outwardItems->sum('quantity');
    //         $totalProductsItem = $productsItem->sum('actual_weight');
    //         // $totalOutwardUom = $outwardItems->sum('uom');
    //         // $totalOutwardRate = $outwardItems->sum('rate');
    //         // $totalOutwardAmount = $outwardItems->sum('amount');

    //         $netQuantity = $totalInwardQuantity - $totalOutwardQuantity - $totalProductsItem;
    //         // $netUom = $totalInwardUom - $totalOutwardUom;
    //         // $netRate = $totalInwardRate - $totalOutwardRate;
    //         // $netAmount = $totalInwardAmount - $totalOutwardAmount;

    //         $html = view('in-out-stock-fatch', compact('netQuantity', 'product'))->render();

    //         return response()->json([
    //             'html' => $html,
    //         ]);
    //     }

    //     if (outwardRawMaterial::MACHINERY_ITEM == $request->materialId) {
    //         $product = MasterProduct::find($request->id);

    //         $inwardItems = inwardRawMachineryItem::where('item_id', $product->id)->get();
    //         $outwardItems = outwardMachineryMaterialItem::where('item_id', $product->id)->get();
    //         $productsItem = Batch::where('material_id', $product->id)->get();


    //         if ($inwardItems->isEmpty() && $outwardItems->isEmpty()) {
    //             return response()->json([
    //                 'message' => 'No data available',
    //                 'html' => ''
    //             ]);
    //         }

    //         $totalInwardQuantity = $inwardItems->sum('quantity');
    //         // $totalInwardUom = $inwardItems->sum('uom');
    //         // $totalInwardRate = $inwardItems->sum('rate');
    //         // $totalInwardAmount = $inwardItems->sum('amount');

    //         $totalOutwardQuantity = $outwardItems->sum('quantity');
    //         $totalProductsItem = $productsItem->sum('actual_weight');
    //         // $totalOutwardUom = $outwardItems->sum('uom');
    //         // $totalOutwardRate = $outwardItems->sum('rate');
    //         // $totalOutwardAmount = $outwardItems->sum('amount');

    //         $netQuantity = $totalInwardQuantity - $totalOutwardQuantity - $totalProductsItem;
    //         // $netUom = $totalInwardUom - $totalOutwardUom;
    //         // $netRate = $totalInwardRate - $totalOutwardRate;
    //         // $netAmount = $totalInwardAmount - $totalOutwardAmount;

    //         $html = view('in-out-stock-fatch', compact('netQuantity', 'product'))->render();

    //         return response()->json([
    //             'html' => $html,
    //         ]);
    //     }

    //     if (outwardRawMaterial::FINISH_GOOD == $request->materialId) {
    //         $product = MasterProduct::find($request->id);

    //         $inwardItems = inwardRawFinishedgoodItem::where('item_id', $product->id)->get();
    //         $outwardItems = outwardFinishedgoodMaterialItem::where('item_id', $product->id)->get();
    //         $productsItem = Batch::where('material_id', $product->id)->get();

    //         if ($inwardItems->isEmpty() && $outwardItems->isEmpty()) {
    //             return response()->json([
    //                 'message' => 'No data available',
    //                 'html' => ''
    //             ]);
    //         }

    //         $totalInwardQuantity = $inwardItems->sum('quantity');
    //         // $totalInwardUom = $inwardItems->sum('uom');
    //         // $totalInwardRate = $inwardItems->sum('rate');
    //         // $totalInwardAmount = $inwardItems->sum('amount');

    //         $totalOutwardQuantity = $outwardItems->sum('quantity');
    //         $totalProductsItem = $productsItem->sum('actual_weight');
    //         // $totalOutwardUom = $outwardItems->sum('uom');
    //         // $totalOutwardRate = $outwardItems->sum('rate');
    //         // $totalOutwardAmount = $outwardItems->sum('amount');

    //         $netQuantity = $totalInwardQuantity - $totalOutwardQuantity - $totalProductsItem;
    //         // $netUom = $totalInwardUom - $totalOutwardUom;
    //         // $netRate = $totalInwardRate - $totalOutwardRate;
    //         // $netAmount = $totalInwardAmount - $totalOutwardAmount;

    //         $html = view('in-out-stock-fatch', compact('netQuantity', 'product'))->render();

    //         return response()->json([
    //             'html' => $html,
    //         ]);
    //     }
    // }


    // public function inOutStockRendar(Request $request)
    // {
    //     if (outwardRawMaterial::RAW_MATERIAL == $request->materialId) {
    //         $inwardItems = InwardRawMaterialItem::where('item_id', $request->item_id)->get();
    //         $outwardItems = outwardRawMaterialItem::where('item_id', $request->item_id)->get();
    //         $itemIds = $inwardItems->pluck('item_id');

    //         $materials = Batch::whereIn('material_id', $itemIds)->with('getProduct', 'getMaterial')->get();

    //         $html = view('in-out-stock-rendar', compact('inwardItems', 'outwardItems', 'materials'))->render();

    //         return response()->json([
    //             'html' => $html,
    //         ]);
    //     }

    //     if (outwardRawMaterial::PACKING_MATERIAL == $request->materialId) {
    //         $inwardItems = inwardRawPackingItem::where('item_id', $request->item_id)->get();
    //         $outwardItems = outwardPackingMaterialItem::where('item_id', $request->item_id)->get();
    //         $itemIds = $inwardItems->pluck('item_id');

    //         $materials = Batch::whereIn('material_id', $itemIds)->get();

    //         $html = view('in-out-stock-rendar', compact('inwardItems', 'outwardItems', 'materials'))->render();

    //         return response()->json([
    //             'html' => $html,
    //         ]);
    //     }

    //     if (outwardRawMaterial::MACHINERY_ITEM == $request->materialId) {


    //         $inwardItems = inwardRawMachineryItem::where('item_id', $request->item_id)->get();
    //         $outwardItems = outwardMachineryMaterialItem::where('item_id', $request->item_id)->get();
    //         $materials = Batch::where('material_id', $request->id)->get();

    //         $html = view('in-out-stock-rendar', compact('inwardItems', 'outwardItems', 'materials'))->render();

    //         return response()->json([
    //             'html' => $html,
    //         ]);
    //     }

    //     if (outwardRawMaterial::FINISH_GOOD == $request->materialId) {

    //         $inwardItems = inwardRawFinishedgoodItem::where('item_id', $request->item_id)->get();
    //         $outwardItems = outwardFinishedgoodMaterialItem::where('item_id', $request->item_id)->get();
    //         $itemIds = $inwardItems->pluck('item_id');

    //         $materials = Batch::whereIn('material_id', $itemIds)->get();

    //         $html = view('in-out-stock-rendar', compact('inwardItems', 'outwardItems', 'materials'))->render();

    //         return response()->json([
    //             'html' => $html,
    //         ]);
    //     }
    //     return redirect()->route('in.out.stock');
    // }


    function mainOrder(Request $request)
    {
        $raw = masterProduct::all();
        return view('main-Order', compact('raw'));
    }

    public function mainOrderCreate(Request $request)
    {

        $transfer_material = mainOrder::create([
            'product_name' => $request->product_name,
            'date' => $request->date,
            'batch_size' => $request->batch_size,
            'batch_required' => $request->batch_required,
        ]);

        $items = $request->input('category-group', []);
        foreach ($items as $masterProduct) {
            if (
                isset($masterProduct['item'], $masterProduct['quantity'], $masterProduct['uom']) &&
                !empty($masterProduct['item']) && !empty($masterProduct['quantity']) && !empty($masterProduct['uom'])
            ) {
                $masterProductRecord = MasterProduct::where('product_name', $masterProduct['item'])->first();

                if ($masterProductRecord) {
                    mainOrderItem::create([
                        'mainOrder_id' => $transfer_material->id,
                        'item' => $masterProductRecord->product_name,
                        'item_id' => $masterProductRecord->id,
                        'quantity' => $masterProduct['quantity'],
                        'uom' => $masterProduct['uom']
                    ]);
                }
            }
        }

        return redirect()->route('mainOrder');
    }

    public function editOrder($id)
    {
        $order = mainOrder::findOrFail($id);
        return view('order-main-update', compact('order'));
    }

    public function updateOrder(Request $request, $id)
    {
        // $validated = $request->validate([
        //     'order_name' => 'required|string|max:255',
        //     'date' => 'required|date',
        // ]);

        $order = mainOrder::findOrFail($id);

        $order->update([
            'product_name' => $request['product_name'],
            'date' => $request['date'],
            'batch_size' => $request['batch_size'],
            'batch_required' => $request['batch_required'],
        ]);

        return redirect()->route('admin')->with('Success', 'Order Updated Successfully.');
    }

    public function masterUom()
    {
        $Uoms = UomMaster::all();
        return view('uom-master', compact('Uoms'));
    }

    public function masterUomCreate(Request $request)
    {
        $data = $request->all();

        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $category) {
                UomMaster::create([
                    "name" => $category['name'],
                    "short_form" => $category['short_name'],
                    "conversion" => $category['conversion'],
                    "uom_2" => $category['uom_2'],
                ]);
            }
        }

        return redirect()->back();
    }

    public function getDataByDate(Request $request)
    {
        $data = $request->all();
        $formDate = $data['formDate'] ?? null;
        $toDate = $data['toDate'] ?? null;
        $filterProduct = $data['filterProduct'] ?? 'all';

        if ($formDate) {
            $formDate = Carbon::createFromFormat('Y-m-d', $formDate)->format('d M Y');
        }
        if ($toDate) {
            $toDate = Carbon::createFromFormat('Y-m-d', $toDate)->format('d M Y');
        }

        // Build query
        $query = Batch::with(['getProduct', 'getMaterial'])
            ->when($filterProduct !== 'all', function ($q) use ($filterProduct) {
                $q->where('product_id', $filterProduct);
            });

        // Apply date range if both dates are provided
        if ($formDate && $toDate) {
            $query->whereBetween('date', [$formDate, $toDate]);
        }

        $products = $query->orderBy('id', 'desc')
            ->groupBy('product_id')
            ->get();

        $productMaster = Product::all();

        $html = view('report-data', compact('products', 'productMaster'))->render();

        return response()->json(['html' => $html]);
    }

    public function updateUom(Request $request)
    {
        $data = $request->all();

        if ($data['type'] == 'name') {
            UomMaster::where('id', $data['id'])->update([
                "name" => $data['value']
            ]);
        } elseif ($data['type'] == 'shortName') {
            UomMaster::where('id', $data['id'])->update([
                "short_form" => $data['value']
            ]);
        } elseif ($data['type'] == 'conversion') {
            UomMaster::where('id', $data['id'])->update([
                "conversion" => $data['value']
            ]);
        } elseif ($data['type'] == 'uom2') {
            UomMaster::where('id', $data['id'])->update([
                "uom_2" => $data['value']
            ]);
        }

        return response()->json(['success', 200]);
    }

    public function deleteUom(Request $request)
    {
        $data = $request->all();

        UomMaster::where('id', $data['id'])->delete();

        return response()->json(['success', 200]);
    }

    public function masterItem()
    {
        $items = itemsMaster::all();
        $types = TypeMaster::all();
        $uoms = UomMaster::all();
        return view('item-master', compact('items', 'types', 'uoms'));
    }

    public function masterItemsCreate(Request $request)
    {
        $data = $request->all();

        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $category) {
                itemsMaster::create([
                    "name" => $category['name'],
                    "type" => $category['type'],
                    "uom" => $category['uom'],
                    "uom2" => $category['uom_2'],
                    "remark" => $category['remark'],
                ]);
            }
        }
        return redirect()->back();
    }

    public function updateItems(Request $request)
    {
        $data = $request->all();

        if ($data['type'] == 'name') {
            itemsMaster::where('id', $data['id'])->update([
                'name' => $data['value']
            ]);
        } else if ($data['type'] == 'type') {

            itemsMaster::where('id', $data['id'])->update([
                'type' => $data['value']
            ]);
        } else if ($data['type'] == 'uom') {

            itemsMaster::where('id', $data['id'])->update([
                'uom' => $data['value']
            ]);
        } else if ($data['type'] == 'uom2') {

            itemsMaster::where('id', $data['id'])->update([
                'uom2' => $data['value']
            ]);
        } else if ($data['type'] == 'remark') {

            itemsMaster::where('id', $data['id'])->update([
                'remark' => $data['value']
            ]);
        }

        return response()->json(['success', 200]);
    }

    public function deleteItems(Request $request)
    {
        $data = $request->all();

        itemsMaster::where('id', $data['id'])->delete();

        return response()->json(['success', 200]);
    }

    public function masterAccount(Request $request)
    {
        $account = masterAccount::all();
        return view('master-account', compact('account'));
    }

    public function masterAccountCreate(Request $request)
    {
        $data = $request->all();

        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $category) {
                masterAccount::create([
                    "name" => $category['name'],
                    "address" => $category['address'],
                    "type" => $category['type'],
                ]);
            }
        }
        return redirect()->route('master.account');
    }

    public function updateAccountName(Request $request)
    {
        $data = $request->all();
        masterAccount::where('id', $data['id'])->update(['name' => $data['name'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function updateAccountAddress(Request $request)
    {
        $data = $request->all();
        masterAccount::where('id', $data['id'])->update(['address' => $data['address'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function updateAccountType(Request $request)
    {
        $data = $request->all();
        masterAccount::where('id', $data['id'])->update(['type' => $data['type'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function deleteAccount(Request $request)
    {
        $data = $request->all();
        masterAccount::where('id', $data['id'])->delete();
        return response()->json(['success' => 'true'], 201);
    }

    public function masterBrand(Request $request)
    {
        $account = BrandMaster::all();
        return view('master-brand', compact('account'));
    }

    public function masterBrandCreate(Request $request)
    {
        $data = $request->all();

        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $category) {
                BrandMaster::create([
                    "name" => $category['name'],
                    "type" => $category['type'],
                    "owner" => $category['owner'],
                ]);
            }
        }
        return redirect()->route('master.brand');
    }

    public function updateBrandName(Request $request)
    {
        $data = $request->all();
        BrandMaster::where('id', $data['id'])->update(['name' => $data['name'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function updatebrandtype(Request $request)
    {
        $data = $request->all();
        BrandMaster::where('id', $data['id'])->update(['type' => $data['type'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function updateBrandOwner(Request $request)
    {
        $data = $request->all();
        BrandMaster::where('id', $data['id'])->update(['owner' => $data['owner'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function deletebrand(Request $request)
    {
        $data = $request->all();
        BrandMaster::where('id', $data['id'])->delete();
        return response()->json(['success' => 'true'], 201);
    }




    public function masterEmploye(Request $request)
    {
        $account = EmployeMaster::all();
        return view('master-employe', compact('account'));
    }

    public function masterEmployeCreate(Request $request)
    {
        $data = $request->all();

        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $category) {
                EmployeMaster::create([
                    "name" => $category['name'],
                ]);
            }
        }
        return redirect()->route('master.employe');
    }

    public function updateEmployeName(Request $request)
    {
        $data = $request->all();
        EmployeMaster::where('id', $data['id'])->update(['name' => $data['name'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function deleteEmployeMaster(Request $request)
    {
        $data = $request->all();
        EmployeMaster::where('id', $data['id'])->delete();
        return response()->json(['success' => 'true'], 201);
    }



    public function masterBiscuit(Request $request)
    {
        $account = BiscuitMaster::all();
        return view('master-biscuit', compact('account'));
    }

    public function masterBiscuitCreate(Request $request)
    {
        $data = $request->all();

        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $index => $category) {
                $originalFileName = '';
                if (isset($category['img']) && $request->hasFile('category-group.' . $index . '.img')) {
                    $file = $request->file('category-group.' . $index . '.img');
                    $destinationPath = 'public/img/';
                    $originalFileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path($destinationPath), $originalFileName);
                }

                BiscuitMaster::create([
                    "name" => $category['name'],
                    "img" => $originalFileName,
                ]);
            }
        }

        return redirect()->route('master.biscuit');
    }


    public function updateBiscuitName(Request $request)
    {
        $data = $request->all();
        BiscuitMaster::where('id', $data['id'])->update(['name' => $data['name'] ?? '']);
        return response()->json(['success' => 'true'], 201);
    }

    public function updateBiscuitImg(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $destinationPath = 'public/img/';
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($destinationPath), $fileName);

            BiscuitMaster::where('id', $data['id'])->update(['img' => $fileName]);

            return response()->json(['success' => true, 'fileName' => $fileName], 200);
        }

        return response()->json(['error' => 'No image'], 400);
    }

    public function deletebiscuiteMaster(Request $request)
    {
        $data = $request->all();
        BiscuitMaster::where('id', $data['id'])->delete();
        return response()->json(['success' => 'true'], 201);
    }

    public function deleteProduct(Request $request)
    {
        $data = $request->all();

        ProductMaster::where('id', $data['id'])->delete();

        return response()->json(['success', 200]);
    }

    public function productEdit(Request $request, $id)
    {
        $productItems = itemsMaster::all();
        $uoms = UomMaster::all();
        $product = ProductMaster::where('id', $id)->first();
        $items = ProductItems::where('product_id', $id)->get();
        return view('product-edit', compact('product', 'items', 'productItems', 'uoms'));
    }

    public function updateProductItems(Request $request)
    {
        $data = $request->all();

        if ($data['type'] == 'name') {
            ProductItems::where('id', $data['id'])->update([
                'item_id' => $data['value']
            ]);
        } elseif ($data['type'] == 'recipieWeight') {
            ProductItems::where('id', $data['id'])->update([
                'recipie_weight' => $data['value']
            ]);
        } elseif ($data['type'] == 'uom') {
            ProductItems::where('id', $data['id'])->update([
                'uom' => $data['value']
            ]);
        }

        return response()->json(['success', 200]);
    }

    public function productItemsDelete(Request $request)
    {
        $data = $request->all();

        ProductItems::where('id', $data['id'])->delete();

        return response()->json(['success', 200]);
    }


    public function productUpdate(Request $request)
    {
        $data  = $request->all();

        $product = ProductMaster::where('id', $data['product-id'])->update([
            "name" => $data['product_name'],
            "pack_size" => $data['pack_size']
        ]);

        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $category) {
                ProductItems::create([
                    "product_id" => $data['product-id'],
                    "item_id" => $category['item'],
                    "recipie_weight" => $category['resepi_weight'],
                    "uom" => $category['uom'],
                ]);
            }
        }
        return redirect()->route('product.master');
    }



    public function packMasters(Request $request)
    {
        $account = PackMaster::all();
        $uom = UomMaster::all();
        return view('pack-masters', compact('account', 'uom'));
    }

    public function packMastersCreate(Request $request)
    {
        $packMastersCreate = PackMaster::create([
            'pack_name' => $request->pack_name,
            'pack_weight' => $request->pack_weight,
            'pack_weight_uom' => $request->pack_weight_uom,
            'no_pf_packet_polybag' => $request->no_pf_packet_polybag,
            'packet_polybag_uom' => $request->packet_polybag_uom,
            'no_of_polybag_in_cartoon' => $request->no_of_polybag_in_cartoon,
            'no_of_cartoon' => $request->no_of_cartoon,
            'no_of_cartoon_uom' => $request->no_of_cartoon_uom,
            'weight_of_cartoon' => $request->weight_of_cartoon,
            'weight_of_cartoon_uom' => $request->weight_of_cartoon_uom,
            'loading_in_container' => $request->loading_in_container,

            'wrapper_qty' => $request->wrapper_qty,
            'poly_bag_qty' => $request->poly_bag_qty,
            'box_qty' => $request->box_qty,
            'tape_qty' => $request->tape_qty,
        ]);

        return redirect()->route('pack.masters');
    }
    public function packMastersDelete(Request $request)
    {
        $data = $request->all();
        PackMaster::where('id', $data['id'])->delete();
        return response()->json(['success' => 'true'], 201);
    }

    function packMastersUpdate($id)
    {
        $packMaster = PackMaster::find($id);
        $uom = UomMaster::all();
        return view('pack-master-update', compact('packMaster', 'uom'));
    }

    function packMastersEdit(Request $request)
    {
        $uom = UomMaster::where('id', $request->id);
        $packMaster = PackMaster::findOrFail($request->id);

        $packMaster->update([
            'pack_name' => $request->pack_name,
            'pack_weight' => $request->pack_weight,
            'pack_weight_uom' => $request->pack_weight_uom,
            'no_pf_packet_polybag' => $request->no_pf_packet_polybag,
            'packet_polybag_uom' => $request->packet_polybag_uom,
            'no_of_polybag_in_cartoon' => $request->no_of_polybag_in_cartoon,
            'no_of_cartoon' => $request->no_of_cartoon,
            'no_of_cartoon_uom' => $request->no_of_cartoon_uom,
            'weight_of_cartoon' => $request->weight_of_cartoon,
            'weight_of_cartoon_uom' => $request->weight_of_cartoon_uom,
            'loading_in_container' => $request->loading_in_container,
            'wrapper_qty' => $request->wrapper_qty,
            'poly_bag_qty' => $request->poly_bag_qty,
            'box_qty' => $request->box_qty,
            'tape_qty' => $request->tape_qty,
        ]);

        return redirect()->route('pack.masters');
    }


    function OrderCreate(Request $request)
    {
        $customer_name = masterCompany::all();
        $product = productMaster::all();
        $brand_name = BrandMaster::all();
        $pack_size = PackMaster::all();
        $order = Order::all();
        // dd($pack_size);
        $biscuit_masters = BiscuitMaster::all();
        return view('order-create', compact('order', 'customer_name', 'product', 'brand_name', 'pack_size', 'biscuit_masters'));
    }


    function OrderCreateAdd(Request $request)
    {
        $order = Order::create([
            'date' => $request->date,
            'name' => $request->name,
            'order_no' => $request->order_no,
            'customer_name' => $request->customer_name,
            'contact_person' => $request->contact_person,
            'hide' => $request->hide,
        ]);

        $data = $request->all();

        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $index => $category) {

                $wrapper_design = '';
                $box_design = '';
                $approval_from_customer = '';

                if (isset($category['wrapper_design']) && $request->hasFile('category-group.' . $index . '.wrapper_design')) {
                    $file = $request->file('category-group.' . $index . '.wrapper_design');
                    $destinationPath = 'public/img/';
                    $wrapper_design = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path($destinationPath), $wrapper_design);
                }
                if (isset($category['box_design']) && $request->hasFile('category-group.' . $index . '.box_design')) {
                    $file = $request->file('category-group.' . $index . '.box_design');
                    $destinationPath = 'public/img/';
                    $box_design = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path($destinationPath), $box_design);
                }
                if (isset($category['approval_from_customer']) && $request->hasFile('category-group.' . $index . '.approval_from_customer')) {
                    $file = $request->file('category-group.' . $index . '.approval_from_customer');
                    $destinationPath = 'public/img/';
                    $approval_from_customer = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path($destinationPath), $approval_from_customer);
                }

                $products = OrderProduct::create([
                    "order_id" => $order->id,
                    "product" => $category['product'],
                    "brand_name" => $category['brand_name'],
                    "pack_size" => $category['pack_size'],
                    "qty_container" => $category['qty_container'],
                    "reqd_oty" => $category['reqd_oty'],
                    "container_date" => $category['container_date'],
                    "container_booked" => $category['container_booked'],
                    "die_name" => $category['die_name'],

                    // "hide" => $category['hide'],
                    "wrapper_design" => $wrapper_design,
                    "box_design" => $box_design,
                    "approval_from_customer" => $approval_from_customer,
                ]);
            }
        }

        return response()->json([
            "order" => $order->id,
        ]);
    }

    public function OrderRender(Request $request)
    {
        $OrderCreateRender = Order::where('id', $request->order)->get();

        $productOrderRender = OrderProduct::where('order_id', $request->order)->with('Products')->get();

        if ($OrderCreateRender) {
            $html = view('order-create-render', compact('OrderCreateRender', 'productOrderRender'))->render();
            return response()->json(['html' => $html]);
        }
        // }

        return response()->json(['error' => 'No orders found'], 400);
    }





    public function OrderCreateDelete(Request $request)
    {
        $data = $request->all();
        Order::where('id', $data['id'])->delete();
        return response()->json(['success' => 'true'], 201);
    }


    public function OrderCreateUpdate($id)
    {
        $OrderCreateUpdate = Order::find($id);
        $collection = OrderProduct::where('order_id', $OrderCreateUpdate->id)->get();
        $customer_name = masterCompany::all();
        $product = productMaster::all();
        $brand_name = BrandMaster::all();
        $pack_size = PackMaster::all();
        $biscuit_masters = BiscuitMaster::all();

        return view('order-create-update', compact(
            'OrderCreateUpdate',
            'collection',
            'customer_name',
            'product',
            'brand_name',
            'pack_size',
            'biscuit_masters'
        ));
    }


    function OrderCreateEdit(Request $request)
    {

        $data = $request->all();

        Order::where('id', $request->id)->update([
            'date' => $request->date,
            'name' => $request->name,
            'order_no' => $request->order_no,
            'customer_name' => $request->customer_name,
            'contact_person' => $request->contact_person,
            'hide' => $request->hide,
        ]);



        if ($data && isset($data['category-group']) && $data['category-group']) {

            // dd($data['category-group']);

            foreach ($data['category-group'] as $index => $category) {

                $wrapper_design = '';
                $box_design = '';
                $approval_from_customer = '';

                if ($request->hasFile('category-group.' . $index . '.wrapper_design')) {
                    $file = $request->file('category-group.' . $index . '.wrapper_design');
                    $destinationPath = 'public/img/';
                    $wrapper_design = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path($destinationPath), $wrapper_design);
                }

                if ($request->hasFile('category-group.' . $index . '.box_design')) {
                    $file = $request->file('category-group.' . $index . '.box_design');
                    $destinationPath = 'public/img/';
                    $box_design = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path($destinationPath), $box_design);
                }

                if ($request->hasFile('category-group.' . $index . '.approval_from_customer')) {
                    $file = $request->file('category-group.' . $index . '.approval_from_customer');
                    $destinationPath = 'public/img/';
                    $approval_from_customer = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path($destinationPath), $approval_from_customer);
                }

                OrderProduct::where('order_id', $request->id)->update([
                    'product' => $category['product'],
                    'brand_name' => $category['brand_name'],
                    'pack_size' => $category['pack_size'],
                    'qty_container' => $category['qty_container'],
                    'reqd_oty' => $category['reqd_oty'],
                    'container_date' => $category['container_date'],
                    'container_booked' => $category['container_booked'],
                    'die_name' => $category['die_name'],
                    'wrapper_design' => $wrapper_design,
                    'box_design' => $box_design,
                    'approval_from_customer' => $approval_from_customer,
                ]);
            }
        }
        return redirect()->route('Order.Create');
    }


    public function getin()
    {
        $type = typeMaster::all();
        $company = masterCompany::all();
        $items = itemsMaster::all();
        $UOM = UomMaster::all();
        return view('getin', compact('type', 'company', 'items', 'UOM'));
    }

    function getInCreate(Request $request)
    {
        $originalFile = '';
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $destinationPath = 'public/img/';
            $originalFile = $file->getClientOriginalName();
            $file->move($destinationPath, $originalFile);
        }

        // dd($request->all());

        $getIn = getIn::create([
            'type_id' => $request->type_id,
            'date' => $request->date,
            'time' => $request->time,
            'company_id' => $request->company_id,
            'location' => $request->location,
            'inv_challan_number' => $request->inv_challan_number,
            'inv_challan_date' => $request->inv_challan_date,
            'vehicle_number' => $request->vehicle_number,
            'mobile' => $request->mobile,
            'img' => $originalFile,
        ]);

        $data = $request->all();

        // dd($data);

        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $category) {

                getInItem::create([
                    'get_in_id' => $getIn->id,
                    'item_id' => $category['item_id'],
                    'quantity' => $category['quantity'],
                    'uom_id' => $category['uom_id'],
                    'rate' => $category['rate'],
                    'amount' => $category['amount'],
                    'remark' => $category['remark'],
                ]);
            }
        }
        return redirect()->route('getin');
    }

    public function getout()
    {
        $type = typeMaster::all();
        $company = masterCompany::all();
        $items = itemsMaster::all();
        $UOM = UomMaster::all();
        return view('getout', compact('type', 'company', 'items', 'UOM'));
    }

    function getOutCreate(Request $request)
    {
        $originalFile = '';
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $destinationPath = 'public/img/';
            $originalFile = $file->getClientOriginalName();
            $file->move($destinationPath, $originalFile);
        }

        // dd($request->all());

        $getOut = getOut::create([
            'type_id' => $request->type_id,
            'date' => $request->date,
            'time' => $request->time,
            'company_id' => $request->company_id,
            'location' => $request->location,
            'inv_challan_number' => $request->inv_challan_number,
            'inv_challan_date' => $request->inv_challan_date,
            'vehicle_number' => $request->vehicle_number,
            'mobile' => $request->mobile,
            'img' => $originalFile,
        ]);

        $data = $request->all();


        if ($data && isset($data['category-group']) && $data['category-group']) {
            foreach ($data['category-group'] as $category) {

                getOutItem::create([
                    'get_out_id' => $getOut->id,
                    'item_id' => $category['item_id'],
                    'quantity' => $category['quantity'],
                    'uom_id' => $category['uom_id'],
                    'rate' => $category['rate'],
                    'amount' => $category['amount'],
                    'remark' => $category['remark'],
                ]);
            }
        }
        return redirect()->route('getout');
    }

    public function getInView()
    {
        $getInData = getIn::all();
        return view('get-in-view');
    }

    public function getOutView()
    {
        return view('get-out-view');
    }
}
