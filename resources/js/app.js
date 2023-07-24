require('./bootstrap');

Array.from(document.getElementsByClassName('delete')).forEach(elm => elm.addEventListener('click', e => {
    e.preventDefault();

    if (!e.target.href) return;

    const form = document.createElement('form');
    form.method = 'post';
    form.action = e.target.href;

    const params = {
        '_method': 'DELETE',
        '_token': document.querySelector('meta[name="csrf-token"]').content,
    };

    for (const key in params) {
        if (!params.hasOwnProperty(key)) continue;

        const hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = key;
        hiddenField.value = params[key];

        form.appendChild(hiddenField);
    }

    document.body.append(form);
    form.submit();
}));
