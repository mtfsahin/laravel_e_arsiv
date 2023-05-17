<?php

namespace App\Http\Controllers;

use App\Helpers\UblInvoiceCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\sendEArchiveInvoice;
class HomeController extends Controller
{
    public function myButtonClicked(Request $request)
    {
        function CreateEInvoice(){
            $orderID = "12351";
            $grand_total = 4.0;
            $coupon_discount = 1.0;
            $TaxInclusiveAmount = 4.0;
            $product_line = 2;
            $tax_total = 0.00;
            $tax_percent = 0.00;

            $Customer_TCKN = '11111111111';
            $Customer_Adress = 'tam adress';
            $Customer_CitySubdivisionName = 'Çankaya';
            $Customer_CityName = 'Ankara';
            $country = 'Turkey';
            $Customer_Country = ($country === 'Turkey') ? 'Türkiye' : 'Error Country!';
            $Customer_Name = 'test';
            $Customer_LastName = 'testsurname';

            $admin_products = [
                [
                    'name' => 'test',
                    'price' => 2.00,
                    'quantity' => 2,
                    'tax' => 0.00,
                    'tax_percent' => 0,
                    'discount' => 1,
                ],
                [
                    'name' => 'test2',
                    'price' => 1.00,
                    'quantity' => 1,
                    'tax' => 0.00,
                    'tax_percent' => 0,
                    'discount' => 0,
                ],
            ];

            $order = [
                'order_id' => $orderID,
                'grand_total' => $grand_total,
                'product_line' =>  $product_line,
                'tax_total' => $tax_total,
                'tax_percent' => $tax_percent,
                'tax_insclusive' => $TaxInclusiveAmount,
                'coupon_discount' => $coupon_discount,

            ];

            $customer = [
                'tckn' => $Customer_TCKN,
                'city_subdivision' => $Customer_CitySubdivisionName,
                'street_name' => $Customer_Adress,
                'city' => $Customer_CityName,
                'country' => $Customer_Country,
                'name' => $Customer_Name,
                'last_name' => $Customer_LastName
            ];

            $xml_content = UblInvoiceCreator::create($order, $customer, $admin_products);


            $xml = simplexml_load_string($xml_content);
            $documentUUID = (string)$xml->children('cbc', true)->UUID;
            $documentId = (string)$xml->children('cbc', true)->ID;
            $documentDate = (string)$xml->children('cbc', true)->IssueDate;
            $sourceUrn = "urn:mail:defaultgb@sahanekitap.com.tr";
            $destinationUrn = "mustafa9889.ma@gmail.com";

            //sendEArchiveInvoice::send($xml_content, $destinationUrn, $documentDate, $documentUUID, $documentId, $sourceUrn);


        }

        CreateEInvoice();
    }
}










