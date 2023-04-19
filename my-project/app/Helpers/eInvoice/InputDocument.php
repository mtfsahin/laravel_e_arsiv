<?php

namespace App\Helpers\eInvoice;

class InputDocument
{
    public $xmlContent;
    public $destinationUrn;
    public $documentDate;
    public $documentUUID;
    public $sourceUrn;
    public $documentId;

    public function __construct($xml_content, $destinationUrn, $documentDate, $documentUUID, $sourceUrn, $documentId)
    {
        $this->xmlContent = $xml_content;
        $this->destinationUrn = $destinationUrn;
        $this->documentDate = $documentDate;
        $this->documentUUID = $documentUUID;
        $this->sourceUrn = $sourceUrn;
        $this->documentId = $documentId;
    }
}
