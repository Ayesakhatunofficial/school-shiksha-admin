<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SubscriptionModel;
use CodeIgniter\HTTP\ResponseInterface;

class SubscriptionController extends BaseController
{
    public function checkPlan()
    {
        $model = new SubscriptionModel();

        $result = $model->checkSubscription();
        if ($result) {
            echo "Successfully Run";
        }
    }
}
