const Loading = class {
    static createElement() {
        if (!Loading.element) {
            const jEl = $('<div>'),
                jIcon = $('<i>');

            jIcon.addClass('fas fa-circle-notch fa-spin');

            jEl.addClass('loading-icon').append(jIcon);
            jEl.hide();

            $('body').append(jEl);

            Loading.element = jEl;
        }
    }

    static destroyElement() {
        Loading.element.remove();

        Loading.element = null;
    }

    static show() {
        if (!Loading.element) {
            Loading.createElement();
        }

        Loading.element.fadeIn();
    }

    static hide() {
        if (Loading.element) {
            Loading.element.fadeOut({
                complete: () => Loading.destroyElement()
            });
        }
    }

    static success() {
        if (Loading.element) {
            Loading.element.addClass('success');

            Loading.element.find('> i').toggleClass('fa-circle-notch fa-check fa-spin');

            setTimeout(() => Loading.hide(), 1500);
        }
    }

    static error() {
        if (Loading.element) {
            Loading.element.addClass('error');

            Loading.element.find('> i').toggleClass('fa-circle-notch fa-exclamation fa-spin');

            Loading.element.on('click', () => {
                Loading.hide();
            });
        }
    }
};

Loading.element = null;