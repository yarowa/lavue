<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        //\DB::enableQueryLog();
        $questions = Question::with(['user', 'answers.user'])->latest()->paginate(5);
         return view('questions.index', compact('questions'));

         //dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $question = new Question();
        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AskQuestionRequest $request
     * @return RedirectResponse
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title', 'body'));
        return  redirect()->route('questions.index')->with('success', 'Your question has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return Factory|View
     */
    public function show(Question $question)
    {
        $question->load('user')->increment('views');
        return view('questions.show', compact('question'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Question $question)
    {
        /*if (Gate::denies('update-question', $question)) {
        abort(403, 'Access denied');
        }*/
        $this->authorize('update', $question);
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AskQuestionRequest $request
     * @param Question $question
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        /*if (Gate::denies('update-question', $question)) {
            abort(403, 'Access denied');
        }*/
        $this->authorize('update', $question);
        $question->update($request->only('title', 'body'));
        return redirect()->route('questions.index')->with('success', 'Your question has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Question $question)
    {
        /*if (Gate::denies('delete-question', $question)) {
            abort(403, 'Access denied');
        }*/
        $this->authorize('delete', $question);
        $question->delete();

        return redirect('/questions')->with('success', "Your question has been deleted.");
    }
}
