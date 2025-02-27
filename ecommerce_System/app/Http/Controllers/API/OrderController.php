<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\OrderRepositoryInterface;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Trait\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class OrderController extends Controller
{
    use ApiResponse;
    private $OrderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->OrderRepository = $orderRepository;
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $userId = Auth::id();
            $data = $this->OrderRepository->index(
                ['products'],
                function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            );
            return $this->SuccessMany($data, OrderResource::class, 'Orders indexed Successfully');
        } catch (Throwable $th) {
            return $this->Error($th);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            $data = $request->validated();
            $data = $this->OrderRepository->store($data);
            return $this->SuccessOne($data, OrderResource::class, 'Order Stored Successfully');
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
            $data = $this->OrderRepository->show($id);
            return $this->SuccessOne($data, OrderResource::class, 'Order fetched Successfully');
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
            $data = $this->OrderRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Order deleted Successfully');
        } catch (Throwable $th) {
            return $this->Error($th);
        }
    }
}
