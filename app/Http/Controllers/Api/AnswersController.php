<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use App\Question;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Question $question
     * @return AnonymousResourceCollection
     *
     */
    public function index(Question $question)
    {
        $answers = $question->answers()->with('user')->where(function ($q) {
            if (request()->has('excludes')) {
                $q->whereNotIn('id', request()->query('excludes'));
            }
        })->simplePaginate(3);
        return AnswerResource::collection($answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Question $question
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Question $question,Request $request)
    {
        if (env('APP_ENV') == 'local') sleep(2);
        $answer = $question->answers()->create($request->validate([
            'body' => 'required'
        ]) + ['user_id' => Auth::id()]);
        return response()->json([
            'message' => 'Your answer has been submitted successfully',
            'answer' => new AnswerResource($answer->load('user'))
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Answer $answer
     * @return Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Question $question
     * @param Answer $answer
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Question $question,  Answer $answer)
    {
        $this->authorize('update', $answer);
        $answer->update($request->validate([
            'body' => 'required',
        ]));
        return response()->json([
            'message' => 'Your answer has been updated',
            'body_html' => $answer->body_html
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param Answer $answer
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();
        return response()->json([
            'message' => 'Your answer has been removed successfully!.'
        ]);
    }
}
