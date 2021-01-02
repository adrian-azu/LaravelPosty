@component('mail::message')
# Your Post was liked
{{ $liker->name }} Liked one of your post.

@component('mail::button', ['url' => route('posts.show', $post)])
    View Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
