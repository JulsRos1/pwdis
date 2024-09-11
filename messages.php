<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            display: flex;
            height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background: #ffffff;
            border-right: 1px solid #ddd;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar h4 {
            margin-top: 0;
        }

        .search-input {
            margin-bottom: 15px;
        }

        .user-list,
        .chat-options {
            list-style-type: none;
            padding: 0;
        }

        .user-list li,
        .chat-options li {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .user-list li:hover,
        .chat-options li:hover {
            background: #f0f0f0;
        }

        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .message-list {
            flex: 1;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            background: #fafafa;
        }

        .message {
            padding: 10px;
            margin: 5px 0;
            background: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: flex-start;
            position: relative;
            border: 1px solid #ddd;
        }

        .message .avatar {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            object-fit: cover;
        }

        .message .content {
            flex: 1;
        }

        .message .username {
            font-weight: bold;
            display: block;
        }

        .message .message-text {
            margin: 5px 0;
        }

        .message .time {
            font-size: 0.85rem;
            color: #888;
            display: block;
            margin-top: 5px;
        }

        .chat-input {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        #messageInput {
            flex: 1;
            margin-right: 10px;
        }

        #sendButton {
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4>Chat</h4>
        <input type="text" id="searchInput" class="form-control search-input" placeholder="Search users...">
        <ul class="chat-options">
            <li id="allChat">All Chat</li>
            <li id="userListHeader">Users</li>
        </ul>
        <ul id="userList" class="user-list">
            <!-- User list will be populated here -->
        </ul>
    </div>
    <div class="chat-container">
        <h4 id="chatHeader">Select a chat option</h4>
        <div class="message-list" id="messageList">
            <!-- Messages will be displayed here -->
        </div>
        <div class="chat-input">
            <input type="text" id="messageInput" class="form-control" placeholder="Type your message...">
            <button id="sendButton" class="btn btn-primary">Send</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let selectedUserId = null;
        let chatMode = 'group'; // 'group' or 'private'

        function fetchUsers(searchQuery = '') {
            $.get('fetch_users.php', {
                search: searchQuery
            }, function(data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    var users = response.users;
                    $('#userList').html('');
                    users.forEach(function(user) {
                        $('#userList').append(
                            '<li data-user-id="' + user.id + '">' +
                            '<img src="' + user.avatar_url + '" class="avatar">' +
                            user.username +
                            '</li>'
                        );
                    });
                } else {
                    alert('Error fetching users');
                }
            });
        }

        function fetchMessages() {
            let url = chatMode === 'group' ? 'fetch_messages.php' : 'fetch_private_messages.php';
            let params = chatMode === 'private' ? {
                userId: selectedUserId
            } : {};

            $.get(url, params, function(data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    var messages = response.messages;
                    $('#messageList').html('');
                    messages.forEach(function(message) {
                        $('#messageList').append(
                            '<div class="message">' +
                            '<img src="' + message.avatar_url + '" class="avatar">' +
                            '<div class="content">' +
                            '<span class="username">' + message.username + '</span>' +
                            '<span class="message-text">' + message.message + '</span>' +
                            '<span class="time">' + new Date(message.timestamp).toLocaleTimeString() + '</span>' +
                            '</div>' +
                            '</div>'
                        );
                    });
                    $('#messageList').scrollTop($('#messageList')[0].scrollHeight);
                } else {
                    alert('Error fetching messages');
                }
            });
        }

        function sendMessage() {
            let url = chatMode === 'group' ? 'post_message.php' : 'post_private_message.php';
            let params = chatMode === 'private' ? {
                message: $('#messageInput').val(),
                receiver_id: selectedUserId
            } : {
                message: $('#messageInput').val()
            };

            if (params.message.trim() !== '') {
                $.post(url, params, function(data) {
                    var response = JSON.parse(data);
                    if (response.status === 'success') {
                        $('#messageInput').val('');
                        fetchMessages();
                    } else {
                        alert(response.message);
                    }
                });
            }
        }

        $('#sendButton').click(function() {
            sendMessage();
        });

        $('#userList').on('click', 'li', function() {
            selectedUserId = $(this).data('user-id');
            var username = $(this).text().trim();
            $('#chatHeader').text('Chatting with ' + username);
            chatMode = 'private';
            fetchMessages();
        });

        $('#allChat').click(function() {
            selectedUserId = null;
            $('#chatHeader').text('All Chat');
            chatMode = 'group';
            fetchMessages();
        });

        $('#userListHeader').click(function() {
            chatMode = 'private';
            fetchUsers();
        });

        $('#searchInput').on('input', function() {
            let searchQuery = $(this).val();
            fetchUsers(searchQuery);
        });

        // Fetch users and messages on page load
        fetchUsers();
        fetchMessages();
        setInterval(fetchMessages, 2000);
    </script>
</body>

</html>