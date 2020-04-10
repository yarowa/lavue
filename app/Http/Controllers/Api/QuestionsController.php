<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AskQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Question;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        if (env('APP_ENV') == 'local') sleep(2);
        $questions = Question::with(['user', 'answers.user'])->latest()->paginate(5);
        return QuestionResource::collection($questions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AskQuestionRequest $request
     * @return JsonResponse
     */
    public function store(AskQuestionRequest $request)
    {
        if (env('APP_ENV') == 'local') sleep(2);
        $question = $request->user()->questions()->create($request->only('title', 'body'));

        return response()->json([
            'message' => "Your question has been submitted",
            'question' => new QuestionResource($question)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return JsonResponse
     */
    public function show(Question $question)
    {
        return response()->json([
            'title'     => $question->title,
            'body'      => $question->body,
            'body_html' => $question->body_html
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AskQuestionRequest $request
     * @param Question $question
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $this->authorize("update", $question);

        $question->update($request->only('title', 'body'));

        return response()->json([
            'message' => "Your question has been updated.",
            'body_html' => $question->body_html
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Question $question)
    {
        $this->authorize("delete", $question);
        $question->delete();
        return response()->json([
            'message' => "Your question has been deleted."
        ]);
    }
}
