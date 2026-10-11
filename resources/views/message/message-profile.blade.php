<h4 class="mt-3">Recent chats</h4>
<ul class="list-unstyled chat-list mt-2 mb-0">
    @foreach($threads as $thread)
        <li class="clearfix @if($thread->is_active) active @endif @if($thread->unreaded > 0) font-weight-bold @endif" data-thread-id="{{ $thread->id }}" style="padding: 10px">
            <a href="{{ $thread->link }}"
               class="text-decoration-none">
                <div class="media">
                    <div class="align-self-center mr-1 img-fluid rounded-circle" style="width: 50px; height: 50px">
                        <img style="object-fit: cover;" class="img-thumbnail w-100 h-100"
                             src="{{ $thread->image }}"
                             alt="{{ $thread->title ?? '' }}"/>
                    </div>
                    <div class="media-body">
                        <p class="my-0" title="{{ $thread->title}}"
                           style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; font-size: 14px;">
                            {{ $thread->title }}
                            <span class="badge badge-danger @if($thread->unreaded == 0) d-none @endif">
                                    {{ $thread->unreaded }}
                                </span>
                        </p>
                        <div class="company  @if ($thread->company) d-none @endif"> {{ $thread->company }}</div>
                        <p class="my-0 text-muted" data-message-preview
                           style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; font-size: 12px;">{{ $thread->preview }}</p>
                        <div class="status">
                            <i class="la la-clock icon-clock offline"></i>
                            <span data-message-time="{{ $thread->last_message_at ?? '' }}">{{ $thread->last_saw_at }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </li>
    @endforeach
</ul>
