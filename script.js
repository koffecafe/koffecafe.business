const container = document.getElementById('container');
const registerbtn = document.getElementById('register');
const loginbtn = document.getElementById('login');
const signupForm = document.getElementById('signupForm');
const errorMessageDiv = document.getElementById('error-message');

// Toggle between sign-up and sign-in
registerbtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginbtn.addEventListener('click', () => {
    container.classList.remove("active");
});

// Handle AJAX form submission
signupForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    errorMessageDiv.innerHTML = ''; // Clear previous messages

    // Gather form data
    const formData = new FormData(this);

    // Make an AJAX request
    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Redirect to success page
            window.location.href = 'success.html';
        } else {
            // Handle error (show message)
            errorMessageDiv.innerHTML = data.message;
        }
    })
    .catch(error => console.error('Error:', error));
});
