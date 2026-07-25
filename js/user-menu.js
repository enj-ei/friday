document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.getElementById('userMenuTrigger');
    if (!trigger) return;

    const menu = trigger.closest('.user-menu');

    trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        menu.classList.toggle('open');
    });

    document.addEventListener('click', function (e) {
        if (!menu.contains(e.target)) {
            menu.classList.remove('open');
        }
    });
});
