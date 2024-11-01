<?php 
    include "includes/headers.php";
    require "includes/config/connect2db.php";
    $db = connect2db();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];

        $query = "INSERT INTO sellers(name, email, phone) VALUES ('$name', '$email', '$phone')";

        $response = mysqli_query($db, $query);
        if ($response){
           echo "Seller Created";
        } else {
           echo "Seller Not Created";
        }
    }
?>

<section>
    <h2>Sellers form</h2>
    <div>
        <form action="createSeller.php" method="post">
            <fieldset>
                <legend>Fill all form fields</legend>
                <div>
                    <label for="id">Seller Id</label>
                    <input type="number" id="id" name="id">
                </div>
                <div>
                    <label for="name">Seller Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="email">Seller Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="phone">Seller Phone</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div>
                    <button type="submit">Create a New Seller</button>
                </div>
                <div style="margin-top: 10px;">
                    <a href="createPropierties.php" style="color: #007bff; font-weight: bold; text-decoration: none;">Go to Create Properties Form</a>
                </div>
            </fieldset>
        </form>
    </div>
</section>

<?php 
    include "includes/footer.php";
?>