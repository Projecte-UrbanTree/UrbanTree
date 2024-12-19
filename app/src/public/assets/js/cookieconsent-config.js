import "https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.1/dist/cookieconsent.umd.js";

// Function to get seasonal emoji
// Usable in the footer of the consent modal
function getSeasonalEmoji() {
    const date = new Date();
    const month = date.getMonth() + 1;
    const day = date.getDate();

    // del deciembre al 6 de enero
    if (month === 12 || (month === 1 && day <= 6)) {
        return "🎄";
    } else if (month === 10 && day >= 31 && day <= 31) {
        return "🎃";
    } else if (month === 7 && day >= 1 && day <= 31) {
        return "🏖️";
    } else if (month === 4 && day >= 1 && day <= 30) {
        return "🌷";
    } else {
        return "🌲";
    }
}

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
                        "We use cookies to enhance your browsing experience. By continuing to use our site, you consent to our use of cookies. For more details, please review our <a href='/cookie-policy'>Cookie Policy</a>.",
                    acceptAllBtn: "Accept all",
                    acceptNecessaryBtn: "Reject all",
                    showPreferencesBtn: "Manage preferences",
                    footer: `${getSeasonalEmoji()} ${new Date().getFullYear()} Urban Tree 5.0`,
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
                                "We use cookies to enhance your browsing experience. By continuing to use our site, you consent to our use of cookies. For more details, please review our <a href='/cookie-policy'>Cookie Policy</a>.",
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
                        "Utilizamos cookies para mejorar tu experiencia de navegación. Al continuar navegando en este sitio, aceptas el uso de cookies. Para más información, consulta nuestra <a href='/cookie-policy'>Política de Cookies</a>.",
                    acceptAllBtn: "Aceptar todo",
                    acceptNecessaryBtn: "Rechazar todo",
                    showPreferencesBtn: "Gestionar preferencias",
                    footer: `${getSeasonalEmoji()} ${new Date().getFullYear()} Urban Tree 5.0`,
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
                                "Utilizamos cookies para mejorar tu experiencia de navegación. Al continuar navegando en este sitio, aceptas el uso de cookies. Para más información, consulta nuestra <a href='/cookie-policy'>Política de Cookies</a>.",
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
