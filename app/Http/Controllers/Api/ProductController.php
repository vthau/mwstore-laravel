<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Exception;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function get_product($slug)
    {
        $product = $this->productService->getBySlug($slug);
        if (!$product) {
            return $this->errorResponse();
        }
        return $this->successResponse($product);
    }

    public function get_product_feather()
    {
        $products = $this->productService->getProductFeather();
        return $this->successResponse($products);
    }

    public function get_product_view()
    {
        $products = $this->productService->getProductTop();
        return $this->successResponse($products);
    }

    public function get_product_new()
    {
        $products = $this->productService->getProductFeather();
        return $this->successResponse($products);
    }

    public function get_product_more()
    {
        $products = $this->productService->getProductPaginate();
        return $this->successResponse($products);
    }

    public function get_product_brand($brand_id)
    {
        $products = $this->productService->getByBrand($brand_id);
        return $this->successResponse($products);
    }

    public function update_view_product($slug)
    {
        $this->productService->updateView($slug);
    }

    public function search(Request $req)
    {
        $products = $this->productService->searchProduct($req);
        return $this->successResponse($products);
    }

    public function all_product()
    {
        $products = $this->productService->getAllProduct();
        return $this->successResponse($products);
    }

    public function product_not_post()
    {
        $products = $this->productService->getProductNoPost();
        return $this->successResponse($products);
    }

    public function top_product()
    {
        $products = $this->productService->getProductTop();
        return $this->successResponse($products);
    }

    public function new_product(Request $req)
    {
        try {
            $this->productService->save($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update_product(Request $req)
    {
        try {
            $this->productService->update($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function product_crawl(Request $req)
    {
        $products = $this->productService->getProductCrawl($req);
        return $this->successResponse($products);
    }

    public function add_product_crawl(Request $req)
    {
        try {
            $this->productService->saveProductCrawl($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete_product(Request $req)
    {
        try {
            $this->productService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
