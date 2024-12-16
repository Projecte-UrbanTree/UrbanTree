tailwind.config = {
    theme: {
        extend: {
            colors: {
                darkGreen: "#008037",
                lightGreen: "#7FD959",
                black: "#222222",
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
                    "@apply font-bold text-lg text-gray-500 hover:text-neutral-700 transition-colors relative":
                        {},
                    "&::after": {
                        "@apply absolute bottom-[-2px] left-0 w-0 h-[2px] bg-neutral-700":
                            {},
                    },
                    "&:hover::after": {
                        "@apply w-full": {},
                    },
                    "&.active": {
                        "@apply text-neutral-700": {},
                    },
                    "&.active::after": {
                        "@apply w-full bg-neutral-700": {},
                    },
                },

                ".link-primary": {
                    "@apply text-sm tracking-tighter lg:tracking-widest font-medium text-gray-500 font-sans hover:text-neutral-700 transition-colors relative":
                        {},
                    "&.active": {
                        "@apply text-neutral-700 font-bold": {},
                    },
                    "&::after": {
                        "@apply content-[''] absolute bottom-[-2px] left-0 w-0 h-[2px] bg-neutral-700 transition-all duration-300 ease-in-out":
                            {},
                    },
                    "&:hover::after": {
                        "@apply w-full": {},
                    },
                    "&.active::after": {
                        "@apply w-full bg-neutral-700": {},
                    },
                },

                ".link-secondary": {
                    "@apply text-gray-500 font-sans hover:text-neutral-700 transition-colors":
                        {},
                },
                ".submenu-item": {
                    "@apply py-2 flex flex-col items-center text-center gap-1":
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
                    "@apply rounded-lg shadow-lg p-4": {},
                },
                ".box-flat": {
                    "@apply border border-gray-500 p-4": {},
                },
                ".box-active": {
                    "@apply border border-darkGreen text-darkGreen p-4": {},
                },
            });
        },
    ],
};
