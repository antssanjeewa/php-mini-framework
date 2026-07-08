<!DOCTYPE html>
<html lang="si">

<head>
  <meta charset="UTF-8">
  <title>My Mini Framework</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
      background: #2b2b2b;
    }

    nav {
      background: #333;
      padding: 15px;
      color: white;
    }

    nav a {
      color: white;
      margin-right: 15px;
      text-decoration: none;
    }

    .container {
      padding: 20px;
      color: white;
      background: #141414;
      margin: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    footer {
      text-align: center;
      padding: 15px;
      background: #141414;
      color: white;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>

<body>

  <nav>
    <a href="/">Home</a> |
    <a href="/about">About</a> |
    <a href="/user">User</a> |
    <a href="/user/1">Profile (User 1)</a>
  </nav>

  <div>

  </div>

  <div class="container">
    {{content}}
  </div>

  <footer>
    <p>&copy; 2026 Mini Framework. All rights reserved.</p>
  </footer>

</body>

</html>