// Logout button click handler
// Triggers a SweetAlert2 confirmation dialog before logging the user out
$('#logout-btn').click(function (e) {
    Swal.fire({
                title: "Logout",
                text: "Are you sure that you want to log out?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Logout",
                // Dynamically sets the modal theme based on saved user preference
                theme: localStorage.getItem('theme')
    }).then((result) => {
        // If the user confirms the action, redirect to the logout endpoint
        if (result.isConfirmed){
            location.replace("logout");
        }
    });
});