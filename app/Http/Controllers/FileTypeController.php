<?php

namespace App\Http\Controllers;

use App\Exports\FileTypeTemplateExport;
use App\Http\Requests\FileType\CreateFileTypeRequest;
use App\Http\Requests\FileType\ImportFileTypeRequest;
use App\Http\Requests\FileType\UpdateFileTypeRequest;
use App\Imports\FileTypesImport;
use App\Models\FileType;
use App\Repositories\FileTypeRepository;
use Exception;
use Illuminate\Http\Request;use Illuminate\Support\Facades\Log;use Maatwebsite\Excel\Facades\Excel;

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
            return response()->json(['status' => 'success', 'msg' => 'File Type saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving fileTypes: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the filetypes.']);
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
            $this->fileTypeRepository->update($request->all(), $file_type->id);
            return response()->json(['status' => 'success', 'msg' => 'File Type updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating File Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the File Type.']);
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
            $this->fileTypeRepository->delete($id);
            return response()->json(['status' => 'success', 'msg' => 'File Type deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Error deleting File Type: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the File Type.']);
        }
    }

    public function getFileTypeDataTableList(Request $request)
    {
        return $this->fileTypeRepository->dataTable($request);
    }

    public function importFileTypes(ImportFileTypeRequest $request)
    {
        try {
            $file   = $request->file('file');
            $import = new FileTypesImport();
            Excel::import($import, $file);

            if (!empty($import->errors)) {
                return response()->json([
                    'status' => 'warning',
                    'msg'    => 'File processed with some issues',
                    'errors' => $import->errors,
                ], 200);
            }

            return response()->json(['status' => 'success', 'msg' => 'File uploaded and processed successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => 'An error occurred during the file upload. ' . $e->getMessage()], 500);
        }
    }
    public function fileTypeTemplateDownload()
    {
        return Excel::download(new FileTypeTemplateExport, 'File_type_template.xlsx');
    }
}
