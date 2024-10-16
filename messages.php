<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Chat</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: "Poppins", sans-serif;
        }

        .sidebar {
            width: 300px;
            background: #ffffff;
            border-right: 1px solid #ddd;
            padding: 20px;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar h4 {
            margin-top: 0;
        }

        .sidebar .btn-home {
            margin-bottom: 20px;
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
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .user-list li:hover,
        .chat-options li:hover {
            background: #f1f1f1;
        }

        .avatar {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            object-fit: cover;
        }

        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
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
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .message .avatar {
            margin-right: 10px;
        }

        .message .content {
            flex: 1;
            background: #ffffff;
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
        }

        .message .username {
            font-weight: bold;
            display: block;
        }

        .message .message-text {
            margin: 5px 0;
        }

        .message .time {
            font-size: 0.75rem;
            color: #888;
            display: block;
            margin-top: 5px;
        }

        .chat-input {
            display: flex;
            align-items: center;
            margin-top: 10px;
            padding: 10px;
            background: #ffffff;
            border-top: 1px solid #ddd;
            border-radius: 8px;
        }

        #messageInput {
            flex: 1;
            margin-right: 10px;
        }

        #sendButton {
            flex-shrink: 0;
        }

        /* Hamburger menu */
        .hamburger {
            display: none;
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 30px;
            cursor: pointer;
            z-index: 1000;
        }

        /* Hiding sidebar only on mobile screens */
        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }

            .sidebar {
                position: absolute;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 999;
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .chat-container {
                width: 100%;
                height: 100vh;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Hamburger Menu for Mobile -->
    <div class="hamburger" id="hamburgerMenu">☰</div>

    <div class="sidebar hidden" id="sidebar">
        <a href="index.php" class="btn btn-primary btn-home">Exit</a>
        <h4>Chatbox</h4>
        <input type="text" id="searchInput" class="form-control search-input" placeholder="Search users...">
        <ul class="chat-options">
            <li id="allChat">All Chat</li>
        </ul>
        <ul id="userList" class="user-list">
            <!-- User list will be populated here -->
        </ul>
    </div>

    <div class="chat-container">
        <h4 id="chatHeader">All Chat - Users Forum</h4>
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
        let isUserScrolling = false; // To track if the user is scrolling
        let shouldScrollToBottom = true; // To track if we should auto-scroll
        const notificationSound = new Audio('sent.mp3');

        // Toggle sidebar visibility
        $('#hamburgerMenu').click(function() {
            $('#sidebar').toggleClass('hidden open');
        });

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
                            user.fullname +
                            '</li>'
                        );
                    });
                } else {
                    alert('Error fetching users');
                }
            });
        }

        $('#messageList').on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            const scrollHeight = $(this)[0].scrollHeight;
            const clientHeight = $(this).innerHeight();

            if (scrollTop + clientHeight >= scrollHeight - 5) {
                shouldScrollToBottom = true;
            } else {
                shouldScrollToBottom = false;
            }
        });

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
                            '<span class="username">' + message.fullname + '</span>' +
                            '<span class="message-text">' + message.message + '</span>' +
                            '<span class="time">' + new Date(message.timestamp).toLocaleTimeString() + '</span>' +
                            '</div>' +
                            '</div>'
                        );
                    });
                    if (shouldScrollToBottom) {
                        $('#messageList').scrollTop($('#messageList')[0].scrollHeight);
                    }
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
                        notificationSound.play();
                    } else {
                        alert(response.message);
                    }
                });
            }
        }

        $('#sendButton').click(function() {
            sendMessage();
        });

        $('#messageInput').keypress(function(e) {
            if (e.which === 13 && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        $('#userList').on('click', 'li', function() {
            selectedUserId = $(this).data('user-id');
            var fullname = $(this).text().trim();
            $('#chatHeader').text('Chatting with ' + fullname);
            chatMode = 'private';
            fetchMessages();
        });

        $('#allChat').click(function() {
            selectedUserId = null;
            $('#chatHeader').text('All Chat - Users Forum');
            chatMode = 'group';
            fetchMessages();
        });

        $('#searchInput').on('input', function() {
            let searchQuery = $(this).val();
            fetchUsers(searchQuery);
        });

        fetchUsers();
        fetchMessages();
        setInterval(fetchMessages, 2000);
    </script>
</body>

</html>