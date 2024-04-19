//CREATE DIALOG:
var gwprompt = new GWDialog();

//==============================================================================
async function ajaxPost(url, responsetype, data, callback_succes, callback_fail) {
    let response = await fetch(
        url,
        {
            method: 'POST',
            body: data
        }
    );
    if (response.ok) // if HTTP-status is 200-299
    {
        let result = '';
        switch (responsetype) {
            case 'json':
                result = await response.json();
                break;
            case 'xml':
                data = await response.text();
                const parser = new DOMParser();
                result = parser.parseFromString(data, "application/xml");
                break;
            default:
                result = await response.text();
        }
        callback_succes(result);
    }
    else {
        callback_fail(response.statusText);
    }
}


/* SOME DIALOG OPTIONS */
const ok_msg_options = (msg) => {
    return {
        title: 'Ok',
        ok_txt: 'Ok',
        body: '<div class="alert">' + msg + '</div>',
        cancel_func: 'NOP',
        width: 400
    };
};

const error_msg_options = (msg) => {
    return {
        title: 'Error',
        ok_txt: 'Ok',
        body: '<div class="alert alert-danger">' + msg + '</div>',
        cancel_func: 'NOP',
        width: 400
    };
};

const edit_name_options = (title, name) => {
    return {
        title: title,
        ok_txt: 'Geef een naam',
        ok_func: 'saveName',
        cancel_txt: 'Cancel',
        cancel_func: '',
        body: '<input type="text" class="gw-dialog-value form-control" name="newname" value="' + name + '"/>'
            + '<input type="hidden" class="gw-dialog-value form-control" name="name" value="' + name + '" />'
    };
};

const add_to_list_options = (recipe) => {
    return {
        title: 'Toegevoegd aan boodschappenlijst',
        cancel_func: 'NOP',
        body: '<div class="alert alert-succes">Ingrediënten voor ' + recipe + ' toegevoegd aan boodschappenlijst</div>',
    };
};


/* OK CALLBACK */
function saveName(data) {
    if (data.newname == null || data.newname == "") {
        console.log("User cancelled.");
        return;
    }
    formData = new FormData();
    for (const property in data) {
        formData.append(property, data[property]);
    }
    ajaxPost(
        'dialogs.php?ajax=1',
        'html',
        formData,
        function (response_data) {
            gwprompt.show(ok_msg_options(response_data));
        },

        function (error) {
            gwprompt.show(error_msg_options(error));

        }
    );
}

/* SHOW DIALOG */
function editName() {
    const name = 'Mag geen naam hebben';
    gwprompt.show(edit_name_options('Edit', name));
}

function addToList() {
    const recipe = 'Stamppot';
    gwprompt.show(add_to_list_options(recipe));
}


/* INIT */
const initPage = () => {
    console.log('initPage');
    document.getElementById('show-dlg').addEventListener('click', editName);
    document.getElementById('add-to-list').addEventListener('click', addToList);
}

(function (fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    }
    else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}(initPage));

