<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;

class Question extends Model
{
    use VotableTrait;
    protected $fillable = ['title', 'body'];
    protected $appends = ['created_date', 'is_favored', 'favorites_count','body_html'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute()
    {
       return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0 ) {
            if ($this->best_answer_id){
                return 'answered-accepted';
            }
            return 'answered';
        }
        return 'unanswered';
    }

    public function getBodyHtmlAttribute()
    {
        return clean($this->bodyHtml());
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }

    protected function bodyHtml()
    {
        $markdown = new CommonMarkConverter(['allow_unsafe_links' => false]);
        return $markdown->convertToHtml($this->body);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->with('user')->orderBy('votes_count', 'DESC');
    }

    public function acceptBestAnswer($answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavored()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoredAttribute()
    {
        return $this->isFavored();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }


}
