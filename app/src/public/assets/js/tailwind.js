tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: "#008037",
                primaryDark: "#00652F",
                secondary: "#7FD959",
            },
            fontFamily: {
                sans: ["Poppins", "sans-serif"],
                condensed: ["Poppins Condensed", "sans-serif"],
            },
        },
    },
    plugins: [
        function ({ addComponents }) {
            addComponents({
            });
        },
    ],
};
