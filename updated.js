
    document.addEventListener('DOMContentLoaded', function() {
        const signupForm = document.getElementById('signup-form');
        const loginForm = document.getElementById('login-form');
        const signupMessage = document.getElementById('signup-message');
        const loginMessage = document.getElementById('login-message');
        
        // API base URL for Replit environment
        const API_BASE = 'https://b22fc393-9892-4774-9729-c11fae395f62-00-26ymd5g7z3a7f.worf.replit.dev/API';
        
        // Signup form submission
        signupForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const username = document.getElementById('signup-username').value;
            const password = document.getElementById('signup-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            // Client-side validation
            if (password !== confirmPassword) {
                showMessage(signupMessage, "Passwords do not match!", "error");
                return;
            }
            
            if (password.length < 6) {
                showMessage(signupMessage, "Password must be at least 6 characters long!", "error");
                return;
            }
            
            if (username.length < 3) {
                showMessage(signupMessage, "Username must be at least 3 characters long!", "error");
                return;
            }
            
            // Real API call
            await signupUser(username, password);
        });
        
        // Login form submission
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const username = document.getElementById('login-username').value;
            const password = document.getElementById('login-password').value;
            
            // Real API call
            await loginUser(username, password);
        });
        
        // Function to show messages
        function showMessage(element, text, type) {
            element.textContent = text;
            element.className = `message ${type}`;
            element.style.display = 'block';
            
            setTimeout(() => {
                element.style.display = 'none';
            }, 5000);
        }
        
        // Real signup function
        async function signupUser(username, password) {
            showMessage(signupMessage, "Creating account...", "success");
            
            try {
                const response = await fetch(`${API_BASE}/signup.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showMessage(signupMessage, data.message, "success");
                    signupForm.reset();
                } else {
                    showMessage(signupMessage, data.message, "error");
                }
            } catch (error) {
                showMessage(signupMessage, "Network error. Please try again.", "error");
                console.error('Signup error:', error);
            }
        }
        
        // Real login function
        async function loginUser(username, password) {
            showMessage(loginMessage, "Logging in...", "success");
            
            try {
                const response = await fetch(`${API_BASE}/login.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showMessage(loginMessage, data.message, "success");
                    
                    // Store session data
                    localStorage.setItem('session_token', data.session_token);
                    localStorage.setItem('user_id', data.user_id);
                    localStorage.setItem('username', data.username);
                    
                    // Redirect to dashboard after a delay
                    setTimeout(() => {
                        window.location.href = 'dashboard.html';
                    }, 1500);
                } else {
                    showMessage(loginMessage, data.message, "error");
                }
            } catch (error) {
                showMessage(loginMessage, "Network error. Please try again.", "error");
                console.error('Login error:', error);
            }
        }
    });
