// After successful login form submission
document.getElementById('login-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const response = await fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        })
    });

    if (response.ok) {
        const { access_token } = await response.json();
        
        // REDIRECTION
        fetch('/api/me', {
            headers: {
                'Authorization': `Bearer ${access_token}`
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.dashboard.type === 'admin') {
                window.location.href = '/admin';
            } else {
                window.location.href = '/dashboard';
            }
        });
    }
});