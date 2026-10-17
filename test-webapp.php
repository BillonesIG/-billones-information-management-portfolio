<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "birthday_wishnote";

$conn = new mysqli($servername, $username, $password, $dbname);
$confirmation_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST["FirstName"] ?? "";
    $lastName = $_POST["LastName"] ?? "";
    $govPosition = $_POST["GovPosition"] ?? "";
    $location = $_POST["Location"] ?? "";

    // INTENTIONAL FLAW FOR THE ASSIGNMENT:
    // Location is captured, but omitted from the INSERT query and binding.
    $sql = "INSERT INTO main_corrupt_politicians (FirstName, LastName, GovPosition) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $firstName, $lastName, $govPosition);
        if ($stmt->execute()) {
            $confirmation_message = "Success! The wish note has been sent.";
        } else {
            $confirmation_message = "System Note: The entry could not be saved.";
        }
        $stmt->close();
    } else {
        $confirmation_message = "System Note: Could not prepare query. Ensure table 'main_corrupt_politicians' exists.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kara David's Wish Note</title>
<style>
:root{--blue:#007bff;--dark-blue:#0056b3;--light-blue:#e7f1ff;--bg:#f4f7f6}
*{box-sizing:border-box;font-family:Arial,Helvetica,sans-serif}
body{margin:0;padding:20px;background:var(--bg);color:#333;min-height:100vh;display:flex;align-items:center;justify-content:center}
.card{background:#fff;padding:30px 40px;border-radius:12px;box-shadow:0 4px 18px #00000018;width:100%;max-width:620px;border-top:7px solid var(--dark-blue)}
h2{text-align:center;color:var(--dark-blue);font-size:clamp(25px,5vw,38px);margin:10px 0 28px}
label{display:block;font-weight:700;color:#555;margin:18px 0 8px;font-size:18px}
input{width:100%;padding:13px;border:1px solid #ccc;border-radius:5px;font-size:16px}
input:focus{outline:2px solid #99caff;border-color:var(--blue)}
button{width:100%;border:0;border-radius:5px;padding:14px;font-size:17px;font-weight:bold;color:#fff;background:var(--blue);cursor:pointer;margin-top:18px}
button:hover{background:var(--dark-blue)}
.success{background:#d4edda;color:#155724;border:1px solid #c3e6cb;padding:15px;border-radius:5px;text-align:center;font-weight:bold;margin-bottom:20px}
.overlay{display:none;position:fixed;inset:0;background:#0008;align-items:center;justify-content:center;padding:20px;z-index:5}
.modal{background:white;padding:28px;border-radius:10px;width:100%;max-width:500px;box-shadow:0 5px 25px #0003}
.modal h3{color:var(--dark-blue);margin-top:0}
.details{background:var(--light-blue);padding:15px;border-radius:5px;overflow-wrap:anywhere}
.details p{margin:10px 0}
.cancel{background:#6c757d}.cancel:hover{background:#545b62}
@media(max-width:480px){.card{padding:25px 20px}.modal{padding:22px}}
</style>
</head>
<body>
<main class="card">
<h2>Kara David's Wish Note</h2>
<?php if ($confirmation_message !== ""): ?>
<div class="success"><?= htmlspecialchars($confirmation_message, ENT_QUOTES, "UTF-8") ?></div>
<?php endif; ?>
<form id="wishForm" method="post">
<label for="FirstName">Target's First Name *</label>
<input id="FirstName" name="FirstName" maxlength="30" required>
<label for="LastName">Target's Last Name *</label>
<input id="LastName" name="LastName" maxlength="30" required>
<label for="GovPosition">Target's Government Position *</label>
<input id="GovPosition" name="GovPosition" maxlength="20" required>
<label for="Location">Target's Location</label>
<input id="Location" name="Location" maxlength="40">
<button type="submit">Send Wish Note</button>
</form>
</main>
<div class="overlay" id="overlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
<div class="modal">
<h3 id="modalTitle">Verify Target Data</h3>
<p>Please review the details below before sending:</p>
<div class="details">
<p>First Name: <strong id="showFirst"></strong></p>
<p>Last Name: <strong id="showLast"></strong></p>
<p>Position: <strong id="showPosition"></strong></p>
<p>Location: <strong id="showLocation"></strong></p>
</div>
<button type="button" class="cancel" id="cancelBtn">Cancel</button>
<button type="button" id="confirmBtn">Confirm &amp; Send</button>
</div>
</div>
<script>
const form = document.getElementById("wishForm");
const overlay = document.getElementById("overlay");
const fields = ["FirstName","LastName","GovPosition","Location"];
form.addEventListener("submit", function(e) {
  e.preventDefault();
  if (!form.reportValidity()) return;
  document.getElementById("showFirst").textContent = form.FirstName.value;
  document.getElementById("showLast").textContent = form.LastName.value;
  document.getElementById("showPosition").textContent = form.GovPosition.value;
  document.getElementById("showLocation").textContent = form.Location.value || "(not provided)";
  overlay.style.display = "flex";
});
document.getElementById("cancelBtn").addEventListener("click", () => overlay.style.display = "none");
document.getElementById("confirmBtn").addEventListener("click", () => form.submit());
</script>
</body>
</html>
