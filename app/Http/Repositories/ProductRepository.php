<?php

namespace App\Http\Repositories;

use App\Traits\DataStoreTrait;
use Exception;
use Throwable;
use Illuminate\Support\Facades\File;

/**
 * Store and retrieve data from the Json File.
 */
class ProductRepository
{
    use DataStoreTrait;

    public function getAllProducts()
    {
        $data = file_get_contents($this->getPath());

        if (empty($data))
            return [];

        return json_decode($data, true);
    }

    public function addProduct($productData)
    {
        $productCount = count($this->getAllProducts());

        $now = date("Y-m-d H:i:s");

        $totalValue = $productData['quantity'] * $productData['price'];

        $count = $productCount + 1;

        $productRow = [
            'count' => $count,
            'name' => $productData['name'],
            'quantity' => $productData['quantity'],
            'price' => $productData['price'],
            'submitted' => $now,
            'total_value' => $totalValue,
        ];

        try {
            $this->saveProduct($productRow);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $productRow;
    }

    /**
     * @param string|int $productId
     * @throws Exception
     * @return array
     */
    public function getProductById($productId)
    {
        //Return the one that the count matches the productId.
        $products = $this->getAllProducts();

        foreach ($products as $product) {
            if ($product['count'] == $productId)
                return $product;
        }


        throw new Exception("Product Not Found");
    }

    public function updateProduct($productData, $productId)
    {
        // $product = $this->getProductById($productId);

        $products = $this->getAllProducts();

        foreach ($products as &$product) {
            if ($product['count'] == $productId) {
                $product['name'] = $productData['name'];
                $product['quantity'] = $productData['quantity'];
                $product['price'] = $productData['price'];
            }
        }

        //now save the products.
        $this->saveToFile($products);
    }

    private function saveProduct($productRow)
    {
        //get all products 
        $products = $this->getAllProducts();

        array_push($products, $productRow);

        $this->saveToFile($products);
    }

    private function saveToFile($products)
    {
        try {
            File::put($this->getPath(), json_encode($products));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
