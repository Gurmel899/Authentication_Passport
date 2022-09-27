<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
// use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'data'=>$products,

            'messege'=>'product created successfuly',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input =$request->all();
        $validator = Validator::make($input,[

            'name'=>'required',
            'detail'=>'required',
        ]);
        if($validator->fails()) {
          return $this->sendError('Validation Error.',$validator->errors());
        }

        $product= Product::create($input);

        // return $this->sendResponse(new ProductResource($product),'product created successfuly');
       return response()->json([
        'product'=>$product,
        'messege'=>'product created successfuly',
       ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('product not found');
        }

        return $this->sendResponse(new ProductResource($product),'product retrieved successfuly');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();

        $validator = Validator::make($input,[
            'name'=>'required',
            'detail'=>'required',

        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.',$validator->errors());
        }

        $product->name = $input['name'];
        $product->detail=$input['detail'];
        $product->save();

        return $this->sendResponse(new ProductResource($product),'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
       return response()->json([
       'messege'=>'product deleted successfuly',
       ]);
    }
}