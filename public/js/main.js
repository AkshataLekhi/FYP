const addPinModal = document.querySelector('.add_pin');
const addPinButton = document.querySelector('.bi-plus-circle-fill');

addPinButton.addEventListener('click', () => {
    addPinModal.style.opacity = 1;
    addPinModal.style.pointerEvents = 'auto';
    addPinModal.style.display = 'flex';
});

addPinModal.addEventListener('click', (event) => {
    if (event.target === addPinModal) {
        reset_modal();
    }
});

let pin_img_blob = null;

document.querySelector('#upload').addEventListener('change', event => {
    if (event.target.files && event.target.files[0]) {
        if (/image\/*/.test(event.target.files[0].type)) {
            const reader = new FileReader();

            reader.onload = function () {
                pin_img_blob = reader.result;
                console.log("Image Blob Data:", pin_img_blob);

                const new_image = new Image();
                new_image.src = pin_img_blob;

                new_image.onload = function () {
                    const pinImgContainer = document.querySelector('.add_pin .pin_img');
                    if (pinImgContainer) {
                        pinImgContainer.innerHTML = '';
                        pinImgContainer.appendChild(new_image);
                        document.querySelector('#upload_img').style.display = 'none';
                    }
                };
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    }

    document.querySelector('#upload').value = ''; // Reset input field
});

document.querySelector('.save_pin').addEventListener('click', () => {
    if (!pin_img_blob) {
        alert("Please upload an image before saving!");
        console.error("Error: No image uploaded.");
        return;
    }

    const users_data = {
        author: 'Akshata',
        board: 'default',
        caption: document.querySelector('#pin_caption').value,
        description: document.querySelector('#pin_description').value,
        links: document.querySelector('#pin_links').value,
        img_blob: pin_img_blob,
        pin_size: document.querySelector('#pin_size').value
    };

    console.log("Users Data Before Saving:", users_data);
    create_pin(users_data);
    reset_modal();
});

function create_pin(pin_details) {
    console.log("Creating New Pin with Image:", pin_details.img_blob);

    const new_pin = document.createElement('div');
    const new_image = new Image();

    new_image.src = pin_details.img_blob;
    new_pin.style.opacity = 1;

    new_image.onload = function() {
        new_pin.classList.add('card');
        new_pin.classList.add(`card_${pin_details.pin_size}`);
        new_image.classList.add('pin_max_width');

        new_pin.innerHTML = `
            <div class="pin_title">${pin_details.caption}</div>
            <div class="pin_modal">
                <div class="modal_head">
                    <div class="save_card">SAVE</div>
                </div>
                <div class="modal_foot">
                    <div class="destination">
                        <div class="pin_container">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </div>
                        <span>${pin_details.links}</span>
                    </div>
                    <div class="pin_container">
                        <i class="bi bi-arrow-bar-up"></i>
                    </div>
                    <div class="pin_container">
                        <i class="bi bi-pencil"></i>
                    </div>
                </div>
            </div>
            <div class="pin_img"></div>
        `;

        const pinImgContainer = new_pin.querySelector('.pin_img');
        if (pinImgContainer) {
            pinImgContainer.appendChild(new_image);
            console.log("Image successfully added to pin.");
        } else {
            console.error("Error: .pin_img container not found in new pin.");
        }

        const pinContent = document.querySelector('.pin_content');
        if (pinContent) {
            pinContent.appendChild(new_pin);
            console.log("New pin added successfully.");
        } else {
            console.error("Error: .pin_content not found.");
        }

        new_pin.style.opacity = 1;
    };
}

function reset_modal() {
    addPinModal.style.opacity = 0;
    addPinModal.style.pointerEvents = 'none';

    // document.querySelector('#upload_img').style.display = 'block';
    // modal_pin.style.display = 'none';
    // modal_pin.style.opacity = 0;

    document.querySelector('#pin_caption').value = '';
    document.querySelector('#pin_description').value = '';
    document.querySelector('#pin_links').value = '';
    document.querySelector('#pin_size').value = '';
    pin_img_blob = null;
}
