<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\FileType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\FileTypeRepository;
use App\Http\Requests\FileType\{CreateFileTypeRequest, UpdateFileTypeRequest};


class FileTypeController extends Controller
{
    private FileTypeRepository $fileTypeRepository;

    public function __construct(FileTypeRepository $fileTypeRepository)
    {
        $this->fileTypeRepository = $fileTypeRepository;
    }

    public function index()
    {
        $viewInOptions = FileType::predefinedViewInOptions();
        return view('file_type.file_types', compact('viewInOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFileTypeRequest $request)
    {
        try {
            $this->fileTypeRepository->store($request->all());
            return response()->json(['status' => 'success', 'msg' => 'File type saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving file type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the file type.']);
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->fileTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->fileTypeRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileTypeRequest $request, FileType $file_type)
    {
        try {
           
            $this->fileTypeRepository->update($request->all(),$file_type->id);
            return response()->json(['status' => 'success', 'msg' => 'File type updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating file type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the file type.']);
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
            $fileType = $this->fileTypeRepository->findOrFail($id);
            if ($fileType) {
                $this->fileTypeRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'File type deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'File type not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting file type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the file type.']);
        }
    }

    public function getFileTypeDataTableList(Request $request)
    {
        return $this->fileTypeRepository->dataTable($request);
    }

}







