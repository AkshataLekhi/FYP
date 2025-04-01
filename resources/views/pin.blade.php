<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outfit Orbit - Pin Page </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pin.css') }}">

</head>
<body>
    <input type="file" name="picture" id="picture">

    <div class="card">
        <div class="pin_title">

        </div>
       <div class="pin_modal">

        <div class="modal_head">
            <div class="save_card">SAVE</div>
        </div>

        <div class="modal_foot">
            <div class="destination">
                <div class="pin_container">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </div>
                <!-- <span>Eatery</span> -->
            </div>

            <div class="pin_container">
                <i class="bi bi-arrow-bar-up"></i>
            </div>

            <div class="pin_container">
                <i class="bi bi-pencil"></i>
            </div>
        </div>
       </div>

       <div class="pin_img">
        <img src="" alt="pin_img">
       </div>


    </div>
    <script src="pin.js"></script>
</body>
</html>
