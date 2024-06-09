<?php

namespace App\Builders\Interfaces;

interface PaymentBuilderInterface
{
    public function create($data);
    
    public function readAll();
    
    public function readById($id);
    
    public function update($id, $data);
    
    public function delete($id);

    public function weeklySales($weeksAgo);

    public function weeklySalesPercentageChange();

    public function weeklySalesChart();

    public function popularCarMakeChart();

}
