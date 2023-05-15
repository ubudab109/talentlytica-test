<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Services\ParticipantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParticipantController extends BaseController
{
    protected $services;

    /**
     * Instance
     * 
     * @return void
     */
    public function __construct(ParticipantService $services)
    {
        $this->services = $services;
        $this->middleware('role:is_admin', ['only' => 'store|update|destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = $this->services->listParticipant();
        return $this->sendResponse($data, 'Successfully Fetched');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateParticipantRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateParticipantRequest $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $created = $this->services->createParticipant($input);
        if (!$created['success']) {
            return $this->sendError('Failed', $created['data']);
        }
        return $this->sendResponse('Success', 'Data created successfully');
    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $data = $this->services->detailParticipant($id, (bool)$request->get('with_relation'));
        if (!$data['success']) {
            return $this->sendBadRequest('Failed', 'Data Not Found', 404);
        }
        return $this->sendResponse($data, 'Data Fetched Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateParticipantRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateParticipantRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $data = $this->services->updateParticipant($id, $input);
        if(!$data['success']) {
            return $this->sendError('Failed', $data['data']);
        }
        return $this->sendResponse('Success', $data['data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $deleted = $this->services->deleteParticipant($id);
        if(!$deleted['success']) {
            return $this->sendError('Failed', $deleted['message']);
        }
        return $this->sendResponse('Success', 'Data Deleted Successfully');
    }
}
