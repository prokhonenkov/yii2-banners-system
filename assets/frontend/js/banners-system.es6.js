class BannerSystem {
    constructor(params) {
        this.banners = params.banners;
        this.url = params.url;
        this.insertBanners();
        this.setViel();
    }

    insertBanners() {
        const self = this;
        $.each(this.banners, function(key, value) {
            const banerPlace = $('.' + key);

            banerPlace.removeClass('hidden')
                .css('height', value.height)
                .css('width', value.width);

            if($.isArray(value.bannerOptions)) {
                $.each(value.bannerOptions, function(k, options) {
                    let htmlObject = $(self.htmlDecode(options.html)).attr('id', '' + options.id)
                        .css('cursor', options.redirectUrl ? 'pointer' : 'default');
                    self.setClick(htmlObject, options);
                    banerPlace.append(htmlObject);
                });
                self.removeViel(banerPlace);
            } else {
                banerPlace
                    .css('cursor', value.bannerOptions.redirectUrl ? 'pointer' : 'default')
                    .append(self.htmlDecode(value.bannerOptions.html));
                self.setClick(banerPlace, value.bannerOptions);
            }
        });
    }

    setClick(el, options) {
        const self = this;

        el.click(function(){
            let csrfParam = yii.getCsrfParam();
            let csrfToken = yii.getCsrfToken();
            let params = { id: options.id};
            params[csrfParam] = csrfToken;
            $.post( self.url, params);
            if(options.redirectUrl) {
                const win = window.open('', 'target="blank"');
                win.location.assign(options.redirectUrl);
                return false;
            }
        })
    }

    htmlDecode(html) {
        return html
            .replace(/&lt;/g, '<')
            .replace(/&gt;/g, '>');
    }

    setViel() {
        const self = this;
        $('.banner-system').each(function(index, object){
            if(!$(object).find('.with-veil').length) {
                self.removeViel(object);
            }
        });
    }

    removeViel(el) {
        $(el).find('.veil').remove();
    }
}