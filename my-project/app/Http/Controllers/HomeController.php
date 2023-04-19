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

        $xml_content = UblInvoiceCreator::create();

        $xml = simplexml_load_string($xml_content);
        $documentUUID = (string)$xml->children('cbc', true)->UUID;
        $documentId = (string)$xml->children('cbc', true)->ID;
        $documentDate = (string)$xml->children('cbc', true)->IssueDate;
        $sourceUrn = "urn:mail:defaultgb@sahanekitap.com.tr";
        $destinationUrn = "mustafa9889.ma@gmail.com";

        sendEArchiveInvoice::send($xml_content, $destinationUrn, $documentDate, $documentUUID, $documentId, $sourceUrn);
    }
}
