<Answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        {{--@include('shared._votes', [
           'model' => $answer
        ])--}}
        <div class="d-flex flex-column vote-controls">
            <a title="This answer is useful"
               class="vote-ap {{ Auth::guest() ? 'off' : '' }}"
               onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{$answer->id}}').submit();"
            >
                <i class="fas fa-caret-up fa-3x"></i>
            </a>
            <form id="up-vote-answer-{{$answer->id}}" action="/answers/{{$answer->id}}/vote" method="POST"  style="display: none">
                @csrf
                <input type="hidden" name="vote" value="1">
            </form>
            <span class="votes-count">{{ $answer->votes_count }}</span>
            <a title="This question is not useful"
               class="vote-down {{ Auth::guest() ? 'off' : '' }}"
               onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{$answer->id}}').submit();"
            >
                <i class="fas fa-caret-down fa-3x"></i>
            </a>
            <form id="down-vote-answer-{{$answer->id}}" action="/answers/{{$answer->id}}/vote" method="POST"  style="display: none">
                @csrf
                <input type="hidden" name="vote" value="-1">
            </form>
            <!-- Favorite _-->

        </div>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea v-model="body" rows="10" class="form-control"  required></textarea>
                </div>
                <button class="btn btn-outline-primary" :disabled="isInvalid" type="submit">Update</button>
                <button class="btn btn-outline-secondary" type="submit" @click.prevent="cancel">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can('update-question', $answer)
                                <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan
                            @can('update-question', $answer)
                                <form class="form-delete" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button @click.prevent="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <user-info :model="{{ $answer }}" label="Answered"></user-info>
                    {{--@include('shared._author', [
                        'model' => $answer,
                        'label' => 'answered'
                    ])--}}


                </div>
            </div>

        </div>
    </div>
</Answer>

