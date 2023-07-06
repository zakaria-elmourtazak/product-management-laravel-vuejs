<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  index(Request $request)
    {
        $perPage = $request->query('per_page', 10); 
    $page = $request->query('page', 1); 
    $query= $request->query('query'); 
    $searchby = $request->query('searchby'); 

    $products =null;
    if($searchby=='price'){
        $products = Product::where($searchby,$query)->paginate($perPage);
    }else{
        $products = Product::where($searchby, 'like', "%".$query."%")->paginate($perPage);

    }
    return response()->json([
        'data' => $products->items(),
        'pagination' => [
            'total' => $products->total(),
            'per_page' => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
        ],
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status'=> 422,
                'errors' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    
            return Product::create($request->all());
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $product = Product::find($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status'=> 422,
                'errors' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    // public function search(Request $request)
    // {
    // // $name = $request->query('name', 's');
    // // $query = $request->get('name');
 
    // $perPage = $request->query('per_page', 10); 
    // $page = $request->query('page', 1); 
    // $name = $request->query('name'); 

    //  $products = Product::where('name', 'like', "%".$name."%")
    //     ->paginate($perPage);

    //     return response()->json([
    //         'data' => $products->items(),
    //         'pagination' => [
    //             'total' => $products->total(),
    //             'per_page' => $products->perPage(),
    //             'current_page' => $products->currentPage(),
    //             'last_page' => $products->lastPage(),
    //         ],
    //     ]);
    //     // return Product::where('name', 'like', '%'.$name.'%')->get();
    // }
}
