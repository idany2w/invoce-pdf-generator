<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\GenerateInvocePDFService;
use App\Http\Requests\GenerateInvocePDFRequest;

class GenerateInvocePDFController extends Controller {
    public function __invoke(GenerateInvocePDFRequest $request)
    {
        $data = $request->all();

        $logo = (data_get($data, 'supplier.logo'))->store('logo', 'public');

        $logo = storage_path("app/public/{$logo}");

        data_set($data, 'supplier.logo', $logo);

        return GenerateInvocePDFService::loadView( $data )->download()->getOriginalContent();
    }
}