<?php
/**
 * Created by PhpStorm.
 * User: Sugito
 * Date: 10/27/2016
 * Time: 10:12 AM
 */

namespace App\Http\Controllers;

use App\Model\ProductUnit;
use App\Model\Receipt;
use App\Model\Stock;
use App\Model\StockIn;
use App\Model\Warehouse;
use App\Model\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class WarehouseInflowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inflow($id = null)
    {
        $warehouseDDL = Warehouse::all();
        $warehouse = Warehouse::with('purchaseOrders.supplier')->find($id);

        return view('warehouse.inflow', compact('warehouseDDL', 'warehouse'));
    }

    public function receipt($id)
    {
        $po = PurchaseOrder::with('items.product.productUnits.unit')->find($id);

        return view('warehouse.receipt', compact('po'));
    }

    public function saveReceipt(Request $request, $id)
    {

        for ($i = 0; $i < sizeof($request->input('item_id')); $i++) {
            $conversionValue = ProductUnit::where([
                'product_id' => $request->input("product_id.$i"),
                'unit_id' => $request->input("selected_unit_id.$i")
            ])->first()->conversion_value;

            $receiptParams = [
                'receipt_date' => date('Y-m-d', strtotime($request->input('receipt_date'))),
                'brutto' => $request->input("brutto.$i"),
                'base_brutto' => $conversionValue * $request->input("brutto.$i"),
                'netto' => $request->input("netto.$i"),
                'base_netto' => $conversionValue * $request->input("netto.$i"),
                'tare' => $request->input("tare.$i"),
                'base_tare' => $conversionValue * $request->input("tare.$i"),
                'licence_plate' => $request->input('licence_plate'),
                'item_id' => $request->input("item_id.$i"),
                'selected_unit_id' => $request->input("selected_unit_id.$i"),
                'base_unit_id' => $request->input("base_unit_id.$i"),
                'store_id' => Auth::user()->store_id
            ];

            $stockParams = [
                'store_id' => Auth::user()->store_id,
                'po_id' => $id,
                'product_id' => $request->input("product_id.$i"),
                'warehouse_id' => $request->input('warehouse_id'),
                'quantity' => $request->input("netto.$i"),
                'current_quantity' => $request->input("netto.$i")
            ];

            $receipt = Receipt::create($receiptParams);
            $stock = Stock::create($stockParams);

            $stockInParams = [
                'store_id' => Auth::user()->store_id,
                'po_id' => $id,
                'product_id' => $request->input("product_id.$i"),
                'warehouse_id' => $request->input('warehouse_id'),
                'stock_id' => $stock->id,
                'quantity' => $request->input("netto.$i")
            ];

            $stockIn = StockIn::create($stockInParams);
        }

        return redirect(route('db.warehouse.inflow.index'));
    }
}