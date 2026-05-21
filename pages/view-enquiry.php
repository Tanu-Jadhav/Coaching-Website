<?php
include("../config/db.php");
include("../includes/header.php");
include("../includes/navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enquiries | Admin Panel</title>

    <!-- SEO -->
    <meta name="description" content="Manage student enquiries easily with search, filter, edit and delete options.">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/view_enquiry.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h1>Student Enquiries</h1>
        <a href="../admin/dashboard.php" class="back-btn">← Dashboard</a>
    </div>

    <!-- SEARCH -->
    <input type="text" id="search" placeholder="Search enquiries..." onkeyup="loadData()">

    <!-- FILTER -->
    <select id="courseFilter" onchange="loadData()">
        <option value="">All Courses</option>
        <?php
        $courses = mysqli_query($conn, "SELECT * FROM courses");
        while($c = mysqli_fetch_assoc($courses)){
            echo "<option value='".$c['name']."'>".$c['name']."</option>";
        }
        ?>
    </select>

    <!-- LOADER -->
    <div id="loader" style="display:none;">Loading...</div>

    <!-- TABLE -->
    <div id="tableData"></div>

</div>

<!-- MESSAGE MODAL -->
<div id="msgModal" class="modal">
    <div class="modal-content">
        <h3>Message</h3>
        <p id="fullMsg"></p>
        <button onclick="closeMsg()">Close</button>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Edit Enquiry</h3>

        <input type="hidden" id="editId">
        <input id="editName" placeholder="Name">
        <input id="editPhone" placeholder="Phone">
        <input id="editEmail" placeholder="Email">
        <input id="editCourse" placeholder="Course">
        <textarea id="editMessage" placeholder="Message"></textarea>

        <button onclick="saveEdit()">Save</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>

<script>

// LOAD DATA
function loadData(page = 1) {

    document.getElementById("loader").style.display = "block";

    let search = document.getElementById("search").value;
    let course = document.getElementById("courseFilter").value;

    let xhr = new XMLHttpRequest();
    xhr.open("GET", `../controllers/fetch-enquiry.php?search=${encodeURIComponent(search)}&course=${encodeURIComponent(course)}&page=${page}`, true);

    xhr.onload = function () {
        document.getElementById("tableData").innerHTML = this.responseText;
        document.getElementById("loader").style.display = "none";
    };

    xhr.send();
}

// DELETE
function deleteEnquiry(btn, id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Delete this enquiry?",
        icon: 'warning',
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {

            btn.disabled = true;

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "../controllers/delete_enquiry.php?id=" + id, true);

            xhr.onload = function () {
                loadData();
                Swal.fire('Deleted!', '', 'success');
            };

            xhr.send();
        }
    });
}

// STATUS
function updateStatus(btn, id) {
    btn.disabled = true;

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../controllers/update_status.php?id=" + id, true);

    xhr.onload = function () {
        loadData();
    };

    xhr.send();
}

// VIEW MESSAGE
function viewMessage(msg) {
    document.getElementById("msgModal").style.display = "block";
    document.getElementById("fullMsg").innerText = msg;
}

function closeMsg() {
    document.getElementById("msgModal").style.display = "none";
}

// ✅ FIXED EDIT FUNCTION (NOW WORKS)
function openEdit(id, name, phone, email, course, message) {

    document.getElementById("editModal").style.display = "block";

    document.getElementById("editId").value = id;
    document.getElementById("editName").value = name;
    document.getElementById("editPhone").value = phone;
    document.getElementById("editEmail").value = email;
    document.getElementById("editCourse").value = course;
    document.getElementById("editMessage").value = message;
}

// CLOSE EDIT
function closeModal() {
    document.getElementById("editModal").style.display = "none";
}

// SAVE EDIT
function saveEdit() {

    let id = document.getElementById("editId").value;

    let data = new URLSearchParams({
        id: id,
        name: document.getElementById("editName").value,
        phone: document.getElementById("editPhone").value,
        email: document.getElementById("editEmail").value,
        course: document.getElementById("editCourse").value,
        message: document.getElementById("editMessage").value
    });

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/update_enquiry.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        loadData();
        closeModal();
        Swal.fire('Updated!', '', 'success');
    };

    xhr.send(data.toString());
}

document.addEventListener("click", function(e){
    if(e.target.closest(".editBtn")){
        let btn = e.target.closest(".editBtn");

        openEdit(
            btn.dataset.id,
            btn.dataset.name,
            btn.dataset.phone,
            btn.dataset.email,
            btn.dataset.course,
            btn.dataset.message
        );
    }
});

// LOAD FIRST TIME
window.onload = loadData;

</script>

</body>

<?php include("../includes/footer.php"); ?>
</html>