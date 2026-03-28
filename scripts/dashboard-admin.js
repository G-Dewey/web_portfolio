// Populates the content of the dashboard
async function populateContent() {
    appendNextCourse("next-course");
    adminStats();
}

async function adminStats() {
    userStats();
    courseStats();
    enrollmentStats();
}

async function userStats() {
    $.ajax({
        url: 'api/user-count', 
        type: 'GET',                
        dataType: 'json',           
        success: function(data) {
            $('#user-count').text(data.totalUsers.toLocaleString());
            $('#admin-count').text(data.adminCount.toLocaleString());
            $('#trainee-count').text(data.nonAdminCount.toLocaleString());
        },
        error: function(xhr, status, error) {
            $('#user-count, #admin-count, #trainee-count').text('Could not fetch');
        }
    });
}

async function courseStats() {
    $.ajax({
        url: 'api/course-count', 
        type: 'GET',                
        dataType: 'json',           
        success: function(data) {
            $('#upcoming-count').text(data.upcomingCount.toLocaleString());
            $('#past-count').text(data.pastCount.toLocaleString());
        },
        error: function(xhr, status, error) {
            $('#upcoming-count, #past-count').text('Could not fetch');
        }
    });
}

async function enrollmentStats() {
    $.ajax({
        url: 'api/enrollment-count', 
        type: 'GET',                
        dataType: 'json',           
        success: function(data) {
            $('#enrollment-count').text(data.enrollmentCount.toLocaleString());
        },
        error: function(xhr, status, error) {
            $('#enrollment-count').text('Could not fetch');
        }
    });
}

