<?php
session_start();
require 'db.php';

$user = null; // Initialize $user to null
$error = '';
$success = '';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    //Uncomment the following lines to force login when a user is not logged in
    header("Location: login.php");
    exit;
}

if(isset($_GET['page'])) {
    $page = htmlspecialchars($_GET['page']);
} else {
    $page = "home"; // Default page
}

if ($page === "chat") {
    // Process new message submission if any (PHP fallback for non-JS or form submission)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
        if (!$user) {
            header("Location: login.php");
            exit;
        }
        $message = trim($_POST['message']);
        if (empty($message)) {
            $error = "Message cannot be empty.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO chat_messages (user_id, message) VALUES (?, ?)");
            if ($stmt->execute([$user['id'], $message])) {
                // Redirect to avoid duplicate submission
                header("Location: index.php?page=chat");
                exit;
            } else {
                $error = "Error sending message.";
            }
        }
    }
    
    // For initial page load, retrieve all messages
    $stmt = $pdo->query("
        SELECT cm.id, cm.message, cm.sent_at, u.username 
        FROM chat_messages cm
        JOIN users u ON cm.user_id = u.id
        ORDER BY cm.sent_at ASC
    ");
    $messages = $stmt->fetchAll();
    
    // Get the ID of the last message
    $lastId = 0;
    foreach ($messages as $msg) {
        if ($msg['id'] > $lastId) {
            $lastId = $msg['id'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="si">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>APG</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
          /* Chat bubble styling */
          .chat-bubble {
              padding: 10px 15px;
              margin: 10px 0;
              border-radius: 20px;
              max-width: 70%;
              background-color: #ffffff;
              box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
          }
          /* Messages from current user */
          .chat-bubble.self {
              background-color: #e1f5fe;
              margin-left: auto;
              text-align: right;
          }
          .chat-bubble .username {
              font-weight: bold;
              margin-bottom: 5px;
          }
          .chat-bubble .timestamp {
              font-size: 0.8rem;
              color: #657786;
          }
          /* Message form styling */
          #chatForm {
              background-color: #ffffff;
              padding: 15px;
              border-bottom: 1px solid #e1e8ed;
              margin-bottom: 20px;
          }
        </style>
    </head>
    <body>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
          <div class="col-md-3 mb-2 mb-md-0">
            <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none" style="font-size: 1.5rem; font-weight: bold;">
              apg.si
            </a>
          </div>
    
          <?php if (isset($_GET['page'])): ?>
            <?php $page = htmlspecialchars($_GET['page']); ?>
          <?php endif; ?>
          <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php?page=home" class="nav-link px-2 link-body-emphasis">Home</a></li>
            <li><a href="index.php?page=chat" class="nav-link px-2 link-body-emphasis">Chat</a></li>
            <li><a href="index.php?page=casino" class="nav-link px-2 link-body-emphasis">Casino</a></li>
            <li><a href="index.php?page=about" class="nav-link px-2 link-body-emphasis">About</a></li>
          </ul>
    
          <?php if (isset($user)): ?>
            <div class="col-md-3 text-end">
                <span class="text-body-secondary">Welcome, <?php echo htmlspecialchars($user['username']); ?>!</span>
                <button type="button" class="btn btn-outline-primary me-2">Profile</button>
                <button type="button" class="btn btn-primary">Settings</button>
            </div>
          <?php else: ?>
            <div class="col-md-3 text-end">
                <a href="login.php"><button type="button" class="btn btn-outline-primary me-2">Login</button></a>
                <a href="register.php"><button type="button" class="btn btn-primary">Sign-up</button></a>
            </div>
          <?php endif; ?>
        </header>
    
        <div class="content">
          <?php if ($page == "home"): ?>
            <h1>Welcome to APG</h1>
            <p>This is the home page.</p>
    
          <?php elseif ($page == "chat"): ?>
            <!-- Chat Page -->
            <h2 class="text-center mb-4">Chat Room</h2>
            <?php if ($error): ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php elseif ($success): ?>
              <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <!-- Message form at the top -->
            <div id="chatForm" class="mb-4">
              <form method="post" action="index.php?page=chat">
                <div class="input-group">
                  <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
                  <button type="submit" class="btn btn-primary">Send</button>
                </div>
              </form>
            </div>
            <!-- Chat messages are rendered below (infinite scroll, natural page flow) -->
            <div id="messagesContainer">
              <?php foreach ($messages as $msg): ?>
                <?php $bubbleClass = ($msg['username'] === $user['username']) ? 'chat-bubble self' : 'chat-bubble'; ?>
                <div class="<?php echo $bubbleClass; ?>" data-message-id="<?php echo $msg['id']; ?>">
                  <div class="username"><?php echo htmlspecialchars($msg['username']); ?></div>
                  <div class="message-text"><?php echo htmlspecialchars($msg['message']); ?></div>
                  <div class="timestamp"><?php echo htmlspecialchars($msg['sent_at']); ?></div>
                </div>
              <?php endforeach; ?>
            </div>
    
          <?php elseif ($page == "casino"): ?>
            <h1>Casino Page</h1>
            <p>This is the casino page.</p>
          <?php elseif ($page == "about"): ?>
            <h1>About Page</h1>
            <p>This is the about page.</p>
          <?php endif; ?>
          <a href="logout.php" style="color:blue">Logout</a>
        </div>
    
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
          <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1" style="font-size: 1.5rem; font-weight: bold;">
              apg.si
            </a>
            <span class="mb-3 mb-md-0 text-body-secondary">© 2025 apg.si</span>
          </div>
    
          <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" href="#">X</a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#">Instagram</a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#">Facebook</a></li>
          </ul>
        </footer>
    </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
        <?php if ($page == "chat"): ?>
          <script>
            // Current user for bubble alignment
            const currentUser = "<?php echo htmlspecialchars($user['username']); ?>";
            // Set lastMessageId to the highest message ID from the initial load
            let lastMessageId = <?php echo $lastId; ?>;
            
            // Function to fetch new messages via AJAX
            async function fetchNewMessages() {
              try {
                const response = await fetch("get_messages.php?after=" + lastMessageId);
                const newMessages = await response.json();
                if (newMessages.length > 0) {
                  const container = document.getElementById("messagesContainer");
                  newMessages.forEach(msg => {
                    const bubble = document.createElement("div");
                    bubble.classList.add("chat-bubble");
                    if (msg.username === currentUser) {
                      bubble.classList.add("self");
                    }
                    bubble.setAttribute("data-message-id", msg.id);
                    bubble.innerHTML = `
                      <div class="username">${msg.username}</div>
                      <div class="message-text">${msg.message}</div>
                      <div class="timestamp">${msg.sent_at}</div>
                    `;
                    container.appendChild(bubble);
                    lastMessageId = msg.id;
                  });
                }
              } catch (error) {
                console.error("Error fetching new messages:", error);
              }
            }
            
            // Poll for new messages every 3 seconds
            setInterval(fetchNewMessages, 3000);
          </script>
        <?php endif; ?>
    </body>
</html>
