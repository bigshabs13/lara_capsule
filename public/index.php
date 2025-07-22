<!DOCTYPE html>
<html>
<head>
    <title>Serj Time Capsule </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2em;
            /* Add the background image */
            background: url('capsule-bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        input, button { margin: 0.5em 0; }
        pre { background: rgba(0,0,0,0.7); padding: 1em; color: #fff; }
        form, h2, h1, button { background: rgba(0,0,0,0.5); padding: 0.5em; border-radius: 8px; }
        input { color: #000; }
    </style>
</head>
<body>
    <h1>Serj Time Capsule</h1>

    <h2>Register</h2>
    <form id="registerForm">
        <input name="name" placeholder="Name" required><br>
        <input name="email" placeholder="Email" required><br>
        <input name="password" type="password" placeholder="Password" required><br>
        <input name="password_confirmation" type="password" placeholder="Confirm Password" required><br>
        <button type="submit">Register</button>
    </form>

    <h2>Login</h2>
    <form id="loginForm">
        <input name="email" placeholder="Email" required><br>
        <input name="password" type="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>

    <h2>Profile</h2>
    <button onclick="getProfile()">Get My Profile</button>
    <button onclick="logout()">Logout</button>
    <pre id="result"></pre>

    <script>
        let token = '';

        document.getElementById('registerForm').onsubmit = async function(e) {
            e.preventDefault();
            const form = e.target;
            const data = {
                name: form.name.value,
                email: form.email.value,
                password: form.password.value,
                password_confirmation: form.password_confirmation.value
            };
            const res = await fetch('/api/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const json = await res.json();
            document.getElementById('result').textContent = JSON.stringify(json, null, 2);
        };

        document.getElementById('loginForm').onsubmit = async function(e) {
            e.preventDefault();
            const form = e.target;
            const data = {
                email: form.email.value,
                password: form.password.value
            };
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const json = await res.json();
            if (json.token) {
                token = json.token;
                document.getElementById('result').textContent = 'Login successful! Token stored.';
            } else {
                document.getElementById('result').textContent = JSON.stringify(json, null, 2);
            }
        };

        async function getProfile() {
            if (!token) {
                document.getElementById('result').textContent = 'Please log in first.';
                return;
            }
            const res = await fetch('/api/me', {
                headers: { 'Authorization': 'Bearer ' + token }
            });
            const json = await res.json();
            document.getElementById('result').textContent = JSON.stringify(json, null, 2);
        }

        async function logout() {
            if (!token) {
                document.getElementById('result').textContent = 'You are not logged in.';
                return;
            }
            const res = await fetch('/api/logout', {
                method: 'POST',
                headers: { 'Authorization': 'Bearer ' + token }
            });
            const json = await res.json();
            document.getElementById('result').textContent = JSON.stringify(json, null, 2);
            token = '';
        }
    </script>
</body>
</html>
