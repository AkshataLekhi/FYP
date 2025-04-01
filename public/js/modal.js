let pin_img_blob = null;

document.querySelector('#upload_img').addEventListener('change', event => {
    if (event.target.files && event.target.files[0]) {
        if (/image\/*/.test(event.target.files[0].type)) {
            const reader = new FileReader();

            reader.onload = function() {
                const new_image = new Image(); 

                new_image.src = reader.result;
                pin_image_blob = reader.result;

                new_image.onload = function() {
                    const modal_pin = document.querySelector('add_pin .modal_pin');

                    new_image.classList.add('pin_max_width');

                    document.querySelector('.add_pin .pin_img').appendChild(new_image);
                    document.querySelector('#upload_img').style.display = 'none';

                    modal_pin.style.display = 'block';

                    if (
                        new_image.getBoundingClientRect().width < new_image.parentElement.getBoundingClientRect().width || 
                        new_image.getBoundingClientRect().height < new_image.parentElement.getBoundingClientRect().height

                    ) {
                        new_image.classList.add('pin_max_height');
                        new_image.classList.remove('pin_max_width');

                    }

                    modal_pin.style.opacity = 1;

                } 
            }

            reader.readAsDataURL(event.target.files[0]);
        }
    }

    document.querySelector('#upload_img').value = '';
});

document.querySelector('.save_pin').addEventListener('click', () => {
    const users_data = {
        author:'Akshata',
        board: 'default',
        caption: document.querySelector('#pin_caption').value,
        description: document.querySelector('#pin_description').value,
        links: document.querySelector('#pin_links').value,
        img_blob: pin_img_blob,
        pin_size: document.querySelector('pin_size').value
    }
    
    console.log(users_data);
});
