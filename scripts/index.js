const form = document.querySelector('#contact-form');
const formTitle = document.querySelector('#title');
const body = document.querySelector('body');

form.onsubmit = e => {
    e.preventDefault();

    const formData = Object.fromEntries(new FormData(e.currentTarget));
    const errors = document.querySelectorAll('.form__error');
    const success = document.querySelector('.form__success');

    body.classList.add('loading');

    if(success) success.remove();
    errors.forEach((item) => item.remove());
    
    fetch('libraries/sendEmail.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json'},
        body: JSON.stringify(formData)
    }).then(req => req.json())
    .then(res => {
        body.classList.remove('loading');

        if(res.status == 'ok') {
            formTitle
                .insertAdjacentHTML('afterend', `<span class="form__success">${res.ok.message}</span>`);

            form.reset();
        } else {
            for (const key in res.error) {
                const target = document.querySelector(`[name=${key}]`).closest('.form__field');

                target
                    .insertAdjacentHTML('afterend', `<span class="form__error">${res.error[key]}</span>`);
            }
        }
    })
    .catch((error) => {
        body.classList.remove('loading');
        console.error(error)
    })
}
