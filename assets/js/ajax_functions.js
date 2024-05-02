
function changeFavoriteStatus() {
    const heart = document.getElementById('favorite-heart');
    const url = heart.getAttribute('data-vrklk-fav-url');
    var xmlhttp = new XMLHttpRequest();
    if (heart.classList.contains('fa-regular')) {
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('favorite-response').innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", url);
        xmlhttp.send();
        heart.classList.remove('fa-regular');
        heart.classList.add('fa-solid');
        heart.setAttribute('data-vrklk-fav-url', url.replace('add', 'remove'))
    } else {
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('favorite-response').innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", url);
        xmlhttp.send();
        heart.classList.remove('fa-solid');
        heart.classList.add('fa-regular');
        heart.setAttribute('data-vrklk-fav-url', url.replace('remove', 'add'))
    }
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