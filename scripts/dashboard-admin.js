// Populates the content of the dashboard
// Orchestrates the loading of the "next course" preview and administrative metrics
async function populateContent() {
    appendNextCourse("next-course");
    adminStats();
}

// Wrapper function to trigger all individual statistic fetches
async function adminStats() {
    userStats();
    courseStats();
    enrollmentStats();
}

// Fetches user-related metrics (total, admin, and trainee counts) via API
async function userStats() {
    $.ajax({
        url: 'api/user-count', 
        type: 'GET',                
        dataType: 'json',           
        success: function(data) {
            // Update the DOM with formatted numbers
            $('#user-count').text(data.totalUsers.toLocaleString());
            $('#admin-count').text(data.adminCount.toLocaleString());
            $('#trainee-count').text(data.nonAdminCount.toLocaleString());
        },
        error: function(xhr, status, error) {
            // Fallback text in case of connection or server issues
            $('#user-count, #admin-count, #trainee-count').text('Could not fetch');
        }
    });
}

// Fetches course-related metrics (upcoming vs. past) via API
async function courseStats() {
    $.ajax({
        url: 'api/course-count', 
        type: 'GET',                
        dataType: 'json',           
        success: function(data) {
            // Populate the dashboard with course timeline stats
            $('#upcoming-count').text(data.upcomingCount.toLocaleString());
            $('#past-count').text(data.pastCount.toLocaleString());
        },
        error: function(xhr, status, error) {
            $('#upcoming-count, #past-count').text('Could not fetch');
        }
    });
}

// Fetches the total number of course enrollments across the system
async function enrollmentStats() {
    $.ajax({
        url: 'api/enrollment-count', 
        type: 'GET',                
        dataType: 'json',           
        success: function(data) {
            // Display the total enrollment figure
            $('#enrollment-count').text(data.enrollmentCount.toLocaleString());
        },
        error: function(xhr, status, error) {
            $('#enrollment-count').text('Could not fetch');
        }
    });
}