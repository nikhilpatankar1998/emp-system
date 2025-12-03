@include('admin.layouts.head')
<style>
    .chat-layout {
        display: flex;
        height: 70vh;
        border: 1px solid #ddd;
        border-radius: 6px;
        overflow: hidden;
    }

    .chat-user-sidebar {
        width: 250px;
        background-color: #f9f9f9;
        border-right: 1px solid #ddd;
        overflow-y: auto;
        max-height: 70vh;
    }

    .chat-user {
        padding: 15px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .chat-user:hover {
        background-color: #e8e8e8;
    }

    .chat-box {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 20px;
        overflow: hidden;
        max-height: 70vh;
    }

    #chatMessages {
        flex: 1;
        overflow-y: auto;
        margin-top: 10px;
        padding-right: 10px;
    }

    .chat-message {
        margin-bottom: 10px;
        padding: 8px;
        background: #f1f1f1;
        border-radius: 5px;
        width: fit-content;
    }

    .chat-message.you {
        background: #d1e7dd;
        align-self: flex-end;
    text-align: left;
    margin-left: auto;
    margin-right: 0;
    }

    .input-group-text {
        background-color: #f0f0f0;
        border: none;
        font-size: 1.2rem;
    }

    .input-group .form-control:focus {
        box-shadow: none;
    }

    #file {
        display: none;
    }


 @media screen and (max-width: 420px){
    .chat-layout {
    display: flex;
      flex-direction: column;
    height: auto;
    border: 1px solid #ddd;
    border-radius: 6px;
    overflow: hidden;
}
    .chat-user-sidebar {
    width: 100%;
    background-color: #f9f9f9;
    border-right: 1px solid #ddd;
    overflow-y: auto;
    max-height: 70vh;
}
    #chatMessages {
    flex: 1;
    overflow-y: auto;
    margin-top: 10px;
    padding-right: 10px;
    margin-top: 200px;
}
    .chat-box {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 10px;
    overflow: hidden;
    max-height: 70vh;
}
  }


@media screen and (max-width: 768px){
  .chat-layout {
    display: flex;
    flex-direction: column;
    height: auto;
    border: 1px solid #ddd;
    border-radius: 6px;
    overflow: hidden;
}
  .chat-user-sidebar {
    width: 100%;
    background-color: #f9f9f9;
    border-right: 1px solid #ddd;
    overflow-y: auto;
    max-height: 70vh;
}
  #chatMessages {
    flex: 1;
    overflow-y: auto;
    margin-top: 10px;
    padding-right: 10px;
    margin-top: 200px;
}
  .chat-box {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 10px;
    overflow: hidden;
    max-height: 70vh;
}
  }

</style>


