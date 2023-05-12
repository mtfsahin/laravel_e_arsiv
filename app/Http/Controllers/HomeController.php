<?php

namespace App\Http\Controllers;

use App\Helpers\UblInvoiceCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\sendEArchiveInvoice;

use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function myButtonClicked(Request $request)
    {


        $orderID = "12345";
        $grand_total = 12.0;

        $order = [
            'order_id' => $orderID,
            'grand_total' => $grand_total
        ];

        $Customer_TCKN = '11111111111';
        $Customer_Adress = 'tam adress';
        $Customer_CitySubdivisionName = 'Çankaya';
        $Customer_CityName = 'Ankara';
        $Customer_Country = 'Türkiye';
        $Customer_Name = 'test';
        $Customer_LastName = 'testsurname';

        $customer = [
            'tckn' => $Customer_TCKN,
            'city_subdivision' => $Customer_CitySubdivisionName,
            'street_name' => $Customer_Adress,
            'city' => $Customer_CityName,
            'country' => $Customer_Country,
            'name' => $Customer_Name,
            'last_name' => $Customer_LastName
        ];

        $products = [
            [
                'name' => 'test',
                'price' => 1.00,
                'quantity' => 2,
                'tax' => 0.00,
                'tax_percent' => 0
            ],
            [
                'name' => 'test2',
                'price' => 1.00,
                'quantity' => 1,
                'tax' => 0.00,
                'tax_percent' => 0
            ],
        ];

        $xml_content = UblInvoiceCreator::create($order, $customer, $products);
        $storage_path = Storage::path('e_arsiv_invoice.xml');
        file_put_contents($storage_path, $xml_content);

        $xml = simplexml_load_string($xml_content);
        $documentUUID = (string)$xml->children('cbc', true)->UUID;
        $documentId = (string)$xml->children('cbc', true)->ID;
        $documentDate = (string)$xml->children('cbc', true)->IssueDate;
        $sourceUrn = "urn:mail:defaultgb@sahanekitap.com.tr";
        $destinationUrn = "mustafa9889.ma@gmail.com";

        sendEArchiveInvoice::send($xml_content, $destinationUrn, $documentDate, $documentUUID, $documentId, $sourceUrn);
    }
}
