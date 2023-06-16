<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\AttributeProduct;
use App\Models\AttributeProductValue;
use App\Models\Product;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function getAll(Request $request)
    {

        try {
            $data = Product::filter()
            // order
            ->when($request->item && $request->type, function($query) use ($request) {
                $query->with(['AttributeProducts' =>  function($q) use ($request) {
                    $q->with(['attributeProductValues' => function($q) use ($request) {
                           $q->orderBy($request->item, $request->type);
                        }]);
                    }])->get();
                })
            ->get(); 

            return $this->successResponse([
                'products' => ProductResource::collection($data),
            ]);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validators = [
                'user_id'              => ['required', 'integer'],
                'title'                => ['required', 'string', 'unique:products', 'max:255'],
                'image_location'       => ['required']
            ];

            validateForm($request->all(), $validators);

            /* Store Image **/
            $path = storeImage($request->image_location);

            $product = Product::create(array_merge($request->all(), ['image_location' => $path]));

            return $this->successResponse([
                'product' => new ProductResource($product),
            ], __('messages.Product Successfully Created'));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::find($id);

            return $this->successResponse([
                'product' => new ProductResource($product),
            ]);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $product = Product::find($id);

            $validator = Validator::make($request->all(), [
                'user_id'              => ['required', 'integer'],
                'title'                => ['required', 'string', 'max:255'],
                'image_location'       => ['required']
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 422);
            }

            /* Store Image **/
            $path = storeImage($request->file('image_location'));

            $product->update([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'image_location' => $path,
                'description' => $request->description
            ]);

            return $this->successResponse([
                'product' => new ProductResource($product),
            ], __('messages.Product Successfully Updated'));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Product::find($id)->delete();

            return $this->successResponse([], __('messages.Product Successfully Deleted'));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

}
