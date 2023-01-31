<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductRepository $productRepository
     */
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function productList()
    {
        $products = $this->productRepository->getAllProducts();
        // dd($products);
        return view('product.index', compact('products'));
    }

    public function newProduct(Request $request)
    {
        if ($request->isMethod('POST')) {
            //validate the data..
            $this->validate($request, [
                'name' => "required",
                'quantity' => 'required|numeric',
                'price' => 'required|numeric'
            ]);
    
            //save the product
            $data = $request->except('_token');
    
            try {
                $this->productRepository->addProduct($data);
    
                session()->flash('success', 'Product Save successfully');
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
    
                session()->flash('error', $errorMessage);
            }
    
            return back();
            # code...
        }

        
    }

    public function editProduct(Request $request, $productId)
    {
        if ($request->isMethod('POST')) {
            //validate the data..
            $this->validate($request, [
                'name' => "required",
                'quantity' => 'required|numeric',
                'price' => 'required|numeric'
            ]);

            try {
                $this->productRepository->updateProduct($request->all(), $productId);
                session()->flash('success', 'Product Updated');
            } catch (\Exception $e) {
                session()->flash('error', $e->getMessage());
            }

            return redirect()->route('list.product');
        }
        try {
            $product = $this->productRepository->getProductById($productId);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            session()->flash('error', $errorMessage);
            return back();
        }
        
        return view('product.edit', compact('product'));
    }
}
