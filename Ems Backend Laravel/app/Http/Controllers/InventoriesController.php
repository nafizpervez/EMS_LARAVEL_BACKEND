<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Http\Resources\InventoriesResource;
use App\Models\Attachments;

class InventoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InventoriesResource::collection(Inventory::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $inventory = Inventory::create([
                'added_by' => Auth::user()->id,
                'product_category' => $request->product_category,
                'product_name' => $request->product_name,
                'product_particulars' => $request->product_particulars,
                'client_name' => $request->client_name,
                'per_unit_price' => (int)$request->per_unit_price,
                'latest_stock' => (int)$request->latest_stock,
                'latest_stock_date' => Carbon::now()->format('Y-m-d'),
                'physically_found_quantity' => (int)$request->physically_found_quantity,
                'sales_quantity' => (int)$request->sales_quantity,
                'purchase_quantity' => (int)$request->purchase_quantity,
                'stock_quantity_to_be_reported' => (int)$request->stock_quantity_to_be_reported,
                'excess_quantity' => (int)$request->excess_quantity,
                'shortage_quantity' => (int)$request->shortage_quantity,
                'remarks' => $request->remarks,
            ]);


            if($request->hasfile('product_image')){
                $file_path = 'public/files/attachments';

                $av_path = Storage::put($file_path, $request->file('product_image'));

                if(env('APP_DEBUG')){
                    $av_path = Str::replace($file_path, 'http://127.0.0.1:8000/api/attachments', $av_path);
                }else{
                    $av_path = Str::replace($file_path, 'https://adnemsbacked.adntel.net/api/attachments', $av_path);
                }


                Attachments::create([
                    'related_to' => 'inventory',
                    'related_id' => $inventory->id,
                    'attachment_type' => 'jpg',
                    'attachment_url' => $av_path,
                ]);
            }

            return response()->json(new InventoriesResource($inventory), 200);
        } catch (\Throwable $th) {
            return response()->json(['Error'=> $th.''], 400);
        }
        

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        return response()->json(new InventoriesResource($inventory), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        if($request->hasfile('product_image')){
            $file_path = 'public/files/attachments';

            $av_path = Storage::put($file_path, $request->file('product_image'));

            if(env('APP_DEBUG')){
                $av_path = Str::replace($file_path, 'http://127.0.0.1:8000/api/attachments', $av_path);
            }else{
                $av_path = Str::replace($file_path, 'https://adnemsbacked.adntel.net/api/attachments', $av_path);
            }
            
            if ($inventory->image()) {
                $inventory->image()->delete();
            }

            Attachments::create([
                'related_to' => 'inventory',
                'related_id' => $inventory->id,
                'attachment_type' => 'jpg',
                'attachment_url' => $av_path,
            ]);
        }

        try {
            $inventory->update([
                'product_category' => is_null($request->product_category) ? $inventory->product_category:$request->product_category,
                'product_name' => is_null($request->product_name) ? $inventory->product_name:$request->product_name,
                'product_particulars' => is_null($request->product_particulars) ? $inventory->product_particulars:$request->product_particulars,
                'client_name' => is_null($request->client_name) ? $inventory->client_name:$request->client_name,
                'per_unit_price' => is_null($request->per_unit_price) ? $inventory->per_unit_price:$request->per_unit_price,
                'latest_stock' => is_null($request->latest_stock) ? $inventory->latest_stock:$request->latest_stock,
                'latest_stock_date' => is_null($request->latest_stock_date) ? $inventory->latest_stock_date:$request->latest_stock_date,
                'physically_found_quantity' => is_null($request->physically_found_quantity) ? $inventory->physically_found_quantity:$request->physically_found_quantity,
                'sales_quantity' => is_null($request->sales_quantity) ? $inventory->sales_quantity:$request->sales_quantity,
                'purchase_quantity' => is_null($request->purchase_quantity) ? $inventory->purchase_quantity:$request->purchase_quantity,
                'stock_quantity_to_be_reported' => is_null($request->stock_quantity_to_be_reported) ? $inventory->stock_quantity_to_be_reported:$request->stock_quantity_to_be_reported,
                'activity_update' => is_null($request->activity_update) ? $inventory->activity_update:$request->activity_update,
                'excess_quantity' => is_null($request->excess_quantity) ? $inventory->excess_quantity:$request->excess_quantity,
                'shortage_quantity' => is_null($request->shortage_quantity) ? $inventory->shortage_quantity:$request->shortage_quantity,
                'remarks' => is_null($request->remarks) ? $inventory->remarks:$request->remarks,
            ]);

            $inventory = Inventory::find($inventory->id);
            return response()->json(new InventoriesResource($inventory), 200);
        } catch (\Throwable $th) {
            return response()->json(['Error'=> $th.''], 400);
        }  
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        if ($inventory->image()) {
            $inventory->image()->delete();
        }

        $inventory->delete();
        return response()->json(['message'=> "Inventory Has been Removed",], 200);
    }
}