<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('admin.layouts.sidebar')

        <div class="body-wrapper">

            @include('admin.layouts.header')

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <h2>Chat </h2>
                                <div class="chat-layout">
                                    <!-- User List Sidebar -->
                                    <div class="chat-user-sidebar">
                                        <div class="chat-user" id="user-9999"
                                            onclick="loadChat(9999, 'IDICE INTERNAL CHAT')">
                                            🌐 IDICE INTERNAL CHAT
                                            <span class="badge bg-danger" id="unread-9999"
                                                style="float: right; display:none;">0</span>
                                        </div>
                                        @foreach ($users as $user)
                                            {{-- <div class="chat-user"
                                                onclick="loadChat({{ $user->id }}, '{{ $user->name }}')">
                                                {{ $user->name }}
                                            </div> --}}
                                            <div class="chat-user" id="user-{{ $user->id }}"
                                                onclick="loadChat({{ $user->id }}, '{{ $user->name }}')">
                                                {{ $user->name }}
                                                <span class="badge bg-danger" id="unread-{{ $user->id }}"
                                                    style="float: right; display:none;">0</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Chat Box -->
                                    <div class="chat-box" id="chatBox" style="margin-bottom: 0px;">
                                        <div id="chatHeader"><strong>Select a user to chat</strong></div>
                                        <div id="chatMessages"></div>
                                        {{-- <form id="messageForm" enctype="multipart/form-data"
                                            onsubmit="sendMessage(event)">
                                            <input type="text" id="messageInput" name="message"
                                                placeholder="Type your message..." class="form-control">
                                            <input type="file" id="file" name="file"
                                                class="form-control mt-2">
                                            <button type="submit" class="btn btn-primary mt-2">Send</button>
                                        </form> --}}
                                        <form id="messageForm" enctype="multipart/form-data"
                                            onsubmit="sendMessage(event)">
                                            {{-- <div class="input-group">
                                                <button type="button" id="emoji-button" class="input-group-text" style="cursor: pointer;">😊</button>
                                                <!-- Message input -->
                                                <input type="text" id="messageInput" name="message"
                                                    class="form-control" placeholder="Type your message..." />

                                                <!-- File input icon -->
                                                <label class="input-group-text" for="file" style="cursor: pointer;">
                                                    📎
                                                </label>
                                                <input type="file" id="file" name="file"
                                                    style="display: none;">

                                                <!-- Send button -->
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </div> --}}
                                            <div class="input-group">
                                                <button type="button" id="emoji-button"
                                                    class="input-group-text p-2">😊</button>
                                                <input type="text" id="messageInput" name="message"
                                                    class="form-control" placeholder="Type your message..." />
                                                <label class="input-group-text" for="file"
                                                    style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M4.406 1.342a5.53 5.53 0 0 1 7.5 2.18 4.498 4.498 0 0 1 3.356 5.385 3.5 3.5 0 0 1-2.882 5.875H4.5a4.5 4.5 0 0 1-.094-8.998 5.532 5.532 0 0 1 0-4.442ZM8 9.5a.5.5 0 0 0 .5-.5V6.707l.646.647a.5.5 0 0 0 .708-.708l-1.5-1.5a.5.5 0 0 0-.708 0l-1.5 1.5a.5.5 0 1 0 .708.708L7.5 6.707V9a.5.5 0 0 0 .5.5Z"/>
</svg></label>
                                                <input type="file" id="file" name="file"
                                                    style="display: none;">
                                                <button type="submit" class="btn btn-primary p-2 px-3"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
    class="bi bi-send" viewBox="0 0 16 16" style="transform: scaleX(-1);">
  <path d="M15.964.686a.5.5 0 0 0-.65-.65l-15 6a.5.5 0 0 0 0 .928l15 6a.5.5 0 0 0 .65-.65L13.04 8 15.964.686Zm-2.29 7.314L1.803 2.21l11.355 5.29L1.803 12.79l11.87-4.79Z"/>
</svg></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
</body>
@include('admin.layouts.footer')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const picker = document.getElementById('emoji-picker');
        const input = document.getElementById('messageInput');
        const emojiBtn = document.getElementById('emoji-button');

        // Toggle picker on button click
        emojiBtn.addEventListener('click', () => {
            picker.style.display = (picker.style.display === 'none') ? 'block' : 'none';
        });

        picker.addEventListener('emoji-click', (event) => {
            event.stopPropagation(); // Prevent bubbling
            const emoji = event.detail.unicode;
            const start = input.selectionStart;
            const end = input.selectionEnd;

            // Insert only once
            input.value = input.value.slice(0, start) + emoji + input.value.slice(end);
            input.focus();
            input.setSelectionRange(start + emoji.length, start + emoji.length);

            picker.style.display = 'none'; // Optionally hide picker after selection
        });

        // Optional: Click outside to close
        document.addEventListener('click', (e) => {
            if (!picker.contains(e.target) && !emojiBtn.contains(e.target)) {
                picker.style.display = 'none';
            }
        });
    });
</script>

