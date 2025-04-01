const addPinModal = document.querySelector('.add_pin'); // Modal
const addPinButton = document.querySelector('.bi-plus-circle-fill'); // Plus icon

addPinButton.addEventListener('click', () => {
    addPinModal.style.opacity = 1;
    addPinModal.style.pointerEvents = 'all';
});

addPinModal.addEventListener('click', (event) => {
    if (event.target === addPinModal) {
        reset_modal();
    }
});

let pin_img_blob = null;

document.querySelector('#upload_img').addEventListener('change', event => {
    if (event.target.files && event.target.files[0]) {
        if (/image\/*/.test(event.target.files[0].type)) {
            const reader = new FileReader();

            reader.onload = function () {
                const new_image = new Image();
                new_image.src = reader.result;
                pin_img_blob = reader.result;

                new_image.onload = function () {
                    const modal_pin = document.querySelector('.add_pin .modal_pin');
                    const pinImgContainer = document.querySelector('.add_pin .pin_img');

                    if (pinImgContainer) {
                        pinImgContainer.innerHTML = ''; // Clear previous image
                        pinImgContainer.appendChild(new_image);
                        document.querySelector('#upload_img').style.display = 'none';
                    }

                    modal_pin.style.display = 'block';
                    modal_pin.style.opacity = 1;
                };
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    }

    document.querySelector('#upload').value = '';
});

document.querySelector('.save_pin').addEventListener('click', () => {
    const users_data = {
        author: 'Akshata',
        board: 'default',
        title: document.querySelector('#pin_caption').value,
        description: document.querySelector('#pin_description').value,
        links: document.querySelector('#pin_links').value,
        img_blob: pin_img_blob,
        pin_size: document.querySelector('#pin_size').value
    };

    console.log([users_data]);

    create_pin(users_data);
    reset_modal();
});


function create_pin(pin_details) {
    const new_pin = document.createElement('DIV');
    const new_image = new Image();

    new_image.src = pin_details.img_blob;
    new_pin.style.opacity = 0;

    new_image.onload = function() {
        new_pin.classList.add('card');
        new_pin.classList.add(`card_${pin_details.pin_size}`);
        new_image.classList.add('pin_max_width');

        new_pin.innerHTML = `
    <div class="pin_title">${pin_details.title} </div>
    <div class="pin_modal">
        <div class="modal_head">
            <div class="save_card">SAVE</div>
        </div>

        <div class="modal_foot">
            <div class="destination">
                <div class="pin_container">
                    <i class="bi bi-arrow-counterclockwise"></i>                
                </div>
                <sapn>${pin_details.links}</span>
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
    </div>`;

        document.querySelector('.pin_cont').appendChild(new_pin);
        new_pin.children[2].appendChild(new_image);

        if (
            new_image.getBoundingClientRect().width < new_image.parentElement.getBoundingClientRect().width || 
            new_image.getBoundingClientRect().height < new_image.parentElement.getBoundingClientRect().height

        ) {
            new_image.classList.add('pin_max_height');
            new_image.classList.remove('pin_max_width');

        }

        new_pin.style.opacity = 1;

    }
}


function reset_modal() {
    addPinModal.style.opacity = 0;
    addPinModal.style.pointerEvents = 'none';

    const modalPin = document.querySelector('.add_pin .modal_pin');

    if (modalPin && modalPin.querySelector('.pin_img img')) {
        modalPin.querySelector('.pin_img img').remove();
    }

    document.querySelector('#pin_caption').value = '';
    document.querySelector('#pin_description').value = '';
    document.querySelector('#pin_links').value = '';
    document.querySelector('#pin_size').value = '';
    pin_img_blob = null;
}
