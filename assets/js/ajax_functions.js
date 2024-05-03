/* FAVORITE */
function changeFavoriteStatus() {
    const heart = document.getElementById('favorite-heart');
    const url = heart.getAttribute('data-vrklk-fav-url');

    if (heart.classList.contains('fa-regular')) {
        heart.setAttribute('data-vrklk-fav-url', url.replace('add', 'remove'));
    } else {
        heart.setAttribute('data-vrklk-fav-url', url.replace('remove', 'add'));
    }

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (xmlhttp.responseText === '') {
                gwprompt.show(not_logged_favorite_options());
            } else {
                gwprompt.show(toggle_favorite_options(xmlhttp.responseText));
                heart.classList.toggle('fa-regular');
                heart.classList.toggle('fa-solid');
            }
        }
    };
    xmlhttp.open("GET", url);
    xmlhttp.send();
}

/* INIT */
const initAJAXPage = () => {
    console.log('initAJAXPage');
    document.getElementById('favorite-heart').addEventListener('click', changeFavoriteStatus);
}

(function (fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    }
    else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}(initAJAXPage));