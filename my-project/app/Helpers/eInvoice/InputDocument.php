<?php
class InputDocument
{
    public $xmlContent;
    public $destinationUrn;
    public $documentDate;
    public $documentUUID;
    public $sourceUrn;
    public $localId;
    public $documentId;

    public function __construct($xmlContent, $destinationUrn, $documentDate, $documentUUID, $sourceUrn, $localId, $documentId)
    {
        $this->xmlContent = $xmlContent;
        $this->destinationUrn = $destinationUrn;
        $this->documentDate = $documentDate;
        $this->documentUUID = $documentUUID;
        $this->sourceUrn = $sourceUrn;
        $this->localId = $localId;
        $this->documentId = $documentId;
    }
}
