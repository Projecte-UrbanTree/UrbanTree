tailwind.config = {
    theme: {
        extend: {
            colors: {
                darkGreen: "#008037",
                lightGreen: "#7FD959",
                gray: "#919191",
                darkGray: "#444444",
                black: "#222222",
                hoverBlack: "#000000",
                activeBorder: "#222222",
                red: "#FF0000",
            },
            fontFamily: {
                sans: ["Poppins", "sans-serif"],
                // MontserratSans: ["Montserrat", "sans-serif"],
                condensed: ["Poppins Condensed", "sans-serif"],
            },
        },
    },
    plugins: [
        function ({ addComponents }) {
            addComponents({
                ".menu-link": {
                    "@apply font-bold text-lg text-gray hover:text-darkGray transition-colors relative":
                        {},
                    "&::after": {
                        "@apply absolute bottom-[-2px] left-0 w-0 h-[2px] bg-darkGray":
                            {},
                    },
                    "&:hover::after": {
                        "@apply w-full": {},
                    },
                    "&.active": {
                        "@apply text-darkGray": {},
                    },
                    "&.active::after": {
                        "@apply w-full bg-darkGray": {},
                    },
                },

                ".link-primary": {
                    "@apply text-sm tracking-tighter lg:tracking-widest font-medium text-gray font-sans hover:text-darkGray transition-colors relative":
                        {},
                    "&.active": {
                        "@apply text-darkGray font-bold": {},
                    },
                    "&::after": {
                        "@apply content-[''] absolute bottom-[-2px] left-0 w-0 h-[2px] bg-darkGray transition-all duration-300 ease-in-out":
                            {},
                    },
                    "&:hover::after": {
                        "@apply w-full": {},
                    },
                    "&.active::after": {
                        "@apply w-full bg-darkGray": {},
                    },
                },

                ".link-secondary": {
                    "@apply text-gray font-sans hover:text-darkGray transition-colors":
                        {},
                },
                ".submenu-item": {
                    "@apply py-2 flex flex-col md:items-center md:text-center":
                        {},
                },
                ".btn-create": {
                    "@apply text-darkGreen hover:text-white font-medium py-2 px-4 rounded-lg border-2 border-darkGreen hover:bg-darkGreen focus:outline-none focus:ring-2 focus:ring-darkGreen transition-colors":
                        {},
                },
                ".font-condensed": {
                    "@apply font-condensed": {},
                },
                ".box-shadow": {
                    "@apply rounded-lg shadow-lg bg-hoverGray p-4": {},
                },
                ".box-flat": {
                    "@apply border border-gray p-4": {},
                },
                ".box-active": {
                    "@apply border border-darkGreen bg-grayActive text-darkGreen p-4":
                        {},
                },
            });
        },
    ],
};
