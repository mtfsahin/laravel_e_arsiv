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
            //fatura kesmek için örnek girilen adres isim vb. bilgiler
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

            //sepet vilgileri
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
            //sipariş bilgileri
            $order = [
                'order_id' => $orderID,
                'invoice_id' => $orderID,
                //ara toplam burada
                'sub_total' => $grand_total,
                'grand_total' => $grand_total,
                'product_line' =>  $product_line,
                'tax_total' => $tax_total,
                'tax_percent' => $tax_percent,
                //indirim, ürünlere eşit olarak dağıtılır, eksiye düşerse ürün son fiyatı 0.00 olur eksiye düşmez
                'discount' => 0.00,
                'tax_insclusive' => $TaxInclusiveAmount,
                'coupon_discount' => $coupon_discount,

            ];
            //müşteri bilgileri
            $customer = [
                'tckn' => $Customer_TCKN,
                'city_subdivision' => $Customer_CitySubdivisionName,
                'street_name' => $Customer_Adress,
                'city' => $Customer_CityName,
                'country' => $Customer_Country,
                'name' => $Customer_Name,
                'last_name' => $Customer_LastName
            ];

            //yukarıda siparişe göre değişen değerlere göre UBL 2.1 formatta xml üretir
            $xml_content = UblInvoiceCreator::create($order, $customer, $admin_products);

            //üretilen xml den servise gidicek bilgiler çekilir
            $xml = simplexml_load_string($xml_content);
            $documentUUID = (string)$xml->children('cbc', true)->UUID;
            $documentId = (string)$xml->children('cbc', true)->ID;
            $documentDate = (string)$xml->children('cbc', true)->IssueDate;
            $sourceUrn = "urn:mail:defaultgb@sahanekitap.com.tr";
            $destinationUrn = "mustafa9889.ma@gmail.com";

            //SOAP servise oluşturulan UBL 2.1 formattaki faturayı gönderir ve servisten dönen yanıtı ekrana yazar
            sendEArchiveInvoice::send($xml_content, $destinationUrn, $documentDate, $documentUUID, $documentId, $sourceUrn);
        }

        CreateEInvoice();
    }
}










