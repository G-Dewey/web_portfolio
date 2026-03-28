async function populateDetails() {
    userDetails();
    courseDetails();
}

async function userDetails() {
    $.ajax({
        url: 'api/get-self', 
        type: 'GET',                
        dataType: 'json',           
        success: function(data) {
        $('#username').text(data.username);
        $('#email').text(data.email);
        $('#firstName').text(data.firstName);
        $('#lastName').text(data.lastName);
        $('#role').text(data.role);
        },
        error: function(xhr, status, error) {
            $('#username, #firstName, #lastName, #role').text('Error');
        }
    });
}

async function courseDetails() {
    $.ajax({
        url: 'api/completed-count', 
        type: 'GET',                
        dataType: 'json',           
        success: function(data) {
            $('#completed').text(data.completedCount.toLocaleString());
        },
        error: function(xhr, status, error) {
            $('#completed').text('Error');
        }
    });
}