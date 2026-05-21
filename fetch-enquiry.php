<?php
include("../config/db.php");

$search = $_GET['search'] ?? '';
$course = $_GET['course'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page <= 0){
    $page = 1;
}

$limit = 5;
$offset = ($page - 1) * $limit;

// ================= SAFE INPUT =================
$search = mysqli_real_escape_string($conn, $search);
$course = mysqli_real_escape_string($conn, $course);

// ================= TOTAL COUNT =================
$countSql = "SELECT COUNT(*) as total FROM enquiries WHERE 1";

if(!empty($search)){
    $countSql .= " AND (name LIKE '%$search%' 
                  OR phone LIKE '%$search%' 
                  OR email LIKE '%$search%')";
}

if(!empty($course)){
    $countSql .= " AND course='$course'";
}

$countResult = mysqli_query($conn, $countSql);
$totalData = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalData / $limit);

// ================= MAIN QUERY =================
$sql = "SELECT * FROM enquiries WHERE 1";

if(!empty($search)){
    $sql .= " AND (name LIKE '%$search%' 
              OR phone LIKE '%$search%' 
              OR email LIKE '%$search%')";
}

if(!empty($course)){
    $sql .= " AND course='$course'";
}

$sql .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $sql);

// ================= TABLE =================
echo "<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Course</th>
    <th>Batch</th>
    <th>Message</th>
    <th>Action</th>
</tr>";

while($row = mysqli_fetch_assoc($result)){

    $id = $row['id'];
    $name = htmlspecialchars($row['name'], ENT_QUOTES);
    $phone = htmlspecialchars($row['phone'], ENT_QUOTES);
    $email = htmlspecialchars($row['email'], ENT_QUOTES);
    $courseVal = htmlspecialchars($row['course'], ENT_QUOTES);
    $batch = htmlspecialchars($row['batch'], ENT_QUOTES);
    $message = htmlspecialchars($row['message'], ENT_QUOTES);

    echo "<tr>
        <td>$id</td>
        <td>$name</td>
        <td>$phone</td>
        <td>$email</td>
        <td>$courseVal</td>
        <td>$batch</td>

        <td>
            <button class='action-btn' onclick=\"viewMessage('$message')\">View</button>
        </td>

        <td>

            <!-- ✅ EDIT BUTTON (DATA ATTRIBUTES - BEST PRACTICE) -->
            <button class='action-btn btn-edit editBtn'
                data-id='$id'
                data-name='$name'
                data-phone='$phone'
                data-email='$email'
                data-course='$courseVal'
                data-message='$message'>
                <i class='fa fa-edit'></i>
            </button>

            <!-- DELETE -->
            <button class='action-btn btn-delete'
                onclick='deleteEnquiry(this, $id)'>
                <i class='fa fa-trash'></i>
            </button>

        </td>
    </tr>";
}

echo "</table>";

// ================= PAGINATION =================
echo "<div style='text-align:center; margin-top:20px;'>";

for($i = 1; $i <= $totalPages; $i++){

    $active = ($i == $page) ? "background:#0d6efd;color:#fff;" : "";

    echo "<button onclick='loadData($i)' 
            style='margin:5px; padding:6px 12px; border:none; cursor:pointer; $active'>
            $i
          </button>";
}

echo "</div>";
?>