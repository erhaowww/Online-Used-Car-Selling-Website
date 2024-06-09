<?php
namespace App\Observers;

require_once "Subject.php";
interface observer
{
    public function all();
    public function store(Subject $subject);
    public function find(Subject $subject);
    public function findMyCars(Subject $subject);
    public function findMyCarsOnBid(Subject $subject);
    public function findOrder(Subject $subject);
    public function update(Subject $subject);
    public function updateAll(Subject $subject);
    public function addToCart(Subject $subject);
    public function deleteCart(Subject $subject);
    public function delete(Subject $subject);
}
