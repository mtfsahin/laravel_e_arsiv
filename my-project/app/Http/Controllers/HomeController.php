<?php

namespace App\Http\Controllers;
use App\Helpers\UblInvoiceCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function myButtonClicked(Request $request)
    {

        UblInvoiceCreator::create();


    }
}
