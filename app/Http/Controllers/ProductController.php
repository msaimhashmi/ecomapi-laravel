<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\ProductModelNotFoundException;
use App\Exceptions\ProductNotBelongsToUser;
use App\Exceptions\RouteNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }

    public function index()
    {
        try{
            return ProductCollection::collection(Product::paginate(20));
        }
        catch(\Exception $exception) {
            throw new ProductModelNotFoundException();
        }
    }


    public function store(ProductRequest $request)
    {
        $product = new Product;
        $product->user_id = Auth::id();
        $product->name = $request->name;
        $product->detail = $request->description;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->stock = $request->stock;
        $product->save();

        return response([
            'data' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        try
        {
            $product = Product::findOrFail($id);
            return new ProductResource($product);
        }
        catch(NotFoundHttpException $exception)
        {
            throw new RouteNotFoundException();
        }
        catch(ModelNotFoundException $exception)
        {
            throw new ProductModelNotFoundException();
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $product = Product::findOrFail($id);
            $this->ProductUserCheck($product);
            $request['detail'] = $request['description'];
            unset($request['description']);
            $product->update($request->all());
    
            return response([
                'data' => new ProductResource($product)
            ], Response::HTTP_CREATED);
        }
        catch(NotFoundHttpException $exception)
        {
            throw new RouteNotFoundException();
        }
        catch(ModelNotFoundException $exception)
        {
            throw new ProductModelNotFoundException();
        }
    }

    public function destroy(Product $product)
    {
        $this->ProductUserCheck($product);
        $product->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function ProductUserCheck($product)
    {
        if(Auth::id() !== $product->user_id)
        {
            throw new ProductNotBelongsToUser;
        }
    }
}
