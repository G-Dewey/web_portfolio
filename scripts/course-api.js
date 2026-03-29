// create CARD
// Generates a jQuery card element based on course data and enrollment status
function createCard(course, archive=false){
    // Apply filters for search, difficulty level, and date/archive status
    if (!(searchFilter(course) && levelFilter(course))) {return false;}
    if (!afterToday(course.date) && !archive) {return false;}
    if (afterToday(course.date) && archive) {return false;}

    // Define the card's HTML template
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
                    <button class="btn flex-fill">Loading...</button>
                </div>
            </div>
        </div>
    `);

    // Set unique ID and populate title
    $card.attr('id', genCardID(course.courseID));
    $card.find('.card-title').text(course.title || "Untitled Course");
    
    // Determine and apply difficulty label/style
    const diffLevel = course.level !== undefined ? course.level : 0;
    const diffData = difficultyMap[diffLevel] || difficultyMap[0];

    $card.find('.difficulty')
        .text(diffData.label)
        .addClass(diffData.class);

    // Convert minutes to hours and handle unit pluralization
    hrsDuration = +(course.duration/60).toFixed(1);

    if (hrsDuration == 1){
        $card.find('.time-unit').text("hour")
    }
    else {
        $card.find('.time-unit').text("hours")
    }

    // Populate remaining course details
    $card.find('.description').text(course.description)
    $card.find('.duration').text(hrsDuration || "0");
    $card.find('.enrolled').text(course.enrolled || "0");
    $card.find('.capacity').text(course.capacity || "0");
    $card.find('.date').text(formateDate(course.date) || "00/00/0000");

    // Button control: Handle buttons based on whether the view is an archive or active
    const $button = $card.find('button')
    if (archive){
        $button.remove(); // No buttons for archived courses
    }
    else{
        $button.attr('course-id', course.courseID);

        // Check enrollment status via API to determine if the user can Enroll or Unenroll
        $.ajax({
            url: 'api/check-enrollment',
            method: 'POST',
            data: { courseID: course.courseID },
            dataType: 'json',
            success: function(response) {
                if (response.isEnrolled === true) {
                    // Configure button for unenrolling
                    $button.text('Unenroll');
                    $button.removeClass('btn-primary');
                    $button.addClass('btn-danger');
                    $button.addClass('course-unenroll-btn');
                } else {
                    // Configure button for enrolling
                    $button.text('Enroll');
                    $button.addClass('btn-primary');
                    $button.addClass('course-enroll-btn');
                }
            }
        });
    }

    return $card;
}

// API CALLS 

// Fetch user enrollements: Retrieves courses the current user is enrolled in
async function FetchUserEnrollments(targetID){
    const archiveStatus = $('#archive-switch').val();
    archive = false;
    if (archiveStatus == "archive") {archive = true;}
    $(`#${targetID}`).addClass('card-grid');

    $.ajax({
        url: 'api/user-enrollments',
        type: 'POST',
        data: { "userID" : -1}, // -1 indicates grabbing the session user ID
        success: function(courses) {
            var added = false;
            courses.forEach(course => {
                $card = createCard(course,archive);             
                if($card != false){
                    added = true;
                    $(`#${targetID}`).append($card);
                }
            });

            // If no courses matched the filters, display an alert
            if (!added){
                $(`#${targetID}`).removeClass('card-grid');
                $(`#${targetID}`).html(`
                    <div class="alert alert-info text-center w-100 mt-4">
                        <i class="fas fa-info-circle"></i> 
                        No enrollments found
                    </div>
                `);
            }
        },
        error: function(error) {
            console.error("AJAX Error:", error);
        }
    });
}

// Enroll: Handles the enrollment click event and updates the UI
$(document).on("click", ".course-enroll-btn", function (e) {
    const courseID = $(this).attr("course-id");

    $.ajax({
        url: 'api/enroll-course',
        method: 'POST',
        data: { courseID: courseID },
        success: function(res) {
            updateSingleCard(courseID); // Refresh the specific card
            Swal.fire({
                title: "Success!",
                text: "Enrolled to Course!",
                icon: "success",
                theme: localStorage.getItem('theme')
            });
        },
        error: function(xhr, status, res) {
            alert(`Selection failed: ${JSON.stringify(res)}`);
        }
    });
});

//Unenroll: Handles the unenrollment click event and handles UI cleanup
$(document).on("click", ".course-unenroll-btn", function (e) {
    const courseID = $(this).attr("course-id");

    $.ajax({
        url: 'api/delete-enrollment',
        method: 'POST',
        data: { courseID: courseID,
                userID: -1},
        success: function(res) {
            
            pageType = getPageType();
            
            // Logic to determine whether to refresh one card or the whole container
            if (pageType == "course-view") { updateSingleCard(courseID);}
            if (pageType == "enrollment-view") {LoadCards("courses-container");}

            Swal.fire({
                title: "Success!",
                text: "Unenrolled from Course!",
                icon: "success",
                theme: localStorage.getItem('theme')
            });
        },
        error: function(xhr, status, res) {
            alert(`Selection failed: ${JSON.stringify(res)}`);
        }
    });
});