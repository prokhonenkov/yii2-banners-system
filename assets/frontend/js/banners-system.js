class BannerSystem {
    constructor(params) {
        this.banners = params.banners;
        this.insertBanners();
        this.setViel();
    }

    insertBanners() {
        const self = this;

        $.each(this.banners, function(key, value) {
            $('#' + key)
                .removeClass('hidden')
                .css('height', value.height)
                .css('width', value.width)
                .append(self.htmlDecode(value.html))
                .click(function(){
                    $.post( "/bannerssystem/banner/set-click", { id: value.id } );
                    if(!value.redirectUrl) {
                        return false;
                    }
                    const win = window.open('', 'target="blank"');
                    win.location.assign(value.redirectUrl);
                });

            if(value.redirectUrl) {
                $('#' + key).css('cursor', 'pointer');
            }
        });
    }

    htmlDecode(html) {
        return html
            .replace(/&lt;/g, '<')
            .replace(/&gt;/g, '>');
    }

    setViel() {
        $('.banner-system').each(function(index, object){
            if(!$(object).find('.with-veil').length) {
                $(object).find('.veil').remove();
            }
        });
    }
}