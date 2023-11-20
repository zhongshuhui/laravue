<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReceivableResource;
use App\Laravue\Models\Receivable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ReceivableResource::collection(Receivable::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ReceivableResource|JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'happen_month' => ['required'],
                'account_name' => ['required'],
                'end_rmb_balance' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $receivable = Receivable::create([
                'happen_month' => date('Y-m',strtotime($params['happen_month'])),
                'account_name' => $params['account_name'],
                'end_rmb_balance' => $params['end_rmb_balance'],
            ]);

            return new ReceivableResource($receivable);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Receivable $receivable
     * @return Response
     */
    public function show(Receivable $receivable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Receivable $receivable
     * @return Response
     */
    public function edit(Receivable $receivable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Receivable $receivable
     * @return JsonResponse|ReceivableResource
     */
    public function update(Request $request, Receivable $receivable)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'happen_month' => ['required'],
                'account_name' => ['required'],
                'end_rmb_balance' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $receivable->account_name = $params['account_name'];
            $receivable->end_rmb_balance = $params['end_rmb_balance'];
            $receivable->save();
        }

        return new ReceivableResource($receivable);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Receivable $receivable
     * @return Response
     */
    public function destroy(Receivable $receivable)
    {
        try {
            $receivable->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
