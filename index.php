<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="form.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
<div id="errorDiv"></div>
<div class="d-flex .flex-column container-md justify-content-center">
    <form action="c_submit.php" method="POST" class="p-4 border rounded bg-light">
        <div class="form-group d-flex">
            <div class="p-2">
            <label class="form-label font-weight-bold">* Email</label>
            <input type="text "  class="form-control" id="email" name="email"  required>
            </div>
            <div class="p-2">
            <label class="form-label font-weight-bold ">* Name</label>
            <input type="text "  class="form-control" id="name"  name="name"  required>
            </div>
        </div>
        <div>
    <label class="form-label font-weight-bold">* Content</label>
        <textarea class="form-control" id="content" name="content"  required> </textarea>
        </div>
    <button type="submit" class="btn btn-info mt-3">Submit</button>
    </form>
</div>

<div class="d-flex justify-content-center flex-column align-items-center">

        <div class="container mt-5" id="commentSection">
        <?php include_once("search.php");
        ?>
        </div>

</div>

</body>
</html>