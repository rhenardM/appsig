<?php 

namespace App\Service;

use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class YousignService
{
    private const PATHFILE = __DIR__ . '/../../public/';

    public function __construct(
        private HttpClientInterface $yousignClient,
    ){}

        // 1 - Initial a signature request
    public function signatureRequest(): array
        {
            $response = $this->yousignClient->request(
                'POST',
                'signature_requests',
                [
                    'body' => <<<JSON
                    {
                        "name" : "Contrat de location",
                        "delivery_mode" : "email",
                        "timezone" : "Europe/Paris"
                        }
                    JSON,
                    'headers' => [
                    'Content-Type' => 'application/json',
                    ],

                ]
            );

            $statusCode = $response->getStatusCode();

            if ($statusCode !== 201){
                    throw new \Exception('Error while creating signature requerts');
            }
            return $response->toArray(); 
        }

    // 2 - Uplode a document 
    
    public function uploadDocument(string $signatureRequestId, string $filename): array
    {
        $formFields = [
            'nature' => 'signable-document',
            'file' => DataPart::fromPath(self::PATHFILE . $filename, $filename, 'application/pdf')
        ];

        $fomData = new FormDataPart($formFields);
        $headers = $fomData->getPreparedHeaders()->toArray();

        $response = $this->yousignClient->request(
            'POST',
            sprintf('signature_requests/%s/documents', $signatureRequestId),
            [
                'headers' => $headers,
                'body' => $fomData->bodyToIterable(),
            ]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode !== 201) {
            # code...
            throw new \Exception('Error while uplod document');
        }
        return $response->toArray(); 
    }

        // 3 Add a signature
        
    public function addSigner(
        string $signatureRequestId,
        string $documentId,
        string $email,
        string $prenom,
        string $nom
    ):array 
    {
        $response = $this->yousignClient->request(
            'POST',
            sprintf('signature_requests/%signers', $signatureRequestId),
            [
                'body' => <<<JSON
                {
                    "info":{
                        "first-name" : "$prenom",
                        "last_name" : "$nom",
                        "email" : "$email",
                        "local" : "fr",
                    },
                    "signature_level": "electronic_signature",
                    "signature_authentication_mode": "no_otp",

                    "fields":[
                        {
                            "document_id":"$documentId",
                            "type":"signature",
                            "page":1,
                            "x":77,
                            "y":581
                        }
                    ],
                }
                JSON,
                'headers' =>[
                    'content-type' => 'application/json',
                ], 
            ]);
            $statusCode = $response -> getStatusCode();

            if ($statusCode !== 201) {
                throw new \Exception('Error while adding signer');
            }
            return $response->toArray(); 
    }

    // 4 - Send the signature request 
    public function activateSignatureRequest(string $signatureRequestId): array
    {
        $response = $this->yousignClient->request(
            'POST',
            sprintf('signature_requests/%s/activate', $signatureRequestId)
        );
        $statusCode = $response->getStatusCode();
        
        if ($statusCode !== 201) {
            # code...
            throw new \Exception('Error while activating signature request');
        }
        return $response->toArray(); 
    }

}
