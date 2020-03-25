<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{ $answerCount. ' '. str_plural('Answer', $answerCount) }}</h2>
                    <hr>
                    @include('layouts._messages')
                    @foreach($answers as $answer)
                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a title="This answer is useful" class="vote-ap">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">1230</span>
                                <a title="This answer is not useful" class="vote-down off">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <a title="Mark this answer as best answer" class="vote-accepted mt-2 ">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                            </div>
                            <div class="media-body">
                                {!! $answer->body_html !!}
                                <div class="row">
                                    <div class="col-4">
                                        <div class="ml-auto">
                                            @can('update-question', $answer)
                                                <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan
                                            @can('update-question', $answer)
                                                <form class="form-delete" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="col-4">

                                    </div>
                                    <div class="col-4">
                                        <div class="float-right">
                                            <span class="text-muted">Answered {{ $answer->created_date }}</span>
                                            <div class="media mt-2">
                                                <a href="{{$answer->user->url}}" class="pr-2">
                                                    <img src="{{$answer->user->avatar}}" alt="">
                                                </a>
                                                <div class="media-body mt-1">
                                                    <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>