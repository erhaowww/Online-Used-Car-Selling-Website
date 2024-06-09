<?php
namespace App\Observers;

require_once "Subject.php";

class ProductData extends Subject
{
    private $id;
    private $user_id;
    private $make;
    private $model;
    private $year;
    private $mileage;
    private $color;
    private $transmission;
    private $product_description;
    private $product_image;
    private $price;
    private $deleted;

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getMake()
    {
        return $this->make;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getMileage()
    {
        return $this->mileage;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getTransmission()
    {
        return $this->transmission;
    }

    public function getProductDescription()
    {
        return $this->product_description;
    }

    public function getProductImage()
    {
        return $this->product_image;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDeleted()
    {
        return $this->deleted;
    }

    public function setMake($make): void
    {
        $this->make = $make;
        $this->notifyUpdate();
    }

    public function setModel($model): void
    {
        $this->model = $model;
        $this->notifyUpdate();
    }

    public function setYear($year): void
    {
        $this->year = $year;
        $this->notifyUpdate();
    }

    public function setMileage($mileage): void
    {
        $this->mileage = $mileage;
        $this->notifyUpdate();
    }

    public function setColor($color): void
    {
        $this->color = $color;
        $this->notifyUpdate();
    }

    public function setTransmission($transmission): void
    {
        $this->transmission = $transmission;
        $this->notifyUpdate();
    }

    public function setProductDescription($product_description): void
    {
        $this->product_description = $product_description;
        $this->notifyUpdate();
    }

    public function setProductImage($product_image): void
    {
        $this->product_image = $product_image;
        $this->notifyUpdate();
    }

    public function setPrice($price): void
    {
        $this->price = $price;
        $this->notifyUpdate();
    }

    public function setDeleted($deleted): void
    {
        $this->deleted = $deleted;
        $this->notifyUpdate();
    }

    public function storeAll($data): void
    {
        $this->user_id  = $data['user_id'];
        $this->make     = $data['make'];
        $this->model    = $data['model'];
        $this->year     = $data['year'];
        $this->mileage  = $data['mileage'];
        $this->color    = $data['color'];
        $this->transmission = $data['transmission'];
        $this->product_description = $data['product_description'];
        $this->price = $data['price'];
        $this->product_image = $data['product_image'];
        $this->deleted = $data['deleted'];
        $this->notifyStore();
    }

    public function retrieveAll()
    {
        return $this->notifyRetrieveAll();
    }

    public function find($id)
    {
        $this->id = $id;
        return $this->notifyFind();
    }

    public function findMyCars($user_id)
    {
        $this->user_id = $user_id;
        return $this->notifyFindMyCars();
    }

    public function findMyCarsOnBid($user_id)
    {
        $this->user_id = $user_id;
        return $this->notifyFindMyCarsOnBid();
    }

    public function findOrder($user_id)
    {
        $this->user_id = $user_id;
        return $this->notifyFindOrder();
    }

    public function updateAll($data): void
    {
        $this->id  = $data['id'];
        $this->make     = $data['make'];
        $this->model    = $data['model'];
        $this->year     = $data['year'];
        $this->mileage  = $data['mileage'];
        $this->color    = $data['color'];
        $this->transmission = $data['transmission'];
        $this->product_description = $data['product_description'];
        $this->price = $data['price'];
        $this->product_image = $data['product_image'];
        $this->notifyUpdateAll();
    }

    public function addToCart($data)
    {
        $this->id  = $data['product_id'];
        $this->user_id  = $data['user_id'];
        return $this->notifyAddToCart();
    }

    public function deleteCart($data)
    {
        $this->id  = $data['product_id'];
        $this->user_id  = $data['user_id'];
        return $this->notifyDeleteCart();
    }

    public function delete($id)
    {
        $this->id = $id;
        return $this->notifyDelete();
    }

    public function __toString()
    {
        return "User ID:" . $this->user_id . "Make:" . $this->make . "Model:" . $this->model . "Year:" . $this->year . "Mileage:" . $this->mileage . "Color:" . $this->color . "Transmission:" . $this->transmission . "Description:" . $this->product_description . "Image:" . $this->product_image . "Price:" . $this->price;
    }
}
