@if ($comments->isNotEmpty())
    @foreach ($comments as $item)
        <div class="comment">
            <img src="{{ URL::asset('public/images/' . $item->user->avatar) }}" alt=""
                class="avatar-xs rounded-circle acitivity-avatar" />
            <div>
                <p class="m-0 text-primary">{{ $item->body }}</p>
                <p class="text-muted m-0">{{ $item->user->name }}</p>
                <small>{{ date('d M, Y', strtotime($item->created_at)) }} |
                    {{ date('h:i A', strtotime($item->created_at)) }}</small>
            </div>
        </div>
    @endforeach
@else
    <div class="m-4">
        <h3 class="text-center">
            No comments yet!
        </h3>
    </div>
@endif
