CKEDITOR.plugins.add('darkmode', {
    // hidpi: false,   // CKEditor sucht nicht SVG zuerst
    icons: 'darkmode.png',

    init: function (editor) {
        editor.addCommand('toggleDark', {
            exec: function (editor) {
                var editable = editor.editable();

                // Liest Hintergrundfarbe
                var currentBG = editable.getComputedStyle('background-color');

                // Umschalter für Hintergrund und Schrift, erweiterbar für weitere CSS Klassen
                if (currentBG === 'rgb(34, 34, 34)') {
                    editable.setStyle('background-color', '#ffffff');
                    editable.setStyle('color', '#000000');
                } else {
                    editable.setStyle('background-color', '#222222');
                    editable.setStyle('color', '#eeeeee');
                }
            }
        });

        editor.ui.addButton('darkmode', {
            label: 'Darkmode Toggle',
            command: 'toggleDark',
            toolbar: 'tools',
            //icon: this.path + 'icons/darkmode.svg' // Korrekte relative URL, funktioniert nicht!.
            icon: this.path = 'https://cdn.jsdelivr.net/npm/feather-icons@4.29.2/dist/icons/moon.svg', // CDN Lösung
            // icon: this.path = 'https://mydomain.com/media/darkmode.png', // BESTE LÖSUNG, externe URL auf HTTP Server
        });

    }
});