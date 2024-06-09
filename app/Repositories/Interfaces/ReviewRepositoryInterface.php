<?php
namespace App\Repositories\Interfaces;

Interface ReviewRepositoryInterface{
    
    public function allReview();
    public function weeklyReview();
    public function weeklyReviewPercentageChange();
    public function weeklyReviewChart();
    public function storeReview($data);
    public function findReview($id);
    public function updateReview($data, $id); 
    public function updateLikes($data, $id);
    public function destroyReview($id);
}