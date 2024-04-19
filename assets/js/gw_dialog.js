const GWDialogDefaultOptions = {
    title: '',
    body: '',
    ok_func: '',
    cancel_func: '',
    ok_txt: 'Ok',
    cancel_txt: 'Annuleer',
    width: 400,
    top: 100
    /* TO DO : implement icon */
};

class GWDialog {
    //==============================================================================
    constructor() {
        const _self = this;
        this.ok_func = '';
        this.cancel_func = '';
        this.dialogoverlay = document.getElementById('gw-dlg-overlay');
        this.dialogbox = document.getElementById('gw-dlg-box');
        this.dialogboxtitle = document.getElementById('gw-dlg-box-title');
        this.dialogboxbody = document.getElementById('gw-dlg-box-body');
        this.dialogboxok = document.getElementById('gw-dlg-btn-ok');
        this.dialogboxcancel = document.getElementById('gw-dlg-btn-cancel');
        this.dialogboxok.addEventListener("click", (e) => { _self.handleEvent(e); });
        this.dialogboxcancel.addEventListener("click", (e) => { _self.handleEvent(e); });
    }
    //==============================================================================
    show(options) {
        options = Object.assign(GWDialogDefaultOptions, options);
        let winW = window.innerWidth;
        let winH = window.innerHeight;
        let width = options.width ?? 480;
        this.dialogboxtitle.innerHTML = '<h4>' + options.title + '</h4>';
        this.ok_func = options.ok_func ? options.ok_func : '';
        this.cancel_func = options.cancel_func ? options.cancel_func : '';
        if (width > (winW - 20)) width = (winW - 20);
        this.dialogbox.style.width = width + "px";
        this.dialogoverlay.style.display = "block";
        this.dialogoverlay.style.height = winH + "px";
        this.dialogbox.style.left = (winW / 2) - (width * .5) + "px";
        this.dialogbox.style.top = (options.top ?? "100") + "px";
        this.dialogboxbody.innerHTML = options.body;
        this.dialogboxok.innerHTML = options.ok_txt;
        if (options.cancel_func === 'NOP') {
            this.dialogboxcancel.style.display = 'none';
            this.cancel_func = '';
        }
        else {
            this.dialogboxcancel.innerHTML = options.cancel_txt;
            this.dialogboxcancel.style.display = 'inline-block';
        }
        this.dialogbox.style.display = "block";
    }
    //==============================================================================   
    handleEvent(e) {
        switch (e.type) {
            case "click":
                if (e.target.id === 'gw-dlg-btn-ok') {
                    this._hide();
                    if (this.ok_func !== '') {
                        window[this.ok_func](this._getValues());
                    }
                    return;
                }
                if (e.target.id === 'gw-dlg-btn-cancel') {
                    this._hide();
                    if (this.cancel_func !== '') {
                        window[this.cancel_func](null);
                    }
                    return;
                }
        }
    }
    //==============================================================================
    _hide() {
        this.dialogoverlay.style.display = "none";
        this.dialogbox.style.display = "none";
    }
    //==============================================================================
    _getValues() {
        let result = new Object();
        Array.from(this.dialogboxbody.getElementsByClassName('gw-dialog-value')).forEach(
            item => result[item.name] = item.value
        );
        return result;
    }
}
//==============================================================================