<?php
namespace App\Models;

use Google_Service_ShoppingContent;

class GoogleContentApi
{
    protected $content;

    public function __construct(Google_Service_ShoppingContent $content)
    {
        $this->content = $content;
    }

    public function insertProduct($product)
    {
        $content = $this->content;

        $item = new Content\Product();
        $item->setOfferId($product['id']);
        $item->setTitle($product['title']);
        $item->setDescription($product['description']);
        $item->setLink($product['link']);
        $item->setImageLink($product['image']);
        $item->setPrice(new Content\Price(['value' => $product['price'], 'currency' => 'USD']));
        $item->setAvailability('in stock');

        $batch = new Content\ProductBatch();
        $batch->setEntries([new Content\ProductstatusesCustomBatchRequestEntry(), new Content\ProductsInsertRequest()]);
        $batch->getEntries()[0]->setMerchantId($merchantId);
        $batch->getEntries()[0]->setProductId($product['id']);
        $batch->getEntries()[1]->setProduct($item);

        $content->productstatuses->custombatch($batch);
        $content->products->insert($merchantId, $item);
    }
}

