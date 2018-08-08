<?php

namespace App\Http\Controllers;

use DB;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return view('questions.home');
    }

    public function update(Request $request, Question $question)
    {
        $q = Question::find($question->id);
        $q->q_read = 1;
        $q->save();
        return response()->json([], 204);
    }

    public function reset()
    {
        $questionTable = (new Question())->getTable();
        DB::table($questionTable)->where('q_read', '=', 1)->update(['q_read' => 0]);
        return redirect()->route('questions.index');
    }

    public function start(Request $request)
    {
        $question = Question::randomComexQuestion();
        return view('questions.show')->with('question', $question);
    }

    public function startLogistic(Request $request)
    {
        $question = Question::randomLogisticQuestion();
        return view('questions.show')->with('question', $question);
    }

    public function new()
    {
        return Question::randomQuestion();
    }
}
