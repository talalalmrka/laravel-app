<div>
    <div class="container py-5">
        {!! $post->content !!}
    </div>
    @auth
        <a class="fixed bottom-5 start-5 btn btn-primary pill" target="_blank"
            href="{{ route('dashboard.posts.edit', $post) }}">
            @icon('bi-pencil-square')
        </a>
    @endauth
</div>
