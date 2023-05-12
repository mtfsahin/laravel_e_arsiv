<?php

namespace App\Helpers;

use App\Helpers\eInvoice\InputDocument;

use SoapClient;

class sendEArchiveInvoice
{
    public static function send($xml_content, $destinationUrn, $documentDate, $documentUUID, $documentId, $sourceUrn)
    {


        // Kullanıcı adı ve şifre
        $username = "admin_002874";
        $password = ")xrd9!iX";

        // SOAP bağlantısı kurulur
        $client = new SoapClient(
            "https://servis.kolayentegrasyon.net/EArchiveInvoiceService/EArchiveInvoiceWS?wsdl",
            [
                "soap_version" => SOAP_1_2,
                "stream_context" => stream_context_create([
                    "http" => [
                        "header" => "Username: $username\r\nPassword: $password\r\n",
                    ],
                ]),
            ]
        );

        $inputDocument = new InputDocument($xml_content, $destinationUrn, $documentDate, $documentUUID, $sourceUrn, $documentId);

        $response = $client->sendInvoice([$inputDocument]);

        echo "<pre>";
        print_r( $response );
        echo "</pre>";


        // Yanıt işlenir
        foreach ($response as $res) {

            echo "İşlem kodu: " . $res->code . "<br>";
            echo "Açıklama: " . $res->explanation . "<br>";

            if (isset($res->cause)) {
                echo "Hata sebebi: " . $res->cause . "<br>";
            }

            echo "<br>";
        }

    }
}
