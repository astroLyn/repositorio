<?php 
include "includes/headers.php";
require "includes/config/connect2db.php";
$db = connect2db();

$query_sellers = "SELECT id, name FROM sellers";
$sellers = mysqli_query($db, $query_sellers);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $rooms = $_POST["rooms"];
    $wc = $_POST["wc"];
    $garage = $_POST["garage"];
    $timestamp = $_POST["timestamp"];
    $id_seller = $_POST["seller"];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $query = "INSERT INTO propiertes (title, price, image, description, rooms, wc, garage, timestamp, idSeller) 
                          VALUES ('$title', '$price', '$dest_path', '$description', '$rooms', '$wc', '$garage', '$timestamp', '$id_seller')";
                
                $response = mysqli_query($db, $query);
                if ($response){
                    echo "Property Created";
                }else{
                    echo "Property Not Created";
                }
            } else {
                echo "Error al mover el archivo de imagen.";
            }
        } else {
            echo "Tipo de archivo no permitido. Solo se permiten JPG, JPEG, PNG y GIF.";
        }
    } else {
        echo "No se subió ninguna imagen o hubo un error al subirla.";
    }
}
?>
    <section>
        <h2>Propierties Form</h2>
        <div>
            <form action="createPropierties.php" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Fill All Form Fields</legend>
                    <div>
                        <label for="id">Id</label>
                        <input type="number" name="id" id="id">
                    </div>
                    <div>
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" placeholder="Properity Title">
                    </div>
                    <div>
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price">
                    </div>
                    <div>
                        <label for="image">Image</label>
                        <input type="file" src="" name="image" id="image">
                    </div>
                    <div>
                        <label for="description">Description</label>
                        <input type="textarea" name="description" id="description">
                    </div>
                    <div>
                        <label for="rooms">Rooms</label>
                        <input type="number" name="rooms" id="rooms">
                    </div>
                    <div>
                        <label for="wc">WC</label>
                        <input type="number" name="wc" id="wc">
                    </div>
                    <div>
                        <label for="garage">Garage</label>
                        <input type="number" name="garage" id="garage">
                    </div>
                    <div>
                        <label for="timestamp">TimeStamp</label>
                        <input type="date" name="timestamp" id="timestamp">
                    </div>
                    <div>
                        <label for="seller">Seller</label>
                        <select name="seller" id="seller">
                            <?php while($seller = mysqli_fetch_assoc($sellers)): ?>
                                <option value="<?php echo $seller['id']; ?>"><?php echo $seller['name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit">Create a New Property</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </section>

<?php include "includes/footer.php"?>