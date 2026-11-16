// It's good practice to place all code in a closure so it's not in the global namespace. This also allows you to
// map jQuery to $ variable and know it will not conflict with other libraries.
(function ($) {

    // Breakpoints
    var phone = 480,
        phablet = 768,
        tablet = 992,
        desktop = 1200,
        wide = 1500;

    // Common slideshow elements
    var prevArrowMarkup = '<button type="button" class="slick-prev"><span class="sr-text">Previous</span><i class="icon-arrow-left"></i></button>',
        nextArrowMarkup = '<button type="button" class="slick-next"><span class="sr-text">Next</span><i class="icon-arrow-right"></i></button>',
        prevArrowButtonMarkup = '<button type="button" class="btn btn-shadow slick-prev"><span class="sr-text">Previous</span><i class="icon-arrow-left"></i></button>',
        nextArrowButtonMarkup = '<button type="button" class="btn btn-shadow slick-next"><span class="sr-text">Next</span><i class="icon-arrow-right"></i></button>';

    // Focus switcher for New Veteran Student Intake Form
    $('.radio-switcher input:radio[value=studentid]').click(function(){
        $('.gform_wrapper .switch1 input').focus();
    });
    $('.radio-switcher input:radio[value=ssn]').click(function(){
        $('.gform_wrapper .switch2 input').focus();
    });


    //----------------------------------------------------------
    // MOBILE MENU
    //----------------------------------------------------------

    // OPEN MOBILE MENU
    function open_mobile_navigation() {
        $('.header-nav').addClass('header-nav-visible');
        $('body').addClass('mobile-menu-is-open');
    }

    // CLOSE MOBILE MENU
    function close_mobile_navigation() {
        $('body').removeClass('mobile-menu-is-open');
        $('.header-nav').removeClass('header-nav-visible');
    }

    // If the user resizes the browser and the mobile menu is open - then close the mobile menu
    $(window).resize(function () {
        if ($(document).width() >= desktop) {
            close_mobile_navigation();
        }
    });

    // MOBILE MENU ICON CLICK EVENT
    $(document).ready(function () {
        $('#open-mobile-menu').on('click', function (e) {
            open_mobile_navigation();
        });

        $('#close-mobile-menu').on('click', function (e) {
            close_mobile_navigation();
        });
    });


    //----------------------------------------------------------
    // MOBILE HEADER SLIDE IN/OUT - Hide and Show header on scroll down and up
    //----------------------------------------------------------
    var $didScroll;
    var $lastScrollTop = 0;
    var $navbarHeight = $('#header').outerHeight();

    $(window).scroll(function (event) {
        $didScroll = true;
    });

    setInterval(function () {
        if ($didScroll) {
            hasScrolled();
            $didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than 5px
        if (Math.abs($lastScrollTop - st) <= 5)
            return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > $lastScrollTop && st > $navbarHeight) { // Scroll Down
            $('#header').removeClass('nav-down').addClass('nav-up');
        } else { // Scroll Up
            if (st + $(window).height() < $(document).height()) {
                $('#header').removeClass('nav-up').addClass('nav-down');
            }
        }

        $lastScrollTop = st;
    }

    /**
     * Nav Search Toggle
     */
    var $searchFormNav = $('.search-form-nav');
    var $searchFormNavInput = $searchFormNav.find('input[type="text"]');
    var $searchToggle = $('.search-toggle');

    $searchToggle.on('click', function(e) {
        e.preventDefault();

        if ($(this).hasClass('clicked')) {
            $(this).removeClass('clicked');
        }
        else {
            $searchFormNavInput.focus();
            $(this).addClass('clicked');
        }
    });

    $searchFormNavInput.on({
        'focusin': function() {
            $searchFormNav.addClass('active');
            $searchToggle.addClass('clicked'); // Necessary for seamless functionality when search box is focused via tabbing
        },
        'focusout': function() {
            $searchFormNav.removeClass('active');
            /**
             * Need delay before removing class in order for multiple click functionality on search toggle to run its
             * click listener logic that pivots around the 'clicked' class. This allows the search box to hide/show
             * whether you are only toggling through the search toggle or by clicking anywhere else in the DOM.
             */
            setTimeout(function() {
                $searchToggle.removeClass('clicked');
            }, 300);
        }
    });

    /**
     * Smart link functionality
     */
    $('.smart-link').each(function() {
        var $smartMenuLink = $(this).children('a');
        var classList = $(this).attr('class').split(/\s+/);
        var menuName = '';

        $.each(classList, function(index, item) {
             if (item.indexOf('smart-link-') !== -1) { // Find class that starts with 'smart-link-', knowing what comes after the - = the menu name
                 menuName = item.replace('smart-link-', '');
             }
        });

        if (menuName.length) {
            $smartMenuLink.attr('data-smart-menu', menuName); // Setting as data-attribute to make things easier if more complex functionality is needed later

            $smartMenuLink.on('click', function(e) {
                e.preventDefault(); // Prevent default to set the cookie

                Cookies.set('smart_menu', $(this).data('smart-menu'), { // Pull menu name from data attribute and set as cookie
                    expires: 30 // 30 days from now
                });

                window.location.href = $smartMenuLink.attr('href'); // Continue on to link after setting cookie
            })
        }
    });

    // Show correct smart menu based on assigned cookie on load
    var curSmartMenu = Cookies.get('smart_menu');
    if (curSmartMenu) {
        $('[data-smart-nav="' + curSmartMenu + '"]').show();
    }

    /**
     * Main Menu/Primary Nav Accessibility
     */
    // Modified from https://sltaylor.co.uk/blog/keyboard-accessible-navigation/
    $(document).ready(function() {
        $('.primary-nav')
            .on('mouseenter focus', 'li > a, li > button', function(e) {
                var el = $(this);
                el.toggleClass('has-focus');
                // Show sub-menu
                el.attr('aria-expanded', 'true');
                el.siblings('.navbar-subnav').attr('aria-expanded', 'true');
            })
            .on('mouseleave blur', 'li > a, li > button', function(e) {
                var el = $(this);
                el.toggleClass('has-focus');
                // Only hide sub-menu after a short delay, so links get a chance to catch focus from tabbing
                setTimeout(function() {
                    if (el.siblings('.navbar-subnav').attr('data-has-focus') !== 'true') {
                        el.attr('aria-expanded', 'false');
                        el.siblings('.navbar-subnav').attr('aria-expanded', 'false');
                    }
                }, 100);
            }).on('mouseenter focusin', '.navbar-subnav', function(e) {
                var el = $(this);
                el.attr('data-has-focus', 'true');
            }).on('mouseleave focusout', '.navbar-subnav', function(e) {
                var el = $(this);
                setTimeout(function() {
                    // Check if anything else has picked up focus (i.e. next link in sub-menu)
                    if (el.find(':focus').length === 0) {
                        el.attr('data-has-focus', 'false');
                        // Hide sub-menu on the way out if parent link doesn't have focus now
                        if (el.siblings('a.has-focus, button.has-focus').length === 0) {
                            el.attr('aria-expanded', 'false');
                            el.siblings('a, button').attr('aria-expanded', 'false');
                        }
                    }
                }, 100);
            });
    });

    //Back to Top Button appear on page scrolling
    $(window).scroll(function() {
        var fixTop = $(window).height() * 1.75;
        var currentScroll = $(window).scrollTop();
        if (currentScroll >= fixTop) {
            $('.back-to-top').addClass('visible');
        } else {
            $('.back-to-top').removeClass('visible');
        }
    });

    //----------------------------------------------------------
    // TABS - For tabbed content
    //----------------------------------------------------------
    $(document).ready(function () {
        $('.tabbed-content').each(function (i, obj) {
            var panel = new Tabpanel($(this).attr('id'));
        });
    });

    /* Anchor Tag links to trigger tabbed clicks */
    $('.anchor-link').on('click', function(event) {
        var addressValue = $(this).attr("href");
        addressTab = addressValue.replace('#', '#tab-');
        $(addressTab).trigger('click');
    });



	
    // Add smooth scrolling tabbed links links
    $('.nav-tabs .tab > a').on('click', function(event) {
        $('html, body').animate({
            scrollTop: $(this).parents(".tabbed-content").offset().top - 60
        }, 300);
    });

    function Tabpanel(id) {
        this._id = id;
        this.$tpanel = $('#' + id);
        this.$tabs = this.$tpanel.find('.tab');
        this.$panels = this.$tpanel.find('.tab-pane');

        this.bindHandlers();
        this.init();

        /* Open tab if in hash */
        if(window.location.hash) {
            var hash = $.trim(window.location.hash.substring(1));
            if($('.tab > #tab-' + hash).length != 0) {
                this.switchTabs($('.tab.active'), $('#tab-' + hash).parent());
                $('html, body').animate({scrollTop: $('#tab-' + hash).offset().top - 90}, 0);
            }
        }
    }

    Tabpanel.prototype.keys = {
        left: 37,
        up: 38,
        right: 39,
        down: 40
    };

    Tabpanel.prototype.init = function () {
        var $tab;

        this.$panels.attr('aria-hidden', 'true');
        this.$panels.removeClass('active in');

        $tab = this.$tabs.filter('.active');

        if ($tab === undefined) {
            $tab = this.$tabs.first();
            $tab.addClass('active');
        }

        this.$tpanel
            .find('#' + $tab.find('a').attr('aria-controls'))
            .addClass('active in').attr('aria-hidden', 'false');
    };

    Tabpanel.prototype.switchTabs = function ($curTab, $newTab) {
        var $curTabLink = $curTab.find('a'),
            $newTabLink = $newTab.find('a');

        $curTab.removeClass('active');
        $curTabLink.attr('tabindex', '-1').attr('aria-selected', 'false');

        $newTab.addClass('active');
        $newTabLink.attr('aria-selected', 'true');

        this.$tpanel
            .find('#' + $curTabLink.attr('aria-controls'))
            .removeClass('active in').attr('aria-hidden', 'true');

        this.$tpanel
            .find('#' + $newTabLink.attr('aria-controls'))
            .addClass('active in').attr('aria-hidden', 'false');

        $newTabLink.attr('tabindex', '0');
        $newTabLink.focus();
    };

    Tabpanel.prototype.bindHandlers = function () {
        var self = this;

        this.$tabs.keydown(function (e) {
            return self.handleTabKeyDown($(this), e);
        });

        this.$tabs.click(function (e) {
            e.preventDefault();
            return self.handleTabClick($(this), e);
        });
    };

    Tabpanel.prototype.handleTabKeyDown = function ($tab, e) {
        var $newTab, tabIndex;

        switch (e.keyCode) {
            case this.keys.left:
            case this.keys.up: {

                tabIndex = this.$tabs.index($tab);

                if (tabIndex === 0) {
                    $newTab = this.$tabs.last();
                }
                else {
                    $newTab = this.$tabs.eq(tabIndex - 1);
                }

                this.switchTabs($tab, $newTab);

                e.preventDefault();
                return false;
            }
            case this.keys.right:
            case this.keys.down: {

                tabIndex = this.$tabs.index($tab);

                if (tabIndex === this.$tabs.length - 1) {
                    $newTab = this.$tabs.first();
                }
                else {
                    $newTab = this.$tabs.eq(tabIndex + 1);
                }

                this.switchTabs($tab, $newTab);

                e.preventDefault();
                return false;
            }
        }
    };

    Tabpanel.prototype.handleTabClick = function ($tab, e) {
        var $oldTab = this.$tpanel.find('.tab.active');
        this.switchTabs($oldTab, $tab);
    };

    /* Make chosen dropdown look right */
    $('.chosen-container').each(function(){
        $(this).parent('.ginput_container_select').addClass('chosen-after');
    });

    // Add smooth scrolling to anchor links
    $('a[href^="#"]').not('[href="#"]').not('[href="#0"]').not('.tab > a').not('.anchor-link').on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function(){
                window.location.hash = hash;
            });
        }
    });


    //----------------------------------------------------------
    // EQUAL HEIGHT - Adjust height of each component and make them equal
    //----------------------------------------------------------
    $.fn.setAllToMaxHeight = function () {
        return this.height(Math.max.apply(this, $.map(this, function (e) {
            return $(e).height();
        })));
    };

    $('.equalheight').setAllToMaxHeight();

    $(window).resize(function () {
        $('.equalheight').css('height', 'auto');
        $('.equalheight').setAllToMaxHeight();
    });


    /**
     * Panel - Success Story Feature - Slideshow
     */
    $successStoryFeature = $('.panel-success-story-feature');
    if ($successStoryFeature.length) {
        $successStoryFeature.find('.stories').each(function () {
            $slideshow = $(this);
            $thumbnails = $(this).closest('.panel').find('.thumbnail');
            $arrowsContainer = $(this).siblings('.pager-arrows');
            $dotsContainer = $(this).siblings('.pager-dots');

            $slideshow.on('init', function (event, slick) {
                // Tie in dots functionality with thumbnails
                $thumbnails.on('click', function() {
                    // Can't reuse $slideshow here for some reason
                    $(this).closest('.panel').find('.stories').slick('slickGoTo', parseInt($(this).data('slick-slide')));
                });

                // Hide pager dots/thumbnails if only one slice
                if (slick.slideCount === 1) {
                    $thumbnails.hide();
                }
            });

            $slideshow.slick({
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true,
                cssEase: 'linear',
                speed: 300,
                prevArrow: prevArrowMarkup,
                nextArrow: nextArrowMarkup,
                appendArrows: $arrowsContainer,
                appendDots: $dotsContainer
            });

            $slideshow.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                $thumbnails.removeClass('active');
                $thumbnails.eq(nextSlide).addClass('active');
            });
        });
    }

    /**
     * Panel - Tile Slider - Slideshow
     */
    $tileSlider = $('.tiles-slider');
    if ($tileSlider.length) {
        $tileSlider.each(function () {
            $slideshow = $(this);
            $arrowsContainer = $(this).siblings('.pager-arrows');

            $slideshow.slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                swipeToSlide: true,
                prevArrow: prevArrowButtonMarkup,
                nextArrow: nextArrowButtonMarkup,
                appendArrows: $arrowsContainer,
                mobileFirst: true,
                responsive: [
                    {
                        breakpoint: phone,
                        settings: {
                            centerMode: true,
                            centerPadding: '60px',
                        }
                    },
                    {
                        breakpoint: phablet,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: desktop,
                        settings: {
                            centerPadding: '120px',
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: wide,
                        settings: {
                            centerPadding: '200px',
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    }
                ]
            });
        });
    }

    /* Mix-blend-mode overlays for only those browsers that support it */
    if (window.getComputedStyle(document.body).mixBlendMode !== undefined) {
        $(".blend-mode").addClass("blend-on");
    }


    /**
     * Panel - Persona Filter
     */
    $personaFilter = $('#persona-filter');
    if ($personaFilter.length) {
        // Pull Persona data from REST endpoint
        $.ajax({
            url: '/wp-json/personas/v1/all'
        })
        .done(function(data) {
            applyPersonaFilter(data);
        });

        function applyPersonaFilter(data) {
            $identitySelect = $('#pf-identity');
            $topicSelect = $('#pf-topic');

            // Populate Identity dropdown
            $.each(data.identities, function(index, value) {
                $identitySelect.append('<option value="' + index + '" data-topic-page-routes=\'' + JSON.stringify(value.topic_page_routes) + '\'>' + value.label + '</option>');
            });

            // Populate Topics dropdown based on Identity selection
            $identitySelect.on('change', function() {
                routes = $(this).find('option:selected').data('topic-page-routes');

                // Ensure Topics element is enabled
                $topicSelect.removeAttr('disabled');

                // Clear all previous topics to repopulate with new selections
                $topicSelect.find('option').not('.placeholder').remove();

                // Add options/corresponding page route date attributes
                $.each(routes, function(index, value) {
                    topic = data.topics[index];
                    $topicSelect.append('<option value="' + index + '" data-page-route="' + value + '">' + topic.label + '</option>');
                });
            });

            // Remove disabled attribute from submit once topic is selected
            $topicSelect.on('change', function(index, value) {
                if (!$(this).find('option:selected').hasClass('placeholder')) {
                    $(this).closest('form').find('input[type="submit"]').removeAttr('disabled');
                }
            });

            // On submit, pull the selected topic page route, use AJAX to retrieve permalink, then redirect
            $personaFilter.on('submit', function(e) {
                e.preventDefault();

                route = $personaFilter.find('#pf-topic option:selected').data('page-route');
                params = {
                    'action': 'get_permalink',
                    'post_type': 'post',
                    'id': route
                };
                $.post('/wp-admin/admin-ajax.php', params, function(response) {
                    window.location.href = response;
                });
            });
        }
    }

})(jQuery);
