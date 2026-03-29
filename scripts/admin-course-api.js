// ADD CARD
// Constructs a jQuery object representing a course card with data and action buttons
function createCard(course){
    // Filter the course; stop if it doesn't meet criteria
    if (!filterCourse(course)) {return false;}

    // Define the HTML structure for the course card
    const $card = $(`
        <div class="card course-card p-0 mb-4">
            <div class="card-body d-flex flex-column">
                <p class="mb-1"><span class="rounded difficulty text-center"></span></p>
                <h2 class="card-title mt-2 mb-0"></h2>
                <hr class="my-3">
                <p class="description"></p>
                <p class="m-0">
                    <i class="bi bi-clock"></i> - 
                    <span class="duration"></span> <span class="time-unit"></span>
                </p>
                <p class="m-0">
                    <i class="bi bi-calendar"></i> - 
                    <span class="date"></span>
                </p>
                <p class="m-0 mb-3">
                    <i class="bi bi-people"></i> - 
                    <span class="enrolled"></span>/<span class="capacity"></span>
                </p>
                
                <div class="d-flex justify-content-start d-flex mt-auto">
                    <button class="btn btn-primary me-1 course-enrollments-btn flex-fill"><i class="bi bi-people-fill"></i></button>
                    <button class="btn btn-warning mx-1 course-edit-btn flex-fill"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-danger ms-1 course-delete-btn flex-fill"><i class="bi bi-trash3"></i></button>
                </div>
            </div>
        </div>
    `);

    // Assign unique ID and populate text content
    $card.attr('id', genCardID(course.courseID));
    $card.find('.card-title').text(course.title || "Untitled Course");
    
    // Map difficulty level to labels and CSS classes
    const diffLevel = course.level !== undefined ? course.level : 0;
    const diffData = difficultyMap[diffLevel] || difficultyMap[0];

    $card.find('.difficulty')
        .text(diffData.label)
        .addClass(diffData.class);

    // Calculate duration in hours and handle pluralization
    hrsDuration = +(course.duration/60).toFixed(1);

    if (hrsDuration == 1){
        $card.find('.time-unit').text("hour")
    }
    else {
        $card.find('.time-unit').text("hours")
    }

    // Fill in remaining course details
    $card.find('.description').text(course.description)
    $card.find('.duration').text(hrsDuration || "0");
    $card.find('.enrolled').text(course.enrolled || "0");
    $card.find('.capacity').text(course.capacity || "0");
    $card.find('.date').text(formateDate(course.date) || "00/00/0000");

    // 3. Attach the ID to the buttons via data attributes for event handling
    $card.find('button').attr('course-id', course.courseID);

    // 4. Return the fully constructed jQuery object
    return $card;
}

// COURSE CRUD
//----------------------------------------------------------
// View Enrollments: Triggered when clicking the enrollment button on a card
$(document).on('click', '.course-enrollments-btn', function (e) {
    const courseID = $(this).attr("course-id");
    
    const courseName = $(this).closest('.course-card').find('.card-title').text();
    $('#course-name').text(courseName);
    
    // Show the modal and fetch the user list
    $('#modal-course-enrollments').modal('show');
    fillEnrollmentTable(courseID);
});

// Get a courses enrollments: AJAX call to fetch and render enrolled users
async function fillEnrollmentTable(courseID) {
    $.ajax({
        url: "api/course-enrollments",
        type: "POST",
        data: {"courseID" : courseID},
        success: function (users) {
            const $tbody = $('#enrollment-list-body');
            $tbody.empty();

            if(users.length === 0){
                $tbody.append('<tr><td colspan="4" class="text-center text-muted">No enrollments in this course</td></tr>');
            }
            
            // Build table rows for each enrolled user
            users.forEach(user => {
                const $tr = $('<tr>');
                $tr.append($('<td>').text(user.username));
                $tr.append($('<td>').text(user.firstName));
                $tr.append($('<td>').text(user.lastName));
                
                const $deleteBtn = $(`
                    <td class="text-center">
                        <button type="button" class="btn button-danger delete-user"><i class="bi bi-trash3"></i></button>
                    </td>
                `);
                
                $deleteBtn.find('button').attr('userid', user.userID);
                $deleteBtn.find('button').attr('courseid', courseID);
                $tr.append($deleteBtn);

                $tbody.append($tr);
            });
        },
        error: function (res) {
            alert("ERROR! " + res.responseText);
        }
    });
}

