document.addEventListener("DOMContentLoaded", function () {
    app.route({
        view: "home",
        load: "./pages/home.html",
        onReady: function () {
            loadScript("./assets/js/home.js");
        }
    });

    app.route({
        view: "offers",
        load: "offers.html"
    });

    app.route({
        view: "contact",
        load: "contact.html",
        onReady: function () {
            loadCSS("./assets/css/contact.css");
        }
    });

    app.route({
        view: "registration",
        load: "registration.html"
    });

    app.route({
        view: "rent",
        load: "rent.html",
        onReady: function () {
            loadCSS("./assets/css/rent.css");
        }
    });

    app.run();

    function loadScript(scriptUrl) {
        if (!document.querySelector(`script[src="${scriptUrl}"]`)) {
            let scriptTag = document.createElement("script");
            scriptTag.src = scriptUrl;
            scriptTag.defer = true;
            document.body.appendChild(scriptTag);
        }
    }

    function loadCSS(cssUrl) {
        if (!document.querySelector(`link[href="${cssUrl}"]`)) {
            let linkTag = document.createElement("link");
            linkTag.rel = "stylesheet";
            linkTag.href = cssUrl;
            document.head.appendChild(linkTag);
        }
    }
});
