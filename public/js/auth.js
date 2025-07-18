// Set CSRF token for Axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

// Login
function loginUser(email, password) {
    axios.post('/api/login', {
        email: email,
        password: password
    })
        .then(response => {
            // The flash message is now stored in Laravel session
            // It will be displayed when the page loads
            console.log(response.data);
            
            const redirectUrl = response.data.redirect || '/client';
            window.location.href = redirectUrl;
        })
        .catch(error => {
            // Handle error flash messages
            const errorMessage = error.response?.data?.flash || error.response?.data?.message || "Login failed";
            alert("Login failed: " + errorMessage);
        });
}

// Register function
function registerUser(name, email, password, passwordConfirmation, token) {
    axios.get('/sanctum/csrf-cookie', { withCredentials: true })
        .then(() => {
            return axios.post('/api/register', {
                name: name,
                email: email,
                password: password,
                password_confirmation: passwordConfirmation,
                token: token
            }, {
                withCredentials: true
            });
        })
        .then(res => {
            console.log(res.data);
            window.location.href = "/client";
        })
        .catch(err => {
            console.error(err.response.data);
            alert("Registration failed: " + (err.response?.data?.message || "Check your input."));
        });
}

// Logout function
function logoutUser() {
    axios.post('/api/logout', {}, {
        withCredentials: true
    })
        .then(() => {
            window.location.href = "/login";
        })
        .catch(err => {
            console.error(err.response.data);
            alert("Logout failed: " + err.response?.data?.message);
        });
}
