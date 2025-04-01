<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outfit Orbit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">


</head>
<body>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf


    <div class="nav">
        <a class="logo" href="#">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo">
        </a>

        <div class="icon_container">
            <div class="pin_container">
                <i class="bi bi-plus-circle-fill"></i>
            </div>

            <div class="pin_container">
                <i class="bi bi-bell-fill"></i>
            </div>

            <div class="pin_container">
                <i class="bi bi-chat-heart-fill"></i>
            </div>

            <div class="pin_container">
                <a class="account_icon" href="{{ URL::to('/profile') }}">
                  <i class="bi bi-person-fill"></i>
                </a>
              </div>

            <div class="pin_container">
                <a class="account_icon" href="{{ URL::to('/story') }}">
                    <i class="bi bi-clock-history"></i>
                </a>
              </div>

        </div>
    </div>
    <div class="pin_content">
        <!-- <div class="card">
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

        </div> -->
    </div>

      <div class="add_pin">
        <div class="add_pin_container">
            <div class="side" id="left_side">

                <div class="section1">
                    <div class="pin_icon">
                        <i class="bi bi-three-dots"></i>
                    </div>
                </div>

                <div class="section2">
                    <label for="upload" id="upload_img">
                        <div class="upload_img_container">
                            <div class="dotted_border">
                                <div class="pin_icon">
                                    <i class="bi bi-arrow-up-circle-fill"></i>
                                </div>
                                <div>Click Here To Upload</div>
                            </div>
                        </div>
                        <input type="file" name="upload" id="upload">
                    </label>

                    <div class="modal_pin">
                        <div class="pin_img">
                            <!-- <img src="" alt="pin_img"> -->
                        </div>
                    </div>
                </div>
                <div class="section3">
                    <div class="reco">Save From Site</div>
                </div>
            </div>

            <div class="side" id="right_side">
                <div class="section1">
                    <div class="select_size">
                        <select name="pin_size" id="pin_size">
                            <option value="" disabled selected>Select</option>
                            <option value="small">Small</option>
                            <option value="medium">Medium</option>
                            <option value="large">Large</option>
                        </select>
                        <div class="save_pin">Save</div>
                    </div>
                </div>

                <div class="section2">
                    <input placeholder= "Your Caption" type="text" class="new_pin" id="pin_caption">
                    <input placeholder="Description of the post..." type="text" class="new_pin" id="pin_description">
                    <input placeholder="Add a Link" type="text" class="new_pin" id="pin_links">
                </div>
            </div>

        </div>
    </div>

    {{-- <script src="main.js"></script> --}}
    <script src="{{ asset('js/main.js') }}"></script>


</body>
</html>
