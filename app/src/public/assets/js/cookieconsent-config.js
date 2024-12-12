import "https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.1/dist/cookieconsent.umd.js";

// Enable dark mode
document.documentElement.classList.add("cc--darkmode");

CookieConsent.run({
    guiOptions: {
        consentModal: {
            layout: "box",
            position: "bottom left",
            equalWeightButtons: true,
            flipButtons: false,
        },
        preferencesModal: {
            layout: "box",
            position: "right",
            equalWeightButtons: true,
            flipButtons: false,
        },
    },
    categories: {
        necessary: {
            readOnly: true,
        },
    },
    language: {
        default: "es",
        autoDetect: "browser",
        translations: {
            en: {
                consentModal: {
                    title: "Hello traveller, it's cookie time!",
                    description:
                        "We use cookies to enhance your browsing experience. By continuing to use our site, you consent to our use of cookies. For more details, please review our Cookie Policy.",
                    acceptAllBtn: "Accept all",
                    acceptNecessaryBtn: "Reject all",
                    showPreferencesBtn: "Manage preferences",
                    footer: '<a href="#link">Privacy Policy</a>\n<a href="#link">Terms and conditions</a>',
                },
                preferencesModal: {
                    title: "Consent Preferences Center",
                    acceptAllBtn: "Accept all",
                    acceptNecessaryBtn: "Reject all",
                    savePreferencesBtn: "Save preferences",
                    closeIconLabel: "Close modal",
                    serviceCounterLabel: "Service|Services",
                    sections: [
                        {
                            title: "Cookie Usage",
                            description:
                                "We use cookies to enhance your browsing experience. By continuing to use our site, you consent to our use of cookies. For more details, please review our Cookie Policy.",
                        },
                        {
                            title: 'Strictly Necessary Cookies <span class="pm__badge">Always Enabled</span>',
                            description:
                                "Strictly necessary cookies are essential for the basic functioning of the website and cannot be disabled in our systems. These cookies enable functions such as access to secure areas of the website, like user accounts, remembering essential settings such as privacy or language preferences, and ensuring the secure and proper operation of the site.",
                            linkedCategory: "necessary",
                        },
                        {
                            title: "More information",
                            description:
                                'For any query in relation to my policy on cookies and your choices, please <a class="cc__link" href="#yourdomain.com">contact me</a>.',
                        },
                    ],
                },
            },
            es: {
                consentModal: {
                    title: "Hola viajero, es la hora de las galletas!",
                    description:
                        "Utilizamos cookies para mejorar tu experiencia de navegación. Al continuar navegando en este sitio, aceptas el uso de cookies. Para más información, consulta nuestra Política de Cookies.",
                    acceptAllBtn: "Aceptar todo",
                    acceptNecessaryBtn: "Rechazar todo",
                    showPreferencesBtn: "Gestionar preferencias",
                    footer: '<a href="#link">Política de privacidad</a>\n<a href="#link">Términos y condiciones</a>',
                },
                preferencesModal: {
                    title: "Preferencias de Consentimiento",
                    acceptAllBtn: "Aceptar todo",
                    acceptNecessaryBtn: "Rechazar todo",
                    savePreferencesBtn: "Guardar preferencias",
                    closeIconLabel: "Cerrar modal",
                    serviceCounterLabel: "Servicios",
                    sections: [
                        {
                            title: "Uso de Cookies",
                            description:
                                "Utilizamos cookies para mejorar tu experiencia de navegación. Al continuar navegando en este sitio, aceptas el uso de cookies. Para más información, consulta nuestra Política de Cookies.",
                        },
                        {
                            title: 'Cookies Estrictamente Necesarias <span class="pm__badge">Siempre Habilitado</span>',
                            description:
                                "Las cookies estrictamente necesarias son esenciales para el funcionamiento básico del sitio web y no pueden ser desactivadas en nuestros sistemas. Estas cookies permiten funciones como acceso a áreas seguras del sitio web, como cuentas de usuario. Recordar configuraciones esenciales, como preferencias de privacidad o idioma y garantizar el funcionamiento seguro y correcto de la página.",
                            linkedCategory: "necessary",
                        },
                        {
                            title: "Más información",
                            description:
                                'For any query in relation to my policy on cookies and your choices, please <a class="cc__link" href="mailto:urbantree@iesmonsia.org" target="_blank">email us</a>.',
                        },
                    ],
                },
            },
        },
    },
});
