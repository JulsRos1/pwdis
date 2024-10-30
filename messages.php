<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Chat</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: #e9eff1;
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: "Poppins", sans-serif;
            color: #333;
        }

        .sidebar {
            width: 320px;
            background: #ffffff;
            border-right: 1px solid #ddd;
            padding: 20px;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar .btn-home {
            margin-bottom: 20px;
            background-color: #007bff;
            color: white !important;
            transition: background-color 0.3s;
        }

        .sidebar .btn-home:hover {
            background-color: #0056b3;
            color: white !important;
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
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .user-list li:hover,
        .chat-options li:hover {
            background: #f0f2f5;
            transform: translateX(5px);
        }

        .avatar {
            border-radius: 50%;
            width: 45px;
            height: 45px;
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
            background: #f9f9f9;
        }

        .message {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .message .avatar {
            margin-right: 10px;
        }

        .message .content {
            flex: 1;
            background: #ffffff;
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ddd;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
        }

        .message .username {
            font-weight: bold;
            display: block;
            color: black;
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

        #allChat {
            background-color: #161C27;
            color: white;
        }

        .hamburger {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            font-size: 24px;
            cursor: pointer;
            z-index: 1000;
            width: 40px;
            height: 40px;
            background: #007bff;
            border-radius: 8px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: background-color 0.3s ease;
        }

        .hamburger:hover {
            background: #0056b3;
        }

        .profile-section {
            display: flex;
            align-items: center;
            padding: 10px;
            cursor: pointer;
            margin-bottom: 20px;
            position: relative;
            background: #f5f5f5;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .profile-section:hover {
            background: #e9e9e9;
        }

        .profile-section i {
            margin-left: auto;
            color: #666;
            transition: transform 0.3s ease;
        }

        .profile-section.active i {
            transform: rotate(180deg);
        }

        .profile-section img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .profile-section .user-info {
            flex: 1;
        }

        .profile-section .user-name {
            font-weight: bold;
            color: #333;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: none;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }

        .dropdown-menu a:hover {
            background: #f5f5f5;
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 999;
                transform: translateX(-100%);
                padding-top: 70px;
                transition: transform 0.3s ease-in-out;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .chat-container {
                width: 100%;
                height: 100vh;
                border-radius: 0;
                padding-top: 60px;
            }

            #chatHeader {
                font-size: 20px;
                margin-left: 50px;
            }
        }

        .separator {
            height: 1px;
            background: #ddd;
            margin: 15px 0;
            width: 100%;
        }

        @media (min-width: 769px) {
            .hamburger {
                display: none;
            }

            .sidebar {
                transform: none;
                position: relative;
                padding-top: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="hamburger" id="hamburgerMenu">
        <i class="fas fa-bars"></i>
    </div>

    <div class="sidebar hidden" id="sidebar">
        <div class="profile-section" id="profileSection">
            <img src="<?php echo $_SESSION['avatar_url']; ?>" alt="Profile">
            <div class="user-info">
                <div class="user-name"><?php echo $_SESSION['name'] . ' ' . $_SESSION['lname']; ?></div>
            </div>
            <i class="fas fa-chevron-down"></i>
            <div class="dropdown-menu">
                <a href="index.php" class="btn btn-primary btn-home">Exit</a>
            </div>
        </div>
        <div class="separator"></div>
        <ul class="chat-options">
          <li id="allChat">  <i class="fa-solid fa-users"></i>Go to Community Forum</li>
        </ul>
        <input type="text" id="searchInput" class="form-control search-input" placeholder="Search users...">
      
        <ul id="userList" class="user-list">
            <!-- User list will be populated here -->
        </ul>
    </div>

    <div class="chat-container">
        <h4 id="chatHeader">Messages</h4>
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
        let chatMode = 'group';
        let shouldScrollToBottom = true;
        const notificationSound = new Audio('sent.mp3');

        const hamburgerMenu = document.getElementById('hamburgerMenu');
        const sidebar = document.getElementById('sidebar');

        hamburgerMenu.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('open');
            this.querySelector('i').classList.toggle('fa-bars');
            this.querySelector('i').classList.toggle('fa-times');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.sidebar') && !e.target.closest('.hamburger')) {
                sidebar.classList.remove('open');
                hamburgerMenu.querySelector('i').classList.add('fa-bars');
                hamburgerMenu.querySelector('i').classList.remove('fa-times');
            }
        });

        function fetchUsers(searchQuery = '') {
            $.get('fetch_users.php', {
                search: searchQuery
            }, function(data) {
                const response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#userList').empty();
                    response.users.forEach(user => {
                        $('#userList').append(
                            `<li data-user-id="${user.id}">
                                <img src="${user.avatar_url}" class="avatar">${user.fullname}
                             </li>`
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
            shouldScrollToBottom = scrollTop + clientHeight >= scrollHeight - 5;
        });

        function fetchMessages() {
            const url = chatMode === 'group' ? 'fetch_messages.php' : 'fetch_private_messages.php';
            const params = chatMode === 'private' ? {
                userId: selectedUserId
            } : {};
            $.get(url, params, function(data) {
                const response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#messageList').empty();
                    response.messages.forEach(message => {
                        $('#messageList').append(
                            `<div class="message">
                                <img src="${message.avatar_url}" class="avatar">
                                <div class="content">
                                    <span class="username">${message.fullname}</span>
                                    <span class="message-text">${message.message}</span>
                                    <span class="time">${new Date(message.timestamp).toLocaleTimeString()}</span>
                                </div>
                             </div>`
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
            const url = chatMode === 'group' ? 'post_message.php' : 'post_private_message.php';
            const params = chatMode === 'private' ? {
                message: $('#messageInput').val(),
                receiver_id: selectedUserId
            } : {
                message: $('#messageInput').val()
            };

            if (params.message.trim() !== '') {
                $.post(url, params, function(data) {
                    const response = JSON.parse(data);
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

        $('#sendButton').click(sendMessage);
        $('#messageInput').keypress(function(e) {
            if (e.which === 13 && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        $('#userList').on('click', 'li', function() {
            selectedUserId = $(this).data('user-id');
            const fullname = $(this).text().trim();
            $('#chatHeader').text('Chatting with ' + fullname);
            chatMode = 'private';
            fetchMessages();
            
            // Close sidebar on mobile
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('open');
                hamburgerMenu.querySelector('i').classList.add('fa-bars');
                hamburgerMenu.querySelector('i').classList.remove('fa-times');
            }
        });

        $('#allChat').click(function() {
            selectedUserId = null;
            $('#chatHeader').text('Community Forum');
            chatMode = 'group';
            fetchMessages();
            
            // Close sidebar on mobile
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('open');
                hamburgerMenu.querySelector('i').classList.add('fa-bars');
                hamburgerMenu.querySelector('i').classList.remove('fa-times');
            }
        });

        $('#searchInput').on('input', function() {
            fetchUsers($(this).val());
        });

        fetchUsers();
        fetchMessages();
        setInterval(fetchMessages, 2000);

        document.getElementById('profileSection').addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
            this.querySelector('.dropdown-menu').classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-section')) {
                document.querySelector('.profile-section').classList.remove('active');
                document.querySelector('.dropdown-menu').classList.remove('show');
            }
        });
    </script>
</body>

</html>