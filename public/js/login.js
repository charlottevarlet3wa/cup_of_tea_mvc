document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    const response = await fetch('/path/to/login/api', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({email, password}),
    });

    const data = await response.json();

    if (data.success) {
        window.location.href = 'http://localhost/cup_of_tea_php/?route=home'; // Redirect on success
    } else {
        document.getElementById('message').textContent = data.message; // Show error message
    }
});
