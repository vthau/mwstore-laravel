<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use InvalidArgumentException;

class ProductService
{

    protected $productRepository;

    protected function addStar($products)
    {

        if ($products instanceof \Illuminate\Database\Eloquent\Model) {
            $products['star'] = $products->star();
            return $products;
        }

        foreach ($products as $product) {
            $star = $product->star();
            if (!$star) $star = 0;
            $product['star'] = $star;
        }

        return $products;
    }

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getCount()
    {
        return $this->productRepository->getCount();
    }

    public function searchProduct($data)
    {
        $products = $this->productRepository->searchProduct($data);
        return $this->addStar($products);
    }

    public function getBySlug($slug)
    {
        $product = $this->productRepository->getBySlug($slug);
        return $this->addStar($product);
    }

    public function getByBrand($brand_id)
    {
        $products = $this->productRepository->getByBrand($brand_id);
        return $this->addStar($products);
    }

    public function getProductFeather()
    {
        $products = $this->productRepository->getProductFeather();
        return $this->addStar($products);
    }

    public function getProductNew()
    {
        $products = $this->productRepository->getProductNew();
        return $this->addStar($products);
    }

    public function getProductNoPost()
    {
        return $this->productRepository->getProductNoPost();
    }

    public function getAllProduct()
    {
        return $this->productRepository->getAllProduct();
    }

    public function getProductPaginate()
    {
        $products = $this->productRepository->getProductPaginate();
        return $this->addStar($products);
    }

    public function getProductTop()
    {
        return $this->productRepository->getProductTop();
    }

    public function getProductCrawl($data)
    {
        return $this->productRepository->getProductCrawl($data);
    }

    public function updateView($slug)
    {
        return $this->productRepository->updateView($slug);
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('FAIL');
        }

        DB::commit();

        return $product;
    }

    public function saveProductCrawl($data)
    {
        $product = $this->productRepository->getByName($data->name);
        if ($product) {
            throw new Exception("PRODUCT_EXIST");
        }

        DB::beginTransaction();

        try {
            $product = $this->productRepository->saveProductCrawl($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('FAIL');
        }

        DB::commit();

        return $product;
    }

    public function update($data)
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepository->update($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('FAIL');
        }

        DB::commit();

        return $product;
    }

    public function delete($data)
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('FAIL');
        }

        DB::commit();

        return $product;
    }
}
