<?php

namespace App\Controllers;

class PrivacyController extends BaseController
{
    public function termsAndConditions()
    {
        return view('terms_and_conditions');
    }

    public function  privacyPolicy()
    {
        return view('privacy_policy');
    }
}
