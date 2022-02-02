<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientDocuments\CreateClientDocumentRequest;
use App\Http\Requests\ClientDocuments\UpdateClientDocumentRequest;
use App\Http\Resources\Clients\ClientDocumentResource;
use App\Models\ClientDocument;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Http\Request;

class ClientDocumentController extends Controller
{
    public function __construct(private ClientServiceContract $service)
    {
    }

    public function upload(CreateClientDocumentRequest $request)
    {
        return new ClientDocumentResource(
            $this->service->addDocument(array_merge($request->validated(), ['document' => $request->file('document')]))
        );
    }

    public function update(UpdateClientDocumentRequest $request, ClientDocument $clientDocument)
    {
        return new ClientDocumentResource(
            $this->service->updateDocument($clientDocument, array_merge($request->validated(), ['document' => $request->file('document')]))
        );
    }

    public function delete(Request $request, ClientDocument $clientDocument)
    {
        $this->service->deleteDocument($clientDocument);
    }
}
