<?php

namespace App\Http\Controllers\API;

use App\Http\Interfaces\ProductRepositoryInterface;
use App\Trait\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Throwable;

class ProductController extends Controller
{
    use ApiResponse;
    private $ProductRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->ProductRepository = $productRepository;
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->ProductRepository->index();
            return $this->SuccessMany($data, ProductResource::class, 'Products indexed Successfully');
        } catch (Throwable $th) {
            return $this->Error($th);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();
            $data = $this->ProductRepository->store($data);
            return $this->SuccessOne($data, ProductResource::class, 'Product Stored Successfully');
        } catch (Throwable $th) {
            return $this->Error($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = $this->ProductRepository->show($id);
            return $this->SuccessOne($data, ProductResource::class, 'Product fetched Successfully');
        } catch (Throwable $th) {
            return $this->Error($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data = $this->ProductRepository->update($id, $data);
            return $this->SuccessOne($data, ProductResource::class, 'Product updated Successfully');
        } catch (Throwable $th) {
            return $this->Error($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = $this->ProductRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Product deleted Successfully');
        } catch (Throwable $th) {
            return $this->Error($th);
        }
    }
}
