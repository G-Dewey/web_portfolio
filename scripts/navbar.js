$('#logout-btn').click(function (e) {
    Swal.fire({
                title: "Logout",
                text: "Are you sure that you want to log out?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Logout",
                theme: localStorage.getItem('theme')
    }).then((result) => {
        if (result.isConfirmed){
            location.replace("logout");
        }
    });
});