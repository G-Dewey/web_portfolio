/**
 * UI Rendering
 */

// Appends a single user row to the HTML table with data attributes for editing
function addRow(user){
    const row = $('<tr>');
    row.append($('<td>').text(user.username));
     row.append($('<td>').text(user.email));
    row.append($('<td class="capitalise hide-on-mobile">').text(user.firstName));
    row.append($('<td class="capitalise hide-on-mobile">').text(user.lastName));
    row.append($('<td class="capitalise">').text(user.role));

    // Define Action Buttons
    const $editBtn = $(`
        <td class="text-center">
            <button type="button" class="btn btn-warning edit-user"><i class="bi bi-pencil-square"></i></button>
        </td>
    `);

    const $deleteBtn = $(`
        <td class="text-center">
            <button type="button" class="btn btn-danger delete-user"><i class="bi bi-trash3"></i></button>
        </td>
    `);

    // Store user data directly on the button for easy access during the edit event
    $editBtn.find('button').attr({
        'userid': user.userID,
        'email': user.email,
        'firstName': user.firstName,
        'lastName': user.lastName,
        'username': user.username,
        'role': user.role
    });

    $deleteBtn.find('button').attr('userid', user.userID);

    row.append($editBtn, $deleteBtn);
    $('#table-users tbody').append(row);
}

/**
 * Data Fetching & Filtering
 */

// Retrieves the user list and applies role-based filters
async function FetchUserTable(){
    try {
        const users = await $.get("api/get-users");

        var userCount = 0;
        var adminCount = 0

        // Get current filter state from radio buttons
        const filterValue = $('input[name="role-filter"]:checked').attr('id');

        $('#table-users tbody').empty();
        var rowAdded = false;

        users.forEach(user => {
            // Count and filter based on 'admin' vs 'user' roles
            if (user['role'] == "admin"){
                adminCount += 1;
                if (filterValue == "filter-all" || filterValue == "filter-admin") { 
                    addRow(user);
                    rowAdded = true;
                }
            }
            else{
                userCount += 1;
                if (filterValue == "filter-all" || filterValue == "filter-user") { 
                    addRow(user);
                    rowAdded = true;
                }
            }
        });

        // Show placeholder if table is empty after filtering
        if (!rowAdded){
            $('#table-users tbody').append(`
                <tr>
                    <td colspan="6">No Users</td>
                </tr>
            `);
        }

        // Update dashboard counter metrics
        $('#total-count').text(adminCount+userCount);
        $('#user-count').text(userCount);
        $('#admin-count').text(adminCount);
    } catch (error) {
        $('#errorMessage').text("Could not load users. Please try again later.");
    }
}

// Refresh table whenever the filter changes
$(document).ready(function() {
    $('input[name="role-filter"]').on('change', function() {
        FetchUserTable();
    });
});

/**
 * Create User Logic
 */

$('#create-user-btn').click(function (e) {
    $('#modal-create-user').modal("show");
});

$('#form-create-user').submit(function (e) {
    e.preventDefault();
    const formData = $('#form-create-user').serialize();

    $.ajax({
        url: "api/create-new-user",
        type: "POST",
        data: formData,
        success: function (res) {
            FetchUserTable();
            Swal.fire({
                title: "Success!",
                text: "User created",
                icon: "success",
                theme: localStorage.getItem('theme')
            });
        },
        error: function (res) {
            alert("ERROR! " + res.responseText);
        }
    });

    closeModal("#modal-create-user")
});

/**
 * Edit User Logic
 */

// Delegate click event for dynamically generated edit buttons
$(document).on("click", ".edit-user", function (e) {
    const userID = $(this).attr("userid");
    const email = $(this).attr("email");
    const firstName = $(this).attr("firstName");
    const lastName = $(this).attr("lastName");
    const username = $(this).attr("username");
    const role = $(this).attr("role");

    // Populate Modal inputs with existing user data
    $("#edit-user-id").val(userID);
    $("#edit-user-title").text(`Edit ${username}`)
    $("#edit-first-name").val(firstName);
    $("#edit-last-name").val(lastName);
    $("#edit-username").val(username);
    $("#edit-email").val(email);
    $("#edit-access-level").val(role);
    
    // Reset password toggle state
    $('#toggle-password').prop('checked', false);
    $('#password-container').hide();
    $('#edit-password').val('');

    $("#modal-edit-user").modal("show");
});

$('#form-edit-user').submit(function (e) {
    e.preventDefault();
    const formData = $('#form-edit-user').serialize();

    $.ajax({
        url: "api/edit-user",
        type: "POST",
        data: formData,
        success: function (res) {
            FetchUserTable();
            Swal.fire({
                title: "Success!",
                text: "User Edited",
                icon: "success",
                theme: localStorage.getItem('theme')
            });
        },
        error: function (res) {
            alert("ERROR! " + res.responseText);
        }
    });

    closeModal("#modal-edit-user")
});

// UI logic for conditional password updating
$(document).on("change", "#toggle-password", function() {
    if ($(this).is(":checked")) {
        $('#password-container').slideDown();
    } else {
        $('#password-container').slideUp();
        $('#edit-password').val('');
    }
});

/**
 * Delete User Logic
 */

$(document).on("click", ".delete-user", function (e) {
    const userID = $(this).attr("userid");

    // Require confirmation before destructive API call
    Swal.fire({
                title: "User Deletion",
                text: "Are you sure you want to delete this user?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                theme: localStorage.getItem('theme')
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                    url: "api/delete-user",
                    type: "POST",
                    data: { userID: userID },
                    success: function (res) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: res,
                            icon: 'success',
                            theme:  localStorage.getItem('theme')
                        }).then(() => {
                            FetchUserTable();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Delete Failed',
                            text: xhr.responseText || 'An unknown error occurred.',
                            theme:  localStorage.getItem('theme')
                        });
                    }
            });
        }
    });
});

/**
 * Helpers
 */

function closeModal(modalID) {
    const modalEle = $(modalID);
    try{
        const form = modalEle.find('form');
        form[0].reset();
    }
    catch(error){

    }
    finally{
        modalEle.modal("hide")
    }
}

// Calls when ready
$(document).ready(function() {
        FetchUserTable();
});