// UTILS
const difficultyMap = {
    0: { label: "N/A", class: "difficulty-na" },
    1: { label: "Rookie", class: "rookie" },
    2: { label: "Amateur", class: "amateur" },
    3: { label: "Challenger", class: "challenger" },
    4: { label: "Pro", class: "pro" }
};

async function FetchCourseCards(targetID){
    const courses = await $.get("api/get-courses");

    $(`#${targetID}`).addClass('card-grid');
    added = false;

    courses.forEach(course => {
        // Add Card is defined differenly in admin-api and user-api
        $card = createCard(course);
        if ($card != false){
            added = true;
            $(`#${targetID}`).append($card);
        }
    });

    if (!added){
        $(`#${targetID}`).removeClass('card-grid');
        $(`#${targetID}`).html(`
            <div class="alert alert-info text-center w-100 mt-4">
                <i class="fas fa-info-circle"></i> 
                No courses found
            </div>
        `);
    }
}

async function updateSingleCard(courseID) {
    $.ajax({
        url: 'api/get-single-course',
        method: 'POST',
        data: { courseID: courseID },
        success: function(course) {
            const cardID = genCardID(courseID);
            $card = $(`#${cardID}`);

            $newCard = createCard(course);
            
            $card.replaceWith($newCard);
        },
        error: function(xhr, status, error) {
            console.error("Selection failed:", error);
        }
    });
}

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

function genCardID(courseID){
    return "course-card-" + courseID;
}

// Converts from YYYY-MM-DD to DD/MM/YYYY
function formateDate(date){
    date = String(date);
    const parts = date.split('-');
    return `${parts[2]}/${parts[1]}/${parts[0]}`;
}

function closeModal(modalID) {
    const modalEle = $(modalID);
    
    try{
        const form = modalEle.find('form');
        form[0].reset();
    }
    catch(error){
        alert(error)
    }
    finally{
        modalEle.modal("hide")
    }
}

function getPageType(){
    return $('#page-type').val();
}

async function LoadCards(targetID){
    $('#' + targetID).empty();

    pageType = getPageType();

    if (pageType == "course-view") { FetchCourseCards(targetID);}
    if (pageType == "enrollment-view") { FetchUserEnrollments(targetID);}
}

// SEARCHERS
$(document).on('click', '.timespan-opt', function(e) {
    e.preventDefault();
    
    const selectedText = $(this).text();

    $('#filterTimespan').text('Timespan: ' + selectedText + " ");
    $('#filterTimespan').data('current-value', selectedText);

    
    LoadCards("courses-container");
});

$(document).on('click', '.level-opt', function(e) {
    e.preventDefault();
    
    const selectedText = $(this).text();

    $('#filterLevel').text('Level: ' + selectedText + " ");
    $('#filterLevel').data('current-value', selectedText);

    LoadCards("courses-container");
});

$("#searchFilter").on("keyup", function() {
    LoadCards("courses-container");
});

$('#archive-switch').on('click', function() {
    const btn = $(this);
    
    if (btn.val() === 'upcoming') {
        btn.val('archive');
        btn.text('View Upcoming');
        
        btn.removeClass('btn-danger')
        btn.addClass('btn-primary')
    } else {
        btn.val('upcoming');
        btn.text('View Archive');
        
        btn.removeClass('btn-primary')
        btn.addClass('btn-danger');
    }

    LoadCards("courses-container");
});

// FILTERS 
function dateFilter(course){
    const dateFilter = $('#filterTimespan').data('current-value') || 'All';

    if (course.date == "0000-00-00"){ 
        if (dateFilter == "All"){return true;}
        return false;
    }

    after = afterToday(course.date);
    console.log(course.title , after);

    if ( dateFilter=="Upcoming" && after) {return true;}
    if ( dateFilter=="Past" && !after) {return true;}
    if (dateFilter=="All") {return true;}

    return false;
}

function searchFilter(course){
    const filterValue = $("#searchFilter").val().toLowerCase();
    const courseTitle = course.title.toLowerCase();

    if (filterValue == ""){return true;}
    if (courseTitle.includes(filterValue)){return true;}
    
    return false;
}

function levelFilter(course){
    const levelFilter = ($('#filterLevel').data('current-value') || 'any').toLowerCase();
    const diffLevel = course.level;
    const levelText = difficultyMap[diffLevel].label.toLowerCase();

    if (levelFilter == "any") {return true;}
    if (levelFilter == levelText) {return true;}

    return false;
}

function filterCourse(course){
    return (dateFilter(course) && searchFilter(course) && levelFilter(course));
}