// Admin Delete Enrollment: Removes a specific user from a course with confirmation
$(document).on("click", ".delete-user", function (e) {
    const userID = $(this).attr("userid");
    const courseID = $(this).attr("courseid");

    Swal.fire({
                title: "Course Deletion",
                text: "Are you sure you want to delete this enrollment?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                theme: localStorage.getItem('theme')
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                    url: "api/delete-enrollment",
                    type: "POST",
                    data: { courseID: courseID,
                            userID: userID },
                    success: function (res) {
                        fillEnrollmentTable(courseID)
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


// Create User: Functions to handle opening the modal and tracking character limits
$('#create-course-btn').click(function (e) {
    $('#modal-create-course').modal("show");
});

// Real-time character count for Title
$('#course-title').on('input', function() {
        let length = $(this).val().length;
        
        $('#charCountTitle').text(length + ' / 50');

        if (length >= 50) {
            $('#charCountTitle').addClass('text-danger');
        } else {
            $('#charCountTitle').removeClass('text-danger');
        }
    });

// Real-time character count for Description
$('#course-description').on('input', function() {
        let length = $(this).val().length;
        
        $('#charCountDesc').text(length + ' / 200');

        if (length >= 200) {
            $('#charCountDesc').addClass('text-danger');
        } else {
            $('#charCountDesc').removeClass('text-danger');
        }
    });

// Handle submission of the Create Course form
$('#form-create-course').submit(function (e) {
    e.preventDefault();

    const formData = $('#form-create-course').serialize();
    console.log(formData);

    $.ajax({
        url: "api/create-new-course",
        type: "POST",
        data: formData,
        success: function (res) {
            LoadCards("courses-container");
            Swal.fire({
                title: "Success!",
                text: "Course Created",
                icon: "success",
                theme: localStorage.getItem('theme')
            });
        },
        error: function (res) {
            alert("ERROR! " + res.responseText);
        }
    });

    closeModal("#modal-create-course")
});

// Edit course: Fetches current course data and populates the edit modal
$(document).on("click", ".course-edit-btn", function (e) {
    const courseID = $(this).attr("course-id");
    $.ajax({
        url: 'api/get-single-course',
        method: 'POST',
        data: { courseID: courseID },
        success: function(course) {
            console.log(course);
            
            const $modal = $('#modal-edit-course');

            // Ensure capacity cannot be set lower than the number of currently enrolled students
            minVal = course.enrolled
            if (minVal == 0){
                minVal = 1;
            }

            // Convert total minutes back to hours and minutes for the inputs
            durationRaw = course.duration
            durationHrs = Math.floor(durationRaw/60);
            durationMins = durationRaw % 60
            
            $modal.find("#course-id").val(course.courseID)
            $modal.find("#course-title").val(course.title);
            $modal.find("#course-description").val(course.description);
            $modal.find("#course-difficulty").val(course.level);
            $modal.find("#course-date").val(course.date);
            $modal.find("#course-duration-hrs").val(durationHrs);
            $modal.find("#course-duration-mins").val(durationMins);
            $modal.find("#course-capacity").val(course.capacity);
            $modal.find("#course-capacity").attr("min", minVal);
            $modal.find("#enrolled").text(course.enrolled);

            $("#modal-edit-course").modal("show");
        },
        error: function(xhr, status, error) {
            console.error("Selection failed:", error);
        }
    });
});

// Handle submission of the Edit Course form
$('#form-edit-course').submit(function (e) {
    e.preventDefault();

    const formData = $('#form-edit-course').serialize();

    const params = new URLSearchParams(formData);
    const courseID = params.get('course-ID');

    $.ajax({
        url: "api/edit-course",
        type: "POST",
        data: formData,
        success: function (res) {
            updateSingleCard(courseID);
            closeModal("#modal-edit-course");
            Swal.fire({
                title: "Success!",
                text: "Course Edited",
                icon: "success",
                theme: localStorage.getItem('theme')
            });
        },
        error: function (res) {
            alert("ERROR! " + res.responseText);
        }
    });

    closeModal("#modal-edit-course")
});

// Delete course: Removes an entire course from the database with confirmation
$(document).on("click", ".course-delete-btn", function (e) {
    const courseID = $(this).attr("course-id");

    Swal.fire({
                title: "Course Deletion",
                text: "Are you sure you want to delete this course?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                theme: localStorage.getItem('theme')
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                    url: "api/delete-course",
                    type: "POST",
                    data: { courseID: courseID },
                    success: function (res) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: res,
                            icon: 'success',
                            theme:  localStorage.getItem('theme')
                        }).then(() => {
                            LoadCards("courses-container");
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