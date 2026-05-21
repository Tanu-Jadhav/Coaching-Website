<?php include("../includes/header.php"); ?>
<link rel="stylesheet" href="../assets/css/refer.css">

<div class="refer-container">

    <!-- HEADER -->
    <div class="refer-header">
        <h2>Refer Your Friends & Earn Rewards</h2>
        <p>Earn ₹700 per successful admission</p>
    </div>

    <!-- FORM -->
        <form action="../controllers/save-refer.php" method="POST" id="referForm">

        <p class="info-text">
            Encourage your friends and earn rewards!
        </p>

        <!-- USER DETAILS -->
        <label>Your Full Name</label>
        <input type="text" name="name" placeholder="Enter your full name" required>

        <label>Your Mobile Number *</label>
            <input type="text" name="mobile" placeholder="Enter 10-digit mobile number" required pattern="[0-9]{10}" title="Enter valid 10-digit number">

        <label>Your Email Address *</label>
            <input type="email" name="email" placeholder="Enter Email Address" required>

        <hr>

        <!-- FRIEND DETAILS -->
        <h3>Your Friend's Details</h3>

        <div id="friends">

            <div class="friend-row">
                <input type="text" name="friend_name[]" placeholder="Friend's Name" required>
                <input type="text" name="friend_mobile[]" placeholder="Mobile Number" required>
                <button type="button" class="delete-btn" onclick="removeRow(this)">🗑</button>
                
            </div>

        </div>

        <button type="button" class="add-btn" onclick="addFriend()">+ Add Friend</button>

        <br><br>

        <button type="submit" class="submit-btn">Submit Referral</button>

    </form>

</div>

<script>
let maxFriends = 5;

function addFriend(){
    let container = document.getElementById("friends");

    if(container.children.length >= maxFriends){
        alert("You can add maximum 5 friends only");
        return;
    }

    let html = `
    <div class="friend-row">
        <input type="text" name="friend_name[]" placeholder="Friend's Name" required>
        <input type="text" name="friend_mobile[]" placeholder="Mobile Number" required pattern="[0-9]{10}" title="Enter 10 digit number">
        <button type="button" class="delete-btn" onclick="removeRow(this)">🗑</button>
    </div>`;

    container.insertAdjacentHTML("beforeend", html);
}

function removeRow(btn){
    btn.parentElement.remove();
}

/* ===== FORM VALIDATION ===== */
document.getElementById("referForm").addEventListener("submit", function(e){

    let mobile = document.querySelector("input[name='mobile']").value;
    let email = document.querySelector("input[name='email']").value;

    // Mobile validation
    if(!/^[0-9]{10}$/.test(mobile)){
        alert("Enter valid 10-digit mobile number");
        e.preventDefault();
        return;
    }

    // Email validation
    if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){
        alert("Enter valid email address");
        e.preventDefault();
        return;
    }

    // Friend validation
    let friendMobiles = document.querySelectorAll("input[name='friend_mobile[]']");
    
    for(let f of friendMobiles){
        if(!/^[0-9]{10}$/.test(f.value)){
            alert("Friend mobile must be 10 digits");
            e.preventDefault();
            return;
        }
    }

});
</script>

<?php include("../includes/footer.php"); ?>