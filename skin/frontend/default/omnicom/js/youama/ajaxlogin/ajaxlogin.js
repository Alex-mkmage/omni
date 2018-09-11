/**
 * YouAMA.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA that is bundled with this package
 * on http://youama.com/freemodule-license.txt.
 *
 *******************************************************************************
 *                          MAGENTO EDITION USAGE NOTICE
 *******************************************************************************
 * This package designed for Magento Community edition. Developer(s) of
 * YouAMA.com does not guarantee correct work of this extension on any other
 * Magento edition except Magento Community edition. YouAMA.com does not
 * provide extension support in case of incorrect edition usage.
 *******************************************************************************
 *                                  DISCLAIMER
 *******************************************************************************
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future.
 *******************************************************************************
 * @category   Youama
 * @package    Youama_Ajaxlogin
 * @copyright  Copyright (c) 2012-2014 YouAMA.com (http://www.youama.com)
 * @license    http://youama.com/freemodule-license.txt
 */

/**
 * This plugin is customized from Youama Ajax Login Extension by Icube
 * - Remove registration form
 */

function youamaAjaxLogin(options) {

    var defaults = {
        redirection : '0',
        windowSize : '',
        stop : false,
        controllerUrl : '',
        profileUrl : '',
        autoShowUp : '',
        errors : '',
        firstname : '',
        lastname : '',
        newsletter : 'no',
        email : '',
        password : '',
        passwordsecond : '',
        licence : 'no'
    };
    var opts = {};
    for (var attrname in defaults) { opts[attrname] = defaults[attrname]; }
    for (var attrname in options) { opts[attrname] = options[attrname]; }

        console.log(opts);

    return start();

    /**
     * Init.
     */
    function start() {
        sendEvents();

        customOpenCloseWindow();
    }

    /**
     * Scroll to top of page because of small screens.
     */
    function animateTop() {
        jQuery('html,body').animate({scrollTop : 0});
    }

    /**
     * Registration or login request by user.
     */
    function sendEvents() {

        // Press enter in login window
        jQuery(document).keypress(function(e) {
            if(e.which == 13
                && jQuery('.youama-login-window').css('display') == 'block') {
                setDatas('login');
                validateDatas('login');
                if (opts.errors != '') {
                    setError(opts.errors, 'login');
                }
                else{
                    callAjaxControllerLogin();
                }
            }
        });

        // Click on login in Login window
        jQuery('.youama-login-window .youama-ajaxlogin-button').on('click', function() {
            setDatas('login');
            validateDatas('login');
        console.log(opts);
            if (opts.errors != '') {
                setError(opts.errors, 'login');
            } else {
                callAjaxControllerLogin();
            }
            return false;
        });
    }

    /**
     * Display windows.
     * @param string windowName
     */
    function animateShowWindow(windowName) {
        jQuery('.youama-' + windowName + '-window')
            .slideDown(1000, 'easeInOutCirc');
    }

    /**
     * Show or hide the Loader with effects.
     * @param string windowName
     * @param int step
     */
    function animateLoader(windowName, step) {
        // Start
        if (step == 'start') {
            jQuery('.youama-ajaxlogin-loader').fadeIn();
            jQuery('.youama-' + windowName + '-window')
                .animate({opacity : '0.4'});
        // Stop
        } else {
            jQuery('.youama-ajaxlogin-loader').fadeOut('normal', function() {
                jQuery('.youama-' + windowName + '-window')
                    .animate({opacity : '1'});
            });
        }
    }

    /**
     * Close windows.
     * @param string windowName
     * @param bool quickly Close without animation.
     * @param bool closeParent Close the parent drop down
     */
    function animateCloseWindow(windowName, quickly, closeParent) {
        if (opts.stop != true){
            if (quickly == true) {
                jQuery('.youama-' + windowName + '-window').hide();
                jQuery('.youama-ajaxlogin-error').hide(function() {
                    if (closeParent) {
                        jQuery('#header-account').removeClass('skip-active');
                    }
                });
            } else {
                jQuery('.youama-ajaxlogin-error').fadeOut();
                jQuery('.youama-' + windowName + '-window').slideUp(function() {
                    if (closeParent) {
                        jQuery('#header-account').removeClass('skip-active');
                    }
                });
            }
        }
    }

    /**
     * Validate user inputs.
     * @param string windowName
     */
    function validateDatas(windowName) {
        opts.errors = '';

        // Register
        if (windowName == 'register') {
            // There is no last name
            if (opts.lastname.length < 1) {
                opts.errors = opts.errors + 'nolastname,'
            }

            // There is no first name
            if (opts.firstname.length < 1) {
                opts.errors = opts.errors + 'nofirstname,'
            }

            // There is no email address
            if (opts.email.length < 1) {
                opts.errors = opts.errors + 'noemail,'
            // It is not email address
            } else if (validateEmail(opts.email) != true) {
                opts.errors = opts.errors + 'wrongemail,'
            }

            // There is no password
            if (opts.password.length < 1) {
                opts.errors = opts.errors + 'nopassword,'
            // Too short password
            } else if (opts.password.length < 6) {
                opts.errors = opts.errors + 'shortpassword,'
            // Too long password
            } else if (opts.password.length > 16) {
                opts.errors = opts.errors + 'longpassword,'
            // Passwords doe not match
            } else if (opts.password != opts.passwordsecond) {
                opts.errors = opts.errors + 'notsamepasswords,'
            }

            // Terms and condition has not been accepted
            if (opts.licence != 'ok') {
                opts.errors = opts.errors + 'nolicence,'
            }
        // Login
        } else if (windowName == 'login') {
            console.log(opts.email);
            // There is no email address
            if (opts.email.length < 1) {
                opts.errors = opts.errors + 'noemail,'
            // It is not email address
            } else if (validateEmail(opts.email) != true) {
                opts.errors = opts.errors + 'wrongemail,'
            }

            // There is no password
            if (opts.password.length < 1) {
                opts.errors = opts.errors + 'nopassword,'
            // Too long password
            } else if (opts.password.length > 16) {
                opts.errors = opts.errors + 'wronglogin,'
            }
        }
    }

    /**
     * Email validator. Retrieve TRUE if it is an email address.
     * @param string emailAddress
     * @returns {boolean}
     */
    function validateEmail(emailAddress) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

        if (filter.test(emailAddress)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Save user input data to property for ajax call.
     * @param string windowName
     */
    function setDatas(windowName) {
        // Register window
        if (windowName == 'login') {
            opts.email = jQuery('.youama-' + windowName
                + '-window #youama-email').val();
            opts.password = jQuery('.youama-' + windowName
                + '-window #youama-password').val();
        }
    }

    /**
     * Load error messages into windows and show them.
     * @param string errors Comma separated.
     * @param string windowName
     */
    function setError(errors, windowName) {
        jQuery('.youama-' + windowName + '-window .youama-ajaxlogin-error')
            .text('');
        jQuery('.youama-' + windowName + '-window .youama-ajaxlogin-error')
            .hide();

        var errorArr = new Array();
        errorArr = errors.split(',');

        var length = errorArr.length - 1;

        for (var i = 0; i < length; i++) {
            var errorText = jQuery('.ytmpa-' + errorArr[i]).text();

            jQuery('.youama-' + windowName + '-window .err-' + errorArr[i])
                .text(errorText);
        }

        jQuery('.youama-' + windowName + '-window .youama-ajaxlogin-error')
            .fadeIn();
    }

    /**
     * Ajax call for login.
     */
    function callAjaxControllerLogin() {
        // If there is no another ajax calling
        if (opts.stop != true){

            opts.stop = true;

            // Load the Loader
            animateLoader('login', 'start');

            // Send data
            var ajaxRegistration = jQuery.ajax({
                url: opts.controllerUrl,
                type: 'POST',
                data: {
                ajax : 'login',
                    email : opts.email,
                    password : opts.password
                },
                dataType: "html"
            });
            // Get data
            ajaxRegistration.done(function(msg) {
                // If there is error
                if (msg != 'success'){
                    setError(msg, 'login');
                // If everything are OK
                } else {
                    opts.stop = false;
                    animateCloseWindow('login', false, true);
                    // Redirect
                    if (opts.redirection == '1') {
                        window.location = opts.profileUrl;
                    } else {
                        window.location.reload();
                    }
                }
                animateLoader('login', 'stop');
                opts.stop = false;
            });
            // Error on ajax call
            ajaxRegistration.fail(function(jqXHR, textStatus, errorThrown) {
                opts.stop = false;
                animateLoader('login', 'stop');
            });
        }
    }

    /**
     * Close windows if media CSS are changing by resize or menu is closing.
     */
    function autoClose() {
        closeInClose();

        // On resize event
        jQuery(window).resize(function() {
            closeInClose();
        });

        // On click another menu item event
        jQuery('.skip-links a').click(function() {
            closeInClose();
        });
    }

    /**
     * Close windows if menu is not open.
     */
    function closeInClose() {
        if (jQuery('.page-header-container #header-account')
            .hasClass('skip-active') != true) {
            animateCloseWindow('login', true, false);
            animateCloseWindow('register', true, false);
        }
    }

    /**
     * Icube Custom: opend / close popup
     */
    function customOpenCloseWindow() {
        jQuery('.popup-login-trigger').magnificPopup({
            removalDelay: 500, //delay removal by X to allow out-animation,
            items: {
                src: '#popup-login',
                type: 'inline'
            },
            callbacks: {
                beforeOpen: function(e) {
                    var Animation = 'mfp-fade';
                    this.st.mainClass = Animation;
                }
            },
        });
    }
}

