<?php

namespace App\Src\Users\Inventories\Controllers;

use App\Domain\Inventories\Dtos\PriceListFilterDTO;
use App\Domain\Inventories\Models\Product;
use App\Src\Shared\Controllers\Controller;
use App\Src\Users\Inventories\Requests\FilterProductRequest;
use App\Src\Users\Inventories\Resources\ProductResource;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(protected Product $product)
    {
    }

    public function index(FilterProductRequest $request)
    {
        return ProductResource::collection($this->product->list(
            priceListFilter: PriceListFilterDTO::new()
                ->buildFromRequest($request)
                ->when(
                    Auth::guard('user')->check(),
                    fn($dto) => $dto->fallbackFromUser($request->user('user'))
                ),
        ))
            ->additional([
                'message' => __('global.response_messages.ok')
            ]);
    }

    public function show(FilterProductRequest $request, int $productId)
    {
        return $this->successResponse(data: [
            'product' => ProductResource::make($this->product->findOrFailById(
                $productId,
                priceListFilter: PriceListFilterDTO::new()
                    ->buildFromRequest($request)
                    ->when(
                        Auth::guard('user')->check(),
                        fn($dto) => $dto->fallbackFromUser($request->user('user'))
                    ),
            ))
        ]);
    }
}
