<?php

namespace App\Domains\Product\Http\Controllers\Api;

use App\Domains\Product\Services\FavoritesService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoritesController extends Controller
{
    protected FavoritesService $favoritesService;

    /**
     * @param FavoritesService $favoritesService
     */
    public function __construct(FavoritesService $favoritesService)
    {
        $this->favoritesService = $favoritesService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function count(Request $request)
    {
        return response()->json([
            'count' => $this->favoritesService->count()
        ]);
    }

    /**
     * @param $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($productId, Request $request)
    {
        $this->validateRequest($productId);
        $cookie = $this->favoritesService->store($productId);
        return response()->json([
            'count' => $this->favoritesService->count()
        ]);
    }

    /**
     * @param $productId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($productId, Request $request)
    {
        $this->validateRequest($productId);
        $this->favoritesService->delete($productId);
        return response()->json([
            'count' => $this->favoritesService->count()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $this->favoritesService->destroy();
        return response()->json([
            'count' => $this->favoritesService->count()
        ]);
    }

    /**
     * @param $productId
     */
    protected function validateRequest($productId)
    {
        Validator::validate([
            'id' => $productId
        ], [
            'id' => 'required|integer|exists:products,id'
        ]);
    }
}
