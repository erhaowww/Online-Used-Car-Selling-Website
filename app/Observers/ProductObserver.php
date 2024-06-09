<?php
namespace App\Observers;

use App\Models\Product;
use App\Models\Order;

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class ProductObserver implements Observer{
    public function all(){
        return Product::where('deleted', 0)->get();
    }

    public function store(Subject $subject){
        Product::create([
            'user_id' => $subject->getUserId(),
            'make' => $subject->getMake(),
            'model' => $subject->getModel(),
            'year' => $subject->getYear(),
            'mileage' => $subject->getMileage(),
            'color' => $subject->getColor(),
            'transmission' => $subject->getTransmission(),
            'product_description' => $subject->getProductDescription(),
            'price' => $subject->getPrice(),
            'product_image' => $subject->getProductImage(),
            'deleted' => false,
        ]);
    }

    public function find(Subject $subject){
        return Product::find($subject->getProductId());
    }

    public function findMyCars(Subject $subject){
        return Product::where('products.user_id', $subject->getUserId())
        ->where('products.deleted', 0)
        ->get();
    }

    public function findMyCarsOnBid(Subject $subject){
        return Product::where('products.user_id', $subject->getUserId())
        ->where('products.deleted', 0)
        ->join('orders', 'products.id', '=', 'orders.product_id')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->select('products.*', 'orders.status as order_status', 'users.name as bidderName', 'users.email as bidderEmail', 'users.phoneNum as bidderPhoneNum')
        ->get();
    }

    public function findOrder(Subject $subject){
        return Order::join('products', 'orders.product_id', '=', 'products.id')
                    ->where('orders.user_id', $subject->getUserId())
                    ->whereIn('orders.status', ['available', 'sold'])
                    ->select('products.*', 'orders.status', 'orders.id as orderId')
                    ->get();
    }

    public function update(Subject $subject){

    }

    public function updateAll(Subject $subject){
        $product = Product::find($subject->getProductId());
        $product->make = $subject->getMake();
        $product->model = $subject->getModel();
        $product->year = $subject->getYear();
        $product->mileage = $subject->getMileage();
        $product->color = $subject->getColor();
        $product->transmission = $subject->getTransmission();
        $product->product_description = $subject->getProductDescription();
        $product->price = $subject->getPrice();
        $product->product_image = $subject->getProductImage();
        $product->save();
    }

    public function addToCart(Subject $subject){
        // Check if an order already exists for the user_id and product_id
        $order = Order::where('user_id', $subject->getUserId())
                        ->where('product_id', $subject->getProductId())
                        ->first();

        if (!$order) {
            // If no order exists, create a new one with status 'available'
            Order::create([
                'user_id' => $subject->getUserId(),
                'product_id' => $subject->getProductId(),
                'status' => 'available',
            ]);
            return true;
        } 
        else if ($order->status === 'deleted') {
            // If an order exists but its status is 'deleted', update its status to 'available'
            $order->update(['status' => 'available']);
            return true;
        }
        return false;
    }
    
    public function deleteCart(Subject $subject){
        // Check if an order already exists for the user_id and product_id
        $order = Order::where('user_id', $subject->getUserId())
        ->where('product_id', $subject->getProductId())
        ->first();

        if ($order) {
            // Update the order status to "deleted"
            $order->status = 'deleted';
            $order->save();
            return true;
        }
        return false;
    }

    public function delete(Subject $subject){
        $product = Product::find($subject->getProductId());
        $product->deleted = 1;
        $product->save();
    }

    
}