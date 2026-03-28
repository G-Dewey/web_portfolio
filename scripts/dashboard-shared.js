// Gets the next course
async function appendNextCourse(targetID){
    $.ajax({
        url: 'api/user-enrollments',
        type: 'POST',
        data: { "userID" : -1}, // IF ID is -1, it grabs the users sessionID
        success: function(courses) {
            var added = false;
            for (const course of courses){
                $card = createCard(course);             
                if($card != false){
                    added = true;
                    $(`#${targetID}`).append($card);
                    break;
                }
            }

            if (!added){
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

// Checks date
function afterToday(date){
    if (date == "0000-00-00"){ 
        return false;
    }
    try{
        const today = new Date().toISOString().split('T')[0];
        const courseDate = new Date(date).toISOString().split('T')[0];

        return (today <= courseDate)
    }
    catch{
        return false;
    }
}

// Creates the card for the next course
function createCard(course){
    if (!afterToday(course.date)) {return false;}

    const $card = $(`
        <div class="card course-card course-card-dash p-0">
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
                <p class="m-0 mb-1">
                    <i class="bi bi-people"></i> - 
                    <span class="enrolled"></span>/<span class="capacity"></span>
                </p>
            </div>
        </div>
    `);

    $card.attr('id', genCardID(course.courseID));

    $card.find('.card-title').text(course.title || "Untitled Course");
    
    const diffLevel = course.level !== undefined ? course.level : 0;
    const diffData = difficultyMap[diffLevel] || difficultyMap[0];

    $card.find('.difficulty')
        .text(diffData.label)
        .addClass(diffData.class);

    hrsDuration = +(course.duration/60).toFixed(1);

    if (hrsDuration == 1){
        $card.find('.time-unit').text("hour")
    }
    else {
        $card.find('.time-unit').text("hours")
    }


    $card.find('.description').text(course.description)
    $card.find('.duration').text(hrsDuration || "0");
    $card.find('.enrolled').text(course.enrolled || "0");
    $card.find('.capacity').text(course.capacity || "0");
    $card.find('.date').text(formateDate(course.date) || "00/00/0000");

    return $card;
}