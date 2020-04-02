<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Models\Product;
use App\Models\Cart;
use App\Http\Requests\CartRequest;
use App\Http\Requests\MailerRequest;

class ProductController extends Controller
{
    /**
     * The Controller instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepository $repository)
    // public function __construct()
    {
        //$this->middleware('auth');
        $this->repository= $repository;

    }

    /**
     * Show the application home-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index(Request $request, ProductRepository $repository)
    public function index(Request $request) //$_POST['...'], $_GET['top9'],  $_GET['search'].
    {
        
        $products = $this->repository->funcSelect($request); // $_GET['top9'],  $_GET['search'] == $request->top9, $request->search
         // $products = $repository->funcSelect($request);


        // Ajax response
        if ($request->ajax()) {
            return response()->json([
                'table' => view("product.brick-standard", ['products' => $products])->render(),
            ]);
        } 
         // Submit response
        return view('product.index', compact('products')); //['products' => $products]

    }

    /**
     * Show the application product-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function product($id, Product $model_product)
    {
        //$product = $this->repository->funcSelectOne($id); first variant!
        $product = $model_product->find($id);
        return view('product.product', compact('product'));
    }

    /**
     * Show the application cart-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cart(Request $request)
    {

         $carts = $this->repository->fromCart(); //добавлено

          // Ajax response
         if ($request->ajax()) {
            return response()->json([
                'table' => view("product.cart-standard", ['carts' => $carts])->render(),
            ]);
        } 

        return view('product.cart',  compact('carts'));
    }

    /**
     * Store data to cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tocart(CartRequest $request) //-> отсюда переходим ProductRepository.php
    {   
        $this->repository->store($request);

        return redirect(route('cart')); //(url('/cart'));
        
        //return view('product.cart');
    }

    /**
     * Remove all cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clearall(Request $request, Cart $model_cart) //-> отсюда переходим ProductRepository.php
    {   
        //$this->repository->clearall();
         $model_cart->truncate(); 

          // Ajax response
         if ($request->ajax()) {
            return response()->json([
            ]);
        } 

        return redirect(route('cart')); //(url('/cart')); //после перегрузки страницы возврат страницы на изходное положение.
        
    }

     /**
     * Remove one from cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clearone(Request $request) //-> отсюда переходим ProductRepository.php
    {   
        $this->repository->clearone($request); //$request->id       
    }

    /**
     * Mailer for sending message and contact.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mailer(MailerRequest $request) //-> отсюда переходим ProductRepository.php
    {   
         if(isset($request->validator) && $request->validator->fails()) //if you need validator->errors() in Controller
        {
            return json_encode($request->validator->errors());
        }
        
       return $this->repository->mailer($request);      
    }
}
