<?php

namespace App\Repositories;

use DataTables;
use App\CPU\Images;
use App\Models\ProductQuestion;
use App\Models\ProductQuestionAnswer;
use App\Repositories\Interface\CustomerQuestionRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CustomerQuestionRepository implements CustomerQuestionRepositoryInterface
{
    public function getAllQuestions()
    {
        return ProductQuestion::all();
    }

    public function dataTable()
    {
        $models = $this->getAllQuestions();
            return Datatables::of($models)
                ->addIndexColumn()
                ->editColumn('question', function ($model) {
                    return $model->message;
                })
                ->editColumn('date', function ($model) {
                    return get_system_date($model->created_at) . ' '. get_system_time($model->created_at);
                })
                ->editColumn('product', function ($model) {
                    return '<div class="row"><div class="col-auto">' . Images::show($model->product->thumb_image) . '</div><div class="col">' . $model->product->name . '</div></div>';
                })
                ->editColumn('answer', function ($model) {
                    return $model->answer ? $model->answer->message : '';
                })
                ->editColumn('answer_by', function ($model) {
                    return $model->answer ? $model->answer->admin->name : '';
                })
                ->addColumn('action', function ($model) {
                    return view('backend.question.action', compact('model'));
                })
                ->rawColumns(['action', 'date', 'question', 'product', 'answer', 'answer_by'])
                ->make(true);
    }
    
    public function dataTableWithAjaxSearch($productId)
    {
        $models = $this->getAllQuestionsForProduct($productId);
            return Datatables::of($models)
                ->addIndexColumn()
                ->editColumn('question', function ($model) {
                    return $model->message;
                })
                ->editColumn('date', function ($model) {
                    return get_system_date($model->created_at) . ' '. get_system_time($model->created_at);
                })
                ->editColumn('answer', function ($model) {
                    return $model->answer ? $model->answer->message : '';
                })
                ->editColumn('answer_by', function ($model) {
                    return $model->answer ? $model->answer->admin->name : '';
                })
                ->addColumn('action', function ($model) {
                    return view('backend.question.action', compact('model'));
                })
                ->rawColumns(['action', 'date', 'question', 'answer', 'answer_by'])
                ->make(true);
    }

    public function getAllQuestionsForProduct($productId)
    {
        return ProductQuestion::where('product_id', $productId)->orderBy('id', 'DESC')->get();
    }

    public function findQuestionById($id)
    {
        return ProductQuestion::with('answer')->find($id);
    }

    public function findAnswerById($id)
    {
        return ProductQuestionAnswer::find($id);
    }

    public function updateOrCreateAnswer($request)
    {
        $id = $request->id;
        $message = $request->answer;

        $question = ProductQuestion::find($id);
        if(!$question) {
            return response()->json(['status' => false, 'message' => 'Question Not Found']);
        }

        $answer = ProductQuestionAnswer::where('question_id', $question->id)->first();
        if($answer) {

            $answer->admin_id = Auth::guard('admin')->id();
            $answer->message = $message;
            $answer->save();

        } else {
            ProductQuestionAnswer::create([
                'question_id' => $question->id,
                'admin_id' => Auth::guard('admin')->id(),
                'message' => $message
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Answer added successfully.', 'load' => true]);
    }
}