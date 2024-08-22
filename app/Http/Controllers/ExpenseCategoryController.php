<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Log;
use App\Repositories\ExpenseCategoryRepository;
use App\Services\ExpenseCategory\ExpenseCategoryService;
use App\Http\Requests\ExpenseCategory\{CreateExpenseCategoryRequest, UpdateExpenseCategoryRequest};

class ExpenseCategoryController extends Controller
{
    public $expenseCategoryService;
    public $expenseCategoryRepository;
    public function __construct(ExpenseCategoryRepository $expenseCategoryRepository, ExpenseCategoryService $expenseCategoryService)
    {
        $this->expenseCategoryService = $expenseCategoryService;
        $this->expenseCategoryRepository = $expenseCategoryRepository;
    }

    public function index()
    {
        return view('expense_category.expense_categories', [
            'data' => $this->expenseCategoryService->getAllData()
        ]);
    }

    public function store(CreateExpenseCategoryRequest $request)
    {
        try {
            $this->expenseCategoryRepository->store($request->only('expense_category_name', 'expense_account'));
            return response()->json(['status' => 'success', 'msg' => 'Expense category saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving expense category: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the expense category.']);
        }
    }

    public function show($id)
    {
        $model = $this->expenseCategoryRepository->findOrFail($id);
        return response()->json($model);
    } 

    public function edit($id)
    {
        $model = $this->expenseCategoryRepository->findOrFail($id);
        return response()->json($model);
    }

    public function update(UpdateExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        try {
            $this->expenseCategoryRepository->update($request->only('expense_category_name', 'expense_account'), $expenseCategory->id);
            return response()->json(['status' => 'success', 'msg' => 'Expense category updated successfully.']);
        } catch (Exception $e) {
            Log::error('Error updating expense category: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'An error occurred while updating the expense category.']);
        }
    }

    public function destroy($id)
    {
        try {
            $expenseCategory = $this->expenseCategoryRepository->findOrFail($id);
            if ($expenseCategory) {
                $this->expenseCategoryRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Expense category deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Expense category not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting expense category: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the expense category.']);
        }
    }
    
    public function getExpenseCategoryDataTableList(Request $request)
    {
        return $this->expenseCategoryRepository->dataTable($request);
    }
}