<script>
    let currentChatUser = null;
    window.currentUserId = {{ auth()->id() }};

    function loadChat(userId, userName) {
        currentChatUser = userId;
        document.getElementById('chatHeader').innerHTML = `<strong>Chat with ${userName}</strong>`;

        fetch(`/chat/messages/${userId}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(messages => {
                const chatMessages = document.getElementById('chatMessages');
                chatMessages.innerHTML = '';
                // messages.forEach(msg => {
                //     let html = `<div class="chat-message ${msg.sender_id == window.currentUserId ? 'you' : ''}">
                // ${msg.message || ''}`;

                messages.forEach(msg => {
                    const senderName = msg.sender_id == window.currentUserId ? 'You' : msg
                        .sender_name;
                    const formattedTime = new Date(msg.created_at).toLocaleString();

                    let html = `<div class="chat-message ${msg.sender_id == window.currentUserId ? 'you' : ''}">
                            <small><strong>${senderName}</strong> • <span>${formattedTime}</span></small><br>
                            ${msg.message || ''}`;

                    if (msg.file_path) {
                        const fileUrl = `/storage/${msg.file_path}`;
                        if (msg.file_type === 'image') {
                            html += `<br><img src="${fileUrl}" width="150">`;
                        } else if (msg.file_type === 'video') {
                            html +=
                                `<br><video width="200" controls><source src="${fileUrl}" type="video/mp4"></video>`;
                        } else {
                            html +=
                                `<br><a href="${fileUrl}" target="_blank">Download File</a>`;
                        }
                    }

                    html += `</div>`;
                    chatMessages.innerHTML += html;
                });
            });
        //  Mark messages as read after loading
        fetch(`/chat/mark-as-read/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        });

        //  Also refresh the unread badge display
        const unreadBadge = document.getElementById(`unread-${userId}`);
        if (unreadBadge) {
            unreadBadge.style.display = 'none';
            unreadBadge.innerText = '';
        }
    }

    function sendMessage(event) {
        event.preventDefault();

        if (!currentChatUser) {
            alert('Please select a user to chat with first.');
            return;
        }

        const form = document.getElementById('messageForm');
        const formData = new FormData(form);
        formData.append('receiver_id', currentChatUser);

        fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(msg => {
                let html = `<div class="chat-message you">${msg.message || ''}`;

                if (msg.file_path) {
                    const fileUrl = `/storage/${msg.file_path}`;
                    if (msg.file_type === 'image') {
                        html += `<br><img src="${fileUrl}" width="150">`;
                    } else if (msg.file_type === 'video') {
                        html +=
                            `<br><video width="200" controls><source src="${fileUrl}" type="video/mp4"></video>`;
                    } else {
                        html += `<br><a href="${fileUrl}" target="_blank">Download File</a>`;
                    }
                }

                html += `</div>`;
                document.getElementById('chatMessages').innerHTML += html;
                form.reset();
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Message failed to send.');
            });
    }
</script>
<script>
    function updateUnreadCounts() {
        fetch('/chat/unread-counts', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                // Reset all badges
                document.querySelectorAll('[id^="unread-"]').forEach(span => {
                    span.style.display = 'none';
                    span.innerText = '';
                });

                data.forEach(entry => {
                    const span = document.getElementById(`unread-${entry.sender_id}`);
                    if (span) {
                        span.innerText = entry.unread_count;
                        span.style.display = 'inline-block';
                    }
                });
            });
    }

    // Call it every 10 seconds
    setInterval(updateUnreadCounts, 10000);
    updateUnreadCounts(); // Initial call 
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Request permission on page load
        if (Notification.permission !== 'granted') {
            Notification.requestPermission().then(permission => {
                if (permission !== 'granted') {
                    console.warn("Notifications are not allowed by the user.");
                }
            });
        }

        // Poll the latest message every 5 seconds
        setInterval(() => {
            fetch('/chat/latest-message', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error("Network response was not ok");
                return res.json();
            })
            .then(data => {
                if (data && data.sender_name && data.message) {
                    if (Notification.permission === 'granted') {
                        // const redirectUrl = `/chat/${data.sender_id}`;
                        new Notification(`New message from ${data.sender_name}`, {
                            body: data.message,
                            // icon: '../assets/images/logos/newbird.png' // Optional icon path
                        });
                    }
                }
            })
            .catch(error => {
                console.error("Error fetching latest message:", error);
            });
        }, 5000); // every 5 seconds
    });
</script>
