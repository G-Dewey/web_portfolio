// Populates the user's profile and progress details
// This orchestrates the two main data fetches required for the profile view
async function populateDetails() {
    userDetails();
    courseDetails();
}

// Fetches the authenticated user's personal information
async function userDetails() {
    $.ajax({
        url: 'api/get-self', 
        type: 'GET',                
        dataType: 'json',           
        success: function(data) {
            // Populate the UI fields with the user's account details
            $('#username').text(data.username);
            $('#email').text(data.email);
            $('#firstName').text(data.firstName);
            $('#lastName').text(data.lastName);
            $('#role').text(data.role);
        },
        error: function(xhr, status, error) {
            // Display error fallback if the session or API fails
            $('#username, #firstName, #lastName, #role').text('Error');
        }
    });
}

// Fetches the count of courses the user has successfully finished
async function courseDetails() {
    $.ajax({
        url: 'api/completed-count', 
        type: 'GET',                
        dataType: 'json',           
        success: function(data) {
            // Display the formatted number of completed courses
            $('#completed').text(data.completedCount.toLocaleString());
        },
        error: function(xhr, status, error) {
            $('#completed').text('Error');
        }
    });
}