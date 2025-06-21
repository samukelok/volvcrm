// Set CSRF token for Axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

// Login function
function loginUser(email, password) {
    axios.get('/sanctum/csrf-cookie', { withCredentials: true })
      .then(() => {
        return axios.post('/api/login', {
          email: email,
          password: password
        }, {
          withCredentials: true
        });
      })
      .then(res => {
        console.log(res.data);
        window.location.href = "/dashboard";
      })
      .catch(err => {
        console.error(err.response.data);
        alert("Login failed: " + (err.response?.data?.message || "Check credentials."));
      });
}

// Register function
function registerUser(name, email, password, passwordConfirmation) {
    axios.get('/sanctum/csrf-cookie', { withCredentials: true })
      .then(() => {
        return axios.post('/api/register', {
          name: name,
          email: email,
          password: password,
          password_confirmation: passwordConfirmation
        }, {
          withCredentials: true
        });
      })
      .then(res => {
        console.log(res.data);
        window.location.href = "/dashboard";
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
