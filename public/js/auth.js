// Login function
function loginUser(email, password) {
    axios.get('/sanctum/csrf-cookie', { withCredentials: true })
      .then(() => {
        return axios.post('/login', {
          email: email,
          password: password
        }, {
          withCredentials: true
        });
      })
      .then(res => {
        console.log(res.data);
        window.location.href = "/dashboard"; // Redirect after login
      })
      .catch(err => {
        console.error(err.response.data);
        alert("Login failed: " + err.response.data.message);
      });
  }
  
  // Register function
  function registerUser(name, email, password, passwordConfirmation) {
    axios.get('/sanctum/csrf-cookie', { withCredentials: true })
      .then(() => {
        return axios.post('/register', {
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
        window.location.href = "/dashboard"; // Auto-login redirect after register
      })
      .catch(err => {
        console.error(err.response.data);
        alert("Registration failed: " + (err.response.data.message || "Check your input."));
      });
  }
  
  // Logout function
  function logoutUser() {
    axios.post('/logout', {}, {
      withCredentials: true
    })
      .then(() => {
        window.location.href = "/login"; // Redirect to login page
      })
      .catch(err => {
        console.error(err.response.data);
        alert("Logout failed: " + err.response.data.message);
      });
  }  