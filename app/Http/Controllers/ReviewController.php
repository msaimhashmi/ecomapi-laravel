<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\ReviewRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
        // return Review::all();
    }

    public function store(ReviewRequest $request, Product $product)
    {
        $review = new Review($request->all());
        $product->reviews()->save($review);
        return response([
            'data' => new ReviewResource($review)
        ], Response::HTTP_CREATED);
    }

    public function show(Product $product, Review $review)
    {
        return new ReviewResource($review);
        // try
        // {
        //     $review = Review::findOrFail($id);
        //     return new ReviewResource($review);
        // }
        // catch(NotFoundHttpException $exception)
        // {
        //     throw new RouteNotFoundException();
        // }
        // catch(ModelNotFoundException $exception)
        // {
        //     throw new ProductModelNotFoundException();
        // }
    }

    public function update(Request $request, Product $product, Review $review)
    {
        $review->update($request->all());
        return response([
            'data' => new ReviewResource($review)
        ], Response::HTTP_CREATED);
    }

    public function destroy(Product $product, Review $review)
    {
        $review->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
