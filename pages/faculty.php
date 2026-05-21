<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>
<?php include("floating-buttons.php"); ?>
<?php include("../config/db.php"); ?>

<link rel="stylesheet" href="../assets/css/faculty.css">

<section class="faculty-section">
    <h1 class="title">Our Expert Faculty</h1>
    <p class="subtitle">Meet our experienced and professional teachers</p>

    <div class="faculty-container">

        <?php
        $query = mysqli_query($conn, "SELECT * FROM faculty");

        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
        ?>

        <div class="faculty-card">
            
            <div class="faculty-img">
                <img src="../uploads/images<?php echo $row['photo']; ?>" alt="Faculty">
            </div>

            <div class="faculty-info">
                <h3><?php echo $row['designation']." ".$row['name']; ?></h3>

                <span class="badge-exp"><?php echo $row['experience']; ?></span>

                <p><strong>Qualification:</strong> <?php echo $row['qualification']; ?></p>

                <p><strong>Subjects:</strong> <?php echo $row['subjects']; ?></p>

                <p class="bio"><?php echo $row['bio']; ?></p>

                <p class="rating">⭐ <?php echo $row['rating']; ?>/5</p>

                <p><strong>Achievements:</strong> <?php echo $row['achievements']; ?></p>

                <a href="javascript:void(0)" 
                class="view-btn viewProfileBtn"
                data-name="<?php echo $row['designation']." ".$row['name']; ?>"
                data-qualification="<?php echo $row['qualification']; ?>"
                data-experience="<?php echo $row['experience']; ?>"
                data-subjects="<?php echo $row['subjects']; ?>"
                data-bio="<?php echo $row['bio']; ?>"
                data-photo="<?php echo $row['photo']; ?>"
                data-rating="<?php echo $row['rating']; ?>"
                data-achievements="<?php echo $row['achievements']; ?>">
                View Profile
                </a>

            </div>

        </div>

        <?php 
            }
        } else {
            echo "<h3 class='no-data'>No Faculty Available</h3>";
        }
        ?>

    </div>
</section>

<!-- MODAL -->
<div id="facultyModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>

        <img id="modalImg">
        <h2 id="modalName"></h2>

        <p id="modalQualification"></p>
        <p id="modalExperience"></p>
        <p id="modalSubjects"></p>
        <p id="modalRating"></p>
        <p id="modalAchievements"></p>
        <p id="modalBio"></p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){

    const modal = document.getElementById("facultyModal");
    const closeBtn = document.querySelector(".close");

    document.querySelectorAll(".viewProfileBtn").forEach(btn => {
        btn.addEventListener("click", function(){

            modal.style.display = "block";
            document.body.style.overflow = "hidden";

            document.getElementById("modalImg").src = "../uploads/" + this.dataset.photo;
            document.getElementById("modalName").innerText = this.dataset.name;
            document.getElementById("modalQualification").innerText = "Qualification: " + this.dataset.qualification;
            document.getElementById("modalExperience").innerText = "Experience: " + this.dataset.experience;
            document.getElementById("modalSubjects").innerText = "Subjects: " + this.dataset.subjects;
            document.getElementById("modalRating").innerText = "Rating: ⭐ " + (this.dataset.rating || "N/A");
            document.getElementById("modalAchievements").innerText = "Achievements: " + (this.dataset.achievements || "N/A");
            document.getElementById("modalBio").innerText = this.dataset.bio;
        });
    });

    closeBtn.onclick = function(){
        modal.style.display = "none";
        document.body.style.overflow = "auto";
    };

    window.onclick = function(e){
        if(e.target == modal){
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        }
    };

});
</script>

<?php include("../includes/footer.php"); ?>