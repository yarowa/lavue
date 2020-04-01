<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnswersController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param Question $question
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Question $question, Request $request)
    {
        $question->answers()->create($request->validate([
                'body' => 'required'
            ]) + ['user_id' => Auth::id()]);

        return back()->with('success', "Your answer has been submitted successfully");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @param Answer $answer
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        return view('answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Question $question
     * @param Answer $answer
     * @return \Illuminate\Http\JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Question $question,  Answer $answer)
    {
        $this->authorize('update', $answer);
        $answer->update($request->validate([
            'body' => 'required',
        ]));
        if ($request->expectsJson()){
            return response()->json([
                'message' => 'Your answer has been updated',
                'body_html' => $answer->body_html
            ]);
        }
        //return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param Answer $answer
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();
        return back()->with('success', 'Your answer has been removed successfully!.');
    }
}
