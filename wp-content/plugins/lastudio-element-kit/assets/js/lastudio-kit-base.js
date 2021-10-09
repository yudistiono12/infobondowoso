( function( $, elementor ) {

    "use strict";

    var LaStudioKits = {
        addedScripts: {},
        addedStyles: {},
        addedAssetsPromises: [],
        addQueryArg: function (url, key, value) {
            var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
            var separator = url.indexOf('?') !== -1 ? "&" : "?";

            if (url.match(re)) {
                return url.replace(re, '$1' + key + "=" + value + '$2');
            } else {
                return url + separator + key + "=" + value;
            }
        },
        getUrlParameter: function (name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        },
        parseQueryString: function (query) {
            var urlparts = query.split("?");
            var query_string = {};

            if (urlparts.length >= 2) {
                var vars = urlparts[1].split("&");

                for (var i = 0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    var key = decodeURIComponent(pair[0]);
                    var value = decodeURIComponent(pair[1]); // If first entry with this name

                    if (typeof query_string[key] === "undefined") {
                        query_string[key] = decodeURIComponent(value); // If second entry with this name
                    } else if (typeof query_string[key] === "string") {
                        var arr = [query_string[key], decodeURIComponent(value)];
                        query_string[key] = arr; // If third or later entry with this name
                    } else {
                        query_string[key].push(decodeURIComponent(value));
                    }
                }
            }

            return query_string;
        },
        removeURLParameter: function (url, parameter) {
            var urlparts = url.split('?');

            if (urlparts.length >= 2) {
                var prefix = encodeURIComponent(parameter) + '=';
                var pars = urlparts[1].split(/[&;]/g); //reverse iteration as may be destructive

                for (var i = pars.length; i-- > 0;) {
                    //idiom for string.startsWith
                    if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                        pars.splice(i, 1);
                    }
                }

                url = urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
                return url;
            } else {
                return url;
            }
        },
        initCarousel: function ( $scope ){

            var $carousel = $scope.find('.lakit-carousel').first();

            if($carousel.length == 0){
                return;
            }

            var elementSettings = $carousel.data('slider_options'),
                slidesToShow = elementSettings.slidesToShow.desktop || 1,
                elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints;

            var swiperOptions = {
                slidesPerView: slidesToShow,
                loop: elementSettings.infinite,
                speed: elementSettings.speed,
                handleElementorBreakpoints: false,
                slidesPerColumn: elementSettings.rows.desktop,
                slidesPerGroup: elementSettings.slidesToScroll.desktop || 1
            }

            var _breakpointsObj = {};
            _breakpointsObj[0] = {
                slidesPerView: elementSettings.slidesToShow.mobile || 1,
                slidesPerColumn: elementSettings.rows.mobile || 1,
                slidesPerGroup: elementSettings.slidesToScroll.mobile || 1,
            };
            if(typeof elementorBreakpoints.mobile_extra !== "undefined"){
                _breakpointsObj[elementorBreakpoints.mobile.value] = {
                    slidesPerView: elementSettings.slidesToShow.mobile_extra || 1,
                    slidesPerColumn: elementSettings.rows.mobile_extra || 1,
                    slidesPerGroup: elementSettings.slidesToScroll.mobile_extra || 1,
                };
                _breakpointsObj[elementorBreakpoints.mobile_extra.value] = {
                    slidesPerView: elementSettings.slidesToShow.tablet || 1,
                    slidesPerColumn: elementSettings.rows.tablet || 1,
                    slidesPerGroup: elementSettings.slidesToScroll.tablet || 1,
                };
            }
            if(typeof elementorBreakpoints.tabletportrait !== "undefined"){
                _breakpointsObj[elementorBreakpoints.mobile.value] = {
                    slidesPerView: elementSettings.slidesToShow.tabletportrait || 1,
                    slidesPerColumn: elementSettings.rows.tabletportrait || 1,
                    slidesPerGroup: elementSettings.slidesToScroll.tabletportrait || 1,
                };
                _breakpointsObj[elementorBreakpoints.tabletportrait.value] = {
                    slidesPerView: elementSettings.slidesToShow.tablet || 1,
                    slidesPerColumn: elementSettings.rows.tablet || 1,
                    slidesPerGroup: elementSettings.slidesToScroll.tablet || 1,
                };
            }

            if(typeof elementorBreakpoints.tabletportrait === "undefined" && typeof elementorBreakpoints.mobile_extra === "undefined" ){
                _breakpointsObj[elementorBreakpoints.mobile.value] = {
                    slidesPerView: elementSettings.slidesToShow.tablet || 1,
                    slidesPerColumn: elementSettings.rows.tablet || 1,
                    slidesPerGroup: elementSettings.slidesToScroll.tablet || 1,
                };
            }

            if(typeof elementorBreakpoints.laptop !== "undefined"){
                _breakpointsObj[elementorBreakpoints.tablet.value] = {
                    slidesPerView: elementSettings.slidesToShow.laptop || 1,
                    slidesPerColumn: elementSettings.rows.laptop || 1,
                    slidesPerGroup: elementSettings.slidesToScroll.laptop || 1,
                };
                _breakpointsObj[elementorBreakpoints.laptop.value] = {
                    slidesPerView: elementSettings.slidesToShow.desktop || 1,
                    slidesPerColumn: elementSettings.rows.desktop || 1,
                    slidesPerGroup: elementSettings.slidesToScroll.desktop || 1,
                };
            }
            else{
                _breakpointsObj[elementorBreakpoints.tablet.value+1] = {
                    slidesPerView: elementSettings.slidesToShow.desktop || 1,
                    slidesPerColumn: elementSettings.rows.desktop || 1,
                    slidesPerGroup: elementSettings.slidesToScroll.desktop || 1,
                };
            }


            swiperOptions.breakpoints = _breakpointsObj;

            if(elementSettings.autoplay){
                swiperOptions.autoplay = {
                    delay: elementSettings.autoplaySpeed,
                    disableOnInteraction: elementSettings.pauseOnInteraction,
                    pauseOnMouseEnter: elementSettings.pauseOnHover
                };
            }
            if(elementSettings.centerMode){
                swiperOptions.centerInsufficientSlides = true;
                swiperOptions.centeredSlides = false;
                swiperOptions.centeredSlidesBounds = false;
            }

            switch (elementSettings.effect) {
                case 'fade':
                    if(slidesToShow == 1){
                        swiperOptions.effect = elementSettings.effect;
                        swiperOptions.fadeEffect = {
                            crossFade: true
                        };
                    }
                    break;

                case 'coverflow':
                    swiperOptions.effect = 'coverflow';
                    swiperOptions.grabCursor = true;
                    swiperOptions.centeredSlides = true;
                    swiperOptions.slidesPerView = 'auto';
                    swiperOptions.coverflowEffect = {
                        rotate: 50,
                        stretch: 0,
                        depth: 100,
                        modifier: 1,
                        slideShadows: true
                    };
                    break;

                case 'cube':
                    swiperOptions.effect = 'cube';
                    swiperOptions.grabCursor = true;
                    swiperOptions.cubeEffect = {
                        shadow: true,
                        slideShadows: true,
                        shadowOffset: 20,
                        shadowScale: 0.94,
                    }
                    swiperOptions.slidesPerView = 1;
                    swiperOptions.slidesPerGroup = 1;
                    break;

                case 'flip':
                    swiperOptions.effect = 'flip';
                    swiperOptions.grabCursor = true;
                    swiperOptions.slidesPerView = 1;
                    swiperOptions.slidesPerGroup = 1;
                    break;

                case 'slide':
                    swiperOptions.effect = 'slide';
                    swiperOptions.grabCursor = true;
                    break;
            }

            if(elementSettings.arrows){
                swiperOptions.navigation = {
                    prevEl: elementSettings.prevArrow,
                    nextEl: elementSettings.nextArrow
                };
            }
            if(elementSettings.dots){
                swiperOptions.pagination = {
                    el: '.lakit-carousel__dots',
                    type: swiperOptions.dotType || 'bullets',
                    clickable: true
                };
                if(elementSettings.dotType == 'bullets'){
                    swiperOptions.pagination.dynamicBullets = true;
                }
                if(elementSettings.dotType == 'custom'){
                    swiperOptions.pagination.renderBullet = function (index, className) {
                        return '<span class="' + className + '">' + (index + 1) + "</span>";
                    }
                }
            }

            var enableScrollbar = elementSettings.scrollbar || false;

            if(!enableScrollbar){
                swiperOptions.scrollbar = false;
            }
            else{
                swiperOptions.scrollbar = {
                    el: '.lakit-carousel__scrollbar',
                    draggable: true
                }
            }

            var Swiper = elementorFrontend.utils.swiper;
            new Swiper( $scope.find('.swiper-container'), swiperOptions);
        },
        initMasonry: function ( $scope ){
            var $container = $scope.find('.lakit-masonry-wrapper').first();

            if($container.length == 0){
                return;
            }

            var $list_wrap = $scope.find($container.data('masonrywrap')),
                itemSelector = $container.data('item_selector'),
                $itemsList = $scope.find(itemSelector),
                $masonryInstance;

            if($list_wrap.length){

                $masonryInstance = $list_wrap.masonry({
                    itemSelector: itemSelector,
                    percentPosition: true,
                })

                $('img', $itemsList).imagesLoaded().progress( function( instance, image ) {
                    var $image      = $( image.img ),
                        $parentItem = $image.closest( itemSelector );
                    $parentItem.addClass( 'item-loaded' );
                    if($masonryInstance){
                        $masonryInstance.masonry( 'layout' );
                    }
                } );
            }
        },
        ajaxLoadPost: function (){
            $(document).on('click', '.lakit-ajax-pagination .lakit-pagination_ajax_loadmore a', function (e){
                e.preventDefault();
                if ($('body').hasClass('elementor-editor-active')) {
                    return false;
                }

                var $pagination, url_request, _parent_container, _container, _item_selector, _infinite_flag, _use_restapi;

                $pagination = $(this).closest('.lakit-ajax-pagination');
                _parent_container = $pagination.data('parent-container');
                _container = $pagination.data('container');
                _item_selector = $pagination.data('item-selector');
                _infinite_flag = false;
                _use_restapi = false;

                if ($pagination.hasClass('with-wp-ajax')) {
                    _use_restapi = false;
                }

                if ($pagination.data('infinite-flag')) {
                    _infinite_flag = $pagination.data('infinite-flag');
                }

                if ($('a.next', $pagination).length) {
                    if ($pagination.hasClass('doing-ajax')) {
                        return false;
                    }
                    $pagination.addClass('doing-ajax');
                    $(_parent_container).addClass('doing-ajax');

                    var success_func = function (response) {
                        var $data = $(response).find(_container + ' ' + _item_selector);

                        if ($(_parent_container).find('.lakit-carousel').length > 0) {
                            var swiper = $(_parent_container).find('.lakit-carousel').get(0).swiper;
                            swiper.appendSlide($data);
                        }
                        else if ($(_container).data('masonry')) {
                            $(_container).append($data);
                            $(_container).masonry('addItems', $data);
                            $('img', $data).imagesLoaded().progress( function( instance, image ) {
                                var $image      = $( image.img ),
                                    $parentItem = $image.closest( _item_selector );
                                $parentItem.addClass( 'item-loaded' );
                                $(_container).masonry( 'layout' );
                            } );

                            $(document).trigger('lastudio-kit/posts/ajax_loadmore_event', [$(_container)]);
                        }
                        else {
                            $data.addClass('fadeIn animated').appendTo($(_container));
                        }

                        $(_parent_container).removeClass('doing-ajax');
                        $pagination.removeClass('doing-ajax lakit-ajax-load-first');

                        if ($(response).find(_parent_container + ' .lakit-ajax-pagination').length) {
                            var $new_pagination = $(response).find(_parent_container + ' .lakit-ajax-pagination');
                            $pagination.replaceWith($new_pagination);
                            $pagination = $new_pagination;
                        }
                        else {
                            $pagination.addClass('nothingtoshow');
                        }

                        if (_infinite_flag !== false) {
                            $(document).trigger('lastudio-kit/posts/infinite_event', [$pagination]);
                        }
                    };

                    url_request = $('a.next', $pagination).attr('href').replace(/^\//, '');
                    url_request = LaStudioKits.removeURLParameter(url_request, '_');
                    var ajaxOpts = {
                        url: url_request,
                        type: "get",
                        cache: true,
                        dataType: 'html',
                        success: function (res) {
                            success_func(res);
                        }
                    };
                    $.ajax(ajaxOpts);

                }

            });
        },
        isEditMode: function (){
            return Boolean( elementorFrontend.isEditMode() );
        },
        mobileAndTabletCheck: function() {
            var check = false;

            (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);

            return check;
        },
        onSearchSectionActivated: function( $scope ) {
            if ( ! elementor ) {
                return;
            }
            if ( ! window.LaStudioKitEditor ) {
                return;
            }
            if ( ! window.LaStudioKitEditor.activeSection ) {
                return;
            }
            var section = window.LaStudioKitEditor.activeSection;
            var isPopup = -1 !== [ 'section_popup_style', 'section_popup_close_style', 'section_form_style' ].indexOf( section );
            if ( isPopup ) {
                $scope.find( '.lakit-search' ).addClass( 'lakit-search-popup-active' );
            }
            else {
                $scope.find( '.lakit-search' ).removeClass( 'lakit-search-popup-active' );
            }
        },
        loadStyle: function( style, uri ) {

            if ( LaStudioKits.addedStyles.hasOwnProperty( style ) && LaStudioKits.addedStyles[ style ] ===  uri) {
                return style;
            }

            if ( !uri ) {
                return;
            }

            LaStudioKits.addedStyles[ style ] = uri;

            return new Promise( function( resolve, reject ) {
                var tag = document.createElement( 'link' );

                tag.id      = style;
                tag.rel     = 'stylesheet';
                tag.href    = uri;
                tag.type    = 'text/css';
                tag.media   = 'all';
                tag.onload  = function() {
                    resolve( style );
                };

                document.head.appendChild( tag );
            });
        },
        loadScriptAsync: function( script, uri ) {

            if ( LaStudioKits.addedScripts.hasOwnProperty( script ) ) {
                return script;
            }

            if ( !uri ) {
                return;
            }

            LaStudioKits.addedScripts[ script ] = uri;

            return new Promise( function( resolve, reject ) {
                var tag = document.createElement( 'script' );

                tag.src    = uri;
                tag.async  = true;
                tag.onload = function() {
                    resolve( script );
                };

                document.head.appendChild( tag );
            });
        },
        elementorFrontendInit: function( $container ) {

            $container.find( '[data-element_type]' ).each( function() {
                var $this       = $( this ),
                    elementType = $this.data( 'element_type' );

                if ( ! elementType ) {
                    return;
                }

                try {
                    if ( 'widget' === elementType ) {
                        elementType = $this.data( 'widget_type' );
                        window.elementorFrontend.hooks.doAction( 'frontend/element_ready/widget', $this, $ );
                    }

                    window.elementorFrontend.hooks.doAction( 'frontend/element_ready/global', $this, $ );
                    window.elementorFrontend.hooks.doAction( 'frontend/element_ready/' + elementType, $this, $ );

                } catch ( err ) {
                    console.log(err);

                    $this.remove();

                    return false;
                }
            } );

        },
        initAnimationsHandlers: function( $selector ) {
            $selector.find( '[data-element_type]' ).each( function() {
                var $this       = $( this ),
                    elementType = $this.data( 'element_type' );

                if ( !elementType ) {
                    return;
                }

                window.elementorFrontend.hooks.doAction( 'frontend/element_ready/global', $this, $ );
            } );
        },
        hamburgerPanel: function ($scope){
            var $panel        = $( '.lakit-hamburger-panel', $scope ),
                $toggleButton = $( '.lakit-hamburger-panel__toggle', $scope ),
                $instance     = $( '.lakit-hamburger-panel__instance', $scope ),
                $cover        = $( '.lakit-hamburger-panel__cover', $scope ),
                $inner        = $( '.lakit-hamburger-panel__inner', $scope ),
                $closeButton  = $( '.lakit-hamburger-panel__close-button', $scope ),
                $panelContent = $( '.lakit-hamburger-panel__content', $scope),
                scrollOffset,
                timer,
                editMode      = Boolean( elementorFrontend.isEditMode() ),
                $html         = $( 'html' ),
                settings      = $panel.data( 'settings' ) || {};

            if ( 'ontouchend' in window || 'ontouchstart' in window ) {
                $toggleButton.on( 'touchstart', function( event ) {
                    scrollOffset = $( window ).scrollTop();
                } );

                $toggleButton.on( 'touchend', function( event ) {
                    if ( scrollOffset !== $( window ).scrollTop() ) {
                        return false;
                    }

                    if ( timer ) {
                        clearTimeout( timer );
                    }

                    if ( ! $panel.hasClass( 'open-state' ) ) {
                        timer = setTimeout( function() {
                            $panel.addClass( 'open-state' );
                        }, 10 );
                        $html.addClass( 'lakit-hamburger-panel-visible' );
                        LaStudioKits.initAnimationsHandlers( $inner );

                        if ( settings['ajaxTemplate'] ) {
                            ajaxLoadTemplate( $panelContent );
                        }
                    } else {
                        $panel.removeClass( 'open-state' );
                        $html.removeClass( 'lakit-hamburger-panel-visible' );
                    }
                } );

            } else {
                $toggleButton.on( 'click', function( event ) {

                    if ( ! $panel.hasClass( 'open-state' ) ) {
                        $panel.addClass( 'open-state' );
                        $html.addClass( 'lakit-hamburger-panel-visible' );
                        LaStudioKits.initAnimationsHandlers( $inner );

                        if ( settings['ajaxTemplate'] ) {
                            ajaxLoadTemplate( $panelContent );
                        }
                    } else {
                        $panel.removeClass( 'open-state' );
                        $html.removeClass( 'lakit-hamburger-panel-visible' );
                    }
                } );
            }

            $closeButton.on( 'click', function( event ) {

                if ( ! $panel.hasClass( 'open-state' ) ) {
                    $panel.addClass( 'open-state' );
                    $html.addClass( 'lakit-hamburger-panel-visible' );
                    LaStudioKits.initAnimationsHandlers( $inner );
                } else {
                    $panel.removeClass( 'open-state' );
                    $html.removeClass( 'lakit-hamburger-panel-visible' );
                }
            } );

            $( document ).on( 'click.lakitHamburgerPanel', function( event ) {
                if ( ( $( event.target ).closest( $toggleButton ).length || $( event.target ).closest( $instance ).length )
                    && ! $( event.target ).closest( $cover ).length
                ) {
                    return;
                }

                if ( ! $panel.hasClass( 'open-state' ) ) {
                    return;
                }

                $panel.removeClass( 'open-state' );

                if ( ! $( event.target ).closest( '.lakit-hamburger-panel__toggle' ).length ) {
                    $html.removeClass( 'lakit-hamburger-panel-visible' );
                }

                event.stopPropagation();
            } );



            /**
             * [ajaxLoadTemplate description]
             * @param  {[type]} $index [description]
             * @return {[type]}        [description]
             */
            function ajaxLoadTemplate( $panelContent ) {
                var $contentHolder = $panelContent,
                    templateLoaded = $contentHolder.data( 'template-loaded' ) || false,
                    templateId     = $contentHolder.data( 'template-id' ),
                    loader         = $( '.lakit-hamburger-panel-loader', $contentHolder );

                if ( templateLoaded ) {
                    return false;
                }

                $( window ).trigger( 'lastudio-kit/ajax-load-template/before', {
                    target: $panel,
                    contentHolder: $contentHolder
                } );

                $contentHolder.data( 'template-loaded', true );

                $.ajax( {
                    type: 'GET',
                    url: window.LaStudioKitSettings.templateApiUrl,
                    dataType: 'json',
                    data: {
                        'id': templateId,
                        'dev': window.LaStudioKitSettings.devMode
                    },
                    success: function( responce, textStatus, jqXHR ) {
                        var templateContent     = responce['template_content'],
                            templateScripts     = responce['template_scripts'],
                            templateStyles      = responce['template_styles'];

                        for ( var scriptHandler in templateScripts ) {
                            LaStudioKits.addedAssetsPromises.push( LaStudioKits.loadScriptAsync( scriptHandler, templateScripts[ scriptHandler ] ) );
                        }

                        for ( var styleHandler in templateStyles ) {
                            LaStudioKits.addedAssetsPromises.push( LaStudioKits.loadStyle( styleHandler, templateStyles[ styleHandler ] ) );
                        }

                        Promise.all( LaStudioKits.addedAssetsPromises ).then( function( value ) {
                            loader.remove();
                            $contentHolder.append( templateContent );
                            LaStudioKits.elementorFrontendInit( $contentHolder );

                            $( window ).trigger( 'lastudio-kit/ajax-load-template/after', {
                                target: $panel,
                                contentHolder: $contentHolder,
                                responce: responce
                            } );
                        }, function( reason ) {
                            console.log( 'Script Loaded Error' );
                        });
                    }
                } );//end
            }
        },
        wooCard: function ($scope){
            if ( window.LaStudioKitEditor &&  window.LaStudioKitEditor.activeSection ) {
                let section = window.LaStudioKitEditor.activeSection,
                    isCart = -1 !== [ 'cart_list_style', 'cart_list_items_style', 'cart_buttons_style' ].indexOf( section );

                $( '.widget_shopping_cart_content' ).empty();
                $( document.body ).trigger( 'wc_fragment_refresh' );
            }

            var $target         =  $( '.lakit-cart', $scope ),
                $toggle         = $( '.lakit-cart__heading-link', $target ),
                settings        = $target.data( 'settings' ),
                firstMouseEvent = true;

            switch ( settings['triggerType' ] ) {
                case 'hover':
                    hoverType();
                    break;
                case 'click':
                    clickType();
                    break;
            }

            $target.on( 'click', '.lakit-cart__close-button', function( event ) {
                if ( ! $target.hasClass( 'lakit-cart-open-proccess' ) ) {
                    $target.toggleClass( 'lakit-cart-open' );
                }
            } );

            function hoverType() {

                if ( 'ontouchend' in window || 'ontouchstart' in window ) {
                    $target.on( 'touchstart', function( event ) {
                        scrollOffset = $( window ).scrollTop();
                    } );

                    $target.on( 'touchend', function( event ) {

                        if ( scrollOffset !== $( window ).scrollTop() ) {
                            return false;
                        }

                        var $this = $( this );

                        if ( $this.hasClass( 'lakit-cart-open-proccess' ) ) {
                            return;
                        }

                        setTimeout( function() {
                            $this.toggleClass( 'lakit-cart-open' );
                        }, 10 );
                    } );

                    $( document ).on( 'touchend', function( event ) {

                        if ( $( event.target ).closest( $target ).length ) {
                            return;
                        }

                        if ( $target.hasClass( 'lakit-cart-open-proccess' ) ) {
                            return;
                        }

                        if ( ! $target.hasClass( 'lakit-cart-open' ) ) {
                            return;
                        }

                        $target.removeClass( 'lakit-cart-open' );
                    } );
                } else {

                    $target.on( 'mouseenter mouseleave', function( event ) {

                        if ( firstMouseEvent && 'mouseleave' === event.type ) {
                            return;
                        }

                        if ( firstMouseEvent && 'mouseenter' === event.type ) {
                            firstMouseEvent = false;
                        }

                        if ( ! $( this ).hasClass( 'lakit-cart-open-proccess' ) ) {
                            $( this ).toggleClass( 'lakit-cart-open' );
                        }
                    } );
                }
            }

            function clickType() {
                $toggle.on( 'click', function( event ) {
                    event.preventDefault();

                    if ( ! $target.hasClass( 'lakit-cart-open-proccess' ) ) {
                        $target.toggleClass( 'lakit-cart-open' );
                    }
                } );
            }
        },
    }

    $( window ).on( 'elementor/frontend/init', function (){
        LaStudioKits.ajaxLoadPost();
        elementor.hooks.addAction( 'frontend/element_ready/lakit-advanced-carousel.default', function ( $scope ){
            LaStudioKits.initCarousel($scope);
        } );
        elementor.hooks.addAction( 'frontend/element_ready/lakit-posts.default', function ( $scope ){
            LaStudioKits.initCarousel($scope);
            LaStudioKits.initMasonry($scope);
        } );
        
        elementor.hooks.addAction( 'frontend/element_ready/lakit-search.default', function ( $scope ){
            LaStudioKits.onSearchSectionActivated($scope);
            $(document).on( 'click.lakitBlocks', function( event ) {

                var $widget       = $scope.find( '.lakit-search' ),
                    $popupToggle  = $( '.lakit-search__popup-trigger', $widget ),
                    $popupContent = $( '.lakit-search__popup-content', $widget ),
                    activeClass   = 'lakit-search-popup-active',
                    transitionOut = 'lakit-transition-out';

                if ( $( event.target ).closest( $popupToggle ).length || $( event.target ).closest( $popupContent ).length ) {
                    return;
                }

                if ( ! $widget.hasClass( activeClass ) ) {
                    return;
                }

                $widget.removeClass( activeClass );
                $widget.addClass( transitionOut );
                setTimeout( function() {
                    $widget.removeClass( transitionOut );
                }, 300 );

                event.stopPropagation();
            } );
        } );

        elementor.hooks.addAction( 'frontend/element_ready/lakit-hamburger-panel.default', function ( $scope ){
            LaStudioKits.hamburgerPanel( $scope );
        } );

        elementor.hooks.addAction( 'frontend/element_ready/lakit-cart.default', function ( $scope ){
            LaStudioKits.wooCard( $scope );
        } );

        $(document)
            .on('click.lakitOnWrapperLink', '[data-lakit-element-link]', function (e){
            var $wrapper = $(this),
                data     = $wrapper.data('lakit-element-link'),
                id       = $wrapper.data('id'),
                anchor   = document.createElement('a'),
                anchorReal;

            anchor.id            = 'lastudio-wrapper-link-' + id;
            anchor.href          = data.url;
            anchor.target        = data.is_external ? '_blank' : '_self';
            anchor.rel           = data.nofollow ? 'nofollow noreferer' : '';
            anchor.style.display = 'none';

            document.body.appendChild(anchor);

            anchorReal = document.getElementById(anchor.id);
            anchorReal.click();
            anchorReal.remove();
        })
            .on('click.lakitSearch', '.lakit-search__popup-trigger,.lakit-search__popup-close', function (event){
                var $this         = $( this ),
                    $widget       = $this.closest( '.lakit-search' ),
                    $input        = $( '.lakit-search__field', $widget ),
                    activeClass   = 'lakit-search-popup-active',
                    transitionIn  = 'lakit-transition-in',
                    transitionOut = 'lakit-transition-out';

                if ( ! $widget.hasClass( activeClass ) ) {
                    $widget.addClass( transitionIn );
                    setTimeout( function() {
                        $widget.removeClass( transitionIn );
                        $widget.addClass( activeClass );
                    }, 300 );
                    $input.focus();
                } else {
                    $widget.removeClass( activeClass );
                    $widget.addClass( transitionOut );
                    setTimeout( function() {
                        $widget.removeClass( transitionOut );
                    }, 300 );
                }
            })

    } );

    window.LaStudioKits = LaStudioKits;

}( jQuery, window.elementorFrontend ) );