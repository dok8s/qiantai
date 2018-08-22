function CookieManager() {
    var _self = this;

    _self.set = function (cname, cvalue, exdays, path) {
        exdays = exdays || 30;
        path = path || "/"

        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        var paths = "path=" + path;
        document.cookie = cname + "=" + cvalue + "; " + expires + "; " + paths;
    }

    _self.get = function (cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }

        return undefined;
    }
}