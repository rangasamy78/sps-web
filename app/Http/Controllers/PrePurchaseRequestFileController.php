<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Log;
use App\Repositories\PrePurchaseRequestFileRepository;
use App\Http\Requests\PrePurchaseRequestFile\{ CreatePrePurchaseRequestFileRequest, UpdatePrePurchaseRequestFileRequest };

class PrePurchaseRequestFileController extends Controller
{
    use ImageUploadTrait;
    public $prePurchaseRequestFileRepository;

    public function __construct(PrePurchaseRequestFileRepository $prePurchaseRequestFileRepository)
    {
        $this->prePurchaseRequestFileRepository = $prePurchaseRequestFileRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrePurchaseRequestFileRequest $request)
    {
        try {
            $this->prePurchaseRequestFileRepository->store($request->only('images','user_id','pre_purchase_request_id','notes'));
            return response()->json(['status' => 'success', 'msg' => 'File saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving File: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the File.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->prePurchaseRequestFileRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrePurchaseRequestFileRequest $request, $id)
    {
        try {
            $this->prePurchaseRequestFileRepository->update($request->only('user_id','pre_purchase_request_id','notes'), $id);
            return response()->json(['status' => 'success', 'msg' => 'File updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating File : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the File .']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $file = $this->prePurchaseRequestFileRepository->findOrFail($id);
            if ($file) {
                if (isset($file->images)) {
                    $this->deleteImage($file->images);
                }
                $this->prePurchaseRequestFileRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'File deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'File not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting File : ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the File .']);
        }
    }

    public function getPrePurchaseRequestFileDataTableList(Request $request) {
        return $this->prePurchaseRequestFileRepository->dataTable($request);
    }

}
