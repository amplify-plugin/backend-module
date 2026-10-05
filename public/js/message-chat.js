(function () {
    var BASE_MS = 3000;
    var STEP_MS = 2000;
    var MAX_MS = 30000;

    function humanTime(iso) {
        var then = Date.parse(iso);
        if (!then) {
            return '';
        }

        var seconds = Math.max(1, Math.round((Date.now() - then) / 1000));
        var steps = [
            [60, 'second'],
            [60, 'minute'],
            [24, 'hour'],
            [7, 'day'],
            [4, 'week'],
            [12, 'month']
        ];
        var count = seconds;
        var name = 'year';

        for (var i = 0; i < steps.length; i++) {
            if (count < steps[i][0]) {
                name = steps[i][1];
                break;
            }
            count = Math.round(count / steps[i][0]);
        }

        if (name === 'year') {
            count = Math.max(1, Math.round(seconds / 31536000));
        }

        return count + ' ' + name + (count === 1 ? '' : 's') + ' ago';
    }

    function refreshTimes() {
        document.querySelectorAll('#plist [data-message-time], #message-chat [data-message-time]').forEach(function (node) {
            var text = humanTime(node.getAttribute('data-message-time'));
            if (text) {
                node.textContent = text;
            }
        });
    }

    function touchActiveChat(sentAt) {
        var node = document.querySelector('#plist li.active [data-message-time]');
        if (!node || !sentAt) {
            return;
        }

        node.setAttribute('data-message-time', sentAt);
        node.textContent = humanTime(sentAt);
    }

    function escapeHtml(value) {
        return String(value == null ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function bodyHtml(value) {
        return escapeHtml(value).replace(/\n/g, '<br>');
    }

    function errorText(payload) {
        if (payload && payload.errors) {
            return Object.keys(payload.errors).reduce(function (lines, key) {
                return lines.concat(payload.errors[key]);
            }, []).join(' ');
        }

        return (payload && payload.message) || 'Could not send the message.';
    }

    function scrollToLatest(scrollEl, force) {
        if (!scrollEl) {
            return;
        }

        var distance = scrollEl.scrollHeight - scrollEl.scrollTop - scrollEl.clientHeight;
        if (force || distance < 120) {
            scrollEl.scrollTop = scrollEl.scrollHeight;
        }
    }

    function attachmentHtml(attachment) {
        if (!attachment) {
            return '';
        }

        if (attachment.is_image) {
            return '<a href="' + escapeHtml(attachment.url) + '" class="chat-attach-image-link" data-lightbox="' + escapeHtml(attachment.url) + '">' +
                '<img class="chat-attach-image" src="' + escapeHtml(attachment.url) + '" alt="' + escapeHtml(attachment.name || 'Image') + '"></a>';
        }

        return '<a href="' + escapeHtml(attachment.url) + '" download class="chat-attach-file">' +
            '<span class="chat-attach-file__icon"><i class="la la-file"></i></span>' +
            '<span class="chat-attach-file__name">' + escapeHtml(attachment.name || 'Attachment') + '</span></a>';
    }

    function sendRequest(url, data, token, onProgress) {
        return new Promise(function (resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', url);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('X-CSRF-TOKEN', token || '');
            xhr.upload.onprogress = function (event) {
                if (!onProgress || !event.lengthComputable || !event.total) {
                    return;
                }
                onProgress(Math.min(100, Math.round((event.loaded / event.total) * 100)));
            };
            xhr.onload = function () {
                var payload = {};
                try {
                    payload = JSON.parse(xhr.responseText || '{}');
                } catch (e) {
                    payload = {};
                }
                resolve({
                    ok: xhr.status >= 200 && xhr.status < 300,
                    status: xhr.status,
                    payload: payload
                });
            };
            xhr.onerror = function () {
                reject(new Error('network'));
            };
            xhr.send(data);
        });
    }

    function bindCompose(form) {
        if (!form || form.dataset.composeReady === '1') {
            return;
        }

        var input = form.querySelector('[data-compose-file]');
        var attach = form.querySelector('[data-compose-attach]');
        var picks = form.querySelector('[data-compose-picks]');
        var progress = form.querySelector('[data-compose-progress]');
        var bar = progress ? progress.querySelector('span') : null;
        var send = form.querySelector('[type="submit"]');
        var sendIcon = form.querySelector('[data-send-icon]');
        var spinner = form.querySelector('[data-send-spinner]');

        if (!input || !attach || !picks) {
            return;
        }

        form.dataset.composeReady = '1';

        var maxFiles = parseInt(form.getAttribute('data-compose-max') || '1', 10);
        var maxKb = parseInt(form.getAttribute('data-compose-max-kb') || '10240', 10);
        var iconClass = form.getAttribute('data-compose-icon') || 'la la-file';
        var picked = [];
        var urls = [];

        function errorBox() {
            return form.querySelector('[data-message-errors], [data-ticket-errors]');
        }

        function showComposeError(text) {
            var node = errorBox();
            if (node) {
                node.textContent = text || '';
            }
        }

        function limitText() {
            if (maxKb % 1024 === 0) {
                return (maxKb / 1024) + ' MB';
            }
            return maxKb + ' KB';
        }

        function formatSize(bytes) {
            if (bytes < 1024) {
                return bytes + ' B';
            }
            if (bytes < 1048576) {
                return Math.max(1, Math.round(bytes / 1024)) + ' KB';
            }
            return (bytes / 1048576).toFixed(1) + ' MB';
        }

        function revoke() {
            urls.forEach(function (url) {
                URL.revokeObjectURL(url);
            });
            urls = [];
        }

        function sync() {
            var transfer = new DataTransfer();
            picked.forEach(function (file) {
                transfer.items.add(file);
            });
            input.files = transfer.files;
        }

        function render() {
            revoke();
            picks.innerHTML = '';
            picked.forEach(function (file, index) {
                var chip = document.createElement('div');
                chip.className = 'chat-pick';
                var visual = document.createElement('span');
                if (file.type && file.type.indexOf('image/') === 0) {
                    var url = URL.createObjectURL(file);
                    urls.push(url);
                    visual = document.createElement('img');
                    visual.src = url;
                    visual.alt = '';
                } else {
                    visual.className = 'chat-pick__icon';
                    visual.innerHTML = '<i class="' + iconClass + '"></i>';
                }
                var meta = document.createElement('span');
                meta.className = 'chat-pick__meta';
                var name = document.createElement('span');
                name.className = 'chat-pick__name';
                name.textContent = file.name;
                var size = document.createElement('span');
                size.className = 'chat-pick__size';
                size.textContent = formatSize(file.size);
                meta.appendChild(name);
                meta.appendChild(size);
                var remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'chat-pick__remove';
                remove.setAttribute('aria-label', 'Remove ' + file.name);
                remove.textContent = '\u00d7';
                remove.addEventListener('click', function () {
                    if (form.dataset.sending === '1') {
                        return;
                    }
                    picked.splice(index, 1);
                    sync();
                    render();
                    if (typeof window.checkTextArea === 'function') {
                        window.checkTextArea();
                    }
                });
                chip.appendChild(visual);
                chip.appendChild(meta);
                chip.appendChild(remove);
                picks.appendChild(chip);
            });
        }

        attach.addEventListener('click', function () {
            if (form.dataset.sending === '1') {
                return;
            }
            input.click();
        });

        input.addEventListener('change', function () {
            if (form.dataset.sending === '1') {
                sync();
                return;
            }

            var incoming = Array.prototype.slice.call(input.files || []);
            input.value = '';
            if (maxFiles === 1) {
                picked = [];
            }

            var rejected = '';
            incoming.forEach(function (file) {
                var duplicate = picked.some(function (current) {
                    return current.name === file.name && current.size === file.size && current.lastModified === file.lastModified;
                });
                if (duplicate) {
                    return;
                }
                if (picked.length >= maxFiles) {
                    rejected = 'You can attach up to ' + maxFiles + ' files.';
                    return;
                }
                if (file.size > maxKb * 1024) {
                    rejected = file.name + ' is larger than ' + limitText() + '.';
                    return;
                }
                picked.push(file);
            });

            sync();
            render();
            showComposeError(rejected);
            if (typeof window.checkTextArea === 'function') {
                window.checkTextArea();
            }
        });

        form._compose = {
            hasFiles: function () {
                return picked.length > 0;
            },
            setBusy: function (busy) {
                form.dataset.sending = busy ? '1' : '0';
                attach.disabled = !!busy;
                if (sendIcon) {
                    sendIcon.hidden = !!busy;
                }
                if (spinner) {
                    spinner.hidden = !busy;
                }
                picks.querySelectorAll('.chat-pick__remove').forEach(function (button) {
                    button.disabled = !!busy;
                });
                if (!busy && progress) {
                    progress.hidden = true;
                    if (bar) {
                        bar.style.width = '0';
                    }
                }
                if (send) {
                    send.disabled = !!busy;
                }
                if (!busy && typeof window.checkTextArea === 'function') {
                    window.checkTextArea();
                }
            },
            setProgress: function (pct) {
                if (progress) {
                    progress.hidden = false;
                }
                if (bar) {
                    bar.style.width = pct + '%';
                }
                picks.querySelectorAll('.chat-pick__size').forEach(function (node) {
                    node.textContent = 'Uploading ' + pct + '%';
                });
            },
            reset: function () {
                picked = [];
                input.value = '';
                sync();
                render();
                if (progress) {
                    progress.hidden = true;
                    if (bar) {
                        bar.style.width = '0';
                    }
                }
            }
        };

        if (!form.hasAttribute('data-message-form') && !form.hasAttribute('data-ticket-form')) {
            form.addEventListener('submit', function (event) {
                if (form.dataset.sending === '1') {
                    event.preventDefault();
                    return;
                }
                form.dataset.sending = '1';
                attach.disabled = true;
                if (sendIcon) {
                    sendIcon.hidden = true;
                }
                if (spinner) {
                    spinner.hidden = false;
                }
            });
        }
    }

    function renderMessage(message) {
        var node = document.createElement('li');
        node.className = 'clearfix my-2';
        node.setAttribute('data-message-id', String(message.id));
        var body = message.body ? '<p class="text-left">' + bodyHtml(message.body) + '</p>' : '';
        node.innerHTML = '<div class="message ' + (message.mine ? 'other-message float-right' : 'my-message') + '">' +
            body +
            attachmentHtml(message.attachment) +
            '<small class="message-data-time text-muted font-italic" data-message-time="' + escapeHtml(message.sent_at) + '">' + escapeHtml(message.time) + '</small>' +
            '</div>';

        return node;
    }

    function start(root) {
        var list = root.querySelector('[data-message-list]');
        var form = root.querySelector('[data-message-form]');
        var errors = root.querySelector('[data-message-errors]');
        var scrollEl = root.querySelector('[data-message-scroll]');
        var seen = {};
        var delay = BASE_MS;
        var generation = 0;
        var timer = null;
        var stopped = false;
        var inFlight = false;

        if (list) {
            list.querySelectorAll('[data-message-id]').forEach(function (node) {
                seen[node.getAttribute('data-message-id')] = true;
            });
        }

        refreshTimes();
        scrollToLatest(scrollEl, true);

        function lastId() {
            var maxId = 0;
            Object.keys(seen).forEach(function (id) {
                var numeric = parseInt(id, 10);
                if (numeric > maxId) {
                    maxId = numeric;
                }
            });
            return maxId;
        }

        function showError(text) {
            if (!errors) {
                return;
            }
            errors.textContent = text || '';
        }

        function append(messages, forceScroll) {
            if (!list) {
                return 0;
            }

            var added = 0;
            var latestSentAt = '';
            messages.forEach(function (message) {
                var id = String(message.id);
                if (!message.id || seen[id]) {
                    return;
                }
                seen[id] = true;
                list.appendChild(renderMessage(message));
                latestSentAt = message.sent_at || latestSentAt;
                added += 1;
                if (message.mine) {
                    forceScroll = true;
                }
            });
            touchActiveChat(latestSentAt);

            if (added > 0) {
                list.style.height = '';
                refreshTimes();
                scrollToLatest(scrollEl, forceScroll);
            }

            return added;
        }

        function schedule() {
            clearTimeout(timer);
            if (stopped || document.hidden) {
                return;
            }
            timer = setTimeout(poll, delay);
        }

        function poll() {
            if (stopped || inFlight || document.hidden || !root.dataset.pollUrl) {
                return;
            }

            var seenGeneration = generation;
            inFlight = true;

            fetch(root.dataset.pollUrl + '?after=' + lastId(), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            }).then(function (response) {
                if (response.status === 401 || response.status === 403 || response.status === 419) {
                    stopped = true;
                    return null;
                }
                if (!response.ok) {
                    throw new Error('poll failed');
                }
                return response.json();
            }).then(function (payload) {
                if (!payload) {
                    return;
                }
                var added = append(payload.messages || [], false);
                if (added > 0) {
                    delay = BASE_MS;
                } else if (seenGeneration === generation) {
                    delay = Math.min(delay + STEP_MS, MAX_MS);
                }
            }).catch(function () {
                if (seenGeneration === generation) {
                    delay = Math.min(delay + STEP_MS, MAX_MS);
                }
            }).then(function () {
                inFlight = false;
                schedule();
            });
        }

        function resetForm() {
            if (!form) {
                return;
            }
            var message = form.querySelector('[name="msg"]');
            if (message) {
                message.value = '';
            }
            if (form._compose) {
                form._compose.reset();
            }
            if (typeof window.checkTextArea === 'function') {
                window.checkTextArea();
            }
        }

        if (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                if (form.dataset.sending === '1') {
                    return;
                }
                showError('');

                var tokenField = form.querySelector('input[name="_token"]');
                var data = new FormData(form);
                data.delete('_method');
                var compose = form._compose;
                var hasFile = compose && compose.hasFiles();
                if (compose) {
                    compose.setBusy(true);
                }

                sendRequest(root.dataset.sendUrl, data, tokenField ? tokenField.value : '', function (pct) {
                    if (hasFile && compose) {
                        compose.setProgress(pct);
                    }
                }).then(function (result) {
                    if (!result.ok) {
                        if (result.status === 419) {
                            showError('Please refresh the page and try again.');
                        } else {
                            showError(errorText(result.payload));
                        }
                        return;
                    }
                    append(result.payload.message ? [result.payload.message] : [], true);
                    resetForm();
                    generation += 1;
                    delay = BASE_MS;
                    schedule();
                }).catch(function () {
                    showError('Could not send the message.');
                }).then(function () {
                    if (compose) {
                        compose.setBusy(false);
                    }
                });
            });
        }

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                clearTimeout(timer);
                return;
            }
            delay = BASE_MS;
            refreshTimes();
            poll();
        });

        schedule();
    }

    function applyRecent(list, threads) {
        var ul = list.querySelector('.chat-list');
        if (!ul || !threads) {
            return;
        }

        var previous = null;
        threads.forEach(function (thread) {
            var item = ul.querySelector('li[data-thread-id="' + thread.id + '"]');
            if (!item) {
                return;
            }

            var time = item.querySelector('[data-message-time]');
            if (time && thread.sent_at) {
                time.setAttribute('data-message-time', thread.sent_at);
            }

            var badge = item.querySelector('.badge');
            var unread = parseInt(thread.unread, 10) || 0;
            if (item.classList.contains('active')) {
                unread = 0;
            }
            if (badge) {
                badge.textContent = String(unread);
                badge.classList.toggle('d-none', unread === 0);
            }
            item.classList.toggle('font-weight-bold', unread > 0);

            var preview = item.querySelector('[data-message-preview]');
            if (preview && typeof thread.preview === 'string') {
                preview.textContent = thread.preview;
            }

            if (previous) {
                previous.after(item);
            } else {
                ul.prepend(item);
            }
            previous = item;
        });

        refreshTimes();
    }

    function watchSidebar(list) {
        var delay = BASE_MS;
        var timer = null;
        var stopped = false;
        var inFlight = false;

        function schedule() {
            clearTimeout(timer);
            if (stopped || document.hidden) {
                return;
            }
            timer = setTimeout(pollRecent, delay);
        }

        function pollRecent() {
            if (stopped || inFlight || document.hidden || !list.dataset.recentUrl) {
                return;
            }

            inFlight = true;
            fetch(list.dataset.recentUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            }).then(function (response) {
                if (response.status === 401 || response.status === 403 || response.status === 419) {
                    stopped = true;
                    return null;
                }
                if (!response.ok) {
                    throw new Error('recent failed');
                }
                return response.json();
            }).then(function (payload) {
                if (!payload) {
                    return;
                }
                var stamp = function () {
                    return Array.prototype.map.call(list.querySelectorAll('[data-message-time]'), function (node) {
                        return node.getAttribute('data-message-time');
                    }).join('|');
                };
                var previous = stamp();
                applyRecent(list, payload.threads || []);
                delay = previous !== stamp() ? BASE_MS : Math.min(delay + STEP_MS, MAX_MS);
            }).catch(function () {
                delay = Math.min(delay + STEP_MS, MAX_MS);
            }).then(function () {
                inFlight = false;
                schedule();
            });
        }

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                delay = BASE_MS;
                refreshTimes();
                pollRecent();
            }
        });

        schedule();
    }

    function boot() {
        var list = document.getElementById('plist');
        var root = document.getElementById('message-chat');

        if ((list || root) && !document.body.dataset.messageTimesReady) {
            document.body.dataset.messageTimesReady = '1';
            refreshTimes();
            setInterval(function () {
                if (!document.hidden) {
                    refreshTimes();
                }
            }, 5000);
        }

        document.querySelectorAll('[data-compose]').forEach(bindCompose);

        if (list && list.dataset.recentReady !== '1') {
            list.dataset.recentReady = '1';
            watchSidebar(list);
        }

        if (root && root.dataset.messageChatReady !== '1') {
            root.dataset.messageChatReady = '1';
            start(root);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
