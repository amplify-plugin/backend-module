<style>
    .chat-composer { display: flex; align-items: flex-end; gap: 8px; }
    .chat-composer__clip,
    .chat-composer__send {
        flex: 0 0 44px; width: 44px; height: 44px; margin: 0; border-radius: 4px !important;
        display: inline-flex; align-items: center; justify-content: center; padding: 0;
    }
    .chat-composer__field { flex: 1 1 auto; min-width: 0; }
    .chat-composer__field textarea { min-height: 44px; resize: vertical; }
    .chat-composer__send .chat-spinner { border-color: rgba(255,255,255,.35); border-top-color: #fff; }
    .chat-file-input {
        position: absolute !important; width: 1px !important; height: 1px !important;
        padding: 0 !important; margin: -1px !important; overflow: hidden !important;
        clip: rect(0,0,0,0) !important; white-space: nowrap !important; border: 0 !important;
    }
    .chat-picks { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 8px; }
    .chat-picks:empty { display: none; }
    .chat-pick {
        display: flex; align-items: center; gap: 8px; max-width: 260px;
        padding: 4px 6px 4px 4px; border: 1px solid #e4e6eb; border-radius: 10px; background: #f8f9fb;
    }
    .chat-pick img, .chat-pick__icon {
        width: 36px; height: 36px; flex: 0 0 36px; border-radius: 6px; object-fit: cover;
    }
    .chat-pick__icon {
        display: inline-flex; align-items: center; justify-content: center;
        background: #e6e9ef; color: #3d4d6a;
    }
    .chat-pick__icon i { font-size: 16px; line-height: 1; }
    .chat-pick__meta { min-width: 0; }
    .chat-pick__name {
        display: block; max-width: 150px; overflow: hidden; text-overflow: ellipsis;
        white-space: nowrap; font-size: 13px; font-weight: 600; color: #1b2a4e;
    }
    .chat-pick__size { display: block; font-size: 11px; color: #6c757d; }
    .chat-pick__remove {
        border: 0; background: transparent; color: #6c757d; font-size: 18px;
        line-height: 1; padding: 0 2px; cursor: pointer;
    }
    .chat-spinner {
        width: 16px; height: 16px; border: 2px solid rgba(32,168,216,.25);
        border-top-color: #20a8d8; border-radius: 50%; display: inline-block;
        animation: chat-spin .7s linear infinite;
    }
    .chat-spinner[hidden], [data-send-icon][hidden] { display: none !important; }
    .chat .chat-history .message {
        max-width: min(420px, 85%);
        box-sizing: border-box;
        overflow: hidden;
    }
    .chat .chat-history .message p,
    .chat .chat-history .message .message-data-time { display: block; clear: both; }
    .chat-attach-image-link { display: block; max-width: 100%; margin-top: 8px; line-height: 0; }
    .chat-attach-image {
        display: block; width: auto; max-width: 100%; max-height: 160px;
        object-fit: cover; border-radius: 8px;
    }
    .chat-attach-file {
        display: flex; align-items: center; justify-content: flex-start; gap: 8px;
        width: fit-content; max-width: 100%; box-sizing: border-box;
        margin: 8px auto 0 0; padding: 6px 10px 6px 6px; border-radius: 8px;
        background: #f4f5f7; border: 1px solid #e4e6eb; text-decoration: none;
        text-align: left; line-height: 1.2; color: #1b2a4e;
    }
    .chat-attach-file__icon {
        flex: 0 0 32px; width: 32px; height: 32px; border-radius: 6px;
        background: #dfe3ea; color: #3d4d6a; display: inline-flex;
        align-items: center; justify-content: center;
    }
    .chat-attach-file__icon i { font-size: 16px; line-height: 1; }
    .chat-attach-file__name {
        flex: 0 1 auto; min-width: 0; overflow: hidden; text-overflow: ellipsis;
        white-space: nowrap; font-size: 13px; text-align: left;
    }
    .recipient-search { position: relative; }
    .recipient-results {
        position: absolute; z-index: 40; left: 0; right: 0; bottom: calc(100% + 4px); top: auto;
        max-height: 360px; overflow-y: auto; background: #fff; color: #1b2a4e;
        border: 1px solid #c5cdd6; border-radius: 4px; box-shadow: 0 -8px 18px rgba(0,0,0,.12);
    }
    .recipient-results__group {
        padding: 8px 12px 2px; font-weight: 700; color: #1b2a4e; background: #fff;
    }
    .recipient-results button {
        display: block; width: 100%; text-align: left; background: #fff; color: #1b2a4e;
        border: 0; padding: 4px 12px 4px 28px; cursor: pointer; font-weight: 400;
    }
    .recipient-results button:hover { background: #1e6fd9; color: #fff; }
    .recipient-results__empty { padding: 8px 12px; color: #73818f; }
    @keyframes chat-spin { to { transform: rotate(360deg); } }
</style>
<div class="chat-panel" @if ($thread && ! $as_customer) id="message-chat" data-poll-url="{{ route('admin.message.messages', $thread->id) }}" data-send-url="{{ route('admin.message.messages.store', $thread->id) }}" @endif>
<div class="chat-header clearfix">
    <div class="row">
        <div class="col-lg-12">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                <img src="{{ $theadImage()}}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover"
                     alt="avatar">
            </a>
            <div class="chat-about">
                <h6 class="mb-0 mt-1">{{ $threadTitle() }}</h6>
                @php
                    $headerSender = $thread?->sender;
                    $headerSubtitle = null;
                    if ($headerSender instanceof \Amplify\System\Backend\Models\Contact) {
                        $headerSubtitle = $headerSender->customer->customer_name ?? null;
                    } elseif ($headerSender instanceof \Amplify\System\Backend\Models\User) {
                        $headerSubtitle = 'Internal User';
                    }
                @endphp
                @if (filled($headerSubtitle))
                    <small class="text-muted d-block text-truncate" style="max-width: 280px; margin-top: 3px; font-size: 12px; line-height: 1.3;">{{ $headerSubtitle }}</small>
                @endif
            </div>
            <div class="chat-toggle-icon d-md-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="#1b2a4e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-x">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>

            </div>
        </div>
    </div>
</div>

<div class="chat-history py-0 pr-0 {{ ($thread && ! $as_customer) ? 'chat-stage is-loading' : '' }}">
    @if ($thread && ! $as_customer)
        <div class="chat-boot" role="status" aria-label="Loading messages">
            <span class="chat-boot__spinner"></span>
        </div>
    @endif
    <ul class="mb-0 pl-0 {{ ($thread && ! $as_customer) ? 'chat-booting' : '' }}" data-message-list data-message-scroll @if($messages->isEmpty()) style="height: 480px" @endif>
        @foreach ($messages as $message)
            <li class="clearfix my-2" data-message-id="{{ $message->id }}">
                <div
                    class="message @if ($message->sender_id === $reader_user->id && (empty($message->model) || $message->model === get_class($reader_user))) other-message float-right @else my-message @endif">
                    @if (filled($message->body))
                        <p class="text-left">{!! nl2br($message->body) !!}</p>
                    @endif
                    @if ($message->attachment)
                        @if (in_array($message->attachment_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true))
                            <a href="{{ $message->attachment }}" class="chat-attach-image-link" data-lightbox="{{ $message->attachment }}"
                               data-title="{{ $message->body }}"
                               title="{{ $message->attachment_title ?? $message->attachment_name }}">
                                <img class="chat-attach-image" src="{{ $message->attachment }}" alt="{{ $message->attachment_title ?? 'Image' }}">
                            </a>
                        @else
                            <a href="{{ $message->attachment }}" download class="chat-attach-file" title="Download attachment">
                                <span class="chat-attach-file__icon"><i class="la la-file"></i></span>
                                <span class="chat-attach-file__name">{{ $message->attachment_title ?? $message->attachment_name }}</span>
                            </a>
                        @endif
                    @endif
                    <small class="message-data-time text-muted font-italic"
                           data-message-time="{{ $message->created_at?->toIso8601String() }}">{{ $message->created_at?->diffForHumans() }}
                    </small>
                </div>
            </li>
        @endforeach
    </ul>
</div>

@if($hasMessagingPermission())
    <div class="chat-message clearfix">
        <form
            data-compose
            data-compose-max="1"
            data-compose-max-kb="1000"
            data-compose-icon="la la-file"
            @if ($thread && ! $as_customer) data-message-form @endif
            action="{{ $threadLink() }}"
            method="post" enctype="multipart/form-data">
            <input type="hidden" name="as_customer" value="{{ $as_customer }}"/>
            @csrf
            @if ($thread)
                @method("PUT")
            @endif

            @if (!isset($thread->id))
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>User type<span class="text-danger">*</span></label>
                        <select name="user_type" class="form-control custom-select"
                                onchange="changeMessageAbleUser(this.value);" id="user_type" oninput="checkTextArea();">
                            <option value="">Select one</option>
                            <option value="user" title="Admin panel users">User</option>
                            <option value="contact" title="Customer contact accounts">Contact</option>
                        </select>
                    </div>
                    <div class="form-group col-md-8">
                        <label for="messageRecipientSearch">Message to<span class="text-danger">*</span></label>
                        <div class="recipient-search">
                            <input type="text" id="messageRecipientSearch" class="form-control" placeholder="Select user type first" autocomplete="off" disabled>
                            <input type="hidden" name="msg_to" id="messageableUser" value="">
                            <div id="messageRecipientResults" class="recipient-results" hidden></div>
                        </div>
                    </div>
                </div>
            @endif

            <div data-compose-picks class="chat-picks"></div>
            <div class="chat-composer">
                <button type="button" class="btn btn-light chat-composer__clip" data-compose-attach aria-label="Attach a file">
                    <i class="la la-paperclip"></i>
                </button>
                <div class="chat-composer__field">
                    <textarea name="msg" id="message" oninput="checkTextArea();" class="form-control"
                              rows="1" placeholder="Enter text here..."></textarea>
                </div>
                <button type="submit" class="btn btn-info chat-composer__send" id="send-msg" disabled aria-label="Send">
                    <i class="la la-paper-plane" data-send-icon></i>
                    <span class="chat-spinner" data-send-spinner hidden></span>
                </button>
                <input type="file" class="chat-file-input" data-compose-file name="attachment" id="message-attachment" tabindex="-1" aria-hidden="true" accept="{{ \Amplify\System\Message\Http\Requests\MessageRequest::acceptAttribute() }}">
            </div>
            <div data-message-errors class="text-danger small mt-1"></div>
        </form>
    </div>
@endif
</div>
<script>

    function checkTextArea() {
        var messageTextarea = document.getElementById('message');
        var fileInput = document.getElementById('message-attachment');
        var sendButton = document.getElementById('send-msg');
        var messageableUser = document.getElementById('messageableUser');
        var userType = document.getElementById('user_type');
        var form = sendButton ? sendButton.closest('form') : null;

        if (!messageTextarea || !sendButton) {
            return;
        }

        if (form && form.dataset.sending === '1') {
            sendButton.disabled = true;
            return;
        }

        var hasBody = messageTextarea.value.trim() !== '' || (fileInput && fileInput.files && fileInput.files.length > 0);
        var hasRecipient = !messageableUser || !userType || (messageableUser.value.trim() !== '' && userType.value.trim() !== '');

        sendButton.disabled = !(hasBody && hasRecipient);
    }

    document.querySelector('.chat-toggle-icon').addEventListener('click', (e) => {
        document.querySelector('.chat-toggle-icon').classList.toggle('show')
        document.querySelector('.people-list').classList.toggle('show')
    });

    var recipientSearchUrls = {
        user: @json(route('admin.message.recipients', ['type' => 'user'])),
        contact: @json(route('admin.message.recipients', ['type' => 'contact']))
    };
    var recipientChoices = [];

    function showRecipientMessage(text) {
        var results = document.getElementById('messageRecipientResults');
        if (!results) {
            return;
        }
        results.hidden = false;
        results.innerHTML = '';
        var note = document.createElement('div');
        note.className = 'recipient-results__empty';
        note.textContent = text;
        results.appendChild(note);
    }

    function renderRecipientResults(items) {
        var results = document.getElementById('messageRecipientResults');
        var hidden = document.getElementById('messageableUser');
        var search = document.getElementById('messageRecipientSearch');
        if (!results || !hidden || !search) {
            return;
        }

        results.innerHTML = '';
        if (!items.length) {
            showRecipientMessage('No matches');
            return;
        }

        var fragment = document.createDocumentFragment();
        var lastGroup = null;
        items.forEach(function (item) {
            if (item.group && item.group !== lastGroup) {
                var header = document.createElement('div');
                header.className = 'recipient-results__group';
                header.textContent = item.group;
                fragment.appendChild(header);
                lastGroup = item.group;
            }
            var button = document.createElement('button');
            button.type = 'button';
            button.textContent = item.text;
            button.addEventListener('click', function () {
                hidden.value = String(item.id);
                search.value = item.text;
                results.hidden = true;
                checkTextArea();
            });
            fragment.appendChild(button);
        });
        results.appendChild(fragment);
        results.hidden = false;
    }

    function filteredRecipients() {
        var search = document.getElementById('messageRecipientSearch');
        var term = search ? search.value.trim().toLowerCase() : '';
        if (!term) {
            return recipientChoices;
        }

        return recipientChoices.filter(function (item) {
            var name = String(item.text || '').toLowerCase();
            var group = String(item.group || '').toLowerCase();
            return name.indexOf(term) !== -1 || group.indexOf(term) !== -1;
        });
    }

    function changeMessageAbleUser() {
        var hidden = document.getElementById('messageableUser');
        var search = document.getElementById('messageRecipientSearch');
        var results = document.getElementById('messageRecipientResults');
        var type = document.getElementById('user_type');

        if (!hidden || !search || !results || !type) {
            return;
        }

        hidden.value = '';
        search.value = '';
        recipientChoices = [];
        results.hidden = true;
        results.innerHTML = '';

        if (!recipientSearchUrls[type.value]) {
            search.disabled = true;
            search.placeholder = 'Select user type first';
            checkTextArea();
            return;
        }

        search.disabled = false;
        search.placeholder = 'Search by name';
        showRecipientMessage('Loading…');
        checkTextArea();

        fetch(recipientSearchUrls[type.value], {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        }).then(function (response) {
            if (!response.ok) {
                throw new Error('load failed');
            }
            return response.json();
        }).then(function (data) {
            if (document.getElementById('user_type').value !== type.value) {
                return;
            }
            recipientChoices = (data && data.results) || [];
            renderRecipientResults(filteredRecipients());
            search.focus();
        }).catch(function () {
            showRecipientMessage('Could not load the list. Try again.');
        });
    }

    (function () {
        var search = document.getElementById('messageRecipientSearch');
        var hidden = document.getElementById('messageableUser');
        var results = document.getElementById('messageRecipientResults');

        if (!search || !hidden || !results) {
            return;
        }

        search.addEventListener('input', function () {
            hidden.value = '';
            checkTextArea();
            if (!recipientChoices.length) {
                return;
            }
            renderRecipientResults(filteredRecipients());
        });

        search.addEventListener('focus', function () {
            if (recipientChoices.length) {
                renderRecipientResults(filteredRecipients());
            }
        });

        document.addEventListener('click', function (event) {
            if (!search.parentElement.contains(event.target)) {
                results.hidden = true;
            }
        });
    })();
</script>
