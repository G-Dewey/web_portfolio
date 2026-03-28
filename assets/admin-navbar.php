<nav class="navbar navbar-expand-xxl navbar-config shadow fixed-top">
  <div class="container-fluid px-3 py-2">
    
    <div class="d-flex align-items-center">
      <a class="navbar-brand" href="#">
        <img src="imgs/logo-small.png" style="height: 40px;">
      </a>
      <?PHP include 'assets/theme_button.html';?>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      
      <ul class="navbar-nav mx-auto navbar-options rounded-pill d-flex pb-0 p-xxl-1 shadow-sm">
        <li class="nav-item"><a class="nav-link active px-3 py-xxl-2" href="/admin-dashboard">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link active px-3 py-xxl-2" href="/view-enrollments">Your Enrollments</a></li>
        <li class="nav-item"><a class="nav-link active px-3 py-xxl-2" href="/explore-courses">Explore Courses</a></li>
        <li class="nav-item"><a class="nav-link active px-3 py-xxl-2" href="/course-administration">Manage Courses</a></li>
        <li class="nav-item"><a class="nav-link active px-3 py-xxl-2" href="/user-administration">Manage Users</a></li>
        <li class="nav-item"><a class="nav-link active px-3 py-xxl-2" href="/user-details">Your Details</a></li>
      </ul>

      <div class="d-flex justify-content-xxl-end mt-0 mt-xxl-0"> 
        <ul class="navbar-nav w-100"> 
          <li class="nav-item text-center"> 
            <button class="btn button-danger rounded-pill pt-0 py-xxl-2 px-4 w-100-mobile" id="logout-btn">Logout</button>
          </li>
        </ul>
      </div>

    </div>
  </div>
</nav>